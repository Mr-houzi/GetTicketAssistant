<?php
/**
 * Created by PhpStorm.
 * User: hasee-pc
 * Date: 2017/12/19
 * Time: 21:00
 */

/**
 * 帮朋友领票-领取双人门票
 *
 */

namespace Home\Controller;
use Think\Controller;

class GetDoubleTicketController extends Controller {
    public function index(){
        $LoginSessionKey = session('LoginSessionKey');

        $friend_num = $_POST['user_id'];//获取你朋友的id
        $friend_pwd = $_POST['password'];//获取你朋友的密码

        $wxLoginOpenid = $_POST['wxLoginOpenid'];//获取你的openid

        $wxLoginSession3rd = $_POST['wxLoginSession3rd'];

        if($wxLoginOpenid==null){
            $arr =array(
                'message'=>'服务器端未接收到openid',
                'status'=> 0
            );
            $json = json_encode($arr);
            echo $json;
            exit;
        }

        //检查朋友是否已绑定此学号
        $resCheckBindingNum = D('User')->getUserInfoByNumber($friend_num);
        if($resCheckBindingNum == null){
            return show(0,'朋友未绑定学号');
            exit;
        }

        //验证输入的朋友账号密码是否正确
        $resCheckStudent = checkStudentNum($friend_num,$friend_pwd);
//        var_dump($resCheckStudent);exit;
        if($resCheckStudent['status']==false){
            return show(0,'朋友的账号或密码不正确');
            exit;
        }

        //通过openid获得本人学号
        $resNum = D('User')->checkOpenid($wxLoginOpenid);
        if($resNum['number'] !=null){
            $my_num = $resNum['number'];
        }else{
            return show(0,'你未绑定学号');
            exit;
        }

        //检查本人是否领过票
        $resCheckMyTicket = D('Yxwh')->findInfoByNumber($my_num);
        if ($resCheckMyTicket != null){
            return show(0,'你已经领过票');
            exit;
        }

        //检查朋友是否领过票
        $resCheckFriendTicket = D('Yxwh')->findInfoByNumber($friend_num);
        if ($resCheckFriendTicket != null){
            return show(0,'你的朋友已经领过票');
            exit;
        }


        //生成P1的门票-自己的门票
        $P1_resLocation =D('Seat')->getSeatInfo();
        $P1_code = $P1_resLocation['code'];//座位代码
        $P1_qrcode = $P1_code;//二维码号=学号+座位代码
        //判断门票是否被领完
        if($P1_resLocation == null){
            $P1_message = '门票已被领完';
            $data['message'] = $P1_message;
            echo json_encode($data);
            exit;
        }
        //将座位从seat表中删除
        $P1_resDelLocation = D('Seat')->delLocation($P1_code);

        //调用公共函数createQrcode生成二维码图
        $P1_createQrcode = createQrcode($P1_qrcode);
        $P1_qrcode_url =$P1_createQrcode['showapi_res_body']['imgUrl'];

        //将个人信息和位置信息加入Yxwh表
        $P1_res = D('Yxwh')->setInfo($my_num,$P1_qrcode,$P1_qrcode_url);
        if($P1_res == false){
            $P1_Message = 'P1领票失败';
            $P1_Status = 0;
        }else{
            $P1_Message = 'P1领票成功';
            $P1_Status = 1;
        }


        //生成P2的门票-朋友的门票
        //保证连票-根据本人的座位id+2为连票
        $P2_SeatId = $P1_resLocation['id']+1;
        $P2_resLocation =D('Seat')->getSeatInfoById($P2_SeatId);
        $P2_code = $P2_resLocation['code'];//座位代码
        $P2_qrcode = $P2_code;//二维码号=学号+座位代码
        //判断门票是否被领完
        if($P2_resLocation == null){
            $P2_message = '门票已被领完';
            $data['message'] = $P2_message;
            echo json_encode($data);
            exit;
        }
        //将座位从seat表中删除
        $P2_resDelLocation = D('Seat')->delLocation($P2_code);

        //调用公共函数createQrcode生成二维码图
        $P2_createQrcode = createQrcode($P2_qrcode);
        $P2_qrcode_url =$P2_createQrcode['showapi_res_body']['imgUrl'];

        //将个人信息和位置信息加入Yxwh表
        $P2_res = D('Yxwh')->setInfo($friend_num,$P2_qrcode,$P2_qrcode_url);
        if($P2_res == false){
            $P2_Message = 'P2领票失败';
            $P2_Status = 0;
        }else{
            $P2_Message = 'P2领票成功';
            $P2_Status = 1;
        }

        if($P1_Status==1 && $P2_Status==1){
            $AllStatus = 1;//全部领票成功
        }else{
            $AllStatus = 0;//未领票成功
        }

        $arr = array(
            'P1' => array('status'=> $P1_Status,'message'=>$P1_Message),
            'P2' => array('status'=> $P2_Status,'message'=>$P2_Message),
            'AllStatus' => $AllStatus
        );
        echo json_encode($arr);

    }

    //检查本人是否已经领票
    public function checkMyTicket(){
        $wxLoginOpenid = $_POST['wxLoginOpenid'];//获取你的openid

        $wxLoginSession3rd = $_POST['wxLoginSession3rd'];

        if($wxLoginOpenid==null){
            $arr =array(
                'message'=>'服务器端未接收到openid',
                'status'=> 0
            );
            $json = json_encode($arr);
            echo $json;
            exit;
        }

        //通过openid获得本人学号
        $resNum = D('User')->checkOpenid($wxLoginOpenid);

        //检查是否本人绑定学号
        if($resNum['number'] == null || $resNum['number'] == false){
            return show(0,'你未绑定学号');
            exit;
        }else{
            $my_num = $resNum['number'];
        }

        //检查本人是否已领票
        $resCheckTicket = D('Yxwh')->findInfoByNumber($my_num);
        if($resCheckTicket != null){
            return show(0,'你已领票');
        }
    }
}