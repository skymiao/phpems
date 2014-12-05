$(function(){
	$("#lesson_menu .menu-bd a").click(function(){
		$('#lesson_menu #lesson-current a').text($(this).text()); // 设置当前选中的搜索类别label	
		$(this).parents("#lesson_menu .menu-bd").hide().siblings("#lesson_menu .menu-hd").removeClass("selected");  // 让下拉菜单隐藏, 取消选择状态
		$("#lesson_menu .menu-hd #lesson-current a.collapsible").removeClass("open"); // 让类别选择器恢复到收起状态
		return false;
	});
});

$(function(){
	$("#show_menu .menu-bd a").click(function(){
		$('#show_menu #show-current a').text($(this).text()); // 设置当前选中的搜索类别label	
		$(this).parents("#show_menu .menu-bd").hide().siblings("#show_menu .menu-hd").removeClass("selected");  // 让下拉菜单隐藏, 取消选择状态
		$("#show_menu .menu-hd #show-current a.collapsible").removeClass("open"); // 让类别选择器恢复到收起状态
		return false;
	});
});

$(function(){
	$("#anew_menu .menu-bd a").click(function(){
		$('#anew_menu #anew-current a').text($(this).text()); // 设置当前选中的搜索类别label	
		$(this).parents("#anew_menu .menu-bd").hide().siblings("#anew_menu .menu-hd").removeClass("selected");  // 让下拉菜单隐藏, 取消选择状态
		$("#anew_menu .menu-hd #anew-current a.collapsible").removeClass("open"); // 让类别选择器恢复到收起状态
		return false;
	});
});
