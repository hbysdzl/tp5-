;(function($){$.fn.fixed=function(options){var defaults={top:null,halfTop:false,durationTime:500}
var options=$.extend(defaults,options);this.each(function(){var thisBox=$(this),contentHeight=thisBox.height(),boxTop=null,defaultTop=thisBox.offset().top,halfTop=($(window).height()- contentHeight)/2
;if(options.top==null){boxTop=defaultTop;}else{boxTop=options.top;}
if(options.halfTop){boxTop=halfTop;}
thisBox.css("top",boxTop);$(window).bind("scroll",function(){var offsetTop=boxTop+ $(window).scrollTop()+"px";thisBox.animate({top:offsetTop},{duration:options.durationTime,queue:false});});});};})(jQuery);