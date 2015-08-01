<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?>
	<div class="x-content">
		<div class="main-info">
		
			<div class="blue-tool">
				<?php if(!empty($pt)) { ?>				
				<a href="index.php?m=member&c=content&a=publish&catid=<?php echo $catid;?>&curmb=add&t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1" class="blue-bt red-bt xfr">+添加项目</a>
				<?php } else { ?>
				<a href="index.php?m=member&c=content&a=publish&catid=<?php echo $catid;?>&curmb=add&t=<?php echo $t;?>&menu=1" class="blue-bt red-bt xfr">+添加项目</a>
				<?php } ?>
			</div>

			<div class="table-widget">
				<table  cellspacing="0" cellpadding="0" class="textc">
					<tr>
						<th class="w50">序号</th>
						<th class="w300">项目名称</th>
						<th class="w150">项目类型</th>
						<th class="w150">项目开始时间</th>
						<th class="w150">项目进度</th>
						<th class="w150">项目状态</th>
						<th class="w150">操作</th>
					</tr>

					<?php $index=0;?>
					<?php $n=1;if(is_array($datas)) foreach($datas AS $info) { ?>
					<?php $index++;?>
					<tr>
						<td align="left" class="pdl10">
							<?php echo $index;?>
						</td>
						<td align="left" class="pdl10">
							<a href="index.php?m=member&c=content&a=edit&catid=9&isShow=1&id=<?php echo $info['id'];?>&t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1"  title="<?php echo $info['title'];?>"><?php echo str_cut($info['title'], 60);?></a>
						</td>
						<td align="center"><a href="<?php if(strpos($CATEGORYS[$info['catid']][url],'http://')===false) { ?><?php echo $siteurl;?><?php } ?><?php echo $CATEGORYS[$info['catid']]['url'];?>" target="_blank"><?php echo $info['name'];?></a></td>
						<td align="center"><?php echo date('Y-m-d',$info['inputtime']);?></td>
						<td></td> 
						<td>
							<?php if($info[status]==0) { ?><font color="red"><?php echo L('reject_content');?></font><?php } elseif ($info[status]!='99') { ?><font color="#1D94C7">待审中</font><?php } ?>
						</td>
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


