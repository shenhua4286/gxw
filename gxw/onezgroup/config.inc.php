<?php
$dbtype='mysql';//���ݿ�����
$tbl = 'gxw_';//���ݱ�ǰ׺
$dbhost = '192.168.56.145';//���ݿ��ַ
$dbuser = 'root';//���ݿ��û���
$dbpass = '';//���ݿ�����
$dbname = 'gxw';//���ݿ���
$dbcharset = 'gbk';

$skin='QQ2009';
$timezone=0;

$mastername = 'admin';//Ĭ�Ϲ���Ա����

$guestname='�ÿ�';

$loginbanner='images/ad/banner.jpg';
$loginbannerurl='http://localhost/gxw/';

$bbsTitle=date('Y��m��d�յ�Ⱥ����Ϣ').'';                                  //�Զ���������ӱ���
$bbsContent='Ⱥ����ʼʱ�䣺'.date('Y��m��d��Hʱi��s��');                   //�Զ����������Ĭ������

$ViewUserUrl = 'http://localhost/gxw/onezgroup/u.php?action=show&uid=*';
$apiurl = 'http://localhost/gxw/';
$regurl = 'http://localhost/gxw/onezgroup/register.php';

$apitype = 'discuz';//�ӿ����͡�1.phpwind 2.ucenter 3.discuz
//************UCenter Start*************
define('UC_CONNECT', 'mysql');
define('UC_DBHOST', '182.92.159.31');
define('UC_DBUSER', 'root');
define('UC_DBPW', 'cscschina');
define('UC_DBNAME', 'ultrax');
define('UC_DBCHARSET', 'utf8');
define('UC_DBTABLEPRE', '`ultrax`.pre_ucenter_');
define('UC_DBCONNECT', '0');
define('UC_KEY', 'gxw');
define('UC_API', 'http://www.hnxclm.com/uc_server');
define('UC_CHARSET', 'utf-8');
define('UC_IP', '');
define('UC_APPID', '3');
define('UC_PPP', '20');
//************UCenter End*************
?>