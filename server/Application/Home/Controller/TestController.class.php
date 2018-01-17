<?php
/**
 * Created by PhpStorm.
 * User: hasee-pc
 * Date: 2017/12/25
 * Time: 11:55
 */

/**
 * 测试
 *
 */

namespace Home\Controller;
use Think\Controller;

class TestController extends Controller {
    public function index(){
        //单票
//        $resLocation =D('Seat')->getSeatInfo();
//        var_dump($resLocation);
//        $code = $resLocation['code'];//座位代码
//        $qrcode = $code;//二维码号=学号+座位代码
//        //将座位从seat表中删除
//        $resDelLocation = D('Seat')->delLocation($code);
//        echo "<br/>";
//        var_dump($resDelLocation);
//
//        $createQrcode =createQrcode($qrcode);
//
//        $qrcode_url =$createQrcode['showapi_res_body']['imgUrl'];
//
//        $res1 = D('Yxwh')->setInfo2($qrcode,$qrcode_url);



        //连票测试
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

//        //调用公共函数createQrcode生成二维码图
//        $P1_createQrcode = createQrcode($P1_qrcode);
//        $P1_qrcode_url =$P1_createQrcode['showapi_res_body']['imgUrl'];

        //将个人信息和位置信息加入Yxwh表
        $P1_res = D('Yxwh')->setInfo(1,$P1_qrcode,null);
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
        $P2_res = D('Yxwh')->setInfo(2,$P2_qrcode,null);
    }
}