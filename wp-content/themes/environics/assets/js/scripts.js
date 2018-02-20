var environics = {};
var masonryInit = true; // set Masonry init flag
var alm_is_animating = false;
var alm_is_done = false;

$(document).ready(function () {
  environics.init();
});

$.fn.almComplete = function() { // Ajax Load More callback function
	if($('.grid').length){
		var windowOffset = $(window).scrollTop() + $(window).height();
		var $container = $('.grid'); // our container
		
		if($container.length) {
			if(masonryInit) {
				// initialize Masonry only once
				masonryInit = false;
				
				$container.masonry({
					gutter: ".gutter-sizer",
					columnWidth: ".grid-sizer",
					itemSelector: '.masonry-tile',
					transitionDuration: 0
				});
			}

			$container.masonry('reloadItems'); // Reload masonry items after callback

			$container.imagesLoaded( function() { // When images are loaded, fire masonry again.
				$container.masonry('layout');
				$('.masonry-tile').each(function() {
					if(windowOffset >= $(this).offset().top){
						$(this).addClass('animate');
					}
				});
			});

			alm_is_done = false;
		}
	}

	if($(window).width() > 768 && $('.page-thinking .square').length) {
		environics.makeSquare();
	}

	if($(window).width() > 768 && $('.page-news .square').length) {
		environics.makeSquare();
	}

	if($(window).width() > 768 && $('.page-work .square').length) {
		environics.makeSquare();
	}
};

$.fn.almDone = function(){
	$('.masonry').removeClass('gradient');
	$('.archive-gallery').removeClass('gradient');
	alm_is_done = true;
};

$.fn.almFilterComplete = function(){
	if($('.grid').length){
		alm_is_animating = false; // clear alm_is_animating flag
		setTimeout(function() {
			if(!alm_is_done) {
				$('.masonry').addClass('gradient');
				$('#load-more').removeClass('done');
			}
		}, 1000);
	}
};

environics.init = function() {

	environics.showMenu();
	if($('.single-work').length) {
		environics.fullStory();
	}

	if($('.upload').length) {
		environics.displayFilename();
	}

	if($('.download-modal').length) {
		environics.formModal();
	}
	
	if($('.whats-happening-today').length) {
		environics.loadWhatsHappeningToday();
	}

	if($('.video-container').length) {
		environics.videoModal();
	}

	if($('.infographic-block .modal').length) {
		environics.infographicModal();
	}

	if($('.copy-box').length){
		environics.embedModal();
	}

	//Make square only if greater than 480px
	if($(window).width() > 768 && !$('.page-work').length) {
		if($('.square').length) {
			environics.makeSquare();
		}
	}

	if($('.grid').length && $(window).width() < 768 && $('.page-work').length) {
		$('.square').css('height', 'auto');
	}

	$(window).resize(function() {
		//Make square only if greater than 480px
		if($(window).width() > 768 && !$('.page-work').length) {
			if($('.square').length) {
				environics.makeSquare();
			}
		}

		if($(window).width() <= 480 && !$('.page-work').length) {
			$('.square').css('height', 'auto');
		}

		if($('.grid').length && $(window).width() >= 768 && $('.page-work').length) {
			environics.makeSquare();
		}

		if($('.grid').length && $(window).width() < 768 && $('.page-work').length) {
			$('.square').css('height', 'auto');
		}

		if($('.filler-span').length){
			environics.resizeFiller();
		}

		if($('.team-gallery').length){
			environics.makeTeamSquare();
		}

		if($(window).width() < 768) {
			if($('.images').length) {
				environics.flickity();
			}
		}
	});

	if($('.team-gallery').length){
		environics.makeTeamSquare();
	}

	if($('.filler-span').length){
		environics.resizeFiller();
	}

	if($('.team-gallery').length){
		environics.activateTeam();
	}

	if($('.page-home .featured').length){
		environics.caseSlideIn();
	}

	if($('.dropdown-gallery').length){
		environics.activateDropdown();
	}
	
	if($('.grid').length){
		environics.masonry();
	}

	if($('iframe').length) {
		// environics.fluidVids();
	}

	if($('.social-share').length){
		environics.socialShare();
	}

	if($('#commentform').length){
		environics.commentError();
	}

	if($(window).width() <= 768 && $('.sub-nav-container').length) {
		environics.subnavWidth();
	}

	$(window).resize(function() {		
		if($(window).width() <= 768 && $('.sub-nav-container').length) {
			environics.subnavWidth();
		}

		if ($(window).width() > 768) {
			if($('.sub-nav-container').length) {
				$('.sub-nav').css('width', 'auto');
				$('.page-home .sub-nav-container p').css('width', '90%');
			}
		}
	});

	//Smooth scroll on job posting pages
	if($('.form-container').length){
		$('a[href^="#"]').on('click', function(event) {
		    var target = $(this.getAttribute('href'));
		    if( target.length ) {
		        event.preventDefault();
		        $('html, body').stop().animate({
		            scrollTop: target.offset().top
		        }, 1000);
		    }
		});
	}

};

//Insert filename into upload form button when file is selected

environics.displayFilename = function(){

	//Force a focus state on the input label
	$('.upload').focus(function() {
		$(this).parents('.frm_single_upload').next().addClass('focused');
	});

	$('.upload').focusout(function() {
		$(this).parents('.frm_single_upload').next().removeClass('focused');
	});

	$('.upload').change(function() {
		var parent = $(this).parents('.frm_single_upload').next();
		var filename = $(this).val();
		//Remove the path from the filename
		filename = filename.split( '\\' ).pop();
		parent.html(filename);
	});
};

//Apply height to the tiled gallery tiles to make them squares
environics.makeSquare = function(target){
	var el;
	
	if (target) { el = target + ' .square'; }
	else { el = '.square'; }

	$(el).each(function(){
		var tileWidth = $(this).outerWidth();
		$(this).css('height', tileWidth);
	});
};

//Apply height to the team gallery tiles to make them squares
environics.makeTeamSquare = function(target){
	var el;
	
	if (target) { el = target + ' .square'; }
	else { el = '.team-square'; }

	$(el).each(function(){
		var tileWidth = $(this).outerWidth();
		$(this).css('height', tileWidth);
	});
};

//Turn restricted tabbing on and off. Lets you tab out of a full screen menu/display. 
environics.tabModal = function(index) {
	$('.site-content a, .site-footer a, button, input, textarea').attr('tabindex', index);
};

//Show and hide the menu
environics.showMenu = function () {
	$('.hamburger-container').on('click', function(){
		if($(this).hasClass('close')){
			$(this).removeClass('close');
			$('.nav-container').removeClass('show').addClass('hide');
			var timer = 0;
			$($('.menu-primary-container .menu-item').get().reverse()).each(function(){
				var _this = this;
				setTimeout(function(){ 
					$(_this).removeClass('active');
				}, timer);
				timer = timer + 50;
			});
			document.ontouchmove = function(){ return true; };
			//restore links to normal tabbing order
			environics.tabModal(1);
		} else {
			$('.nav-container').addClass('show').removeClass('hide');
			$('.hamburger-container').addClass('close');
			var timer = 0;
			$('.menu-primary-container .menu-item').each(function(){
				var _this = this;
				setTimeout(function(){ 
					$(_this).addClass('active');
				}, timer);
				timer = timer + 50;
			});
			document.ontouchmove = function(e){ e.preventDefault(); };
			//remove links from tabbing index except for nav links
			environics.tabModal(-1);
		}
	});

	$('.hamburger-container').keypress(function (e) {
	 var key = e.which;
	 if(key === 13) {
	   if($(this).hasClass('close')){
	   			$(this).removeClass('close');
	   			$('.nav-container').removeClass('show').addClass('hide');
	   			$('.menu-item').removeClass('active').addClass('passive');
	   			document.ontouchmove = function(){ return true; };
	   			$('body').removeClass('no-overflow');
	   			//restore links to normal tabbing order
				environics.tabModal(1);
	   		} else {
	   			$('.nav-container').addClass('show').removeClass('hide');
	   			$('.hamburger-container').addClass('close');
	   			$('.menu-item').addClass('active').removeClass('passive');
	   			document.ontouchmove = function(e){ e.preventDefault(); };
	   			$('body').addClass('no-overflow');
	   			//remove links from tabbing index except for nav links
	   			environics.tabModal(-1);
	   		}  
	  	}
	}); 
};

$('.no-overflow').on('touchmove', function(e) {
	e.preventDefault();
});

// Scroll to content when user clicks "Read Full Story" button
environics.fullStory = function () {
	$('.divider button').on('click', function(){
		var nextContainer = $(this).next();
		$('html, body').animate({
			scrollTop: ($(nextContainer).offset().top + 28)
		}, 1000);
	});
};

environics.activateTeam = function(){
	// var totalmembers = $('.team-member').length;

	// $('.team-member').on('click', function(event){
	// 	event.stopPropagation();
	// 	if($(this).hasClass('jobs-item')) {
	// 		return;
	// 	}

	// 	//Find the position of the current element
	// 	var current = this;
	// 	var position = 0;
	// 	$('.team-member').each(function(){
	// 		if($(this).is(current)) {
	// 			position++;
	// 			return false;
	// 		} position++;
	// 	});

	// 	// Remove class active
	// 	if($(this).hasClass('active')) {
	// 		$(this).removeClass('active');
	// 		$('.dropdown').remove();
	// 	}

	// 	// Set class to active
	// 	else {
	// 		$('.team-member').removeClass('active');
	// 		$(current).addClass('active');

	// 		var membersPerRow;

	// 		//Get the amount of tiles per row based on window width
	// 		//Gallery never spans to 1 per row, so keep at 3
	// 		// if($(window).width() > 480) {
	// 			membersPerRow = 3;
	// 		// } else {
	// 		// 	membersPerRow = 1;
	// 		// }
			
	// 		//Find placement of bio insert
	// 		var placement = Math.ceil(position / membersPerRow) * membersPerRow -1;

	// 		//If the jobs square is the next square
	// 		var nextsquare = $(this).next();
	// 		//If the jobs link is 2 columns wide, 
	// 		//minus one from placement so team member on last row has correct placement
	// 		if (nextsquare.hasClass('filler-span-two')){
	// 			placement = placement - 1;
	// 		}
			
	// 		// Get the html inside the dropdown
	// 		var bio = '<article class="dropdown span_10" style="display: block">';
	// 		bio += $(this).children('.dropdown-content').html();
	// 		bio += '</article>';

	// 		// If a bio exists on the stage, remove it first, 
	// 		// then insert the new one...
	// 		if($('.dropdown').length) {
	// 			$('.dropdown').fadeOut("fast", function() {
	// 				$(this).remove();
	// 				$($('.team-member')[placement]).after(bio);
	// 				// Initiate close function
	// 				environics.closeDropdown();
	// 			});
	// 		}

	// 		// // ...otherwise just insert the bio
	// 		else {
	// 			$($('.team-member')[placement]).after(bio);
	// 			// Initiate close function
	// 			environics.closeDropdown();
	// 		}	
	// 	}

	// 		// Scroll window to member photo offset minus height of margin

	// 		var memberOffset = $(this).offset();
	// 		var memberMargin = parseInt($(this).children().css('marginBottom')) - 2;
	// 		var scrollPos = memberOffset.top - memberMargin;

	// 		// If team member details is above member, add height of team member details to scrollPos
	// 		var teamDetailOffset = $('.dropdown').offset();

	// 		if (teamDetailOffset.top < memberOffset.top) {
	// 			scrollPos = memberOffset.top - $('.dropdown').outerHeight() - (memberMargin * 2);
	// 			$('body, html').animate({
	//                 scrollTop: scrollPos
	//         	}, 800);
			
	// 		// ...otherwise do not add height of team memeber details to scrollPos
	// 		} else {
	// 			// var scrollPos = memberOffset.top - 19.2;
	// 			$('body, html').animate({
	//                 scrollTop: scrollPos
	//         	}, 800);
	// 		}
	// });

	// $('.team-member').keypress(function (e) {
	// 	 var key = e.which;
	// 	 if(key === 13) {
	// 	 	$(this).click();
	// 	 }
	//  });	
};

environics.activateDropdown = function(){
	//Get the amount of tiles per row based on window width
	var itemsPerRow;

	$('.dropdown-item').on('click', function(event){
		event.stopPropagation();
		var placement;
		var current = this;
		var position = 0;
		var total = 0;


		//Find the position of the current element, and the total elements
		$(this).parent().find('.dropdown-item').each(function(){
			if($(this).is(current)) {
				position++;
				return false;
			} position++;
		});
		$(this).parent().find('.dropdown-item').each(function(){
			total++;
		});

		// If the selected item open, then close it
		if($(this).hasClass('active')) {
			$(this).removeClass('active');
			$('.dropdown').remove();
		}

		// Open the selected item
		else {
			$('.dropdown-item').removeClass('active');
			$(current).addClass('active');

			//Mobile
			itemsPerRow = 2;

			//Desktop - 3 items per row
			if($(window).width() > 768) {
				itemsPerRow = 3;
			} 

			if($(this).parents('.team-container').length) {
				itemsPerRow = 3;
			} 

			if($(this).parents('.sectors-container').length) {
				itemsPerRow = 2;

				if($(window).width() < 768) {
					itemsPerRow = 1;
				} 
			} 
			
			//Find placement of bio insert
			placement = Math.ceil(position / itemsPerRow) * itemsPerRow -1;
			
			var _this = $(this);
			
			// Get the html inside the dropdown
			var bio = '<article class="dropdown" style="display: block">';
			bio += $(this).children('.dropdown-content').html();
			bio += '</article>';

			//Create a variable for the item to place bio after
			var placeafter = $(this).parent().children('.dropdown-item').eq(placement);

			// If a bio exists on the stage, remove it first, 
			// then insert the new one...
			if($('.dropdown').length) {
				$('.dropdown').fadeOut("fast", function() {
					$(this).remove();
					//Check to account for last row that is not full
					if(placeafter.length){
						placeafter.after(bio);
					} else {
						_this.parent().children().eq(total - 1).after(bio);
					}
					
					// Initiate close function
					environics.closeDropdown();
				});
			}

			// ...otherwise just insert the bio
			else {
				//Check to account for last row that is not full
				if(placeafter.length){
					placeafter.after(bio);
				} else {
					_this.parent().children().eq(total - 1).after(bio);
				}
				// Initiate close function
				environics.closeDropdown();
			}	
		}
	});

	$('.dropdown-item').keypress(function (e) {
		 var key = e.which;
		 if(key === 13) {
		 	$(this).click();
		 }
	 });	
};

environics.closeDropdown = function() {
	$('.dropdown .close').on('click', function(){
		$('.dropdown-item').removeClass('active');
		$('.team-member').removeClass('active');
		$('.dropdown').remove();
	});
};

// Expand and collapse the accordion on Capabilities and About pages
environics.accordion = function() {
	// Get the height of the accordion
	var accordionHeight = $('.accordion').height();
	// Add height so accordion opens smoothly
	$('.accordion-row').css('height', accordionHeight);
	
	$('.accordion-row').on('click', function(){
		// Remove flex-basis so elements can grow/shrink
		// Add active class to clicked 
		$(this).addClass('active');
		// Hide siblings
		$(this).siblings().addClass('hide');
	});

	//On close, remove all extraneous classes
	$('.accordion-row .close').on('click', function(e){
		$('.accordion-row').removeClass('active hide');
		e.stopPropagation();
	});
};

// Initiate the masonry gallery on the home and work with us pages
environics.masonry = function () {
	//When the user scrolls past a featured item box, add a class to trigger animation
	$(window).scroll(function(){
		var windowOffset = $(window).scrollTop() + $(window).height();
		
		$('.masonry-tile').each(function() {	
			if(!$(this).hasClass('shown') && windowOffset >= $(this).offset().top) {
				$(this).addClass('animate');
			}
		});
	});

	// Gallery filters
	$('.sub-nav li a').on('click', function(e){
		e.preventDefault();
		var el = $(this); // Our selected element

		if(!el.hasClass('active') && !alm_is_animating){ // Check for active and !alm_is_animating  
			alm_is_animating = true;   
			el.parent().addClass('active').siblings('li').removeClass('active'); // Add active state
		}

		var data = el.data(), // Get data values from selected menu item
		transition = 'fade', // 'slide' | 'fade' | null
		speed = '300'; //in milliseconds
         
     	$.fn.almFilter(transition, speed, data); // reset Ajax Load More (transition, speed, data)
     	return false;
	});
};

environics.nextInterval = null;

environics.loadWhatsHappeningToday = function() {
	var dots = $('.dot');
	var moments = $(".wht-moment");

	//If there are more than one quotes, set function to cycle through them
	if(dots.length > 1) {
		moments.eq(0).addClass('active');
		environics.animateMoment(moments.eq(0));
		environics.positionMoments();
		environics.animateProgressBar();
		dots.eq(0).addClass('active');
		dots.eq(1).addClass('next');
		environics.positionDots();
		environics.nextInterval = setInterval(environics.whatsHappeningNext, 5000);
		dots.on('click', environics.whatsHappeningSelected); //Jump to the selected one
	} 
	else if (dots.length === 1){
		dots.css('display', 'none');
		$('.progress-bar').css('display', 'none');
	} 
	else {
		$('.banner').css('display', 'none');
	}
};

environics.animateMoment = function(moment) {
	moment.fadeIn(500).delay(4000).fadeOut(500);
};

environics.whatsHappeningNext = function() {
	var dots = $('.dot');
	var moments = $(".wht-moment");
	var nextDot = $('.dot.next');
	var nextMoment;

	environics.animateDots();
	
	$('.dot.active').removeClass('active');
	nextDot.addClass('active').removeClass('next');

	if(nextDot.is(dots.last())) {
		dots.first().addClass('next');
	}
	else {
		nextDot.next().next().addClass('next');
	}

	//Load the next moment
	moments.removeClass('active');
	nextMoment = $('.dot.active').prev();
	nextMoment.addClass('active');
	environics.animateMoment(nextMoment);

	environics.animateProgressBar();
	environics.positionMoments();
};

environics.animateDots = function() {
	var startingPos = 0;
	var dotWidth    = 8;
	var activePos   = Math.floor($('.dot.active').position().left);
	var nextPos     = Math.floor($('.next').position().left);
	var dotStretch  = Math.abs(nextPos - activePos) + dotWidth; //Make this number always positive
	
	//Determine the start position for the animation which dictates the direction the animation will appear
	if(nextPos < activePos) {
		startingPos = nextPos;
	}
	else {
		startingPos = activePos;
	}

	$('.superdot').css('left', activePos)
		.animate({ left: startingPos, width: dotStretch}, 500, function(){ //stretch
			$('.superdot').animate({ left: nextPos, width: dotWidth }, 100); //collapse
		});
};

environics.whatsHappeningSelected = function() {
	var dots = $('.dot');
	var moments = $(".wht-moment");
	var nextMoment;

	moments.removeClass('active').stop();
	clearInterval(environics.nextInterval); //Stop the previous animation from running
	$('.progress-bar').stop().fadeOut(100).css('width', '0%');

	//Reset the next dot to the one that was just clicked on
	dots.removeClass('next');
	$(this).addClass('next');

	environics.animateDots();

	dots.removeClass('active');
	$(this).addClass('active').removeClass('next');

	if($(this).is(dots.last())) {
		dots.first().addClass('next');
	}
	else {
		$(this).next().next().addClass('next');
	}

	//Load the next moment
	nextMoment = $('.dot.active').prev();
	nextMoment.addClass('active');
	environics.animateMoment(nextMoment);

	environics.animateProgressBar();
	environics.positionMoments();
	
	//Re-set the interval
	environics.nextInterval = setInterval(environics.whatsHappeningNext, 5000);
};

environics.positionMoments = function() {
	
	var whtTitle = $('.wht-title');
	var whtMoments = $('.wht-moment.active');
	var bannerWidth = $('.whats-happening-today').width();
	var whtTitlePos = (bannerWidth - (whtTitle.width() + whtMoments.width())) / 2; //Calculate the position for whtTitle
	var whtMomentsPos = whtTitlePos + whtTitle.width();
	var whtMomentsMobilePos = (bannerWidth - whtMoments.outerWidth()) / 2;

	if ($(window).width() < 688) {
		//If the screen is mobile width, stack the wht Title and Moments
		whtMoments.css('left', whtMomentsMobilePos);
	}
	else {
	   //Else, position them side-by-side relative to screen size
	   whtTitle.css('left', whtTitlePos);
	   whtMoments.css('left', whtMomentsPos);
	}

};

environics.positionDots = function() {
	//Add an incremental left value to all dots
	$('.dot').each(function(index) {
	    $(this).css({
	        'left': (index * 16) + 'px',
	    });
	});
	environics.positionSuperDot();
};

environics.positionSuperDot = function() {
	$('.superdot').css('left', $('.dot.active').position().left);
};

environics.animateProgressBar = function() {
	//Initiate the banner line animation 
	$('.progress-bar').fadeIn(500).animate({
		width: '100%'
	}, 4000, function(){
		$('.progress-bar').fadeOut(500, function(){
			//animation complete
			$('.progress-bar').css('width', '0%');
		});
	});
};

environics.caseSlideIn = function() {
	var windowOffset = $(window).scrollTop() + $(window).height();
	var scrollBox = $('.page-home .featured .box');

	scrollBox.each(function() {
		if(windowOffset >= $(this).offset().top){
			$(this).addClass('scrolled');
		}
	});

	//When the user scrolls past a featured item box, add a class to trigger animation
	$(window).scroll(function(){
		var index;
		
		//Get the offset of the bottom of the window and the placement of the featured box
		for (index = 1; index < scrollBox.length + 1; ++index) {
	        var featuredOffset = $('#featured-box-' + index).offset();
	        var featuredHeight = $('#featured-box-' + index).height() / 2;
	        windowOffset = $(window).scrollTop() + $(window).height();

			if(windowOffset >= featuredOffset.top + featuredHeight){
				$('#featured-box-' + index).addClass('scrolled');
			}
		}
	});
};

environics.flickity = function() {
	$('.image-container.images').flickity({
		cellAlign: 'left'
	});
};

environics.socialShare = function() {
	$(".socialShareLink").click(function(e){
		e.preventDefault();
		var newwindow=window.open($(this).attr('href'),'','height=436,width=626');
        if (window.focus) {
        	newwindow.focus();
        }
	});
};


// Show and hide the video modal
environics.videoModal = function () {

	var videoWrapper = $('.video-wrapper');
	$(videoWrapper).html($(videoWrapper).data('iframe'));
	environics.fluidVids();

	// Click play button to show video modal
	$('.videoPlay').on('click', function(e){
		e.preventDefault();
		var videoBlock = $(this).parents('.video-container');
		var videoWrapper = $(videoBlock).find('.video-wrapper');
		$(videoWrapper).html($(videoWrapper).data('iframe'));
		var modal = $(videoBlock).find('.modal');
		$(modal).fadeIn();
		document.ontouchmove = function(e){ e.preventDefault(); };
		$('body').addClass('no-overflow');
		environics.fluidVids();
		environics.tabModal(-1);
	});
	var videoClose = function() {
		$('.video-wrapper').find("iframe").remove();
		$('.video-container .modal').fadeOut('fast');
		document.ontouchmove = function(){ return true; };
		$('body').removeClass('no-overflow');
		environics.tabModal(1);
	};
	// Click close button to close video modal
	$('.modal .close').on('click', function(){
		videoClose();
		
	});
	// Click outside video to close modal
	$('.video-container .modal').on('click', function(){
		videoClose();
	});
	// Hit enter on close div to close modal
	$('.modal .close').keypress(function (e) {
		var key = e.which;
		if(key === 13) {
			videoClose();
		}
	});
	$(document).keyup(function(e) {
		if (e.keyCode === 27) { // escape key maps to keycode `27`
			e.stopPropagation();
			videoClose();
		}
	});
	// Stop propagation of the click event if user clicks on the video.
	// In other words, don't close the modal, let them play the video.
	$('.video-wrapper').click(function(e){
	    e.stopPropagation();
	});
	
};

// Show and hide the infographic modal
environics.infographicModal = function () {


	//Click image to show modal
	$('.infographic-image').on('click', function(e) {
		e.preventDefault();
		$(this).next().fadeIn();
		document.ontouchmove = function(e){ e.preventDefault(); };
		$('body').addClass('no-overflow');
		environics.tabModal(-1);
	});

	var infographicClose = function() {
		$('.infographic-block .modal').fadeOut('fast');
		document.ontouchmove = function(){ return true; };
		$('body').removeClass('no-overflow');
		environics.tabModal(1);
	};

	// Click close button to close infographic modal
	$('.modal .close').on('click', infographicClose);

	// Click outside infographic to close modal
	$('.infographic-block .modal').on('click', infographicClose);

	// Hit enter on close div to close modal
	$('.modal .close').keypress(function (e) {
		var key = e.which;
		if(key === 13) {infographicClose();}
	});
	
	// Hit escape to close modal
	$(document).keyup(function(e) {
		if (e.keyCode === 27) { // escape key maps to keycode `27`
			e.stopPropagation();
			infographicClose();
		}
	});
	



	// Stop propagation of the click event if user clicks on the infographic.
	// In other words, don't close the modal, let them play the infographic.
	$('.infographic-wrapper').click(function(e){
	    e.stopPropagation();
	});
	
};

//Show and Hide Embed Copy Modal
environics.embedModal = function() {
	$('.copy-box').hide();
	$('.embed-infographic').on('click', function(e){
		e.preventDefault();
		// $('.copy-box').show();
		$(this).next().show();
	});
	
	// Click close button to close embed modal
	$('.copy-box .close').on('click', function() {
		$(this).parent().hide();
		$('.fa-check').css('opacity', '0');
		$('.copy-inside').css('opacity', '1');
	});

	// Hit enter on close div to close modal
	$('.copy-box .close').keypress(function (e) {
		var key = e.which;
		if(key === 13) {
			$('.copy-box').hide();
			uncheckOnClose();
		}
	});

	// Hit escape to close modal
	$(document).keyup(function(e) {
		if (e.keyCode === 27) { // escape key maps to keycode `27`
			e.stopPropagation();
			$('.copy-box').hide();
			uncheckOnClose();
		}
	});


	//show the checkmark once copy has been clicked & revert back to 'copy' on close
	$('.embed-success').on('click', function(){
		// Select the content
		document.querySelector(".embed-link").select();
		// Copy to the clipboard
		document.execCommand('copy');
		
		$('.fa-check').css('opacity', '1');
		$('.copy-inside').css('opacity', '0');
	});

	var uncheckOnClose = function() {
		$('.fa-check').css('opacity', '0');
		$('.copy-inside').css('opacity', '1');
	};
};


// Show and hide the form modal
environics.formModal = function () {
	// Click download button to show form modal
	$('#getReport').on('click', function(e){
		e.preventDefault();
		$('.report-form').fadeIn();
		document.ontouchmove = function(e){ e.preventDefault(); };
		$('body').addClass('no-overflow');
		environics.tabModal(-1);
	});

	var closeForm = function () {
		$('.report-form').fadeOut('fast');
		document.ontouchmove = function(){ return true; };
		$('body').removeClass('no-overflow');
		environics.tabModal(1);
	};
	// Click close button to close form modal
	$('.modal .close').on('click', function(){
		closeForm();
	});
	$('.modal .close').keypress(function (e) {
		var key = e.which;
		if(key === 13) {
			closeForm();
		}
	});
	$(document).keyup(function(e) {
		if (e.keyCode === 27) { // escape key maps to keycode `27`
			e.stopPropagation();
			closeForm();
		}
	});
};

environics.commentError = function () {
	$('#commentform').submit(function(e) {
		var email=$('#email').val();
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		
		if( !emailReg.test( email ) || $.trim($("#email").val()) === "") {
	    	$('.comment-form-email').append('<p class="comment-noval">Please enter a valid email</p>');
	        e.preventDefault();

	    } else if ($.trim($("#author").val()) === ""){
	    	$('.comment-form-author').append('<p class="comment-noval">Please enter your name</p>');
	        e.preventDefault();

	    } else if ($.trim($("#comment").val()) === ""){
	    	$('.comment-form-comment').append('<p class="comment-noval">Please enter some text</p>');
	        e.preventDefault();
	    }
	});
};

//Add a bottom margin to team member gallery filler squares for Firefox 

environics.resizeFiller = function() {
	var teamHeight = $('.filler-span').prev().find('img').height();
	$('.filler-span').css('height', teamHeight);
};

//Calulate the width of the sub nav container for mobile scrolling/overflow
environics.subnavWidth = function() {
	var wdth = 0;
	var endPadding = 30;

	if($('.sub-nav-container').length) {
		$('.sub-nav-container li').each(function() {
		    wdth += Math.ceil($(this).outerWidth(true));
		});
		$('.sub-nav').css('width', wdth + endPadding);
	}
	
	if($('.page-home').length){
		$('.sub-nav-container span:visible').each(function() {
		    wdth += $(this).width();
		});
		$('.sub-nav-container p').css('width', wdth + endPadding);
	}
};

//*****************************************************************
//* FluidVids.js - Fluid and Responsive YouTube/Vimeo Videos v1.0.0 by 
//* Todd Motto: http://www.toddmotto.com
//* Latest version: https://github.com/toddmotto/fluidvids
//* 
//* Copyright 2013 Todd Motto
//* Licensed under the MIT license
//* http://www.opensource.org/licenses/mit-license.php
//* 
//* A raw JavaScript alternative to FitVids.js, fluid width video embeds
//* 
environics.fluidVids = function() {
	var iframes = document.getElementsByTagName('iframe');

	for (var i = 0; i < iframes.length; i++) {
		var iframe = iframes[i];
		var players = /www.youtube.com|player.vimeo.com/;
		var iframeSrc = iframe.src;

		if(iframeSrc.search(players) !== -1) {
			iframe.src = "";
		
			var videoRatio = (iframe.height / iframe.width) * 100;

			iframe.style.position = 'absolute';
			iframe.style.top = '0';
			iframe.style.left = '0';
			iframe.width = '100%';
			iframe.height = '100%';
			iframe.webkitallowfullscreen = 'true';
			iframe.mozallowfullscreen = 'true';
			iframe.allowfullscreen = 'true';

			var div = document.createElement('div');
			div.className = 'video-wrap';
			div.style.width = '100%';
			div.style.position = 'relative';
			div.style.paddingTop = videoRatio + '%';

			var parentNode = iframe.parentNode;
			parentNode.insertBefore(div, iframe);
			div.appendChild(iframe);

			var extra;
			// Added the following code to add wmode=transparent to the 
			// end of youtube embeds to ensure they don't break 
			// z-indexing.
			if(iframeSrc.indexOf('youtube') !== -1  && $('.modal').length) {
				extra = "wmode=transparent&autoplay=1";
			}
			if(iframeSrc.indexOf('youtube') !== -1  && !$('.modal').length) {
				extra = "wmode=transparent";
			}

			//Add ability for vimeo videos to autoplay
			if(iframeSrc.indexOf('vimeo') !== -1 && $('.modal').length) {
				extra = "autoplay=1";
			}

			if(iframeSrc.indexOf('?') !== -1) {
				var getQString = iframeSrc.split('?');
				var oldString = getQString[1];
				var newString = getQString[0];
				
				iframeSrc = newString+'?'+extra+'&'+oldString;
			}
			else {
				iframeSrc = iframeSrc + '?' + extra;
			}

			iframe.src = iframeSrc;
		}
	}
};
