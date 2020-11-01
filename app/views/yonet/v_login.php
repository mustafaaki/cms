<!DOCTYPE html>
<html>
    <head>
    <title>Zensis Yönetici Giriş Paneli</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="<?php echo base_url('yonet/')?>">
    <link rel="stylesheet" href="<?php echo base_url("yonet/../css/yonet/bootstrap.min.css")?>">
  
    <script type="text/javascript" src="<?php echo base_url("yonet/../js/bootstrap.min.js")?>"></script>
    </head>
<body style="background-color:#ededed">
<?php echo $frm["open"];?>
<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-heading" align="center">
				<img src="../img/admin/zensis.png" >
			</div>
			<hr />
			<div class="modal-body">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">
							<span class="glyphicon glyphicon-user"></span>
							</span>
							 <?php echo $frm["email"] ?>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">
							<span class="glyphicon glyphicon-lock"></span>
							</span>
							 <?php echo $frm["pass"] ?>

						</div>

					</div>
                    <div class="form-group">
						<div class="input-group" align="justify">
							<?=$captcha;?><br>
							<?php echo $frm["captcha"] ?>
						</div>
					</div>
					<div class="form-group text-center"><?php echo $error;?>
						<?php echo $frm["submit"] ?>
						<a href="#" class="btn btn-link">Şifremi Unuttum</a>
					</div>
			</div>
		</div>
	</div>
<?php echo $frm["close"];?>
</body>
</html>  