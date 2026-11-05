<?php

class url_update_detail{

public $woo_id;
public $product_id;
public $rs_product; 
public $woocommerce;
public $db_;
public $rs_decode; 
public $c_variation;
public $variation;
public $id_categorie_product ;  //categories 
public $avg_evaluation_rating	; //rating
public $name ;       
public $desc;
public $short;
//zone dimension
public $length;
public $height;
public $width;
public $weight;
public $dimensions;
public $ae_item_properties;//liste des proprety
public $sku;//
public $sku_price;//
public $offer_bulk_sale_price;
public $sku_available_stock;
public $currency_code;//USD
//ZONE ATTRIBU 0
public $ae_sku_property_dtos;
public $response_call_back;
public $attributes; 
public $brandname; 
public $parent_id;
public $array_image_un;
public $array_image;
public $categories; 
public $categories_update; 
public $meta_donne_;  
public $data_single_product; 
public $default_attributes;
public $rs_post_data;
public $rs_put_data; 
public $val_variable;
public $encode_product_attributes;
public $encode_product_attributes_size; 
public $v_data; 
public $id_product_image;
public $list_variation; 
public $sku_property_name;//name color
public $sku_property_value; //type color
public $id_product_insert ;
public $update_product_; 
//ZONE ATTRIBU 1
public $sku_property_value_size; //type Sise exemple => S
public $sku_property_value_size_name; //name Size
//ZONE IMAGE BRANDS AND CATEGORIES 
public $image_categories;
public $image_brands;
public $up_shipping; 
public $up_prix;



public function __construct(array $array){

                $this->woo_id = $array['woo_id'];
                $this->product_id= $array['product_id'];
                $this->up_shipping= $array['up_shipping'];
                $this->up_prix= $array['up_prix'];
                require_once("../url_controler_update/wordpress_creat_insert.php");
                require_once("../../private/private_db_root.php");
                require_once("../../url_page/url_get_categories.php");
                $this->db_=$db; 
                $prepare = "SELECT * FROM wp_aliexpresspro_upload_test1 WHERE id_ali_product=:id_ali_product";
              

                $mys= new __root_mysql(); 
                $select_array = array(":id_ali_product"=>$this->product_id);
                $this->rs_product= $mys->__select($prepare,$select_array,false,$this->db_);
                $this->rs_decode = json_decode($this->rs_product['contenu_product'],true ); 
}



public function update_product(){

                $search_product = json_encode($this->woocommerce->get('products',['sku'=>$this->product_id]));
                $de_product = json_decode($search_product);
    
                if(isset($de_product[0]->{'id'})){

                //$de_product = json_decode($search_product);

                $data_update = [
                ':active' => '1',
                ':id_product_active' =>$de_product[0]->{'id'},
                ':id_ali_product'=>$this->product_id
                ];
       
                // 3. Préparation de la requête avec des marqueurs nommés (:)
                $sql_update="UPDATE wp_aliexpresspro_upload_test1 SET active=:active, id_product_active=:id_product_active  WHERE id_ali_product=:id_ali_product";
                $rs_update=$this->db_->prepare($sql_update);
                $rs_active = $rs_update->execute($data_update);
                // 4. Exécution en passant les données
                $this->update_product_ =   $rs_active;
                $this->woo_id=$de_product[0]->{'id'};
                return  json_encode(array('code'=>200, 'msg'=>'insert')); 

                }else{
                        
                  return json_encode(array('code'=>500, 'msg'=>'error')); 
              
          }

}

public function all_donnees(){
                $this->c_variation = count($this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o']);
                $this->variation= $this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'];
                $this->id_categorie_product   =  $this->rs_decode['result']['ae_item_base_info_dto']['category_id'];  //categories 
                $this->avg_evaluation_rating	= $this->rs_decode['result']['ae_item_base_info_dto']['avg_evaluation_rating']; //rating
                $this->name =$this->rs_decode['result']['ae_item_base_info_dto']['product_id'];       
                $this->desc=$this->rs_decode['result']['ae_item_base_info_dto']['detail'];
                $this->short=$this->rs_decode['result']['ae_item_base_info_dto']['subject'];
                //zone dimension
                $this->length=strval($this->rs_decode['result']['package_info_dto']['package_length']);
                $this->height=strval($this->rs_decode['result']['package_info_dto']['package_height']);
                $this->width=strval($this->rs_decode['result']['package_info_dto']['package_width']);
                $this->weight=strval($this->rs_decode['result']['package_info_dto']['gross_weight']);


                $this->dimensions=['length'=>$this->length,'width'=>$this->width,'height'=>$this->height];
               

                $this->ae_item_properties= $this->rs_decode['result']['ae_item_properties']['ae_item_property'];//liste des proprety

                $this->sku= $this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][0]['sku_id'];//
                $this->sku_price= strval($this->prix_up_shipping($this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][0]['sku_price']));//
                $this->offer_bulk_sale_price=strval($this->prix_up_shipping($this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][0]['offer_bulk_sale_price']));
                $this->sku_available_stock=$this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][0]['sku_available_stock'];
                $this->currency_code=$this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][0]['currency_code'];//USD
                //ZONE ATTRIBU 0
                $this->ae_sku_property_dtos=$this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][0]['ae_sku_property_dtos']['ae_sku_property_d_t_o'];

//------------------------------------------------------------------
                $rs_get_cat= $this->woocommerce->get('products/categories',['per_page'=>99]); 
                $count_woo_cat= count($rs_get_cat); 
  
}
public    function cat_p($count,$name,$rs_get){
                       
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


public function call_back_ali(){
                //call back categorie 
               $post_data ="token_type=AECategorys&cat_id=$this->id_categorie_product";

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
                $this->response_call_back = curl_exec($ch);
                // return categorie type



//--------------------------
        $rs_cat_curl = json_decode($this->response_call_back ); 
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
         
            
          /////------ parent

           // $category_name_parent= preg_replace("/[^A-Za-z']/", " ", $category_name_parent);
            $rs_get_cat_p= $this->woocommerce->get('products/categories',['parent' => 0,'per_page'=>99]); 
            $in_count = count($rs_get_cat_p);

            $rs_f_cat_p = $this->cat_p($in_count,$category_name_parent,$rs_get_cat_p);
            $encode= json_encode($rs_f_cat_p);
            $decode_= json_decode($encode);
            
           
            if($rs_f_cat_p==200):

                    $data_ = [
                    'name' => $category_name_parent 
                    ];
            $rs_val_parent=$this->woocommerce->post('products/categories', $data_);
            $rs_get_cat_p= $this->woocommerce->get('products/categories',['parent' => 0,'per_page'=>99 ]); 
            $count_n_parent= count($rs_get_cat_p);
            $rs_f_cat_p= $this->cat_p($count_n_parent,$category_name_parent,$rs_get_cat_p);
          
        else:
           
            $encode= json_encode($rs_f_cat_p);
            $decode_= json_decode($encode);

            endif;    

            //------------- parent 
            //-----------------------------------------------------------------------------------------------
            //----- categories
           

            $rs_get_cat_p_= $this->woocommerce->get('products/categories', ['parent' => $decode_[0]->{'id'}, 'per_page'=>99  ] ); 
            $count_rs_get_cat_p_=count($rs_get_cat_p_);
            $rs_get_cat_p__= $this->cat_p($count_rs_get_cat_p_,$category_name,$rs_get_cat_p_);

        if($rs_get_cat_p__==200):
                
            $encode__= json_encode($rs_get_cat_p__);
            $decode_ss= json_decode($encode__);
            $data = [
            'name' =>  $category_name ,
            'parent'=> $decode_[0]->{'id'}
            ];

            
            $rs_post_sscategories=$this->woocommerce->post('products/categories', $data);// Post categories
            $rs_get_cat__= $this->woocommerce->get('products/categories',['parent' => $decode_[0]->{'id'}, 'per_page'=>99 ]); 
            $count_n = count($rs_get_cat__);
            $rs_f_cat__ = $this->cat_p($count_n,$category_name,$rs_get_cat__);
            $en_rs_f_cat__ = json_encode($rs_f_cat__);
            $de_rs_f_cat = json_decode($en_rs_f_cat__); 
            else:

            $encode__= json_encode($rs_get_cat_p__);
            $decode_ss= json_decode($encode__);
            endif;     

           
            
            //------- categories 

            $this->parent_id=intval($decode_[0]->{'id'});//categories parent
            $this->categories[]=['id' =>  $decode_[0]->{'id'}];//categories parent
            $this->categories[]=['id' =>   $decode_ss[0]->{'id'}];//categories $categories[]=['id' =>  $rs_f_cat_p[0]['id']];//categories parent
            $this->categories_update[]=['id' =>  $decode_[0]->{'id'},'name'=>$decode_[0]->{'category_name'}];//categories_date
            $this->categories_update[]=['id' =>  $decode_ss[0]->{'id'},'name'=> $decode_ss[0]->{'category_name'}];//categories_date

            return json_encode( $this->categories);
}

public function attributes_collor_size(){
                 //liste attribute de color et size
                $c_n_variation=count($this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o']); // le nombre de varaiation

                for($i=0;$i<$c_n_variation;$i++){

                    $n_option_color[]= ucfirst(strtolower($this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][$i]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][0]['sku_property_value']));//color
                    $n_option_image[]= $this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][$i]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][0]['sku_image'];//image
                    $n_option_size[]= ucfirst(strtolower($this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][$i]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][1]['sku_property_value'])) ;
                    $n_option_ShipsFrom[]= ucfirst(strtolower($this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'][$i]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][2]['sku_property_value'])) ;
                }

                $uninque_color =  array_unique($n_option_color); // recuperation des colors
                $uninque_size =  array_unique($n_option_size); //recuperation des sizes 
               // $uninque_image= array_unique($n_option_image);// recuperation des images
                $uninque_ShipsFrom=  array_unique($n_option_ShipsFrom);//
                $uninque_image= array_values(array_unique($n_option_image));// recuperation des images

                $count_image_un = count($uninque_image);


                 for($e=0; $e<$count_image_un; $e++){
                    $this->array_image[]= $uninque_image[$e];
                     }

               
                $unique_image_q = array_values(array_unique($this->array_image)); 
                $coun_array_image = count($unique_image_q);

                    for($a=0; $a<$coun_array_image; $a++){
                            if(isset($unique_image_q[$a])){
                    $this->array_image_un[]= ['src'=> $unique_image_q[$a]] ;
                        }
                    }


        //--------------------------------

              $type_attribute_count = count($this->ae_sku_property_dtos);

              for($c=0;$c<$type_attribute_count;$c++){

                    if($this->ae_sku_property_dtos[$c]['sku_property_name']=='Color'|| $this->ae_sku_property_dtos[$c]['sku_property_name']=='Size'){

                        if($this->ae_sku_property_dtos[$c]['sku_property_name']=='Color'){
                        $option=$uninque_color;
                        }elseif($this->ae_sku_property_dtos[$c]['sku_property_name']=='Size'){
                        $option=$uninque_size;
                        }else{
                              $option=$uninque_color;
                        }

                      $this->attributes[]= [
                                'name'=> $this->ae_sku_property_dtos[$c]['sku_property_name'],
                                'position' => 0,
                                'visible' => true,
                                'variation' => true,
                                'options' => $option
                            ];

                    }else{

                          $this->attributes[]= [

                                'name'=>$this->ae_sku_property_dtos[$c]['sku_property_name'],
                                'position' => 0,
                                'visible' => true,
                                'variation' => false,
                                'options' => $uninque_ShipsFrom
                            ];
                    }

              }
           
              return json_encode(  $this->attributes);
}

public function brands_other_attributes(){
    $coun_ae_item_properties= count($this->ae_item_properties);

        $brands = json_encode($this->woocommerce->get('products/brands',['search'=>$this->ae_item_properties[0]['attr_value']]));
        //$tags = json_encode($woocommerce->get('products/tags',['search'=>$ae_item_properties[0]['attr_value']]));
        $br_de = json_decode($brands);
       // $br_de_tags = json_decode($tags);
        // sart conditions brands 
        //  var_dump($empty )     ;         
    
         if(isset($br_de[0]->{'id'})):
                 
                    $this->brandname[]= ['id' =>intval($br_de[0]->{'id'})]; 

                    for($c_br=0;$c_br<$coun_ae_item_properties;$c_br++){
                        // zone de selection des brands                        
                        // autres elements des attributes
                    if(ucfirst(strtolower($this->ae_item_properties[$c_br]['attr_name']))!="Size" || ucfirst(strtolower($this->ae_item_properties[$c_br]['attr_name']))!="Color" ):
                    $this->attributes[]= [
                    'name'=>$this->ae_item_properties[$c_br]['attr_name'],
                    'position' => 0,
                    'visible' => true,
                    'variation' => false,
                    'options' =>[$this->ae_item_properties[$c_br]['attr_value']]
                    ];
                    endif; 
                    };
            elseif(empty($br_de[0]->{'id'})):

                    $brand_data = [
                    'name'        => $this->ae_item_properties[0]['attr_value'],
                    'slug'        => $this->ae_item_properties[0]['attr_value'],
                    'description' => $this->short
                    ];
                    //  Create the brand
                    $brands_post = json_encode($this->woocommerce->post('products/brands', $brand_data));
                  //  $brands_tags= json_encode($woocommerce->post('products/tags', $brand_data));
                    $brands = json_encode($this->woocommerce->get('products/brands',['search'=>$this->ae_item_properties[0]['attr_value']]));
                   // $brands_tags = json_encode($woocommerce->get('products/tags',['search'=>$ae_item_properties[0]['attr_value']]));
                    $br_de = json_decode($brands);
                 //   $br_de_tags= json_decode($brands);
                    $this->brandname[]= ['id' =>intval($br_de[0]->{'id'})]; 
                 //   $brandname_tags[]= ['id' =>intval($br_de_tags[0]->{'id'})]; 

                                // star function for -----------------     
             for($c_br=0;$c_br<$coun_ae_item_properties;$c_br++){             
                            // autres elements des attributes
                if(ucfirst(strtolower($this->ae_item_properties[$c_br]['attr_name']))!="Size" || ucfirst(strtolower($this->ae_item_properties[$c_br]['attr_name']))!="Color" ):

                         $this->attributes[]= [
                        'name'=>$this->ae_item_properties[$c_br]['attr_name'],
                        'position' => 0,
                        'visible' => true,
                        'variation' => false,
                        'options' =>[$this->ae_item_properties[$c_br]['attr_value']]
                        ];
                endif; 
            };
                            // end function for 
     endif; // end function brands
    
     return json_encode($this->attributes);
}
public function attributes_default(){
                $unique_attr =  array_unique($this->attributes);         
                $this->sku_property_name=$this->ae_sku_property_dtos[0]['sku_property_name'];//name color
                $this->sku_property_value=$this->ae_sku_property_dtos[0]['sku_property_value']; //type color
                //ZONE ATTRIBU 1
                $this->sku_property_value_size=$this->ae_sku_property_dtos[1]['sku_property_value']; //type Sise exemple => S
                $this->sku_property_value_size_name=$this->ae_sku_property_dtos[1]['sku_property_name']; //name Size

                                $this->default_attributes[]=
                                [
                                'name'=>$this->sku_property_name,
                                'visible' => true,
                                'variation' => true,
                                'option' =>ucfirst(strtolower($this->sku_property_value))
                                ];
                                $this->default_attributes[]= [
                                'name' => $this->sku_property_value_size_name,
                                'visible' => true,
                                'variation' => true,
                                'option' => ucfirst(strtolower($this->sku_property_value_size))
                                ];               

               return $this->default_attributes; 
}
public function meta_donnes(){

      $this->meta_donne_ =[['key'=>'_sku', 'value'=>$this->product_id],
                                ['key'=>'_regular_price','value'=> $this->sku_price],
                                ['key'=>"_sale_price", 'value'=>$this->offer_bulk_sale_price], 
                                ['key'=> '_weight', 'value'=>$this->weight], 
                                ['key'   =>'_dimensions',
                                'value'=> [
                                '_length'=>$this->length,
                                '_width'=>$this->width,
                                '_height'=>$this->height]
                                ], 
                                ['key'=>"_stock_status",'value'=>"instock"],
                                ['key'=>"_manage_stock",'value'=>true],
                                ['key'=>'_stock','value'=> $this->sku_available_stock],
                                ['key'=>'_downloadable','value'=>true],
                                ['key'=>'_virtual','value'=>false],
                                ['key'=>'_product_attributes','value'=>$this->attributes]]; 
                    return  $this->meta_donne_ ;
}

public function up_im_brands_cate(){

            $c_cat_id = count($this->categories); 
            for($c =0; $c <$c_cat_id; $c++){
                    $s= json_encode($this->array_image_un[$c]);
                    $s_d= json_decode($s);
                    $ca_s= json_encode($this->categories[$c]);
                    $ca_d= json_decode($ca_s);
                    $s_d= json_decode($s);
                if($c==0):
                    $this->image_brands= ["image"=>
                    ["src"=>$s_d->{"src"}]
                ]; 
                endif; 

                $this->image_categories= ["image"=>
                ["src"=>$s_d->{"src"}]
                ]; 
                $data_url=[
                    'description'=>$this->short,
                ]+  $this->image_categories;

                $rs[]=$this->woocommerce->put('products/categories/'.$ca_d->{'id'},  $data_url);
                }

                $s_brands= json_encode($this->brandname[0]);
                $d_brands= json_decode($s_brands);
                $rs_breat=$this->woocommerce->put('products/brands/'.$d_brands->{'id'}, $this->image_brands);

  return json_encode($this->brandname); 

}

public function prix_up_shipping($prix_up){

            $prix = $prix_up*$this->up_prix*$this->up_shipping;
            $new_prix = number_format( $prix,2,".", " ");          
            return $new_prix; 


}



public function add_single_product(){
                   // ensemble des donnees product
                            $this->data_single_product = [
                                'name' => $this->short,
                                'type' => 'variable',
                                'description' => $this->desc,
                                'short_description' => $this->short,
                                'sku'=>$this->product_id,
                                'price'=>$this->sku_price,
                                'cost'=>$this->sku_price,
                                'regular_price'=>$this->sku_price,
                                'sale_price'=>$this->offer_bulk_sale_price,  
                                'parent_id'=>$this->parent_id, 
                                'categories'=>$this->categories,
                                'manage_stock'=>true,
                                'stock_quantity'=>$this->sku_available_stock,
                                'tags'=>$this->brandname,
                                'brands'=>$this->brandname,
                                'weight'=>$this->weight,
                                'dimensions'=>$this->dimensions,
                                'attributes' => $this->attributes,
                                'default_attributes' =>   $this->default_attributes,
                                'meta_data'=> $this->meta_donne_           
                            ];

             return json_encode($this->data_single_product) ; 
}
  
public function post_data(){


            $this->data_single_product =  $this->data_single_product+array('images'=> $this->array_image_un); 
           $rs_result = json_encode($this->woocommerce->post('products/', $this->data_single_product)); // insertion des donnees .
          
            $this->rs_post_data= json_decode($rs_result);
            $this->id_product_image=$this->rs_post_data->{'images'};

            // $this->list_variation =$this->rs_post_data->{'variations'}; // variations
            $this->woo_id =$this->rs_post_data->{'id'}; // idenfiant du product complement pour la variable
            $id_product_attributes =$this->rs_post_data->{'attributes'}; // idenfiant du product complement pour la variable
           
            $this->encode_product_attributes = json_encode($id_product_attributes[0]);//color attributes 
            $this->encode_product_attributes_size = json_encode($id_product_attributes[1]);//attributes sizes
    return    json_encode($rs_result); 
}

public function put_data(){

                $get_product =$this->woocommerce->get('products',['sku'=>$this->product_id]);
                //  $rs_decode_product= json_decode($product);
                $rs_image_count= count($get_product[0]->{'images'});
                if($rs_image_count==0){
                $this->data_single_product =  $this->data_single_product+['images'=> $this->array_image_un]; 
                }

                $this->rs_put_data =json_encode($this->woocommerce->put('products/'.$this->woo_id, $this->data_single_product)); // insertion des donnees .
                $rs_decode_data = json_decode( $this->rs_put_data);
                $id_product_insert =$rs_decode_data->{'id'}; // idenfiant du product complement pour la variable
                if($rs_image_count==0){
                     $this->id_product_image =$rs_decode_data->{'images'}; // idenfiant du product complement pour la variable
                }else{
                     $this->id_product_image =$get_product[0]->{'images'};
                }
                $this->list_variation =$rs_decode_data->{'variations'}; // variations
                $encode_product_image=json_encode($this->id_product_image);// il faut forcement re-encoder pour utiliser les donnees de la recuperation decode
                $id_product_attributes =$rs_decode_data->{'attributes'}; // idenfiant du product complement pour la variable
                $this->encode_product_attributes = json_encode($id_product_attributes[0]);//color attributes 
                $this->encode_product_attributes_size = json_encode($id_product_attributes[1]);//attributes sizes
                return  $this->rs_put_data; 

}

public function variation_post_data(){
                                   
                            $en_deco = json_decode($this->encode_product_attributes);
                            $de_o= $en_deco->{"options"};//recuperation des valeurs
                            $en_o_= json_encode($de_o); 

                            $en_deco_s = json_decode($this->encode_product_attributes_size);
                            $de_o_s= $en_deco_s->{"options"};//recuperation des valeurs
                            $en_o__s= json_encode($de_o); 

                            $v_inser =  $this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'];
                          
                            $c_n_variation=count($this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o']);
                // for de l'ensembles des variations
             
                
                
                $val_variable = ''; 
                            $rs_data_json = '';
     for($v=0;$v<$c_n_variation; $v++){

                        $parse_url= parse_url($v_inser[$v]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][0]['sku_image']); 

                        $sku_= $v_inser[$v]['sku_id']; 
                        $sku_price_= $this->prix_up_shipping($v_inser[$v]['sku_price']); 
                        $offer_bulk_sale_price_= $this->prix_up_shipping($v_inser[$v]['offer_bulk_sale_price']); 
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
                                    'name' =>  $this->sku_property_name,
                                    'option' =>   $de_o[$o]
                                    ];
                                    } 
                                    }

                                    $c_id_option_s=count($de_o_s);
                                    for($o=0;$o<$c_id_option_s;$o++){

                                    if( $typesize == $de_o_s[$o]){
                                    $d_color[]=
                                    [
                                    'name' => $this->sku_property_value_size_name,
                                    'option' =>   $de_o_s[$o]
                                    ];
                                    } 
                                    }

            

                        $ex_url=  explode("/",$parse_url['path']);
                        $ex_p= explode(".",$ex_url[2]);
                        $ref_image= $ex_p[0]; // name image 
        
        
        // ensemble reference image et id image 

        $count_i=  count($this->id_product_image);

        $image=''; 

                for($im=0;$im<$count_i;$im++){
                $i_encode = json_encode($this->id_product_image[$im]);
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

                                    $this->v_data =  [
                                    'description'=>$this->short, 
                                    'sku'=>  $sku_ ,
                                    'price'=>$sku_price_,
                                    'regular_price'=>$sku_price_,
                                    'sale_price'=>$offer_bulk_sale_price_, 
                                    'manage_stock'=>true,
                                    'stock_quantity'=>$stock_quantity_, 
                                    'downloadable'=>true,
                                    'downloads'=>$d_download,
                                    'weight'=>$this->weight,
                                    'dimensions'=>$this->dimensions,
                                    'image' =>   $d_image,  
                                    'attributes' => $d_color

                                    ];
                    $this->val_variable[]= $this->woocommerce->post('products/'.$this->woo_id.'/variations',  $this->v_data); 

        unset($d_image);
        unset($d_color);
        unset($d_download);
        unset($this->brandname);
    }
    // prepare insertion categories 
                $en_categories =json_encode($this->categories_update); 
                $data_update = [
                    ':active' => '1',
                    ':id_product_active' =>$this->woo_id,
                    ':id_ali_product'=>$this->product_id,
                    ':categories'=> $en_categories
                ];

                // 3. Préparation de la requête avec des marqueurs nommés (:)
                $sql_update = "UPDATE wp_aliexpresspro_upload_test1 SET active=:active, id_product_active=:id_product_active , categories=:categories WHERE id_ali_product=:id_ali_product";
                $rs_update=  $this->db_->prepare($sql_update);

// 4. Exécution en passant les données
                $rs_active = $rs_update->execute($data_update);

                if(isset($rs_active)){
                echo json_encode(array('code'=>200, 'url_edit'=>'https://'.$_SERVER['SERVER_NAME'].'/wp-admin/post.php?post='.$this->woo_id.'&action=edit')); 
                }else{
                echo json_encode(array('code'=>500, 'msg'=>'error')); 
                }

            exit;
}

public function variation_put_data(){
                                        
                            $en_deco = json_decode($this->encode_product_attributes);
                            $de_o= $en_deco->{"options"};//recuperation des valeurs
                            $en_o_= json_encode($de_o); 

                            $en_deco_s = json_decode($this->encode_product_attributes_size);
                            $de_o_s= $en_deco_s->{"options"};//recuperation des valeurs
                            $en_o__s= json_encode($de_o); 

                            $v_inser =  $this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'];
                            $c_list_variation=count($this->list_variation);
                            if( $c_list_variation>0):
                            $c_n_variation=count($this->list_variation);
                            else:
                            $c_n_variation=count($this->rs_decode['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o']);
                            endif; 
                              
                            $val_variable = ''; 
                            $rs_data_json = '';

                // for de l'ensembles des variations
     for($v=0;$v<$c_n_variation; $v++){
        
                                $parse_url= parse_url($v_inser[$v]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][0]['sku_image']); 

                                $sku_= $v_inser[$v]['sku_id']; 
                                $sku_price_= $this->prix_up_shipping($v_inser[$v]['sku_price']); 
                                $offer_bulk_sale_price_= $this->prix_up_shipping($v_inser[$v]['offer_bulk_sale_price']); 
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
                                            'name' =>  $this->sku_property_name,
                                            'option' =>   $de_o[$o]
                                            ];
                                            } 
                                            }

                                            $c_id_option_s=count($de_o_s);
                                            for($o=0;$o<$c_id_option_s;$o++){

                                            if( $typesize == $de_o_s[$o]){
                                            $d_color[]=
                                            [
                                            'name' => $this->sku_property_value_size_name,
                                            'option' =>   $de_o_s[$o]
                                            ];
                                            } 
                                            }

                  

                                $ex_url=  explode("/",$parse_url['path']);
                                $ex_p= explode(".",$ex_url[2]);
                                $ref_image= $ex_p[0]; // name image 
               
             
                // ensemble reference image et id image 

                $count_i=  count($this->id_product_image);

                $image=''; 
  
                        for($im=0;$im<$count_i;$im++){
                        $i_encode = json_encode($this->id_product_image[$im]);
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

                                            $this->v_data =  [
                                            'description'=>$this->short, 
                                            'sku'=>  $sku_ ,
                                            'price'=>$sku_price_,
                                            'regular_price'=>$sku_price_,
                                            'sale_price'=>$offer_bulk_sale_price_, 
                                            'manage_stock'=>true,
                                            'stock_quantity'=>$stock_quantity_, 
                                            'downloadable'=>true,
                                            'downloads'=>$d_download,
                                            'weight'=>$this->weight,
                                            'dimensions'=>$this->dimensions,
                                            'image' =>   $d_image,  
                                            'attributes' => $d_color

                                            ];
            if( $c_list_variation>0):
            $this->val_variable[]= $this->woocommerce->put('products/'.$this->woo_id.'/variations/'.$this->list_variation[$v],  $this->v_data); 
            else:
            $this->val_variable[]= $this->woocommerce->post('products/'.$this->woo_id.'/variations', $this->v_data); 
            endif; 
                                        
                    

                unset($d_image);
                unset($d_color);
                unset($d_download);
                unset($this->brandname);
              }

              return  json_encode(array('result'=>$this->val_variable)); 
}










}// fin class

?>