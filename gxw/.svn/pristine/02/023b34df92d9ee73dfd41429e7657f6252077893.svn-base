<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once('../include/common.inc.php'); 
   
define('UC_CLIENT_VERSION', '1.5.1');
define('UC_CLIENT_RELEASE', '20091001');   
   
define('API_DELETEUSER', 1);        //用户删除 API 接口开关    
define('API_RENAMEUSER', 1);        //用户改名 API 接口开关    
define('API_UPDATEPW', 1);      //用户改密码 API 接口开关    
define('API_GETTAG', 1);        //获取标签 API 接口开关    
define('API_SYNLOGIN', 1);      //同步登录 API 接口开关    
define('API_SYNLOGOUT', 1);     //同步登出 API 接口开关    
define('API_UPDATEBADWORDS', 1);    //更新关键字列表 开关    
define('API_UPDATEHOSTS', 1);       //更新域名解析缓存 开关    
define('API_UPDATEAPPS', 1);        //更新应用列表 开关    
define('API_UPDATECLIENT', 1);      //更新客户端缓存 开关    
define('API_UPDATECREDIT', 1);      //更新用户积分 开关    
define('API_GETCREDITSETTINGS', 1); //向 UCenter 提供积分设置 开关    
define('API_UPDATECREDITSETTINGS', 1);  //更新应用积分设置 开关    
   
define('API_RETURN_SUCCEED', '1');    
define('API_RETURN_FAILED', '-1');    
define('API_RETURN_FORBIDDEN', '-2');    
   
$code = $_GET['code'];    
parse_str(authcode($code, 'DECODE', UC_KEY), $get);    
if(time() - $get['time'] > 3600) {    
    exit('Authracation has expiried');    
}    
if(empty($get)) {    
    exit('Invalid Request');    
}    
$action = $get['action'];    
$timestamp = time();    
//请到onez中进行用户的 注册、登陆    
//一定在Ucenter中设置onez的“是否接受通知” 为“是”   
if($action == 'test') {    
    //ucenter使用的连接测试    
    exit(API_RETURN_SUCCEED);    
}elseif($action == 'updatepw'){    
    //外部通知onez修改自己数据中的密码，这个等用户下一次登陆的时候会自动更新  
    require_once('../include/common.inc.php');
    $username = $get['username'];
    exit(API_RETURN_SUCCEED);  
}elseif($action == 'renameuser'){    
    //外部通知onez修改自己数据中的用户名    
}elseif($action == 'deleteuser'){    
    //同步删除用户    
    require_once('../include/common.inc.php');
    if($result){    
        exit(API_RETURN_SUCCEED);    
    }else{    
        exit(API_RETURN_FAILED);    
    }    
}elseif($action == 'synlogout'){    
    //同步退出
    require_once('../include/common.inc.php');
    $GLOBALS['cookiepre']='onez_';
    osetcookie('userid','',-86400);
    osetcookie('username','',-86400);
    exit(API_RETURN_SUCCEED);    
}elseif($action == 'synlogin'){    
    //同步登陆    
    require_once('../include/common.inc.php');
    $uid=$get['uid'];
    $username=$get['username'];
    if(!$db){
      include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
      db_local();
      $db=new onez_db;
    }
    if($db->rows("users","uid='$uid'")==0){//创建本地用户
      include_once('../uc_client/client.php');
      if($data = uc_get_user($uid,1)) {
        list($uid, $username, $email) = $data;
        $arr=array(
          'uid'=>$uid,
          'username'=>$username,
          'email'=>$email,
          'infoip'=>$onlineip,
          'infotime'=>$time,
        );
        $db->insert('users',$arr);
      }
    }
    $GLOBALS['cookiepre']='onez_';
    osetcookie('userid',$uid,31536000);
    osetcookie('username',$username,31536000);
    exit(API_RETURN_SUCCEED);  
}elseif($action == 'getcreditsettings'){   
    //发送积分配置
    require_once('../include/common.inc.php');  
    $credits = array();
    foreach($extcredits as $id => $v) {
      if($v[0]){
        $credits[$id] = array($v[1],$v[2]);
      }
    }
    echo uc_serialize($credits); 
}elseif($action == 'updatecreditsettings'){   
    //保存积分兑换比例
    require_once('../include/common.inc.php');  
    $outextcredits = array();
    foreach($get['credit'] as $appid => $credititems) {
      if($appid == UC_APPID) {
        foreach($credititems as $value) {
          $outextcredits[$value['appiddesc'].'|'.$value['creditdesc']] = array(
            'creditsrc' => $value['creditsrc'],
            'title' => $value['title'],
            'unit' => $value['unit'],
            'ratio' => $value['ratio'],
            'ratiosrc' => $value['ratiosrc'],
            'ratiodesc' => $value['ratiodesc'],
            'ratio' => $value['ratio']
          );
        }
      }
    }
    @writeover("../onezdata/creditsettings.php","<?\n\$outextcredits=".var_export($outextcredits,true)."?>");
    exit(API_RETURN_SUCCEED);
}elseif($action == 'updatecredit'){   
    //接收积分兑换通知
    $credit = intval($get['credit']);
    $amount = intval($get['amount']);
    $uid = intval($get['uid']);
    require_once('../include/common.inc.php');
    if(!$db){
      include_once(ONEZ_ROOT.'./include/db_mysql.class.php');
      $db=new onez_db;
    }
    $db->query("UPDATE {$tbl}users SET extcredits$credit=extcredits$credit+$amount WHERE uid='$uid'");
    exit(API_RETURN_SUCCEED);
}elseif($action == 'updateapps'){   
    //应用程序列表
    $post = uc_unserialize(file_get_contents('php://input'));
    $appid=array();
    foreach($post as $id=>$v){
      if($id!='UC_API' && $id!=UC_APPID){
        $appid[]=$id;
      }
    }
    writeover('../onezdata/apps.php',"<?\n\$apps=".var_export($post,true).";\n\$appid=array(".implode(',',$appid).");\n?>");
    exit(API_RETURN_SUCCEED);
}else{    
    exit(API_RETURN_SUCCEED);    
}    
   
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {    
   
    $ckey_length = 4;    
   
    $key = md5($key ? $key : UC_KEY);    
    $keya = md5(substr($key, 0, 16));    
    $keyb = md5(substr($key, 16, 16));    
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';    
   
    $cryptkey = $keya.md5($keya.$keyc);    
    $key_length = strlen($cryptkey);    
   
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;    
    $string_length = strlen($string);    
   
    $result = '';    
    $box = range(0, 255);    
   
    $rndkey = array();    
    for($i = 0; $i <= 255; $i++) {    
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);    
    }    
   
    for($j = $i = 0; $i < 256; $i++) {    
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;    
        $tmp = $box[$i];    
        $box[$i] = $box[$j];    
        $box[$j] = $tmp;    
    }    
   
    for($a = $j = $i = 0; $i < $string_length; $i++) {    
        $a = ($a + 1) % 256;    
        $j = ($j + $box[$a]) % 256;    
        $tmp = $box[$a];    
        $box[$a] = $box[$j];    
        $box[$j] = $tmp;    
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));    
    }    
   
    if($operation == 'DECODE') {    
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {    
            return substr($result, 26);    
        } else {    
            return '';    
        }    
    } else {    
        return $keyc.str_replace('=', '', base64_encode($result));    
    }    
   
}    
   
function uc_serialize($arr, $htmlon = 0) {    
    include_once '../uc_client/lib/xml.class.php';    
    return xml_serialize($arr, $htmlon);    
}    
   
function uc_unserialize($s) {    
    include_once '../uc_client/lib/xml.class.php';    
    return xml_unserialize($s);    
}    
?>   
