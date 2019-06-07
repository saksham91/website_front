/************* functions *****************************************************/ 	
function stageMargin() {
		"use strict";
        var headerHeight = $(".header").height();    
        if ($(window).width() < 1200) {
            $(".stage").css("margin-top", "0"); 
        }
        else {           			
            $(".stage").css("margin-top", headerHeight); 
        }
}

$(function () {
"use strict";
  $('[data-toggle="tooltip"]').tooltip();
});

/* initialize bootstrap popovers */
$(function () { 
	"use strict";
    $('.toggle-popover').popover({'trigger': 'toggle', 'placement':'top'});

    $('.mp-pusher').on('touchstart', function(e) {
        if($(e.target).hasClass('toggle-popover')) {
          $(e.target).popover('toggle');
        }
        if(!$(e.target).parent().hasClass('popover')) {
              $('.popover').prev('a').not(e.target).popover('toggle');
        }
    });
});

/************* functions end **************************************************/ 	

$( document ).ready(function() {
/************************ document ready begin ********************************/    
 /* mobile menu */
new mlPushMenu(document.getElementById('mp-menu'), document.getElementById('trigger-menu'), {			
	type : 'cover'
 });
/* varaibles */    
    var headerHeight = $(".header").height();     
/* varaibles end */    
    
/* stage */     
    //$(".stage").css("margin-top", headerHeight); 
    stageMargin();
/* stage end */
  
/* initialize bootstrap dropdown on hover */
   $('[data-toggle="dropdown"]').bootstrapDropdownHover();
/* Add fade in animation to dropdown */
    $('.dropdown').on('show.bs.dropdown', function(e){		
      $(this).find('.dropdown-menu').first().stop(true, true).fadeToggle(500);
    });
/* Add fade out animation to dropdown */
    $('.dropdown').on('hide.bs.dropdown', function(e){
      $(this).find('.dropdown-menu').first().stop(true, true).fadeToggle(500);
    });


/* position of arrow element for dorpdown-module and bootstrap dropdown */
$(".dropdown-module").each(function(e){         
    var parentWidth = $(this).parent().width()/2; 
    $(this).prepend($("<div class='dropdown-module-before'></div>").css("left",parentWidth));        
});
$(".dropdown-menu").each(function(e){         	
    var parentWidth = $(this).parent().width()/2-10; 
    $(this).prepend($("<div class='dropdown-menu-before'></div>").css("left",parentWidth));        
});





/* smooth scroll */
$(function() {
  $('a[href*=\\#]:not([href=\\#])').click(function() {
    if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $(window).animate({
          scrollTop: target.offset().top - headerHeight - 50
        }, 1000);        
        return false;
      }
    }
  });  
}); 

/* top button */
$(window).scroll(function(){
    if($(window).scrollTop() > 220){
        $('.top-button').fadeIn();            
    }else{
        $('.top-button').fadeOut();            
    }
});

$(".top-button").click(function() {
  $("html").animate({ scrollTop: 0 }, "slow");
  return false;
});


/************* document ready end ********************************************/ 	
});
    
    
/************** Window resize function ****************************************/
$(window).on('resize', function(){
    /* stage */    
	"use strict";
        stageMargin();
    /* stage end */    
        
});

/************** Window load function ******************************************/
$(window).on('load', function(){
	/* stage */  
	"use strict";
        stageMargin();
    /* stage end */  
});






