<?php
/**
 * Created by PhpStorm.
 * User: hasee-pc
 * Date: 2017/10/31
 * Time: 15:48
 */

namespace Common\Model;
use Think\Model;

class SeatModel extends Model{
    private $_db = '';
    public function __construct(){
        $this->_db = M('seat');
    }

    //添加座位
    public function addLocation($location,$code){
        $data['location'] = $location;
        $data['code'] = $code;
        $res = $this->_db->data($data)->add();
        return $res;
    }

    //删除座位-根据code-加锁
    public function delLocation($code){
        $res = $this->_db->lock(true)->where('code="'.$code.'"')->delete();
        return $res;
    }

    //随机返回一座位
    public function randLocation(){
        $res = $this->_db->limit(1)->order('rand()')->find();
        return $res;
    }

    //返回数据表中第一条数据-加锁
    public function getSeatInfo(){
        $res = $this->_db->lock(true)->find();
        return $res;
    }

    //根据id查询信息
    public function getSeatInfoById($id){
        $res = $this->_db->where('id = "'.$id.'"')->find();
        return $res;
    }

}