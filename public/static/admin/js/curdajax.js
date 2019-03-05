
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

function ajaxedit() {
	//修改管理员
	$(".layui-btn-normal").click(function(){
		var id = $(this).attr('id');
		var index = layui.layer.open({
			title : "修改管理员",
			type : 2,
			content : "/admin/Manage/edit/id/"+id,
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
function ajaxdel() {
	$('.layui-btn-danger').on('click',function () {
        id = $(this).attr('id');
        layer.confirm('确定要删除该管理员吗?', {icon: 3, title:'系统提示'}, function(index){ 
			$.get("{:url('delete')}",{id:id},function(msg){
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

//复选框全选
function checkboxs() {
	//全选
	form.on('checkbox(allChoose)', function(data){
		var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"])');
		child.each(function(index, item){
			item.checked = data.elem.checked;
		});
		form.render('checkbox');
	});

	//通过判断文章是否全部选中来确定全选按钮是否选中
	form.on("checkbox(choose)",function(data){
		var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"])');
		var childChecked = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"]):checked')
		data.elem.checked;
		if(childChecked.length == child.length){
			$(data.elem).parents('table').find('thead input#allChoose').get(0).checked = true;
		}else{
			$(data.elem).parents('table').find('thead input#allChoose').get(0).checked = false;
		}
		form.render('checkbox');
	})
}

	