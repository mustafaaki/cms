<!DOCTYPE html>
<!-- Template by Quackit.com -->
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="http://localhost/dubaiataseligi/css/dropzone.css">


<script src="http://localhost/dosya/js/dropzone.js"></script>
<script type="text/javascript">

	var deleteid='x';
	var removeLinkObjNbr=-1;
	Dropzone.autoDiscover = true;
	if(typeof Dropzone != 'undefined')
	{
		 
		 
		 frmTarget = new Dropzone('#frmTarget',{
		    autoProcessQueue: false,
		    url: "<?php echo base_url('yonet/file/upload')?>",
			parallelUploads: 20,
			maxFileSize: 50,
			createImageThumbnails: true,
			acceptedFiles: ".pdf,.jpg,.png,.gif,.doc,.docx,.xls,",
			dictDefaultMessage: "<strong>Dosyaları sürükle yada tıklayarak seç <br>(Çoklu yada tekli seçim). </strong>",
			addRemoveLinks: function(response){
				  
			},
			removedfile: function(file){
				removeLinkObjNbr = removeLinkObjNbr - 1;
				deleteid = file._removeLink['attributes']['data-dz-remove']['nodeValue'];
				alert(deleteid);
				$.ajax({
					
					url: '<?php echo base_url( "yonet/file/deleteid" );?>',
					type: 'POST',
					data: "id=" + deleteid,
					success: function(data) {
					    alert(data);
					}
				});

				
				var _ref;
				return(_ref = file.previewElement) != null
					? _ref.parentNode.removeChild(file.previewElement)
					: void 0;
			},
			init: function ( file, response ) {
			       var myDropzone = this;
			        // if autoProcessQueue value is false ,  
			       $("#buttonsubmit").click(function (e) {
			           e.preventDefault();
			           myDropzone.processQueue();
			       });
			       this.on('sending', function(file, xhr, formData) {
			            // Append all form inputs to the formData Dropzone will POST
			    	    var data = $('#frmTarget').serializeArray();
			            $.each(data, function(key, el) {
			                formData.append(el.name, el.value);
			            });
			       });
			    },
			    success: function( file, response ){
			       obj = JSON.parse(response);
			       removeLinkObjNbr = parseInt(removeLinkObjNbr + 1);

			       if(obj['error'] != false){
	        		       $( ".dz-remove" ).eq(removeLinkObjNbr).attr('data-dz-remove',obj['fileid']);
	        		       $( ".dz-filename span" ).eq(removeLinkObjNbr).html(obj['filename']);
			          
			       }else{
			    	    alert('yükleme hatası');
			       } 
			    }
		});
	}

</script>
</head>
<h5>Resim ve Dosya Yükle</h5>
<!-- Change /upload-target to your upload address -->
  <div class="row">
         <div class="col-sm-12">
         <div class="tab">
                 <?php echo '<button id="lngbutton" class="tablinks" onclick="openTabLng(event, \'tab-'.$this->session->userdata("activeLng")["alias"].'\')">'.img($this->session->userdata("activeLng")["flag"]).$this->session->userdata("activeLng")["name"].'</button>';?>
                 
                 <?php foreach($this->session->userdata("deactiveLng") as $imgLng=>$lngVal){
                     echo '<button id="lngbutton" class="tablinks" onclick="openTabLng(event, \'tab-'.$lngVal["alias"].'\')">'.$lngVal["name"].img($lngVal["flag"]).'</button>';
                 }
                 ?>
             </div>
             <form id='frmTarget' name='dropzone' action="<?php echo base_url('yonet/file/upload')?>"  class='dropzone' method="POST">
             <input type="hidden" name="page_id" value="<?=$pageId?>">
             <?php
              echo '<div id="tab-'.$this->session->userdata("activeLng")["alias"].'" class="tabcontent form-group col-lg-12 active" style="display:block">';
              echo '<div class="col-sm-12"><label class="col-sm-2">Başlık('.$this->session->userdata("activeLng")["alias"].')</label>'.
              '<div class="col-sm-9"><input type="text" name="header-'.$this->session->userdata("activeLng")["alias"].'" class="form-control"></div></div>';
              echo '<div class="col-sm-12"><label class="col-sm-2">Metin</label><div class="col-sm-9"><input type="text" name="content-'.$this->session->userdata("activeLng")["alias"].'" class="form-control"></div></div>';
              echo '<div class="col-sm-12"><label class="col-sm-2">Tag</label><div class="col-sm-9"><input type="text" name="tag-'.$this->session->userdata("activeLng")["alias"].'" class="form-control"></div></div>';
              echo '</div>';
              
              foreach($this->session->userdata("deactiveLng") as $imgLng=>$lngVal){
                echo '<div id="tab-'.$lngVal["alias"].'" class="tabcontent form-group col-sm-12">';
                echo '<div class="col-sm-12"><label class="col-sm-2">Başlık('.$lngVal["alias"].')</label><div class="col-sm-9"><input type="text" name="header-'.$lngVal["alias"].'" class="form-control"></div></div>';
                echo '<div class="col-sm-12"><label class="col-sm-2">Metin</label><div class="col-sm-9"><input type="text" name="content-'.$lngVal["alias"].'" class="form-control"></div></div>';
                echo '<div class="col-sm-12"><label class="col-sm-2">Tag</label><div class="col-sm-9"><input type="text" name="tag-'.$lngVal["alias"].'" class="form-control"></div></div>';
                echo '</div>';
              }
              ?>
              <button type="submit" id="buttonsubmit" class="btn btn-primary" style="display:block;position: right;margin-bottom:0px;">Kaydet</button>  
              </form>
         </div>  
    </div>
    
      
<script type="text/javascript">
function openTabLng(evt, imageTextTagName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(imageTextTagName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>