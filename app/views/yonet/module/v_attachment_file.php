<div class="form-group col-lg-12">
	<label class="col-lg-3 pull-left"><?php echo $header; ?></label>
	    <div class="form-group col-lg-6">
	            <input type="text" name="addSearchFile" class="form-control" id="add-search-file" placeholder="Atanacak resim için Anahtar Kelime"/>
	            <?php echo $form['id'].$form['typ']?>
        </div> 
        <div class="form-group col-lg-12" id="alertMsg"> </div>
        
        <div class="col-lg-12" id="add-search-file-list"></div>
        <div><hr></div>
        <div class="col-lg-12" id="file-list">
        <?php echo $file_list_html;?>
        </div>
        <div class="clear"></div>              
	
</div>


