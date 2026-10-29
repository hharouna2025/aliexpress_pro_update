<?php


/*

 * Plugin Name:       Aliexpress pro
 * Description:       Handle the basics with this plugin.
 
 */  

function add_theme_scripts() {
	//wp_enqueue_style( 'bootstrap.min', get_stylesheet_uri(). '/css/bootstrap/assets/dist/css/bootstrap.min.css', array(), '1.1', 'all' );



	wp_enqueue_script( 'jquery', plugins_url(). '/consmarket-llc/admin/js/jquery.js', array( 'jquery' ));
	wp_enqueue_script( 'consmarket', plugins_url(). '/consmarket-llc/admin/js/consmarket.js', array( 'jquery' ));
	wp_enqueue_script( 'bootstrap.bundle.min', plugins_url(). '/consmarket-llc/admin/css/bootstrap/assets/dist/js/bootstrap.bundle.min.js', array( 'jquery' ));
	wp_enqueue_script( 'all', plugins_url(). '/consmarket-llc/admin/css/fontawesome/js/all.js', array( 'jquery' ));
    

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

function add_theme_style() {
	//wp_enqueue_style( 'bootstrap.min', get_stylesheet_uri(). '/css/bootstrap/assets/dist/css/bootstrap.min.css', array(), '1.1', 'all' );

	wp_enqueue_style( 'bootstrap.min', plugins_url(). '/consmarket-llc/admin/css/bootstrap/assets/dist/css/bootstrap.min.css',array(),'5.3.8','all') ;
	wp_enqueue_style( 'all', plugins_url(). '/consmarket-llc/admin/css/fontawesome/css/all.css');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_style( 'comment-reply' );
	}
}



function wporg_options_page() {
    //add_options_page('word count setting', 'Consmarket Menu','manage_options',  plugin_dir_path(__FILE__) . 'admin/url_contenu.php', 5);
    add_menu_page(
        'Aliexpress pro',
        'Aliexpress pro',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/url_contenu.php',
        null,
        '<i class="fa-brands fa-product-hunt"></i>',
        20
    );
}

add_action( 'admin_enqueue_scripts', 'add_theme_style' );  
add_action( 'admin_enqueue_scripts', 'add_theme_scripts' );


add_action( 'admin_menu', 'wporg_options_page' );



?>