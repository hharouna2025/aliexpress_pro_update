<?php 
class url_contenu{

public $token_ali, $code_ali;
public $rs_select_sql, $rs_select_account; 

public function __construct($token,$code)
        {
                    
                $this->token_ali= $token; 
                $this->code_ali=$code;

        }



public function contenu($rs_select_,$rs_select_count_,$ac_,$p_page_){

        $return_page = $this->modal();
        $return_page .= $this->css_js();
        $return_page .= $this->div_start_contenu();//-start 
        $return_page .= $this->all_nav_parametter(); 
        $return_page .= $this->search_fun($rs_select_,$rs_select_count_,$ac_,$p_page_); 
        $return_page .= $this->contenu_page($rs_select_,$rs_select_count_,$ac_,$p_page_);
     //$return_page .= $this->pagination($ac_,$p_page_); 
        $return_page .= $this->div_end_contenu();//end
        


        return $return_page; 


}
public function css_js(){
    $boostrat_js_css ="<link rel='stylesheet' id='bootstrap.min-css' href='https://vs-style.com/wp-content/plugins/consmarket-llc/admin/css/bootstrap/assets/dist/css/bootstrap.min.css' media='all' />";
    $boostrat_js_css .='<script id="bootstrap.bundle.min" src=" https://vs-style.com/wp-content/plugins/consmarket-llc/admin/css/bootstrap/assets/dist/js/bootstrap.bundle.min.js"></script>';
    https://vs-style.com/wp-content/plugins/consmarket-llc/admin/css/bootstrap/assets/dist/js/bootstrap.bundle.min.js
    return $boostrat_js_css ; 

}

public function url_new(){
            $return_page = $this->modal();
          //  $return_page .= $this->div_start_contenu();
            $return_page .= $this->all_nav_parametter();
           // $return_page .= $this->div_end_contenu();

            return $return_page; 
 }
public function div_start_contenu(){
    $page_start= '
        <div class="container-md mt-3  p-2 rounded resultat_product">
         <div class="col-sm-12 "> '     ;

        return $page_start; 
}
public function div_end_contenu(){
    $page_end= '</div></div> '  ;

    return $page_end; 
}

public function modal(){



        $modal = '<div class="modal  modal-xl fade mt-2" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
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
                    </div>'; 
        return $modal; 

}


public function main_container(){
           $main = '<div class="container-md shadow-sm mt-3 bg-light p-2 rounded resultat_product">';
           $main .= " "; 
           $main.= '</div>'; 
}
public function all_nav_parametter(){
    
$all_parmet = '<div class="container-md shadow-sm mt-3 mb-2 bg-dark p-2 rounded">

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
        //---- zone access ali authentification and Token 
        $all_parmet.= '<div class="container-sm m-2 p-2 bg-light shadow-lg rounded">
        
        <p class="text-start">Token : '.$this->token_ali.'</p>
        <p class="text-start">Auth ali : '.$this->code_ali.'</p>
        </div> <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab" tabindex="0">4</div>
        
        </div></div></div></div>';
      

return $all_parmet ; 


}
public function categories_product($woo_val_categories,$id_product_woo,$woo_product_active,$product_update, $active_update,$category_id){
                
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

            }

public function ac_desc(){
   $act_desc =' <div class="btn-group mt-2" role="group" aria-label="Basic outlined example">
    <button type="button"  active="1" class="btn btn-outline-success product_status ">Product active</button>
<button type="button" active="0" class="btn btn-outline-danger product_status"> Product desactive </button>
</div>'; 

            return  $act_desc ; 

}

public function contenu_page($rs_fetchall_select,$rs_fetchall_count,$active_,$p_){


            // $page=$contenu_page;
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
      
        $page='';
        $page.= '<div class="rs_pagination pb-3 rounded rs_u_pagination">';
        $page.=  $this->pagination($active_,$p_,$rs_fetchall_count,$rs_fetchall_select,true); 

        $page.= '<div class="row row-cols-1 row-cols-sm-4 g-4 ">';
          ///--- zone carousel image 
    foreach($rs_fetchall_select['fectAll'] as $rs_fe => $_fecthAll){
            $encode = json_encode($_fecthAll['contenu_product']);
            $rs_decode = json_decode($_fecthAll['contenu_product'],true ); 
            $en_rs = json_encode($rs_decode->{'result'}); 
           // $dede = json_decode($en_rs,true); 
            //$rs=json_encode($dede);
            $exploid_image = explode(";", $rs_decode['result']['ae_multimedia_info_dto']['image_urls']);
            $count_image = count($exploid_image);
            $page.='<div class="col card'.$_fecthAll['id_product'].'"><div class="card update'.$_fecthAll['id_product'].' shadow-sm mt-3 mb-2 bg-light rounded">
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
            // ---  decut for
            for($i=0; $i<$count_image; $i++){
                if($i==0){
                $img.=  '  <div class="carousel-item active" data-bs-interval="2000">
                <img src="'.$exploid_image[$i].'" class="d-block w-100 rounded" alt="..." width="207"  height="207"></div>';
                }else{
                $img.=  '  <div class="carousel-item" data-bs-interval="2000">
                <img src="'.$exploid_image[$i].'" class="d-block w-100 rounded" alt="..." width="207"  height="207"></div>';
                }
            }//---  fin for 
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
            </div>';//---


                                //--- zone categories 
 
            if($_fecthAll['active']==1 ){ 
               
                $va = json_decode( $_fecthAll['categories']);
                $woo_categories = '<div class="update_categories'.$_fecthAll['id_product_active'].'">'.$this->categories_product($va,$_fecthAll['id_product'],$_fecthAll['id_product_active'],$rs_decode['result']['ae_item_base_info_dto']['product_id'],$_fecthAll['active'],$rs_decode['result']['ae_item_base_info_dto']['category_id']).'</div>';
                $page.= $woo_categories;
            }
        
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
            $page.='<button type="button" class="btn btn-success btn-sm control-form all_update_product"   type_update="'.$type_update.'" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'" id_p="'.$_fecthAll['id_product'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-arrows-rotate"></i></button>';
            $page.='<button type="button" class="btn btn-default btn-sm control-form consult_product" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-regular fa-pen-to-square"></i></button>';

            }
            $page.='  <button type="button" class="btn btn-warning btn-sm control-form edit_product" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-bars"></i></button>
            <button type="button" class="btn btn-danger btn-sm control-form delete_product" id_product_woo="'.$_fecthAll['id_product_active'].'" active="'.$_fecthAll['active'].'" id_p="'.$_fecthAll['id_product'].'" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-trash"></i></button>
            </div></div>
            </div></div>
           ';

     }
     
            $page.= "</div>"; 
            $page.=  $this->pagination($active_,$p_,$rs_fetchall_count,$rs_fetchall_select,false); 
            $page.= "</div>";
    
       
            return $page ; 

}

public function search_fun($rs_fetchall_select,$rs_fetchall_count,$active_,$p_){

            $list_all= count($rs_fetchall_select['fectAll']); 
            foreach($rs_fetchall_select['fectAll'] as $rs_fe => $_fecthAll){
            $encode = json_encode($_fecthAll['contenu_product']);
            $rs_decode = json_decode($_fecthAll['contenu_product'],true ); 
            $list_update[]= ["id"=>$_fecthAll['id_product'], "woo_id"=>$_fecthAll['id_product_active'], "product"=>$rs_decode['result']['ae_item_base_info_dto']['product_id']]; 
            }
            $list= count($rs_fetchall_count['fectAll']); 
            foreach($rs_fetchall_count['fectAll'] as $rs_fe => $_fecthAll){
            $encode = json_encode($_fecthAll['contenu_product']);
            $rs_decode = json_decode($_fecthAll['contenu_product'],true ); 
            $list_update_all[]= ["id"=>$_fecthAll['id_product'], "woo_id"=>$_fecthAll['id_product_active'], "product"=>$rs_decode['result']['ae_item_base_info_dto']['product_id']]; 
            }
        
        $page='  <div class="container-sm shadow-sm mb-2 bg-light rounded">';
        $page.=' <div class="container-sm  p-3 rounded"><div class="input-group mb-3">';
       /*
        if($active_==1 || $active_==0){   
            if($active_==1){
                                $type_update="Productupdate";
                            }else{
                                $type_update="ProductInsert";
                            }
        $all_list_up= json_encode($list_update_all);
        $all_list= json_encode($list_update);
        $page.=  ' <button type="button" class="btn btn-outline-success update_all"><i class="fa-solid fa-arrows-rotate"></i></button>    
        <select class="form-select form-control update_option" aria-label="Default select example">
        <option selected>Select Update</option>';
        $page.=  "<option value='".$all_list_up."'>All Product (".$list.")</option> ";      
        $page.=  "<option value='".$all_list."'>Selected Product (".$list_all.")</option> </select>";      
         }*/
        $page.=' <input type="text" class="form-control search_product_input" active="'.$active_.'" placeholder="Search Product "   aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        <button type="button" class="btn btn-outline-secondary search_product" active="'.$active_.'"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>'; 
        $page.='<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
        </div>
        ';   
        $page.= $this->ac_desc(); 
      
        $page.= '</div>'; 


        return  $page; 
}
public function pagination($active_,$p_,$rs_select_account_,$rs_select_sql,$update){
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
            $all_list_up= json_encode($list_update);
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
}






?>