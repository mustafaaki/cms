<!DOCTYPE html>
<html>
<head>
<title>Zensis Yönetici Giriş Paneli</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<base href="<?php echo base_url('yonet/')?>">
<link href="<?php echo base_url("css/yonet/bootstrap.min.css")?>" rel="stylesheet" id="bootstrap-css">
<link href="<?php echo base_url("css/yonet/bootstrap-select.min.css")?>" rel="stylesheet" id="bootstrap-css">
<link href="<?php echo base_url("css/yonet/side-bar.css")?>" rel="stylesheet" id="bootstrap-css">
<link href="<?php echo base_url("css/yonet/yonet.css")?>" rel="stylesheet" id="bootstrap-css">

<script src="<?php echo base_url("js/yonet/wysihtml5-0.3.0.min.js")?>"></script>
<script src="<?php echo base_url("js/yonet/jquery.js")?>"></script>
<script src="<?php echo base_url("js/yonet/bootstrap.min.js")?>"></script>
<script src="<?php echo base_url("js/yonet/bootstrap3-wysihtml5.js")?>"></script>
<script defer src="<?php echo base_url('js/yonet/font-awesome.js') ?>" ></script>   
<script>
var baseUrl='<?php echo base_url("yonet/");?>';
</script>



</head>
<body>
<?php echo $menu;?>
<div class="col-md-10 content">
<?php echo $page?>
</div>
<?php echo $footer;?>
<div class="popup">
	<span class="popup-btn-close">close</span>
	<div class="popup-html"></div>
</div>
<script type="text/javascript" src="<?php echo base_url("js/yonet/formValidation.js");?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/yonet/framework/bootstrap.js");?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/yonet/formValidationMy.js");?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/yonet/yonet.glob.js")?>"></script>  
</body>
</html>