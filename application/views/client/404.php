<!DOCTYPE html>
<html>
<head>
	<title><?=htmlspecialchars($title)?></title>
	<meta name="description" content="<?=htmlspecialchars($metadesc)?>">
	<meta name="keywords" content="<?=htmlspecialchars($metakey)?>">
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="7 days">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/icon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<link rel="apple-touch-icon" sizes="57x57" href="/icon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/icon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/icon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/icon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/icon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/icon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/icon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/icon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/icon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/icon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/icon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/icon/favicon-16x16.png">
	<link rel="manifest" href="/icon/manifest.json">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link type="text/css" rel="stylesheet" href="/css/client/slideshow/slideshow.css">
	<link type="text/css" rel="stylesheet" href="/css/client/lightbox/lightbox.css">
	<link type="text/css" rel="stylesheet" href="/css/client/owl-carousel/owl-carousel.css">
	<link type="text/css" rel="stylesheet" href="/css/client/style.css">
	<link type="text/css" rel="stylesheet" href="/css/client/responsive.css">
	
	
	
	<script type="text/javascript" src="/js/client/jquery.1.9.1.js"></script>
	<script type="text/javascript" src="/js/client/modernizr/modernizr.min.js"></script>
	<script type="text/javascript" src="/js/client/lightbox/lightbox.min.js"></script>
	<script type="text/javascript" src="/js/client/owl-carousel/owl-carousel.min.js"></script>
	<script type="text/javascript" src="/js/client/slideshow/slideshow.js"></script>
	<script type="text/javascript" src="/js/client/functions.js"></script>
	
	
	<?=$settings->analitics?>
	<?=$settings->metrica?>
</head>
<body>
	<div class="wrapper" style="height:100%;">
		
		<header class="header">
			<div class="main">
				<a class="logo" href="/" title="ANRO">
					<img src="/img/i/logo.jpg" alt="ANRO">
				</a>

				<button class="btn btn-toggle" data-toggle="nav">
					<span></span>
					<span></span>
					<span></span>
				</button>
				
				<nav class="nav">
					<ul class="menu">
						<li>
							<a href="#about"><?=$this->lang->line('head_menu_about')?></a>
						</li>
						<li>
							<a href="#materials"><?=$this->lang->line('head_menu_post_material')?></a>
						</li>
						<li>
							<a href="#services"><?=$this->lang->line('head_menu_services')?></a>
						</li>
						<li>
							<a href="#production"><?=$this->lang->line('head_menu_production')?></a>
						</li>
						<li>
							<a href="#reviews"><?=$this->lang->line('head_menu_reviews')?></a>
						</li>
						<li>
							<a href="#contacts"><?=$this->lang->line('head_menu_contacts')?></a>
						</li>
					</ul>
				</nav>
			</div>
		</header>
		
		
		<section class="404" style="height:100%;padding:100px 0;">
			<div class="main">
				<h1>404</h1>
				<a href="/">&larr; back</a>
			</div>
		</section>
		

		<footer class="footer">
			<div class="main">
				<div class="lfloat">
					<div class="copyright">&copy; 2015 ANRO</div>
				</div>
				<div class="rfloat">
					<ul class="soc-list">
					<?php foreach ($settings->social as $k=>$v):?>
						<li>
							<a class="soc <?=$k?>" href="<?=htmlspecialchars($v)?>" target="_blank"></a>
						</li>
					<?php endforeach;?>
					</ul>
				</div>
			</div>
		</footer>
		
	</div><!-- wrapper -->
</body>
</html>