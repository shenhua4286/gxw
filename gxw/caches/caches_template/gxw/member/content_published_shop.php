<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?>
	<div class="x-content">
		<div class="main-info">


			<div class="table-widget table-list">
				<table  cellspacing="0" cellpadding="0" class="textc">
					<thead>
						<tr>
							<th width="20">序号</th>
							<th width="120">电商名称</th>
							<th width="100">logo</th>
							<th width="100">电商简介</th>
							<th width="100">发布时间</th>
						</tr>
					</thead>

					<?php $index=0;?>
					<?php $n=1;if(is_array($datas)) foreach($datas AS $info) { ?>
					<?php $index++;?>
					
					<tr>
						<td align="center" class="pdl10">
							<?php echo $index;?>
						</td>
						<td align="left" class="pdl10">
							
							<a href="<?php echo $info['link_address'];?>" target="_blank"><?php echo str_cut($info['title'], 60);?></a>
							
						</td>
						<td><img src="<?php echo $info['logo'];?>" width="124" height="124" /></td> 
						<td align="left"><?php echo str_cut($info['description'],300,'...');?></td>
						<td align="center"><?php echo date('Y-m-d',$info['inputtime']);?></td>
					</tr>
					<?php $n++;}unset($n); ?>
					
				</table>
			
 				<div id="pages"> <?php echo $pages;?></div>
			</div>
		</div>
	</div>


