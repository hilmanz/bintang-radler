$(document).ready(function() { 
						   
	
	
	$('#videobox').videoBG({
		position:"fixed",
		zIndex:0,
		mp4:'video/BintangRadler.mp4',
		ogv:'video/BintangRadler.ogv',
		webm:'video/BintangRadler.webm',
		poster:'video/BintangRadler.jpg',
		opacity:1,
		fullscreen:true,
		autoplay:false,
	});
	$( ".btnicon,.arrowBack2" ).click(function() {
		var targetID = jQuery(this).attr('href');
		$(targetID).toggleClass('playanim');
 	    return false;
	});
	$( ".arrowBack" ).click(function() {
		var targetID = jQuery(this).attr('href');
		$(".icon_beer").removeClass("active_beer");
		$(".icon_lemon").removeClass("active_lemon");
		$(targetID).toggleClass( "fadeInDowns" );
 	    return false;
	});
/*	$( "#home-beer .btnicon,#work-beer .btnicon,#food-beer .btnicon,#outdoor-beer .btnicon" ).mouseout(function() {
		$(".occasion").fadeOut();
		$(".occasion").removeClass("playanim");
 	    return false;
	});*/
  $(function() {
	$( ".icon_beer" ).click(function() {
		$( "#beer-desc" ).toggleClass( "fadeInDowns" );
		$(this).toggleClass( "active_beer" );
		 return false;
	});
  });
  $(function() {
	$( ".icon_lemon" ).click(function() {
	    $( "#lemon-desc" ).toggleClass( "fadeInDowns" );
	    $(this).toggleClass( "active_lemon" );
	    return false;
	});
  });

   if ($(window).width() < 640)
	{
		$( ".arrowBack" ).click(function() {
			$( "#menubox" ).toggle();;
			return false;
		});
		$( ".icon_beer" ).click(function() {
			$( "#menubox" ).toggle();
			 return false;
		});
		$( ".icon_lemon" ).click(function() {
			$( "#menubox" ).toggle();
			return false;
		});
  
		  $(function() {
			$( "#togglemobile" ).click(function() {
				$( ".flex-control-nav" ).toggle();
				 return false;
			});
		  });
	}
  
  // tes
	
    $(window).load(function(){
							
      $('.flexslider').flexslider({
        animation: "fade",
		animationLoop: false,
		slideshow: false,
		directionNav: false, 
		mousewheel: true,  
		pauseOnAction: true,           
		pauseOnHover: true,
        start: function(slider){
          $('body').removeClass('loading');
		   if ($(window).width() < 640)
			{
				$( "#menubox" ).click(function() {
					$( ".flex-control-nav").toggle();
					 return false;
				});
			}
        }
      });
    });

});
