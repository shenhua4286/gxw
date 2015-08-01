<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div id="closeParentTime" style="display:none"></div>

<div class="pad-10">

<div class="content-menu ib-a blue line-x">
	<a class="add fb" href="?m=content&c=content&a=add&menuid=&catid=<?php echo $catid;?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>")><em><?php echo L('add_content');?></em></a>　
	<a href="?m=content&c=content&a=init&catid=<?php echo $catid;?>&pc_hash=<?php echo $pc_hash;?>" <?php if($steps==0 && !isset($_GET['reject'])) echo 'class=on';?>><em><?php echo L('check_passed');?></em></a><span>|</span>
	<?php echo $workflow_menu;?> <a href="javascript:;" onclick="javascript:$('#searchid').css('display','');"><em><?php echo L('search');?></em></a> 
	<?php if($category['ishtml']) {?>
	<span>|</span><a href="?m=content&c=create_html&a=category&pagesize=30&dosubmit=1&modelid=0&catids[0]=<?php echo $catid;?>&pc_hash=<?php echo $pc_hash;?>&referer=<?php echo urlencode($_SERVER['QUERY_STRING']);?>"><em><?php echo L('update_htmls',array('catname'=>$category['catname']));?></em></a>
	<?php }?>
</div>  
<div id="searchid" style="display:<?php if(!isset($_GET['search'])) echo 'none';?>">
<form name="searchform" action="" method="get" >
<input type="hidden" value="content" name="m">
<input type="hidden" value="content" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $catid;?>" name="catid">
<input type="hidden" value="<?php echo $steps;?>" name="steps">
<input type="hidden" value="1" name="search">
<input type="hidden" value="<?php echo $pc_hash;?>" name="pc_hash">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
 
				<?php echo L('addtime');?>：
				<?php echo form::date('start_time',$_GET['start_time'],0,0,'false');?>- &nbsp;<?php echo form::date('end_time',$_GET['end_time'],0,0,'false');?>
				
				<select name="posids"><option value='' <?php if($_GET['posids']=='') echo 'selected';?>><?php echo L('all');?></option>
				<option value="1" <?php if($_GET['posids']==1) echo 'selected';?>><?php echo L('elite');?></option>
				<option value="2" <?php if($_GET['posids']==2) echo 'selected';?>><?php echo L('no_elite');?></option>
				</select>				
				<select name="searchtype">
					<option value='0' <?php if($_GET['searchtype']==0) echo 'selected';?>>企业名称</option>
					<option value='1' <?php if($_GET['searchtype']==1) echo 'selected';?>><?php echo L('title');?></option>
					<option value='2' <?php if($_GET['searchtype']==2) echo 'selected';?>><?php echo L('intro');?></option>
					<option value='3' <?php if($_GET['searchtype']==3) echo 'selected';?>><?php echo L('username');?></option>
					<option value='4' <?php if($_GET['searchtype']==4) echo 'selected';?>>ID</option>
				</select>
				
				<input name="keyword" type="text" value="<?php if(isset($keyword)) echo $keyword;?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>
<form name="myform" id="myform" action="" method="post" >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
			 <th width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <!-- <th width="37"><?php echo L('listorder');?></th>  -->
            <th width="40">ID</th>
			<th>名称</th>
            <!-- <th width="40"><?php echo L('hits');?></th>  -->
            <th width="200">所属企业</th>
            <th width="100">状态</th>
            <th width="120"><?php echo L('updatetime');?></th>
			<th width="72"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
<tbody>

	

    <?php
	//print_r($datas);
	//die;
	//print_r($datas);
	if(is_array($datas)) {
		$sitelist = getcache('sitelist','commons');
		$release_siteurl = $sitelist[$category['siteid']]['url'];
		$path_len = -strlen(WEB_PATH);
		$release_siteurl = substr($release_siteurl,0,$path_len);
		$this->hits_db = pc_base::load_model('hits_model');
		
		foreach ($datas as $r) {
			$hits_r = $this->hits_db->get_one(array('hitsid'=>'c-'.$modelid.'-'.$r['id']));
	?>
        <tr>
		<td align="left">
			<input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
      	 <!--  <td align='center'><input name='listorders[<?php echo $r['id'];?>]' type='text' size='3' value='<?php echo $r['listorder'];?>' class='input-text-c'></td>
		 -->
		<td align='left' ><?php echo $r['id'];?></td>
		 <td>
			<?php echo "<a href='index.php?m=content&c=content&a=edit&isShow=1&catid={$catid}&id={$r['id']}&pc_hash={$_SESSION['pc_hash']}'>";?>		
			<span<?php echo title_style($r['style'])?>><?php echo $r['title'];?></span>
			</a>
		</td>
		<!--  
			<td align='center' title="<?php echo L('today_hits');?>：<?php echo $hits_r['dayviews'];?>&#10;<?php echo L('yestoday_hits');?>：<?php echo $hits_r['yestodayviews'];?>&#10;<?php echo L('week_hits');?>：<?php echo $hits_r['weekviews'];?>&#10;<?php echo L('month_hits');?>：<?php echo $hits_r['monthviews'];?>"><?php echo $hits_r['views'];?></td>
		 -->
		<td align='left'>
		<?php
		if($r['sysadd']==0) {
			echo "<a href='?m=member&c=member&a=memberinfo&username=".urlencode($r['username'])."&pc_hash=".$_SESSION['pc_hash']."' >".$r['nickname']."</a>"; 
		} else {
			echo $r['nickname'];
		}
		?></td>
		<td align='center'>
			<?php 
				if($r['status']==-1){
					echo '已驳回';
				}else if($r['status']==0){
					echo '企业未提交';
				}else if($r['status']==1){
					echo '等待审核';
				}else if($r['status']==2){
					echo '等待市里审核';
				}else if($r['status']==99 && $catid== 9){
					echo '已入库';
				}else{
					echo '已审核';
				}
			?>
		</td>
		<td align='left'><?php echo format::date($r['updatetime'],1);?></td>
		<td align='center'>
			<a href="index.php?m=content&c=content&a=edit&isShow=edit&catid=<?php echo $catid;?>&id=<?php echo $r['id']?>&pc_hash=<?php echo $_SESSION['pc_hash']?>"><?php echo L('edit');?></a>
			|
			<?php if($r['status']==99){ ?>
				<a class="steps_b" href="javascript:;">驳回</a>
			<?php }else {?>
				<a class="steps_a" href="javascript:myform.action='?m=content&c=content&a=pass&catid=<?php echo $catid?>&steps=<?php echo $steps?>';myform.submit();"">审核</a>				
				<?php }?>
		 </td>
	</tr>
     <?php }
	}
	?>
</tbody>
     </table>
    <div class="btn"><label for="check_box"><?php echo L('selected_all');?>/<?php echo L('cancel');?></label>
		<input type="hidden" value="<?php echo $pc_hash;?>" name="pc_hash">
    	<!-- <input type="button" class="button" value="<?php echo L('listorder');?>" onclick="myform.action='?m=content&c=content&a=listorder&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		 -->	
	<?php if($category['content_ishtml']) {?>
		<input type="button" class="button" value="<?php echo L('createhtml');?>" onclick="myform.action='?m=content&c=create_html&a=batch_show&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php }
		if($status!=99) {?>
		<input type="button" class="button" value="<?php echo L('passed_checked');?>" onclick="myform.action='?m=content&c=content&a=pass&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php }?>
		<!-- 
			<input type="button" class="button" value="<?php echo L('delete');?>" onclick="myform.action='?m=content&c=content&a=delete&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';return confirm_delete()"/>
		 -->
		<?php 
			if(!isset($_GET['reject'])) { 
		?>
		<!--
		 <input type="button" class="button" value="<?php echo L('push');?>" onclick="push();"/>
		-->	
	   <input type="button" class="button" value="<?php echo L('reject');?>" onclick="reject_check()"/>
		<div id='reject_content' style='background-color: #fff;border:#006699 solid 1px;position:absolute;z-index:10;padding:1px;display:none;'>
			<table cellpadding='0' cellspacing='1' border='0'><tr><tr><td colspan='2'><textarea name='reject_c' id='reject_c' style='width:300px;height:46px;'  onfocus="if(this.value == this.defaultValue) this.value = ''" onblur="if(this.value.replace(' ','') == '') this.value = this.defaultValue;"><?php echo L('reject_msg');?></textarea></td><td><input type='button' value=' <?php echo L('submit');?> ' class="button" onclick="reject_check(1)"></td></tr>
		</table>
		</div>
		<?php }?>
		<!--  <input type="button" class="button" value="<?php echo L('remove');?>" onclick="myform.action='?m=content&c=content&a=remove&catid=<?php echo $catid;?>';myform.submit();"/>
		<?php echo runhook('admin_content_init')?>
		 -->
	</div>
    <div id="pages"><?php echo $pages;?></div>
</div>
</form>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript"> 
		
$(function(){
	$(".steps_a").click(function(){
			$(":checkbox").attr('checked',false);
			var tr=$(this).parent().parent()
			var check=$(tr).find(":checkbox");
			check[0].checked=true;
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


<!--
function push() {
	var str = 0;
	var id = tag = '';
	$("input[name='ids[]']").each(function() {
		if($(this).attr('checked')=='checked') {
			str = 1;
			id += tag+$(this).val();
			tag = '|';
		}
	});
	if(str==0) {
		alert('<?php echo L('you_do_not_check');?>');
		return false;
	}
	window.top.art.dialog({id:'push'}).close();
	window.top.art.dialog({title:'<?php echo L('push');?>：',id:'push',iframe:'?m=content&c=push&action=position_list&catid=<?php echo $catid?>&modelid=<?php echo $modelid?>&id='+id,width:'800',height:'500'}, function(){var d = window.top.art.dialog({id:'push'}).data.iframe;// 使用内置接口获取iframe对象
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'push'}).close()});
}
function confirm_delete(){
	if(confirm('<?php echo L('confirm_delete', array('message' => L('selected')));?>')) $('#myform').submit();
}
function view_comment(id, name) {
	window.top.art.dialog({id:'view_comment'}).close();
	window.top.art.dialog({yesText:'<?php echo L('dialog_close');?>',title:'<?php echo L('view_comment');?>：'+name,id:'view_comment',iframe:'index.php?m=comment&c=comment_admin&a=lists&show_center_id=1&commentid='+id,width:'800',height:'500'}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function reject_check(type) {
	if(type==1) {
		var str = 0;
		$("input[name='ids[]']").each(function() {
			if($(this).attr('checked')=='checked') {
				str = 1;
			}
		});
		if(str==0) {
			alert('<?php echo L('you_do_not_check');?>');
			return false;
		}
		var reject_c=$("#reject_c");
		
		if($(reject_c).val() == reject_c.defaultValue || $("#reject_c").val()==""){
			alert("请输入驳回意见");
			return false;
		}
		document.getElementById('myform').action='?m=content&c=content&a=pass&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>&reject=1';
		document.getElementById('myform').submit();
	} else {
		$('#reject_content').css('display','');
		$('#reject_content').css('position','');
		return false;
	}	
}
setcookie('refersh_time', 0);
function refersh_window() {
	var refersh_time = getcookie('refersh_time');
	if(refersh_time==1) {
		window.location.reload();
	}
}
setInterval("refersh_window()", 3000);
//-->
</script>
</body>
</html>