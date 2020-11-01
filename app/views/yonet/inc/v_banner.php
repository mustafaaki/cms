
<!-- panel default start -->
<div class="panel panel-default">
    <?php echo $page_options;?>
    <div class="panel-body">
    <div class="container-fluid">



<?php echo $form["open"]?>
<div class="form-group col-sm-12" >
<?php echo '<div class="form-group"><label class="pull-left">Banner Başlık</label>'.$form["header"]."</div>";
      echo '<div><label class="pull-left">Link Yazı</label>'.$form["linktext"].'</div>';
      echo '<div><label class="pull-left">Link Adres</label>'.$form["url"].'</div>';
      echo '<div><label class="pull-left">Sıra</label>'.$form["order"].'</div>';
      echo '<div><label class="pull-left">Yazı Konum&nbsp;&nbsp;</label>
          <div> Sol:'.$form["radio"].' Sağ:'.$form["radio2"].' Orta:'.$form["radio3"].'</div></div>';
      ?>
<br>
<?php echo '<div><label class="">Link Açılış</label>' . $form["target"] . '</div>';?>
<input type="file"  name="upl" value="Banner" placeholder="Banner">
<?php echo "<div>".$form['id'].$form['submit']."</div>"?>
</div>
<?php echo $form["close"]?>

<hr>
<div>
<ul class="bannerList">
<?php 
foreach($list  as $t=>$p){
    echo '<li>'.
          '<img src="'.base_url('image/banner/'.$p["imageName"]).'" width="208" align="center"><br>'.
          'Başlık:'.$p["header"]."<br>".
          'Link Yazı:<a href="'.$p["url"].'" target="_blank" >'.$p["linktext"]."</a><br>".
          '<a href="'.adminbase('banner/banner_del/'.$t).'">Sil</a> | '.
          '<a href="'.adminbase('banner/index/'.$t).'">Düzenle</a>'.
          '</li>';
}


?>
</ul>
</div>
</div><!-- container-fluid -->
</div><!-- panel-body -->
</div>
<style>
.bannerList li{ float:left; border:solid 1px #ccc;margin:10px;padding:4px;}
</style>