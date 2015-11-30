<div class="body">	<h1 class="title"><?=$h1?></h1>		<div class="nav">		<div class="fleft"></div>		<div class="fright">			<a style="margin-left:5px;" class="button orange" data-form-apply="">Применить</a>		</div>	</div>	<form id="form" action="<?=$path?>" method="POST" enctype="multipart/form-data">				<div class="toggle-box">			<a class="bookmark-toggle activ" data-name="images" href="#images">Список</a>		</div>		<div class="bookmark activ" data-id="images">			<table class="table-1">				<thead>					<tr>						<td class="small">№</td>						<td class="small">Иконка</td>						<td>Название</td>						<td>Текст</td>						<td class="small">							<a class="link_add" data-images="add" title="добавить"></a>						</td>					</tr>				</thead>				<tbody data-sortable="body" data-images="items">				<?php foreach ($info->images as $k):?>					<tr data-images="item">						<td>							<span class="icon-reorder handler" data-sortable="handler"></span>							<input type="hidden" data-sortable="order" name="images_order[update][<?=$k->id?>]" value="<?=$k->order?>">						</td>						<td>							<div class="FM-image-box">								<div class="i">									<img class="FM-image" src="<?=htmlspecialchars($k->cache)?>" alt="">								</div>								<input type="hidden" name="images[update][<?=$k->id?>]" value="<?=htmlspecialchars($k->image)?>">								<br><a href="/" class="FM-overview">обзор</a> | <a href="/" class="FM-clear">очистить</a>							</div>						</td>						<td>							<?php foreach ($settings->language as $l):?>							<?php $d = $k->description[$l->id];?>								<div class="inf-lang">									<input class="inf" type="text" name="images_description[update][<?=$k->id?>][<?=$l->id?>][name]" value="<?=htmlspecialchars($d->name)?>">									<img src="<?=$l->image?>" alt="<?=$l->code?>" title="<?=$l->name?>">								</div>							<?php endforeach;?>						</td>						<td>							<?php foreach ($settings->language as $l):?>							<?php $d = $k->description[$l->id];?>								<div class="inf-lang">									<textarea class="inf" name="images_description[update][<?=$k->id?>][<?=$l->id?>][text]"><?=$d->text?></textarea>									<img src="<?=$l->image?>" alt="<?=$l->code?>" title="<?=$l->name?>">								</div>							<?php endforeach;?>						</td>						<td>							<a class="link_del" data-images="delete" title="удалить"></a>						</td>					</tr>				<?php endforeach;?>				</tbody>			</table>		</div>				<input type="hidden" name="id" value="<?=$info->id?>">		<input type="hidden" name="edit" value="">	</form>	</div><!-- END BODY --><script> // APPLY$(document).on('click', '[data-form-apply]', function(e){	e.preventDefault();	$(document.body).append('<div class="load"></div>');		if (tinyMCE && tinyMCE.editors){		$(tinyMCE.editors).each(function(){			$(this.getElement()).html(this.getContent());		});	}		AP.init('', $('#form')[0], function(){			location.reload(true);	});	return false;	});</script><script> // IMAGES;$(function(){	var _id_rand = 0;		var I = {		create:function(){			var html = 			'<tr data-images="item" class="new-tr">'+				'<td>'+					'<span class="icon-reorder handler" data-sortable="handler"></span>'+					'<input type="hidden" data-sortable="order" name="images_order[insert]['+_id_rand+']" value="0">'+				'</td>'+				'<td>'+					'<div class="FM-image-box">'+						'<div class="i">'+							'<img class="FM-image" src="/img/i/loading_mini.gif" alt="">'+						'</div>'+						'<input type="hidden" name="images[insert]['+_id_rand+']" value="">'+						'<br><a href="/" class="FM-overview">обзор</a> | <a href="/" class="FM-clear">очистить</a>'+					'</div>'+				'</td>'+				'<td>';				$.each(I.lang, function(i){					html +=					'<div class="inf-lang">'+						'<input class="inf" type="text" name="images_description[insert]['+_id_rand+']['+this.id+'][name]" value="">'+						'<img src="'+this.image+'" alt="'+this.code+'" title="'+this.name+'">'+					'</div>';				});				html +=				'</td>'+				'<td>';				$.each(I.lang, function(i){					html +=					'<div class="inf-lang">'+						'<textarea class="inf" name="images_description[insert]['+_id_rand+']['+this.id+'][text]"></textarea>'+						'<img src="'+this.image+'" alt="'+this.code+'" title="'+this.name+'">'+					'</div>';				});				html +=				'</td>'+				'<td>'+					'<a class="link_del" data-images="delete" title="удалить"></a>'+				'</td>'+			'</tr>';							html = $(html);			$('[data-images="items"]').prepend(html).trigger('sortupdate');			setTimeout(function(){html.removeClass('new-tr')},20);						_id_rand++;		},		init:function(lang){			try{				I.lang = $.parseJSON(lang);			}catch(e){				alert('Ошибка');				return;			}			$(document).on('click','[data-images="add"]', I.create)			.on('click','[data-images="delete"]',function(){				$(this).parents('[data-images="item"]').hide(200,function(){					$(this).remove();					if ( ! $('[data-images="item"]').length) I.create();				});			});			if ( ! $('[data-images="item"]').length) I.create();		}	}		I.init('<?=isset($settings->language) ? json_encode($settings->language) : 0;?>');});</script>