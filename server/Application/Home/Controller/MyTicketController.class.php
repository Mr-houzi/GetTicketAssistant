<?php
/**
 * Created by PhpStorm.
 * User: hasee-pc
 * Date: 2017/12/22
 * Time: 17:41
 */

/**
 * 我的-我的领票
 *
 */

namespace Home\Controller;
use Think\Controller;

class MyTicketController extends Controller{
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
        if($res == null){
            $arr['message'] = '未领票';
            echo json_encode($arr);
        }else{
            //将qrcode 10101解析成 一层1排1座
            $floor = substr($res['qrcode'],0,1);
            $row = substr($res['qrcode'],1,2);
            $num = substr($res['qrcode'],3,2);
            $location = $floor."层".$row."排".$num."号";
            $res['location']=$location;

            $res['message'] = '你的领票';
            $string = json_encode($res);//把数组转化成json
            echo $string;//json格式的字符串
        }

    }
}