<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?> 
<?php $isShow=$_GET['isShow'];?>
<script type="text/javascript">
                <!--
                var charset = '<?php echo CHARSET;?>';
                var uploadurl = '<?php echo pc_base::load_config('system','upload_url')?>';
                //-->
            </script>
<link href="<?php echo CSS_PATH;?>dialog.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>dialog.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>content_addtop.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>formvalidator.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--

//-->
$(function(){
	
	$('th:contains("上")').each(function(){
		var s = this.innerHTML;
		s = s.replace("上","<?php echo date('n',strtotime('-1 month'));?>");
		this.innerHTML = s;
	});
});
</script>
<style>
	.main_page{
		width:1200px;
		margin:0 auto;

	}
	.frame-name{
		font-size: 16px;
		font-weight: 400;
		color: #222;
		padding-bottom: 23px;
		margin-top: -10px;
	}
</style>
<div class="main_page">
	<div class="x-content">
		<form method="post" action="" id="myform" name="myform">
			<div class="main-info">
				<h3 class="frame-name"></h3>
				<div class="table-widget padding10">
				
					<?php $date = date('Y-m',strtotime('-1 month'))?>
					<?php $where="yearMonth='".$date."'  and username='".$memberinfo['username']."'";?>
					<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=b084766171e8f52839437389db1c9778&action=lists&catid=%24catid&where=%24where&moreinfo=1\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>$catid,'where'=>$where,'moreinfo'=>'1','limit'=>'20',));}?>
						<?php if(!empty($data)) { ?>		 
							<?php $n=1;if(is_array($data)) foreach($data AS $val) { ?>
							<?php if(!empty($_GET["pt"])) { ?>
							您好，你本月的生产情况已经填写完毕,若需要修改，请点击<a href="index.php?m=member&c=content&a=edit&catid=14&id=<?php echo $val['id'];?>"><font color="red">这里</font></a>
							<?php } else { ?>
							<?php $pt=$_GET["t"];$t=32;?>
							您好，你本月的生产情况已经填写完毕,若需要修改，请点击<a href="index.php?m=member&c=content&a=edit&catid=14&id=<?php echo $val['id'];?>"><font color="red">这里</font></a>							
							<?php } ?>
							<table>
								<tr>
									<th class="w150 textr">上月产值：</th>
									<td class="w600 textl noborder"><?php echo $val['title'];?></td>
								</tr>
								<tr>
									<th class="w150 textr">上月销售额：</th>
									<td class="w600 textl noborder"><?php echo $val['invest'];?></td>
								</tr>
								<tr>
									<th class="w150 textr">其他说明：</th>
									<td class="w600 textl noborder"><?php echo $val["monthWork"];?></td>
								</tr>
							</table>
							<?php $n++;}unset($n); ?>
						<?php } else { ?>
							<table>
								<input type="hidden" name="info[catid]" value="<?php echo $catid;?>" />
								<!--<?php print_r($forminfos[pro_type])?>-->
								<?php $n=1; if(is_array($forminfos)) foreach($forminfos AS $k => $v) { ?> 
									<?php if($v['name']!='栏目') { ?>
									<tr>
										<th class="w150 textr"><?php if($v['star']) { ?> <font color="red">*</font><?php } ?>
											<?php echo $v['name'];?>：
										</th>
										<td class="w600 textl noborder"><?php echo $v['form'];?><?php if($v['tips']) { ?>(<?php echo $v['tips'];?>)<?php } ?></td>
									</tr>
									<?php } ?> 
								<?php $n++;}unset($n); ?> 
								<?php if(!$isShow) { ?>
								<tr>
									<th></th>
									<td><input name="forward" type="hidden"
										value="<?php echo HTTP_REFERER;?>"> <input name="id" type="hidden"
										value="<?php echo $id;?>"> <input name="dosubmit" type="submit"
										id="dosubmit" value="保存" class="button red-bt">
										<input type="hidden"  name="http_referer" value="<?php echo HTTP_REFERER;?>"/>
										<input type="hidden"  name="menu" value="<?php echo $_GET['menu']?>"/>
										<?php if($catid==14) { ?><input type="hidden"  name="info[yearMonth]" value="<?php echo $date;?>"/><?php } ?>
									</td>
								
								</tr>
								<?php } ?>
							  </table>							
						<?php } ?>
					 <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>			 
				</div>
			</div>
		 </form>

	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
			var isSubmit=false;
            $(function() {
                $.formValidator.initConfig({
                    formid: "myform",
                    autotip: true,
                    onerror: function(msg,obj){
                    	alert(msg);
                    },onsuccess:function(){
                    	if(!isSubmit){
                    		isSubmit=true;
                    		return true;
                    	}else{
                    		//console.log("重复提交");
                    	}
                    	return false;
                    }
                });
                <?php echo $formValidator;?>
            });
            </script>
<?php if($isShow) { ?>
<script src="<?php echo JS_PATH;?>inputFormart.js"></script>
<?php } ?> 

