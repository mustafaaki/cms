<!DOCTYPE html>
<html lang="<?php echo $this->user_lang ; ?>">
<head>
<title><?php echo $values["header"];?></title>
<meta charset="utf-8">
<base href="<?php echo base_url();?>">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="Safaria - Safari Responsive Themes" name="description">
<meta content="Codeopus" name="author">

<link href="<?php echo base_url('assets/stylesheets/css/bootstrap.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/stylesheets/css/font-family.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/stylesheets/css/global.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/stylesheets/css/style-'. $this->user_lang.'.css');?>" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Lobster|Anton|Lalezar" rel="stylesheet">

<link href="<?php echo base_url('assets/javascripts/slick/slick-theme.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/javascripts/slick/slick.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/fonts/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/stylesheets/css/effect-preloader.css');?>" rel="stylesheet" type="text/css">
<script src="<?php echo base_url('assets/javascripts/preloader/modernizr.custom.js');?>"></script>
<script>
var baseUrl = '<?php echo base_url();?>'; 
var pageLng = '<?php echo $this->user_lang;?>'; 
</script>
</head>
 <body class="demo-1">
<div class="ip-container" id="ip-container">  
<!--initial header-->
      <div class="ip-header" id="header">
        <div class="ip-loader">
          <img alt="preloader" class="img-center" src="img/site/preloader.gif"><svg class="ip-inner" height="60px" viewbox="0 0 80 80" width="60px"><path class="ip-loader-circlebg" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"></path><path class="ip-loader-circle" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z" id="ip-loader-circle"></path></svg>
        </div>
      </div>
    
<div class="ip-main">
<?php echo $header;?>
<?php echo $page;?>
<?php echo $footer; ?>
</div>
</div>

<script src="<?php echo base_url('assets/javascripts/jquery.js');?>"></script>
<script src="<?php echo base_url('assets/javascripts/bootstrap.js');?>"></script>
<script src="<?php echo base_url('assets/javascripts/custom.js');?>"></script>
<script src="<?php echo base_url('assets/javascripts/slick/slick.min.js');?>"></script>
<script src="<?php echo base_url('assets/javascripts/preloader/classie.js');?>"></script>
<script src="<?php echo base_url('assets/javascripts/preloader/pathLoader.js');?>"></script>
<script src="<?php echo base_url('assets/javascripts/preloader/main.js');?>"></script>
</body>
</html>
