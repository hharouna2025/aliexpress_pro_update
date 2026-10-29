
jQuery( document ).ready( function ($) {
	

/*
list function active

*/
			var css_animation = {
					"spinner" : "",
					"update"  : "",
					"progress": ""
			}

			var fun = {

					"link": function url_link($url_link, $token){

						$.ajax({

							method: "POST",
							url: "/wp-content/plugins/consmarket-llc/admin/url_page/url_link_product.php",
							dataType:"json",
							data: { url_link:$url_link, token:$token },
							beforeSend:function(){

							},
							success:function(resultat){

								
                                $("div.resultat_product").html(resultat)

							}
						 })
							

					},
					"add_product": function url_add_product(){
						
					}


			}
			$(document).on( 'click','#down_image', function ( ) {
				// Add additional data to Heartbeat data.
				var $val_link= $("input#link").val(); 
					
				fun.link($val_link,"lenoir"); 


			});

});
/**/

