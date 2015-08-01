<?php
defined('IN_gxw') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class formguide_export extends admin {

    private $db, $f_db, $tablename;
    public function __construct() {
        parent::__construct();
        $this->db = pc_base::load_model('sitemodel_field_model');
        $this->f_db = pc_base::load_model('sitemodel_model');
        if (isset($_GET['formid']) && !empty($_GET['formid'])) {
            $formid = intval($_GET['formid']);
            $f_info = $this->f_db->get_one(array('modelid'=>$formid, 'siteid'=>$this->get_siteid()), 'tablename');
            $this->tablename = 'form_'.$f_info['tablename'];
            $this->db->change_table($this->tablename);
        }
        //判断表单id是否正确
        if (!isset($_GET['formid']) || empty($_GET['formid'])) {
            showmessage(L('illegal_operation'), HTTP_REFERER);
        }
    }

    /**
     * 选择导出条件
     */
    public function init() {
        /**
         * http://localhost/ynwsywyxy/index.php?m=formguide&c=formguide_info&a=init&formid=12&menuid=1608&pc_hash=RrXrfx
         * http://localhost/ynwsywyxy/index.php?m=formguide&c=formguide_export&a=init&formid=12&menuid=1608&pc_hash=RrXrfx
         */
        /**
        if (!isset($_GET['formid']) || empty($_GET['formid'])) {
        showmessage(L('illegal_operation'), HTTP_REFERER);
        }
        $formid = intval($_GET['formid']);
        if (!$this->tablename) {
        $f_info = $this->f_db->get_one(array('modelid'=>$formid, 'siteid'=>$this->get_siteid()), 'tablename');
        $this->tablename = 'form_'.$f_info['tablename'];
        $this->db->change_table($this->tablename);
        }
        //获取表单字段
        $page = max(intval($_GET['page']), 1);
        $r = $this->db->get_one(array(), "COUNT(dataid) sum");
        $total = $r['sum'];
        $this->f_db->update(array('items'=>$total), array('modelid'=>$formid));
        $pages = pages($total, $page, 20);
        $offset = ($page-1)*20;
        $datas = $this->db->select(array(), '*', $offset.', 20', '`dataid` DESC');
        var_export($datas);
        $big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=formguide&c=formguide&a=add\', title:\''.L('formguide_add').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('formguide_add'));
        include $this->admin_tpl('formguide_export_list');
         */

        //得到表单字段名称
        $formid = intval($_GET['formid']);
        define('CACHE_MODEL_PATH',gxw_PATH.'caches'.DIRECTORY_SEPARATOR.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
        require CACHE_MODEL_PATH.'formguide_output.class.php';
        $formguide_output = new formguide_output($formid);
        $data = $formguide_output->fields;
        //获得要导出的表单名称
        $formInfo = $this->f_db->get_one(array('type' => 3, 'siteid'=>$this->get_siteid(),'modelid'=>$formid));
        pc_base::load_sys_class('form', '', false);
        include $this->admin_tpl('formguide_export_list');
    }
    /**
     * 导出
     */
    public function export(){
        if($_POST['fields']){
            //去除数组中的值
            $map=$this->str_where($_POST);
            $field=array();
            foreach($_POST['fields'] as $fv){
                $field[$fv]=$_POST['fieldName'][$fv];
            }
            //查询数据库
            $data=$this->db->select(join(' AND ',$map));
            if($data){
            	//得到表单字段名称
            	$formid = intval($_GET['formid']);
            	define('CACHE_MODEL_PATH',gxw_PATH.'caches'.DIRECTORY_SEPARATOR.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
            	require CACHE_MODEL_PATH.'formguide_output.class.php';
            	$formguide_output = new formguide_output($formid);
            	
            	$list=array();
            	
            	foreach ($data as $d){
            		$list[]=$formguide_output->get($d);
            	}
            	$this->createXls($list,$field);
            }else{
                showmessage('当前表单中没有符合条件的数据', HTTP_REFERER);
            }
        }else{
            showmessage(L('illegal_operation'), HTTP_REFERER);
        }
    }
    /**
     * 组织查询条件
     */
    protected function str_where($data){
        //组织查询条件
        $map=array();
        foreach($data['fields'] as $val){
            if($data['sear'][$val]){
                if(is_array($data['sear'][$val])){
                    //如果大小区间
                    if(array_key_exists('__max__',$data['sear'][$val])&&array_key_exists('__min__',$data['sear'][$val])){
                        //转换数据类型
                        if(is_numeric($data['formtype'][$val])){
                            $wstr='';
                            if($data['formtype'][$val]==0){
                                $data['sear'][$val]['__max__']=(int)$data['sear'][$val]['__max__'];
                                $data['sear'][$val]['__min__']=(int)$data['sear'][$val]['__min__'];
                            }else{
                                $data['sear'][$val]['__max__']=(double)$data['sear'][$val]['__max__'];
                                $data['sear'][$val]['__min__']=(double)$data['sear'][$val]['__min__'];
                            }
                        }else{
                            if($val=='datetime'){
                                $data['sear'][$val]['__max__']=$data['sear'][$val]['__max__']?mktime(0,0,0,((int)substr($data['sear'][$val]['__max__'],5,2)),((int)substr($data['sear'][$val]['__max__'],8,2)),((int)substr($data['sear'][$val]['__max__'],0,4))):false;
                                $data['sear'][$val]['__min__']=$data['sear'][$val]['__min__']?mktime(0,0,0,((int)substr($data['sear'][$val]['__min__'],5,2)),((int)substr($data['sear'][$val]['__min__'],8,2)),((int)substr($data['sear'][$val]['__min__'],0,4))):false;
                            }else{
                                $data['sear'][$val]['__max__']=$data['sear'][$val]['__max__']?"'".$data['sear'][$val]['__max__']."'":false;
                                $data['sear'][$val]['__min__']=$data['sear'][$val]['__min__']?"'".$data['sear'][$val]['__min__']."'":false;
                            }
                        }
                        if($data['sear'][$val]['__max__']&&$data['sear'][$val]['__min__']){
                            $wstr='(`'.$val.'`>'.$data['sear'][$val]['__min__'].' AND `'.$val.'`<'.$data['sear'][$val]['__max__'].')';
                        }elseif($data['sear'][$val]['__max__']){
                            $wstr='(`'.$val.'`<'.$data['sear'][$val]['__max__'].')';
                        }elseif($data['sear'][$val]['__min__']){
                            $wstr='(`'.$val.'`>'.$data['sear'][$val]['__min__'].')';
                        }
                        if(!in_array($wstr,$map)){
                            $map[]=$wstr;
                        }
                    }else{
                        $map[]="(`{$val}` in ('".join("','",$data['sear'][$val])."'))";
                    }
                }else{
                    $map[]='(`'.$val.'` like "%'.$data['sear'][$val].'%")';
                }
            }
        }
        //过滤空值
        $map=array_diff($map,array(null));
        return $map;
    }
    /**
     * @param $field
     * @param $data
     */
    function createXls($data,$field){
        $formid = intval($_GET['formid']);
        //获得要导出的表单名称
        $formInfo = $this->f_db->get_one(array('type' => 3, 'siteid'=>$this->get_siteid(),'modelid'=>$formid));
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/download');;
        header('Content-Disposition: attachment;filename='.$formInfo['name'].date('Y-m-d',time()).'.xls');
        header('Content-Transfer-Encoding: binary ');
        $td='';$th='';
        foreach($data as $key=>$val){
            $td.='<tr>';
            foreach($field as $kv=>$fv){
                if(!$key){
                    $th.='<th style="vnd.ms-excel.numberformat:@">'.$fv.'</th>';
                }
                if($kv=='datetime'){
                    $val[$kv]=date('Y-m-d H:i:s',$val[$kv]);
                }
                $td.='<td style="vnd.ms-excel.numberformat:@">'.$val[$kv].'</td>';
            }
            $td.='</tr>';
        }
        echo '<table boder="1"><tr><th colspan="'.count($field).'">'.$formInfo['name'].date('Y年m月d日',time()).'导出数据</th></tr><tr>'.$th.'</tr>'.$td.'</table>';
        return true;
    }
}
?>