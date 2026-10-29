<?php 



			define("HOST_DB","mysql:host=localhost;dbname=c1vsstyle");// mysql db 
			//USER ET MOT DE PASSE 
			define("HOST_USER","c1vsstyle");//user db
			define("HOST_PASS","@05530080@");//mdp db

			try{

			$db = new PDO(HOST_DB, HOST_USER, HOST_PASS);

			}
			catch(PDOException $e){
			die('Erreur :' .$e-> getMessage("Probléme de connexion !!! "));
			};


//MODIFICATION DES CODE GENERER WOOCOMMERCE 
// DIRECTION WOOCOMMERCE >SETTINGS> ADVANCED > REST API >ADD KEY 

			define("HOSTNAME_WOO",'http://vs-style.com');// 
			define("KEY_WOO",'ck_58c41c85977c9dad00f66afeacaad3617a4b8298');// Keywoocommerce code 
			define("SECRET_WOO",'cs_b18fd32e0a41913900579104c34a85bef823708e');// secret code woocommerce 
			  
			/*

			'http://vs-style.com', // Your store URL
			'ck_58c41c85977c9dad00f66afeacaad3617a4b8298', // Your consumer key
			'cs_b18fd32e0a41913900579104c34a85bef823708e', // Your consumer secret
			[
			'wp_api' => true, // Enable the WP REST API integration
			'version' => 'wc/v3' // WooCommerce WP REST API version
			]
			*/

    //information on ali account api DS CENTER https://ds.aliexpress.com/
		/*
		
		
		https://openservice.aliexpress.com
		   
		APP CONSOLE > COMMON > API EXPLORER >
		
		
		*/

		define('APPKEY',"538886");
		define('APPSECRET',"yLz78SfbSUb0KtKJ8Dv7cXO1FWXLzffI");
		define('URL_LINK',"https://api-sg.aliexpress.com/sync");
		define('URL_LINK_REST_TOKEN',"https://api-sg.aliexpress.com/rest");
		define('URL_CALLBACK',"https://".$_SERVER['SERVER_NAME']."/wp-content/plugins/consmarket-llc/admin/url_page/url_link_product.php");
		/*
		https://openservice.aliexpress.com/doc/doc.htm?spm=a2o9m.11193494.0.0.6d706095DutenB&nodeId=27493&docId=118729#/?docId=1590
		https://api-sg.aliexpress.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri=https://vs-style.com/wp-content/plugins/consmarket-llc/admin/url_page/url_link_product.php&client_id=538886
		pour obtenir un le code d'access
		*/
		$GetCODE_ali = file_get_contents('GetCODE.txt', true);// code authentfication
		$token= file_get_contents('token.txt', true);//code token 
		define('CODE',$GetCODE_ali);//code d'access 
		define('ACCESS_TOKEN',$token);//token access aliexpress.us
		define('Link_site',"https://".$_SERVER['SERVER_NAME']."/wp-content/plugins/consmarket-llc/admin/url_page/url_link_product.php");// Link callback





?>