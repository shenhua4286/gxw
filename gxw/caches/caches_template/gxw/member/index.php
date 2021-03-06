<?php defined('IN_gxw') or exit('No permission resources.'); ?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="UTF-8">
<title>长沙市工业和信息化项目库管理系统</title>
<link href="<?php echo CSS_PATH;?>/gxw/css/base.css" rel="stylesheet"
	type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_PATH;?>/gxw2/css/ics.css" />
<script type="text/javascript"
	src="<?php echo CSS_PATH;?>/gxw2/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript"
	src="<?php echo CSS_PATH;?>/gxw2/js/jquery.tmpl.min.js"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo JS_PATH;?>content_addtop.js"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo JS_PATH;?>dialog.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>gxw.js"></script>
<link href="<?php echo CSS_PATH;?>dialog.css" rel="stylesheet" type="text/css" />
<style>
.nav-active {
	color: #02A1D0 !important;
	font-weight: 700;
}

.w-cont-act {
	background: #fff;
	border: 1px solid #d9dadc;
}

.w-cont-act .frame {
	border-left: 1px solid #eaeaea;
}

.zh-info {
	float: left;
}

.zh-info a {
	line-height: 18px;
}

.l-out {
	float: right;
	padding-top: 4px;
	padding-left: 9px;
	/* border-left: 1px solid #fff; */
	margin-left: 13px;
	margin-top: 4px;
	padding-bottom: 1px;
	font-weight: 700;
}

.l-out	a {
	border: 1px solid #eee;
	padding: 6px;
	border-radius: 2px;
}

.l-out	a:hover {
	background: #868686;
}

.news {
	background: red;
	color: #fff;
	padding: 2px;
	font-size: 10px;
}
</style>
<body style="overflow: auto;">
			<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"message\" data=\"op=message&tag_md5=6148979e8152595f69c4eb2d2a5ebab7&action=check_new\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$message_tag = pc_base::load_app_class("message_tag", "message");if (method_exists($message_tag, 'check_new')) {$data = $message_tag->check_new(array('limit'=>'20',));}?> 
				<?php $news_data=$data;?> 
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
	<div class="i-header">
		<div class="w1200">
			<div class="logo i-fl">
				<img class="logotu" src="<?php echo CSS_PATH;?>/gxw2/img/logo66.gif" alt=""
					/ width="80px"> <a href="index.php"
					class="logoinfo i-fl">
					<div class="hehe">长沙市工业和信息化项目库管理系统</div>
					<div class="hemin">—&nbsp;全 球 视 野 / 工 业 之 都</div>
				</a>
			</div>
			<div id="memberinfo" style="float: right; margin-top: 29px; font-size: 12px; margin-left: 12px;">
				<div class="zh-info relative">
					
				</div>
				<li class="l-out"><a onclick="loadMenu(27);menu(27);" href="<?php echo APP_PATH;?>index.php?m=member&c=index&a=login" target="main">马上登录</a></li>
				<!-- <li><a href="index.php?m=admin&c=index&a=login">管理登录</a></li> -->
			</div>
			<div class="right-info">
				
				<div class="tq ifr tqqili">
					<div class="tianqi-box">
						<span>长沙</span> <span class="tqpng"> </span> <span
							class="sheshidu" style="width: 70px;">26℃</span>

					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
	var userid=null;
    $(function(){
    	$.ajax({
    	      url : 'http://api.map.baidu.com/telematics/v3/weather?location= 长沙&output=json&ak=XGnXhb5r9ofOnLy949arfNjP',
    	      dataType : 'jsonp',
    	      success : function(data){
    	        
    	        var tqUrl = data.results[0].weather_data[0].dayPictureUrl;
    	        var tqSsd = data.results[0].weather_data[0].temperature;
    	        var tqPm = data.results[0].pm25;
    	        $('.sheshidu').html(tqSsd+'</br>PM2.5：'+tqPm)
    	        if(tqUrl.indexOf('qing')>=0){
    	          $('.tqpng').addClass('tq-qing')
    	        }else if(tqUrl.indexOf('yun')>=0){
    	          $('.tqpng').addClass('tq-yun')
    	        }
    	      }
    	    });
    	
    	/**加载日历**/
		/*var url="index.php?m=member&c=index&a=public_day";
		$.getJSON(url,function(data){
			var ri=data.msg;
			$("#ri_nar").html(ri.lunar+"</br>"+ri.solar);
			$("#ri_day").html(ri.day);
		});*/
		memberinfo();
    });
    
	function memberinfo(){
		//alert('我执行了。');
		if(userid == null){ //用户未登录
			var url="index.php?m=content&c=index&a=memberinfo&t="+new Date();
			$.getJSON(url,function(data){
					if(data.status){
						var user=data.msg;
						userid=user.userid;//用户已登录
						$("#nickname").text(user.nickname);
						$("#member_status").text(user.status);
						var str='<div class="zh-info"><li>你好，<span id="nickname">'+user.nickname+'</span> &nbsp;&nbsp; <span class="laba"></span>'
								+'<a onclick="menu_activityIndex=7;loadMenu(27);menu(27);" href="index.php?m=message&c=index&a=inbox&&t=8&menu=1" target="main">消息'
								+0+'</a>'//php?m=member&c=index&a=logout
								+'<li>审核状态：<span id="member_status">'+user.status+'</span></li></div>'
								+'<li class="l-out"><a href="<?php echo APP_PATH;?>index.php?m=member&c=index&a=logout">退出账户</a></li>'
						$("#memberinfo").html(str);
					
						if(user.groupid >12){// 企业以上会员
							$("#nav").append('<a onclick="loadMenu(29);menu(29);" href="javascript:openIndex(0);">层级管理</a><span>|</span>');
						}		
								
					}else{  //用户未登录
						
						<!-- 未登录会员，将资金申报 href转向登录 -->
						/* var a=$(".relative").find("a");
						var href='index.php?m=member&c=index&a=center&catid=9&t=27';
						$(a[7]).attr("href",href).attr("target",'main');
						$(a[8]).attr("href",href).attr("target",'main'); */
						
					}
			});
		}
	}
	
    </script>



	<?php $t=$_GET['t']; if(!isset($t)){$t=4;} $pt=isset($_GET['pt']) ? $_GET['pt'] :$t;?> 
	<?php $siteinfo = siteinfo($this->memberinfo['siteid']);?> 
	<?php $this->menu_db = pc_base::load_model('member_menu_model');?> 
	<?php if($_groupid > 12){$menu_num=9;}else{$menu_num=9;}?> 
	<?php $menu = $this->menu_db->select(array('display'=>1, 'parentid'=>0), '*', $menu_num , 'listorder');?>
	<div class="navbar">
		<ul class="w1200 relative" id="nav" >
			<?php $n=1; if(is_array($menu)) foreach($menu AS $k => $v) { ?> 
				<?php if($v['isurl']) { ?> 
					<?php $href=$v['url']?> 
				<?php } else { ?> 
					<?php $href="index.php?m=".$v['m']."&c=".$v['c']."&a=".$v['a']."&".$v['data']."&t=".$v['id'];?>
				<?php } ?>
				<a id="a_<?php echo $v['id'];?>" onclick="loadMenu(<?php echo $v['id'];?>);menu(<?php echo $v['id'];?>);"  <?php if($v['id'] != 4) { ?><?php if(strpos($href,'javascript') === false) { ?> target="main"<?php } ?>   <?php } ?> 
						<?php if($k==0) { ?> class="nav-active" <?php } ?>  href="<?php echo $href;?>">
					<?php echo L($v['name'], '', 'member_menu');?> 
					<?php if($v['id'] == 27 && $news_count>0) { ?><sup class='news'><?php echo $news_count;?></sup><?php } ?>
					<!-- b标签为小红点 -->
					<?php if($v['id'] == 23) { ?><b></b><?php } ?>
				</a>
				<span>|</span> 
			<?php $n++;}unset($n); ?>
			<div class="help" style="display: none;">
				<img src="<?php echo CSS_PATH;?>/gxw2/img/arrowup.png" alt="" class="arrowup">
				<div class="shut">×</div>
				<div class="nextb">了解了</div>
				<div class="tips">
					<img src="<?php echo CSS_PATH;?>/gxw2/img/tb.png" width="25px" alt=""> <span>点击此按钮即可进入数据填报,填写您的企业信息</span>
				</div>
			</div>
		</ul>
	</div>





	<div class="bigbg"></div>



	<div class="w-container"
		style="width: 1200px; height: 602px; margin: 0 auto; margin-top: 12px;">
		<div class="left" style="display: none;"><?php include template('member','left'); ?></div>

		<!-- <div id="load" align="center" style="z-index:99999;height:100px;">
		<img src="http://sc.cnwebshow.com/upimg/allimg/070707/01294420.gif" /> loading
	</div> -->


	<iframe class="frame" allowtransparency="true" name="main" id="main"
		scrolling="auto" frameborder="no"
		style="width: 100%;  position: absolute;">
	</iframe>

		<div id="index" style="position:relative; height:645px;"><?php include template('member','main'); ?></div>
	</div>

	<script>
	<?php if(!$_userid) { ?>
	alertInfo("长沙市工业和信息化项目库管理系统新版本正式上线试运行，原有账户名不变，密码统一变更为111111，请完善和核对现有企业和项目信息，及时更改密码,欢迎加入QQ群：260226212与我们一起交流","<?php echo CSS_PATH;?>gxw2/img/mail.png");
    <?php } ?>
	var _openIndex=-1,menu_activityIndex=0,_news_count='<?php echo $news_count;?>',selectId=null;
	
	$(".w-container").css("width","100%");
	/*
	$(".navbar a").click(function(){
			$(".nav-active").removeClass("nav-active");
			$(this).addClass("nav-active");
	});*/
	$(function(){
		shiying();
		$('.ifooter').addClass('ifooter-act');
		$("#main").css("visibility",'hidden');

	})
	function shiying(){     //高度自适应
		if($(window).height()<800){
			$('#index').height(645);
			$('.ifooter').eq(1).hide();
		}else{

			$('#index').height($(window).height()-155);
		}
	}
	$(window).resize(function(){     //高度自适应
		if($(window).height()<800){
			$('#index').height(645);
		}else{

			$('#index').height($(window).height()-155);
		}
	});
	function menu(id){
		$(".nav-active").removeClass("nav-active");
		$("#a_"+id).addClass("nav-active");
		if(id==4){
				$("#main").css("visibility",'hidden');
				$("#index").css("display",'block');
				$('.ifooter').addClass('ifooter-act');
				$("#main").css("height",'auto');
		}else{
				$("#index").css("display",'none');
				$("#main").css("visibility",'visible');
				$('.ifooter').removeClass('ifooter-act');
				$("#main").css("height",'100%');
				$('.ifooter').show();
		}

		if(id ==24||id == 4 || id == 77 || id==1 || id==25){
			hideMenu(id);
		}else{
			showMenu(id);
		}
		if(id ==24){  //
			$('.w-container').css('width','1100px')
			$('.w-container').css('height','700px')
			$('#main').css('width','1120px')
			$('#main').css('height','670px')
		}else{
			$('#main').css('width','100%')
		}
		if(id ==77 || id ==25){  //限定宽度
			$('.w-container').css('width','1200px')
			$('.w-container').css('height','100%')
		}else{
			
		}
	}



	function showMenu(id){

			$(".left").show();
			$('.bigbg').hide();
			$('.w-container').addClass('w-cont-act')
			$(".w-container").css("width","1200px");
			$(".w-container").css("height","100%");

		}
		function hideMenu(id){
			$(".frame").css("width","100%");
			$(".w-container").css("width","100%");
			$(".w-container").css("height","602px");
			$(".left").hide();
			
			if(id == 77 || id == 25){
				$('.bigbg').hide();
				$('.w-container').addClass('w-cont-act');
			}else{
				$('.bigbg').show();
				$('.w-container').removeClass('w-cont-act');
			}
			// iFrameHeight();
		}
		
		var isMenuSuccess=false;
		function loadMenu(id){
			//$('body').hide();
			isMenuSuccess=false;
			var url="index.php?m=member&c=index&a=public_loadMenu&parentid="+id;
			$.getJSON(url,function(data){
				$(".left-menu-ul").html("");
				if(data.length!=0){
					var html=creatrMenu(data);
					//var menu=$("#menu-tmpl").tmpl(data);
					$(".left-menu").html(html);
					isMenuSuccess=true;
					setTimeout("menuSuccess()",100);
				}
			});
		}
		
		function creatrMenu(data){
			var html=new Array();
			for(var i=0;i<data.length;i++){
				html.push("<div class='menu-div'>");
				html.push("<h5 id='h5_"+data[i].id+"'><span class='li-icon'></span>");
				var childMenu=data[i].child;
					if(childMenu != null && childMenu.length!=0){
						html.push(data[i].menuName);
						html.push("</h5>");
						
						html.push("<ul class='left-menu-ul'>");
							for(var j=0;j<childMenu.length;j++){
									html.push("<li id='li_"+childMenu[j].id+"'>");  //id='li_"+data[i].id+"'>"
									html.push(createA(childMenu[j]));
									html.push("</li>");
							}
						html.push("</ul>");
					}else{
						html.push(createA(data[i]));
						html.push("</h5>");
					}
				html.push("</div>");
			}

			return html.join("");
		}
		
	function createA(data){
			//消息条数
			if(data.id==8){
				if(_news_count != '' && _news_count >0){
					data.menuName+="<sup class='news'>"+_news_count+"</sup>";
				}
			}
			var href="";
			if(data.isurl==1){
				href=data.url;
			}else{
				href="index.php?m="+data.m+"&c="+data.c+"&a="+data.a+"&"+data.data+"&t="+data.id+"&menu=1";
			}
			var menu="<a href="+href+" target=main> <span>"+data.menuName+"</span></a>";
			return menu;
	}
		
	function openIndex(index){
		_openIndex=index;
		if(isMenuSuccess){
			var href=$(".menu-div a").eq(index).attr("href");
			$("#main").attr("src",href);
		}else{
			setTimeout("openIndex(_openIndex)",100);
		}
		//iframeload();
	}
		
		
		
		function menuSuccess(){
			var li=$(".menu-div").find("li");
			
			
			if(isNaN(menu_activityIndex)){
				menu_activityIndex=0;
			}
			if(selectId==null){  //指定选中ID为空 选择第1个为选中状态
				if(li.length==0){
					$(".menu-div").eq(menu_activityIndex).find("h5").addClass("h5-on");
				}else{
					$(".menu-div").eq(menu_activityIndex).find("li").eq(0).addClass("menu-active");
				}
			}else{
				if(selectId.indexOf("h")>=0){   //h5选中
					$('#'+selectId).addClass("h5-on");
				}else{							//li选中
					$('#'+selectId).addClass("menu-active");
				}
			}
			
			$(".menu-div a").on('click',function(){
				var li=$(this).parent().parent().find("li");
				$(".menu-active").removeClass("menu-active");
				$(".h5-on").removeClass("h5-on");
				if(li.length==0){
					$(this).parent().addClass("h5-on");
				}else{
					
					$(this).parent().addClass("menu-active");
				}
			});
			$('.menu-div h5').on('click',function(){
				var lis = $(this).parent().find('li');
				if(lis.length>0){
					$(this).parent().find('ul').slideToggle();
				}
			})
			menu_activityIndex=0;
		}
		
		
	$('.nextb,.shut').click(function(){
		$(this).parent().hide();
	})
	// 关闭顶部提示
	$(function(){
		setTimeout("$('.y-tips').slideDown()",4000)
	})
	$('.tips-close').on('click',function(){
		$('.y-tips').slideUp();
	})
		
	$('.nextb,.shut').click(function(){
		$(this).parent().hide();
	})
	//关闭备忘录
	$('.beiwang-close').on('click',function(){
		$(this).parent().hide();
	})
	
	/*var iframe = document.getElementById("main");  
	if (iframe.attachEvent) {  
	    iframe.attachEvent("onload", function() {  
	                //以下操作必须在iframe加载完后才可进行  
	       $('body').fadeIn();
	    });  
	} else {  

	    iframe.onload = function() {  
	    	console.log('ee')
	    	$('body').fadeIn();
	                //以下操作必须在iframe加载完后才可进行  
	     
	    };  
	}*/




</script>






	<?php include template('member', 'footer'); ?>