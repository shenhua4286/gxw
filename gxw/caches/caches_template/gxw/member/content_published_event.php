<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?>
	<div class="x-content">
		<div class="main-info">
		
			<div class="blue-tool">
				<a href="index.php?m=member&c=content&a=publish&catid=<?php echo $catid;?>&curmb=add&menu=1&t=79&pt=56" class="blue-bt red-bt xfr">+添加大事件</a>
			</div>

			<div class="table-widget">
				<table  cellspacing="0" cellpadding="0" class="textc">
					<tr>
						<th class="w50">序号</th>
						<th class="w150">所属月份</th>
						<th class="w300">事件标题</th>
						<th class="w150">发布时间</th>
						<th class="w150">操作</th>
					</tr>

					<?php $index=0;?>
					<?php $n=1;if(is_array($datas)) foreach($datas AS $info) { ?>
					<?php $index++;?>
					<tr>
						<td align="left" class="pdl10">
							<?php echo $index;?>
						</td>
						<td><?php echo date('Y年m月份',strtotime($info['yearMonth']));?></td> 
						<td align="left" class="pdl10">
							<a href="index.php?m=member&c=content&a=edit&catid=<?php echo $info['catid'];?>&isShow=1&id=<?php echo $info['id'];?>&t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1"  title="<?php echo $info['title'];?>"><?php echo str_cut($info['title'], 60);?></a>
						</td>
						<td align="center"><?php echo date('Y-m-d',$info['inputtime']);?></td>
						<td align="center">
							<a title="编辑" href="index.php?m=member&c=content&a=edit&catid=<?php echo $info['catid'];?>&id=<?php echo $info['id'];?>&t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1"><font class="edit-bt" color="red">&nbsp;&nbsp;</font></a>
						</td>
					</tr>
					<?php $n++;}unset($n); ?>
					
				</table>
			
 				<div id="pages"> <?php echo $pages;?></div>
			</div>
		</div>
	</div>


