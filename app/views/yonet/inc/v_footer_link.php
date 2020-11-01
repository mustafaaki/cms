<!-- panel default start -->
<div class="panel panel-default">
     <?php  echo $page_options;	?>
    <div class="panel-body">
    <div class="container-fluid">
<?php   echo $formCat['open'];?>
<div class="form-group col-sm-12">
    <b><?php echo $catTitle?></b><br>
    <?  
        echo '<div class="form-group"><label>Kategori Adı</label>'.$formCat['name'].'</div>';
        echo '<div class="form-group"><label>Sırası</label>'.$formCat['order'].'</div>';
    ?>
    <br>
    <?php echo '<div>'.$formCat['catId'].$formCat['submit'].'</div>';?>
</div>
<?php echo $formCat['close'] ?> 

<div class="form-group col-sm-12">
<b>Footer Kategori Listesi</b><br>
    <?php 
    foreach($footerCatList  as $x=>$y){
        $selectedLine = '';
        $duzenleLink  = '<a href="'.adminbase('footer/link_cat/'.$x).'">'.$y['name'].'</a>';
        if($catId==$x){
            $selectedLine='selectedLine';
            
            $linkName=$y['name'];
        }
        
        echo '<div class="'.$selectedLine.'"><span class="footerCatLink">'.$duzenleLink.'</span><span class="footerCatOrder">'.$y["order"].'</span>'.
        '<span class="footerCatEdit"><a  href="' . adminbase("footer/link_cat/".$x) . '">'.'<img src="'.base_url("img/icon/small-content.png").'"></a></span>'.
        '<span class="footerCatEdit"><a  href="' . adminbase("footer/cat_delete/".$x) . '">'.'<img src="'.base_url("img/icon/delete-red.png").'"></a></span></div>';
        
    }
    ?>
    
</div>
<div class="form-group col-sm-12"><br>
<b><?php echo $footerCatList[$catId]["name"]?> isimli kategori altındaki bağlı linkler</b>
    <?php 
    foreach ($footerCatList[$catId]["footerLinks"] as $p=>$m) { 
        echo "<div><span class=\"footerCatLink\">".$m["urlName"].'</span><span class="footerCatOrder">'.$y["order"].'</span>'.
            '<span class="footerCatEdit"><a  href="' . adminbase("footer/link_cat/".$x."/".$p) . '">'.'<img src="'.base_url("img/icon/small-content.png").'"></a></span>'.
        '<span class="footerCatEdit"><a  href="' . adminbase("footer/link_delete/".$catId."/".$p) . '">'.'<img src="'.base_url("img/icon/delete-red.png").'"></a></span></div>';
    
    }?>

</div>

<?php if($catId!=""){ ?>
<hr  class="style-line">
<div class="footerLinkCatContainer">
<b><?php echo $linkName ?> Link Grubuna Link Oluşturun</b>
<?php echo $form["open"]?>
<?php echo '<div><label class="">Link Adı</label>'.$form["name"].'</div>';?>
<?php echo '<div><label class="">Link Adres</label>'.$form["url"].'</div>';?>
<?php echo '<div><label class="">Link Sıra</label>'.$form["order"].'</div>';?>
<?php echo '<div><label class="">Link Konum</label>' . $form["target"].'</div>';?>
<?php echo '<div>'.$form['catId'].$form['linkId'].$formCat['submit'].'</div>';?>

<?php }?>
</div>

</div>
</div>
</div><!-- panel default end -->