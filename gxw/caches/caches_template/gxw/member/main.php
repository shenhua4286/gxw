<?php defined('IN_gxw') or exit('No permission resources.'); ?><link rel="stylesheet" href="<?php echo CSS_PATH;?>gxw2/css/idangerous.swiper.css" />
<script type="text/javascript" src="<?php echo CSS_PATH;?>gxw2/js/idangerous.swiper.min.js"></script>
<style>
	.swiper-pagination {
		 position: absolute;
		 left: 0;
		 text-align: center;
		 top: 167px;
		 width: 930px;
	}
	.swiper-pagination-switch {
	  display: inline-block;
	  width: 10px;
	  height: 10px;
	  border-radius: 10px;
	  background:url(http://182.92.159.31/gxw/statics/css/gxw2/img/aaadot.png) no-repeat;

	  margin: 0 3px;
	  cursor: pointer;
	}
	.swiper-active-switch {
	  background:url(http://182.92.159.31/gxw/statics/css/gxw2/img/666dot.png) no-repeat;
	}
	#code_img{
		height:auto;
	}
</style>
	<div class="seach">
		<div class="relative w1200">
			<div class="seach-box">
				<div class="seach-input">
					<input class="sousuo" type="text" />
					
					<input class="sousuobt" type="submit" />
					<span class="ifr">
						<img class="xiala-bt" src="<?php echo CSS_PATH;?>/gxw2/img/xiala.png" alt="" />
					</span>
					<div class="xiala-box">
						<div class="seach-tool">
										<ul>
											<a class="no2" href="index.index.php?m=content&c=index&a=lists&catid=20">
												<p>产业</p>
											</a>
											<a class="no3" href="index.php?&menu=1&m=member&c=index&a=lists&status=99&search=search">
												<p>企业</p>
											</a>
											<a class="no7" href="index.php?m=member&c=content&a=published&catid=9">
												<p>项目</p>
											</a>
											<a class="no5" href="index.php?m=member&c=content&a=published&catid=10">
												<p>产品</p>
											</a>
											
											<a class="no8" href="index.index.php?m=content&c=index&a=lists&catid=46">
												<p>区县</p>
											</a>
											<a class="no4" href="index.index.php?m=content&c=index&a=lists&catid=47">
												<p>园区</p>
											</a>
											<a class="no8" href="index.index.php?m=content&c=index&a=lists&catid=22">
												<p>政策</p>
											</a>
											<a class="no7" href="index.index.php?m=content&c=index&a=lists&catid=22">
												<p>法规</p>
											</a>
											<a class="no8" href=index.index.php?m=content&c=index&a=lists&catid=23>
												<p>借鉴</p>
											</a>
											<a class="no6" href="index.index.php?m=content&c=index&a=lists&catid=24">
												<p>人才</p>
											</a>
											<a class="no8" href="index.index.php?m=content&c=index&a=lists&catid=25">
												<p>标准</p>
											</a>
											<a class="no1" href="###">
												<p>综合</p>
											</a>
										</ul>
									</div>
					</div>
				</div>
			</div>
			<div class="seach-tool">
				<ul>
				<!-- 产业、企业、项目、产品、区县、园区、政策、法规、借鉴、人才、标准、综合 -->
					<a class="no2" target="main"  onclick="loadMenu(77);menu(77);" href="index.php?m=content&c=index&a=lists&catid=20">
						<p>产业</p>
					</a>
					<a class="no3"  target="main"  onclick="selectId='h5_99';loadMenu(29);menu(29);"   href="index.php?m=member&c=index&a=lists&status=99&search=search&t=99&menu=1">
						<p>企业</p>
					</a>
					<a class="no8"  target="main" onclick="selectId='h5_99';loadMenu(29);menu(29);"  href="index.php?&menu=1&m=member&c=content&a=published&catid=9&type=steps&t=133&pt=99" >
						<p>项目</p>
					</a>
					<a class="no5"   target="main" onclick="selectId='h5_99';loadMenu(29);menu(29);"  href="index.php?&menu=1&m=member&c=content&a=published&catid=10&t=137&pt=99">
						<p>产品</p>
					</a>
					<a class="no4"  target="main" onclick="loadMenu(77);menu(77);"  href="index.php?m=content&c=index&a=lists&catid=46">
						<p>区县</p>
					</a>
					<a class="no6"  target="main"  onclick="loadMenu(77);menu(77);"  href="index.php?m=content&c=index&a=lists&catid=47">
						<p>园区</p>
					</a>
					<a class="no7" target="main" onclick="loadMenu(77);menu(77);"   href="index.php?m=content&c=index&a=lists&catid=21">
						<p>政策</p>
					</a>
					<a class="no1" target="main" onclick="loadMenu(77);menu(77);"  href="index.php?m=content&c=index&a=lists&catid=21">
						<p>综合</p>
					</a>
				</ul>
			</div>
			<!-- 	
				<div class="right-bar">
					<div class="tuijian">
						<a class="no1" href="">推荐服务</a>
						<a class="no2" href="">推荐服务</a>
						<a class="no3" href="">推荐服务</a>
						<a class="no4" href="">推荐服务</a>
						<a class="no5" href="">推荐服务</a>
					</div>
				</div>  
			-->
			
			<?php if(!$_userid && $memberinfo) { ?>
				<?php $_userid=$memberinfo['userid'];?>
			<?php } ?>
			<?php if(!$_status && $memberinfo) { ?>
				<?php $_status=$memberinfo['status'];?>
			<?php } ?>
			   
			   <div class="login-widget home-login" style="  margin: 0 0 0 191px;">
			<?php if($_userid) { ?>
				
				<?php include template('member', 'main_news'); ?>

				<?php } else { ?>
				
	            <div class="login-widget-title home-huany">欢迎登录</div>
	            <form  method="post" action="index.php?m=member&c=index&a=login" id="myform" name="myform" >
	                <input type="hidden" name="forward" id="forward" value="index.php">

	                <div class="login-input relative">
	                	<div class="home-login-icon">
	                		
	                	</div>
	                    <input type="text" id="username" name="username" size="22" class="h38 w200 pd-input"></div>

	                <div class="login-input relative">
	                <div class="home-passw-icon">
	                		
	                	</div>
	                    <input type="password" id="password" name="password" size="22" class="h38 w200 pd-input">
	                </div>
	                <div class="login-input relative"><div class="yanz-posi">验证码：</div>
	                    <input type="text" id="code" name="code" size="22" class="h38 w200 " style="width: 88px; padding-left: 65px;">
	                    <div class="yzm-tu"><img id="code_img" onclick="this.src=this.src+&quot;&amp;&quot;+Math.random()" src="api.php?op=checkcode&amp;code_len=4&amp;font_size=14&amp;width=120&amp;height=26&amp;font_color=&amp;background="><div class="gh-yzm">单击图片更换验证码</div></div>
	                </div>
	                    <div class="login-input relative">
	                         <input type="submit" name="dosubmit" id="dosubmit" value="登录" class="submit-bt home-denglu-bt">
	                         <a onclick="loadMenu(77);menu(77);" href="index.php?m=member&amp;c=index&amp;a=register" class="zhuce b-hover home-zhuce-bt" target="main">注册</a>
	                         </div>
	            </form>
				<script>
				$('.yanz-posi').click(function(){
					document.getElementById('code').focus();
				})
				</script>
	            <div class="zhucewj">
	                <!-- <a href="" class="wangji b-hover">忘记密码</a>  -->
	            </div>
	       
			<?php } ?>
			 </div>
		</div>
	</div>


	<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=45f8f7beaed39795c9b89cc2fe07a07c&action=lists&catid=12&order=listorder+DESC%2Cid+desc&num=8\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'12','order'=>'listorder DESC,id desc','limit'=>'8',));}?>
	<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

	<div class="newsbar">
		<div class="w1200 relative" style="width:920px;">
			<div class="w1100 swiper-container">
				<div class="swiper-wrapper">

					<?php $index=0;?>
					<?php $n=1; if(is_array($data)) foreach($data AS $key => $val) { ?> 
						<?php if($index%4==0) { ?>
							<ul class="swiper-slide ">
						<?php } ?>
							<li class="<?php echo $index;?>">
								<a href="<?php echo $val['url'];?>&t=77&menu=1" onclick="loadMenu(77);menu(77);"
								target="main"
								>
									<img src="<?php echo $val['thumb'];?>" width="130" height="120" />
									<h5><?php echo str_cut($val['title'],60,'...');?></h5>
									<p><?php echo str_cut($val['description'],130,'...');?></p>
								</a>
							</li>
						<?php if($index%4==3) { ?>
							</ul>
						<?php } ?>
						<?php $index++;?>
					<?php $n++;}unset($n); ?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
			<div class="arrowl"></div>
			<div class="arrowr"></div>
		</div>
	</div>
	
	<script> 
		var mySwiper = new Swiper('.swiper-container', {
		autoplay: 10000,//可选选项，自动滑动
		pagination : '.swiper-pagination',
		grabCursor: true,
		paginationClickable: true,

	})


	// var mySwiper = new Swiper('.swiper-container',{
	//   pagination: '.pagination',
	//   loop:true,
	//   grabCursor: true,
	//   paginationClickable: true
	// })
	$('.arrowl').on('click', function(e){
	  e.preventDefault()
	  mySwiper.swipePrev()
	})
	$('.arrowr').on('click', function(e){
	  e.preventDefault()
	  mySwiper.swipeNext()
	})
	
	//dfsf
	$('.xiala-bt').click(function(e){
		e.stopPropagation();
		$('.xiala-box').toggle();
	})
	$('.xiala-box').click(function(e){
		e.stopPropagation();
	})
	$(document).click(function(){
			$('.xiala-box').hide();
	})
	$('.swiper-slide').find('li').eq(3).css('border-right','0');
	$('.swiper-slide').find('li').eq(7).css('border-right','0');
	</script>

	<?php include template('member', 'footer'); ?>