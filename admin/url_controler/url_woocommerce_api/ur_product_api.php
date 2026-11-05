<?php
                extract($_POST);

                require_once("../url_controler_update/wordpress_creat_insert.php");
                require_once("../../private/private_db_root.php");
                require_once("../../url_page/url_get_categories.php");

                $prepare = "SELECT * FROM wp_aliexpresspro_upload_test1 WHERE id_ali_product=:id_ali_product";
              

                $mys= new __root_mysql(); 
                $select_array = array(":id_ali_product"=>$product_id_ali);
                $rs_select= $mys->__select($prepare,$select_array,false,$db);
                $rs_decode = json_decode($rs_select['contenu_product'],true ); 

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


                $search_product = json_encode($woocommerce->get('products',['per_page'=>99,'sku'=>$product_id_ali]));
                $de_product = json_decode($search_product);

                if(isset($de_product[0]->{'id'})){
                $data_update = [
                ':active' => '1',
                ':id_product_active' =>$de_product[0]->{'id'},
                ':id_ali_product'=>$product_id_ali
                ];

                // 3. Préparation de la requête avec des marqueurs nommés (:)
                $sql_update="UPDATE wp_aliexpresspro_upload_test1 SET active=:active, id_product_active=:id_product_active  WHERE id_ali_product=:id_ali_product";
                $rs_update=$db->prepare($sql_update);

                // 4. Exécution en passant les données
                $rs_active = $rs_update->execute($data_update);

                if(isset($rs_active)){
                echo json_encode(array('code'=>200, 'url_edit'=>'https://'.$_SERVER['SERVER_NAME'].'/wp-admin/post.php?post='.$de_product[0]->{'id'}.'&action=edit')); 
                }else{
                echo json_encode(array('code'=>500, 'msg'=>'error')); 

                }
                exit; 
                }


                $exploid_image = explode(";", $rs_decode['result']['ae_multimedia_info_dto']['image_urls']);
                
                $count_image = count($exploid_image);

                //$array_image= [] ; recuperation des images

                for($b=0; $b<$count_image; $b++){

                $array_image[]= $exploid_image[$b];
                $parse_url[]= parse_url($exploid_image[$b]); 

                }

            
                //fin de recupration des images 


                $c_variation = count($rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o']);
                $variation= $rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'];
                $id_categorie_product   =  $rs_decode['result']['ae_item_base_info_dto']['category_id'];  //categories 
                $avg_evaluation_rating	= $rs_decode['result']['ae_item_base_info_dto']['avg_evaluation_rating']; //rating
                $name =$rs_decode['result']['ae_item_base_info_dto']['product_id'];       
                $desc=$rs_decode['result']['ae_item_base_info_dto']['detail'];
                $short=$rs_decode['result']['ae_item_base_info_dto']['subject'];
                //zone dimension
                $length=strval($rs_decode['result']['package_info_dto']['package_length']);
                $height=strval($rs_decode['result']['package_info_dto']['package_height']);
                $width=strval($rs_decode['result']['package_info_dto']['package_width']);
                $weight=strval($rs_decode['result']['package_info_dto']['gross_weight']);


                $dimensions=['length'=>$length,'width'=>$width,'height'=>$height];
               

                $ae_item_properties= $rs_decode['result']['ae_item_properties']['ae_item_property'];//liste des proprety

                $sku= $rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][0]['sku_id'];//
                $sku_price= strval($rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][0]['sku_price']);//
                $offer_bulk_sale_price=strval($rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][0]['offer_bulk_sale_price']);
                $sku_available_stock=$rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][0]['sku_available_stock'];
                $currency_code=$rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][0]['currency_code'];//USD
                //ZONE ATTRIBU 0
                $ae_sku_property_dtos=$rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][0]['ae_sku_property_dtos']['ae_sku_property_d_t_o'];

//------------------------------------------------------------------
                $rs_get_cat= $woocommerce->get('products/categories',['per_page'=>99]); 
                $rs_get_cat_p= $woocommerce->get('products/categories',['per_page'=>99]); 
                $count_woo_cat= count($rs_get_cat); 

                //call back categorie 
               $post_data ="token_type=AECategorys&cat_id=$id_categorie_product";

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
                // return categorie type
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

                
            //-------------------------------------
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

            $rs_f_cat_p = cat_p($in_count,$category_name_parent,$rs_get_cat_p);
            $encode= json_encode($rs_f_cat_p);
            $decode_= json_decode($encode);
 
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
            $rs_get_cat_p__= cat_p($count_rs_get_cat_p_,$category_name,$rs_get_cat_p_);

        if($rs_get_cat_p__==200):
                
            $encode__= json_encode($rs_get_cat_p__);
            $decode_ss= json_decode($encode__);
            $data = [
            'name' =>  $category_name ,
            'parent'=>  $decode_[0]->{'id'}
            ];

            
            $rs_post_sscategories=$woocommerce->post('products/categories', $data);// Post categories
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
        $categories_update[]=['id' =>  $decode_[0]->{'id'},'name'=>$decode_[0]->{'category_name'}];//categories_date
        $categories_update[]=['id' =>  $decode_ss[0]->{'id'},'name'=> $decode_ss[0]->{'category_name'}];//categories_date



//----------------------------------------------------------------
                //liste attribute de color et size
                $c_n_variation=count($rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o']); // le nombre de varaiation

                for($i=0;$i<$c_n_variation;$i++){

                    $n_option_color[]= ucfirst(strtolower($rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][$i]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][0]['sku_property_value']));//color
                    $n_option_image[]= $rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][$i]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][0]['sku_image'];//image
                    $n_option_size[]= ucfirst(strtolower($rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][$i]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][1]['sku_property_value'])) ;
                    $n_option_ShipsFrom[]= ucfirst(strtolower($rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][$i]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][2]['sku_property_value'])) ;
                }

                $uninque_color =  array_unique($n_option_color); // recuperation des colors
                $uninque_size =  array_unique($n_option_size); //recuperation des sizes 
               // $uninque_image= array_unique($n_option_image);// recuperation des images
                $uninque_ShipsFrom=  array_unique($n_option_ShipsFrom);//
                $uninque_image= array_values(array_unique($n_option_image));// recuperation des images

                $count_image_un = count($uninque_image);


                 for($e=0; $e<$count_image_un; $e++){
                    $array_image[]= $uninque_image[$e];
                     }

               
                $unique_image_q = array_values(array_unique($array_image)); 
                $coun_array_image = count($unique_image_q);

                    for($a=0; $a<$coun_array_image; $a++){
                            if(isset($unique_image_q[$a])){
                    $array_image_un[]= ['src'=> $unique_image_q[$a]] ;
                        }
                    }


        //--------------------------------

              $type_attribute_count = count($ae_sku_property_dtos);

              for($c=0;$c<$type_attribute_count;$c++){

                    if($ae_sku_property_dtos[$c]['sku_property_name']=='Color'|| $ae_sku_property_dtos[$c]['sku_property_name']=='Size'){

                        if($ae_sku_property_dtos[$c]['sku_property_name']=='Color'){
                        $option=$uninque_color;
                        }elseif($ae_sku_property_dtos[$c]['sku_property_name']=='Size'){
                        $option=$uninque_size;
                        }else{
                              $option=$uninque_color;
                        }

                     $attributes[]= [
                                'name'=> $ae_sku_property_dtos[$c]['sku_property_name'],
                                'position' => 0,
                                'visible' => true,
                                'variation' => true,
                                'options' => $option
                            ];

                    }else{

                         $attributes[]= [

                                'name'=>$ae_sku_property_dtos[$c]['sku_property_name'],
                                'position' => 0,
                                'visible' => true,
                                'variation' => false,
                                'options' => $uninque_ShipsFrom
                            ];
                    }

              }
  
        $coun_ae_item_properties= count($ae_item_properties);

        $brands = json_encode($woocommerce->get('products/brands',['search'=>$ae_item_properties[0]['attr_value']]));
        //$tags = json_encode($woocommerce->get('products/tags',['search'=>$ae_item_properties[0]['attr_value']]));
        $br_de = json_decode($brands);
       // $br_de_tags = json_decode($tags);
        // sart conditions brands 
        //  var_dump($empty )     ;         
    
         if(isset($br_de[0]->{'id'})):
                 

                    

                    $brandname[]= ['id' =>intval($br_de[0]->{'id'})]; 

                    for($c_br=0;$c_br<$coun_ae_item_properties;$c_br++){
                        // zone de selection des brands                        
                        // autres elements des attributes
                    if(ucfirst(strtolower($ae_item_properties[$c_br]['attr_name']))!="Size" || ucfirst(strtolower($ae_item_properties[$c_br]['attr_name']))!="Color" ):
                    $attributes[]= [
                    'name'=>$ae_item_properties[$c_br]['attr_name'],
                    'position' => 0,
                    'visible' => true,
                    'variation' => false,
                    'options' =>[$ae_item_properties[$c_br]['attr_value']]
                    ];
                    endif; 
                    };
            elseif(empty($br_de[0]->{'id'})):

                    $brand_data = [
                    'name'        => $ae_item_properties[0]['attr_value'],
                    'slug'        => $ae_item_properties[0]['attr_value'],
                    'image' => $array_image_un[0],
                    'description' => $short
                    ];
                    //  Create the brand
                    $brands_post = json_encode($woocommerce->post('products/brands', $brand_data));
                  //  $brands_tags= json_encode($woocommerce->post('products/tags', $brand_data));
                    $brands = json_encode($woocommerce->get('products/brands',['search'=>$ae_item_properties[0]['attr_value']]));
                   // $brands_tags = json_encode($woocommerce->get('products/tags',['search'=>$ae_item_properties[0]['attr_value']]));
                    $br_de = json_decode($brands);
                 //   $br_de_tags= json_decode($brands);
                    $brandname[]= ['id' =>intval($br_de[0]->{'id'})]; 
                 //   $brandname_tags[]= ['id' =>intval($br_de_tags[0]->{'id'})]; 

                                // star function for -----------------     
             for($c_br=0;$c_br<$coun_ae_item_properties;$c_br++){             
                            // autres elements des attributes
                if(ucfirst(strtolower($ae_item_properties[$c_br]['attr_name']))!="Size" || ucfirst(strtolower($ae_item_properties[$c_br]['attr_name']))!="Color" ):

                        $attributes[]= [
                        'name'=>$ae_item_properties[$c_br]['attr_name'],
                        'position' => 0,
                        'visible' => true,
                        'variation' => false,
                        'options' =>[$ae_item_properties[$c_br]['attr_value']]
                        ];
                endif; 
            };
                            // end function for 
     endif; // end function brands

                $unique_attr =  array_unique($attributes);         
                $sku_property_name=$ae_sku_property_dtos[0]['sku_property_name'];//name color
                $sku_property_value=$ae_sku_property_dtos[0]['sku_property_value']; //type color
                //ZONE ATTRIBU 1
                $sku_property_value_size=$ae_sku_property_dtos[1]['sku_property_value']; //type Sise exemple => S
                $sku_property_value_size_name=$ae_sku_property_dtos[1]['sku_property_name']; //name Size

                                $default_attributes[]=
                                [
                                'name'=>$sku_property_name,
                                'visible' => true,
                                'variation' => true,
                                'option' =>ucfirst(strtolower($sku_property_value))
                                ];
                                $default_attributes[]= [
                                'name' => $sku_property_value_size_name,
                                'visible' => true,
                                'variation' => true,
                                'option' => ucfirst(strtolower($sku_property_value_size))
                                ];               
                              
                                
             // meta_data data 
                                $meta_donne =[['key'=>'_sku', 'value'=>$product_id_ali],
                                ['key'=>'_regular_price','value'=> $sku_price],
                                ['key'=>"_sale_price", 'value'=>$offer_bulk_sale_price], 
                                ['key'=> '_weight', 'value'=>$weight], 
                                ['key'   =>'_dimensions',
                                'value'=> [
                                '_length'=>$length,
                                '_width'=>$width,
                                '_height'=>$height]
                                ], 
                                ['key'=>"_stock_status",'value'=>"instock"],
                                ['key'=>"_manage_stock",'value'=>true],
                                ['key'=>'_stock','value'=> $sku_available_stock],
                                ['key'=>'_downloadable','value'=>true],
                                ['key'=>'_virtual','value'=>false],
                                ['key'=>'_product_attributes','value'=>$attributes]]; 
                                 
                    // ensemble des donnees product
                            $data = [
                                'name' => $short,
                                'type' => 'variable',
                                'description' => $desc,
                                'short_description' => $short,
                                'sku'=>$product_id_ali,
                                'price'=>$sku_price,
                                'cost'=>$sku_price,
                                'regular_price'=>$sku_price,
                                'sale_price'=>$offer_bulk_sale_price,  
                                'parent_id'=>$parent_id, 
                                'categories'=>$categories ,
                                'manage_stock'=>true,
                                'stock_quantity'=>$sku_available_stock,
                                'tags'=>$brandname,
                                'brands'=>$brandname,
                                'weight'=>$weight,
                                'dimensions'=>$dimensions,
                                'images' =>  $array_image_un,
                                'attributes' => $attributes,
                                'default_attributes' =>   $default_attributes,
                                'meta_data'=> $meta_donne           
                            ];

                            $rs_inser_product =json_encode($woocommerce->post('products', $data)); // insertion des donnees .
                            $rs_decode_data = json_decode($rs_inser_product);
                            $id_product_insert =$rs_decode_data->{'id'}; // idenfiant du product complement pour la variable
                            $id_product_image =$rs_decode_data->{'images'}; // idenfiant du product complement pour la variable
                            $encode_product_image=json_encode($id_product_image);// il faut forcement re-encoder pour utiliser les donnees de la recuperation decode
                            $id_product_attributes =$rs_decode_data->{'attributes'}; // idenfiant du product complement pour la variable
                            $encode_product_attributes = json_encode($id_product_attributes[0]);//color attributes 
                            $encode_product_attributes_size = json_encode($id_product_attributes[1]);//attributes sizes

                            //recupration des ids des color
                                        
                            $en_deco = json_decode($encode_product_attributes);
                            $de_o= $en_deco->{"options"};//recuperation des valeurs
                            $en_o_= json_encode($de_o); 

                            $en_deco_s = json_decode($encode_product_attributes_size);
                            $de_o_s= $en_deco_s->{"options"};//recuperation des valeurs
                            $en_o__s= json_encode($de_o); 

                            $v_inser =  $rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'];
                            $c_n_variation=count($rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o']);

                            $val_variable = ''; 
                            $rs_data_json = '';

                // for de l'ensembles des variations
     for($v=0;$v<$c_n_variation; $v++){
        
                                $parse_url= parse_url($v_inser[$v]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][0]['sku_image']); 

                                $sku_= $v_inser[$v]['sku_id']; 
                                $sku_price_= $v_inser[$v]['sku_price']; 
                                $offer_bulk_sale_price_= $v_inser[$v]['offer_bulk_sale_price']; 
                                $stock_quantity_= $v_inser[$v]['sku_available_stock']; 
                

                                $color= ucfirst(strtolower($v_inser[$v]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][0]['sku_property_value'])); 
                                $typecolor= $v_inser[$v]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][0]['sku_property_name']; 
                                $typenamesize= $v_inser[$v]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][1]['sku_property_name']; 
                                $typesize= ucfirst(strtolower($v_inser[$v]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][1]['sku_property_value'])); 

                                //recuperation du code image

                                            $c_id_option=count($de_o);
                                            for($o=0;$o<$c_id_option;$o++){

                                            if( $color == $de_o[$o]){
                                            $d_color[]=
                                            [
                                            'name' =>  $sku_property_name,
                                            'option' =>   $de_o[$o]
                                            ];
                                            } 
                                            }

                                            $c_id_option_s=count($de_o_s);
                                            for($o=0;$o<$c_id_option_s;$o++){

                                            if( $typesize == $de_o_s[$o]){
                                            $d_color[]=
                                            [
                                            'name' => $sku_property_value_size_name,
                                            'option' =>   $de_o_s[$o]
                                            ];
                                            } 
                                            }

                  

                                $ex_url=  explode("/",$parse_url['path']);
                                $ex_p= explode(".",$ex_url[2]);
                                $ref_image= $ex_p[0]; // name image 
               
             
                // ensemble reference image et id image 

                $count_i=  count($id_product_image);

                $image=''; 
  
                        for($im=0;$im<$count_i;$im++){
                        $i_encode = json_encode($id_product_image[$im]);
                        $i_decode = json_decode($i_encode);
                        $name_ref=explode(".",$i_decode->{'name'});

                            if($ref_image==$name_ref[0]){
                            $id = strval($i_decode->{'id'}); 
                            $name = strval($i_decode->{'name'}); 
                            $file = strval($i_decode->{'src'}); 
                            $image.= $i_decode->{'id'}; 
                            $d_image= ['id' =>$i_decode->{'id'}];// id image select for categories
                            $d_download= [['id' => $id,'name' =>$name,'file' =>$file]];//detail image , src name file 
                            }
                        }; 

                                            $v_data =  [
                                            'description'=>$short, 
                                            'sku'=>  $sku_ ,
                                            'price'=>$sku_price_,
                                            'regular_price'=>$sku_price_,
                                            'sale_price'=>$offer_bulk_sale_price_, 
                                            'manage_stock'=>true,
                                            'stock_quantity'=>$stock_quantity_, 
                                            'downloadable'=>true,
                                            'downloads'=>$d_download,
                                            'weight'=>$weight,
                                            'dimensions'=>$dimensions,
                                            'image' =>   $d_image,  
                                            'attributes' => $d_color

                                            ];
                            $val_variable= json_encode($woocommerce->post('products/'.$id_product_insert.'/variations',  $v_data)); 

                unset($d_image);
                unset($d_color);
                unset($d_download);
                unset( $brandname);
              }

                // prepare insertion categories 
                $en_categories =json_encode($categories_update); 
                $data_update = [
                    ':active' => '1',
                    ':id_product_active' =>$id_product_insert,
                    ':id_ali_product'=>$product_id_ali,
                    ':categories'=> $en_categories
                ];

                // 3. Préparation de la requête avec des marqueurs nommés (:)
                $sql_update = "UPDATE wp_aliexpresspro_upload_test1 SET active=:active, id_product_active=:id_product_active , categories=:categories WHERE id_ali_product=:id_ali_product";
                $rs_update=  $db->prepare($sql_update);

// 4. Exécution en passant les données
                $rs_active = $rs_update->execute($data_update);

                if(isset($rs_active)){
                echo json_encode(array('code'=>200, 'url_edit'=>'https://'.$_SERVER['SERVER_NAME'].'/wp-admin/post.php?post='.$id_product_insert.'&action=edit')); 
                }else{
                echo json_encode(array('code'=>500, 'msg'=>'error')); 
                }

            exit;



?>