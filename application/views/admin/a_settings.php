<div class="body">
	
	<?php if ($this->session->userdata('error')):?>
	<div class="error-box"><?=$this->session->userdata('error');?></div>
	<?php $this->session->unset_userdata('error');?>
	<?php endif;?>
	
	<h1 class="title"><?=$h1?></h1>
	
	<div class="nav">
		<div class="fleft"></div>
		<div class="fright">
			<a class="button orange" data-form-apply="" >Применить</a>
		</div>
	</div>
	
	<form id="form" action="<?=$path?>" method="POST" enctype="multipart/form-data">
		
		<div class="toggle-box">
			<a class="bookmark-toggle activ" data-name="manager" href="#manager">Менеджер</a>
			<a class="bookmark-toggle" data-name="analitics" href="#analitics">Analitics</a>
			<a class="bookmark-toggle" data-name="admin" href="#admin">Админ</a>
		</div>
		
		<div class="bookmark activ" data-id="manager">
			<table class="table-1">
				<tbody>
					<tr>
						<td class="small right nowrap"><b>Менеджер:</b></td>
						<td>
							<input class="inf" type="text" name="manager" value="<?=htmlspecialchars($settings->manager)?>">
						</td>
					</tr>
					<tr>
						<td class="right nowrap"><b>Skype:</b></td>
						<td>
							<input class="inf" type="text" name="skype" value="<?=htmlspecialchars($settings->skype)?>">
						</td>
					</tr>
					<tr>
						<td class="right nowrap"><b>E-mail:</b></td>
						<td>
							<input class="inf" type="text" name="email" value="<?=htmlspecialchars($settings->email)?>">
						</td>
					</tr>
					<tr>
						<td class="right nowrap"><b>Соц. сети:</b></td>
						<td>
							<table class="table-1">
								<thead>
									<tr>
										<td class="small"></td>
										<td class="small"><b>Соц.сеть</b></td>
										<td><b>URL</b></td>
										<td class="small">
											<a class="link_add" data-social="add" title="добавить социальную сеть"></a>
										</td>
									</tr>
								</thead>
								<tbody data-sortable="body" data-social="items">
								<?php if (is_array($settings->social)):?>
								<?php foreach ($settings->social as $_name=>$_link):?>
									<tr data-social="item">
										<td class="small">
											<span class="icon-reorder handler" data-sortable="handler"></span>
										</td>
										<td>
											<select data-select="" name="social_name[]">
												<option value="0" selected> - выбрать -</option>
												<?php foreach ($social as $i):?>
												<option value="<?=$i->code?>" <?=($i->code == $_name) ? ' selected' : '';?>><?=$i->name?></option>
												<?php endforeach;?>
											</select>
										</td>
										<td>
											<input class="inf" type="text" name="social_link[]" value="<?=htmlspecialchars($_link)?>">
										</td>
										<td class="small">
											<a class="link_del" data-social="delete" title="удалить"></a>
										</td>
									</tr>
								<?php endforeach;?>
								<?php endif;?>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td class="small nowrap right"><b>Телефон:</b></td>
						<td>
							<table class="table-1">
								<thead>
									<tr>
										<td class="small"></td>
										<td><b>Номер</b></td>
										<td class="small">
											<a class="link_add" data-phones="add" title="добавить телефон"></a>
										</td>
									</tr>
								</thead>
								<tbody data-sortable="body" data-phones="items">
								<?php if (is_array($settings->phone)):?>
								<?php foreach($settings->phone as $phone):?>
									<tr data-phones="item">
										<td class="small">
											<span class="icon-reorder handler" data-sortable="handler"></span>
										</td>
										<td>
											<input class="inf" type="text" data-mask="phone" name="phone[]" value="<?=htmlspecialchars($phone)?>">
										</td>
										<td class="small">
											<a class="link_del" data-phones="delete" title="удалить телефон"></a>
										</td>
									</tr>
								<?php endforeach;?>
								<?php endif;?>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td class="right nowrap"><b>Адрес:</b></td>
						<td>
							<table class="table-1">
								<tr>
									<td class="small right"><b>Страна:</b></td>
									<td class="left">
										<input class="inf" type="text" name="country" value="<?=htmlspecialchars($settings->country)?>">
									</td>
								</tr>
								<tr>
									<td class="right"><b>Город:</b></td>
									<td class="left">
										<input class="inf" type="text" name="city" value="<?=htmlspecialchars($settings->city)?>">
									</td>
								</tr>
								<tr>
									<td class="right"><b>Ул./дом:</b></td>
									<td class="left">
										<input class="inf" type="text" name="address" value="<?=htmlspecialchars($settings->address)?>">
									</td>
								</tr>
								<tr>
									<td class="right"><b>Индекс:</b></td>
									<td class="left">
										<input class="inf" type="text" name="postal_code" value="<?=htmlspecialchars($settings->postal_code)?>">
									</td>
								</tr>
								<tr>
									<td class="right"><b>Карта:</b></td>
									<td class="left">
										<table class="table-1">
											<tr>
												<td class="small">
													<div style="height:100px;">
														<img id="ya-map-image" src="<?=htmlspecialchars($settings->map)?>" alt="">
													</div>
													<input class="inf" type="hidden" name="map" value="<?=htmlspecialchars($settings->map)?>">
													<input class="inf" type="hidden" name="coordinates" value="<?=htmlspecialchars($settings->coordinates)?>">
												</td>
												<td class="left">
													<a class="button blue" 
														data-bind="choose-map" 
														data-address="<?=htmlspecialchars($settings->country)?> <?=htmlspecialchars($settings->city)?> <?=htmlspecialchars($settings->address)?>">выбрать</a>
													<a class="button orange" data-bind="clean-map">очистить</a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="bookmark" data-id="analitics">
			<table class="table-1">
				<tbody>
					<tr>
						<td class="small right nowrap"><b>Google Analitics:</b></td>
						<td>
							<textarea style="height:100px;" class="inf" name="analitics"><?=$settings->analitics?></textarea>
						</td>
					</tr>
					<tr>
						<td class="right nowrap"><b>Yandex Metrica:</b></td>
						<td>
							<textarea style="height:100px;" class="inf" name="metrica"><?=$settings->metrica?></textarea>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="bookmark" data-id="admin">
			<table class="table-1">
				<tbody>
					<tr>
						<td class="small right"><b>Логин:</b></td>
						<td class="left">
							<input class="inf" type="text" data-admin="login" name="admin[login]" value="<?=$admin->login?>" disabled>
						</td>
						<td class="small">
							<a class="link_edit" data-bind="enabled" title="Изменить логин"></a>
						</dt>
					</tr>
					<tr>
						<td class="right"><b>Пароль:</b></td>
						<td>
							<input class="inf" type="password" data-admin="password" name="admin[password]" value="" disabled>
						</td>
						<td>
							<a class="link_edit" data-bind="enabled" title="Изменить пароль"></a>
						</dt>
					</tr>
					<tr>
						<td class="right"><b>E-mail:</b></td>
						<td class="left">
							<input class="inf" type="text" data-admin="email" name="admin[email]" value="<?=$admin->email?>" disabled>
						</td>
						<td>
							<a class="link_edit" data-bind="enabled" title="Изменить email"></a>
						</dt>
					</tr>
				</tbody>
			</table>
			<script>
			$(function(){
				$('input[data-admin]').prop('disabled', true);
				$('[data-bind="enabled"]').on('click', function(e){
					e.preventDefault();
					var _this = $(this).parents('tr').find('[data-admin]');
					_this.attr('disabled') ? _this.removeAttr('disabled') : _this.attr('disabled', 'disabled');
				});
			});
			</script>
		</div>

		
		
		<div class="bookmark" data-id="sizes">
			<table class="table-1">
				<thead>
					<tr>
						<td class="small">№</td>
						<td>Размер (px)</td>
						<td class="small">
							<a class="link_add" data-sizeImage="add"></a>
						</td>
					</tr>
				</thead>
				<tbody data-sizeImage="items">
				<?php if (is_array($settings->sizes)):?>
				<?php $i=1; foreach($settings->sizes as $size):?>
					<tr data-sizeImage="item">
						<td><?=$i++;?></td>
						<td class="left">
							<input class="inf" type="text" data-mask="int" name="image_size[]" value="<?=$size?>">
						</td>
						<td>
							<a class="link_del" data-sizeImage="delete" title="Удалить размер"></a>
						</td>
					</tr>
				<?php endforeach;?>
				<?php endif;?>
				</tbody>
			</table>
		</div>
		
		<input type="hidden" name="edit" value="">
	</form>
</div>

<script> // APPLY
$(document).on('click', '[data-form-apply]', function(e){
	$(document.body).append('<div class="load"></div>');
	
	if (tinyMCE && tinyMCE.editors){
		$(tinyMCE.editors).each(function(){
			$(this.getElement()).html(this.getContent());
		});
	}
	
	AP.init('', $('#form')[0], function(){	
		location.reload(true);
	});
	return false;		
});
</script>

<script> // SOCIAL
;$(function(){
	var d = $(document);
	var S = {
		create:function(){
			var html =
			'<tr data-social="item" class="new-tr">'+
				'<td class="small">'+
					'<span class="icon-reorder handler" data-sortable="handler"></span>'+
				'</td>'+
				'<td>'+
					'<select data-select="" name="social_name[]">'+
						'<option value="0" selected> - выбрать -</option>';
						$.each(S.social, function(){
						html +=
						'<option value="'+this.code+'">'+this.name+'</option>';
						});
					html +=
					'</select>'+
				'</td>'+
				'<td>'+
					'<input class="inf" type="text" name="social_link[]" value="">'+
				'</td>'+
				'<td class="small">'+
					'<a class="link_del" data-social="delete" title="удалить телефон"></a>'+
				'</td>'+
			'</tr>';
			
			html = $(html);
			html.find('[data-select]').selectmenu({width:'auto'});
			
			
			$('[data-social="items"]').prepend(html).trigger('sortupdate');
			setTimeout(function(){html.removeClass('new-tr')},20);
		},
		init:function(social){
			try{
				S.social = $.parseJSON(social);
			}catch(e){
				S.social = [];
			}

			d.on('click', '[data-social="add"]', S.create)
			.on('click','[data-social="delete"]',function(){
				$(this).parents('[data-social="item"]').hide(200,function(){
					$(this).remove();
				});
			});
		}
	}
	S.init('<?=isset($social) ? json_encode($social) : 0;?>');
});
</script>

<script> // PHONES
;$(function(){
	var d = $(document);
	var F = {
		create:function(){
			var html = $(
			'<tr data-phones="item" class="new-tr">'+
				'<td class="small">'+
					'<span class="icon-reorder handler" data-sortable="handler"></span>'+
				'</td>'+
				'<td>'+
					'<input class="inf" type="text" data-mask="phone" name="phone[]" value="">'+
				'</td>'+
				'<td class="small">'+
					'<a class="link_del" data-phones="delete" title="удалить телефон"></a>'+
				'</td>'+
			'</tr>');
						
			$('[data-phones="items"]').prepend(html).trigger('sortupdate');
			html.find('[data-mask="phone"]').mask("+38 (999) 999-99-99",{ placeholder:"_" });
			setTimeout(function(){html.removeClass('new-tr')},20);
		},
		init:function(){
			d.on('click', '[data-phones="add"]', F.create)
			.on('click', '[data-phones="delete"]', function(){
				$(this).parents('[data-phones="item"]').hide(200,function(){
					$(this).remove();
				});
			});
		}
	}
	F.init();
});
</script>

<script> // SIZE IMAGE
;$(function(){
	var d = $(document);
	var A = {
		create:function(){
			var html = $(
			'<tr data-sizeImage="item" class="new-tr">'+
				'<td></td>'+
				'<td class="left">'+
					'<input class="inf" type="text" data-mask="int" name="image_size[]" value="">'+
				'</td>'+
				'<td>'+
					'<a class="link_del" data-sizeImage="delete" title="Удалить размер"></a>'+
				'</td>'+
			'</tr>');
		
			$('[data-sizeImage="items"]').prepend(html);
			html.find('[data-mask="int"]').mask("9?999999999999",{ placeholder:""});
			setTimeout(function(){html.removeClass('new-tr')},20);
		},
		init:function(){
			d.on('click', '[data-sizeImage="add"]', A.create)
			.on('click', '[data-sizeImage="delete"]', function(){
				$(this).parents('[data-sizeImage="item"]').hide(200,function(){
					$(this).remove()
					if ( ! $('[data-sizeImage="item"]').length) A.create();
				});
			});
			if ( ! $('[data-sizeImage="item"]').length) A.create();
		}
	}
	A.init();
});
</script>


<script> // YAMAP
$(function(){
	var image = $('#ya-map-image')
		inputMap = $('input[name="map"]'),
		inputCoordinates = $('input[name="coordinates"]');
	
	$('[data-bind="clean-map"]').on('click', function(e){
		e.preventDefault();
		image.attr('src', '');
		inputMap.val('');
		inputCoordinates.val('');
	});
	
	$('[data-bind="choose-map"]').on('click', function(e){
		e.preventDefault();
		
		var address = $(this).data('address') || 'Украина';
		
		var D = $('<div id="YaMapBox" style="height:100%;"></div>').dialog({
			title: 'Карта',
			type: 'map'
		});
		
		YaApiMap(function(){
			ymaps.geocode(address).then(function(data){
				var map = new ymaps.Map($('#YaMapBox')[0], {
					center:data.geoObjects.get(0).geometry.getCoordinates(),
					//zoom:17,
					zoom:6,
					controls: ['typeSelector', 'zoomControl']
					//controls: ['typeSelector', 'searchControl', 'zoomControl']
				});
				map.behaviors.disable('scrollZoom'); 
				$('[class $= "copyrights-pane"]').remove();
				
				// Создаем экземпляр класса ymaps.control.SearchControl
				var mySearchControl = new ymaps.control.SearchControl({
					options: {
						noPlacemark: true
					}
				})
				// Результаты поиска будем помещать в коллекцию.
				,mySearchResults = new ymaps.GeoObjectCollection(null, {
					hintContentLayout: ymaps.templateLayoutFactory.createClass('$[properties.name]')
					//hintContentLayout: ymaps.templateLayoutFactory.createClass('<h1>$[properties.name]</h1>')
					//hintContentLayout: ymaps.templateLayoutFactory.createClass('<p>$[[options.contentBodyLayout]]</p>')
				});
					
				/*
				var MyHintContentLayout = ymaps.templateLayoutFactory.createClass(
						'<div class="hint" style="color:#f00">$[properties.hintContent]</div>'
					),
					myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
						hintContent: "Здесь содержимое хинта",
					}, {
						hintContentLayout: MyHintContentLayout, // шаблон хинта
					});
				myMap.geoObjects.add(myPlacemark);
				*/

				map.controls.add(mySearchControl);
				map.geoObjects.add(mySearchResults);
				// При клике по найденному объекту метка становится красной.
				mySearchResults.events.add('click', function (e) {
					//console.log(e.get('target').geometry.getCoordinates());
					
					var coord = e.get('target').geometry.getCoordinates(),
						src = 'http://static-maps.yandex.ru/1.x/?ll='+coord[1]+','+coord[0]+'&size=600,250&z=16&l=map&pt='+coord[1]+','+coord[0]+',pm2rdl';
					
					inputCoordinates.val(coord);
					inputMap.val(src);
					image.attr('src', src);

					e.get('target').options.set('preset', 'islands#redIcon');
				});
				
				// Выбранный результат.
				mySearchControl.events.add('resultselect', function (e) {
					var index = e.get('index');
					mySearchControl.getResult(index).then(function (res) {
					   mySearchResults.add(res);
					   // res.events.add('click', function(){
						   // alert(res.geometry.getCoordinates());
					   // });
					});
				}).add('submit', function (e) {
					mySearchResults.removeAll();
				});
				
				
				/*
				var myMap = new ymaps.Map('map', {
						center: [59.22, 39.89],
						zoom: 12,
						controls: []
					}),
					// Создаем экземпляр класса ymaps.control.SearchControl
					mySearchControl = new ymaps.control.SearchControl({
						options: {
							noPlacemark: true
						}
					}),
					// Результаты поиска будем помещать в коллекцию.
					mySearchResults = new ymaps.GeoObjectCollection(null, {
						hintContentLayout: ymaps.templateLayoutFactory.createClass('$[properties.name]')
					});
					
				myMap.controls.add(mySearchControl);
				myMap.geoObjects.add(mySearchResults);
				
				// При клике по найденному объекту метка становится красной.
				mySearchResults.events.add('click', function (e) {
					e.get('target').options.set('preset', 'islands#redIcon');
				});
				
				// Выбранный результат помещаем в коллекцию.
				mySearchControl.events.add('resultselect', function (e) {
					var index = e.get('index');
					mySearchControl.getResult(index).then(function (res) {
					   mySearchResults.add(res);
					});
				}).add('submit', function () {
					mySearchResults.removeAll();
				});
				*/
				
				
				/*
				var Placemark = new ymaps.GeoObject(
					{
						geometry: {
							type: "Point", 
							coordinates:data.geoObjects.get(0).geometry.getCoordinates()
						},
						properties: {
							iconContent: 'AAA',
							hintContent: data.geoObjects.get(0).properties.get('name')
						}
					},
					{
						preset: 'islands#pinkStretchyIcon'
					}
				);
				
				Placemark.events.add('click', function (e) {
					map.setCenter(Placemark.geometry.getCoordinates(), 17);
				});
				
				map.geoObjects.add(Placemark);
				*/
			});
		});
		
	});
});


/*
$(function(){
	return;
	
	YaApiMap(function(){
		var address = 'Украина, г.Днепропетровск ул. Ленина, 21а';
		var address = '49000 Украина г. Днепропетровск ул. Ленина, 21а, оф. 518';
		
		//ymaps.geocode('Украина, <?=$settings->address?>').then(function(data){
		ymaps.geocode(address).then(function(data){
			var coord = data.geoObjects.get(0).geometry.getCoordinates().reverse().join(',');
			
			var img = $('<img src="//static-maps.yandex.ru/1.x/?ll='+coord+'&size=600,250&z=16&l=map&pt='+coord+',pm2rdl">');
			$('[data-yamap="static"]').append(img);
			
			return;
		});
	});
});
*/

/*
$(function(){
	var a = document.createElement('script'); 
	a.type = 'text/javascript'; 
	a.async = true;     
	a.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'api-maps.yandex.ru/2.1/?lang=ru_RU';  
	var s = document.getElementsByTagName('script')[0]; 
	s.parentNode.insertBefore(a, s);
	
	a.onload = function(){
		ymaps.ready(function(){
			ymaps.geocode('Украина, <?=$settings->address?>').then(function(data){
				map = new ymaps.Map($('[data-yandex-map="box"]')[0], {
					center:data.geoObjects.get(0).geometry.getCoordinates(),
					zoom:17,
					controls: ['typeSelector', 'zoomControl']
				});
				// запретить ZOOM (мышкой)
				map.behaviors.disable('scrollZoom'); 
				
				$('[class $= "copyrights-pane"]').remove();
			
				var Placemark = new ymaps.GeoObject(
					{
						geometry: {
							type: "Point", 
							coordinates:data.geoObjects.get(0).geometry.getCoordinates()
						},
						properties: {
							//balloonContentBody: 'dsads',
							iconContent: 'CRYSTALLINE.IN.UA',
							hintContent: data.geoObjects.get(0).properties.get('name')
						}
					},
					{
						preset: 'islands#pinkStretchyIcon'
					}
				);
				Placemark.events.add('click', function (e) {
					map.setCenter(Placemark.geometry.getCoordinates(),17,{checkZoomRange:true,duration:1000});
				});
				
				map.geoObjects.add(Placemark);
			});
		});
	};
});
*/
</script>