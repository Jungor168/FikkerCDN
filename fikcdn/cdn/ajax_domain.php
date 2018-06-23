<?php
	
include_once('../db/db.php');
include_once('../function/pub_function.php');
include_once('../function/define.php');
include_once('../function/fik_api.php');
include_once("function.php");

//是否登录
if(!FuncClient_IsLogin())
{
	$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoLogin);
	PubFunc_EchoJsonAndExit($aryResult,NULL);
}

$sMod 	 	 = isset($_GET['mod'])?$_GET['mod']:'';
$sAction 	 = isset($_GET['action'])?$_GET['action']:'';
$client_username 	= $_SESSION['fikcdn_client_username'];

if($sMod=='domain')
{
	if($sAction=="add")
	{
		$client_username 	= $_SESSION['fikcdn_client_username'];

		$sDomain 		= isset($_POST['domain'])?$_POST['domain']:'';
		$SSLOpt 		= isset($_POST['SSLOpt'])?$_POST['SSLOpt']:'';
		$SSLCrtContent	= isset($_POST['SSLCrtContent'])?$_POST['SSLCrtContent']:'';
		$SSLKeyContent 	= isset($_POST['SSLKeyContent'])?$_POST['SSLKeyContent']:'';
		$SSLExtraParams = isset($_POST['SSLExtraParams'])?$_POST['SSLExtraParams']:'';		
		$sSrcip 		= isset($_POST['srcip'])?$_POST['srcip']:'';
		$sUnicomIP		= isset($_POST['unicom_ip'])?$_POST['unicom_ip']:'';
		$UpsSSLOpt		= isset($_POST['UpsSSLOpt'])?$_POST['UpsSSLOpt']:'';
		$sIcp 			= isset($_POST['icp'])?$_POST['icp']:'';
		$dns_name 		= isset($_POST['dns_name'])?$_POST['dns_name']:'';
		$sBackup		= isset($_POST['backup'])?$_POST['backup']:'';
		$buy_id			= isset($_POST['buy_id'])?$_POST['buy_id']:'';
		$upstream_add_type	=isset($_POST['upstream_add_type'])?$_POST['upstream_add_type']:''; 
			
		$sDomain = trim($sDomain);
		$sSrcip = trim($sSrcip);
		$sUnicomIP = trim($sUnicomIP);
		
		//域名全部用小写保存
		$sDomain =  strtolower($sDomain);
				
		if(strlen($sUnicomIP) <=0 && strlen($sSrcip)<=0)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
	
		if( !is_numeric($SSLOpt) || !is_numeric($UpsSSLOpt) )
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}		
				
		if(strlen($sDomain)<=0 || strlen($sDomain)>64 || strlen($sUnicomIP)>64|| strlen($sSrcip)>64 || !is_numeric($buy_id))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		if(strlen($sBackup)>128 || strlen($sIcp)>32 || strlen($dns_name)>64)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		if($upstream_add_type!=0 && $upstream_add_type!=1){
			$upstream_add_type = 0;
		}
				
		$sDomain = htmlspecialchars($sDomain);
		$sSrcip = htmlspecialchars($sSrcip); 
		$sBackup = htmlspecialchars($sBackup); 
		$sIcp = htmlspecialchars($sIcp); 
		$sUnicomIP = htmlspecialchars($sUnicomIP); 
		$dns_name = htmlspecialchars($dns_name); 
		$SSLCrtContent = htmlspecialchars($SSLCrtContent); 
		$SSLKeyContent = htmlspecialchars($SSLKeyContent); 
		$SSLExtraParams = htmlspecialchars($SSLExtraParams);  
				
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{	
			$sDomain = mysql_real_escape_string($sDomain);
			$sSrcip = mysql_real_escape_string($sSrcip); 
			$sUnicomIP = mysql_real_escape_string($sUnicomIP);
			$sBackup = mysql_real_escape_string($sBackup);
			$sIcp = mysql_real_escape_string($sIcp); 
			$dns_name = mysql_real_escape_string($dns_name); 	
			$SSLCrtContent = mysql_real_escape_string($SSLCrtContent); 
			$SSLKeyContent = mysql_real_escape_string($SSLKeyContent); 
			$SSLExtraParams = mysql_real_escape_string($SSLExtraParams);  		
						
			//产品套餐
			$sql = "SELECT * FROM fikcdn_client WHERE username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'增加域名失败，登录用户帐号不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			$domain_need_verify  = mysql_result($result,0,"domain_need_verify");
	
			//产品套餐
			$sql = "SELECT * FROM fikcdn_buy WHERE id='$buy_id' AND username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'增加域名失败，你购买的产品套餐不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			$domain_num  = mysql_result($result,0,"domain_num");
			$product_end_time 		= mysql_result($result,0,"end_time");
			$product_has_data_flow  = mysql_result($result,0,"has_data_flow");
			$product_id = mysql_result($result,0,"product_id");
			
			$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'增加域名失败，你购买的产品套餐不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			$group_id = mysql_result($result,0,"group_id");
			$product_name = mysql_result($result,0,"name");
			
			$sql = "SELECT * FROM fikcdn_group WHERE id='$group_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'增加域名失败，产品套餐错误，产品不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}						
			
			//域名是否已经存在
			$sql = "SELECT * FROM fikcdn_domain WHERE hostname='$sDomain' AND group_id='$group_id'";
			$result = mysql_query($sql,$db_link);
			if($result && mysql_num_rows($result)>0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrDomainHasExist,'ErrorMsg'=>'增加域名失败，此域名已经存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}	
			
			//增加域名数量			
			$sql = "SELECT count(*) FROM fikcdn_domain WHERE username='$client_username' AND buy_id='$buy_id'"; 
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'增加域名失败，查询域名个数错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}	
			$domain_count  = mysql_result($result,0,"count(*)");
			if($domain_count>=$domain_num)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrDomainTooMore,'ErrorMsg'=>'增加域名失败，域名已达上限，您不能再继续增加域名。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
			
			if($domain_need_verify==1)
			{
				$domain_status=$PubDefine_HostStatusVerify;
			}
			else
			{
				$domain_status=$PubDefine_HostStatusOk;
			}
			
			$timenow = time();
			$sql="INSERT INTO fikcdn_domain(id,hostname,username,add_time,buy_id,group_id,upstream,unicom_ip,icp,DNSName,status,begin_time,end_time,note,upstream_add_all,SSLOpt,SSLCrtContent,SSLKeyContent,SSLExtraParams,UpsSSLOpt) 
					VALUES(NULL,'$sDomain','$client_username',$timenow,$buy_id,$group_id,'$sSrcip','$sUnicomIP','$sIcp','$dns_name','$domain_status',0,0,'$sBackup',$upstream_add_type,'$SSLOpt','$SSLCrtContent','$SSLKeyContent','$SSLExtraParams','$UpsSSLOpt')";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				echo $sql;
				echo mysql_error();
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrInsert,'ErrorMsg'=>'增加域名失败，插入数据库错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
			
			$domain_id = mysql_insert_id($db_link);
			
			// 域名不需要审核
			if($domain_status==$PubDefine_HostStatusOk)
			{
				//服务器组
				$sql = "SELECT * FROM fikcdn_node WHERE groupid='$group_id' AND is_close='0'";
				$result = mysql_query($sql,$db_link);
				if(!$result)
				{
					$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrUpdate,'ErrorMsg'=>'修改域名状态失败，查询服务器错误。');
					PubFunc_EchoJsonAndExit($aryResult,$db_link);	
				}
				
				$node_count = mysql_num_rows($result);
				for($i=0;$i<$node_count;$i++)
				{
					$node_id 		 = mysql_result($result,$i,"id");
					$node_ip 		 = mysql_result($result,$i,"ip");
					$node_password	 = mysql_result($result,$i,"password");
					$node_admin_port = mysql_result($result,$i,"admin_port");
					$node_auth_domain= mysql_result($result,$i,"auth_domain");
					$node_SessionID	 = mysql_result($result,$i,"SessionID");
					
					//加入后台任务
					$timenow = time();
					$sql = "INSERT INTO fikcdn_task(id,username,type,time,domain_id,node_id,product_id,buy_id,hostname,group_id) 
									VALUES(NULL,'$client_username',$PubDefine_TaskAddProxy,$timenow,$domain_id,$node_id,$product_id,$buy_id,'$sDomain',$group_id)";
					$result2 = mysql_query($sql,$db_link);
				}
			}
			
			$aryResult = array('Return'=>'True','id'=>$domain_id,'domain'=>$sDomain,'SSLOpt'=>$SSLOpt,'UpsSSLOpt'=>$UpsSSLOpt,'upstream'=>$sSrcip,'unicom_ip'=>$sUnicomIP,'product_name'=>$product_name,'status'=>$PubDefine_HostStatus[$domain_status],'note'=>$sBackup);
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'增加域名失败，连接数据库错误。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}	
	}
	else if($sAction=="modify")
	{
		$client_username 	= $_SESSION['fikcdn_client_username'];

		$domain_id 		= isset($_POST['domain_id'])?$_POST['domain_id']:'';
		$SSLOpt 		= isset($_POST['SSLOpt'])?$_POST['SSLOpt']:'';
		$SSLCrtContent	= isset($_POST['SSLCrtContent'])?$_POST['SSLCrtContent']:'';
		$SSLKeyContent 	= isset($_POST['SSLKeyContent'])?$_POST['SSLKeyContent']:'';
		$SSLExtraParams = isset($_POST['SSLExtraParams'])?$_POST['SSLExtraParams']:'';			
		$sSrcip 		= isset($_POST['srcip'])?$_POST['srcip']:'';
		$sUnicomIP		= isset($_POST['unicom_ip'])?$_POST['unicom_ip']:'';
		$UpsSSLOpt 		= isset($_POST['UpsSSLOpt'])?$_POST['UpsSSLOpt']:'';
		$sIcp 			= isset($_POST['icp'])?$_POST['icp']:'';
		$dns_name 		= isset($_POST['dns_name'])?$_POST['dns_name']:'';		
		$sBackup		= isset($_POST['backup'])?$_POST['backup']:'';
		$upstream_add_type	=isset($_POST['upstream_add_type'])?$_POST['upstream_add_type']:''; 
		
		$sSrcip = trim($sSrcip);
		$sUnicomIP = trim($sUnicomIP);
		
		if(strlen($sUnicomIP) <=0 && strlen($sSrcip)<=0)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
			
		if( !is_numeric($SSLOpt) || !is_numeric($UpsSSLOpt) )
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
							
		if( strlen($sUnicomIP)>64|| strlen($sSrcip)>64 || !is_numeric($domain_id))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		if(strlen($sBackup)>128 || strlen($sIcp)>32 || strlen($dns_name)>64)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		if($upstream_add_type!=0 && $upstream_add_type!=1){
			$upstream_add_type = 0;
		}
				
		$sSrcip = htmlspecialchars($sSrcip); 
		$sUnicomIP = htmlspecialchars($sUnicomIP); 
		$sBackup = htmlspecialchars($sBackup); 
		$sIcp = htmlspecialchars($sIcp); 
		$dns_name = htmlspecialchars($dns_name); 
		$SSLCrtContent = htmlspecialchars($SSLCrtContent); 
		$SSLKeyContent = htmlspecialchars($SSLKeyContent); 
		$SSLExtraParams = htmlspecialchars($SSLExtraParams);  
							
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{	
			$sSrcip = mysql_real_escape_string($sSrcip); 
			$sUnicomIP = mysql_real_escape_string($sUnicomIP); 
			$sBackup = mysql_real_escape_string($sBackup);
			$sIcp = mysql_real_escape_string($sIcp); 
			$dns_name = mysql_real_escape_string($dns_name); 
			$SSLCrtContent = mysql_real_escape_string($SSLCrtContent); 
			$SSLKeyContent = mysql_real_escape_string($SSLKeyContent); 
			$SSLExtraParams = mysql_real_escape_string($SSLExtraParams);  
									
			$sql="SELECT * FROM fikcdn_domain WHERE id='$domain_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'修改域名信息失败，您要修改的域名不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$hostname 		= mysql_result($result,0,"hostname");
			$username 		= mysql_result($result,0,"username");
			$buy_id			= mysql_result($result,0,"buy_id");
			$group_id		= mysql_result($result,0,"group_id");
			$upstream		= mysql_result($result,0,"upstream");
			$unicom_ip		= mysql_result($result,0,"unicom_ip");
			$use_transit_node		= mysql_result($result,0,"use_transit_node");
			$status					= mysql_result($result,0,"status");
			$upstream_add_all		= mysql_result($result,0,"upstream_add_all");				
			$domain_SSLOpt 	    	= mysql_result($result,0,"SSLOpt");	
			$domain_SSLCrtContent	= mysql_result($result,0,"SSLCrtContent");			
			$domain_SSLKeyContent	= mysql_result($result,0,"SSLKeyContent");
			$domain_SSLExtraParams	= mysql_result($result,0,"SSLExtraParams");								
			$domain_UpsSSLOpt	    = mysql_result($result,0,"UpsSSLOpt");		
						
			if(strlen($username)<=0 ||$username !=$client_username)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoPower,'ErrorMsg'=>'修改域名信息失败，您不能修改不属于您的域名。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
			
			//如果源站IP无修改或域名还在审核中则不需要修改Fikker服务器
			if($status==$PubDefine_HostStatusVerify)
			{
				$sql = "UPDATE fikcdn_domain SET upstream='$sSrcip',unicom_ip='$sUnicomIP',note='$sBackup',icp='$sIcp',use_transit_node='$use_transit',
					  SSLOpt='$SSLOpt',SSLCrtContent='$SSLCrtContent',SSLKeyContent='$SSLKeyContent',SSLExtraParams='$SSLExtraParams',UpsSSLOpt='$UpsSSLOpt',
					  upstream_add_all='$upstream_add_type' WHERE id='$domain_id'";
				$result = mysql_query($sql,$db_link);
				if(!$result)
				{
					$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrUpdate,'ErrorMsg'=>'修改域名信息失败，更新数据库操作错误。');
					PubFunc_EchoJsonAndExit($aryResult,$db_link);	
				}
					
				$aryResult = array('Return'=>'True','id'=>$domain_id);
				PubFunc_EchoJsonAndExit($aryResult,$db_link);					
			}
			
			//查询产品所属服务器组
			$sql = "SELECT * FROM fikcdn_buy WHERE id='$buy_id' AND username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'修改域名状态失败，您域名所属的产品套餐不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}	
			$product_id	= mysql_result($result,0,"product_id");
						
			//查询产品所属服务器组
			$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'修改域名信息失败，您购买的产品套餐已不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}	
			
			$product_name	= mysql_result($result,0,"name");
			$group_id 		= mysql_result($result,0,"group_id");
			
			$modify_upstream = 0;
			$modify_domain = 0;
			$modify_type = 0;
			
			if($sSrcip!=$upstream || $sUnicomIP!=$unicom_ip || $upstream_add_type!=$upstream_add_all)
			{
				$modify_upstream =1;
			}
			
			if($SSLOpt!=$domain_SSLOpt || $SSLCrtContent!=$domain_SSLCrtContent || $SSLKeyContent!=$domain_SSLKeyContent|| $SSLExtraParams!=$domain_SSLExtraParams || $UpsSSLOpt!=$domain_UpsSSLOpt)
			{
				$modify_domain = 1;
			}
			
			if($modify_upstream ==1 || $modify_domain ==1 )
			{	
				if($modify_upstream==1 && $modify_domain ==1 )
				{
					$modify_type =1;
				}
				else if($modify_upstream==1)
				{
					$modify_type =2;
				}
				else if($modify_domain ==1)
				{
					$modify_type =3;
				}
				
				//删除还没执行完成的修改任务
				$sql = "DELETE FROM fikcdn_task WHERE domain_id=$domain_id AND type=$PubDefine_TaskModifyUpstream";
				$result2 = mysql_query($sql,$db_link);	
				
				//删除还没执行完成的添加任务
				$sql = "DELETE FROM fikcdn_task WHERE domain_id=$domain_id AND type=$PubDefine_TaskAddProxy";
				$result2 = mysql_query($sql,$db_link);	
				
				$sql = "SELECT * FROM fikcdn_node WHERE groupid='$group_id' AND is_close='0'";
				$result = mysql_query($sql,$db_link);
				if(!$result)
				{
					$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrUpdate,'ErrorMsg'=>'修改域名信息失败，查询服务器错误。');
					PubFunc_EchoJsonAndExit($aryResult,$db_link);	
				}				
				
				$node_count = mysql_num_rows($result);
				for($i=0;$i<$node_count;$i++)
				{
					$node_id 		 = mysql_result($result,$i,"id");
					$node_ip 		 = mysql_result($result,$i,"ip");
					$node_password	 = mysql_result($result,$i,"password");
					$node_admin_port = mysql_result($result,$i,"admin_port");
					$node_auth_domain= mysql_result($result,$i,"auth_domain");
					$node_SessionID	 = mysql_result($result,$i,"SessionID");
					
					//添加修改任务，让后台去执行
					$timenow = time();
					$sql = "INSERT INTO fikcdn_task(id,username,type,time,domain_id,node_id,product_id,buy_id,hostname,group_id,ext) 
									VALUES(NULL,'$client_username',$PubDefine_TaskModifyUpstream,$timenow,$domain_id,$node_id,$product_id,$buy_id,'$hostname',$group_id,'$modify_type')";
					$result2 = mysql_query($sql,$db_link);					
				}	
			}
			
			$sql = "UPDATE fikcdn_domain SET note='$sBackup',upstream='$sSrcip',unicom_ip='$sUnicomIP',icp='$sIcp',DNSName='$dns_name',upstream_add_all='$upstream_add_type',
				SSLOpt='$SSLOpt',SSLCrtContent='$SSLCrtContent',SSLKeyContent='$SSLKeyContent',SSLExtraParams='$SSLExtraParams',UpsSSLOpt='$UpsSSLOpt' WHERE id='$domain_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrUpdate,'ErrorMsg'=>'修改域名信息失败，更新数据库操作错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}

			$aryResult = array('Return'=>'True','id'=>$domain_id);
			PubFunc_EchoJsonAndExit($aryResult,$db_link);				
		}		
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'修改域名信息失败，连接数据库错误。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}		
	}
	else if($sAction=="del")
	{
		$client_username 	= $_SESSION['fikcdn_client_username'];

		$domain_id 	= isset($_POST['domain_id'])?$_POST['domain_id']:'';
		
		if( !is_numeric($domain_id))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{				
			$sql="SELECT * FROM fikcdn_domain WHERE id='$domain_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'删除域名失败，您要删除的域名不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}			
			
			$hostname 		= mysql_result($result,0,"hostname");
			$username 		= mysql_result($result,0,"username");
			$buy_id			= mysql_result($result,0,"buy_id");
			$upstream		= mysql_result($result,0,"upstream");
			$status			= mysql_result($result,0,"status");
			if(strlen($username)<=0 ||$username !=$client_username)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoPower,'ErrorMsg'=>'删除域名失败，您不能删除不属于您的域名。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
			
			//还在审核中，可直接删除
			if($status==$PubDefine_HostStatusVerify)
			{
			 	$sql = "DELETE FROM fikcdn_domain WHERE id=$domain_id";
				$result = mysql_query($sql,$db_link);
				if(!$result)
				{
					$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrDel,'ErrorMsg'=>'删除域名失败，操作数据库错误。');
					PubFunc_EchoJsonAndExit($aryResult,$db_link);
				}
				
				$aryResult = array('Return'=>'True','id'=>$domain_id);
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
						
			//查询产品所属服务器组
			$sql = "SELECT * FROM fikcdn_buy WHERE id='$buy_id' AND username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'删除域名失败，您域名所属的产品套餐不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}	
			$product_id	= mysql_result($result,0,"product_id");
			
			//查询产品所属服务器组
			$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'删除域名失败，您购买的产品套餐已不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}	
			
			$product_name	= mysql_result($result,0,"name");
			$group_id 		= mysql_result($result,0,"group_id");
			
			//删除还没执行完成的添加任务
			$sql = "DELETE FROM fikcdn_task WHERE domain_id=$domain_id AND type>=$PubDefine_TaskModifyUpstream AND type<=$PubDefine_TaskAddProxy";
			$result2 = mysql_query($sql,$db_link);
						
			//服务器组
			$sql = "SELECT * FROM fikcdn_node WHERE groupid='$group_id' AND is_close='0'";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrUpdate,'ErrorMsg'=>'删除域名失败，查询服务器错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
			
			$node_count = mysql_num_rows($result);
			for($i=0;$i<$node_count;$i++)
			{
				$node_id 		 = mysql_result($result,$i,"id");
				$node_ip 		 = mysql_result($result,$i,"ip");
				$node_password	 = mysql_result($result,$i,"password");
				$node_admin_port = mysql_result($result,$i,"admin_port");
				$node_auth_domain= mysql_result($result,$i,"auth_domain");
				$node_SessionID	 = mysql_result($result,$i,"SessionID");
				
				//加入后台任务
				$timenow = time();
				$sql = "INSERT INTO fikcdn_task(id,username,type,time,domain_id,node_id,product_id,buy_id,hostname,group_id) 
								VALUES(NULL,'$client_username',$PubDefine_TaskDelDomain,$timenow,$domain_id,$node_id,$product_id,$buy_id,'$hostname',$group_id)";
				$result2 = mysql_query($sql,$db_link);
			}			 	
			
			//删除域名
			$sql = "DELETE FROM fikcdn_domain WHERE id=$domain_id";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrDel,'ErrorMsg'=>'删除域名失败，操作数据库错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			//删除源站
			$sql = "DELETE FROM fikcdn_upstream WHERE group_id='$group_id' AND hostname='$hostname';";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				$aryResult = array('Return'=>'false','ErrorNo'=>$PubDefine_ErrDel);
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$aryResult = array('Return'=>'True','id'=>$domain_id);
			PubFunc_EchoJsonAndExit($aryResult,$db_link);		
		}
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'删除域名失败，连接数据库错误。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}
	}
	else if($sAction=="start" || $sAction=="stop")
	{
		$client_username 	= $_SESSION['fikcdn_client_username'];

		$domain_id 	= isset($_POST['domain_id'])?$_POST['domain_id']:'';
		
		if( !is_numeric($domain_id))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		$new_status = $PubDefine_HostStatusStop;
		
		if($sAction=="start")
		{
			$new_status = $PubDefine_HostStatusOk;
		}
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{				
			$sql="SELECT * FROM fikcdn_domain WHERE id='$domain_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'修改域名状态失败，您要修改的域名不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}			
			
			$hostname 		= mysql_result($result,0,"hostname");
			$username 		= mysql_result($result,0,"username");
			$buy_id			= mysql_result($result,0,"buy_id");
			$upstream		= mysql_result($result,0,"upstream");
			$status			= mysql_result($result,0,"status");
			if(strlen($username)<=0 ||$username !=$client_username)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoPower,'ErrorMsg'=>'修改域名状态失败，您不能修改不属于您的域名。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
			
			//还在审核中，不能修改状态
			if($status==$PubDefine_HostStatusVerify)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoPower,'ErrorMsg'=>'修改域名状态失败，域名还在审核中。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);		
			}
			
			//查询产品所属服务器组
			$sql = "SELECT * FROM fikcdn_buy WHERE id='$buy_id' AND username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'修改域名状态失败，您域名所属的产品套餐不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}	
			$product_id	= mysql_result($result,0,"product_id");
			
			//查询产品所属服务器组
			$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'修改域名状态失败，您购买的产品套餐不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}	
			
			$product_name	= mysql_result($result,0,"name");
			$group_id 		= mysql_result($result,0,"group_id");
			
			//服务器组
			$sql = "SELECT * FROM fikcdn_node WHERE groupid='$group_id' AND is_close='0'";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrUpdate,'ErrorMsg'=>'修改域名状态失败，查询服务器错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
			
			$node_count = mysql_num_rows($result);
			for($i=0;$i<$node_count;$i++)
			{
				$node_id 		 = mysql_result($result,$i,"id");
				$node_ip 		 = mysql_result($result,$i,"ip");
				$node_password	 = mysql_result($result,$i,"password");
				$node_admin_port = mysql_result($result,$i,"admin_port");
				$node_auth_domain= mysql_result($result,$i,"auth_domain");
				$node_SessionID	 = mysql_result($result,$i,"SessionID");
				
				//加入后台任务
				$timenow = time();
				$sql = "INSERT INTO fikcdn_task(id,username,type,time,domain_id,node_id,product_id,buy_id,hostname,group_id) 
								VALUES(NULL,'$client_username',$PubDefine_TaskModifyDomainStatus,$timenow,$domain_id,$node_id,$product_id,$buy_id,'$hostname',$group_id)";
				$result2 = mysql_query($sql,$db_link);
			}			 	
			
			//修改域名状态
			$sql = "UPDATE fikcdn_domain SET status=$new_status WHERE id=$domain_id";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrDel,'ErrorMsg'=>'修改域名状态失败，操作数据库错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}
			
			$aryResult = array('Return'=>'True','id'=>$domain_id);
			PubFunc_EchoJsonAndExit($aryResult,$db_link);		
		}	
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'修改域名状态失败，连接数据库错误。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}
	}
	else if($sAction=="cleancache")
	{
		$client_username 	= $_SESSION['fikcdn_client_username'];

		$buy_id = isset($_POST['buy_id'])?$_POST['buy_id']:'';
		$url1 	= isset($_POST['url1'])?$_POST['url1']:'';
		$url2 	= isset($_POST['url2'])?$_POST['url2']:'';
		$url3 	= isset($_POST['url3'])?$_POST['url3']:'';
		
		$url1 = trim($url1);
		$url2 = trim($url2);
		$url3 = trim($url3);

		if( strlen($url1)<=0 && strlen($url2)<=0 && strlen($url3)<=0 )
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		if( !is_numeric($buy_id))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		if( strlen($url1)>1024 || strlen($url2)>1024 || strlen($url3)>1024 )
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{		
			$aryUrl = array();
			
			$url1 = mysql_real_escape_string($url1);
			$url2 = mysql_real_escape_string($url2);
			$url3 = mysql_real_escape_string($url3);
					
			//查询产品所属服务器组
			$sql = "SELECT * FROM fikcdn_buy WHERE id='$buy_id' AND username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'更新缓存文件失败，您购买的产品套餐不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}	
			$product_id	= mysql_result($result,0,"product_id");
			$domain_num	= mysql_result($result,0,"domain_num");
								
			//查询产品所属服务器组
			$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'更新缓存文件失败，您购买的产品套餐不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}	
			
			$product_name	= mysql_result($result,0,"name");
			$group_id 		= mysql_result($result,0,"group_id");
			
			$aryResult = array('Return'=>'True','id'=>$product_id);
						
			//服务器组
			$sql = "SELECT * FROM fikcdn_node WHERE groupid='$group_id' AND is_close='0'";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'更新缓存文件失败，服务器组不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
		
			$node_count = mysql_num_rows($result);
			for($i=0;$i<$node_count;$i++)
			{
				$node_id 		 = mysql_result($result,$i,"id");
				$node_ip 		 = mysql_result($result,$i,"ip");
				$node_password	 = mysql_result($result,$i,"password");
				$node_admin_port = mysql_result($result,$i,"admin_port");
				$node_auth_domain= mysql_result($result,$i,"auth_domain");
				$node_SessionID	 = mysql_result($result,$i,"SessionID");
				
				//加入后台删除任务
				$timenow = time();
				
				if(strlen($url1)>0)
				{
					if(PubFunc_IsHomePage($url1))
					{
						$url1 = $url1.'/';
					}
					
					$sql = "INSERT INTO fikcdn_task(id,username,type,time,domain_id,node_id,product_id,buy_id,hostname,group_id,ext) 
									VALUES(NULL,'$client_username',$PubDefine_TaskAdminClearCache,$timenow,0,$node_id,$product_id,$buy_id,'',$group_id,'$url1')";
					$result2 = mysql_query($sql,$db_link);					
					if(!$result2)
					{

					}
				}
				
				if(strlen($url2)>0)
				{
					if(PubFunc_IsHomePage($url2))
					{
						$url2 = $url2.'/';
					}
					
					$sql = "INSERT INTO fikcdn_task(id,username,type,time,domain_id,node_id,product_id,buy_id,hostname,group_id,ext) 
									VALUES(NULL,'$client_username',$PubDefine_TaskAdminClearCache,$timenow,0,$node_id,$product_id,$buy_id,'',$group_id,'$url2')";
					$result2 = mysql_query($sql,$db_link);					
					if(!$result2)
					{

					}
				}
				
				if(strlen($url3)>0)
				{
					if(PubFunc_IsHomePage($url3))
					{
						$url3 = $url3.'/';
					}
									
					$sql = "INSERT INTO fikcdn_task(id,username,type,time,domain_id,node_id,product_id,buy_id,hostname,group_id,ext) 
									VALUES(NULL,'$client_username',$PubDefine_TaskAdminClearCache,$timenow,0,$node_id,$product_id,$buy_id,'',$group_id,'$url3')";
					$result2 = mysql_query($sql,$db_link);					
					if(!$result2)
					{

					}
				}
			}			
					
			PubFunc_EchoJsonAndExit($aryResult,$db_link);		
		}	
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'清理缓存文件失败，连接数据库错误。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}	
	}
	else if($sAction == "cleandircache")
	{
		$domain_id = isset($_POST['domain_id'])?$_POST['domain_id']:'';
		$url 	= isset($_POST['url'])?$_POST['url']:'';
		
		$url = trim($url);
		
		if( strlen($url)<=0)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		if( !is_numeric($domain_id))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
		
		if( strlen($url)>1024)
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}	
	
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$url = mysql_real_escape_string($url);			
			
			//域名是否存在
			$sql = "SELECT * FROM fikcdn_domain WHERE id='$domain_id' AND username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if(!$result || mysql_num_rows($result)<=0)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'更新缓存失败，你提交的域名不存在。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
			
			$hostname 		 = mysql_result($result,0,"hostname");	
			$group_id		 = mysql_result($result,0,"group_id");		
			
			if(ord("/")!=ord($url))
			{
				$sClearUrl = $hostname.'/'.$url;
			}
			else
			{
				$sClearUrl = $hostname.$url;
			}
			
			//服务器组
			$sql = "SELECT * FROM fikcdn_node WHERE groupid='$group_id' AND is_close='0'";
			$result = mysql_query($sql,$db_link);
			if(!$result)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'清理缓存文件失败，服务器查询错误。');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);	
			}
		
			$node_count = mysql_num_rows($result);
			for($i=0;$i<$node_count;$i++)
			{
				$node_id 		 = mysql_result($result,$i,"id");
				$node_ip 		 = mysql_result($result,$i,"ip");
				$node_password	 = mysql_result($result,$i,"password");
				$node_admin_port = mysql_result($result,$i,"admin_port");
				$node_auth_domain= mysql_result($result,$i,"auth_domain");
				$node_SessionID	 = mysql_result($result,$i,"SessionID");
				
				//加入后台删除任务
				$timenow = time();
				$sql = "INSERT INTO fikcdn_task(id,username,type,time,domain_id,node_id,product_id,buy_id,hostname,group_id,ext) 
								VALUES(NULL,'$client_username',$PubDefine_TaskDirClearCache,$timenow,0,$node_id,0,0,'',$group_id,'$sClearUrl')";
				$result2 = mysql_query($sql,$db_link);					
				if(!$result2)
				{
					echo mysql_error($db_link).'<br />';
					echo $sql.'<br />';
				}
			}			
			
			$aryResult = array('Return'=>'True','domain_id'=>$domain_id);
			
			PubFunc_EchoJsonAndExit($aryResult,$db_link);	
		}		
		else
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrConnectDB,'ErrorMsg'=>'清理缓存文件失败，连接数据库错误。');
			PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}	
		
	}	
}

?>
