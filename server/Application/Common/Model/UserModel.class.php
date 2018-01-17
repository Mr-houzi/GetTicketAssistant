<?php

/**
 * Created by PhpStorm.
 * User: hasee-pc
 * Date: 2017/10/25
 * Time: 23:25
 */
namespace Common\Model;
use Think\Model;

class UserModel extends Model{
    private $_db = '';
    public function __construct(){
        $this->_db = M('user');
    }

    //查询openid是否存在
    public function checkOpenid($openid){
        $res = $this->_db->where('openid ="'.$openid.'"')->find();
        return $res;
    }

    //插入openid
    public function setOpenid($openid){
        $data['openid'] = $openid;
        $res = $this->_db->data($data)->add();
        return $res;
    }

    //根据openid插入number
    public function setNumber($openid,$number){
        $data['number'] = $number;
        $res = $this->_db->where('openid ="'.$openid.'"')->data($data)->save();
        return $res;
    }

    //根据number查询
    public function getUserInfoByNumber($number){
        $res = $this->_db->where('number="'.$number.'"')->find();
        return $res;
    }

}