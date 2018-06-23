<?php
session_start(); 	
include_once('../db/db.php');
include_once('../function/pub_function.php');
include_once('../function/define.php');
include_once("function.php");

$sMod 	 	 = isset($_GET['mod'])?$_GET['mod']:'';
$sAction 	 = isset($_GET['action'])?$_GET['action']:'';

if($sMod=='user')
{
	if($sAction=="register")
	{
		$sUsername 	= isset($_POST['username'])?$_POST['username']:'';
		$password 	= isset($_POST['password'])?$_POST['password']:'';
		$realname 	= isset($_POST['realname'])?$_POST['realname']:'';
		$compname 	= isset($_POST['compname'])?$_POST['compname']:'';
		$phone 		= isset($_POST['phone'])?$_POST['phone']:'';
		$qq 		= isset($_POST['qq'])?$_POST['qq']:'';
		$addr 		= isset($_POST['addr'])?$_POST['addr']:'';
		$checkcode	= isset($_POST['checkcode'])?$_POST['checkcode']:'';
	
		if(strlen($sUsername)<=0 || strlen($sUsername)>64 || strlen($password)!=32 || strlen($realname)<=0 || strlen($realname)>64)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误。');
			PubFunc_EchoJsonAndExit($aryResult,NULL);	
		}
		
		if(strlen($phone)<=0 || strlen($phone)>32)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误。');
			PubFunc_EchoJsonAndExit($aryResult,NULL);	
		}
		
		if(strlen($compname)>128 || strlen($qq)>32 || strlen($addr)>128 || strlen($checkcode)<=0 || strlen($checkcode)>6 )
		{			
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误。');
			PubFunc_EchoJsonAndExit($aryResult,NULL);	
		}
		
		if($FikConfig_AllowRegister==false)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoPower,'ErrorMsg'=>'本系统不开放用户帐号注册。');
			PubFunc_EchoJsonAndExit($aryResult,NULL);	
		}
		
		$sSessionCheckCode = $_SESSION['CheckCode'];
		if(strcasecmp($sSessionCheckCode,$checkcode)!=0 && strlen($checkcode)>0)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrCheckCode,'ErrorMsg'=>'验证码错误。');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		$db_link = FikCDNDB_Connect();
		if(!$db_link)
		{			
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'注册用户失败，数据库连接错误。');
			PubFunc_EchoJsonAndExit($aryResult,NULL);	
		}
		
		$sUsername 	= mysql_real_escape_string($sUsername); 
		$password 	= mysql_real_escape_string($password);
		$realname 	= mysql_real_escape_string($realname);  
		$compname 	= mysql_real_escape_string($compname);  	
		$phone 		= mysql_real_escape_string($phone);  	
		$qq 		= mysql_real_escape_string($qq);  	
		$addr 		= mysql_real_escape_string($addr); 
		$checkcode	= mysql_real_escape_string($checkcode); 
			
		// 是否重复添加
		$sql = "SELECT * FROM fikcdn_client WHERE username='$sUsername'";
		$result = mysql_query($sql,$db_link);
		if($result && mysql_num_rows($result)>0)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrHasExist,'ErrorMsg'=>'注册用户失败，用户帐号已经存在。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);		
		}	
		
		$add_time = time();
		$client_ip = $_SERVER["REMOTE_ADDR"]; 
		
		$sql = "INSERT INTO fikcdn_client(id,username,realname,password,enable_login,register_time,register_ip,addr,phone,company_name,qq,note) VALUES(NULL,'$sUsername',
				'$realname','$password','1','$add_time','$client_ip','$addr','$phone','$compname','$qq','');";
		$result = mysql_query($sql,$db_link);	
		if(!$result)
		{			
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrInsert,'ErrorMsg'=>'注册用户失败，数据库错误。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);	
		}	

		$aryResult = array('Return'=>'True','name'=>$sUsername );
		PubFunc_EchoJsonAndExit($aryResult,$db_link);		
	}
}

?>
