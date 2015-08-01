<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?>
<script type="text/javascript" src="<?php echo JS_PATH;?>formvalidator.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>formvalidatorregex.js" charset="UTF-8"></script>
<link href="<?php echo CSS_PATH;?>dialog.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>dialog.js"></script>
<script language="JavaScript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#nickname").formValidator({onshow:"<?php echo L('input').L('nickname');?>",onfocus:"<?php echo L('nickname').L('between_2_to_20');?>"}).inputValidator({min:2,max:20,onerror:"<?php echo L('nickname').L('between_2_to_20');?>"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"<?php echo L('nickname').L('format_incorrect');?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=member&c=index&a=public_checknickname_ajax&userid=<?php echo $memberinfo['userid'];?>",
		datatype : "html",
		async:'false',
		success : function(data){
            if( data == "1" ) {
                return true;
			} else {
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('already_exist');?>",
		onwait : "<?php echo L('connecting_please_wait');?>"
	}).defaultPassed();

	<?php echo $formValidator;?>
});

//-->
</script>


<div class="x-content">
<form method="post" action="" id="myform" name="myform">
		<div class="main-info">
			<div class="table-widget padding10">
				
		<table  cellspacing="0" cellpadding="0">
				
			<form method="post" action="" id="myform" name="myform">
				<table width="100%" cellspacing="0" class="table_form">
					<tr>
						<th class="w150 textr"><?php echo L('email');?>：</th>        
						<td class="w600 textl noborder"><input name="info[email]" type="text" id="email" size="30" value="<?php echo $memberinfo['email'];?>" class="input-text"></td>
					</tr>
					<tr>
						<th class="w150 textr"><?php echo L('old_password');?>：</th>        
						<td class="w600 textl noborder"><input name="info[password]" type="password" id="password" size="30" value="" class="input-text"></td>
					</tr>
					<tr>
						<th class="w150 textr"><?php echo L('new_password');?>：</th>
						<td class="w600 textl noborder"><input name="info[newpassword]" type="password" id="newpassword" size="30" value="" class="input-text"></td>
					</tr>
					<tr>
						<th class="w150 textr"><?php echo L('re_input').L('new_password');?>：</th>
						<td class="w600 textl noborder"><input name="info[renewpassword]" type="password" id="renewpassword" size="30" value="" class="input-text"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan=""  align="center" class="w600 textl noborder">
							<input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit');?>" class="button">
						</td>
					</tr>
				</table>
				
			</form>
			</div>
			<span class="o1"></span><span class="o2"></span><span class="o3"></span><span class="o4"></span>
		</div>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#password").formValidator({onshow:"<?php echo L('input').L('password');?>",onfocus:"<?php echo L('password').L('between_6_to_20');?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password').L('between_6_to_20');?>"});
	$("#newpassword").formValidator({onshow:"<?php echo L('input').L('password');?>",onfocus:"<?php echo L('password').L('between_6_to_20');?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password').L('between_6_to_20');?>"});
	$("#renewpassword").formValidator({onshow:"<?php echo L('input').L('cofirmpwd');?>",onfocus:"<?php echo L('input').L('passwords_not_match');?>",oncorrect:"<?php echo L('passwords_match');?>"}).compareValidator({desid:"newpassword",operateor:"=",onerror:"<?php echo L('input').L('passwords_not_match');?>"});	
	$("#email").formValidator({onshow:"<?php echo L('input').L('email');?>",onfocus:"<?php echo L('email').L('format_incorrect');?>",oncorrect:"<?php echo L('email').L('format_right');?>"}).inputValidator({min:2,max:32,onerror:"<?php echo L('email').L('between_2_to_32');?>"}).regexValidator({regexp:"email",datatype:"enum",onerror:"<?php echo L('email').L('format_incorrect');?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=member&c=index&a=public_checkemail_ajax",
		datatype : "html",
		async:'false',
		success : function(data){	
            if( data == "1" ) {
                return true;
			} else {
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('deny_register').L('or').L('email_already_exist');?>",
		onwait : "<?php echo L('connecting_please_wait');?>"
	}).defaultPassed();
})
//-->
</script>
