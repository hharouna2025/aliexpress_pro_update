<?php 

class ali_api{




public function refreshToken($url,$appkey,$appSecret){

$c = new IopClient(url,appkey,appSecret);
$request = new IopRequest('/auth/token/refresh');
$request->addApiParam('refresh_token','50001600212wcwiOabwyjtEH11acc19aBOvQr9ZYkYDlr987D8BB88LIB8bj');
//var_dump($c->execute($request));
$refreshToken = $c->execute($request) ;
return $refreshToken  ;
}

public function refreshSecurityToken($url,$appkey,$appSecret){


$c = new IopClient(url,appkey,appSecret);
$request = new IopRequest('/auth/token/security/create');
$request->addApiParam('code','0_2DL4DV3jcU1UOT7WGI1A4rY91');
$request->addApiParam('uuid','uuid');
//var_dump($c->execute($request));
$refreshSecurityToken = $c->execute($request) ;
return $refreshSecurityToken ; 
}


public function generateSecurityToken($url,$appkey,$appSecret){


$c = new IopClient(url,appkey,appSecret);
$request = new IopRequest('/auth/token/security/create');
$request->addApiParam('code','0_2DL4DV3jcU1UOT7WGI1A4rY91');
$request->addApiParam('uuid','uuid');
//var_dump($c->execute($request));
$generateSecurityToken = $c->execute($request);
return $generateSecurityToken; 
}


public function generate_token($url,$appkey,$appSecret){


$c = new IopClient($url,$appkey,$appSecret);
$request = new IopRequest('/auth/token/create');
$request->addApiParam('code','0_2DL4DV3jcU1UOT7WGI1A4rY91');
$request->addApiParam('uuid','uuid');
//var_dump($c->execute($request));
$generate_token = $c->execute($request)
return  $generate_token ;
}

public function Get_DropShip_Order_Tracking_info($url,$appkey,$appSecret,$id_order){


$c = new IopClient(url,appkey,appSecret);
$request = new IopRequest('aliexpress.ds.order.tracking.get');
$request->addApiParam('ae_order_id',$id_order);
$request->addApiParam('language','en_US');
var_dump($c->execute($request, $accessToken));
//var_dump($c->execute($request));
$Tracking_info= $c->execute($request)
return  $Tracking_info;
}

public function ali_ds_product_get($url,$appkey,$appSecret,$accessToken, $id_product,$_link_aephp_sdk){

    /*----------------------------------- */
        include_once($_link_aephp_sdk); //include link to folder ae-phpsdk file IopSdk.php
    /*----------------------------------- */
        $c = new IopClient($url,$appkey,$appSecret);
        $request = new IopRequest('aliexpress.ds.product.get');
        $request->addApiParam('ship_to_country','US');
        $request->addApiParam('product_id',$id_product);
        $request->addApiParam('target_currency','USD');
        $request->addApiParam('target_language','en');
        $request->addApiParam('remove_personal_benefit','false');
        $request->addApiParam('biz_model','biz_model');
        $request->addApiParam('province_code','provice');
        $request->addApiParam('city_code','city');
        //var_dump($c->execute($request, $accessToken));
        $rs_ali_ds_product_get= $c->execute($request, $accessToken); 

        return  $rs_ali_ds_product_get; 
}





}


/*


$dom = new DOMDocument('1.0', 'UTF-8');
$products = $dom->createElement('products');
$dom->appendChild($products);

foreach ($json->product as $item) {
    $product = $dom->createElement('product');
    foreach ($item as $key => $value) {
        $product->appendChild($dom->createElement($key, $value));
    }
    $products->appendChild($product);
}

$xml = $dom->saveXML();


*/




?>