<?php defined('IN_gxw') or exit('No permission resources.'); ?><!DOCTYPE html>
<html style="  overflow-x: hidden;">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit" />
<meta charset="UTF-8">
<title>长沙工业信息化调度系统</title>
<link href="<?php echo CSS_PATH;?>gxw2/css/base.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_PATH;?>gxw2/css/ics.css" />

<link rel="stylesheet" href="<?php echo CSS_PATH;?>gxw2/css/idangerous.swiper.css" />
<link href="<?php echo CSS_PATH;?>table_form.css" rel="stylesheet" type="text/css">
<link href="<?php echo CSS_PATH;?>reset.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo CSS_PATH;?>gxw2/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="<?php echo CSS_PATH;?>gxw2/js/idangerous.swiper.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>gxw.js"></script>
<style>
	html{
		overflow: scroll;
		height: auto;
	}
	.swiper-pagination {
		 position: absolute;
		 left: 0;
		 text-align: center;
		 top: 219px;
		 width: 100%;
	}
	.swiper-pagination-switch {
	  display: inline-block;
	  width: 10px;
	  height: 10px;
	  border-radius: 10px;
	  background:url(<?php echo CSS_PATH;?>gxw2/img/aaadot.png) no-repeat;

	  margin: 0 3px;
	  cursor: pointer;
	}
	.swiper-active-switch {
	  background:url(<?php echo CSS_PATH;?>gxw2/img/666dot.png) no-repeat;
	}
	.table-widget{
		float:left;
	}
	#code_img{
		height:auto;
	}
</style>
<script>
</script>
</head>
<style>
		.header-menu > li{
			float:left;
		}
		.title{
			font-size:17px;
			color:#222;
		}
		.edit .nav-active{

		}
		.edit{
			height: 36px;
			border-bottom: 1px solid #e5e5e5;
			background-color: #FAFAFA;
			border-top: 1px solid #e5e5e5;
			padding-top: 4px;
		}
		.edit li a{
			color:#222;
			line-height: 30px;
			padding:10px 26px;
		}
		.edit li a:hover{
			border-bottom:3px solid #ccc;
		}
		.edit .on a{
			color:#02a1d0;
			border-bottom:3px solid #02a1d0;
		}
		.edit .on a:hover{
			border-bottom:3px solid #02a1d0;
		}
		.red-bt{
		/*	background: #02a1d0;
			padding:5px;*/
		}
		.news{
			background:red;
			color:#fff;
			padding:2px;
			font-size:10px;
		}
</style>
	<?php $t=$_GET['t'];$pt=isset($_GET['pt']) ?$_GET['pt']:$t;?>
		<?php if($pt==8) { ?>   <!-- 查询消息 -->
			<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"message\" data=\"op=message&tag_md5=6148979e8152595f69c4eb2d2a5ebab7&action=check_new\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$message_tag = pc_base::load_app_class("message_tag", "message");if (method_exists($message_tag, 'check_new')) {$data = $message_tag->check_new(array('limit'=>'20',));}?> 
				<?php $news_data=$data;?> 
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
		<?php } ?>
	
	<?php if(isset($t) && $_GET['menu'] ) { ?>
		
	<script>/**格式化菜单**/
		//parent.loadMenu(<?php echo $t;?>);parent.menu(<?php echo $t;?>);
		$(function(){
			
			$("a").each(function(){
				var href=$(this).attr("href");
				<?php if($catid!=29) { ?>
				if(href!=null && href != "" && href.indexOf('javascript') <0){
					if(href.indexOf('.php')>0 || href.indexOf('.html')>0 ){
						if(href.indexOf("t=")<0){
							if(href.indexOf("?")<0){
								$(this).attr("href",href+"?t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1");
							}else{
								$(this).attr("href",href+"&t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1");
							}
							
						}
					}
				}
				<?php } ?>
			});
		});
	</script>
	
		<?php $this->menu_db = pc_base::load_model('member_menu_model');?>
		<?php $titleMenu=$this-> menu_db ->get_one(array('display' => 1,'id' => $pt));?>
		<?php $menu = $this->menu_db->select(array('parentid'=>$pt), '*', 9 , 'listorder');?>
		
		 <div class="title" style="margin:18px 26px 10px">
			<?php echo L($titleMenu['name'], '', 'member_menu');?>
		</div>  
<!-- 		<hr> -->
		<?php if(!empty($menu)) { ?>
			<ul class="header-menu edit" style="">
					 <?php $n=1; if(is_array($menu)) foreach($menu AS $k => $v) { ?>
							<?php if($v['isurl']) { ?>
								<?php $href=$v['url']?>
							<?php } else { ?>
								<?php $href="index.php?&menu=1&m=".$v['m']."&c=".$v['c']."&a=".$v['a']."&".$v['data']."&t=".$v['id']."&pt=".$pt;?>
							<?php } ?>
							
					
							
							<li <?php if($v['id'] == $t) { ?> class="on" <?php } ?>  <?php if($t==$pt && $k ==0) { ?> class="on"<?php } ?>>
								<a target="main"  href="<?php echo $href;?>" >
									<?php echo L($v['name'], '', 'member_menu');?>
									
									<?php if($v['id']==13 && $news_data['new_count'] >0) { ?><sup class="news"><?php echo $news_data['new_count'];?></sup><?php } ?>
									<?php if($v['id']==18 && $news_data['new_group_count'] >0) { ?><sup class="news"><?php echo $news_data['new_group_count'];?></sup><?php } ?>
								</a>
								
								
							<!-- 	<span>|</span> -->
							</li>
					  <?php $n++;}unset($n); ?>
				  
			</ul>
			<?php } ?>
		
		
	<?php } ?>
	<?php if($memberinfo['userid']) { ?>
		<script>
		parent.memberinfo();
		</script>	
	<?php } ?>