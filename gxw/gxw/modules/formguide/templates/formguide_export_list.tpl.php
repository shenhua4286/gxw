<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = $show_header = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="javascript:void(0);" class="on"><em>导出向导</em></a>
        <?php if(isset($big_menu)) echo '<a class="add fb" href="'.$big_menu[0].'"><em>'.$big_menu[1].'</em></a>　';?>
        <?php echo admin::submenu($_GET['menuid'],$big_menu); ?><span>|</span><a href="javascript:window.top.art.dialog({id:'setting',iframe:'?m=formguide&c=formguide&a=setting', title:'<?php echo L('module_setting')?>', width:'540', height:'350'}, function(){var d = window.top.art.dialog({id:'setting'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'setting'}).close()});void(0);"><em><?php echo L('module_setting')?></em></a>
    </div>
</div>
<script type="text/javascript" src="<?php echo JS_PATH?>dialog.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>calendar/calendar.js"></script>
<div class="pad-lr-10">
    <form name="myform"  action="?m=formguide&c=formguide_export&a=export&formid=<?php echo $formid?>" method="post">
        <div class="table-list">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th colspan="2">导出表单<b><?php echo $formInfo['name']; ?></b>数据</th>
                    <th align="left"><input type="submit" class="button" value="导出表单数据"></th>
                </tr>
                <tr>
                    <th style="width: 92px"><input type="checkbox" value="" id="check_box" onclick="selectall('fields[]');"></th>
                    <th style="width: 100px">字段名称</th>
                    <th align="left">导出条件</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td align="center"><input type="checkbox" name="fields[]" value="datetime" checked="">
                        <input type="hidden" name="fieldName[datetime]" value="填表时间">
                        <input type="hidden" name="formtype[datetime]" value="Y-m-d H:i:s">
                    </td>
                    <td align="center">填表时间</td>
                    <td>
                        <?php
                        echo '最小日期：'.form::date('sear[datetime][__min__]', date($form['format'],''));
                        echo '最大日期：'.form::date('sear[datetime][__max__]', date($form['format'],''));
                        ?>
                    </td>
                </tr>
                <?php
                if(is_array($data)){
                    foreach($data as $form){
                        ?>
                    <tr style="display: none">
                        <td align="center"><input type="checkbox" name="fields[]" value="<?php echo $form['field']?>" <?php if($form['minlength']){echo 'checked';}?>/>
                            <input type="hidden" name="fieldName[<?php echo $form['field']?>]" value="<?php echo $form['name']?>"/>
                            <?php
                                if($form['formtype']=='number'){?>
                                    <input type="hidden" name="formtype[<?php echo $form['field']?>]" value="<?php echo $form['decimaldigits']?>"/>
                            <?php
                                }else{?>
                                    <input type="hidden" name="formtype[<?php echo $form['field']?>]" value="<?php echo $form['format']?>"/>
                                <?php
                                }
                            ?>
                        </td>
                        <td align="center"><?php echo $form['name']?></td>
                        <td>
                            <?php
                            switch($form['formtype']){
                                case 'text':
                                case 'textarea':
                                case 'editor':
                                case 'image':
                                case 'images':
                                    echo '关键字：<input type="text" name="sear['.$form['field'].']"><strong>为空时导出全部</strong>';
                                    break;
                                case 'number':
                                    echo '最小值('.$form['minlength'].')：<input type="text" name="sear['.$form['field'].'][__min__]"/>&nbsp;最大值('.$form['maxlength'].')：<input type="text" name="sear['.$form['field'].'][__max__]"/>';
                                    break;
                                case 'box':
                                    echo '<label><input type="checkbox" onclick="select_all(this,'."'".'sear['.$form['field'].'][]'."'".');"/> 全选</label> ';
                                    $options=explode("\n",$form['options']);
                                    foreach($options as $val){
                                            $kv=explode('|',rtrim($val));
                                            echo '<label><input type="checkbox" name="sear['.$form['field'].'][]" value="'.$kv[1].'"/> '.$kv[0].'</label> ';
                                    }
                                    break;
                                case 'datetime':
                                    echo '最小日期：'.form::date('sear['.$form['field'].'][__min__]', date($form['format'],''));
                                    echo '最大日期：'.form::date('sear['.$form['field'].'][__max__]', date($form['format'],''));
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>

            <div class="btn"><label for="check_box"><?php echo L('selected_all')?>/<?php echo L('cancel')?></label>
                <input style="margin-left: 150px" type="submit" class="button" value="导出表单数据">
            </div>
        </div>
    </form>
</div>
</body>
</html>
<script type="text/javascript">
   function select_all(obj,name){
       if(obj.checked){
           $("input[name='"+name+"']").attr('checked',true);
       }else{
           $("input[name='"+name+"']").attr('checked',false);
       }
   }
   jQuery(document).ready(function(){
       jQuery(document.myform).bind('submit',function(){
           if($("input[name='fields[]']:checked").length<1){
               alert('请选择要导出的字段');
               return false;
           }
           return true;
       })
   })
</script>