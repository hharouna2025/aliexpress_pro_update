<?php 

extract($_POST);

            include_once('../../ae-php-sdk/IopSdk.php');    
            require_once('../url_controler/url_controler_update/wordpress_creat_insert.php');
            //global $wpdb;
            require_once("../private/private_db_root.php");
          //  $db = new PDO("mysql:host=localhost;dbname=c1vsstyle", "c1vsstyle","@05530080@");
            $root_sql = new __root_mysql(); 

            require '../url_controler/url_woocommerce_api/vendor/autoload.php';
            use Automattic\WooCommerce\Client;
              /*
              'ck_58c41c85977c9dad00f66afeacaad3617a4b8298', // Your consumer key
                'cs_b18fd32e0a41913900579104c34a85bef823708e', // Your consumer secret
                */
            $woocommerce = new Client(
                HOSTNAME_WOO, // Your store URL
                KEY_WOO, // Your consumer key
                SECRET_WOO, // Your consumer secret
                [
                    'wp_api' => true, // Enable the WP REST API integration
                    'version' => 'wc/v3' // WooCommerce WP REST API version
                ]
            );

                if(isset($url_link)):   

                $prepare = "SELECT * FROM wp_aliexpresspro_upload_test1 WHERE id_product=:id_product";
                $prepare_delete = "DELETE FROM wp_aliexpresspro_upload_test1 WHERE id_product=:id_product";
                $select_array =array(":id_product"=>$id_product);
                $rs_select=$root_sql->__select($prepare,$select_array,false,$db);  
                $rs_woo_delete =""; 
 
                if($rs_select['id_product_active']!=""):
                $rs_woo_delete=  $woocommerce->delete('products/'.$rs_select['id_product_active'], ['force' => true]); 
                endif; 
             
                $rs_delete=$root_sql->__delete($prepare_delete,$select_array,$db); 
                 

                echo json_encode(array("code"=>200, "rs_delete"=>"card".$id_product, "row"=>$rs_delete, "woo_delete"=> $rs_woo_delete ));

                exit;

                endif;  





?>