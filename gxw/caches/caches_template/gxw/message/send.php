<?php defined('IN_gxw') or exit('No permission resources.'); ?><?php include template('member', 'header'); ?>
<div class="x-content">
<form name="myform" action="<?php echo APP_PATH;?>index.php?m=message&c=index&a=send" method="post" id="myform">
		<div class="main-info">
			<div class="table-widget padding10">
				<table>
						<tr>
							<th class="w150 textr">收信人：</th>
							<td class="w600 textl noborder">
								<input name="info[send_to_id]" type="text" id="username" size="30" value=""  class="input-text"/>
							</td>
						</tr>
						<tr>
							<th class="w150 textr">标题：</th>
							<td class="w600 textl noborder">
								<input name="info[subject]" type="text" id="subject" size="30" value=""  class="input-text"/>
							</td>
						</tr>
						<tr>
							<th class="w150 textr">内容：</th>
							<td class="w600 textl noborder">
								<textarea  name="info[content]" rows="5" cols="80">
								
								</textarea>
							</td>
						</tr>
						<tr>
							<th class="w150 textr">验证码：</th>
							<td class="w600 textl noborder">
								<input name="code" type="text" id="code" size="10"  class="input-text"/> <?php echo form::checkcode('code_img','4','14',110,30);?>
							</td>
						</tr>
						 <tr>
					       <td></td>
					       <td colspan="2"><label>
					         <input type="submit" name="dosubmit" id="dosubmit" value="确 定" class="button"/>
					         </label></td>
    					</tr>
				</table>
                </div>
            </div>
			</form>

    </div>
