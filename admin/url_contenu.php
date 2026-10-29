






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
            $ac="0"; 
            }
            if(empty($p)){
            $p="0"; 
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
          
              $url_contenu= new url_contenu(ACCESS_TOKEN,CODE);
        
              $mys= new __root_mysql(); 
              $select_array = array(":active"=>$ac);
              $select_array_c = array(":active"=>$ac);
              $rs_select= $mys->__select($prepare,$select_array,true,$db);
              $rs_select_count= $mys->__select($prepare_count,$select_array_c,true,$db);

                $url_contenu->rs_select_account = $rs_select_count; 
                $url_contenu->rs_select_sql = $rs_select; 
                //---  zone require
   
             
            if(empty($rs_select['fectAll'])):
                  
            $ac="1"; 
            $prepare = "SELECT * FROM wp_aliexpresspro_upload_test1  WHERE  active=:active ORDER BY id_product DESC LIMIT 24  ";
            $prepare_count = "SELECT * FROM wp_aliexpresspro_upload_test1 WHERE  active=:active ";

            $select_array = array(":active"=>$ac);
            $select_array_c = array(":active"=>$ac);
            $rs_select= $mys->__select($prepare,$select_array,true,$db);
            $rs_select_count= $mys->__select($prepare_count,$select_array_c,true,$db);
            // $list= count($rs_select_count['fectAll']); 
                     $url_contenu->rs_select_account = $rs_select_count; 
                     $url_contenu->rs_select_sql = $rs_select; 
                    
                if(empty($rs_select)){
                echo $url_contenu->url_new(); 
                exit; 
                }
                //---  zone require
            endif; 
 
                $p_page = $p; 
                // all contenu
//echo "ok".$p.$ac ; exit; 
                echo $url_contenu->contenu($rs_select,$rs_select_count,$ac,$p_page); 
            exit; 


?>
