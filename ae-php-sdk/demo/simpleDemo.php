<?php
    include "../IopSdk.php";

    $c = new IopClient('https://api-pre.aliexpress.com/sync', '538886', 'WwXtJWYkT8m1Zsx5DNRb1HH2sKNYr6Qm');
    $request = new IopRequest('aliexpress.logistics.redefining.getlogisticsselleraddresses');
    $request->simplify="true";
    $request->format="xml";
    $request->addApiParam('seller_address_query','pickup');
    
    var_dump($c->execute($request,"50000001a27l15rndYBjw6PrtFFHPGZfy09k1Cp1bd8597fsduP0RsNy0jhF6FL"));

?>