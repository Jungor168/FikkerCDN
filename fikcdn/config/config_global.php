<?php

$_config = array();

// ----------------------------  CONFIG DB  ----------------------------- //
// 为了保证绝对安全，已对数据库访问进行IP限制，仅限服务器本机127.0.0.1能登录到数据库。
$_config['db']['1']['dbhost'] = '127.0.0.1:8816';
$_config['db']['1']['dbuser'] = 'root';
$_config['db']['1']['dbpw'] = '';
$_config['db']['1']['dbcharset'] = 'utf8';
$_config['db']['1']['pconnect'] = '0';
$_config['db']['1']['dbname'] = 'fikcdn';
$_config['db']['1']['tablepre'] = 'fikcdn_';
// ----------------------------  CONFIG DB  ----------------------------- //

$FikCdnCookiePaht	= "/";

$StatData_KeepDay = 7;
$FikConfig_IsUserCheckCode	= true;
$FikConfig_TaskIsLocalRun = true;

$FikConfig_KeeperLogin = false;
$FikConfig_IsCDNDemo = false;

//是否开放用户注册功能
$FikConfig_AllowRegister = false;

?>
