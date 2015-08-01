<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?>

<style>
	.w100{
		background: #fff !important;
		text-indent: 20px;
		color: #767676;
	}
</style>

<div class="x-content">

	<div class="main-info">
		<form method="post" action="" id="myform" name="myform">
			<input type="hidden" name="type" value="basic">
			
			<div>
				<div class="info">
					<div class="home-title">
					<!-- 企业logo -->
						<img  src="<?php echo $info['basic_logo'];?>" alt="" class="home-logo" height="121px">
						<h4><?php echo $memberinfo['nickname'];?><span class="renz">(<?php echo L('status'.$memberinfo['status'],'','mydiy');?>)</span></h4>
					</div>
					<div class="home-jieshao">
						<?php echo $memberinfo['basic_com_intruduce'];?>
					</div>
					<div class="jieshao-row">
						<li>
							<div class="jieshao-li">
								<span class="js-title">法人代表</span>
								<span class="js-cont"><?php echo $info['basic_far'];?></span>
							</div>
							<div class="jieshao-li">
								<span class="js-title">注册地址</span>
								<span class="js-cont"><?php echo $info['basic_reg_addr'];?></span>
							</div>
						</li>
						<li>
							<div class="jieshao-li">
								<span class="js-title">成立时间</span>
								<span class="js-cont"><?php echo $info['basic_found_date'];?></span>
							</div>
							<div class="jieshao-li">
								<span class="js-title">办公电话</span>
								<span class="js-cont"><?php echo $info['basic_office_phone'];?></span>
							</div>
						</li>
						<li>
							<div class="jieshao-li">
								<span class="js-title">联系人QQ</span>
								<span class="js-cont"><?php echo $info['basic_qq'];?></span>
							</div>
							<div class="jieshao-li">
								<span class="js-title">单位网址</span>
								<a class="js-cont href" href="<?php echo $info['basic_url'];?>"><?php echo $info['basic_url'];?></a>
							</div>
						</li>
					</div>
					<div class="home-cont-li">
						<div class="home-cont-title">
							<span>1</span>
							<div class="home-cont-h5">
								项目信息
							</div>
						</div>
						<?php $where="username='".$memberinfo['username']."'";?>
						<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=eb5959f8e9e4f31138c53624ee92c3e9&action=lists&catid=9&order=listorder+DESC%2Cid+desc&num=8&moreinfo=1&where=%24where+\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'9','order'=>'listorder DESC,id desc','moreinfo'=>'1','where'=>$where ,'limit'=>'8',));}?>
						<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
						
						<?php $n=1;if(is_array($data)) foreach($data AS $v) { ?>
							<a href="index.php?menu=1&m=member&c=content&a=edit&catid=<?php echo $v['catid'];?>&isShow=1&id=<?php echo $v['id'];?>">
								<!-- 项目标题 -->
								<div class="home-xiangmu-title">
									<?php echo $v['title'];?>
								</div>
								<!-- 项目详情 -->
								<div class="home-xiangmu-cont">
									<?php echo str_cut($v['pro_content'],500);?>
								</div>
							</a>
						<?php $n++;}unset($n); ?>
					</div>
						<?php $where.="and thumbs!=''"?>
						<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=a28339f234a8afff3027685a51b28fae&action=lists&catid=10&order=listorder+DESC%2Cid+desc&num=12&moreinfo=1&where=%24where+\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'10','order'=>'listorder DESC,id desc','moreinfo'=>'1','where'=>$where ,'limit'=>'12',));}?>
						<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
					
					<!-- 产品图片开始 -->
					<div class="home-product-img">
							<h5>产品图片</h5>
						<?php $n=1;if(is_array($data)) foreach($data AS $v) { ?>	
							<?php eval("\$d = ".$v['thumbs'].'; ');?>
			         		<?php $d=$d[0];?>
						
							<li class="hp-li">
								<a href="index.php?m=member&c=content&a=edit&catid=<?php echo $v['catid'];?>&isShow=1&id=<?php echo $v['id'];?>&menu=1">
									<img src="<?php echo $d['url'];?>" alt="">
									<p><?php echo str_cut($v['title'],20);?></p>
								</a>
							</li>
						<?php $n++;}unset($n); ?>
					</div>
					




				</div>
			</div>
		</form>
	</div>
</div>

