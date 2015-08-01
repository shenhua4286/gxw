<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?>
	<div class="x-content">
		<div class="main-info">
			
			<div class="table-widget table-list">
				<table  cellspacing="0" cellpadding="0" class="textc">
					<thead>	
					<tr>
						<th class="w50">序号</th>
						<th class="w300">信息名称</th>
						<th class="w150">发布时间</th>
					</tr>
					</thead>

				
					<?php $index=0;?>
					<?php $n=1;if(is_array($datas)) foreach($datas AS $info) { ?>
					<?php $index++;?>
					<tr>
						<td align="left" class="pdl10">
							<?php echo $index;?>
						</td>
						<td align="left" class="pdl10">
							<a href="<?php echo $info['url'];?>&t=<?php echo $t;?>&pt=<?php echo $pt;?>&t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1"  title="<?php echo $info['title'];?>"><?php echo str_cut($info['title'], 100);?></a>
						</td>
						<td align="center"><?php echo date('Y-m-d',$info['inputtime']);?></td>
					</tr>
					<?php $n++;}unset($n); ?>
					
				</table>
 				<div id="pages"> <?php echo $pages;?></div>
			</div>
		</div>
		</div>
	</div>


