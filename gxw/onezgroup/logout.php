<?
include_once("include/common.inc.php");
$channelid=Char_Cv('channelid','get');
echo API_Logout('index.php?channelid='.$channelid);
?>