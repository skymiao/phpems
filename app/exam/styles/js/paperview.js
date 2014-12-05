	var currentquestion = 0;
	var questionaddtion = 0;
	var currenttype = 0;
	var currentqtid = '';
	var currentqid = '';
	var alltypenumber = $('.questypearea').length;
	var allquestionnumber = $('.qu_content').length;
	var typenumber = new Array();
	var k = 0;
	var initquestion = function(){
			currenttype = 0;
			currentquestion = 0;
			questionaddtion = 0;
			$('.qu_content').hide();
			$('.questypearea').hide();
			$('[name="qbar"]').show();
			$('[name="qtbar"]').hide();
			currentqtid = $('.questypearea').eq(currenttype).attr('id');
			currentqid = $('.qu_content').eq(currentquestion).attr('id');
			$('#'+currentqtid).show();
			$('#'+currentqid).show();
			while(k < alltypenumber)
			{
				typenumber[k] = $('.questypearea:eq('+k+') > .qu_content').length;
				k++;
			}
		}
	var nextquestion = function(){
			questionaddtion++;
			if(questionaddtion >= typenumber[currenttype]){
				currenttype++;
				if(currenttype >= alltypenumber)
				{
					currenttype = alltypenumber - 1;
					currentquestion = allquestionnumber - 1;
					questionaddtion = typenumber[currenttype] - 1;
					alert('这是最后一题！');
					return true;
				}
				else
				questionaddtion = 0;
			}
			$('#'+currentqtid).hide();
			$('#'+currentqid).hide();
			currentqid = $('.qu_content').eq(currentquestion).attr('id');
			currentqtid = $('.questypearea').eq(currenttype).attr('id');
			$('#'+currentqid).show('fast');
			$('#'+currentqtid).show('fast');
			currentquestion ++;
		}
	var prevquestion = function(){
			questionaddtion--;
			if(questionaddtion < 0){
				currenttype--;
				questionaddtion = typenumber[currenttype] - 1;
			}
			if(currentquestion <= 0)
			{
				alert('这是最后一题！');
				questionaddtion = 0;
				currentquestion = 0;
				currenttype = 0;
				currentqid = $('.qu_content').eq(0).attr('id');
				currentqtid = $('.questypearea').eq(0).attr('id');
				$('#'+currentqid).show('fast');
				$('#'+currentqtid).show('fast');
				return true;
			}
			$('#'+currentqtid).hide();
			$('#'+currentqid).hide();
			currentquestion--;
			currentqid = $('.qu_content').eq(currentquestion).attr('id');
			currentqtid = $('.questypearea').eq(currenttype).attr('id');
			$('#'+currentqid).show('fast');
			$('#'+currentqtid).show('fast');
		}
	var inittype = function(){
			currenttype = 0;
			$('.qu_content').show();
			$('.questypearea').hide();
			$('[name="qtbar"]').show();
			$('[name="qbar"]').hide();
			currentqtid = $('.questypearea').eq(currenttype).attr('id');
			$('#'+currentqtid).show("fast");
	}

	var nexttype = function(){
			currenttype++;
			if(currenttype >= alltypenumber)
			{
				alert('这是最后一题了');
				currenttype = alltypenumber-1;
			}
			else
			{
				$('#'+currentqtid).hide();
				currentqtid = $('.questypearea').eq(currenttype).attr('id');
				$('#'+currentqtid).show("fast");
			}
	}

	var prevtype = function(){

			if(currenttype <= 0)
			{
				alert('这是最后一题了');
				currenttype = 0;
			}
			else
			{
				currenttype--;
				$('#'+currentqtid).hide();
				currentqtid = $('.questypearea').eq(currenttype).attr('id');
				$('#'+currentqtid).show("fast");
			}
	}

	var initpaper = function(){
		$('[name="qbar"]').hide();
		$('[name="qtbar"]').hide();
		$('.qu_content').show();
		$('.questypearea').show();
	};
	
	//float 跟随
	(function(){
		var oDiv=document.getElementById("float");
		if ( oDiv == undefined ) return false;
		var H=0,iE6;
		var Y=oDiv;
		while(Y){H+=Y.offsetTop;Y=Y.offsetParent};
		iE6=window.ActiveXObject&&!window.XMLHttpRequest;
		function myscroll(){
			var s=document.body.scrollTop||document.documentElement.scrollTop;
			if (s >H ){
				oDiv.className = "float_div1 float_div2";
				if(iE6){oDiv.style.top=(s-H)+"px";}
			}
			else
				oDiv.className = "float_div1";	
		}
		if(!iE6 || true){
			window.onscroll= buffer(myscroll,150,this );
		}
	})();
