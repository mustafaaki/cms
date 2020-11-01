  

	/*news image  arama listeleme */
	$("#addSearchImg").keyup(function() {
		searchKey=$("#addSearchImg").val();
		pageId=$("#pageId").val();
		
		len= searchKey.length;
		searchUrl= baseUrl + "ajax/add_img_list";
		
		if(len>=3){
			$("#addSearchImgList").html('<img src="../../image/admin/big-loader.gif"></div>');
			    $.ajax({
		    	type: "POST",
		    	url: searchUrl,
		    	data: 'key='+ searchKey + '&pageId=' + pageId,
		    	success: function(yanit) {
		    	  $("#addSearchImgList").empty();
		          $("#addSearchImgList").html(yanit);
		         
		        }
			});	
		}else{
			 $("#addSearchImgList").html('');
		}
	});
	/*news image resmi forma baglama */
	function setImage(id){
		url = $('.getImageId' + id).attr('src');
		$("#addSearchImgList").html('<div class="selectedNewsImg"><b>Haber Resmi Seçildi</b><br><img src="' + url + '"></div>');
		$('input[name="newsImg"]').val(id);   
	}