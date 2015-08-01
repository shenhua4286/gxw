<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<style>
.highcharts-button {
	display: none;
}

svg>text {
	display: none;
}

.highcharts-title {
	display: block;
	color: gray
}
</style>
<!-- 绘图 -->
<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: {
            text: '入驻企业类型占比',
            align: 'center',
            verticalAlign: 'middle',
            y: -50
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    distance: 40,
                    style: {
                        color: 'gray',
                    }
                },
                startAngle: -90,
                endAngle: 270,
                center: ['50%', '75%']
            }
        },
        series: [{
            type: 'pie',
            name: '企业信息产业',
            innerSize: '85%',
            data: [
			<?php
			
			$color = array (
					'#e199dd',
					'#ff9193',
					'#ffdd52',
					'#7ee189',
					'#72e9cb',
					'#7297d1' 
			);
			foreach ( $member_count as $k => $v ) {
				echo "{name:'{$v['name']}',color:'{$color[$k]}',y:{$v['num']}},";
			}
			?>
			
            ]
        }]
    });
});
		</script>
<script src="<?php echo JS_PATH?>highcharts/highcharts.js"></script>
<script src="<?php echo JS_PATH?>highcharts/modules/exporting.js"></script>

<style>
* {
	
}

.col-2 td {
	padding-top: 10px;
	padding-left: 20px;
}
</style>

<div class="explain-col mb10" style="display: none"
	id="browserVersionAlert">
	<?php echo L('ie8_tip')?>
</div>
<div class="col-2 lf mr10" style="width: 48%">
	<h6>统计数据</h6>
	<table>
		<tr>
			<td><?php echo $member_ruzhu?>家企业注册入驻本系统</td>
		</tr>
		<tr>
			<td><?php echo $member_shim?>家企业通过了实名认证</td>
		</tr>
		<tr>
			<td>累积已申报项目<?php echo $project_num?>个</td>
		</tr>
		<tr>
			<td>通过审核项目<?php echo $project_tg?>个</td>
		</tr>
		<tr>
			<td>产业园一共<?php echo $cyy_num?>个</td>
		</tr>

	</table>
</div>
<div class="col-2 col-auto">
	<h6>管理状态</h6>
	<table>
		<tr>
			<td><a
				href="index.php?m=member&c=member&a=search&groupid=10&search=search">
				<?php echo $member_check?>
				</a> 家企业等待审核</td>
		</tr>
		<tr>
			<td><a href="index.php?m=content&c=content&a=init&catid=9&steps=1">
				<?php echo $project_num-$project_tg-$project_submit?>
			</a> 个申报项目正在审核</td>
		</tr>
		<tr>
			<td>已添加录入<?php echo $products_num?>个产品</td>
		</tr>
	</table>
</div>
<div class="bk10"></div>

<?php

$bi = $member_shim / $member_ruzhu * 100;
$bi = number_format ( $bi, 1, '.', '' )?>
<style>
.bi {
	text-align: center;
	color: #fff;
	line-height: 15px;
	height: 100%;
	width: <?php echo$bi?>%;
	background-color: rgb(43, 191, 190);
}
</style>

<div class="col-2 lf mr10" style="width: 48%;">
	<div
		style="width: 100%; height: 15px; background-color: rgb(149, 159, 175)">
		<div class="bi">
				<?php echo $bi;?>%
			</div>
	</div>
	<div>
		<a
			href="index.php?m=member&c=member&a=search&groupid=12&search=search"><?php echo $member_ruzhu?></a>家企业注册入驻本系统
		<a
			href="index.php?m=member&c=member&a=search&groupid=12&search=search"><?php echo $member_shim?></a>家企业通过了实名认证
	</div>
</div>



<div class="col-2 col-auto" style="margin-top: -50px">
	<div id="container"
		style="min-width: 50px; height: 180px; max-width: 800px; margin: 0 auto">
	</div>
</div>



</body>
</html>