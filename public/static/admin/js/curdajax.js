layui.config({
	base : "/static/admin/js/"
}).use(['form','layer','jquery','laypage'],function(){
	var form = layui.form(),
		layer = parent.layer === undefined ? layui.layer : parent.layer,
		laypage = layui.laypage,
		$ = layui.jquery;
	
 
})


function ajaxadd() {
	//添加管理员
	$(".linksAdd_btn").click(function(){
		var index = layui.layer.open({
			title : "添加管理员",
			type : 2,
			content : "/admin/Manage/add",
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
	

	