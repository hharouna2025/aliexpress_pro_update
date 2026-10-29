<?php 
                extract($_POST);

           require_once("../url_controler_update/wordpress_creat_insert.php");
            require_once("../../private/private_db_root.php");
            require_once("../../url_page/url_get_categories.php");

                $mys= new __root_mysql(); 
                

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

              
              

               // $Arraycat= array('URL_LINK'=>URL_LINK,'APPKEY'=>APPKEY, 'APPSECRET'=>APPSECRET,'CODE'=>CODE,'ACCESS_TOKEN'=>ACCESS_TOKEN); 

              // $post_data ='token_type=AECategorys&cat_id='.$cat_product_id;
               $post_data ="token_type=AECategorys&cat_id=$category_id";



                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, URL_CALLBACK);
                // tell CURL to return the response instead of sending it to stdout
                curl_setopt( $ch, CURLOPT_POST, true );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // set the required header
                //curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                // set the POST data and corresponding method
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);



            // send the request and get the response
            $response = curl_exec($ch);
         
            /**/
            //--------------------------
            $rs_cat_curl = json_decode($response); 
            $rs_rs_id_cat = $rs_cat_curl->{'rs_id_cat'};
            $rs_en_rs_id_cat= json_encode($rs_rs_id_cat);
            $rs_de_rs_id_cat= json_decode($rs_en_rs_id_cat);
            $category_id = $rs_de_rs_id_cat->{'category_id'};
            $category_name = $rs_de_rs_id_cat->{'category_name'};
            $parent_category_id= $rs_de_rs_id_cat->{'parent_category_id'};
            //--------------------- $parent            
            $rs_rs_id_cat_parent= $rs_cat_curl->{'rs_id_cat_parent'};
            $rs_en_rs_id_parent= json_encode($rs_rs_id_cat_parent);
            $rs_de_rs_id_parent= json_decode($rs_en_rs_id_parent);
            $category_id_parent = $rs_de_rs_id_parent->{'category_id'};
            $category_name_parent=   $rs_de_rs_id_parent->{'category_name'};
            $parent_category_id_parent= $rs_de_rs_id_parent->{'parent_category_id'};      
            
            //-----------------------function cat --------------
            function cat_p($count,$name,$rs_get){
                    
               
            for($cat=0;$cat<$count;$cat++){
            if(htmlspecialchars_decode($rs_get[$cat]->{'name'})==$name):
            $_cat[]=['id'=>$rs_get[$cat]->{'id'},'category_name'=>htmlspecialchars_decode($rs_get[$cat]->{'name'})];
            endif; 
            }  

            if(empty($_cat)):
                $_cat =200;
            endif;  

            return $_cat; 

            }
            
          /////------ parent

           // $category_name_parent= preg_replace("/[^A-Za-z']/", " ", $category_name_parent);
            $rs_get_cat_p= $woocommerce->get('products/categories',['parent' => 0,'per_page'=>99]); 
            $in_count = count($rs_get_cat_p);

            $rs_f_cat_p = cat_p( $in_count,$category_name_parent,$rs_get_cat_p);
            $encode= json_encode($rs_f_cat_p);
            $decode_= json_decode($encode);
         
            // $decode_[0]->{'id'} ;
           
        

            if($rs_f_cat_p==200):

            $data_ = [
            'name' => $category_name_parent   
            ];

            $rs_val_parent=$woocommerce->post('products/categories', $data_);
            $rs_get_cat_p= $woocommerce->get('products/categories',['parent' => 0,'per_page'=>99 ]); 
            $count_n_parent= count($rs_get_cat_p);
            $rs_f_cat_p= cat_p($count_n_parent,$category_name_parent,$rs_get_cat_p);
            else:
            $encode= json_encode($rs_f_cat_p);
            $decode_= json_decode($encode);
            endif;    

            //------------- parent 
            //-----------------------------------------------------------------------------------------------
            //----- categories
           

            $rs_get_cat_p_= $woocommerce->get('products/categories', ['parent' => $decode_[0]->{'id'}, 'per_page'=>99  ] ); 
            $count_rs_get_cat_p_=count($rs_get_cat_p_);
            // $response = $woocommerce->put('products/categories/' . $category_id, $data);
            $rs_get_cat_p__= cat_p($count_rs_get_cat_p_,$category_name,$rs_get_cat_p_);

            
        
            if($rs_get_cat_p__==200):
                
            $encode__= json_encode($rs_get_cat_p__);
            $decode_ss= json_decode($encode__);
            $data = [
            'name' =>  $category_name ,
            'parent'=>  $decode_[0]->{'id'}
            ];

    
            //$response = $woocommerce->put('products/categories/' . $decode_[0]->{'id'} , $data);
            $rs_post_sscategories=$woocommerce->post('products/categories', $data);
  
            $rs_get_cat__= $woocommerce->get('products/categories',['parent' => $decode_[0]->{'id'}, 'per_page'=>99 ]); 


            $count_n = count($rs_get_cat__);
            $rs_f_cat__ = cat_p($count_n,$category_name,$rs_get_cat__);
            $en_rs_f_cat = json_encode($rs_f_cat__);
            $de_rs_f_cat = json_decode($en_rs_f_cat__); 

    
            else:

            $encode__= json_encode($rs_get_cat_p__);
            $decode_ss= json_decode($encode__);

            endif;     

            //------- categories 

 
  

        $parent_id=intval($decode_[0]->{'id'});//categories parent
        $categories[]=['id' =>  $decode_[0]->{'id'}];//categories parent
        $categories[]=['id' =>   $decode_ss[0]->{'id'}];//categories $categories[]=['id' =>  $rs_f_cat_p[0]['id']];//categories parent
        $categories_update[]=['id' =>  $decode_[0]->{'id'},'name'=>htmlspecialchars_decode($decode_[0]->{'category_name'})];//categories_date
        $categories_update[]=['id' =>  $decode_ss[0]->{'id'},'name'=> htmlspecialchars_decode($decode_ss[0]->{'category_name'})];//categories_date


  

        $data_update = [
        'parent_id'=>$parent_id,
        'categories'=>  $categories
        ];

        $update_cat=  $woocommerce->put('products/'.$id_product_active, $data_update);

        $en_categories =json_encode($categories_update); 

        $data_update_sql = [
        ':id_ali_product'=>$product,
        ':categories'=>$en_categories
        ];
  
     
           // 3. Préparation de la requête avec des marqueurs nommés (:)
                $sql_update = "UPDATE wp_aliexpresspro_upload_test1 SET  categories=:categories WHERE id_ali_product=:id_ali_product";
                $rs_update=  $db->prepare( $sql_update);

                // 4. Exécution en passant les données
                $rs_update_categories= $rs_update->execute($data_update_sql);

        function categories_product($woo_val_categories){
                $nav_cat= '<nav  class="mb-1 shadow-sm pt-1 text text-center  pb-0 fs-6 rounded bg-light "aria-label="breadcrumb"><ol class="breadcrumb  pb-0 m-1">' ;
                 
                $rs_update_en = json_encode($woo_val_categories); 
              //  var_dump( $rs_update_en); 
                $rs_update_de = json_decode($rs_update_en); 
                
                if(isset($rs_update_de)){
                
                $count_cat=count($rs_update_de );
                for($c=0;$c<$count_cat;$c++) {

                $nav_cat.= '<li class="breadcrumb-item fs-6 " aria-current="page">'.$rs_update_de[$c]->{'name'}.'</li>';     

                }
                }else{

                $nav_cat.='error';
                
                }

                $nav_cat.= ' </ol></nav>';

            return  $nav_cat;

            };


                if($rs_update_categories==true){
 
                //echo $rs_get_categories; 
                    $f_rs_update = categories_product($categories_update);
                echo json_encode(array('code'=>200, 'update_categories'=> $f_rs_update)); 
                }else{
                echo json_encode(array('code'=>500, 'update_categories'=>'error')); 

                }

                exit;



?>