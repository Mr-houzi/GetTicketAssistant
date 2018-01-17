<?php
/**
 * Created by PhpStorm.
 * User: hasee-pc
 * Date: 2017/10/30
 * Time: 19:12
 */

namespace Common\Model;
use Think\Model;

class YxwhModel extends Model{
    private $_db ='';
    public function __construct(){
        $this->_db = M('yxwh');
    }

    //根据 qrcode 修改ticketStatus值 （检票状态）
    public function updateTicketStatus($value,$qrcode){
        $data['ticket_status'] = $value;
        $res = $this->_db->where('qrcode="'.$qrcode.'"')->data($data)->save();
        return $res;
    }

    //通过number查找信息-加锁
    public function findInfoByNumber($number){
        $res = $this->_db->lock(true)->where('number="'.$number.'"')->find();
        return $res;
    }

    //将number 二维码 位置信息 插入
    public function setInfo($number,$qrcode,$qrcode_url){
        $data['number'] = $number;
        $data['qrcode'] = $qrcode;
        $data['qrcode_url'] = $qrcode_url;
        $res = $this->_db->data($data)->add();
        return $res;
    }

    // 二维码 位置信息 插入--测试并发用
    public function setInfo2($qrcode,$qrcode_url){
        $data['qrcode'] = $qrcode;
        $data['qrcode_url'] = $qrcode_url;
        $res = $this->_db->data($data)->add();
        return $res;
    }

    //通过number 获取信息
    public function getInfoByNumber($number){
        $res = $this->_db->where('number="'.$number.'"')->find();
        return $res;
    }

    //统计id个数
    public function countId(){
        $res = $this->_db->count('id');
        return $res;
    }

}