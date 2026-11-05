jQuery( document ).ready( function ($) {
	

/*
list function active

*/

/*
        const triggerTabList = document.querySelectorAll('#myTab button')
        triggerTabList.forEach(triggerEl => {
        const tabTrigger = new bootstrap.Tab(triggerEl)

        triggerEl.addEventListener('click', event => {
        event.preventDefault()
        tabTrigger.show()
        })
        })
*/
            $('#myTab button').on('click', function (e) {
                    e.preventDefault();
                    $(this).tab('show');
            });

			var css_animation = {
					"spinner" : '<span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>',
					"update"  : "",
					"progress": ""
			}


			var fun = {
                     "url_page_nav":function url_nav(nav){
 
                    $.ajax({

                    method: "POST",
                    url: "/wp-content/plugins/consmarket-llc/admin/url_page/url_page_nav.php",
                    dataType:"json",
                    data: { nav:nav },
                    beforeSend:function(){
                        $("div.resultat_product").html(css_animation.spinner)
                    },
                        success:function(resultat){

                        $("div.resultat_product").html(resultat)

                        }


                        })
                     }, 

                        "link": function url_link($url_link, $token,this_btn,font_type){
                        $.ajax({
                        method: "POST",
                        url: "/wp-content/plugins/consmarket-llc/admin/url_page/url_link_product.php",
                        dataType:"json",
                        data: { url_link:$url_link, token_type:$token },
                        beforeSend:function(){
                            this_btn.html(css_animation.spinner)
                            $("input#link").addClass('disabled')
                        },
                        success:function(resultat){
                                    
                        this_btn.html( font_type )
                        $("input#link").removeClass('disabled').val("")

                        var all_product="";
                        all_product+=fun.ae_item_base_info_dto(resultat['rs_product']['result']['ae_item_base_info_dto'],resultat['woo_id'] ,resultat['id_product'],resultat['active'])
                        all_product+=fun.ae_multimedia_info_dto(resultat['rs_product']['result'])
                        all_product+=fun.ae_item_sku_info_d_t_o(resultat['rs_product']['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o'])
                 
                       var myModal = new bootstrap.Modal($('#exampleModalToggle'));
                              myModal.show(); 
                        $("div.modal-body").html(all_product)
                            if(resultat['active']==0){
                        fun.list_product_active(resultat['active']);   
                               }
                        }
                        })
							  

					},
                       'all_update_sync':function envoyerRequete(woo_id,id,product,btn_this,type_update_val) {
                            return $.ajax({
                                method: "POST",
                                url: "/wp-content/plugins/consmarket-llc/admin/url_controler/url_woocommerce_api/url_update_product.php",
                                dataType:"json",
                                data: {id_product_woo:woo_id,id_product_active:id,product:product,type_update:type_update_val},
                                statusCode: {
                                500: function() {

                               var myModal = new bootstrap.Modal($('#exampleModalToggle')[0]);
                               myModal.show(); 
                                $("div.modal-body").html("This product can't function or is already exist in the databass!!!  </br>"+
                                "Try again if is't pass, delete the product on the list and add again on the list Thank you. </br>" +
                                'Delete The product <button type="button" class="btn btn-danger btn-sm control-form delete_product"  id_p="'+id_p+'"  product="'+product_id_ali+'"><i class="fa-solid fa-trash"></i></button>' )
                                $("div.update"+id).addClass("border border-danger shadow-lg m-0")
                                btn_this.html('<i class="fa-solid fa-arrows-rotate"></i>').removeClass('disabled');
                                }

                                },
                                beforeSend:function(){
                                btn_this.html(css_animation.spinner).addClass('disabled');

                                },
                                success:function(resultat){
                            if(resultat['code']==200){
                                 if(type_update_val=="Productupdate"){
                               
                                $("div.update"+id).addClass("border border-success shadow-lg m-0")
                                btn_this.html('<i class="fa-solid fa-arrows-rotate"></i>').removeClass('disabled');

                                }else if(type_update_val=="ProductInsert"){
                               
                                $('div.update'+id).addClass("border border-success shadow-lg m-0")
                                $('div.card'+id).fadeOut(3000, "linear").remove()
                                 //fun.list_product_active(0); 
                            

                                }
                                    }
                                }
                            })
                            
                        },
                    "all_update":async function envoyerEnSequence(tableau,n_this,type_update) {
                        console.log("Début de l'envoi séquentiel...");

                        for (const [key, value] of tableau.entries()) {
                        try {
                        console.log("Envoi en cours pour l'élément:"+ value.id);

                        // Attend la réponse AJAX avant de continuer la boucle
                        const reponse = await fun.all_update_sync(value.woo_id,value.id,value.product,n_this,type_update); 
                        var progress= ((key+1)*100)/tableau.length
                        $("div.progress").attr('aria-valuenow',progress); 
                        $("div.progress-bar").attr("style","width:"+progress+"%").html(progress.toFixed(2)+"%"); 
                        console.log("Succès pour l'élément"+value.id+' Réponse :'+ reponse +"----"+progress);
                        } catch (erreur) {

                        console.error("Échec pour l'élément"+ value.id+"Erreur :"+ erreur);
                        // Optionnel : vous pouvez ajouter un 'break;' ici si vous voulez stopper 
                        // tout le processus dès qu'une requête échoue.
                        }

                        }
                        
                        fun.list_product_active(0); 
                       // n_this.html('<i class="fa-solid fa-arrows-rotate"></i>').removeClass('disabled');
                        },
                    "all_update_product":function all_product_woo_product(id_product_woo,id_product_active,product,btn_this,type_update){

						$.ajax({

							method: "POST",
							url: "/wp-content/plugins/consmarket-llc/admin/url_controler/url_woocommerce_api/url_update_product.php",
							dataType:"json",
							data: {id_product_woo:id_product_woo,id_product_active:id_product_active,product:product,type_update:type_update},
                            statusCode: {
                            500: function() {

                            var myModal = new bootstrap.Modal($('#exampleModalToggle')[0]);
                            myModal.show(); 
                            $("div.modal-body").html("This product can't function or is already exist in the databass!!!  </br>"+
                            "Try again if is't pass, delete the product on the list and add again on the list Thank you. </br>" +
                            'Delete The product <button type="button" class="btn btn-danger btn-sm control-form delete_product"  id_p="'+id_p+'"  product="'+product_id_ali+'"><i class="fa-solid fa-trash"></i></button>' )

                            btn_this.html('<i class="fa-solid fa-check"></i>').removeClass('disabled');
                            }

                            },
							beforeSend:function(){
                               btn_this.html(css_animation.spinner).addClass('disabled');
                                
							},
							success:function(resultat){

                                if(resultat['code']==200){
                            if(type_update=="Productupdate"){
                                $("div.update"+id_product_active).addClass("border border-success shadow-lg m-0")
                                btn_this.html('<i class="fa-solid fa-arrows-rotate"></i>').removeClass('disabled');

                                }else if(type_update=="ProductInsert"){
                                    $('div.card'+id_product_active).addClass("border border-success shadow-lg m-0").fadeOut(6000,"slow").remove()
                                  //  fun.list_product_active(0);  
                                }
                          }
                        
                        }
						 })
                    },
                    "delete": function url_delete($url_link, id_p , $token,d_this){

						$.ajax({

							method: "POST",
							url: "/wp-content/plugins/consmarket-llc/admin/url_page/url_link_delete.php",
							dataType:"json",
							data: { url_link:$url_link, token:$token , id_product:id_p},
							beforeSend:function(){
                                  d_this.html(css_animation.spinner)
							},
							success:function(resultat){

                                if(resultat['code']=='200'){
                                    var myModal = new bootstrap.Modal($('#exampleModalToggle')[0]);
                       
                                   myModal.hide(); 
                                    $("div."+resultat['rs_delete']).fadeOut( "slow" ).remove()
                                   
                                }
                
					    	}
						 })
							

					},
					"add_product": function url_add_product(product){
						
                        
					},
                    "ae_item_sku_info_d_t_o": function rs_sku_info(result_sku_info){
                        // result ['result']['ae_item_sku_info_dtos']['ae_item_sku_info_d_t_o']

                    var c= result_sku_info.length;
                    var info_sku= ""; 

                        info_sku +='<div class="accordion" id="accordionExample"> '; 
                         
                        
                        var array_image =[]; 
                  for(var i=0; i<c; i++){

                        info_sku +='<div class="accordion-item">';
                        info_sku +='<h2 class="accordion-header">';
                        info_sku +='<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'+result_sku_info[i]['sku_id']+'" aria-expanded="false" aria-controls="collapse'+result_sku_info[i]['sku_id']+'">'
                        info_sku +='<div class="text-left">'
    
                        info_sku +='<div class="input-group input-group-sm mb-3"><span class="input-group-text" id="inputGroup-sizing-sm">SKU :</span> '+'<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="'+result_sku_info[i]['sku_id']+'"> </div>'
                        info_sku +='</div> </button> </h5>';
                        info_sku += '<div id="collapse'+result_sku_info[i]['sku_id']+'" class="accordion-collapse collapse " data-bs-parent="#accordionExample">'

                        info_sku += '<div class="accordion-body">'

                            var c1= result_sku_info[i]['ae_sku_property_dtos']['ae_sku_property_d_t_o'].length
                            var rs_c1= result_sku_info[i]['ae_sku_property_dtos']['ae_sku_property_d_t_o']
                            info_sku +='<table class="table table-success table-striped-columns">'
                            info_sku +='<thead>    <tr>'

                            for (var i1=0; i1<c1; i1++){
                 
                            info_sku +='   <tr>'
                            info_sku += '<img src="'+rs_c1[i1]['sku_image']+'" width="100" height="100" class="rounded" alt=" '+rs_c1[i1]['sku_property_value']+'">'
                            info_sku +='<th scope="col">'+rs_c1[i1]['sku_property_value']+'+</th>'  
                            info_sku += ' </tr> '

                            }
                            info_sku += ' </tr>  </thead>'
                            info_sku += '<tbody>    <tr>'
                            for (var i1=0; i1<c1; i1++){
                            info_sku += '  <tr>'
                            info_sku += '<th scope="row">'+i1+'</th>'
                            info_sku += '</tr>'

                            }
                              info_sku += '</tr></tbody>'
                              info_sku +='</table>'
                        info_sku +=' </div></div></div>'; 
                      }  //and balise for  
                    
                      return info_sku; 
                    },
                    ae_multimedia_info_dto: function multimedia(result){

                        // result ['result']['ae_multimedia_info_dto']
                            var rs_multimedia= '<div class="container-sm  m-2 p-2">'
                             rs_multimedia+=' <div class="row">'
                             if(result['ae_multimedia_info_dto']['ae_video_dtos']!== undefined){
                             rs_multimedia+='<div class="col m-2  shadow-sm">'
                             //rs_multimedia+=result['ae_multimedia_info_dto']['ae_video_dtos']['ae_video_d_t_o'][0]['media_status']
                             //rs_multimedia+=result['ae_multimedia_info_dto']['ae_video_dtos']['ae_video_d_t_o'][0]['media_type']
                             //rs_multimedia+=result['ae_multimedia_info_dto']['ae_video_dtos']['ae_video_d_t_o'][0]['poster_url']
                             rs_multimedia+='<div class="ratio ratio-16x9"><iframe src="'+result['ae_multimedia_info_dto']['ae_video_dtos']['ae_video_d_t_o'][0]['media_url']+'" title="YouTube video" allowfullscreen></iframe></div>'
                             rs_multimedia+='</div>'}
                             rs_multimedia+='<div class="col m-2 shadow-sm p-2">'

                             var strArray = result['ae_multimedia_info_dto']['image_urls'].split(";");
                            // rs_multimedia+=result['ae_multimedia_info_dto']['image_urls']
                            //rs_multimedia+='<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel"><div class="carousel-inner">    <div class="carousel-item active">'


                             rs_multimedia+= '<div id="carouselExampleDark" class="carousel carousel-dark slide ">'
                             rs_multimedia+='<div class="carousel-indicators">'
                             for(var i = 0; i < strArray.length; i++){
                                               
                           if(i==0){
                                                 rs_multimedia+='<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="'+i+'" class="active" aria-current="true" aria-label="Slide '+i+'"></button>'
                            }else{
                                                 rs_multimedia+='<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="'+i+'" aria-label="Slide '+i+'"></button>'
                            }
  
                                                    
                                                   
                        }       
                             rs_multimedia+='</div>'
                             rs_multimedia+=' <div class="carousel-inner">'
                                for(var i = 0; i < strArray.length; i++){
                            if(i==0){
                                                    rs_multimedia+='<div class="carousel-item active" data-bs-interval="20">'
                                                    rs_multimedia+='<img src="'+strArray[i]+'" class="d-block w-100 rounded" alt="...">'
                                                    rs_multimedia+=' </div>'
                            }else{
                                                    rs_multimedia+='<div class="carousel-item" data-bs-interval="20">'
                                                    rs_multimedia+='<img src="'+strArray[i]+'" class="d-block w-100 rounded" alt="...">'
                                                    rs_multimedia+=' </div> '
                                                    
                            }
                             

                             }
                                            rs_multimedia+=' </div> '
                                            rs_multimedia+='<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">'
                                            rs_multimedia+='<span class="carousel-control-prev-icon" aria-hidden="true"></span>'
                                            rs_multimedia+= '<span class="visually-hidden">Previous</span>  </button>'
                                            rs_multimedia+='<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">'
                                            rs_multimedia+='<span class="carousel-control-next-icon" aria-hidden="true"></span>'
                                            rs_multimedia+='<span class="visually-hidden">Next</span>  </button>'
                             rs_multimedia+=' </div></div></div></div>' 

                          return rs_multimedia; 

                    }, 
                    package_info_dto: function package_info(){
                        // result ['result']['package_info_dto']

                    },
                    logistics_info_dto: function info_delivery (){
                    
                    },
                    product_id_converter_result: function product_id_main(){

                    },
                    ae_item_base_info_dto: function detail_product(result,woo_id ,id_p,active){

                        if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
                        tinyMCE.execCommand("mceAddControl", false, "textareatext");}
            

                        var detail= '<div class="mb-3">'
                        detail+='<label for="exampleFormControlInput1" class="form-label">Product ID : '+result['product_id']+' --- Link Product: <a href="https://www.aliexpress.us/item/'+result['product_id']+'.html" target="_blank"> https://www.aliexpress.us/item/'+result['product_id']+'.html </a> </label>'
                        if(active!=1){
                        detail+=' <div class="btn-group text-end"><button type="button" class="btn btn-primary btn-sm control-form active_product"  id_p="" id_product_woo="'+woo_id+'" active="'+active+'"  product="'+result['product_id']+'"><i class="fa-solid fa-check"></i></button>'
                        }
                        detail+= '<button type="button" class="btn btn-danger btn-sm control-form delete_product" id_product_woo="'+woo_id+'" id_p="'+id_p+'"   product="'+result['product_id']+'"><i class="fa-solid fa-trash"></i></button></div>'
                        detail+='</br><label for="exampleFormControlInput1" class="form-label">Detail : </label>'
                        detail+=' <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Mini description" value="'+result['subject']+'"></div>'

                        detail+='<div class="mb-3">'
                        detail+='<label for="exampleFormControlTextarea1" class="form-label mceEditor">Description</label>'
                        detail+='<textarea class="form-control" id="textareatext" rows="10" value="">'+result['detail']+'</textarea>'
                        detail+='</div>'

                        return detail; 
                    },
                    has_wole_sales: "",
                    ea_item_properties: function properties(){

                    },
                    ae_store_info: function store_info(){

                    }, 
                    pagination: function u_pagination(n_page,v1,v2,active,next){

                        
						$.ajax({

							method: "POST",
							url: "/wp-content/plugins/consmarket-llc/admin/url_f_controle/url_pagination.php",
							dataType:"json",
							data: { p:n_page,v1:v1,v2:v2,active:active, next:next},
							beforeSend:function(){
                                  $("div.rs_u_pagination").html(css_animation.spinner);
							},
							success:function(resultat){

                                    $("div.rs_u_pagination").html(resultat['page_url']);

							}
						 })
							

                    },update_categories: function u_update(id_product_woo,category_id,id_product_active,product,btn_this ){

                        
						$.ajax({

							method: "POST",
							url: "/wp-content/plugins/consmarket-llc/admin/url_controler/url_woocommerce_api/url_update_categories.php",
							dataType:"json",
							data: {id_product_woo:id_product_woo,category_id:category_id,id_product_active:id_product_active, product:product},
							 statusCode: {
                                500: function() {
                                var myModal = new bootstrap.Modal($('#exampleModalToggle')[0]);
                               myModal.show(); 
                                $("div.modal-body").html("Go to update on the Edit or realod the product!!!" );

                                btn_this.html('update categories <i class="fa-solid fa-arrows-rotate"></i>')
                                .removeClass('disabled')
                                .addClass('btn-danger')
                                .removeClass('btn-success');
                                }
                               
                                },
                            beforeSend:function(){
                                 btn_this.html(css_animation.spinner);
							},
							success:function(resultat){

                                    $("div.update_categories"+id_product_active).html(resultat['update_categories']);

							}
						 })
							

                    }
                    , pagination_search: function search_pagination(sku,active,btn_this){

                        
						$.ajax({

							method: "POST",
							url: "/wp-content/plugins/consmarket-llc/admin/url_controler/url_woocommerce_api/url_search_product.php",
							dataType:"json",
							data: { type:'search_product',sku:sku,active:active},
							beforeSend:function(){
                                  btn_this.html(css_animation.spinner);
                                  $("input.search_product_input").addClass("disabled")
							},
							success:function(resultat){

                                   var myModal = new bootstrap.Modal($('#exampleModalToggle')[0]);
                               myModal.show(); 
                                $("div.modal-body").html(resultat['result'] )
                                 btn_this.html('<i class="fa-solid fa-magnifying-glass"></i>');
                                  $("input.search_product_input").removeClass("disabled")
							}
						 })
							

                    },
                    list_product_active:function product_active(active){
                        $.ajax({

							method: "POST",
							url: "/wp-content/plugins/consmarket-llc/admin/url_f_controle/url_pagination.php",
							dataType:"json",
							data: { active:active},
							beforeSend:function(){
                                  $("div.rs_u_pagination").html(css_animation.spinner);
							},
							success:function(resultat){

                                    $("div.rs_u_pagination").html(resultat['page_url']);

							}
						 })
                    },

                    rsp_code:"",
                    rsp_msg:"", 
                    request_id:"",
                    _trace_id_:"",
                    add_product_woo: function woo_add_product(product_id_ali,id_p,ac_this){
                           
						$.ajax({

							method: "POST",
							url: "/wp-content/plugins/consmarket-llc/admin/url_controler/url_woocommerce_api/ur_product_api.php",
							dataType:"json",
							data: { product_id_ali:product_id_ali},
                                statusCode: {
                                500: function() {
                                var myModal = new bootstrap.Modal($('#exampleModalToggle')[0]);
                               myModal.show(); 
                                $("div.modal-body").html("This product can't function or is already exist in the databass!!!  </br>"+
                                "Try again if is't pass, delete the product on the list and add again on the list Thank you. </br>" +
                                'Delete The product <button type="button" class="btn btn-danger btn-sm control-form delete_product"  id_p="'+id_p+'"  product="'+product_id_ali+'"><i class="fa-solid fa-trash"></i></button>' )

                                ac_this.html('<i class="fa-solid fa-check"></i>').removeClass('disabled');
                                }
                               
                                },
							beforeSend:function(){
                                ac_this.html(css_animation.spinner).addClass('disabled');
                                
							},
							success:function(resultat){
                                if(resultat['code']==200){
                              
                                window.location.href = resultat['url_edit']; 
                           
                             }
							}
						 })
							
                    }



			}

            var fun_token ={
                f_token: function token_generate(type_token, this_btn){

                    $.ajax({

                            method: "POST",
                           // url: "/wp-content/plugins/consmarket-llc/admin/url_controler/url_controler_token.php",
                           url: "/wp-content/plugins/consmarket-llc/admin/url_page/url_link_product.php",
                            dataType:"json",
                            data: { token_type:type_token },
                          
                            beforeSend:function(){
                                   this_btn.html(css_animation.spinner);
                            },
                            success:function(resultat){
                               if(resultat['type']=="ActiveCode"){
                                 window.location.href = resultat['url_auth'];
                               }
                                 if(resultat['type']=="GenerateToken"){
                                 var myModal = new bootstrap.Modal($('#exampleModalToggle')[0]);
                               myModal.show(); 
                                   $("div.modal-body").html("New Token is : "+ resultat['Token']); 
                               }
                            }


                    })

                    }
              }

			$(document).on( 'click','#down_image', function ( ) {
				// Add additional data to Heartbeat data.
				var $val_link= $("input#link").val(); 
				var $btn_this=$(this)
				fun.link($val_link,"ProductGet",$btn_this,'<i class="fa-solid fa-download"></i> Download'); 

	
			});

            $(document).on( 'click','button#token', function ( ) {
				// Add additional data to Heartbeat data.
				var attr_type = $(this).attr('type_token');
		        var btn_this = $(this); 
                    fun_token.f_token(attr_type,btn_this);

			});

               $(document).on( 'click','button.n_pagination', function ( ) {
				// function pagination
				var attr_p = $(this).attr('p');
				var attr_v1 = $(this).attr('v1');
				var attr_v2 = $(this).attr('v2');
				var attr_next= $(this).attr('next');
				var attr_active = $(this).attr('active');
	            fun.pagination(attr_p,attr_v1,attr_v2,attr_active,attr_next);

			});
            
                $(document).on( 'click','button.edit_product', function ( ) {
				// function pagination
				var attr_product = $(this).attr('product');
                var btn_this= $(this)
				fun.link(attr_product,"ProductGet",btn_this,' <i class="fa-solid fa-bars"></i> ');   
			});    
            $(document).on( 'click','button.consult_product', function ( ) {
				// function pagination
				var attr_woo_id= $(this).attr('id_product_woo');
				var hostname =  $(location).attr('hostname');//https://example.com

                var rt_link = '/wp-admin/post.php?post='+attr_woo_id+'&action=edit';
                  window.location.href = rt_link ;

                  
			});
                $(document).on( 'click','button.delete_product', function ( ) {
				// function pagination
				var attr_product = $(this).attr('product');
				var attr_id_p = $(this).attr('id_p');
                var d_this =$(this);  
                var confirme= prompt("Confirme (yes)");
                if(confirme=='yes'){
                fun.delete(attr_product,attr_id_p,"delete",d_this); 
                }else{
                alert("Sorry try again !!!")
                }
			});

            $(document).on( 'click','button.active_product', function ( ) {
            // function pagination
          /*  var attr_product = $(this).attr('product');
            var attr_id_p = $(this).attr('id_p');
            var ac_this =$(this);  
            fun.add_product_woo(attr_product,attr_id_p,ac_this);   
                */
             // function active or inactive product 
            var attr_this = $(this);
            var attr_id_product_woo = $(this).attr('id_product_woo')
            var attr_id_product_active= $(this).attr('id_p');
            var attr_product= $(this).attr('product');
            fun.all_update_product(attr_id_product_woo,attr_id_product_active,attr_product,attr_this,"ProductInsert" );
            });

            $(document).on( 'click','button.update_categories', function ( ) {
            // function active or inactive product 
            var attr_this = $(this);
            var attr_id_product_woo = $(this).attr('id_product_woo');
            var attr_category_id= $(this).attr('category_id');
            var attr_id_product_active= $(this).attr('id_product_active');
            var attr_product= $(this).attr('product');

            fun.update_categories(attr_id_product_woo,attr_category_id,attr_id_product_active,attr_product,attr_this );   
            });

             $(document).on( 'click','button.all_update_product', function ( ) {
            // function active or inactive product 
            var attr_this = $(this);
            var attr_type_update = $(this).attr('type_update');
            var attr_id_product_woo = $(this).attr('id_product_woo')
            var attr_id_product_active= $(this).attr('id_p');
            var attr_product= $(this).attr('product');
            fun.all_update_product(attr_id_product_woo,attr_id_product_active,attr_product,attr_this,attr_type_update );
            });

           $(document).on( 'click','button.update_all', function ( ) {
            // function active or inactive product 
            var attr_this = $(this);
            var attr_type_update = $(this).attr('type_update');
            var attr_option =  $('select.update_option option:selected').val()
            var obj = jQuery.parseJSON( attr_option  );
            var count_obj = obj.length
            fun.all_update(obj,attr_this,attr_type_update);
            });
            $(document).on( 'click','button.update_all_page', function ( ) {
            // function active or inactive product 
            var attr_this = $(this);
            var attr_type_update = $(this).attr('type_update');
            var attr_option =  $('select.update_option_page option:selected').val()
            var obj = jQuery.parseJSON( attr_option  );
            var count_obj = obj.length
            fun.all_update(obj,attr_this,attr_type_update);
            });

            $(document).on( 'click','button.product_status', function ( ) {
            // function active or inactive product 
            var attr_active = $(this).attr('active');
            fun.list_product_active(attr_active);   
            });

            $(document).on( 'click','button.search_product', function ( ) {
            // function active or inactive product 
            var attr_active = $(this).attr('active');
            var rs_val_sku = $("input.search_product_input").val(); 

            var btn_t = $(this); 
            fun.pagination_search(rs_val_sku,attr_active, btn_t);    
            //fun.list_product_active(attr_active);   
            });

             $(document).on( 'click', "select.pagination option:selected", function ( ) {
            // function active or inactive product 
            var attr_p = $(this).attr('p');
            var attr_v1 = $(this).attr('v1');
            var attr_v2 = $(this).attr('v2');
            var attr_next= $(this).attr('next');
            var attr_active = $(this).attr('active');
            fun.pagination(attr_p,attr_v1,attr_v2,attr_active,attr_next);
            });
            


    

});
/**/
