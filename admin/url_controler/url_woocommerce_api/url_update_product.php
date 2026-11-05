<?php
            extract($_POST);
            require_once('url_update_detail.php'); 
            $donne_array = array("woo_id"=>$id_product_woo,"product_id"=>$product,"up_shipping"=>1.30,"up_prix"=>1.75);
            $url_update_product = new url_update_detail($donne_array);
            // Install:
            // composer require automattic/woocommerce
            // Setup:
            require __DIR__ . '/vendor/autoload.php';
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

           
            $url_update_product->woocommerce=$woocommerce;  
            $url_update_product->all_donnees();
            $url_update_product->call_back_ali();
            $url_update_product->attributes_collor_size();
            $url_update_product->brands_other_attributes();
            $url_update_product->attributes_default();
            $url_update_product->meta_donnes();
            $url_update_product->add_single_product(); 
 

     if($type_update=="Productupdate"){
            if(isset($id_product_woo)&&isset($product)){
                $url_update_product->put_data();
                if(isset($url_update_product->list_variation)):
                      $url_update_product->variation_put_data();
                echo  json_encode(array('code'=>200));
                else:    
                      $url_update_product->variation_post_data();
                echo  json_encode(array('code'=>200));
                endif; 
           exit; 
           }
            }// fin partie update product
       
     //----- starts new product
            if($type_update=="ProductInsert"){
                if(isset($product)&&empty($id_product_woo)){

                    $rs_update=  $url_update_product->update_product();
                    $result_update = json_decode($rs_update);
                    if( $result_update->{'code'}==200){   

                    $rs_echo =  json_encode(array('code'=>200,'msg'=>'Product updated successfully','url_edit'=>'https://'.$_SERVER['SERVER_NAME'].'/wp-admin/post.php?post='.$url_update_product->woo_id.'&action=edit')); 

                    } elseif( $result_update->{'code'}==500){

                    $post_value=  $url_update_product->post_data() ;

                    if(isset( $url_update_product->woo_id)){

                    $url_update_product->variation_post_data();
                    $rs_echo = json_encode(array('code'=>200, 'url_edit'=>'https://'.$_SERVER['SERVER_NAME'].'/wp-admin/post.php?post='.$url_update_product->woo_id.'&action=edit'));
                    }else{
                    $rs_echo = json_encode(array('code'=>500, 'msg'=>'error')); 
                    }

                    } 

                echo $post_value;
                exit;
            } 
        }
        
?>