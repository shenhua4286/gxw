<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php $type=isset($_GET['type']) ? $_GET['type']:'_';$isShow=$_GET['isShow']?>
<?php $menu=1;?>
<?php include template('member', 'header'); ?>
<script type="text/javascript" src="<?php echo JS_PATH;?>formvalidator.js"
	charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>formvalidatorregex.js"
	charset="UTF-8"></script>
<link href="<?php echo CSS_PATH;?>dialog.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>dialog.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>jquery-form.js"></script>
	
<script language="JavaScript">
<!--
	$(function() {
		$.formValidator.initConfig({
			autotip : true,
			formid : "myform",
			onerror : function(msg) {
			}
		});
		$("#nickname")
				.formValidator({
					onshow : "<?php echo L('input').L('nickname');?>",
					onfocus : "<?php echo L('nickname');?>应该在2-30个字符之间"
				})
				.inputValidator({
					min : 4,
					max : 60,
					onerror : "<?php echo L('nickname');?>应该在2-30个字符之间"
				})
				.regexValidator({
					regexp : "ps_username",
					datatype : "enum",
					onerror : "<?php echo L('nickname').L('format_incorrect');?>"
				})
				.ajaxValidator(
						{
							type : "get",
							url : "",
							data : "m=member&c=index&a=public_checknickname_ajax&userid=<?php echo $memberinfo['userid'];?>",
							datatype : "html",
							async : 'false',
							success : function(data) {
								if (data == "1") {
									return true;
								} else {
									return false;
								}
							},
							buttons : $("#dosubmit"),
							onerror : "<?php echo L('already_exist');?>",
							onwait : "<?php echo L('connecting_please_wait');?>"
						}).defaultPassed();

		$.formValidator.initConfig({
			formid : "myform",
			autotip : true,
			onerror : function(msg, obj) {
				alert(msg);
			}
		});
		<?php echo $formValidator;?>
	});
//-->
/* $(document).ready(function() {  
		   // bind 'myForm' and provide a simple callback function   
		   $('#myform').ajaxForm(function(data) {   
		       //alert("Thank you for your comment!");  
		    	alertInfo(data,"<?php echo CSS_PATH;?>gxw2/img/mail.png");
		    }); 
}); */
</script>
<div class="x-content">
	<div class="main-info">
		<form method="post" action="" id="myform" name="myform">
			<input type="hidden" name="type" value="<?php echo $type;?>" />
			<input type="hidden" id="status" name="status" value="2"/>
			<div>
			<div class="table-widget padding10">
				<table cellspacing="0" cellpadding="0" align="center">
					
					<?php $isEdits=$_GET['isEdits'];?>
					<?php if($type=='basic') { ?>
						<?php if($memberinfo['status'] == 99 && !isset($isEdits)) { ?>
						<!--
							<?php if($pt!=56) { ?>
							<tr>
								<th colspan="2">您的企业信息已审核完成,若需修改，请<a style="color:blue;" href="index.php?&menu=1&m=member&c=content&a=publish&catid=19">点击此处进行申请</a></th>
							</tr>
							<?php } ?>
							<script src="<?php echo JS_PATH;?>inputFormart.js"></script>
							-->
						<?php } ?>

						<tr>
							<th class="w150 textr">单位名称：</th>
							<td class="w350 textl noborder">
								<input id="nickname" name="nickname"
									value="<?php echo $memberinfo['nickname'];?>" type="text"
									class="input-text" size="50">
							</td>
						</tr>
						 <tr>
							<th class="w150 textr"><font color=red>*</font>所属区域：</th>
							<td class="w350 textl noborder">
								 <?php echo menu_linkage(3360,'area',$memberinfo['area']);?>
							</td>
						</tr>
						
					<?php } ?>
				
				
					<?php $index=0;?>
					
					<?php if($memberinfo["groupid"] == 12) { ?>
						 <?php $n=1; if(is_array($forminfos)) foreach($forminfos AS $k => $v) { ?> 
							<?php $basic=strpos($v['form'],$type);?> 
							<?php if($basic) { ?>
							<tr>
								<th class="w150 textr"><?php if($v['isbase']) { ?><font color=red>*</font><?php } ?><?php echo $v['name'];?>：
								</th>
								<td class="w350 textl noborder"><?php echo $v['form'];?><?php if($v['tips']) { ?>(<?php echo $v['tips'];?>)<?php } ?></td>
							</tr>
							<?php $index++;?> 
							<?php } ?> 
						  <?php $n++;}unset($n); ?>
						  <?php } else { ?>
							   <?php $n=1; if(is_array($forminfos)) foreach($forminfos AS $k => $v) { ?> 
								<tr>
									<th class="w150 textr"><?php if($v['isbase']) { ?><font color=red>*</font><?php } ?><?php echo $v['name'];?>：
									</th>
									<td class="w350 textl noborder"><?php echo $v['form'];?><?php if($v['tips']) { ?>(<?php echo $v['tips'];?>)<?php } ?></td>
								</tr>
							   <?php $n++;}unset($n); ?>
					<?php } ?>
						<?php $button='下一步'; if($type == 'kej'){$button='保存';}?>
							<tr>
								<td colspan="2" align="center">
								<input name="dosubmit" type="submit" id="dosubmit" value="<?php echo $button;?>"
									class="button"></td>
							</tr>
						</table>
					</div>
				</div>
		</form>
	</div>
</div>
<?php if($isShow) { ?>
<script src="<?php echo JS_PATH;?>inputFormart.js"></script>
<?php } ?> 


