

<?php

            class url_ali_all  {

            protected string $URL_LINK; 
            protected string $URL_LINK_REST_TOKEN; 
            protected string $APPKEY; 
            protected string $APPSECRET; 
            protected string $ACCESTOKEN; 
            protected string $CODE; 
            protected string $ID_URL; 
            protected string $HOST_DB; 
            protected string $HOST_USER; 
            protected string $HOST_PASS; 
            protected string $LINK_CODE; 
            protected string $CODE_URL; 
            protected string $CATEGORIES; 

            public function __construct(array $ArrayIoplient) {

            require_once('../url_controler/url_controler_update/wordpress_creat_insert.php');
            require_once("../private/private_db_root.php");
            include_once('../../ae-php-sdk/IopSdk.php');

            $this->HOST_DB=HOST_DB;
            $this->HOST_USER =HOST_USER;
            $this->HOST_PASS=HOST_PASS;
            $this->URL_LINK_REST_TOKEN = URL_LINK_REST_TOKEN;
            $this->URL_LINK =URL_LINK;
            $this->APPKEY= APPKEY;
            $this->APPSECRET= APPSECRET;
            $this->CODE= CODE;
            $this->ACCESTOKEN= ACCESS_TOKEN;
            $this->LINK_CODE= Link_site;
            $this->ID_URL = $ArrayIoplient['ID_URL'] ?? '';
            $this->CODE_URL = $ArrayIoplient['CODE'] ?? '';
            $this->CATEGORIES = $ArrayIoplient['categories'] ?? '';

            }

            public function ActiveCode(){
                //FUNCTION GENERATE AUTH ALIEXPRESS CODE
                  return json_encode(array("type"=>"ActiveCode","url_auth"=>"https://api-sg.aliexpress.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri=".$this->LINK_CODE."&client_id=".$this->APPKEY)); 
              }
       
            public function GenerateToken(){
           //FUNCTION GENERATE TOKEN ALIEXPRESS 
                $c = new IopClient($this->URL_LINK_REST_TOKEN,$this->APPKEY,$this->APPSECRET);
                $request = new IopRequest('/auth/token/create');
                $request->addApiParam('code',$this->CODE);
                // $request->addApiParam('uuid','uuid');
                $rs_token = json_decode($c->execute($request));
                $token=  $rs_token->{'access_token'}; 
                $filename= "../private/token.txt";
                file_put_contents($filename, $token);
                return json_encode(array("type"=>"GenerateToken", "Token" => $token ));

            }
            public function GenerateSecurityToken(){
           //FUNCTION GenerateSecurityToken AUTH ALIEXPRESS 
            $c = new IopClient($this->URL_LINK_REST_TOKEN,$this->APPKEY,$this->APPSECRET);
            $request = new IopRequest('/auth/token/security/create');
            $request->addApiParam('code',$this->CODE);
            //$request->addApiParam('uuid','uuid');
            return $c->execute($request);

            }
            public function RefreshSecurityToken(){
             //FUNCTION RefreshSecurityToken AUTH ALIEXPRESS 
            $c = new IopClient($this->URL_LINK_REST_TOKEN,$this->APPKEY,$this->APPSECRET);
            $request = new IopRequest('/auth/token/security/refresh');
            $request->addApiParam('code',$this->CODE);
           // $request->addApiParam('uuid','uuid');
            return $c->execute($request);

            }
            public function RefreshToken(){
            //FUNCTION RefreshToken AUTH ALIEXPRESS 
            $c = new IopClient($this->URL_LINK_REST_TOKEN,$this->APPKEY,$this->APPSECRET);
            $request = new IopRequest('/auth/token/security/create');
            $request->addApiParam('code',$this->CODE);
         //   $request->addApiParam('uuid','uuid');
            return $c->execute($request);

            }
            public function category($cat_id_ali){
                //FUNCTION category AUTH ALIEXPRESS 
            $c = new IopClient($this->URL_LINK,$this->APPKEY,$this->APPSECRET);
            $request = new IopRequest('aliexpress.ds.category.get');
            $request->addApiParam('categoryId',$cat_id_ali);
            $request->addApiParam('language','en');
            $request->addApiParam('consmarket',$this->ACCESTOKEN);


            $rs_cat =$c->execute($request); 
            $rs_cat_deco = json_decode($rs_cat);
            $rs_aliexpress_ds_category= $rs_cat_deco->{"aliexpress_ds_category_get_response"}; 
            $rs_en_res_result=json_encode($rs_aliexpress_ds_category); 
            $rs_de_res_result=json_decode($rs_en_res_result);
            $rs_result= $rs_de_res_result->{"resp_result"}; 
            $rs_en_result=json_encode($rs_result);
            $rs_de_result=json_decode($rs_en_result);
            $rs_categorie=$rs_de_result->{'result'}; 
            $rs_en_categories= json_encode($rs_categorie); 
            $rs_de_categories= json_decode($rs_en_categories); 
            $rs_category = $rs_de_categories->{'categories'};
            $rs_en_category= json_encode($rs_category); 
            $rs_de_category= json_decode($rs_en_category); 
            $rs_cat = $rs_de_category->{'category'};
            $rs_cat_encode = json_encode($rs_cat[0]);
            $rs_cat_decode= json_decode($rs_cat_encode);
            $parent_category_id =$rs_cat_decode->{'parent_category_id'};
            $category_name =$rs_cat_decode->{'category_name'};
            $category_id =$rs_cat_decode->{'category_id'};

            $rs_c_decode= json_encode($rs_c_encode);
            return json_encode(array("category_id"=>$category_id,"category_name"=>$category_name,"parent_category_id"=>$parent_category_id));
           
            }
            public function  AECategorys(){
            //FUNCTION AECategorys AUTH ALIEXPRESS 
             $rs_id_cat = json_decode($this->category($this->CATEGORIES)); //product categories
             $rs_id_cat_parent = json_decode($this->category($rs_id_cat->{'parent_category_id'})); // product parent 
             return json_encode(array("rs_id_cat"=>$rs_id_cat,"rs_id_cat_parent"=>$rs_id_cat_parent)); 
          
            }
            public function ProductGet(){
             //FUNCTION ProductGet AUTH ALIEXPRESS 
                $sql_ali = new __root_mysql(); 
                $db_n = new PDO($this->HOST_DB,$this->HOST_USER,$this->HOST_PASS);

                if(empty($this->ID_URL)):

                        return json_encode(array("result"=>"le champs est vide !!!")); 
              
                endif; 

                if(isset($this->ID_URL)):

                    $prepare = "SELECT * FROM wp_aliexpresspro_upload_test1 WHERE id_ali_product=:id_ali_product ";
                    $select_array =array(":id_ali_product"=>$this->ID_URL);
                    $rs_id_ali_product=$sql_ali->__select($prepare,$select_array,false,$db_n);   
                    $rs_cat_deo =json_decode($rs_id_ali_product['contenu_product']);
                    $rs_encode_cat = $rs_cat_deo->{'result'};
                    $rs_cat_encode = json_encode($rs_encode_cat); 
                    $rs_cat_de= json_decode($rs_cat_encode); 

                    $rs_info= $rs_cat_de->{'ae_item_base_info_dto'};
                    $rs_id_cat = json_encode($rs_info); 
                    $rs_id_cat_de = json_decode($rs_id_cat);
                    $rs_id = $rs_id_cat_de ->{'category_id'};
               

                    if($this->ID_URL==$rs_id_ali_product['id_ali_product']):

                    return json_encode(array("rs_product"=>json_decode($rs_id_ali_product['contenu_product']), "woo_id"=>$rs_id_ali_product['id_product_active'],
                    "id_product"=>$rs_id_ali_product['id_product'], "active"=>$rs_id_ali_product['active'], "cat"=> json_decode($rs_categories), "cats"=>json_decode($this->AECategorys($rs_id))));
                
                    endif;  

                endif;

                $c = new IopClient($this->URL_LINK,$this->APPKEY,$this->APPSECRET);
                $request = new IopRequest('aliexpress.ds.product.get');
                $request->addApiParam('ship_to_country','US');
                $request->addApiParam('product_id',$this->ID_URL);
                $request->addApiParam('target_currency','USD');
                $request->addApiParam('target_language','en');
                $request->addApiParam('remove_personal_benefit','false');
                $request->addApiParam('biz_model','biz_model');
                $request->addApiParam('province_code','provice');
                $request->addApiParam('city_code','city');
                $resultat = $c->execute($request,$this->ACCESTOKEN);
                $encode = json_encode($resultat); 
                $restulat_jsondecode= json_decode($resultat); 

                /*

                ----- session ali express callback -----
                */

                $restulat_jsondecode= json_decode($resultat); 
                //recuperation
                $rs_encode = json_encode($restulat_jsondecode->{"aliexpress_ds_product_get_response"}); 
                //$rs_de= json_decode($rs_encode); 
                //$rs_aliepress = $rs_encode;
                //RUPERATION ALL RESULT
                $rs_decode = json_decode($rs_encode); 
                // $rs_encode_result = json_encode($rs_decode->{'result'}); 
                // insertion dans la basse de donnees 
                if(isset($this->ID_URL)):
                                if($rs_encode!=null):
                                        $prepare = "INSERT INTO wp_aliexpresspro_upload_test1(id_ali_product , contenu_product ) VALUES (:id_ali_product,:contenu_product)";
                                        $array = array(':id_ali_product'=>$this->ID_URL,':contenu_product'=>$rs_encode); 
                                        $rs_insert_resultat =$sql_ali->__insert($prepare,$array,$db_n);
                                        return json_encode(array("rs_product"=>json_decode($rs_encode), "id_product"=>$rs_insert_resultat,"active"=>0)) ;
                                else:
                                        return json_encode(array("result"=>"aucun resultat")); 
                                endif;  
                else :
                        return json_encode(array("result"=>"aucun resultat disponible !!!")); 
                endif; 
            }
            public function GetProductShippingInfo($ali_product_id, $ali_sku_product){

            $c = new IopClient($this->URL_LINK,$this->APPKEY,$this->APPSECRET);
            $request = new IopRequest('aliexpress.affiliate.product.shipping.get');
            $request->addApiParam('product_id',$ali_product_id);
            $request->addApiParam('sku_id',$ali_sku_product);
            $request->addApiParam('ship_to_country','CN');
            $request->addApiParam('target_currency','USD');
          //$request->addApiParam('target_sale_price','100.03');
            $request->addApiParam('target_language','en');
            $request->addApiParam('tax_rate','0.1');
            $resultat = $c->execute($request,$this->ACCESTOKEN);
            $encode = json_encode($resultat); 
            return $encode; 
        }

public function buyercalculate_shippingfee(){
       
                // 1. Initialisation du client IOP d'AliExpress
                $c = new IopClient($this->URL_LINK,$this->APPKEY,$this->APPSECRET);

                // 2. Création de la requête dédiée au calcul de fret
                $request = new IopRequest('aliexpress.logistics.buyer.freight.calculate');

                // 3. Ajout des paramètres logistiques requis
                $request->addApiParam('product_id', $this->ID_URL); // Remplacer par l'identifiant réel de votre produit
                $request->addApiParam('product_num', '1');          // Quantité d'articles
                $request->addApiParam('country_code', 'US');        // Code ISO du pays de destination (Ex: US, FR, CA)

                // Paramètres optionnels recommandés selon vos critères :
                // $request->addApiParam('sku_id', '3213123XXX');   // ID de la variante (la taille/poids peut faire varier le prix)
                // $request->addApiParam('province_code', 'NY');     // État ou région si applicable
                // $request->addApiParam('city_code', 'New York');   // Ville de destination

                // 4. Exécution de la requête
                $response = $c->execute($request,$this->ACCESTOKEN);

                // 5. Affichage ou traitement du résultat
         
                return json_encode($response);

                
                  }
 }



?>