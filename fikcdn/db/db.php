<?php
	
// 登录到系统
include_once("../config/config_global.php");

function FikCDNDB_Connect()
{	
	global $_config;
	
    // 连接数据库
	$db_link = mysql_connect($_config['db']['1']['dbhost'],$_config['db']['1']['dbuser'], $_config['db']['1']['dbpw']);
	//or die("连接数据库错误" . mysql_error());
	if(!$db_link){
		return false;
	}
	
	$sql = "SET NAMES ".$_config['db']['1']['dbcharset'];
	mysql_query($sql,$db_link);
	mysql_select_db($_config['db']['1']['dbname'],$db_link);
	
	return $db_link;	
}


function FikCDNDB_Close($db_link)
{
	if($db_link)
	{
		mysql_close($db_link);
	}
}




?>
