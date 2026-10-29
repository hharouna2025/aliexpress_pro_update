<?php 
/*

controle all nav 

*/

extract($_POST); 


class url_page_nav{


    public function add_product($u_nav)){
         return json_encode(array('contenu_url_page'=>$u_nav,, 'resultat'=> "resultat_product"));
    }
    public function list_product(){

            require_once("../url_controler/url_controler_update/wordpress_creat_insert.php");
            $db = new PDO("mysql:host=localhost;dbname=c1vsstyle", "c1vsstyle","@05530080@");
            $prepare = "SELECT * FROM wp_aliexpresspro_upload_test1 ORDER BY id_product DESC LIMIT 24  ";

            $mys= new __root_mysql(); 
            $select_array = array();
            $rs_select= $mys->__select($prepare,$select_array,true,$db);

            //require_once("url_page/url_page_listproduct.php"); 
            /*
            $page_list_product =new list_product(); 

            $rs_list_product = $page_list_product->list_product($db,$prepare); 



            */
            //$decode = json_decode($rs_select->{"contenu"})
                $page= '<div class="row row-cols-1 row-cols-md-3 g-4">';


                foreach($rs_select['fectAll'] as $rs_fe => $_fecthAll){
                $encode = json_encode($_fecthAll['contenu_product']);
                $rs_decode = json_decode($_fecthAll['contenu_product'],true ); 
                $en_rs = json_encode($rs_decode->{'result'}); 
                $dede = json_decode($de_rs,true); 
                $rs=json_encode($dede);

                $page.=  '<div class="col"><div class="card h-100">
                <div id="carouselExampleDark" class="carousel carousel-dark slide"><div class="carousel-inner"> <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>';


                            //var_dump($rs_decode['result']['ae_multimedia_info_dto']['image_urls'] );
                $exploid_image = explode(";", $rs_decode['result']['ae_multimedia_info_dto']['image_urls']);
                $count_image = count($exploid_image);
                $img=' <div class="carousel-inner">'; 
                for($i=0; $i<$count_image; $i++){
                $img.=  '<div class="carousel-item active" data-bs-interval="10000">
                <img src="'.$exploid_image[$i].'" class="d-block w-100 rounded" alt="..." width="207"
                height="207"></div>';
                            
                            }

                        
                    $page.='</div></div>'.$img;
                $page.='<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
                </button> ';
                $page.= ' </div><div class="card-body">
                <h5 class="card-title"><h6>'.$rs_decode['result']['ae_item_base_info_dto']['subject'].'</h6></h5>
                </div>
                <div class="card-footer text-center bg-default">
                <div class="btn-group text-center" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn btn-primary btn-sm control-form active_product"  product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-check"></i></button>
          <button type="button" class="btn btn-success btn-sm control-form consult_product" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-bars"></i></button>
          <button type="button" class="btn btn-warning btn-sm control-form edit_product" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-regular fa-pen-to-square"></i></button>
          <button type="button" class="btn btn-danger btn-sm control-form delete_product" product="'.$rs_decode['result']['ae_item_base_info_dto']['product_id'].'"><i class="fa-solid fa-trash"></i></button>
                </div>  </div>
                </div>
                </div> ';



                    

                    }

            $page.= '<nav aria-label="...">
                    <ul class="pagination">
                    <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active">
                    <a class="page-link" href="#" aria-current="page">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                    </li>
                    </ul>
                    </nav>';
            $page.='</div>';
      
$u_page = 
            '
            

            <div class="container-sm">consmarket llc</div>

            <div class="container-sm shadow-sm mt-3  p-5 rounded contenu_url_page">


            <div class="input-group mb-3">
            <input type="text" class="form-control "  valeu="" id="link" placeholder="But link : https://www.aliexpress.us/item/[3256803904367260].html => 3256803904367260 " aria-label="Recipient’s username" aria-describedby="button-addon2">
            <button class="btn btn-outline-success " type="button" id="down_image"> <i class="fa-solid fa-download"></i> Download</button>
            </div> </div></div>

            <div class="container-md shadow-sm mt-3 bg-light p-2 rounded resultat_product">

            <div class="container text-left">
            <div class="row">
            <div class="col-sm-9">
              ' .$page.'
    
            </div>
            <div class="col-sm-3">
            <a href="/" class="d-flex align-items-center pb-3 mb-3 link-body-emphasis text-decoration-none border-bottom">
            <li class="mb-1"> <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
            Information product
            </button> 
            <div class="collapse" id="home-collapse" style=""> <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small"> <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Overview</a></li> <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Updates</a></li> <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Reports</a></li> </ul> </div> </li> <li class="mb-1"> <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
            Dashboard
            </button> 
            <div class="collapse" id="dashboard-collapse" style="">

            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Overview</a></li>

            </ul> 
            </div> 
            </li> <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
            Orders
            </button> 
            <div class="collapse" id="orders-collapse" style=""> <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small"> 
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">New</a></li> 
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Processed</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Shipped</a></li> 
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Returned</a></li> 
            </ul> </div> </li> 
            <li class="border-top my-3"></li> 
            <li class="mb-1"> 
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
            Account
            </button> 
            <div class="collapse" id="account-collapse" style=""> 
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small"> 
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">New...</a></li> 
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Profile</a></li> 
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Settings</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Sign out</a></li>
            </ul> </div> </li> </ul> 

            </div>
            </div>
            </div>';

         return json_encode(array('contenu_url_page'=>$u_nav, 'resultat'=> "resultat_product", "u_page"=>$u_page));
    }
    public function parametres(){
         return json_encode(array('contenu_url_page'=>$u_nav, 'resultat'=> "resultat_product"));
    }

}


$url_nav = new url_page_nav(); 


        if(isset($nav)):
                    if($nav='$add_product_nav'):
                        echo $url_nav->add_product($nav);
                        exit; 
                    elseif ($nav='list_product'):
                        echo $url_nav->list_product($nav);
                        exit;
                    elseif($nav='parametres'):
                        echo $url_nav->parametres($nav);
                        exit;   
                    else:
                        echo $url_nav->add_product($nav);
                        exit; 
                    endif; 
        endif;           



?>