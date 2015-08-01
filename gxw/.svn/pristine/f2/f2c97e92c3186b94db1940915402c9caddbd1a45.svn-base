<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?>
<div class="x-content">


	<div class="main-info">
			<div class="blue-tool">
				<?php if(empty($_GET['pt'])) { ?>
				<?php $pt=$_GET['t'];$t=13;?>
				<a href="index.php?m=message&c=index&a=send&t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1" class="blue-bt red-bt xfr">+发送消息</a>
				<?php } else { ?>
				<a href="index.php?m=message&c=index&a=send&t=<?php echo $_GET['t'];?>&pt=<?php echo $_GET['pt'];?>&menu=1" class="blue-bt red-bt xfr">+发送消息</a>
				<?php } ?>
			</div>
			<div class="table-widget">
				<table cellspacing="0" cellpadding="0" class="textc">
					<tr>
						<th class="w50">序号</th>
						<th class="w300">标题</th>
						<th class="w50">回复</th>
						<th class="w50">发送时间</th>
					</tr>
					<?php $index=0?>
				 <?php $n=1;if(is_array($infos)) foreach($infos AS $info) { ?> <?php $index++?>
					<tr>
						<td align="center"><?php echo $index;?></td>
						<td align="left" class="pdl10"><a
							href="<?php echo APP_PATH;?>index.php?m=message&c=index&a=read&messageid=<?php echo $info['messageid'];?>&t=<?php echo $t;?>&pt=<?php echo $pt;?>&menu=1">
							<?php if($info['status']==1) { ?><font class="unread"><b><?php echo $info['subject'];?></b></font><?php } else { ?><font class="readed"><?php echo $info['subject'];?></font><?php } ?>
						</a></td>
						<td align="center"><?php if($info['status']!=2) { ?><?php } ?><?php echo $info['reply_num'];?></td>
						<td align="center"><?php echo date('Y-m-d h:m:s',$info['message_time']);?></td>
					</tr>
					<?php $n++;}unset($n); ?>

				</table>

				<div id="pages"><?php echo $pages;?></div>
			</div>
	</div>
</div>

