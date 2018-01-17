<?php
/**
 * Created by PhpStorm.
 * User: hasee-pc
 * Date: 2017/10/13
 * Time: 1:02
 */

/**
 * 公共方法
 */

//消息提示方法(将后端定义的状态和消息传到前端$.post)
/**
 * @param $status
 * @param $message
 * @param array $data
 * @return json
 */
function show($status,$message,$data=array()){
    $result = array(
        'status' => $status,
        'message' => $message,
        'data' => $data,
    );
    exit(json_encode($result));//返回JSON编码
}

//座位随机生成
function location_random(){
    //座位生成
    //楼层随机生成
    $floor = array("一","二");
    $random_floor = array_rand($floor,1);
    //排数随机生成 一层共23排 二层共11排
    $row1 = array(          //一层排数
        '一','二','三',
        '四','五','六',
        '七','八','九',
        '十','十一','十二',
        '十三','十四','十五',
        '十六','十七','十八',
        '十九','二十','二十一',
        '二十二','二十三'
    );
    $row2 = array(          //二层排数
        '一','二','三',
        '四','五','六',
        '七','八','九',
        '十','十一'
    );
    if($random_floor[0]=='一'){
        $random_row = array_rand($row1,1);
        $row = $row1[$random_row];
    }else{
        $random_row = array_rand($row2,1);
        $row = $row2[$random_row];
    }
    //座号随机生成 偶数 奇数

    //拼接座位信息
    $location = $floor[$random_floor].'层'.$row.'排';
    return $location;
}

//微信中用于通信的方法
function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}

//生成第三方3rd_session
function setSession3rd(){
    $session3rd  = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol)-1;
    for($i=0;$i<16;$i++){
        $session3rd .=$strPol[rand(0,$max)];
    }
    return $session3rd;
}


//校验学生账号密码
/**
 * @param $user_id
 * @param $password
 * @return array
 *
 */
function checkStudentNum($user_id,$password){
    $arr = array(
        "user_id" => $user_id,
        "password" => $password
    );

    //json也可以
    $data_string =  json_encode($arr);

    //curl验证成功
    $ch = curl_init(url);//填写身份验证接口

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

    //解决出现 “SSL证书问题：无法获得本地颁发者证书”的问题
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//信任任何证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        // 'Content-Length: ' . strlen($data_string)
    ));

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        print curl_error($ch);
    }
    curl_close($ch);
    //将JSON转化成数组返回
    return json_decode($result,true);
}


//传入值生成二维码图（此处使用的阿里平台的二维码生成，若使用其他平台可直接替换函数内容）
/**
 * @param $qrcode
 * @return array
 *
 */
function createQrcode($qrcode){
    //二维码传值api需要urlencode编码转格式
    $qrcodeValue = urlencode("$qrcode");

    //二维码生成
    $host = "http://qrservice.market.alicloudapi.com";
    $path = "/createQrCode";
    $method = "GET";
    $appcode = "xxxxxx";//填写API的appcode
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    $querys = "content=".$qrcodeValue."&imgExtName=jpg&size=10";
    $bodys = "";
    $url = $host . $path . "?" . $querys;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    if (1 == strpos("$".$host, "https://"))
    {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    //var_dump(curl_exec($curl));
    //echo curl_exec($curl);


    $string = strstr(curl_exec($curl),'{',false);//截取纯净json数据
//            echo $string;
    $arr = json_decode($string,true);//将json数据转化成数组
    return $arr;//返回数组
}