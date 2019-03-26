$(window).on('load', function(){
	Main.init();
	Main.setParallaxHeight(); 
	$('#loader').fadeOut();
});
$(window).on('resize', function(){
	Main.setParallaxHeight();
	Main.setElementsHeight();
});
var Main = (function($){
	return {
		//inits
		init: function(){
			Main.events();
			Main.setElementsHeight();
			Main.setParallaxHeight();
			// Main.countdownInit();
		},
		//events
		events: function(){
			$(document).on('click','#submit_form_btn',function(){
				var v			= true;

				username 	= $("#username").val()
				password 	= $("#password").val()
				code 		= $("#code").val()
				if(username == ''){
					v = false;
					$("#username").attr('style','border:1px solid #000');
					$("#username").attr('placeholder','用户名不得为空！');
					return false;
				}
				if(password == ''){
					v = false;
					$("#password").attr('style','border:1px solid #000');
					$("#password").attr('placeholder','密码不得为空！');
					return false;
				}
				
				if(code == ''){
					v = false;
					$("#code").attr('style','border:1px solid #000');
					$("#code").attr('placeholder','验证码不得为空！');
					return false;
				}

				if(v){
					Main.sendLogin(username,password,code);
				}
			});

		},
		//functions
		setParallaxHeight: function(){
			var height = $(window).height();
			$('#christmas_scene .layer-photo').css('height', height);
		},
		sendLogin:function(username,password,code){
			$.ajax({
				url: '/admin/Login/login',
				type: 'post',
				data: { "username": username, "password": password, "code": code},
				success: function(res){
					if (res.code == '1') {
                    	window.location.href = "/admin/Index/index";
	                }else{
	                    alert(res.msg);
	                }
				},
				error: function( jqXhr, textStatus, errorThrown ){
					console.log( errorThrown );
				}
			});
		},
		isEmail: function(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		},
		setElementsHeight: function(){
			var height = $(window).height();

			if( height <= 400){
				var width = $(window).height() / 2;
			}else if( height <= 500 ){
				var width = $(window).height() / 3.5;
			}else if( height <= 700 ){
				var width = $(window).height() / 3;
			}else if( height <= 800 )
			var width = $(window).height() / 2.8;
			else{
				var width = $(window).height() / 2.5;
			}
			$('#christmas_tree').css({ 'width' : width,
				'margin-left' : -(width/2)
			});
			$('#mail_pole').css('margin-left', -(width/1.2));
			$('#mail_pole img').css('width', width/3);
		},
		// countdownInit: function(){
		// 	$('#countdown_container').countdown('2019/3/26',function(event) {
		// 		$(this).html(event.strftime('<div class="col-md-3 col-xs-3 countdown-globe">%D<div class="col-md-12 padding-none">Days</div></div>\
		// 			<div class="col-md-3 col-xs-3 countdown-globe">%H<div class="col-md-12 padding-none">Hours</div></div>\
		// 			<div class="col-md-3 col-xs-3 countdown-globe">%M<div class="col-md-12 padding-none">Minutes</div></div>\
		// 			<div class="col-md-3 col-xs-3 countdown-globe">%S<div class="col-md-12 padding-none">Seconds</div></div>'));
		// 	});
		// }
	}
})($);

function getLocalTime(nS) {     
    return new Date(parseInt(nS) * 1000).toLocaleString().substr(0,17)}     
//alert(getLocalTime(1293072805));  
