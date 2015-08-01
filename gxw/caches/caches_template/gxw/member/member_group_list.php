<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member','header'); ?>
	<style>
		.qunli{
			width:250px;
			height:155px;
			background: #fff;
			position: relative;
			float:left;
			margin: 15px 30px 20px 25px;
			color:#333;
			border:1px solid #b0b0b0;
			font-size: 12px;
			font-family: microsoft yahei;
		}
		.qunli-mingpian{
			width:100%;
			height:60px;
			padding-top:14px;
		}
		.qunli-img{
			padding:0 10px 0 9px;
			float:left;

		}
		.qunli-name{
			float:left;
			font-size: 14px;
			width:165px;
			overflow: hidden;
			height: 21px;
		}
		.qunli-num{
			float:left;
			font-size: 12px;
			color:;
			width:120px;
			background: url(qun-num.png) no-repeat 0 50%;
			padding-left:26px;
			margin-top:8px;
		}
		.qunli-info{
			padding:5px 9px;
			color:#777;
		}
		.qunli-jinru{
			background: #e5e5e5;
			position: absolute;
			bottom: 0;
			left:0;
			width:100%;
			display: block;
			height:30px;
		}
		.qunli-jinru img{
			display: block;
			margin:0 auto;
			padding-top:5px;
		}
		.qunli-jinru:hover{
			background: #f0f0f0;
		}
	</style>
	<div style="width:980px;">
		<div class="new-qun">
			<img src="<?php echo IMG_PATH;?>GG-1.PNG" alt="" height="85px" width="85px">
			<div class="new-qun-info">
				<h4>机械产业联盟</h4>
				<h5>行业交流,供求信息发布,欢迎大家进来交流</h5>
				<p>主题354个,成员156</p>
				<p>最后发表: 2015-7-9 05:16</p>
			</div>
		</div>
		<div class="new-qun">
			<img src="<?php echo IMG_PATH;?>GG-1.PNG" alt="" height="85px" width="85px">
			<div class="new-qun-info">
				<h4>机械产业联盟</h4>
				<h5>行业交流,供求信息发布,欢迎大家进来交流</h5>
				<p>主题354个,成员156</p>
				<p>最后发表: 2015-7-9 05:16</p>
			</div>
		</div>
		<div class="new-qun">
			<img src="<?php echo IMG_PATH;?>GG-1.PNG" alt="" height="85px" width="85px">
			<div class="new-qun-info">
				<h4>机械产业联盟</h4>
				<h5>行业交流,供求信息发布,欢迎大家进来交流</h5>
				<p>主题354个,成员156</p>
				<p>最后发表: 2015-7-9 05:16</p>
			</div>
		</div>


		<!-- 群卡片开始 -->
		<?php $this->menu_db = pc_base::load_model('member_menu_model');?>
		<?php $menu = $this->menu_db->select(array('parentid'=>25), '*', 9 , 'listorder');?>
		<?php $n=1;if(is_array($menu)) foreach($menu AS $v) { ?>
				<div class="new-qun">
					<img src="<?php echo IMG_PATH;?>GG-1.PNG" alt="" height="85px" width="85px">
					<div class="new-qun-info">
						<h4><?php echo L($v['name'], '', 'member_menu');?></h4>
						<h5>行业交流,供求信息发布,欢迎大家进来交流</h5>
						<p>主题<?php echo $v['id'];?>个,成员<?php echo $v['id'];?></p>
						<p>最后发表: <?php echo date($v[inputtime],'y-m-d');?></p>
					</div>
				</div>


		

		<?php $n++;}unset($n); ?>
	




		</div>
	</body>

</html>