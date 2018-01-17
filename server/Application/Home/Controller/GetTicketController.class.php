<?php
/**
 * Created by PhpStorm.
 * User: hasee-pc
 * Date: 2017/12/18
 * Time: 0:42
 */
/**
 * 门票生成
 *
 */

namespace Home\Controller;
use Think\Controller;


class GetTicketController extends Controller{
    public function index(){
        $LoginSessionKey = session('LoginSessionKey');

        $wxLoginOpenid = $_POST['wxLoginOpenid'];
        $wxLoginSession3rd = $_POST['wxLoginSession3rd'];

        if($wxLoginOpenid == null){
            return show(0,'服务器端未接收到openid');
            exit;
        }

        //通过openid查询number
        $resUser = D('User')->checkOpenid($wxLoginOpenid);
        if($resUser['number']==null){
            return show(0,'请先绑定学号');
            exit;
        }
        $number = $resUser['number'];
        //通过number检查用户是否领过票
        $res = D('Yxwh')->findInfoByNumber($number);

        if($res == false || $res == null){

            //随机生成座位
            //$resLocation = D('Seat')->randLocation();

            //生成一个位置
            $resLocation =D('Seat')->getSeatInfo();
            $code = $resLocation['code'];//座位代码
            $qrcode = $code;//二维码号=学号+座位代码
            //将座位从seat表中删除
            $resDelLocation = D('Seat')->delLocation($code);
            if($resLocation == null){
                $message = '门票已被领完';
                $data['message'] = $message;
                echo json_encode($data);
                exit;
            }

            $createQrcode =createQrcode($qrcode);

            $qrcode_url =$createQrcode['showapi_res_body']['imgUrl'];

            //将位置信息加入数据库
            $res1 = D('Yxwh')->setInfo($number,$qrcode,$qrcode_url);
            if($res1 == false){
                $message = '领票失败';
            }else{
                $message = '领票成功';
            }


            $res2 = D('Yxwh')->findInfoByNumber($number);
            //将qrcode 10101解析成 一层1排1座
            $floor = substr($res2['qrcode'],0,1);
            $row = substr($res2['qrcode'],1,2);
            $num = substr($res2['qrcode'],3,2);
            $location = $floor."层".$row."排".$num."号";
            $res2['location']=$location;

            $res2['message'] = $message;
            $string = json_encode($res2);//把数组转化成json
            echo $string;//json格式的字符串
        }else{
            $res3 = D('Yxwh')->findInfoByNumber($number);
            //将qrcode 10101解析成 一层1排1座
            $floor = substr($res3['qrcode'],0,1);
            $row = substr($res3['qrcode'],1,2);
            $num = substr($res3['qrcode'],3,2);
            $location = $floor."层".$row."排".$num."号";
            $res3['location']=$location;

            $res3['message'] = '您已经领票';
            $string = json_encode($res3);
            echo $string;
        }
    }
}