<?php
/**
 * Created by PhpStorm.
 * User: hasee-pc
 * Date: 2017/10/16
 * Time: 23:53
 */

namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller{
    public function index(){
        header("content-type:text/html;charset=utf-8");
        $code = $_GET['code'];
        $appid = 'XXX';//填写小程序的appid--在自己申请的微信公众平台查看
        $secret = 'XXX';//填写小程序的secret--在自己申请的微信公众平台查看
        $api = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';

        //echo $api."<br/>";
        $str = httpGet($api);
        //echo $str;

        //转成数组，提取openid
        $arr = json_decode($str,true);
        $openid = $arr['openid'];
        //echo $openid;

        //检测数据库中是否存在openid，若不存在则插入
        $res = D('User')->checkOpenid($openid);
        if($res == NUll || $res == false){
            if($openid!=null){
                $res1 = D('User')->setOpenid($openid);
                if($res1!=false){
                    //return show(1,'openid插入成功');
                }
            }
        }else{
            //return show(0,'openid已存在');
        }

        $data['status'] = 'success';
        $data['openid'] = $openid;
        $data['session3rd'] = setSession3rd();

        //返回学号
        $res = D('User')->checkOpenid($openid);
        if($res['number'] == null){
            $data['number'] = '未绑定学号';
        }else{
            $data['number'] = $res['number'];
        }

        echo json_encode($data);

        session('LoginSessionKey',$data);//将openid存入session
    }
}