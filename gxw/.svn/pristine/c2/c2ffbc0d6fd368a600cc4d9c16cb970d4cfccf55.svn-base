<?php
include_once("include/common.inc.php");
//header("Content-type: text/html; charset=utf-8");
foreach(API_Config() as $k=>$v)$$k=$v;
$type=Char_Cv('type','get');
Robot($type=='onez'?1:0);

$channelid=Char_Cv('channelid','get');
Channel($channelid);
if($Channel['allowguest']==1 || $username){
  if($Channel['ifonly']==1){
    header("location:group.php?only=1&channel=".$Channel['id']);
    exit();
  }
}

$botid=Char_Cv('botid','get');
$client=Char_Cv('client','get');



$onezdivcount=28;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="themes/<?=$Channel['theme']?$Channel['theme']:$setting['theme']?>/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<script type="text/javascript">
var client="<?=$client?>";
var theskin="<?=$Channel['theme']?$Channel['theme']:$setting['theme']?>";
var GroupId="<?=$Channel['id']?>";
var GroupName="<?=$Channel['name']?>";
OnezDivCount=<?=$onezdivcount?>;
</script>
<script type="text/javascript" src='themes/<?=$Channel['theme']?$Channel['theme']:$setting['theme']?>/config.js'></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/frame.js"></script>
<script type="text/javascript" src="js/move.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<script type="text/javascript" src="js/limit.js"></script>
<script type="text/javascript">
<?php
if($botid && file_exists('plugins/robot/'.$botid.'/config.php')){
  echo "ToBot('$botid','".$Bot[$botid]['name']."','".$Bot[$botid]['width']."','".$Bot[$botid]['height']."');";
}elseif(!$userid && $Channel['allowguest']==0){
  echo 'OpenLoginDialog("'.$Channel['id'].'");';
}elseif($hiddenGroup!=1){
  echo 'OpenGroupDialog("'.$Channel['id'].'");';
}
if(is_array($BotList[2])){
  foreach($BotList[2] as $v){
    echo "ToBot('$v','".$Bot[$v]['name']."','".$Bot[$v]['width']."','".$Bot[$v]['height']."');";
  }
}
?>
</script>
<?if($userid){?><ul id="minwins"></ul><?}?>
</body>
</html>