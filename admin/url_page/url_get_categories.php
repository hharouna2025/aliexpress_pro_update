<?php 

class get_categories{

        public string $URL_LINK; 
        protected string $URL_LINK_REST_TOKEN; 
        public string $APPKEY; 
        public string $APPSECRET; 
        public string $ACCESTOKEN; 
        protected string $CODE; 
        protected string $ID_URL; 
        protected string $HOST_DB; 
        protected string $HOST_USER; 
        protected string $HOST_PASS; 
        public string $LINK_CODE; 
        public int $ID_CATEGORIES; 

        public function __construct(){
        require_once("../private/private_db_root.php");
        include_once('../../ae-php-sdk/IopSdk.php');
        $this->URL_LINK =URL_LINK;
        $this->APPKEY= APPKEY;
        $this->APPSECRET= APPSECRET;
        $this->ACCESTOKEN= ACCESS_TOKEN;

        }
        public function  cat_AECategorys($categories_id){

        $c = new IopClient($this->URL_LINK,$this->APPKEY,$this->APPSECRET);
        $request = new IopRequest('aliexpress.ds.category.get');
        $request->addApiParam('categoryId',$categories_id);
        $request->addApiParam('language','en');
        $request->addApiParam('consmarket',$this->ACCESTOKEN);

        
       // $rs_resultat_cat= $c->execute($request);

        return $c->execute($request);; 
        }

}












?>