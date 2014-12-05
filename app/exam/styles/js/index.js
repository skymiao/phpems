/* $Id: content_js/index.js.js,v 1.7 2011/06/14 07:50:59 xuerong Exp $ */


// 全局widget
$(function(){
	//tab效果 在tab 后加上tabHover则是滑动效果
	$(".tab li").hover(function() {
		var href = $(this).children("a").attr("href");
		if ($(href).hasClass("tab-panel")){
			$(this).addClass("current").siblings().removeClass("current");
    	    $(href).show().siblings(".tab-panel").hide();
			return false;
		}
	});

	$(".tabHover li").hover(function() {
		var href = $(this).children("a").attr("rel");
		if ($(href).hasClass("tab-panel")){
			$(this).addClass("current").siblings().removeClass("current");
    	    $(href).show().siblings(".tab-panel").hide();
			return false;
		}
	});

	$("a.toggle").click(function() {
		if ($(this).hasClass("unclickable")) {
			return false;
		}
		var me = $(this), href=$(this).attr("href");
		$(href).toggle();
		me.toggleClass("open");
		return false;
	});

	$("a.collapsible").each(function(){
		var me = $(this), href = me.attr("href"), hd = me.parents(".menu-hd");

		if (hd.length > 0) { // 是在menu-hd里，绑定hover切换效果
			me.parents('.menu').hover(
				function(){
					if (href=="#dongao-nav") { // 服务导航，现ajax取数据
						$("#dongao-nav").load("/nav.htm").show();
					} else {
						$(href).show();
					}
					me.addClass("open");
					hd.addClass("selected");
					return false;
				},
				function(){
					$(href).hide();
					me.removeClass("open");
					hd.removeClass("selected");
					return false;
				}
			);

			if (me.attr("rel") && me.attr("rel")!='') { //如果有rel属性，那么允许点击，并定位到rel地址
				me.click(function() {
					if(me.attr("rel")=='reload')window.location.reload;
					else
					window.location.href = me.attr("rel");
					return false;
				});
			} else { // 没有rel属性，则不允许点击
				me.click(function() {
					return false;
				});
			}
		} else { // 独立的a.collapsible，绑定click效果
		    if (me.hasClass("ajax")) { // ajax模式
				me.toggle(
				    function(){
						$(this).addClass("open");
						$(href).load(me.attr("rel")).show();
						return false;
					},
					function() {
						$(this).removeClass("open");
						$(href).hide();
						return false;
					}
				);

			} else {
				me.click(function(){
					$(href).toggle();
					me.toggleClass("open");
					return false;
				});
			}

		}
	});
	//学员心声滚动
	$(function() {
		//cache the ticker
		var ticker = $("#voice");
		//wrap dt:dd pairs in divs
		ticker.children().filter("li").each(function() {
		  var dt = $(this),
		    container = $("<div>");
		  dt.next().appendTo(container);
		  dt.prependTo(container);
		  container.appendTo(ticker);
		});
		//hide the scrollbar
		ticker.css("overflow", "hidden");
		//animator function
		function animator(currentItem) {
		  //work out new anim duration
		  var distance = currentItem.height();
			duration = (distance + parseInt(currentItem.css("marginTop"))) / 0.025;
		  //animate the first child of the ticker
		  currentItem.animate({ marginTop: -distance }, duration, "linear", function() {
			//move current item to the bottom
			currentItem.appendTo(currentItem.parent()).css("marginTop", 0);
			//recurse
			animator(currentItem.parent().children(":first"));
		  });
		};
		//start the ticker
		animator(ticker.children(":first"));
		//set mouseenter
		ticker.mouseenter(function() {
		  //stop current animation
		  ticker.children().stop();
		});
		//set mouseleave
		ticker.mouseleave(function() {
          //resume animation
		  animator(ticker.children(":first"));

		});
	  });

});