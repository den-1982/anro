/* disabled input 
-------------------------------------------*/
;$(document).on('keypress', 'input[type=text]', function(e){
	if (e.keyCode == 13) return false;
});

/* MASK
-------------------------------------------
;$(function(){
	$.mask.definitions['$']='[0-9,.]';
	$.mask.definitions['~']='[1-9]';
	$('[data-mask="price"]').mask("$?$$$$$$$$$$$",{ placeholder:"" });
	$('[data-mask="phone"]').mask("(999) 999-99-99",{ placeholder:"_" });
});
*/

/* LANGUAGE TOGGLE
-------------------------------------------*/
$(function(){
	var b = $('#toggle-lang'),
		tm;
	
	b.on('click', function(e){
		b.toggleClass('activ');
	}).on({
		mouseenter:function(){
			clearTimeout(tm);
		},
		mouseleave:function(){
			tm = setTimeout(function(){
				b.removeClass('activ');
			}, 2000);
		}
	});
});


/* SCROLL ANCHOR & TOGGLE MENU (mobil)
-------------------------------------------*/
$(function(){
	var w = $(window),
		d = $(document),
		hb = $('html, body'),
		nav = $('.nav'),
		toggle = $('[data-toggle="nav"]'),
		sections = $( 
			nav.find('a').map(function(){
				return (~this.href.indexOf('#')) ? '#'+this.href.replace(/.*#/, '') : '_';
			}).toArray().join(',') 
		);
	
	// TOGGLE
	toggle.on('click.toggle_nav', function(e){
		e.preventDefault();
		
		if ( !(w[0].matchMedia && w[0].matchMedia('(max-width: 979px)').matches) || w.width() > 960) return;
		
		if (nav.hasClass('open')){
			nav.slideUp(300, function(){
				nav.removeAttr('style').removeClass('open');
			});
		}else{
			nav.slideDown(300, function(){
				nav.removeAttr('style').addClass('open');
			});
		}
	});

	// CLICK
	nav.on('click', 'a', function(e) {
		e.preventDefault();
		
		// unbind scroll
		w.unbind('scroll.anchor');
		
		nav.find('a').removeClass('activ').filter(this).addClass('activ');
		
		var hash = this.hash;

		hb.stop(true).animate({
			scrollTop: $(hash).offset().top
		}, 1000, function() {
			window.location.hash = hash;
			
			// bind scroll
			w.bind('scroll.anchor', scr);
		});
		
		toggle.trigger('click.toggle_nav');
	});
	
	
	// SCROLL
	w.bind('scroll.anchor', scr).trigger('scroll.anchor');
	
	function scr(){
		nav.find('a').removeClass('activ');
		
		var winTop = w.scrollTop();
		
		sections.each(function(){
			var _this = $(this),
				top = _this.offset().top - 200,
				bottom = _this.outerHeight(true) + top;
			
			if (winTop >= top && (winTop <= bottom)){
				nav.find('a[href~="#' + this.id + '"]').addClass('activ');
			}
		});
	}
});


/* BANNER
-------------------------------------------*/
$(function(){
	$('[data-owl="banner"]').owlCarousel({
		singleItem:true,
		pagination:true,
		navigation:true,
		autoPlay:20000,
		theme:'owl-banner'
	});
});
				
/* OWL CARUSEL
-------------------------------------------*/
$(function(){
	$('[data-owl="production"]').owlCarousel({
		items : 4,
		itemsDesktop : [1000,3],
		itemsDesktopSmall : [900,2],
		itemsTablet: [600,1],
		itemsMobile : false
	});
});
$(function(){
	$('[data-owl="reviews"]').owlCarousel({
		items : 3,
		itemsDesktop : [1000,3],
		itemsDesktopSmall : [900,2],
		itemsTablet: [600,1],
		itemsMobile : false,
		navigation:false,
		autoPlay:20000
	});
});
		
/* BOOKMARK
-------------------------------------------*/
$(function(){
	var m = $('#materials-menu');
	
	m.on('click.bookmark', '.toggle', function(e){
		e.preventDefault();

		m.find('.toggle').removeClass('activ');
		$(this).addClass('activ');
		
		$(this.hash).addClass('activ').siblings('.bookmark').removeClass('activ');
	});
});

/* CLICK STATIC MAP
-------------------------------------------*/
$(document).on('click.yamapstatic', '[data-yamap="static"]', function(e){

	var data = $(this).data(),
		box = $('#map'),
		address = data.address,
		coordinates = data.coordinates.split(',');
	
	if (box.hasClass('activ')) return;
	
	box.addClass('activ');
	
	YaApiMap(function(){
		ymaps.geocode(coordinates).then(function(i){
			var map = new ymaps.Map(box[0], {
				center: i.geoObjects.get(0).geometry.getCoordinates(),
				zoom: 17,
				controls: ['typeSelector', 'zoomControl']
			});
			map.behaviors.disable('scrollZoom'); 
			$('[class $= "copyrights-pane"]').remove();
			
			var Placemark = new ymaps.GeoObject({
				geometry: {
					type: "Point", 
					coordinates: i.geoObjects.get(0).geometry.getCoordinates()
				},
				properties: {
					iconContent: 'A N R O',
					hintContent: i.geoObjects.get(0).properties.get('name')
				}
			},
			{
				preset: 'islands#redStretchyIcon'
			});
			
			Placemark.events.add('click', function(e){
				map.setCenter(Placemark.geometry.getCoordinates(), 17);
			});
			
			map.geoObjects.add(Placemark);
		});
	});
});

/* CALLBACK
-------------------------------------------*/
$(document).on('submit', '[data-bind="callback"]', function(e){
	e.preventDefault();
	
	var _this = $(this),
		l = $('<div class="load"></div>');
	
	$(document.body).append(l);
	
	_this.find('[name]').removeClass('error');
	
	$.post('', _this.serialize(), function(data){
		l.remove();
		
		console.log(data.error.length);
		
		if ( data.result ){
			_this.fadeOut(500, function(){
				_this.replaceWith(data.result);
			});
			
			return;
		}

		for (var i in data.error){
			_this.find('[name="'+i+'"]').addClass('error');
		}
		
	}, 'json');
});

/* YANDEX API MAP
-------------------------------------------*/
function YaApiMap(callback){
	if (window.ymaps){
		ymaps.ready(callback);
		return;
	}
	
	var a = document.createElement('script'); 
	a.type = 'text/javascript'; 
	a.async = true;     
	a.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'api-maps.yandex.ru/2.1/?lang=ru_RU';  
	var s = document.getElementsByTagName('script')[0]; 
	s.parentNode.insertBefore(a, s);
	
	a.onload = function(){
		ymaps.ready(callback);
	};
}
