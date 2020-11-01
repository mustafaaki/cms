<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle navbar-toggle-sidebar collapsed">
			MENU
			</button>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand logo-container" href="#">
				<img src="../img/admin/zensis-small.png" >
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">      
			<form class="navbar-form navbar-left" method="GET" role="search">
				<div class="form-group">
					<input type="text" name="q" class="form-control" placeholder="İçerik Ara">
				</div>
				<button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
			</form>
			<ul class="nav navbar-nav navbar-right">
				<li>
				    <ul class="nav navbar-nav">
				   <?php
				    $imgFlag = img(Array("src"=>base_url($this->my_lang->activeLng['flag']),'alt'=>$this->my_lang->activeLng['alias']));
				    echo '<li>'.alink(adminbase("#"), $imgFlag,$this->my_lang->activeLng["name"]).'</li>';
                    foreach($this->my_lang->deactiveLng as $lng=>$lngVal){    
                          $imgFlag= img(Array("src"=>base_url($lngVal["flag"]),'alt'=>$lngVal['alias']));
                          echo '<li>'.alink(adminbase("ajax/change_lng/".$lngVal["alias"]),$imgFlag,$lngVal["name"]).'</li>';
                    }  
				    ?>
				    </ul>     
				   
				     
				</li>
				<li><a href="<?php echo base_url();?>" target="_blank">Siteye Git</a></li>
				<li><a href="<?php echo base_url("yonet/help");?>" target="_blank">Yardım</a></li>
				<li class="dropdown ">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						<span class="glyphicon glyphicon-cog"></span>Hesap Yönetimi
						<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="dropdown-header">Ayarlar</li>
							
							<li class=""><a href="#">Şifre Değiş</a></li>
							<li class=""><a href="#">Kullanıcı Ekle</a></li>
							<li class="divider"></li>
							<li class=""><a href="#">Dil Ayarları</a></li>
							<li class=""><a href="#">Sosyal Medya</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url('yonet/login/out');?>"><span class="glyphicon glyphicon-log-out"></span> Çıkış</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
</nav>  	
<div class="main-container">
  	<div class="col-md-2 sidebar">
  			<div class="row">
	<!-- uncomment code for absolute positioning tweek see top comment in css -->
	<div class="absolute-wrapper"> </div>
	<!-- Menu -->
	<div class="side-menu">
		<nav class="navbar navbar-default" role="navigation">
			<!-- Main Menu -->
			<div class="side-menu-container">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#"><span class="glyphicon glyphicon-cloud"></span> İçerikler</a></li>
					<li class="panel panel-default" id="dropdown">
					   <a data-toggle="collapse" href="#dropdown-lvl1">
					       <span class="glyphicon glyphicon-globe"></span> Ana Sayfa  <span class="caret"></span>
					   </a>
					
    					<div id="dropdown-lvl1" class="panel-collapse collapse">
    							<div class="panel-body">
    								<ul class="nav navbar-nav">
    									<li><a href="<?=adminbase('news/news_list')?>">Anasayfaya İçerik</a></li> 
    									<li><a href="<?=adminbase('banner/index')?>">Banner Yönetimi</a></li> 
    									<li><a href="<?=adminbase('menu/makemenu')?>">Üst Menü Yönetimi</a></li>
    									<li><a href="<?=adminbase('footer/link_cat')?>">Alt Menü</a></li>
    									<li><a href="<?=adminbase('footer/static_text')?>">Site Sabit</a></li>  
    									
    								</ul>
    							</div>
    					</div>
					
					</li>
                    <li class="panel panel-default" id="dropdown">
					   <a data-toggle="collapse" href="#dropdown-lvl2">
					       <span class="glyphicon glyphicon-align-left"></span> Kategori   <span class="caret"></span>
					   </a>
					   <div id="dropdown-lvl2" class="panel-collapse collapse">
    							<div class="panel-body">
    								<ul class="nav navbar-nav">
    									<li><a href="<?=adminbase('page/create/cat')?>">Yeni Kategori</a></li> 
    									<li><a href="<?=adminbase('page/cat_list')?>">Kategori Listesi</a></li> 
    								</ul>
    							</div>
    					</div>
					</li>
					<!-- Dropdown-->
					<li class="panel panel-default" id="dropdown">
						<a data-toggle="collapse" href="#dropdown-lvl3">
							<span class="glyphicon glyphicon-file"></span>Sayfa  <span class="caret"></span>
						</a>

						<!-- Dropdown level 1 -->
						<div id="dropdown-lvl3" class="panel-collapse collapse">
							<div class="panel-body">
								<ul class="nav navbar-nav">
									
                                    <li><a href="<?=adminbase('page/create/txt')?>">Yeni Sayfa</a></li>
                                    <li><a href="<?=adminbase('page/txt_list')?>">Sayfa Listesi</a></li>
									

									<!-- Dropdown level 2 -->
									<li class="panel panel-default" id="dropdown">
										<a data-toggle="collapse" href="#dropdown-lvl4">
											<span class="glyphicon glyphicon-off"></span>  <span class="caret"></span>
										</a>
										<div id="dropdown-lvl4" class="panel-collapse collapse">
											<div class="panel-body">
												<ul class="nav navbar-nav">
													<li><a href="#">Kategori Sayfası</a></li> 
												</ul>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</li>
                    <li><a href="#"><span class="glyphicon glyphicon-picture"></span> Resim Yönetimi</a></li>
					
					<li><a href="#"><span class="glyphicon glyphicon-file"></span> Dosya Yönetimi</a></li>
				
					
					


				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>

	</div>
</div>
</div>
</div>
  		
  		
  	
<script type="text/javascript">
	$(function () {
  	$('.navbar-toggle-sidebar').click(function () {
  		$('.navbar-nav').toggleClass('slide-in');
  		$('.side-body').toggleClass('body-slide-in');
  		$('#search').removeClass('in').addClass('collapse').slideUp(200);
  	});

  	$('#search-trigger').click(function () {
  		$('.navbar-nav').removeClass('slide-in');
  		$('.side-body').removeClass('body-slide-in');
  		$('.search-input').focus();
  	});
  });
</script>