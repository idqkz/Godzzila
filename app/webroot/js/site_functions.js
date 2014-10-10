var site_functions = {
	class_to_add: 'animated',
	init: function() {

		fade_in = document.getElementsByClassName('fade-in');

		for (var i = fade_in.length - 1; i >= 0; i--) {
			site_functions.fade_in(fade_in[i], site_functions.find_position(fade_in[i]).top);
		};

		$('.main-menu a').click(function() {
			$('.main-menu a').removeClass('active');
			$(this).addClass('active');
			selector = '.' + $(this).attr('href').substring(1);
			destination = $(selector).position().top - 200;
			current = window.scrollY;
			speed = 5;
			distance = destination - current;
			if (distance < 0) { distance *= -1};
			time = distance/speed;
			$('body').animate({scrollTop: destination}, time);
			site_functions.push_history($(this).attr('href'));
			return false;
		})

	},
	sticky: function(item_to_watch, class_to_add, sticky_top_class) {
		var sticky = document.querySelector(item_to_watch);

		if (sticky.style.position !== 'sticky') {
		  var stickyTop = $(sticky_top_class).outerHeight() + 22;
		  return document.addEventListener('scroll', function () {
		  	if (window.scrollY >= stickyTop) {
		  		sticky.classList.add(class_to_add);
		  	} else {
		  		sticky.classList.remove(class_to_add);
		  	}
		  });
		}
	},
	find_position: function(obj) {
		var curleft = curtop = 0;
		if (obj.offsetParent) { do { curleft += obj.offsetLeft; curtop += obj.offsetTop; } while (obj = obj.offsetParent); }
		return {left: curleft, top: curtop};
	},
	fade_in: function(item_to_watch, threshold) {
		
		init_top = item_to_watch.style.top;
		init_left = item_to_watch.style.left;
		init_width = item_to_watch.style.width;

		return document.addEventListener('scroll', function () {
			setTimeout(function() {
				if ((window.scrollY +  window.innerHeight) >= (threshold + 100)) {
					if (item_to_watch.classList.contains(site_functions.class_to_add) == false) {
						item_to_watch.classList.add(site_functions.class_to_add);
						TweenLite.to(item_to_watch, 1, {opacity: 1});
					}
				} else {
					item_to_watch.classList.remove(site_functions.class_to_add);
					item_to_watch.style.opacity = 0;
					item_to_watch.style.top = init_top;
					item_to_watch.style.left = init_left;
					item_to_watch.style.width = init_width;
				}
			}, 100)
			
		});
	},
	push_history: function(href) {
		state = $('html').html();
		window.history.pushState(state, $('html title').html(), window.location.href.substring(0, window.location.href.lastIndexOf('#') + 0) + href);
	},
	special_init: function(obj) {

		return setInterval(function() {
			right_now = new Date();

			start = obj.find('.time').attr('data-start');
			expriry = obj.find('.time').attr('data-expiry');
			
			if (start.substring(11, 13) <= right_now.getHours() && right_now.getHours() < expriry.substring(11, 13)) {

				console.log(start.substring(11, 13) + '<=' +  right_now.getHours());

				
				year = expriry.substring(0, 4);
				month = expriry.substring(5, 7);
				day = expriry.substring(8, 10);
				hour = expriry.substring(11, 13);
				minutes = expriry.substring(14, 16);
				seconds = expriry.substring(17);
				
				due_date = new Date();
				due_date.setFullYear(year, month, day);
				due_date.setHours(hour, minutes, seconds);
				one_day = 1000*60*60*24;
				now = new Date();
				
				days = (due_date.getTime() - right_now.getTime()) / (1000*60*60*24);
				hours = ((due_date.getTime() - right_now.getTime()) / (1000*60*60)) - (parseInt(days)*24);
				minutes = (hours - parseInt(hours))*60;
				seconds = parseInt((minutes - parseInt(minutes))*60);
				if (seconds < 10) {seconds = '0' + seconds} else {seconds += ''}
				minutes = parseInt(minutes);
				if (minutes < 10) {minutes = '0' + minutes} else {minutes += ''}
				hours = parseInt(hours) + '';
				if (hours < 10) {hours = '0' + hours} else { hours += '';}
				days = parseInt(days) + '';

				obj.find('.time p:eq(2)').html(hours.substring(0, 1));
				obj.find('.time p:eq(3)').html(hours.substring(1, 2));

				obj.find('.time p:eq(4)').html(minutes.substring(0, 1));
				obj.find('.time p:eq(5)').html(minutes.substring(1, 2));

				obj.find('.time p:eq(6)').html(seconds.substring(0, 1));
				obj.find('.time p:eq(7)').html(seconds.substring(1, 2));

				obj.find('.counter').show();

			}  else {
				obj.find('.counter').hide();
			}

		}, 1000);
	},
	carousel_next: function(clicked) {
		mar_l = ($('.interior .carousel .item:first()').outerWidth(true)) * -1;
		if (clicked.hasClass('left')) {
			//	animate left
			$('.interior .carousel .item:first()').animate({marginLeft: mar_l}, 250, function() {
				$('.interior .carousel .item:first()').detach().css({marginLeft: 0}).appendTo('.interior .carousel .inner');
			})
		} else {
			//	animate right
			$('.interior .carousel .item:last()').detach().css({marginLeft: mar_l}).prependTo('.interior .carousel .inner');
			$('.interior .carousel .item:first()').animate({marginLeft: 0}, 250);
		}
	},
	carousel_zoom: function(clicked) {
		image = $('<img src="' + clicked.attr('data-large') + '"/>');
		$('.popup-bg').append(image).fadeIn(100);
		$('.popup-bg').click(function() {
			$(this).html('').fadeOut(200);
		})

	}
}
$(document).ready(function() {
	site_functions.init();
	$('.special-wrapper .item:last()').hide();
	$('.special-wrapper .nav .link:first()').addClass('active');
	$('.special-wrapper .item').each(function() {
		site_functions.special_init($(this));
	});

	$('.special-wrapper .nav a').click(function() {
		$('.special-wrapper .nav .link').removeClass('active');
		$(this).parent().addClass('active');
		index = $('.special-wrapper .nav .link').index($(this).parent());
		$('.special-wrapper .item').hide();
		$('.special-wrapper .item:eq(' + index + ')').show();
		return false;
	})
})