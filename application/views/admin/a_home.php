<div class="body">	<h1 class="title"><?=$h1?></h1>		<div class="nav">		<div class="fleft"></div>		<div class="fright">			<a style="margin-left:5px;" class="button orange" data-form-apply="">Применить</a>		</div>	</div>		<form id="form" action="<?=$path?>" method="POST" enctype="multipart/form-data">				<div class="toggle-box">			<a class="bookmark-toggle activ" data-name="data" href="#data">Общие</a>			<a class="bookmark-toggle" data-name="banners" href="#banners">Баннеры</a>			<a class="bookmark-toggle" data-name="slider" href="#slider">Слайдер</a>		</div>		<div class="bookmark activ" data-id="data">			<table class="table-1">				<tbody>					<tr>						<td class="small nowrap right">							<b>H1:</b>						</td>						<td>							<input class="inf" type="text" name="h1" value="<?=htmlspecialchars($home->h1)?>">						</td>					</tr>					<tr>						<td class="right nowrap">							<b>Title:</b>						</td>						<td>							<textarea style="height:100px;" class="inf" name="title"><?=$home->title?></textarea>						</td>					</tr>					<tr>						<td class="right nowrap">							<b>Metadesc:</b>						</td>						<td>							<textarea style="height:100px;" class="inf" name="metadesc"><?=$home->metadesc?></textarea>						</td>					</tr>					<tr>						<td class="right nowrap">							<b>Metakey:</b>						</td>						<td>							<textarea style="height:100px;" class="inf" name="metakey"><?=$home->metakey?></textarea>						</td>					</tr>					<tr>						<td class="right nowrap">							<b>Spam:</b>						</td>						<td>							<textarea style="height:70px;" class="inf" name="spam"><?=$home->spam?></textarea>						</td>					</tr>					<tr>						<td class="right nowrap">							<b>Баннер:</b>						</td>						<td class="left">							<div class="FM-image-box" style="">								<div class="i">									<img class="FM-image" src="<?=htmlspecialchars($home->middle_banner)?>">								</div>								<input type="hidden" name="middle_banner" value="<?=htmlspecialchars($home->middle_banner)?>">								<br>								<a href="/" class="FM-overview">обзор</a> | <a href="/" class="FM-clear">очистить</a>							</div>						</td>					</rt>					<tr>						<td class="small nowrap right">							<b>Text:</b>						</td>						<td>							<textarea class="tiny" style="height:300px;" name="text"><?=$home->text?></textarea>						</td>					</tr>				</tbody>			</table>		</div>				<div class="bookmark" data-id="banners">			<table class="table-1">				<thead>					<tr>						<td class="small">№</td>						<td class="small"></td>						<td>Заголовок</td>						<td>Ссылка (URL)</td>						<td class="small">Размер</td>						<td class="small">							<a class="link_add" data-banners="add" title="добавить"></a>						</td>					</tr>				</thead>				<tbody data-sortable="body" data-banners="items">				<?php foreach ($home->banners as $k):?>					<tr data-banners="item">						<td>							<span class="icon-reorder handler" data-sortable="handler"></span>							<input type="hidden" data-sortable="order" name="banner_order[]" value="<?=$k->order?>">						</td>						<td>							<div class="FM-image-box" style="">								<div class="i">									<img class="FM-image" src="<?=htmlspecialchars($k->cache)?>">								</div>								<input type="hidden" name="banner_image[]" value="<?=htmlspecialchars($k->image)?>">								<br>								<a href="/" class="FM-overview">обзор</a> | <a href="/" class="FM-clear">очистить</a>							</div>						</td>						<td class="left">							<input class="inf" type="text" name="banner_text[]" value="<?=htmlspecialchars($k->text)?>">						</td>						<td class="left">							<input class="inf" type="text" name="banner_link[]" value="<?=htmlspecialchars($k->link)?>">						</td>						<td class="left">							<select data-select="" name="banner_size[]">								<option value="0" <?=$k->size == 0 ? 'selected' : '';?>>Малый</option>								<option value="1" <?=$k->size != 0 ? 'selected' : '';?>>Большой</option>							</select>						</td>						<td>							<a class="link_del" data-banners="delete" title="удалить"></a>						</td>					</tr>					<?php endforeach;?>				</tbody>			</table>		</div>				<div class="bookmark" data-id="slider">			<table class="table-1">				<thead>					<tr>						<td class="small">№</td>						<td class="small"></td>						<td class="small"></td>						<td class="small"></td>						<td>H1</td>						<td>Текст</td>						<td>Ссылка</td>						<td class="small">							<a class="link_add" data-slider="add" title="добавить"></a>						</td>					</tr>				</thead>				<tbody data-sortable="body" data-slider="items">				<?php foreach ($home->slider as $k):?>					<tr data-slider="item">						<td>							<span class="icon-reorder handler" data-sortable="handler"></span>							<input type="hidden" data-sortable="order" name="slider_order[]" value="<?=$k->order?>">						</td>						<td>							<div class="FM-image-box" style="">								<div class="i">									<img class="FM-image" src="<?=htmlspecialchars($k->cache)?>" alt="">								</div>								<input type="hidden" name="slider_image[]" value="<?=htmlspecialchars($k->image)?>">								<br>								<a href="/" class="FM-overview">обзор</a> | <a href="/" class="FM-clear">очистить</a>							</div>						</td>						<td>							<div class="FM-image-box" style="">								<div class="i">									<img class="FM-image" src="<?=htmlspecialchars($k->cache2)?>" alt="">								</div>								<input type="hidden" name="slider_image2[]" value="<?=htmlspecialchars($k->image2)?>">								<br>								<a href="/" class="FM-overview">обзор</a> | <a href="/" class="FM-clear">очистить</a>							</div>						</td>						<td>							<div class="FM-image-box" style="">								<div class="i">									<img class="FM-image" src="<?=htmlspecialchars($k->cache3)?>" alt="">								</div>								<input type="hidden" name="slider_image3[]" value="<?=htmlspecialchars($k->image3)?>">								<br>								<a href="/" class="FM-overview">обзор</a> | <a href="/" class="FM-clear">очистить</a>							</div>						</td>						<td class="left">							<textarea class="inf" style="height:70px;" name="slider_h1[]"><?=$k->h1?></textarea>						</td>						<td class="left">							<textarea class="inf" style="height:70px;" name="slider_text[]"><?=$k->text?></textarea>						</td>						<td class="left">							<input class="inf" name="slider_link[]" value="<?=htmlspecialchars($k->link)?>">						</td>						<td>							<a class="link_del" data-slider="delete" title="удалить"></a>						</td>					</tr>					<?php endforeach;?>				</tbody>			</table>		</div>				<input type="hidden" name="id" value="<?=$home->id?>">		<input type="hidden" name="edit" value="">	</form>	</div><!-- END BODY --><script> // APPLY$(document).on('click', '[data-form-apply]', function(e){	e.preventDefault();	$(document.body).append('<div class="load"></div>');		if (tinyMCE && tinyMCE.editors){		$(tinyMCE.editors).each(function(){			$(this.getElement()).html(this.getContent());		});	}		AP.init('', $('#form')[0], function(){			location.reload(true);	});	return false;	});</script><script> // BANNERS;$(function(){	var d = $(document);	var B = {		create:function(){			var html = $(			'<tr data-banners="item" class="new-tr">'+				'<td>'+					'<span class="icon-reorder handler" data-sortable="handler"></span>'+					'<input type="hidden" data-sortable="order" name="banner_order[]" value="">'+				'</td>'+				'<td>'+					'<div class="FM-image-box" style="">'+						'<div class="i">'+							'<img class="FM-image" src="/img/i/loading_mini.gif">'+						'</div>'+						'<input type="hidden" name="banner_image[]" value="">'+						'<br>'+						'<a href="/" class="FM-overview">обзор</a> | <a href="/" class="FM-clear">очистить</a>'+					'</div>'+				'</td>'+				'<td class="left">'+					'<input class="inf" type="text" name="banner_text[]" value="">'+				'</td>'+				'<td class="left">'+					'<input class="inf" type="text" name="banner_link[]" value="">'+				'</td>'+				'<td class="left">'+					'<select data-select="" name="banner_size[]">'+						'<option value="0" selected>Малый</option>'+						'<option value="1">Большой</option>'+					'</select>'+				'</td>'+				'<td>'+					'<a class="link_del" data-banners="delete" title="удалить"></a>'+				'</td>'+			'</tr>');						html.find('[data-select]').selectmenu({width:'auto'});			$('[data-banners="items"]').prepend(html).trigger('sortupdate');			setTimeout(function(){html.removeClass('new-tr')}, 20);		},		init:function(){			d.on('click','[data-banners="add"]', B.create)			.on('click','[data-banners="delete"]', function(){				$(this).parents('[data-banners="item"]').hide(200,function(){					$(this).remove();				});			});		}	}	B.init();});</script><script> // SLIDER;$(function(){	var d = $(document);	var S = {		create:function(){			var html = $(			'<tr data-slider="item" class="new-tr">'+				'<td>'+					'<span class="icon-reorder handler" data-sortable="handler"></span>'+					'<input type="hidden" data-sortable="order" name="slider_order[]" value="">'+				'</td>'+				'<td>'+					'<div class="FM-image-box">'+						'<div class="i">'+							'<img class="FM-image" src="/img/i/loading_mini.gif">'+						'</div>'+						'<input type="hidden" name="slider_image[]" value="">'+						'<br><a href="/" class="FM-overview">обзор</a> | <a href="/" class="FM-clear">очистить</a>'+					'</div>'+				'</td>'+				'<td>'+					'<div class="FM-image-box">'+						'<div class="i">'+							'<img class="FM-image" src="/img/i/loading_mini.gif">'+						'</div>'+						'<input type="hidden" name="slider_image2[]" value="">'+						'<br><a href="/" class="FM-overview">обзор</a> | <a href="/" class="FM-clear">очистить</a>'+					'</div>'+				'</td>'+				'<td>'+					'<div class="FM-image-box">'+						'<div class="i">'+							'<img class="FM-image" src="/img/i/loading_mini.gif">'+						'</div>'+						'<input type="hidden" name="slider_image3[]" value="">'+						'<br><a href="/" class="FM-overview">обзор</a> | <a href="/" class="FM-clear">очистить</a>'+					'</div>'+				'</td>'+				'<td class="left">'+					'<textarea class="inf" style="height:70px;" name="slider_h1[]"></textarea>'+				'</td>'+				'<td class="left">'+					'<textarea class="inf" style="height:70px;" name="slider_text[]"></textarea>'+				'</td>'+				'<td class="left">'+					'<input class="inf" name="slider_link[]" value="">'+				'</td>'+				'<td>'+					'<a class="link_del" data-slider="delete" title="удалить"></a>'+				'</td>'+			'</tr>');						$('[data-slider="items"]').prepend(html).trigger('sortupdate');			setTimeout(function(){html.removeClass('new-tr')}, 20);		},		init:function(){			d.on('click','[data-slider="add"]', S.create)			.on('click','[data-slider="delete"]', function(){				$(this).parents('[data-slider="item"]').hide(200,function(){					$(this).remove();					if ( ! $('[data-slider="item"]').length) S.create();				});			});						if ( ! $('[data-slider="item"]').length) S.create();		}	}	S.init();});</script>