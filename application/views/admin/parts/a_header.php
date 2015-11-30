<!DOCTYPE html>
<html>
<head>
	<title>Админ::<?=$h1?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="/css/admin/style.css">
	<link rel="stylesheet" type="text/css" href="/css/admin/fonts/font.awesome/font-awesome.css">
	
	<link rel="stylesheet" type="text/css" href="/css/admin/jquery/jquery-ui.1.11.0.css">
	<link rel="stylesheet" type="text/css" href="/css/admin/dialog/dialog.css">
	<link rel="stylesheet" type="text/css" href="/css/admin/fm/fm.css">
	
	<script type="text/javascript" src="/js/admin/jquery/jquery.1.10.2.js"></script>
	<script type="text/javascript" src="/js/admin/jquery/jquery-ui.1.11.0.js"></script>
	<script type="text/javascript" src="/js/admin/tinymce/tinymce.min.js"></script>
	<script type="text/javascript" src="/js/admin/mask/mask.js"></script>
	<script type="text/javascript" src="/js/admin/dialog/dialog.js"></script>
	<script type="text/javascript" src="/js/admin/fm/fm.js"></script>
	<script type="text/javascript" src="/js/admin/functions.js"></script>

</head>
<body>
	<div class="wrapper">

		<div class="header">
			<ul class="menu">
				<li>
					<span class="has-child"><i class="icon-sitemap"></i>Страницы</span>
					<ul>
						<li>
							<a class="<?=$action == 'info'?'activ':'';?>" href="/admin/info">Инфо</a>
						</li>
						<li>
							<a class="<?=$action == 'about'?'activ':'';?>" href="/admin/about">О нас</a>
						</li>
						<li>
							<a class="<?=$action == 'technologies'?'activ':'';?>" href="/admin/technologies">Технологии</a>
						</li>
						<li>
							<a class="<?=$action == 'experience'?'activ':'';?>" href="/admin/experience">Опыт</a>
						</li>
						<li>
							<a class="<?=$action == 'services'?'activ':'';?>" href="/admin/services">Услуги</a>
						</li>
						<li>
							<a class="<?=$action == 'production'?'activ':'';?>" href="/admin/production">Производство</a>
						</li>
						<li>
							<a class="<?=$action == 'reviews'?'activ':'';?>" href="/admin/reviews">Отзывы</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="<?=$action == 'materials'?'activ':'';?>" href="/admin/materials">POS Материалы</a>
				</li>
				<li>
					<a class="<?=$action == 'banner'?'activ':'';?>" href="/admin/banner">Банер</a>
				</li>
				<li>
					<a class="<?=$action == 'settings'?'activ':'';?>" href="/admin/settings"><i class="icon-cogs"></i>Настройки</a>
				</li>
				<li>
					<a class="FM-overview" href="#"><i class="icon-picture"></i>Файлы</a>
				</li>
				
				<li class="logout">
					<a href="/admin/?logout" title="Выход"><i class="icon-signout"></i></a>
				</li>
				<li class="site">
					<a href="/" target="_blank" title="Перейти на сайт"><i class="icon-globe"></i></a>
				</li>
			</ul>
		</div>