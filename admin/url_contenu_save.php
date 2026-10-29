






<?php
extract($_POST); 
global $jal_db_version;
$jal_db_version = '1.0';

function jal_install() {

            global $wpdb;
            global $jal_db_version;

            $table_name = $wpdb->prefix . 'c1vsstyle';// basse de donnes

            $charset_collate = $wpdb->get_charset_collate();
//----- zone creation table wp_aliexpresspro_upload_test1 on sql db 
            $sql = "CREATE TABLE wp_aliexpresspro_upload_test1 (
            id_product int(11)  NOT NULL AUTO_INCREMENT,
            id_ali_product varchar(250) NOT NULL,
            contenu_product longtext NOT NULL,
            id_product_active varchar(250) NOT NULL,
            categories VARCHAR(500) NOT NULL,
            date_upload timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY  (id_product)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
//-----zone creation table wp_aliexpresspro_upload_test1 on sql db 
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';// admin upgrade 
            dbDelta( $sql );

            add_option( 'jal_db_version', $jal_db_version );
            }

            jal_install();
            require_once ABSPATH . 'wp-includes/class-wpdb.php';

            $table_name1 = $wpdb->prefix . 'c1vsstyle.wp_aliexpresspro_upload_test1';
            $wpdb->insert(
            $table_name1 ,
            array(
                'id_ali_product' => 'sgsg',
                'contenu_product' => "dfd"
            )
            );
            if(empty($active)){
            $active="0"; 
            }

      //--- and creation and update       
              /*

              zone listing  product

              */
              //--- zone require 
              require_once("url_controler/url_controler_update/wordpress_creat_insert.php");
              require_once("private/private_db_root.php");
              require_once("url_page/url_page_contenu.php");

              $prepare = "SELECT * FROM wp_aliexpresspro_upload_test1  WHERE  active=:active ORDER BY id_product DESC LIMIT 24  ";
              $prepare_count = "SELECT * FROM wp_aliexpresspro_upload_test1 WHERE  active=:active ";
              
              $url_contenu= new url_contenu();
        
              $mys= new __root_mysql(); 
              $select_array = array(":active"=>$active);
              $select_array_c = array(":active"=>$active);
              $rs_select= $mys->__select($prepare,$select_array,true,$db);
              $rs_select_count= $mys->__select($prepare_count,$select_array_c,true,$db);

              $list= count($rs_select_count['fectAll']); 
                //---  zone require

        $page=   '
        <div class="modal  modal-xl fade mt-2" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        Show a second modal and hide this one with the button below.
        </div>
        <div class="modal-footer">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        </div>
        </div>
        </div>
        </div>



        <div class="container-md shadow-sm mt-3 bg-dark p-2 rounded">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"> <i class="fa-solid fa-barcode"></i> Add product</button>
        </li>
        <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="fa-solid fa-list"></i> List Porduct</button>
        </li>
        <li class="nav-item" role="presentation">
        <button class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false"><i class="fa-solid fa-gear"></i> Parametres</button>
        </li>
        <li class="nav-item" role="presentation">
        <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Settings</button>
        </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
        <div class="tab-pane active shadow-sm mt-3  p-5 rounded contenu_url_page" id="home" role="tabpanel" aria-labelledby="home-tab" tabindex="0"><div class="input-group mb-3">
        <input type="text" class="form-control "  valeu="" id="link" placeholder="But link : https://www.aliexpress.us/item/[3256803904367260].html => 3256803904367260 " aria-label="Recipient’s username" aria-describedby="button-addon2">
        <button class="btn btn-outline-success " type="button" id="down_image"> <i class="fa-solid fa-download"></i> Download</button>
        </div></div>
        <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">2</div>
        <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab" tabindex="0">

        <div class="tab-pane active shadow-sm mt-3  p-5 rounded contenu_url_page" id="home" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
        <div class="btn-group m-2" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-success" type_token="ActiveCode" id="token">AUTH ALIEXPRESS CODE</button>
        <button type="button" class="btn btn-primary" type_token="GenerateToken" id="token">Generate Token</button>

        </div>     ';
        $page.= '<div class="container-sm m-2 p-2 bg-light shadow-lg rounded">
         //---- zone access ali authentification and Token 
        <p class="text-start">Token : '.ACCESS_TOKEN.'</p>
        <p class="text-start">Auth ali : '.CODE.'</p>
        </div> </div>';
        //---- zone access ali authentification and Token 
        $page.= '</div></div> ';
        $page.= '<div class="container-sm m-2 p-2 bg-light shadow-lg rounded">
        <div class="btn-group m-2" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-success" type_token="ActiveCode" id="token">AUTH ALIEXPRESS CODE</button>
        <button type="button" class="btn btn-primary" type_token="GenerateToken" id="token">Generate Token</button>

        </div>    
        zone access ali authentification and Token 
        <p class="text-start">Token : '.ACCESS_TOKEN.'</p>
        <p class="text-start">Auth ali : '.CODE.'</p>
        </div> </div>';
        $page.= '<div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab" tabindex="0">4</div>
        </div></div><div class="container-md shadow-sm mt-3 bg-light p-2 rounded resultat_product">
        <div class="container text-left"> <div class="row"> <div class="col-sm-9 rs_u_pagination">' ;
        $page.=' <div class="container-sm shadow-sm p-3 rounded">  <i class="fa-solid fa-barcode"></i>  Product upload on aliexpress.us : '.$list.'</div></br>'; 
        $page.=' <div class="container-sm  p-3 rounded">  <div class="input-group mb-3">
        <button class="input-group-text shadow-lg search_product" active="'.$active.'" id="inputGroup-sizing-default"><i class="fa-solid fa-magnifying-glass"></i></button>
        <input type="text" class="form-control search_product_input" active="'.$active.'" placeholder="Search Product [Example SKU: 3256808679907523 ]..."   aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        </div></div></br>'; 

        $page.= '<div class="row row-cols-1 row-cols-md-3 g-4">';
          ///--- zone carousel image 
            foreach($rs_select['fectAll'] as $rs_fe => $_fecthAll){
            $encode = json_encode($_fecthAll['contenu_product']);
            $rs_decode = json_decode($_fecthAll['contenu_product'],true ); 
            $en_rs = json_encode($rs_decode->{'result'}); 
            $dede = json_decode($de_rs,true); 
            $rs=json_encode($dede);
            $exploid_image = explode(";", $rs_decode['result']['ae_multimedia_info_dto']['image_urls']);
            $count_image = count($exploid_image);


            $page.=  '<div class="col card'.$_fecthAll['id_product'].'"><div class="card h-100">
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
            //---- zone images carousel 
            //---- zone images 
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
            //-- zone images
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
            </div>
            <div class="card-footer text-center bg-default">
            <div class="btn-group text-center" role="group" aria-label="Basic mixed styles example">';

            if($_fecthAll['active']!=1){
            $page.= '<button type="button" class="btn btn-primary btn-sm control-form active_product"  id_p="'.$_fecthAll['id_product'].'" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'"  product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-check"></i></button>';
            }
            if($_fecthAll['active']==1){
            $page.='<button type="button" class="btn btn-success btn-sm control-form consult_product" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-arrows-rotate"></i></button>';
            $page.='<button type="button" class="btn btn-success btn-sm control-form consult_product" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-regular fa-pen-to-square"></i></button>';

            }
            $page.='  <button type="button" class="btn btn-warning btn-sm control-form edit_product" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-bars"></i></button>
            <button type="button" class="btn btn-danger btn-sm control-form delete_product" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'" id_p="'.$_fecthAll['id_product'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-trash"></i></button>
            </div>  </div>
            </div>
            </div> ';

           }

            $page.= '<div class="container m-2 p-2" >';
            $page.= '<div class="btn-group m-2 p-2" role="group" aria-label="">';

            foreach($rs_select_count['fectAll'] as $rs_fe => $_fecthAll){
            $all_id[]=['id'=>$_fecthAll['id_product'], 'active'=>$_fecthAll['active']]; 
            }

            foreach($rs_select['fectAll'] as $rs_fe => $_fecthAll){
            $all_id_af[]=['id'=>$_fecthAll['id_product'], 'active'=>$_fecthAll['active']]; 
            }      
            
            $first_line = array_first($all_id_af);// frist of the array 
            $last_line = end($all_id_af); //last end of the array 
            $count_id=count($all_id); 
            $n_page=$count_id/24;  
            
            for($i=1; $i<$n_page;$i++){
                for($al=0; $al<$count_id; $al++){
                    if(($i*24)==$all_id[$al]['id']){
                          $n_al_1= $al+1; 
                          $n_al_2= $al+24; 
                          $v_n1= $all_id[$n_al_1]['id'];
                          $v_n2=$all_id[$n_al_2]['id']; 
                          $un_all[]=['v1'=>$v_n1,'v2'=>$v_n2,'p'=>$p, 'active'=>$all_id[$al]['active']]; 
                        }
                }                
            }                   
            $c_un = count($un_all); 
            if($p==0):
            $d= "disabled";
            endif;
            $page.= '<button type="button" class="btn btn-secondary  n_pagination '.$d.'" v1="'.$first_line['id'].'" next="pr" p="'.($un_all[$n]['p']-1).'" >Previous</button>';
            $page.=' <select class="form-select form-select-sm" aria-label="Small select example">';

            for($n=0;$n<$c_un;$n++){
            if( $n!=$un_all[$n]['p']):
            $page.= '<option value="'.number_format($n, 0, '', '').'">'.number_format($n, 0, '', '').'</option> ';
            endif;  
               
            if( $n==$un_all[$n]['p']):
                $a= 'active';
                $page.= '<button type="button" class="btn btn-secondary '.$a.'  n_pagination" active="'.$active.'" v1="'.number_format($un_all[$n]['v1'], 0, '', '').'" v2="'.number_format($un_all[$n]['v2'], 0, '', '').'" p="'.number_format($n, 0, '', '').'">'.number_format($n, 0, '', '').'</button>';
                $page.= '<option selected active="'.$active.'" v1="'.number_format($un_all[$n]['v1'], 0, '', '').'" v2="'.number_format($un_all[$n]['v2'], 0, '', '').'" p="'.number_format($n, 0, '', '').'" value="'.number_format($n, 0, '', '').'">'.number_format($n, 0, '', '').'</option> ';
                $nextv1= number_format(($un_all[$n]['v1']+1), 0, '', '');  
                $nextv2= number_format(($un_all[$n]['v2']+1), 0, '', '');  
                $nextp= number_format(($n+1), 0, '', '');  
            endif;
                  }

            $page.=' </select>'; 
            if($p==$c_un):
            $d= "disabled";
            $page.= '<button type="button" class="btn btn-secondary  n_pagination '.$d.'">Next</button>'; 
        
            elseif($p<$c_un): 
            $page.= '<button type="button" class="btn btn-secondary '.$a.' n_pagination" active="'.$active.'" next="nx"  v1="'.$last_line['id'].'" v2="'.$nextv2.'" p="'.$nextp.'">Next</button>';

            endif;

            $page.='</div>';
            $page.='</div></div>';
            $page.='</div><div class="col-sm-3"><div class="list-group">
            <button type="button" class="list-group-item list-group-item-action active" aria-current="true">
            Information Product
            </button>
            <button type="button"  active="1" class="list-group-item list-group-item-action product_status ">List Product active</button>
            <button type="button" active="0" class="list-group-item list-group-item-action product_status">List Product desactive</button>
            </div></div></div></div>';


            echo $page;
            exit; 

?>
