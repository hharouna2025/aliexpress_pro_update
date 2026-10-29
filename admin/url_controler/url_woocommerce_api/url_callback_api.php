<?php
// Install:
//composer require automattic/woocommerce

// Setup:
//require_once("../../private/private_db_root.php");
require __DIR__ . '/wc-api-php/src/vendor/autoload.php';

//use Automattic\wc-api-php\src\WooCommerce\Client;

$woocommerce = new Client(
  'http://vs-style.com', // Your store URL
    'ck_90ae4153d3fc72bdeca515ca20a126b810001de9', // Your consumer key
    'cs_97f2068ecb0eb7c256552f10105729df37bad776', // Your consumer secret
    [
        'wp_api' => true, // Enable the WP REST API integration
        'version' => 'wc/v3' // WooCommerce WP REST API version
    ]
);
?>