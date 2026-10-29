<?php 
require_once("../url_controler/url_controler_update/wordpress_creat_insert.php");

class list_product extends __root_mysql{

public function presentation($image_product,$subject_product){

       

                    $af=   ' <div class="col">
                    <div class="card h-100">'.$image_product.'
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                    <h5 class="card-title">'.$subject_product.'</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                    <div class="card-footer">
                    <small class="text-body-secondary">Last updated 3 mins ago</small>
                    </div>
                    </div>';

                    return $af;

}
public function list_product($db_sql, $prepare_p){

            $select_array = array();
            $rs_select= $this->__select($prepare_p,$select_array,true,$db_sql);

            $list="";   
            $list.= '<div class="row row-cols-1 row-cols-md-3 g-4">';

                    foreach($rs_select['fectAll'] as $rs_fe => $_fecthAll){

                  //  $list.=$this->presentation($_fecthAll[contenu_product]['result']['ae_multimedia_info_dto']['image_urls'],$_fecthAll['result']['ae_item_base_info_dto']['subject']);  

                    }
            $list.= '</div>';
            }

return $list; 
}












?>