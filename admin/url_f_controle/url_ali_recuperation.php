<?php 

class ali_recuperation{


public $rsp_msg, $rsp_code ,$result , $ae_item_properties , $ae_item_sku_info_dtos , $ae_multimedia_info_dto, $package_info_dto , $ae_store_info, $product_id_converter_result,
$has_whole_sale, $manufacturer_info, $logistics_info_dto, $ae_item_base_info_dto; 

public function decode_f($_json){

                $restulat_jsondecode= json_decode($resultat); 
                //recuperation
                $rs_encode = json_encode($restulat_jsondecode->{$_json}); 

}

public function encode_f($_json){


}

public function fetch_all($_array_json){

}

}






?>