<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php if($catid==9) { ?>
	<?php include template('member','content_published_project'); ?>
	<?php } elseif ($catid==10) { ?>
	<?php include template('member','content_published_products'); ?>
	<?php } elseif ($catid==12) { ?>
	<?php include template('member','content_published_notice'); ?>
	<?php } elseif ($catid==13) { ?>
	<?php include template('member','content_published_projectProgress'); ?>
	<?php } elseif ($catid==14) { ?>
	<?php include template('member','content_published_monthProgress'); ?>
    <?php } elseif ($catid==15) { ?>
	<?php include template('member','content_published_service'); ?>
	<?php } elseif ($catid==16) { ?>
	<?php include template('member','content_published_event'); ?>
	<?php } elseif ($catid==17) { ?>
	<?php include template('member','content_published_feedback'); ?>
	<?php } elseif ($catid==19) { ?>
	<?php include template('member','content_published_application'); ?>
	<?php } elseif ($catid==29) { ?>
	<?php include template('member','content_published_shop'); ?>
	<?php } else { ?>
	<?php include template('member','content_published_object'); ?>
<?php } ?>
