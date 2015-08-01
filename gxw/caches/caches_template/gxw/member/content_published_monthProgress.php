<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?>
<script>
    function confirm_delete(id){
    	 if(confirm('确认删除吗？')) $('#myform').submit();
    	
    }
</script>

	<form name="myform" id="myform" method="post">
		
	</form>
	<div class="x-content">
		<div class="main-info">
			<div class="blue-tool">
				<a href="index.php?m=member&c=content&a=publish&catid=<?php echo $catid;?>&curmb=add&menu=1&t=<?php echo $t;?>&pt=<?php echo $pt;?>" class="blue-bt red-bt xfr">+添加</a>
			</div>
			<div class="table-widget">
				<table  cellspacing="0" cellpadding="0" class="textc">
					<tr>
						<th class="w50">序号</th>
						<th class="w150">所属月份</th>
						<th class="w150">产值</th>
						<th class="w150">投资额</th>
						<th class="w300">其他说明</th>
						<th class="w150">添加时间</th>
						<th class="w150">操作</th>
					</tr>

				 	<?php $index=0;?>
					<?php $n=1;if(is_array($datas)) foreach($datas AS $info) { ?>
					<?php $index++;?>
					<tr>
						<td align="center" class="pdl10">
							<?php echo $index;?>
						</td>
						<td align="center"><?php echo $info['yearMonth'];?></td>
						<td align="left" class="pdl10">
							<a href="index.php?m=member&c=content&a=edit&catid=<?php echo $info['catid'];?>&isShow=1&id=<?php echo $info['id'];?>&t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1"  title="<?php echo $info['title'];?>"><?php echo str_cut($info['title'], 60);?></a>
						</td>
						<td align="center"><?php echo $info['invest'];?></td>
						<td align="center"><?php echo $info['monthWork'];?></td>
						<td align="center"><?php echo date('Y-m-d',$info['inputtime']);?></td>
						<td align="center">
								<a title="编辑" href="index.php?m=member&c=content&a=edit&catid=<?php echo $info['catid'];?>&id=<?php echo $info['id'];?>&t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1"><font class="edit-bt" color="red">&nbsp;&nbsp;</font></a>
								<a title="删除" href="javascript:;" onclick="myform.action='index.php?m=member&c=content&a=delete&catid=<?php echo $info['catid'];?>&id=<?php echo $info['id'];?>';return confirm_delete();"><font class="del-bt">&nbsp;&nbsp;</font></a>
						</td>
					</tr>
					<?php $n++;}unset($n); ?>
					
				</table>
			
 				<div id="pages"> <?php echo $pages;?></div>
			</div>
		</div>
	</div>


