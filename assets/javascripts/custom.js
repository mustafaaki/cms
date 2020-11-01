$( document ).ready(function() {

  "use strict";

  var $headerAbout  = $(".header-about");
  var $contentAbout = $(".content-about");
  var $bannerVideo  = $("#banner-video");
  var $jsIntro      = $("#js-intro");

  function pageRedirect(url) {
	  
      window.location = url;
  }      
/* 
=============================================== 
Maillist
=============================================== 
*/
  $("body").on('click','button[id="submit-button"]',function(event) {
	var email_list; 
	email_list =  $("#mail-list").val();
	$('.input__label-content').html('');
	var regex = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+.)+([.])+[a-zA-Z0-9.-]{2,6}$/;
	
	if (regex.test(email_list)==true){
		var email_url= baseUrl + "my_app/email_list_save";
		
		$.ajax({
	    	type: "POST",
	    	dataType:'html',
	    	url: email_url,
	    	data: 'email=' + email_list + '&lng=' + pageLng,
	    	success: function(msg) {
	    		alert(msg);
	    			    
	    	}
	    });
	}else{
		alert("Error: Check your email!");
	}
  });
  
  
  
/* 
=============================================== 
Slider About Effect
=============================================== 
*/

  //Every resize of window
  $(window).resize(sizeContent);

  //Dynamically assign height
  function sizeContent() {
  // var newHeight = 450 + "px";
  $headerAbout.css("height", newHeight);
  $contentAbout.css("top", newHeight);
  }

  //Fade header on scroll
  $(window).scroll(function(){
    $headerAbout.css("opacity", 1 - $(window).scrollTop() / 500);
  });

/* 
=============================================== 
Slider Home Effect
=============================================== 
*/
  var videoClick=1;
  var bannerPrefixName, componentPrefixName;
  var componentPrefixName = [10,9,8,7,6,5,4,3,2,1]
  $.each(componentPrefixName, function( index, value ) {
    $(".active-" + value).on('click', function(){
    	
      $(".act-" + value).removeClass("hide");
      $bannerVideo.addClass("hide");

      var bannerPrefixName = value
      $(".banner-" + bannerPrefixName).removeClass("hide");

      $.each(componentPrefixName, function(index, _value) {
        if(bannerPrefixName == _value){ return true; }
        $(".banner-" + _value).addClass("hide");
      })

      $.each(componentPrefixName, function(index, _value) {
        if(value == _value){ return true; }
        $(".act-" + _value).addClass("hide");
      })
    });
  });
  
  $jsIntro.on("click", function(){
	videoClick++;
	var vid = document.getElementById("vid-100"); 
	if(videoClick%2==0){
		$('#js-intro > i').removeClass('fa fa-play');
		$('#js-intro > i').addClass('fa fa-pause');
		vid.play(); 
	}else{
		$('#js-intro > i').removeClass('fa fa-pause');
		$('#js-intro > i').addClass('fa fa-play');
		vid.pause();
	}
    $bannerVideo.removeClass("hide");
    $(".banner-1, .banner-2, .banner-3, .banner-4, .banner-5, .banner-6, .banner-7, .banner-8").addClass("hide");
    $("body").scrollTop(0);
    
  });

/* 
=============================================== 
Slider Destination Effect
=============================================== 
*/
  var destinationPrefixName, desPrefixvalue;
  var destinationPrefixName = [1,2,3,4,5,6,7,8,9,10]
  $.each(destinationPrefixName, function( index, value ) {
    $(".active-" + value).on('click', function(){
      $.each(destinationPrefixName, function(index, _value) {
        if(value == _value){ $(".act-" + value).removeClass("hide"); }
        else { $(".act-" + _value).addClass("hide");  }
      })
      desPrefixvalue = value
      $.each(destinationPrefixName, function(index, _value) {
       
        if(desPrefixvalue == _value){ $(".des-" + _value).removeClass("hide"); }
        else { $(".des-" + _value).addClass("hide"); }
      })
    });
  });

/* 
=============================================== 
Slider Slick Effect
=============================================== 
*/

  $('.homeslick').slick({
    centerMode: true,
    centerPadding: '150px',
    slidesToShow: 3,
    arrows: false,
    focusOnSelect: true,
    dots: true,
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          centerPadding: false
        }
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          centerPadding: false
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          centerPadding: false
        }
      }
     
    ]
  });

/* 
=============================================== 
Slider Slick Testimony
=============================================== 
*/

  $('.slidetestimony').slick({
    dots: true,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    adaptiveHeight: true,
    responsive: [
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          centerPadding: false
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          centerPadding: false,
          arrows: false
        }
      }
    ]
  });

/* 
=============================================== 
Parallax Effect
=============================================== 
*/

  window.addEventListener('scroll', function(event) {
    var depth, layer, layers, movement, topDistance, translate3d, _i, _len;
    topDistance = this.pageYOffset;
    layers = document.querySelectorAll("[data-type='parallax']");
    for (_i = 0, _len = layers.length; _i < _len; _i++) {
      layer = layers[_i];
      depth = layer.getAttribute('data-depth');
      movement = -(topDistance * depth);
      translate3d = 'translate3d(0, ' + movement + 'px, 0)';
      layer.style['-webkit-transform'] = translate3d;
      layer.style['-moz-transform'] = translate3d;
      layer.style['-ms-transform'] = translate3d;
      layer.style['-o-transform'] = translate3d;
      layer.style.transform = translate3d;
    }
  });

/* 
=============================================== 
Scroll Header
=============================================== 
*/

  $(window).scroll(function(){ 
  var scroll = $(window).scrollTop();
    if( scroll > 870 ){    
      $(".navbar-safaria").addClass("navbar-black");     
    } else {
      $(".navbar-safaria").removeClass("navbar-black");
    }
  });

  $(".js-search").on("click", function(){
    $("#js-search").removeClass("hide");
  });

  $(".js-login").on("click", function(){
    $("#js-login").removeClass("hide");
  });

  $(".js-menu").on("click", function(){
    $("#js-menu").removeClass("hide");
  });

  $('.close-pop').on('click', function(){
    $('#js-search').addClass('hide');
    $('#js-login').addClass('hide');
    $('#js-menu').addClass('hide');
  });

/* 
=============================================== 
Scroll About Point
=============================================== 
*/

  var $menu = $(".js-about-point")
  var headerHeight = $(".header-about").outerHeight(true);
  var contentHeight = $(".content-about").outerHeight(true);

  $(window).scroll(function(){ 
    var scroll = $(window).scrollTop();
    if (scroll > headerHeight && scroll < contentHeight) {
      $menu.addClass("box-fixed").removeClass("box-fixed-bottom");
    } else if (scroll > contentHeight) {
      $menu.addClass("box-fixed-bottom").removeClass("box-fixed");
    } else{
      $menu.removeClass("box-fixed").removeClass("box-fixed-bottom");
    }
  });

  $('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 2000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
  });

});