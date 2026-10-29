<?php
/*
function 
controleur 
insert
update
delete 
*/


class __root_mysql {
 
  public $domaine_serveur = ''; 
  

  public function __insert($_prepare, $array_execute,$_db){
      //function insertion basse de donnee 
    $sqlinsert= $_db->prepare($_prepare);
    $sqlinsert->execute($array_execute);
    $last_insert = $_db->lastInsertId();
          
      return $last_insert ; 

    }

    public function __select($_prepare,$array_execute, $_truefalse,$_db)
    {
   // function selection dans la basse de donnee
      $sqlselect= $_db->prepare($_prepare);
      $sqlselect->execute($array_execute);
      $count =$sqlselect->rowCount(); 
     /*
     explication:
      condition true :
        perment d'utiliser l option 
      
        foreach($_db_root_admin['fectAll'] as $rs_fe => $_fecthAll){
            $r_page .= $_fecthAll['root_mail'];
          }
        de la function fetchALL
      condition false :
          perment d'utiliser seulement la function fetch   
     */


    if($_truefalse==true):

        $r_fetechAll= $sqlselect->fetchAll(PDO::FETCH_ASSOC); 

        if(empty($r_fetechAll)):
            return false;
        else:
          $return = array('fectAll'=>$r_fetechAll,'compte'=>$count);
          return $return; 
        endif;

        elseif($_truefalse==false):
          
        $r_fetech= $sqlselect->fetch(); 
          if(empty($r_fetech)):
            return false;
        else:
          return $r_fetech;
        endif; 
    endif; 
      

    }

    public function __like($_prepare,$_excute_array, $_trueflase,$_db)
    {
  // function rechercher dans la basse de donnees
      $sqlselect= $_db->prepare($_prepare);
      $sqlselect->execute($_excute_array);
      $count =$sqlselect->rowCount(); 
     
      if($_trueflase=true):

        $r_fetechAll= $sqlselect->fetchAll(PDO::FETCH_ASSOC); 
        $return = array('fectAll'=>$r_fetechAll,'compte'=>$count);

        return $return; 

        else:

        $r_fetech= $sqlselect->fetch(); 
        return $r_fetech;
        endif; 
      

      }

    public function __update($_prepare, $array_execute, $_db)
    {
      // function update
      //UPDATE `root_admin` SET `root_phone` = '19733937509' WHERE `root_admin`.`id_root_admin` = 1;
      $update_= $_db->prepare($_prepare);
      if($update_->execute($array_execute)){
            return  true;
        } else{
          return false;
        };

      

    }
  
    public function __delete($_prepare, $_array_execute, $_db)
    {

// function supprimer 

            $sqldelete= $_db->prepare($_prepare);
            $sqldelete->execute($_array_execute);
            $row=  $sqldelete->rowCount();

            return $row; 
   

    }

}


?>