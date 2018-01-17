<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    //返回首页数据
    public function index(){
        $res =D('Yxwh')->countId();//参与人数

        //定义焦点图
        $data['focusimg'][0] = 'https://123456.xxx.com/Public/img/banner2.jpg';
        $data['focusimg'][1] = 'https://123456.xxx.com/Public/img/banner1.jpg';
        $data['focusimg'][2] = 'https://123456.xxx.com/Public/img/banner1.jpg';
        $data['people'] = $res;//参与人数
        $data['activity_status'] = 1;// 1 活动进行中 2 活动已结束
        $data['activity_title'] = "2018曲园同春迎新晚会";
        $data['activity_time'] = "2017年12月28日";

        echo json_encode($data);
    }
    //返回首页二级页面数据
    public function indexContent(){
        $data['img'] = "https://123456.xxx.com/Public/img/haibao.jpg";//设置活动图片
        $data['title'] = "2018曲园同春迎新晚会";
        $data['time'] = "2017年12月28日";
        $data['position'] = "逸夫学术交流中心";

        echo json_encode($data);
    }
}