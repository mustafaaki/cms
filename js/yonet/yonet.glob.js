	$("body").on('keyup','input[id*="json_order-menu"]',function(event) {
		idName=$(this).attr('id');
		idNameArr=idName.split('-');
		
		order = parseFloat($(this).val());
		$(this).val(order); 
	
		
		$.ajax({
	    	type: "POST",
	    	dataType:'html',
	    	url: baseUrl + "menu/order_update",
	    	data: 'order=' + order + '&id=' + idNameArr[2],
	    	success: function(msg) {
	    		//alert(msg);	    
	    	}
	    });
	
	});
	
	
	function map_save(){
		
		lat    = $('#map_lat').val();
		lon    = $('#map_lon').val();
		zoom   = $('#map_zoom').val();
		id     = $('#map_id').val();
		if( $('#map_pub').val()=='y' ){
			pub='y';
		}else{
			pub='n';
		}
		address = $('#pac-input').val();
		translate_page=$('#translate_page').val();
		page_id=$('#page_id').val();
		$.ajax({
	    	type: "POST",
	    	dataType:'html',
	    	url: baseUrl + "map/save",
	    	data: 'lat=' + lat + '&lon=' + lon + '&zoom=' + zoom + '&page_id=' + page_id +  '&id=' + id + '&pub=' + pub + '&translate_page=' + translate_page + '&address=' + address  ,
	    	success: function(msg) {
	    		
	    		  alert('Harita başarıyla kaydedildi');
	    	}
	    });
	}

	
	$("body").on('click','span[data*="delete-"]',function(event) {
		//alert($(this).attr('data'));
		object=$(this);
		idName=$(this).attr('data');
		idNameArr=idName.split('-');
		
		id = idNameArr[2];
		table = idNameArr[1];
		r = confirm("UYARI: Geri dönüşü olmayan silme işlemi,\nBu içeriği silmek istediğinizden eminmisiniz?");
		if(r != true)
			return false;
		$.ajax({
	    	type: "POST",
	    	dataType:'html',
	    	url: baseUrl + table + '/' + table+ '_delete',
	    	data: 'table=' + table + '&id=' + id,
	    	success: function(msg) {
	    		if(msg=="true"){
	    		/*icerigin bulundugu tag temizleniyor*/
	    			parentTagClose(1,object);
	    		}
	    			    
	    	}
	    });
	
	});

	
	
	function frmLoad( url, id  ,typ  ){
		url = baseUrl + url;
		
		$('.popup-html').html('');
		$.ajax({
	    	type: "POST",
	    	url: url,
	    	data: 'typ=' + typ +  "&id=" + id ,
	    	success: function(yanit) {
	          $('.popup-html').html(yanit);
	        }
		});	
	}
	

	

	
	/*master detail alanlarina ajaxla  veri isleme*/
	function pagecross() {
		url = baseUrl + "ajax/pagecross_proccess";
		frmData = $("#crossFrm").serialize();
		
		/*var masterId = [];
		$("#"+ frmName + ' #pageMultiple option').each(function(i) {
			if (this.selected == true) {
				masterId.push(this.value);	
			}
		});
		*/
		
		//detailId =$("#"+ frmName +" [name='detailId']").val();
		if(confirm("Bu işlemde alt kategori varsa onlarda beraber taşınacaktır.\nOnaylıyormusunuz?")){
		$.ajax({
	    	type: "POST",
	    	url: url,
	    	cache:false,
	    	data:frmData,
	    	success: function(yanit) {
	    		$('.popup-html').append(yanit);
	        }
		});
		}
	}
	

	
	
	
	
	 
    
    /*search file for page (img video doc)*/
    $("body").on('keyup','#add-search-file', function(){
	
		
		key = $("#add-search-file").val();
		id  = $('input:hidden[name=attachment-id]').val();
		typ = $('input:hidden[name=attachment-typ]').val();
		table = $('input:hidden[name=attachment-table]').val();
		len = key.length;
		
		searchUrl= baseUrl + "file/attachment_search";
		
		if(len>=3){
			$("#add-search-file-list").html('<img src="../img/admin/big-loader.gif">');
		    $.ajax({
	    	type: "POST",
	    	url: searchUrl,
	    	data: 'key='+ key + '&id=' + id  + '&typ=' + typ + '&table=' + typ,
	    	success: function(yanit) {
	    	  $("#add-search-file-list").empty();
	          $("#add-search-file-list").html(yanit);
	        }
		});	
		}else{
			 $("#add-search-file-list").html('');
		}
	});
    
    function setAttachmentFile(detail,master){
    	
    	
    	var searchUrl = baseUrl + 'file/add_attachment';
    	
    	$.ajax({
        	type: "POST",
        	url: searchUrl,
        	data: 'detail=' + detail + '&master=' + master,
        	success: function(yanit) {
        	  
              $("#file-list").prepend(yanit);
            }
    	});	
    	
    }
    
    function removeAttachmentFile(id,object){
    	var searchUrl = baseUrl + 'file/remove_attachment';
    	
    	$.ajax({
        	type: "POST",
        	url: searchUrl,
        	data: 'id=' + id ,
        	success: function(yanit) {
        	  
        	  parentTagClose(1,object);
        	  $("#alertMsg").html(yanit);
            }
    	});	
    	
    }
    /*search file for page END*/
  
	 
	
	/* Add search image for news*/
	/*search image for news*/
	$("#add-search-image").keyup(function() {
		
		key = $("#add-search-image").val();
		id  = $('input:hidden[name=id]').val();
		lng = $('input:hidden[name=lng]').val();
		len = key.length;
		
		searchUrl= baseUrl + "ajax/search_image_for_news";
		
		if(len>=3){
			$("#add-search-image-list").html('<img src="../img/admin/big-loader.gif">');
		    $.ajax({
	    	type: "POST",
	    	url: searchUrl,
	    	data: 'key='+ key + '&id=' + id + '&lng=' + lng,
	    	success: function(yanit) {
	    	  $("#add-search-image-list").empty();
	          $("#add-search-image-list").html(yanit);
	        }
		});	
		}else{
			 $("#add-search-image-list").html('');
		}
	});
	/*set image for news*/
	function setImageNews(id){
		url = $('.getImageId-' + id).attr('src');
		$("#add-search-image-list").html('<div class="selectedNewsImg"><b>Haber Resmi Seçildi</b><br><img src="' + url + '"></div>');
		$('input[name="img"]').val(id);   
	}	
	/*add search image for news END*/
	
	
	/*id = orderbox-table-id den olusan inputtaki veriyi ajaxla kaydeder*/
	$("body").on('keyup','input[data*="orderbox"]',function(event) {
		data=$(this).attr('data');
		dataArr=data.split('-');
		table =dataArr[1];
		order =$(this).val();
		id    =dataArr[2];
		var code = event.keyCode;
		order = parseInt(order);
		if(!isNaN(order)){
		    $(this).val(order);
		}else{
			order="";
		}
		
		if((code<106 && code>95) || (code>47 && code<58) || order==0){			
			$.ajax({
		    	type: "POST",
		    	dataType:'html',
		    	url: baseUrl + "ajax/list_order" ,
		    	data: 'id=' + id + "&table=" + table + "&order=" + order,
		    	success: function(msg) {
					
				}
		    });
	    }   
	});
	/*orderbox END*/
	
	/*publish - data pub verilerini  gunceller */
	 $("body").on('click','span[data*="publish"]', function(){
		 /*class=publish-y publish-n ve data=publish-tablename-id-pub */
		 data=$(this).attr('data');
		 dataArr=data.split('-');
			table = dataArr[1];
			id    = dataArr[2];
			pub   = dataArr[3];
			if(pub=="y"){
				newPub='n';
			}else{
				newPub='y';
			}
			//class adi ve data etiketi gelen veriye gore duzenleniyor
			$(this).removeClass().addClass('publish-' + newPub);
			$(this).attr('data','publish-' + table + '-' + id +'-' + newPub );
			//ajax ile veriler databasede degistiriliyor
		   $.ajax({
		    	type: "POST",
		    	dataType:'html',
		    	url: baseUrl + "ajax/publish_update" ,
		    	data: 'id=' + id + "&table=" + table + "&pub=" + newPub,
		    	success: function(msg) {
					
				}
		    });
	 });
	 /*publish - data pub verilerini  gunceller END*/
	

	 
	 
	/*position update*/
	$("body").on('change','select[class*="position-"]',function(event) {
		data=$(this).attr('class');
		dataArr=data.split('-');
		table =dataArr[1];
		position =$(this).val();
		id    =dataArr[2];
		$.ajax({
	    	type: "POST",
	    	dataType:'html',
	    	url: baseUrl + "ajax/position_update" ,
	    	data: 'id=' + id + "&position=" + position + "&table=" + table,
	    	success: function(msg) {
				
			}
	    });
	});
	/*position update END*/
	
	
	// Popup Window
	var scrollTop = '';
	var newHeight = '100';

	$(window).bind('scroll', function() {
	   scrollTop = $( window ).scrollTop();
	   newHeight = scrollTop + 100;
	});

	$('.popup-trigger').click(function(e) {
		 e.stopPropagation();
	 if(jQuery(window).width() < 767) {
	   $(this).after( $( ".popup" ) );
	   $('.popup').show().addClass('popup-mobile').css('top', 0);
	   $('html, body').animate({
			scrollTop: $('.popup').offset().top
		}, 500);
	 } else {
	   $('.popup').removeClass('popup-mobile').css('top', newHeight).toggle('500');
	 };
	});


	$('.popup-btn-close').click(function(e){
	  $('.popup').hide();
	});

	$('.popup').click(function(e){
	  e.stopPropagation();
	});
    // Popup window end
	
	/*image baglama vb. alanlarlarda ust ebeveyn sinifi kaldirir.*/
	function parentTagClose(step,object){
		/*0 icin parent, 1 icin grandparent, 2 icin greatparent.... alanini siler*/
		 object.parents(':eq('+ step +')').remove();
	}
	/*image baglama vb. alanlarlarda ust ebeveyn sinifi kaldirir. END */	