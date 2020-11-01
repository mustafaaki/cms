
<!-- panel default start -->
<div class="panel panel-default">
    <?php echo $page_options;?>
    <div class="panel-body">
    <div class="container-fluid">
             
             
            <?=$form["open"]?>
           
                <div class="form-group col-lg-12"><label class="col-sm-2" for="header">*Başlık</label>
                      <div class="col-sm-10"><?=$form["header"]?></div>
                 </div>  
                <div class="form-group col-lg-12"><label class="col-sm-2" for="title">*Pencere Başlık</label>
                      <div class="col-sm-10"><?=$form["name"]?></div>
                </div> 
                <div class="form-group col-lg-12"><label for="urladres" class="form-control-label col-sm-2" class="">*Sayfa Adres</label>
                      <div class="col-sm-10 urladres"><?=$form["url"]?></div>
                </div>
                <div class="form-group col-lg-12">
                   <div class="col-sm-4"><label>Anahtar Kelimeler</label>
                        <?=$form["key"]?>
                   </div>
                   <div class="col-sm-4"><label>Sayfa Açıklama</label>
                        <?=$form["desc"]?>
                    </div>
                    <div class="col-sm-4"><label>Etiketler</label>
                        <?=$form["tag"]?>
                    </div>
                </div>

                <div class="form-group col-lg-12">
                    <div class="col-sm-12">
                    <label>Kısa Metin (Max:500)</label>
                         <?=$form["content"];?>
                    </div>
                    <div class="col-sm-12" style="margin-top:30px;">
                    <label>İçerik Metni</label>
                      <?=$form["longtext"];?>
                    </div>
                </div>
                <div class="form-group col-lg-12" style="margin-top:25px;">
                        <div class="col-sm-3 ">
                            <?=$form["template"]?>
                        </div>
                       <div class="col-sm-3">
                            <label class="col-sm-3">Yayın</label>
                            <?=$form["pub"]?>
                        </div>
                       <div class="col-sm-3"><label  class="col-sm-3">İndex</label>
                            <?=$form["index"]?>
                       </div>
                       <div class="col-sm-3 pull-right">
                            <?=$form["lng"]?>
                            <?=$form["id"]?>
                            <?=$form["cuser"]?>
                            <?=$form["typ"]?>
                            <?=$form["language"]?>
                            <?=$form["button"]?>
                       </div>
                </div>
                <?=$form["close"]?>     
      </div>
      </div>
</div>
<!-- panel default end -->   
<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="../dist/summernote.js"></script>
<script>
      $('#summernote').summernote({
        placeholder: 'İçerik Metni',
        tabsize: 2,
        height: 300
      });
    </script>