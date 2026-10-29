<?php 


class Token{
public funtion generateToken($url,$appkey,$appSecret){

include_once('../ae-php-sdk/IopSdk.php');
$c = new IopClient($url,$appkey,$appSecret);
$request = new IopRequest('/auth/token/create');
$request->addApiParam('code','0_2DL4DV3jcU1UOT7WGI1A4rY91');
$request->addApiParam('uuid','uuid');
var_dump($c->execute($request));

}




}



                $appkey_= "538886";
                $appSecret_= "XuJ6zrrYe0pP55BYcuiz4bjWX3S5z2sw"; 
                $url_link_= "https://api-sg.aliexpress.com/rest"; 

                   
                include_once('../ae-php-sdk/IopSdk.php');
                $c = new IopClient( $url_link_,$appkey_,$appSecret_);
                $request = new IopRequest('/auth/token/create');
                $request->addApiParam('code','0_2DL4DV3jcU1UOT7WGI1A4rY91');
                $request->addApiParam('uuid','uuid');
                var_dump($c->execute($request));
                        /*        
                $token = new Token(); 
                $token->generateToken($url_link_,$appkey_,$appSecret_); 
                */





?>