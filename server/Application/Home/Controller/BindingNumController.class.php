<?php
/**
 * Created by PhpStorm.
 * User: hasee-pc
 * Date: 2017/12/19
 * Time: 11:18
 */

/**
 * 绑定学号
 *
 */

namespace Home\Controller;
use Think\Controller;

class BindingNumController extends Controller{
    public function index(){
        $user_id = $_POST['user_id'];
        $password = $_POST['password'];
        $LoginSessionKey = session('LoginSessionKey');

        $wxLoginOpenid = $_POST['wxLoginOpenid'];
        $wxLoginSession3rd = $_POST['wxLoginSession3rd'];

        $arr = array(
            "user_id" => $user_id,
            "password" => $password
        );

        //json也可以
        $data_string =  json_encode($arr);

        $result = checkStudentNum($user_id,$password);

        $arr = array();
        //判断是否登录成功，并绑定学号
        if($result['status']==true){
            //检测是否绑定过学号
            $resNum = D('User')->checkOpenid($wxLoginOpenid);
            if($resNum['number'] != null){
                //已经绑定过学号
                $arr = array(
                    'message' => '已经绑定过学号',
                    'status' => 1
                );
                $json = json_encode($arr);
                echo $json;
                exit;
            }

            //插入往表中查学号
            $res = D('User')->setNumber($wxLoginOpenid,$user_id);
            if($res===false){
                $arr['message'] = '绑定失败';
                $arr['status'] = 0;//1为成功，0为未成功
            }else{
                $arr['message'] = '绑定成功';
                $arr['status'] = 1;
            }
        }else{
            $arr['message'] = '账号或密码有误';
            $arr['status'] = 0;
        }

        $json = json_encode($arr);
        echo $json;
    }

    //检查是否已经绑定过学号
    public function checkBingNum(){
        $wxLoginOpenid = $_POST['wxLoginOpenid'];
        //检查是否获取到openid
        if($wxLoginOpenid==null){
            $arr =array(
                'message'=>'服务器端未接收到openid',
                'status'=> 0
            );
            $json = json_encode($arr);
            echo $json;
            exit;
        }
        //检查是否绑定学号
        $res = D('User')->checkOpenid($wxLoginOpenid);
        $arr = array();
        if($res['number'] != null){
            $arr['message'] = '学号已经绑定过';
            $arr['status'] = 1;//1表示已经绑定过，0表示未绑定过
            $arr['number'] = $res['number'];
        }else{
            $arr['message'] = '学号还未绑定';
            $arr['status'] = 0;//1表示已经绑定过，0表示未绑定过
        }
        $json = json_encode($arr);
        echo $json;
    }

}