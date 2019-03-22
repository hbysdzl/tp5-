$(function(){
	//服务toggle效果
	$('.accordion-handle').on('click',function(){
		var obj=$(this);
		$(".accordion-pane").slideUp();
		$(".accordion-handle").removeClass('current');
		obj.addClass('current');
		obj.next('.accordion-pane').slideDown();
	});
	//摄影作品
	$('.tabs-nav li').on('click',function(){
		$('.tabs-panes>.tab-box').slideUp();
		$('.tabs-nav li>a').removeClass('current');
		var ind=$(this).index();
		$(this).find('a').addClass('current');
		$('.tabs-panes').find('.tab-box:eq('+ind+')').slideDown();
	});
	//返回顶端
	$(window).scroll(function(){
		var top=$(window).scrollTop();
		if(top>450){
			$('.gotop').css('display',"block");
		}else{
			$('.gotop').fadeOut('slow');
		}
	});
	//返回顶端
	$('.gotop').on('click',function(){
		gtop(3);
	});
	
});
function gtop(speed){
	var top=$(window).scrollTop();
	var step=5;
	var timer=setInterval(function(){
		top=top-step;
		step+=speed;
		if(top<=0){
			$(window).scrollTop(0);
			clearInterval(timer);
		}else{
			$(window).scrollTop(top);
		}
	},15);
	
}
