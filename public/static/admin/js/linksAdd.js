layui.config({
	base : "/static/admin/js/"
}).use(['form','layer','jquery','layedit','laydate'],function(){
	var form = layui.form(),
		layer = parent.layer === undefined ? layui.layer : parent.layer,
		laypage = layui.laypage,
		layedit = layui.layedit,
		laydate = layui.laydate,
		$ = layui.jquery;

	//创建一个编辑器
 	var editIndex = layedit.build('links_content');
 	var addLinksArray = [],addLinks;
 	form.on("submit(addLinks)",function(data){
 		//弹出loading
 		var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
 		//添加数据
		var linksData = $('form').serialize();
		$.ajax({
			url : "/admin/Manage/add",
			type : "post",
			dataType : "json",
			data: linksData,
			success : function(msg){
				if (msg.status == '1' ) {
					setTimeout(function(){
		            	top.layer.close(index);
						top.layer.msg(msg.msgs);
		 				layer.closeAll("iframe");
			 			//刷新父页面
			 			parent.location.reload();
        			},2000);		
				}else{
					setTimeout(function(){
		            	top.layer.close(index);
						layer.msg(msg.msgs,{icon: 2,time:2000});
        			},2000);
				}
					
			}
		})
 		return false;
 	})
	
})
