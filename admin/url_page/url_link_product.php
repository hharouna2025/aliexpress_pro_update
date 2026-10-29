<?php 

              
            extract($_POST);
            extract($_GET);


         
            require_once("url_ali_all.php"); 

            $array_Ioplient= array();

            if($token_type=='ProductGet'):
            $array_Ioplient= array('ID_URL'=>$url_link);
            endif;
            
            

            if(isset($code)):
                
                $array_Ioplient= array('CODE'=>$code);
                $token_type="getcode";
                $filename= "../private/GetCODE.txt";
                $dataCode=$code; 
                file_put_contents($filename, $dataCode);
                $CODE_n = file_get_contents($filename, true);
                header('Location: https://'.$_SERVER['SERVER_NAME'].'/wp-admin/admin.php?page=consmarket-llc%2Fadmin%2Furl_contenu.php&msg=codeTrue');
                exit; 


                endif;

                if($token_type=='AECategorys'):
                    $array_Ioplient= array('categories'=>$cat_id); 
                endif; 
                    $ali_all= new url_ali_all($array_Ioplient); 

                if($token_type=='AECategorys'):
                    $rs_ali_all = $ali_all->$token_type();
                     echo $rs_ali_all; 
                exit; 
                endif;

                     $rs_ali_all = $ali_all->$token_type(); 
                 // $rs_fee = $ali_all->buyercalculate_shippingfee();        
                echo $rs_ali_all;
               
            exit;            




?>