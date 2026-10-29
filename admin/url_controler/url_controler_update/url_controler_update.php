<?php 


use AliExpress\Sdk\IopClient; 

//https://www.aliexpress.us/item/3256812122645880.html?spm=a2g0o.order_list.order_list_main.10.69e01802dHT5zq&gatewayAdapt=glo2usa



$c = new IopClient(url,appkey,appSecret);
$request = new IopRequest('/auth/token/security/create');
$request->addApiParam('code','0_2DL4DV3jcU1UOT7WGI1A4rY91');
$request->addApiParam('uuid','uuid');
var_dump($c->execute($request));



$c = new IopClient(url,appkey,appSecret);
$request = new IopRequest('/auth/token/create');
$request->addApiParam('code','0_2DL4DV3jcU1UOT7WGI1A4rY91');
$request->addApiParam('uuid','uuid');
var_dump($c->execute($request));




$c = new IopClient(url,appkey,appSecret);
$request = new IopRequest('aliexpress.merchant.profile.get');
$request->addApiParam('channel_seller_id','12345');
var_dump($c->execute($request, $accessToken));


?>