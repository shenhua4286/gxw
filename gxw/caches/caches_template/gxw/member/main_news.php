<?php defined('IN_gxw') or exit('No permission resources.'); ?><style>
.xiaoxi-notice{
	width: 300px;
	  /* height: 300px; */
	  position: relative;
	  z-index: 999;
	  padding-bottom: 35px;
}
.shang-jt{
	position: absolute;
	  top: -13px;
	  right: 75px;
}
.notice-li{
	width:275px;
	height:56px;
	background: #fff;
	color:#333;
	margin:13px auto;
	position: relative;
	box-shadow: 0 2px 2px #ccc;
}
.notice-li a{
	color:#1080d0;
	text-decoration: underline;

}
.notice-li h4{
	height:40px;
	width:40px;
	background: #1080d0;
	color:#fff;
	line-height: 20px;
	padding:8px;
	text-align: center;
	float:left;
}
.red-tips h4{
	background: #dd4b39;

}
.tips-text{
	float:left;
	width:160px;
	height:40px;
	padding:8px 16px;
	line-height: 18px;
}
.blue-tips h4{
	background: #1080d0;
}
.tips-text{
	display: table;
}
.blue-tips a{
	vertical-align: middle;
	display: table-cell;
}
.blue-tips p{
	display: table-row;
}
.notice-close{
	position: absolute;
	top: 0px;
	right: 8px;
	color: #9c9c9c;
	font-size: 18px;
	cursor:pointer;
}
.see-all-notice{
	position: absolute;
	left:50%;
	bottom:0;
	width:200px;
	height:30px;
	line-height:30px !important;
	background: #e4e4e4;
	text-align: center;
	display: block;
	margin-left:-100px;
	color:#333 !important;
	text-decoration: underline;

}
.see-all-notice:hover{
	background: #f8f8f8;
}
.navbar a b{
	position: absolute;
	top: 11px;
	right: 29px;
	background: url(red-tips-dot.png) no-repeat;
	height: 6px;
	width: 6px;
}
.left-h5{
	position: relative;
}
.left-h5 b{
	position: absolute;
	top: 13px;
	left: 103px;
	background: url(red-tips-dot.png) no-repeat;
	height: 6px;
	width: 6px;
}
</style>


				<div class="xiaoxi-notice">
					
					<?php if($_stasus!=99) { ?>
						<div class="notice-li">
							<div class="red-tips">
								<h4>待办事项</h4>
								<div class="tips-text">
									<p>您还没完成数据填报</p>
									<a target="main" onclick="selectId='li_55';loadMenu(23);menu(23);" href="index.php?m=member&c=index&a=account_manage_info&type=basic&t=55&menu=1">立即前往数据填报</a>
								</div>
							</div>
							<!-- <div class="notice-close">
								×
							</div>  -->
						</div>
					<?php } ?>
					
		
			<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=454382bcd5a5a038ba15a0f6cb8971ff&action=lists&catid=12&order=listorder+DESC%2Cid+desc&num=2\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'12','order'=>'listorder DESC,id desc','limit'=>'2',));}?>
					<?php $n=1;if(is_array($data)) foreach($data AS $v) { ?>
						<div class="notice-li">
								<div class="blue-tips">
									<h4>消息提醒</h4>
									<div class="tips-text">
										<p><?php echo str_cut($v[title],30);?></p>
										<a onclick="loadMenu(77);menu(77);" target="main" href="<?php echo $v['url'];?>">查看</a>
									</div>
								</div>
								<!-- <div class="notice-close">
									×
								</div> -->
						</div>
						<?php $n++;}unset($n); ?>
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
					
		
					
					<a onclick="loadMenu(77);menu(77);" target="main" href="index.php?m=content&c=index&a=lists&catid=12" class="see-all-notice">查看所有通知</a>  
				</div>



<script>
	//关闭通知动画
	$('.xiaoxi-kuang').on('click',function(){
		$('.xiaoxi-notice').slideToggle();
	})
	$('.notice-close').on('click',function(){
		$(this).parent().slideUp();
		if($('.xiaoxi-notice').height()<=100){
			$('.login-widget').slideToggle();
		}
	});
	
	
	
</script>