<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>

<div class="pad-lr-10">
<div class="table-list">
<div class="common-form">
	<input type="hidden" name="info[userid]" value="<?php echo $memberinfo['userid']?>"></input>
	<input type="hidden" name="info[username]" value="<?php echo $memberinfo['username']?>"></input>
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="120"><?php echo L('username')?></td> 
			<td><?php echo $memberinfo['username']?><?php if($memberinfo['islock']) {?><img title="<?php echo L('lock')?>" src="<?php echo IMG_PATH?>icon/icon_padlock.gif"><?php }?><?php if($memberinfo['vip']) {?><img title="<?php echo L('vip')?>" src="<?php echo IMG_PATH?>icon/vip.gif"><?php }?></td>
		</tr>
		<tr>
			<td><?php echo L('avatar')?></td> 
			<td><img src="<?php echo $memberinfo['basic_logo']?>" style="width:90px;height:90px;"></td>
		</tr>
		<tr>
			<td><?php echo L('nickname')?></td> 
			<td><?php echo $memberinfo['nickname']?></td>
		</tr>
		<tr>
			<td><?php echo L('email')?></td>
			<td>
			<?php echo $memberinfo['email']?>
			</td>
		</tr>
		<tr>
			<td><?php echo L('mp')?></td>
			<td>
			<?php echo $memberinfo['mobile'];?>
			</td>
		</tr>
		<tr>
			<td><?php echo L('member_group')?></td>
			<td>
			<?php echo $grouplist[$memberinfo['groupid']]['name'];?>
			</td>
		</tr>
		<tr>
			<td>审核状态</td>
			<td>
			<?php echo L('status'.$memberinfo['status'],'','mydiy')?>
			</td>
		</tr>
		<!-- <tr>
			<td><?php echo L('member_model')?></td>
			<td>
			<?php echo $modellist[$modelid]['name'];?>
			</td>
		</tr>  
		<tr>
			<td><?php echo L('in_site_name')?></td>
			<td>
			<?php echo $sitelist[$memberinfo['siteid']]['name'];?>
			</td>
		</tr>
		-->
		
	</table>
</fieldset>
<div class="bk15"></div>
<fieldset>
	<legend><?php echo L('more_configuration')?></legend>
	
	<form action="?m=member&c=member&a=check" method="post" >
		<input type="hidden" name="userid[]" value=<?php echo $memberinfo['userid']?>/>
		<input type="hidden" id="status" name="status" value="12"/>
		<table width="100%" class="table_form">
		
		
		
		
		

		<?php foreach($member_fieldinfo as $k=>$v) {?>
			<tr>
				<td width="120"><?php echo $k?></td> 
				<td><?php echo $v?></td>
			</tr>
		<?php }?>
		<tr>
			<td colspan="2" align="center">
				<input type="submit" name="dosubmit" value="审核通过" onclick="pass(99)">
				<input type="submit" name="dosubmit" value="驳回" onclick="pass(-1)">
			</td>
		</tr>
		</table>
	</form>
</fieldset>
</div>

<script>
/**审核通过**/
function pass(status){
	$("#status").val(status);
}
</script>
<div class="bk15"></div>
<input type="button" class="dialog" name="dosubmit" id="dosubmit" onclick="window.top.art.dialog({id:'modelinfo'}).close();"/>
</div>
</div>
</body>
</html>