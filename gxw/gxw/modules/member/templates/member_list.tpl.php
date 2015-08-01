<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
<form name="searchform" action="" method="get">
		<input type="hidden" value="member" name="m"> <input type="hidden"
			value="member" name="c"> <input type="hidden" value="search" name="a">
		<input type="hidden" value="879" name="menuid">
		<table width="100%" cellspacing="0" class="search-form">
			<tbody>
				<tr>
					<td>
						<div class="explain-col">
				
				<?php echo L('regtime')?>：
				<?php echo form::date('start_time', $start_time)?>-
				<?php echo form::date('end_time', $end_time)?>
							
					<select name="status">
								<option value=''
									<?php if(isset($_GET['status']) && $_GET['status']==0){?>
									selected <?php }?>><?php echo L('status','','mydiy')?></option>
								<option value='2'
									<?php if(isset($_GET['status']) && $_GET['status']==2){?>
									selected <?php }?>><?php echo L('status2','','mydiy')?></option>
								<option value='99'
									<?php if(isset($_GET['status']) && $_GET['status']==99){?>
									selected <?php }?>><?php echo L('status99','','mydiy')?></option>
								<option value='1'
									<?php if(isset($_GET['status']) && $_GET['status']==1){?>
									selected <?php }?>>未提交</option>
								<option value='-1'
									<?php if(isset($_GET['status']) && $_GET['status']==-1){?>
									selected <?php }?>><?php echo L('status-1','','mydiy')?></option>
							</select>
				<?php echo form::select($grouplist, $groupid, 'name="groupid"', L('member_group'))?>
				
				<select name="type">
								<option value='5'
									<?php if(isset($_GET['type']) && $_GET['type']==5){?> selected
									<?php }?>><?php echo L('nickname')?></option>
								<option value='1'
									<?php if(isset($_GET['type']) && $_GET['type']==1){?> selected
									<?php }?>><?php echo L('username')?></option>
								<option value='2'
									<?php if(isset($_GET['type']) && $_GET['type']==2){?> selected
									<?php }?>><?php echo L('uid')?></option>
								<option value='3'
									<?php if(isset($_GET['type']) && $_GET['type']==3){?> selected
									<?php }?>><?php echo L('email')?></option>
								<option value='4'
									<?php if(isset($_GET['type']) && $_GET['type']==4){?> selected
									<?php }?>><?php echo L('regip')?></option>
								
							</select> <input name="keyword" type="text"
								value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>"
								class="input-text" /> <input type="submit" name="search"
								class="button" value="<?php echo L('search')?>" />
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
<form name="myform" action="?m=member&c=member&a=check" method="post" onsubmit="checkuid();return false;">

<input type="hidden" name="userid"/>
<input type="hidden" name="status" id="status" />


<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th  align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('userid[]');"></th>
			<th align="left"><?php echo L('uid')?></th>
			<th align="left"><?php echo L('groupTitle'.$groupid,'','mydiy')?>名称</th>
			<th align="left">登录名</th>
			<th align="left"><?php echo L('email')?></th>
			<th align="left">审核状态</th>
			<!-- <th align="left"><?php echo L('regip')?></th>  -->
			<th align="left"><?php echo L('lastlogintime')?></th>
			<!-- 	
				<th align="left"><?php echo L('amount')?></th> 
				<th align="left"><?php echo L('point')?></th>
			-->
				<th align="left"><?php echo L('operation')?></th>
			
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($memberlist)){
	foreach($memberlist as $k=>$v) {
?>
    <tr>
		<td align="left"><input type="checkbox" value="<?php echo $v['userid']?>" name="userid[]"></td>
		<td align="left"><?php echo $v['userid']?></td>
		<td align="left"><?php echo new_html_special_chars($v['nickname'])?></td>
		<td align="left">
			<img src="<?php echo $v['avatar']?>" height=18 width=18 onerror="this.src='<?php echo IMG_PATH?>member/nophoto.gif'">
			<?php echo $v['username']?>
			<a href="javascript:member_infomation(<?php echo $v['userid']?>, '<?php echo $v['modelid']?>', '')"><?php echo $member_model[$v['modelid']]['name']?><img src="<?php echo IMG_PATH?>admin_img/detail.png"></a>
		</td>
		<td align="left"><?php echo $v['email']?></td>
		<td align="left"><?php echo L('status'.$v['status'],'','mydiy')?></td>  
		<td align="left"><?php echo format::date($v['lastdate'], 1);?></td>
		<td align="left">
			<a href="javascript:edit(<?php echo $v['userid']?>, '<?php echo $v['username']?>')">[<?php echo L('edit')?>]</a>
			|<?php if($v['status'] == 99){ ?>
				<a class="steps_b" href="javascript:;">驳回</a>
			<?php }else {?>
			
				<input style="border: none; background: none;cursor:pointer;" class="steps_a" type="submit" name="dosubmit" value="审核"/>
				<?php }?>
		
		
		</td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>

<div class="btn">
	<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> 
	<!-- <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('<?php echo L('sure_delete')?>')"/>
	 -->
	<!-- 
	<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=member&c=member&a=lock'" value="<?php echo L('lock')?>"/>
	<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=member&c=member&a=unlock'" value="<?php echo L('unlock')?>"/>
 -->	
 	 <input type="submit" class="button" name="dosubmit" onclick="pass(99)" value="审核通过"/>
 	 <input type="button" class="button" name="dosubmit" onclick="reject_check(-1)" value="驳回"/>

 	 <div id='reject_content' style='background-color: #fff;border:#006699 solid 1px;position:absolute;z-index:10;padding:1px;display:none;'>
			<table cellpadding='0' cellspacing='1' border='0'><tr><tr><td colspan='2'>
			<textarea name='reject_c' id='reject_c' style='width:300px;height:46px;'  onfocus="if(this.value == this.defaultValue) this.value = ''" onblur="if(this.value.replace(' ','') == '') this.value = this.defaultValue;">请输入驳回意见，驳回意见将已消息的形式发送给对方</textarea></td><td>
			<input type='submit' name="dosubmit" value=' <?php echo L('submit');?> ' class="button" onclick="reject_check(1)" />
			</td>
			</tr>
		</table>
		</div>
		
		<div id="pages"><?php echo $pages?></div>
</div>


</div>
</form>
</div>
<script type="text/javascript">

$(function(){
	$(".steps_a").click(function(){
		$(":checkbox").attr('checked',false);
		var tr=$(this).parent().parent()
		var check=$(tr).find(":checkbox");
		check[0].checked=true;
		$("#status").val(99);
		checkuid();
	//	return false;
	});

	
	$(".steps_b").click(function(){
		$(":checkbox").attr('checked',false);
		var tr=$(this).parent().parent()
		var check=$(tr).find(":checkbox");
		check[0].checked=true;

		var top=$(this).offset().top;
		var left=$(this).offset().left;

		var reject_content=$("#reject_content");
		var height=$(reject_content).height();
		$(reject_content).css('display','');
		$(reject_content).css('position','absolute');
		$(reject_content).css('top',top+20+"px");
		$(reject_content).css('left',left-400+"px");
		
		return false;
	});
	
});


/**审核通过**/
function pass(groupid){
	$("#status").val(groupid);
}

function reject_check(type) {
	$("#status").val("-1");
	if(type==1) {
		
	} else {
		$('#reject_content').css('display','');
		$('#reject_content').css('position','');
		return false;
	}	
}

<!--
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit').L('member')?>《'+name+'》',id:'edit',iframe:'?m=member&c=member&a=edit&userid='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function move() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'<?php echo L('plsease_select').L('member')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	}
	window.top.art.dialog({id:'move'}).close();
	window.top.art.dialog({title:'<?php echo L('move').L('member')?>',id:'move',iframe:'?m=member&c=member&a=move&ids='+ids,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'move'}).data.iframe;d.$('#dosubmit').click();return false;}, function(){window.top.art.dialog({id:'move'}).close()});
}

function checkuid() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		alert('<?php echo L('plsease_select').L('member')?>');
		return false;
	}
	else if($("#groupid").val() == 11){
		var reject_c=$("#reject_c")[0];
		if(reject_c.value== reject_c.defaultValue || $(reject_c).val()==""){
			alert("请输入驳回意见");
			return false;
		}
	} 
	myform.submit();
}

function member_infomation(userid, modelid, name) {
	window.top.art.dialog({id:'modelinfo'}).close();
	window.top.art.dialog({title:'<?php echo L('memberinfo')?>',id:'modelinfo',iframe:'?m=member&c=member&a=memberinfo&userid='+userid+'&modelid='+modelid,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'modelinfo'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'modelinfo'}).close()});
}

//-->
</script>
</body>
</html>