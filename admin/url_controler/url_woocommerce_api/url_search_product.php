<?php
            extract($_POST);
           
     
            require_once("../url_controler_update/wordpress_creat_insert.php");
            require_once("../../private/private_db_root.php");
            $sku=preg_replace('/[^0-9]/', '', $sku);
            $donne_array = array("woo_id"=>trim($sku));
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

 function categories_product($woo_val_categories,$id_product_woo,$woo_product_active,$product_update, $active_update,$category_id){
                $nav_cat= '<nav  class="mb-1 shadow-sm pt-1 text text-center  pb-0 fs-6 rounded bg-light "aria-label="breadcrumb"><ol class="breadcrumb  pb-0 m-1">' ;
                
                if(isset($woo_val_categories)){
                
                $count_cat=count($woo_val_categories);
                for($c=0;$c<$count_cat;$c++) {

                $nav_cat.= '<li class="breadcrumb-item fs-6 " aria-current="page">'.$woo_val_categories[$c]->{'name'}.'</li>';     

                }
                }else{

                $nav_cat.='<li class="breadcrumb-item fs-6" aria-current="page"><button type="button" class="btn btn-success btn-sm control-form update_categories" id_product_active="'.$woo_product_active.'" id_product_woo="'.$id_product_woo.'" active="'.$active_update.'" product="'.$product_update.'" category_id="'.$category_id.'">update categories - ><i class="fa-solid fa-arrows-rotate"></i></button></li>';
                
                }

                $nav_cat.= ' </ol></nav>';

            return  $nav_cat;

            };


                $prepare = "SELECT * FROM wp_aliexpresspro_upload_test1 WHERE id_ali_product=:id_ali_product";
                $mys= new __root_mysql(); 
                $select_array = array(":id_ali_product"=>$donne_array['woo_id']);

                $rs_product= $mys->__select($prepare,$select_array,false,$db);
                $rs_decode = json_decode($rs_product['contenu_product'],true ); 
                $reseach = $woocommerce->get("products",['sku'=>$donne_array['woo_id']]);
            
 $page= ""; 
           

       
            $encode = json_encode( $rs_product['contenu_product']);
            $rs_decode = json_decode( $rs_product['contenu_product'],true ); 
            $en_rs = json_encode($rs_decode->{'result'}); 
            $dede = json_decode($de_rs,true); 
            $rs=json_encode($dede);
            $exploid_image = explode(";", $rs_decode['result']['ae_multimedia_info_dto']['image_urls']);
            $count_image = count($exploid_image);


            $page.=  '<div class="col card'.$rs_product['id_product'].'"><div class="card update'. $rs_product['id_product'].' h-100">
            <div id="carouselExampleDark'. $rs_product['id_product'].'" class="carousel carousel-dark slide">'; 
            $page.= '<div class="carousel-indicators">';
            for($n=0; $n<$count_image; $n++){
            if($n==0){
            $page.='<button type="button" data-bs-target="#carouselExampleDark'. $rs_product['id_product'].'" data-bs-slide-to="'.$n.'" class="active" aria-current="true" aria-label="Slide '.($n+1).'"></button>';
            }else{
            $page.='<button type="button" data-bs-target="#carouselExampleDark'. $rs_product['id_product'].'" data-bs-slide-to="'.$n.'" aria-label="Slide '.($n+1).'"></button>';
            }
             
    }
    $page.='</div>';
      
       
        
        $img=' <div class="carousel-inner">'; 
        for($i=0; $i<$count_image; $i++){
                if($i==0){
                $img.=  '  <div class="carousel-item active" data-bs-interval="2000">
                <img src="'.$exploid_image[$i].'" class="d-block w-100 rounded" alt="..." width="207"  height="207"></div>';
                }else{
                $img.=  '  <div class="carousel-item" data-bs-interval="2000">
                <img src="'.$exploid_image[$i].'" class="d-block w-100 rounded" alt="..." width="207"  height="207"></div>';
                }
        }
      
            $img.='</div>';
            $page.=$img;
            $page.='<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark'. $rs_product['id_product'].'" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark'. $rs_product['id_product'].'" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button> </div>';

            $page.= ' <div class="card-body">
            <h5 class="card-title"><h6>'.$rs_decode['result']['ae_item_base_info_dto']['subject'].'</h6></h5>
            </div>';
        //--- zone categories 
  
            if( $rs_product['active']==1){ 
            
            $va = json_decode(  $rs_product['categories']);
            $woo_categories = '<div class="update_categories'. $rs_product['id_product_active'].'">'.categories_product($va, $rs_product['id_product'], $rs_product['id_product_active'],$rs_decode['result']['ae_item_base_info_dto']['product_id'],$_fecthAll['active'],$rs_decode['result']['ae_item_base_info_dto']['category_id']).'</div>';
            $page.= $woo_categories;
            }
        //--- zone 

            $page.= '<div class="card-footer text-center bg-default rounded shadow-sm">
            <div class="btn-group text-center" role="group" aria-label="Basic mixed styles example">';
            if( $rs_product['active']!=1){

            $page.= '<button type="button" class="btn btn-primary btn-sm control-form active_product"  id_p="'. $rs_product['id_product'].'" id_product_woo="'. $rs_product['id_product_active'].'" active="'. $rs_product['active'].'"  product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-check"></i></button>';
            }

            if( $rs_product['active']==1){
            $page.='<button type="button" class="btn btn-success btn-sm control-form all_update_product" id_product_woo="'. $rs_product['id_product_active'].'" active="'. $rs_product['active'].'" id_p="'. $rs_product['id_product'].'" type_update="Productupdate" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-arrows-rotate"></i></button>';
            $page.='<button type="button" class="btn btn-default btn-sm control-form consult_product" id_product_woo="'. $rs_product['id_product_active'].'" active="'. $rs_product['active'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-regular fa-pen-to-square"></i></button>';
            }
            $page.='  <button type="button" class="btn btn-warning btn-sm control-form edit_product" id_product_woo="'. $rs_product['id_product_active'].'" active="'. $rs_product['active'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-bars"></i></button>
            <button type="button" class="btn btn-danger btn-sm control-form delete_product" id_product_woo="'. $rs_product['id_product_active'].'" active="'. $rs_product['active'].'" id_p="'. $rs_product['id_product'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-trash"></i></button>
            </div>  </div>
            </div>
            </div> ';

  

            $page.= ' </div></div>';
           
 echo json_encode(array("result"=>$page));

            exit; 
?>