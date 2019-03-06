
function ajaxadd(btn,title,url) {
	//添加管理员
	$("."+btn).click(function(){
		var index = layui.layer.open({
			title : title,
			type : 2,
			content : url,
			success : function(layero, index){
				layui.layer.tips('点击此处返回列表', '.layui-layer-setwin .layui-layer-close', {
					tips: 3
				});
			}
		})
		//改变窗口大小时，重置弹窗的高度，防止超出可视区域（如F12调出debug的操作）
		$(window).resize(function(){
			layui.layer.full(index);
		})
		layui.layer.full(index);
	})
}

function ajaxedit(title,url) {
	//修改管理员
	$(".layui-btn-normal").click(function(){
		var id = $(this).attr('id');
		var index = layui.layer.open({
			title : title,
			type : 2,
			content : url+'/id/'+id,
			success : function(layero, index){
				layui.layer.tips('点击此处返回列表', '.layui-layer-setwin .layui-layer-close', {
					tips: 3
				});
			}
		})
		//改变窗口大小时，重置弹窗的高度，防止超出可视区域（如F12调出debug的操作）
		$(window).resize(function(){
			layui.layer.full(index);
		})
		layui.layer.full(index);
	})
}


//删除
function ajaxdel(url) {
	$('.layui-btn-danger').on('click',function () {
        id = $(this).attr('id');
        layer.confirm('确定要删除操作吗?', {icon: 3, title:'系统提示'}, function(index){ 
			$.get(url,{id:id},function(msg){
				if (msg.code == '1') {
						layer.msg(msg.msg);
	 				setTimeout(function(){
	 					window.location.reload();
	 				},1000);
				}else{
					layer.msg(msg.msg);
				}
			},'json');
            layer.close(index);
        });
	          
	})
}


//数据提交表单
function addformData(form,urls) {
	
 	form.on("submit(addData)",function(data){
 		//弹出loading
 		var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.6});
		$.ajax({
			url : urls,
			type : "post",
			dataType : "json",
			data: $('form').serialize(),
			success : function(res){
				if (res.code == '1' ) {
					setTimeout(function(){
		            	top.layer.close(index);
						top.layer.msg(res.msg);
		 				layer.closeAll("iframe");
			 			//刷新父页面
			 			parent.location.reload();
        			},2000);		
				}else{
					setTimeout(function(){
		            	top.layer.close(index);
						layer.msg(res.msg,{icon: 2,time:2000});
        			},2000);
				}
					
			}
		})
 		return false;
 	})
}



	