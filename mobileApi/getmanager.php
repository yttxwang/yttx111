<?php

header('Content-Type: text/html; charset=utf-8'."\n"); 
$baseurl = 'http://online.rs.com/mobileApi/api.php';
//$baseurl = 'http://mapi.dhb.net.cn/api.php';
$baseurl = 'http://wy.dhb.net.cn/mobileApi/ty/api.php';
//$baseurl = 'http://wyy.dhb.hk/mobileApi/api.php';
echo $baseurl;
echo '<pre>';

//echo sha1('jsapi_ticket=sM4AOVdWfPE4DxkXGEs8VNQeSsWXRwj_BwX31YfEZFSX4ao93SinJfNlIQX2nI-IeSck3V9WEVOTVw-lIiCp-A&noncestr=Wm3WZYTPz0wzccnW&timestamp=1427424880749&url=http://192.168.1.104/weixin/demo1.html');
echo '<br />';
$pagestartime=microtime(); //获取程序开始执行的时间 

$param['Username']   = 'seekfor';
$param['Password']   = 'rsung';
$param['sKey']   = '8a2ffa2009e65719b3c6509adce61999';
//$param['wid']	 = '1';
echo $var = '?f=managerGetWay&v='.json_encode($param);

$url = $baseurl.$var;
$c = file_get_contents($url);

$data = json_decode($c,true);

print_r($data);
unset($param);
echo '<hr />';
exit('ok');



$param['mobile']   = '13981715406'; 
$param['loginFrom']  = 'Mobile';

$param['username']  = 'liu';
$param['confirmPassword']  = '123456';
$param['prefix']  = 'liu';
$param['trueName']  = '李先生';
$param['platformName']  = '订货宝在线订货系统';



//$param['wid']	 = '1';
echo $var = '?f=managerSubmitCompany&v='.json_encode($param);

$url = $baseurl.$var;
$c = file_get_contents($url);

$data = json_decode($c,true);

print_r($data);
unset($param);
echo '<hr />';
exit('ok');

$param['sKey'] = $data['sKey'];
/**
$param['clientId'] = 66852;

$param['action'] = 'edit';

//$param['clientId'] = 66853;

$param['ClientLevel'] = 'A_level_2';
$param['ClientArea'] = '1';
$param['ClientName'] = 'deng12343';
$param['ClientCompanyName'] = '成都市ddd巴4564156';
$param['ClientNO'] = '32323';
$param['ClientTrueName'] = '邓小姐';
$param['ClientEmail'] = 'deng@gmail.com';
$param['ClientPhone'] = '028-66445343';
$param['ClientFax'] = '028-66445343';
$param['ClientMobile'] = '';
$param['ClientAdd'] = 'ff4564565';
$param['ClientAbout'] = '重要客户';
$param['ClientFlag'] = 0;
$param['ClientPassword'] = '12345';
**/
/**
$param['orderId'] = 40143;
$param['action'] = 'audit';
echo $var = '?f=managerClientList&v='.json_encode($param);
echo '<hr />';
$url = $baseurl.$var;

echo $c2 = file_get_contents($url);
echo '<hr />';

$data = json_decode($c2,true);
print_r($data);
exit('over');
**/


//$param['sKey'] = '7d760d491914756d59dbf216e2309512';
//$param['debug'] = 1;
//订单

//$param['begin'] = 1;
//$param['step'] = 10;
/**
$param['payType'] = '1';
$param['sendType'] = '1';

$param['invoiceType'] = 'Z';
$param['accountName'] = '成都阿商';
$param['bankName'] = '招商银行';
$param['bankAccount'] = '14564564561561';
$param['invoiceHeader'] = '成都阿商信息技术有限公司';
$param['invocieContent'] = '明细';
$param['taxpayerNumber'] = '48941564195456';
$param['addressCompany'] = '收货公司';
$param['addressContact'] = '联系人';
$param['addressPhone'] = '4006311682';
$param['addressAddress'] = '四川成都';
$param['deliveryDate'] = '2015-04-20';
$param['orderRemark'] = '说明';
$param['orderFrom'] = 'WeiXin';
//$param['cartItems'][] = array('contentId' => 789,'color' => '黑', 'spec' => '','number' => 1);
//$param['cartItems'][] = array('contentId' => 789,'color' => '棕', 'spec' => '','number' => 2);
$param['cartItems'][] = array('contentId' => 784,'color' => '红', 'spec' => '小号','number' => 5);
$param['cartItems'][] = array('contentId' => 245,'color' => '', 'spec' => '','number' => 1);

$param['financeYufu'] = 'N';
$param['financeOrder'] = array('20150409-356','20150409-349','20150409-347');
$param['financeToDate'] = '2015-01-13';
$param['financeTotal'] = '100.235';
$param['financeAccounts'] = 3;
$param['financeAbout'] = '尽快确认';

$param['kuaidiNo'] = '1901008810278';
$param['kuaidiCode'] = 'yunda';
**/
//$param['addressId'] = '21';
//$param['sKey'] = '4bbcde5f48b1860db218e95ea29a3f0c';
//$param['sKey'] = 'e1991cfb8794be76bb5c1e43ed3a28b4';
echo $var = '?f=managerHome&v='.json_encode($param);
echo '<hr />';
$url = $baseurl.$var;

echo $c2 = file_get_contents($url);
echo '<hr />';

$data = json_decode($c2,true);
print_r($data);
exit('over');
/**

echo $var = '?f=getOrderList&v='.json_encode($param);
echo '<hr />';
$url = $baseurl.$var;

echo $c2 = file_get_contents($url);
echo '<hr />';

$data = json_decode($c2,true);
print_r($data);
**/

//商品
$param['orderBy'] = 1;
$param['commendId'] = 10;
echo $var = '?f=getGoodsList&v='.json_encode($param);
echo '<hr />';
$url = $baseurl.$var;

echo $c2 = file_get_contents($url);
echo '<hr />';

$data = json_decode($c2,true);
print_r($data);


//商品分类
$param['parentId'] = 91;
echo $var = '?f=getGoodsSort&v='.json_encode($param);
echo '<hr />';
$url = $baseurl.$var;

echo $c2 = file_get_contents($url);
echo '<hr />';
$data = json_decode($c2,true);
print_r($data);
echo '<hr />';

//商品明细
$param['contentId'] = 694;
echo $var = '?f=getGoodsContent&v='.json_encode($param);
echo '<hr />';
$url = $baseurl.$var;

echo $c2 = file_get_contents($url);
echo '<hr />';
$data = json_decode($c2,true);
print_r($data);


//订单明细
//$param['sKey'] = $data['sKey'];
$param['orderId'] = 66;
echo $var = '?f=getOrderContent&v='.json_encode($param);
echo '<hr />';
$url = $baseurl.$var;

echo $c2 = file_get_contents($url);
echo '<hr />';

$data = json_decode($c2,true);
print_r($data);

$pageendtime = microtime(); 
$starttime = explode(" ",$pagestartime); 
$endtime = explode(" ",$pageendtime); 
$totaltime = $endtime[0]-$starttime[0]+$endtime[1]-$starttime[1]; 
$timecost = sprintf("%s",$totaltime); 
echo "页面运行时间: $timecost 秒";
echo '</pre>';
exit('over');


function get_content($url){

	$ch = curl_init();  
	curl_setopt($ch, CURLOPT_URL,$url);  
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
?>