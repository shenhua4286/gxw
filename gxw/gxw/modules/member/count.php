<?php
/**
 * 企业前台管理中心、账号管理、收藏操作类
 */

defined('IN_gxw') or exit('No permission resources.');
pc_base::load_app_class('foreground');
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);

class index extends foreground {


  	public function count(){
  		$member_db = pc_base::load_model('member_info_model');
  		$member=$member_db ->get_fields("member_info");
  		$membersumcount=count($member);//字段总数
  		$memberin=$member_db ->get_one($where = 'userid='.$memberinfo["userid"], $data = '*');
  		$membercount=0;
  		foreach( $memberin as $key=>$val){
  			if($val==""||$val==0||$val==NULL ){
  				$membercount++;
  			}
  		}
  		
  		$memberpercent=100 - ceil($membercount/$membersumcount *100);//信息完整度百分比
  		
  		$member1_db = pc_base::load_model('member_model');
  		
  		$shenhenum=$member1_db ->select($where = 'groupid=4', $data = 'userid');
  		$shenhesumnum=$member1_db ->select($where = '', $data = 'userid');
  	}
}
?>