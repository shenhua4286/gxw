<?
include_once("include/common.inc.php");
foreach(API_Config() as $k=>$v)$$k=$v;
switch($action=Char_Cv('type','get')){
  case 'islogin':
    print($userid?'Y':'N');
    break;
  case 'logout':
    echo API_Logout();
    break;
}
?>