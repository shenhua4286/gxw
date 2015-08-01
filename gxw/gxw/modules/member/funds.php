<?php
/**
 * 企业前台管理中心、账号管理、收藏操作类
 */

defined('IN_gxw') or exit('No permission resources.');
pc_base::load_app_class('foreground');
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);
class funds extends foreground {

	private $times_db;
	
	function __construct() {
		parent::__construct();
		$this->http_user_agent = $_SERVER['HTTP_USER_AGENT'];
	}
	
	/***
	 * 资金申报资金填写
	 */
	function init(){
		include template('member','funds_declare_input');
	}	
	
	
	/***
	 * 资金申报资金填写
	 */
	function funds_declare_input(){
		include template('member','funds_declare_input');
	}
	/****
	 * 进度查询
	 */
	function funds_declare_progress(){
		include template('member','funds_declare_progress');
	}
	
	/****
	 * 进度
	 */
	function funds_declare_data(){
		include template('member','funds_declare_data');
	}
	
}
?>