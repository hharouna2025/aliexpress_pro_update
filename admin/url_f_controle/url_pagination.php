<?php 
        extract($_POST); 

            require_once("../url_controler/url_controler_update/wordpress_creat_insert.php");
            require_once("../private/private_db_root.php");
            require_once('../url_controler/url_woocommerce_api/vendor/autoload.php');
            use Automattic\WooCommerce\Client;
   
            $woocommerce = new Client(
            HOSTNAME_WOO, // Your store URL
            KEY_WOO, // Your consumer key
            SECRET_WOO, // Your consumer secret
            [
                'wp_api' => true, // Enable the WP REST API integration
                'version' => 'wc/v3' // WooCommerce WP REST API version
            ]
            );

            if(empty($v1)){
                $v1=0; 
            }
             function search_fun($rs_fetchall_select,$rs_fetchall_count,$active_,$p_){

            $list= count($rs_fetchall_count['fectAll']); 
            $list_page = count($rs_fetchall_select['fectAll']); 
            foreach($rs_fetchall_select['fectAll'] as $rs_fe => $_fecthAll){
            $encode = json_encode($_fecthAll['contenu_product']);
            $rs_decode = json_decode($_fecthAll['contenu_product'],true ); 
            $list_update[]= ["id"=>$_fecthAll['id_product'], "woo_id"=>$_fecthAll['id_product_active'], "product"=>$rs_decode['result']['ae_item_base_info_dto']['product_id']]; 
            }
            foreach($rs_fetchall_count['fectAll'] as $rs_fe => $_fecthAll){
            $encode = json_encode($_fecthAll['contenu_product']);
            $rs_decode = json_decode($_fecthAll['contenu_product'],true ); 
            $list_update_all[]= ["id"=>$_fecthAll['id_product'], "woo_id"=>$_fecthAll['id_product_active'], "product"=>$rs_decode['result']['ae_item_base_info_dto']['product_id']]; 
            }
        
       
        $page=' <div class="container-sm  p-3 rounded"><div class="input-group mb-3">';
        if($active_==1 || $active_==0){   
        $d= json_encode($list_update);
        $all_list_up= json_encode($list_update_all);
        $page.=  ' <button type="button" class="btn btn-outline-success update_all"><i class="fa-solid fa-arrows-rotate"></i></button>    
        <select class="form-select form-control update_option" aria-label="Default select example">';
        $page.= "<option selected value='".$d."'  >All Page (".$list_page.")</option>";
        $page.= "<option selected value='".$all_list_up."'  >All Page (".$list.")</option>";
        $page.= "</select>";      
         }
        $page.='</div>'; 
        $page.='<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
        </div>
        ';   
  
        return  $page; 
}
     function pagination($active_,$p_,$rs_select_account_,$rs_select_sql,$update){
             $list= count($rs_select_account_['fectAll']); 
            $list_page = count($rs_select_sql['fectAll']); 
            foreach($rs_select_sql['fectAll'] as $rs_fe => $_fecthAll){
            $encode = json_encode($_fecthAll['contenu_product']);
            $rs_decode = json_decode($_fecthAll['contenu_product'],true ); 
            $list_update[]= ["id"=>$_fecthAll['id_product'], "woo_id"=>$_fecthAll['id_product_active'], "product"=>$rs_decode['result']['ae_item_base_info_dto']['product_id']]; 
            }
            foreach($rs_select_account_['fectAll'] as $rs_fe => $_fecthAll){
            $encode = json_encode($_fecthAll['contenu_product']);
            $rs_decode = json_decode($_fecthAll['contenu_product'],true ); 
            $list_update_all[]= ["id"=>$_fecthAll['id_product'], "woo_id"=>$_fecthAll['id_product_active'], "product"=>$rs_decode['result']['ae_item_base_info_dto']['product_id']]; 
            }
                        $pagination = '';
                        $pagination .= '<div class="btn-group m-2 p-2" role="group" aria-label="">';
                            foreach($rs_select_account_['fectAll'] as $rs_fe => $_fecthAll){
                        $all_id[]=['id'=>$_fecthAll['id_product'], 'active'=>$_fecthAll['active']]; 
                        }
                        foreach($rs_select_sql['fectAll'] as $rs_fe => $_fecthAll){

                        $all_id_af[]=['id'=>$_fecthAll['id_product'], 'active'=>$_fecthAll['active']]; 
                
                        }

                        $first_line = array_first($all_id_af);
                        $last_line = end($all_id_af); //last end of the array 
                                
                        $count_id=count($all_id); 
                        $n_page=$count_id/24; 
                        
                        for($i=0; $i<$n_page;$i++){
                            for($al=0; $al<$count_id; $al++){
                                if(($i*24)==$all_id[$al]['id']){
                                    
                                    $n_al_1= $al+1; 
                                    $v_n1= $all_id[$n_al_1]['id'];
                                    $un_all[]=['v1'=>$v_n1,'p'=>$p_, 'active'=>$all_id[$al]['active'],'id_product'=>$all_id[$al]['id']]; 
                                    }
                            }
                            
                        }
                        $c_un = count($all_id)/24; 
                    
                        if($p_==0):
                        $d= "disabled";
                        endif;
                        if($p_!=0):
                        $pn=1;
                        $pagination .='<button type="button" class="btn btn-secondary  n_pagination '.$d.'" v1="'.$first_line['id'].'" next="pr" active="'.$active.'" " v2="" p="'.($p-$pn).'" >Previous</button>';
                        else: 
                        $pn=0; 
                        $pagination .='<button type="button" class="btn btn-secondary  n_pagination '.$d.'" v1="" next="pr" active="'.$active_.'" " v2="" p="'.($p-$pn).'" >Previous</button>';
                        endif; 
                    
                        $pagination .='<select class="form-select pagination form-select-sm" aria-label="Small select example">';

                        for($n=0;$n<$c_un;$n++){
                            
                        if( $n!=$p_):
                        $nextp= $p_+1;
                        $pagination .= '<option active="'.$active_.'" value="'.number_format($n, 0, '', '').'" v1="'.number_format($all_id[($n*24)]['id'], 0, '', '').'" next="nx" v2="" p="'.number_format($n, 0, '', '').'">'.number_format($n, 0, '', '').' </option> ';
                        endif;  
                        
                        if( $n==$p_):
                        $a= 'active';
                        $pagination .= '<option selected active="'.$active_.'" v1="'.number_format($all_id[($n*24)]['id'], 0, '', '').'" v2="'.number_format($un_all[$n]['v2'], 0, '', '').'" p="'.number_format($n, 0, '', '').'" value="'.number_format($n, 0, '', '').'">'.number_format($n, 0, '', '').'</option> ';
                        $nextv1= number_format(($un_all[$n]['v1']+1), 0, '', '');  
                        $nextv2= number_format(($un_all[$n]['v2']+1), 0, '', '');    
                        endif;
                            }
                        $pagination .=' </select>'; 
                        if($p_==($c_un-1)):
                        $d= "disabled";
                        $pagination .= '<button type="button" class="btn btn-secondary  n_pagination '.$d.'">Next</button>'; 
                        elseif($p_<($c_un-1)): 
                        $nextp= $p_+1;
                        $pagination .= '<button type="button" class="btn btn-secondary '.$a.' n_pagination" active="'.$active_.'" v1="'.$last_line['id'].'" next="nx" v2="" p="'.$nextp.'">Next</button>';
                        else:
                        $d= "disabled";
                        $pagination .= '<button type="button" class="btn btn-secondary  n_pagination '.$d.'">Next</button>'; 
                        endif;

                         if($active_==1 || $active_==0 && $update==true){   
                            if($active_==1){
                                $type_update="Productupdate";
                            }else{
                                $type_update="ProductInsert";
                            }
             $d= json_encode($list_update);
            $all_list_up= json_encode($list_update_all);
            $pagination .=  '<button type="button" class="btn btn-outline-success" disabled>-----</button>  '  ;
            $pagination .=' <select class="form-select form-control update_option_page" aria-label="Default select example">';
            $pagination .= "<option selected>Select Update</option> <option value='".$d."'  >All Page (".$list_page.")</option>";
            $pagination .= " <option value='".$all_list_up."'  >Updated all products (".$list.")</option>";
         
            $pagination .= "</select>";      
            $pagination .=  '<button type="button" class="btn btn-outline-success update_all_page" type_update="'.$type_update.'"><i class="fa-solid fa-arrows-rotate"></i></button>  '  ;

           
         }
                $pagination .=  '<button type="button" class="btn btn-outline-success update_all_page form-control" disabled> '.$list.'</button>  '  ;

                        $pagination .='</div>';

                    return $pagination; 
            }
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

        //$prepare = "SELECT * FROM wp_aliexpresspro_upload_test1 WHERE active=:active AND id_product BETWEEN $v1  AND $v2 ORDER BY id_product DESC LIMIT 24";
        if($next=='pr'):
        $condition = "id_product>$v1" ;
        elseif($next=='nx'):
        $condition = "id_product<$v1" ;
        endif;

        if(empty($v1) || $p==0 && empty($type) ){
        $prepare = "SELECT * FROM wp_aliexpresspro_upload_test1  WHERE  active=:active ORDER BY id_product DESC LIMIT 24  ";}
        elseif($type=="search_product"){

        $prepare = "SELECT * FROM wp_aliexpresspro_upload_test1 WHERE  id_ali_product=:id_ali_product ";

        } elseif(isset($next)){

        $prepare = "SELECT * FROM wp_aliexpresspro_upload_test1 WHERE active=:active AND $condition   ORDER BY id_product DESC LIMIT 24";
      
        } 
        $prepare_count = "SELECT * FROM wp_aliexpresspro_upload_test1 WHERE active=:active ORDER BY id_product DESC";

        $mys= new __root_mysql(); 

        if(isset($type)):
        $select_array = array(":id_ali_product"=>$sku);
        $select_array_c = array(":active"=>$active);
        $p=0; 
        $next="nx";
        else:
        $select_array_c = array(":active"=>$active);
        $select_array = array(":active"=>$active);
        endif; 
           
        $rs_select= $mys->__select($prepare,$select_array,true,$db);
        $rs_select_count= $mys->__select($prepare_count,$select_array_c,true,$db);

        if(empty($rs_select)){
        echo json_encode(array("page_url"=>"aucun resultat")); 
        exit; 
        }
        $list= count($rs_select_count['fectAll']); 
        $list_page = count($rs_select['fectAll']); 
        foreach($rs_select['fectAll'] as $rs_fe => $_fecthAll){
            $encode = json_encode($_fecthAll['contenu_product']);
            $rs_decode = json_decode($_fecthAll['contenu_product'],true ); 
            $list_update[]= ["id"=>$_fecthAll['id_product'], "woo_id"=>$_fecthAll['id_product_active'], "product"=>$rs_decode['result']['ae_item_base_info_dto']['product_id']]; 
        }
         foreach($rs_select_count['fectAll'] as $rs_fe => $_fecthAll){
            $encode = json_encode($_fecthAll['contenu_product']);
            $rs_decode = json_decode($_fecthAll['contenu_product'],true ); 
            $list_update_all[]= ["id"=>$_fecthAll['id_product'], "woo_id"=>$_fecthAll['id_product_active'], "product"=>$rs_decode['result']['ae_item_base_info_dto']['product_id']]; 
        }
        $page=' ';
        $page.=' <div class="container-sm  p-3 rounded">';
    /*
        if($active==1){   
            $d= json_encode($list_update);
            $all_list_up= json_encode($list_update_all);
            $page.=  ' <button type="button" class="btn btn-outline-success update_all"><i class="fa-solid fa-arrows-rotate"></i></button>    
            <select class="form-select form-control update_option" aria-label="Default select example">
            <option selected>Select Update</option>';
            $page.= " <option value='".$d."'  >All Page (".$list_page.")</option>";
            $page.=  "<option value='".$all_list_up."'>All Product (".$list.")</option>
            </select>";}
        $page.=' <input type="text" class="form-control search_product_input" active="'.$active.'" placeholder="Search Product "   aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        <button type="button" class="btn btn-outline-secondary search_product" active="'.$active.'"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>'; 
        $page.='<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
        </div>
        </div>';   
*/
        $page.= pagination($active,$p,$rs_select_count,$rs_select,true);
    
        $page.= '<div class="row row-cols-1 row-cols-sm-4 g-4">';
        $page.='';

            foreach($rs_select['fectAll'] as $rs_fe => $_fecthAll){
            $encode = json_encode($_fecthAll['contenu_product']);
            $rs_decode = json_decode($_fecthAll['contenu_product'],true ); 
            $en_rs = json_encode($rs_decode->{'result'}); 
            $dede = json_decode($de_rs,true); 
            $rs=json_encode($dede);
            $exploid_image = explode(";", $rs_decode['result']['ae_multimedia_info_dto']['image_urls']);
            $count_image = count($exploid_image);


            $page.=  '<div class="col card'.$_fecthAll['id_product'].'"><div class="card update'.$_fecthAll['id_product'].'">
            <div id="carouselExampleDark'.$_fecthAll['id_product'].'" class="carousel carousel-dark slide">'; 
            $page.= '<div class="carousel-indicators">';
            for($n=0; $n<$count_image; $n++){
            if($n==0){
            $page.='<button type="button" data-bs-target="#carouselExampleDark'.$_fecthAll['id_product'].'" data-bs-slide-to="'.$n.'" class="active" aria-current="true" aria-label="Slide '.($n+1).'"></button>';
            }else{
            $page.='<button type="button" data-bs-target="#carouselExampleDark'.$_fecthAll['id_product'].'" data-bs-slide-to="'.$n.'" aria-label="Slide '.($n+1).'"></button>';
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
            $page.='<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark'.$_fecthAll['id_product'].'" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark'.$_fecthAll['id_product'].'" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button> </div>';

            $page.= ' <div class="card-body">
            <h5 class="card-title"><h6>'.$rs_decode['result']['ae_item_base_info_dto']['subject'].'</h6></h5>
            </div>';
        //--- zone categories 
  
            if($_fecthAll['active']==1){ 
            
            $va = json_decode( $_fecthAll['categories']);
            $woo_categories = '<div class="update_categories'.$_fecthAll['id_product_active'].'">'.categories_product($va,$_fecthAll['id_product'],$_fecthAll['id_product_active'],$rs_decode['result']['ae_item_base_info_dto']['product_id'],$_fecthAll['active'],$rs_decode['result']['ae_item_base_info_dto']['category_id']).'</div>';
            $page.= $woo_categories;
            }
        //--- zone 

            $page.= '<div class="card-footer text-center bg-default rounded shadow-sm">
            <div class="btn-group text-center" role="group" aria-label="Basic mixed styles example">';
            if($_fecthAll['active']!=1){
            if($_fecthAll['active']==1){
            $type_update="Productupdate";
            }else{
            $type_update="ProductInsert";
            }
            $page.= '<button type="button" class="btn btn-primary btn-sm control-form active_product" type_update="'.$type_update.'"  id_p="'.$_fecthAll['id_product'].'" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'"  product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-check"></i></button>';
            }

            if($_fecthAll['active']==1){
                 if($_fecthAll['active']==1){
                                $type_update="Productupdate";
                            }else{
                                $type_update="ProductInsert";
                            }
            $page.='<button type="button" class="btn btn-success btn-sm control-form all_update_product" type_update="'.$type_update.'" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'" id_p="'.$_fecthAll['id_product'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-arrows-rotate"></i></button>';
            $page.='<button type="button" class="btn btn-default btn-sm control-form consult_product" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-regular fa-pen-to-square"></i></button>';
            }
            $page.='  <button type="button" class="btn btn-warning btn-sm control-form edit_product" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-bars"></i></button>
            <button type="button" class="btn btn-danger btn-sm control-form delete_product" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'" id_p="'.$_fecthAll['id_product'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-trash"></i></button>
            </div>  </div>
            </div>
            </div> ';

            }

            $page.= ' </div></div>';
          /*    $page.= '<div class="container m-2 p-2" >';

            $page.= '<div class="btn-group m-2 p-2" role="group" aria-label="">';


            foreach($rs_select_count['fectAll'] as $rs_fe => $_fecthAll){

            $all_id[]=['id'=>$_fecthAll['id_product'], 'active'=>$_fecthAll['active']]; 
    
            }

         
            foreach($rs_select['fectAll'] as $rs_fe => $_fecthAll){

            $all_id_af[]=['id'=>$_fecthAll['id_product'], 'active'=>$_fecthAll['active']]; 
    
            }

            $first_line = array_first($all_id_af);
            $last_line = end($all_id_af); //last end of the array 
                     
            $count_id=count($all_id); 
            $n_page=$count_id/24; 
            
            for($i=0; $i<$n_page;$i++){
                for($al=0; $al<$count_id; $al++){
                    if(($i*24)==$all_id[$al]['id']){
                          
                        $n_al_1= $al+1; 
                        $v_n1= $all_id[$n_al_1]['id'];
                        $un_all[]=['v1'=>$v_n1,'p'=>$p, 'active'=>$all_id[$al]['active'],'id_product'=>$all_id[$al]['id']]; 
                        }
                }
                 
            }
            $c_un = count($all_id)/24; 
        
            if($p==0):
            $d= "disabled";
            endif;

            if($p!=0):
            $pn=1;
            $page.='<button type="button" class="btn btn-secondary  n_pagination '.$d.'" v1="'.$first_line['id'].'" next="pr" active="'.$active.'" " v2="" p="'.($p-$pn).'" >Previous</button>';

            else: 
            $pn=0; 
            $page.='<button type="button" class="btn btn-secondary  n_pagination '.$d.'" v1="" next="pr" active="'.$active.'" " v2="" p="'.($p-$pn).'" >Previous</button>';
            endif; 
           
            $page.='<select class="form-select pagination form-select-sm" aria-label="Small select example">';

            for($n=0;$n<$c_un;$n++){
                
            if( $n!=$p):
            $nextp= $p+1;
            $page.= '<option active="'.$active.'" value="'.number_format($n, 0, '', '').'" v1="'.number_format($all_id[($n*24)]['id'], 0, '', '').'" next="nx" v2="" p="'.number_format($n, 0, '', '').'">'.number_format($n, 0, '', '').' </option> ';
            endif;  
               
            if( $n==$p):

            $a= 'active';
            $page.= '<option selected active="'.$active.'" v1="'.number_format($all_id[($n*24)]['id'], 0, '', '').'" v2="'.number_format($un_all[$n]['v2'], 0, '', '').'" p="'.number_format($n, 0, '', '').'" value="'.number_format($n, 0, '', '').'">'.number_format($n, 0, '', '').'</option> ';
           
            $nextv1= number_format(($un_all[$n]['v1']+1), 0, '', '');  
            $nextv2= number_format(($un_all[$n]['v2']+1), 0, '', '');  
                  
            endif;
                  }

                 
            $page.=' </select>'; 
            if($p==($c_un-1)):
            $d= "disabled";
            $page.= '<button type="button" class="btn btn-secondary  n_pagination '.$d.'">Next</button>'; 
            elseif($p<($c_un-1)): 
            $nextp= $p+1;
            $page.= '<button type="button" class="btn btn-secondary '.$a.' n_pagination" active="'.$active.'" v1="'.$last_line['id'].'" next="nx" v2="" p="'.$nextp.'">Next</button>';
            else:
            $d= "disabled";
            $page.= '<button type="button" class="btn btn-secondary  n_pagination '.$d.'">Next</button>'; 
            endif;
*/   
         //   $page.='</div></div>';

        

$page.='</div>';
$page.= pagination($active,$p,$rs_select_count,$rs_select,false);
 

echo json_encode(array("page_url"=>$page)); 



?>