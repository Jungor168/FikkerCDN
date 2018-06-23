<?php
set_time_limit(0);

include_once('../db/db.php');
include_once('../function/fik_api.php');
include_once("function.php");

//是否登录
if(!FuncClient_IsLogin())
{
	$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrNoLogin);
	PubFunc_EchoJsonAndExit($aryResult,NULL);
}
$client_username 	=$_SESSION['fikcdn_client_username'];
	
$sMod  		= isset($_GET['mod'])?$_GET['mod']:'';
$sAction  	= isset($_GET['action'])?$_GET['action']:'';
if($sMod=="proxy")
{
	if($sAction=="max_bandwidth")
	{
		$domain_id 	= isset($_GET['domain_id'])?$_GET['domain_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		if(!is_numeric($domain_id) || !is_numeric($timeval))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
				
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$aryAllData = array();
			
			$sql = "SELECT * FROM fikcdn_domain WHERE id=$domain_id AND username='$client_username'";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2 || mysql_num_rows($result2)<=0)
			{
				$aryResult = array('Return'=>'False','2.ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}	
			
			$hostname  	 = mysql_result($result2,0,"hostname");	
			$username = mysql_result($result2,0,"username");
			$buy_id = mysql_result($result2,0,"buy_id");
			$group_id = mysql_result($result2,0,"group_id");
			
			$timenow=time();
			
			if($timeval==60)
			{
				$timeval1 = mktime(0,59,59,date("m"),1,date("Y"));
				$timeval2 = mktime(0,0,0,date("m")-1,1,date("Y"));
				$sql = "SELECT * FROM domain_stat_host_max_bandwidth WHERE domain_id='$domain_id' AND time>=$timeval2 AND time<$timeval1 ORDER BY time ASC";
			}	
			else if($timeval==30)
			{
				$timeval1 = mktime(0,0,0,date("m"),1,date("Y"));
				$sql = "SELECT * FROM domain_stat_host_max_bandwidth WHERE domain_id='$domain_id' AND time>=$timeval1 ORDER BY time ASC";
			}
			else
			{
				if($timeval==1)
				{
					$timeval = $timenow-24*60*60;
				}
				else if($timeval==7)
				{
					$timeval = $timenow-24*60*60*7;
				}
				else if($timeval==30)
				{
					$timeval = $timenow-24*60*60*30;
				}
			
				//查找此域名的流量统计
				$sql = "SELECT * FROM domain_stat_host_max_bandwidth WHERE domain_id='$domain_id' AND time>=$timeval ORDER BY time ASC";
			}
			
			$result2 = mysql_query($sql,$db_link);
			if(!$result2)
			{
				echo $sql;
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}			
			
			$aryDataDown=array();
			$aryDataUp=array();
			
			$row_count2 = mysql_num_rows($result2);	
			for($k=0;$k<$row_count2;$k++)
			{
				$stat_time = mysql_result($result2,$k,"time");
				$bandwidth_down = mysql_result($result2,$k,"bandwidth_down");
				$bandwidth_up = mysql_result($result2,$k,"bandwidth_up");						
				
				$aryDataDown[$k][0] = $stat_time;
				$aryDataDown[$k][1] = $bandwidth_down;	
				
				$aryDataUp[$k][0] = $stat_time;
				$aryDataUp[$k][1] = $bandwidth_up;				
			}
			
			$aryAllData[0]["name"]="用户下载峰值带宽";
			$aryAllData[0]["data"]=$aryDataDown;
			
			$aryAllData[1]["name"]="用户上传峰值带宽";
			$aryAllData[1]["data"]=$aryDataUp;
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);
	}	
	else if($sAction=="bandwidth")
	{
		$domain_id 	= isset($_GET['domain_id'])?$_GET['domain_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		if(!is_numeric($domain_id) || !is_numeric($timeval))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
				
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$aryAllData = array();
			
			$sql = "SELECT * FROM fikcdn_domain WHERE id=$domain_id AND username='$client_username'";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2 || mysql_num_rows($result2)<=0)
			{
				$aryResult = array('Return'=>'False','2.ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}	
			
			$hostname  	 = mysql_result($result2,0,"hostname");	
			$username = mysql_result($result2,0,"username");
			$buy_id = mysql_result($result2,0,"buy_id");
			$group_id = mysql_result($result2,0,"group_id");
			
			$timenow=time();
			$nDay1 = date("d")-$timeval;
			
			$timeval1 = mktime(0,0,0,date("m"),$nDay1,date("Y"));
			$timeval2 = $timeval1+24*60*60;
			$sql = "SELECT * FROM domain_stat_host_bandwidth WHERE domain_id='$domain_id' AND time>=$timeval1 AND time<$timeval2 ORDER BY time ASC";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2)
			{
				echo $sql;
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}			
			
			$aryDataDown=array();
			$aryDataUp=array();
			
			$row_count2 = mysql_num_rows($result2);	
			for($k=0;$k<$row_count2;$k++)
			{
				$stat_time = mysql_result($result2,$k,"time");
				$bandwidth_down = mysql_result($result2,$k,"bandwidth_down");
				$bandwidth_up = mysql_result($result2,$k,"bandwidth_up");						
				
				$aryDataDown[$k][0] = $stat_time;
				$aryDataDown[$k][1] = $bandwidth_down;	
				
				$aryDataUp[$k][0] = $stat_time;
				$aryDataUp[$k][1] = $bandwidth_up;				
			}
			
			$aryAllData[0]["name"]="用户下载带宽";
			$aryAllData[0]["data"]=$aryDataDown;	
			
			$aryAllData[1]["name"]="用户上传带宽";
			$aryAllData[1]["data"]=$aryDataUp;	
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);
	}
	else if($sAction=="DownloadCount")
	{
		$domain_id 	= isset($_GET['domain_id'])?$_GET['domain_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		if(!is_numeric($domain_id) || !is_numeric($timeval))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
				
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$aryAllData = array();
			
			$sql = "SELECT * FROM fikcdn_domain WHERE id=$domain_id AND username='$client_username'";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2 || mysql_num_rows($result2)<=0)
			{
				$aryResult = array('Return'=>'False','2.ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}	
			
			$hostname  	 = mysql_result($result2,0,"hostname");
			$username = mysql_result($result2,0,"username");
			$buy_id = mysql_result($result2,0,"buy_id");
			$group_id = mysql_result($result2,0,"group_id");
			
			$timenow=time();
			
			if($timeval==7)
			{
				$timeval = $timenow-24*60*60*7;
			}
			else if($timeval==30)
			{
				$timeval = $timenow-24*60*60*30;
			}
			else if($timeval==90)
			{
				$timeval = $timenow-24*60*60*90;
			}
		
			//查找此域名的流量统计
			$sql = "SELECT * FROM domain_stat_group_day WHERE domain_id='$domain_id' AND time>=$timeval ORDER BY time ASC";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2)
			{
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}			
			
			$aryDataDown=array();
			$aryDataUp=array();
			
			$row_count2 = mysql_num_rows($result2);	
			for($k=0;$k<$row_count2;$k++)
			{
				$stat_time = mysql_result($result2,$k,"time");
				$DownloadCount = mysql_result($result2,$k,"DownloadCount");
				$UploadCount = mysql_result($result2,$k,"UploadCount");						
				
				$aryDataDown[$k][0] = $stat_time;  
				$aryDataDown[$k][1] = round($DownloadCount/1024,2);	
				
				$aryDataUp[$k][0] = $stat_time;
				$aryDataUp[$k][1] = round($UploadCount/1024,2);				
			}
			
			$aryAllData[0]["name"]="日用户下载流量";
			$aryAllData[0]["data"]=$aryDataDown;
			
			$aryAllData[1]["name"]="日用户上传流量";
			$aryAllData[1]["data"]=$aryDataUp;			
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);
	}
	else if($sAction=="RequestCount")
	{
		$domain_id 	= isset($_GET['domain_id'])?$_GET['domain_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		if(!is_numeric($domain_id) || !is_numeric($timeval))
		{
			$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrParam,'ErrorMsg'=>'参数错误');
			PubFunc_EchoJsonAndExit($aryResult,NULL);
		}
				
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$aryAllData = array();
			
			$sql = "SELECT * FROM fikcdn_domain WHERE id=$domain_id AND username='$client_username'";
			$result2 = mysql_query($sql,$db_link);
			if(!$result2 || mysql_num_rows($result2)<=0)
			{
				$aryResult = array('Return'=>'False','2.ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}	
			
			$hostname  	 = mysql_result($result2,0,"hostname");
			$username = mysql_result($result2,0,"username");
			$buy_id = mysql_result($result2,0,"buy_id");
			$group_id = mysql_result($result2,0,"group_id");
			
			$timenow=time();
			
			if($timeval==7)
			{
				$timeval = $timenow-24*60*60*7;
			}
			else if($timeval==30)
			{
				$timeval = $timenow-24*60*60*30;
			}
			else if($timeval==90)
			{
				$timeval = $timenow-24*60*60*90;
			}
		
			//查找此域名的流量统计
			$sql = "SELECT * FROM domain_stat_group_day WHERE domain_id='$domain_id' AND time>=$timeval ORDER BY time ASC";
	
			$result2 = mysql_query($sql,$db_link);
			if(!$result2)
			{
				echo $sql;
				$aryResult = array('Return'=>'False','ErrorNo'=>$PubDefine_ErrQuery,'ErrorMsg'=>'域名不存在');
				PubFunc_EchoJsonAndExit($aryResult,$db_link);
			}			
			
			$aryDataDown=array();

			$row_count2 = mysql_num_rows($result2);	
			for($k=0;$k<$row_count2;$k++)
			{
				$stat_time = mysql_result($result2,$k,"time");
				$DownloadCount = mysql_result($result2,$k,"RequestCount");			
				
				$aryDataDown[$k][0] = $stat_time;
				$aryDataDown[$k][1] = $DownloadCount;				
			}
			
			$aryAllData[0]["name"]="日请求量";
			$aryAllData[0]["data"]=$aryDataDown;		
		}
		echo  json_encode($aryAllData);
		mysql_close($db_link);
	}					
}
else if($sMod=="product")
{
	if($sAction=="DayDownloadCount")
	{		
		$buy_id 	= isset($_GET['buy_id'])?$_GET['buy_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$sql = "SELECT * FROM fikcdn_buy WHERE id=$buy_id AND username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if($result && mysql_num_rows($result)>0)
			{
				$aryAllData = array();
				
				$this_buy_id	 = mysql_result($result,0,"id");
				$this_username = mysql_result($result,0,"username");
				$this_product_id = mysql_result($result,0,"product_id");
				
				$sql = "SELECT * FROM fikcdn_product WHERE id=$this_product_id";
				$result1 = mysql_query($sql,$db_link);
				if($result1 && mysql_num_rows($result1)>0)
				{
					$product_name = mysql_result($result1,0,"name");
				}
				
				$sql = "SELECT * FROM fikcdn_client WHERE username='$this_username'";
				$result1 = mysql_query($sql,$db_link);
				if($result1 && mysql_num_rows($result1)>0)
				{
					$company_name = mysql_result($result1,0,"company_name");
					$realname = mysql_result($result1,0,"realname");
				}
				
				$timenow = time();
				
				if($timeval==7)
				{
					$timeval = $timenow-24*60*60*7;
				}
				else if($timeval==30)
				{
					$timeval = $timenow-24*60*60*30;
				}
				else if($timeval==90)
				{
					$timeval = $timenow-24*60*60*90;
				}				
				
				//查找此域名的流量统计
				$sql = "SELECT * FROM domain_stat_product_day WHERE buy_id=$this_buy_id AND time>$timeval ORDER BY time ASC";
				$result2 = mysql_query($sql,$db_link);
				if(!$result2)
				{
					exit();
				}			
				
				$aryDataDown=array();
				$aryDataUp=array();
				
				$row_count2 = mysql_num_rows($result2);	
				for($k=0;$k<$row_count2;$k++)
				{
					$stat_time = mysql_result($result2,$k,"time");
					$DownloadCount = mysql_result($result2,$k,"DownloadCount");					
					$UploadCount = mysql_result($result2,$k,"UploadCount");			
					
					$aryDataDown[$k][0] = $stat_time;
					$aryDataDown[$k][1] = $DownloadCount;	
					
					$aryDataUp[$k][0] = $stat_time;
					$aryDataUp[$k][1] = $UploadCount;				
				}
				
				$aryAllData[0]["name"]="日用户下载流量";
				$aryAllData[0]["data"]=$aryDataDown;
				
				$aryAllData[1]["name"]="日用户上传流量";
				$aryAllData[1]["data"]=$aryDataUp;
			}
			echo  json_encode($aryAllData);
			mysql_close($db_link);
		}		
	}	
	else if($sAction=="DayRequestCount")
	{		
		$buy_id 	= isset($_GET['buy_id'])?$_GET['buy_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$sql = "SELECT * FROM fikcdn_buy WHERE id=$buy_id AND username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if($result && mysql_num_rows($result)>0)
			{		
				$aryAllData = array();		
				$this_buy_id	 = mysql_result($result,0,"id");
				$this_username = mysql_result($result,0,"username");
				$this_product_id = mysql_result($result,0,"product_id");
				
				$sql = "SELECT * FROM fikcdn_product WHERE id=$this_product_id";
				$result1 = mysql_query($sql,$db_link);
				if($result1 && mysql_num_rows($result1)>0)
				{
					$product_name = mysql_result($result1,0,"name");
				}
				
				$sql = "SELECT * FROM fikcdn_client WHERE username='$this_username'";
				$result1 = mysql_query($sql,$db_link);
				if($result1 && mysql_num_rows($result1)>0)
				{
					$company_name = mysql_result($result1,0,"company_name");
					$realname = mysql_result($result1,0,"realname");
				}
				
				$timenow = time();
				
				if($timeval==7)
				{
					$timeval = $timenow-24*60*60*7;
				}
				else if($timeval==30)
				{
					$timeval = $timenow-24*60*60*30;
				}
				else if($timeval==90)
				{
					$timeval = $timenow-24*60*60*90;
				}	
				
				//查找此域名的流量统计
				$sql = "SELECT * FROM domain_stat_product_day WHERE buy_id=$this_buy_id AND time>$timeval ORDER BY time ASC";
				$result2 = mysql_query($sql,$db_link);
				if(!$result2)
				{
					exit();
				}			
				
				$aryData=array();
				$row_count2 = mysql_num_rows($result2);	
				for($k=0;$k<$row_count2;$k++)
				{
					$stat_time = mysql_result($result2,$k,"time");
					$RequestCount = mysql_result($result2,$k,"RequestCount");					
					
					$aryData[$k][0] = $stat_time;
					$aryData[$k][1] = $RequestCount;				
				}
				
				$label_name =$product_name.'('.$this_username.')';
				$aryAllData[0]["name"]="日请求数量";
				$aryAllData[0]["data"]=$aryData;	
			}
			echo  json_encode($aryAllData);
			mysql_close($db_link);
		}		
	}	
	else if($sAction=="bandwidth")
	{
		$buy_id 	= isset($_GET['buy_id'])?$_GET['buy_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$sql = "SELECT * FROM fikcdn_buy WHERE id=$buy_id AND username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if($result && mysql_num_rows($result)>0)
			{		
				$aryAllData = array();		
				$this_buy_id	 = mysql_result($result,0,"id");
				$this_username = mysql_result($result,0,"username");
				$this_product_id = mysql_result($result,0,"product_id");
				
				$sql = "SELECT * FROM fikcdn_product WHERE id=$this_product_id";
				$result1 = mysql_query($sql,$db_link);
				if($result1 && mysql_num_rows($result1)>0)
				{
					$product_name = mysql_result($result1,0,"name");
				}
				
				$timenow=time();
				$nDay1 = date("d")-$timeval;
				
				$timeval1 = mktime(0,0,0,date("m"),$nDay1,date("Y"));
				$timeval2 = $timeval1+24*60*60;
				
				$sql = "SELECT * FROM domain_stat_product_bandwidth WHERE buy_id=$this_buy_id AND time>=$timeval1 AND time<$timeval2 ORDER BY time ASC";			
				//查找此域名的流量统计
				$result2 = mysql_query($sql,$db_link);
				if(!$result2)
				{
					continue;
				}			
				
				$aryDataDown=array();
				$aryDataUp=array();
				
				$row_count2 = mysql_num_rows($result2);	
				for($k=0;$k<$row_count2;$k++)
				{
					$stat_time = mysql_result($result2,$k,"time");
					$bandwidth_down = mysql_result($result2,$k,"bandwidth_down");	
					$bandwidth_up = mysql_result($result2,$k,"bandwidth_up");						
					
					$aryDataDown[$k][0] = $stat_time;
					$aryDataDown[$k][1] = $bandwidth_down;	
					
					$aryDataUp[$k][0] = $stat_time;
					$aryDataUp[$k][1] = $bandwidth_up;			
				}
				
				$aryAllData[0]["name"]="用户下载带宽";
				$aryAllData[0]["data"]=$aryDataDown;
				
				$aryAllData[1]["name"]="用户上传带宽";
				$aryAllData[1]["data"]=$aryDataUp;
			}
			echo  json_encode($aryAllData);
			mysql_close($db_link);
		}		
	}
	else if($sAction=="MaxBandwidth")
	{		
		$buy_id 	= isset($_GET['buy_id'])?$_GET['buy_id']:'';
		$timeval 	= isset($_GET['timeval'])?$_GET['timeval']:'';
		
		$db_link = FikCDNDB_Connect();
		if($db_link)
		{			
			$sql = "SELECT * FROM fikcdn_buy WHERE id=$buy_id AND username='$client_username'";
			$result = mysql_query($sql,$db_link);
			if($result && mysql_num_rows($result)>0)
			{		
				$aryAllData = array();		
				$this_buy_id	 = mysql_result($result,0,"id");
				$this_username = mysql_result($result,0,"username");
				$this_product_id = mysql_result($result,0,"product_id");
				
				$sql = "SELECT * FROM fikcdn_product WHERE id=$this_product_id";
				$result1 = mysql_query($sql,$db_link);
				if($result1 && mysql_num_rows($result1)>0)
				{
					$product_name = mysql_result($result1,0,"name");
				}
				
				$timenow=time();
				
				if($timeval==60)
				{
					$timeval1 = mktime(0,59,59,date("m"),1,date("Y"));
					$timeval2 = mktime(0,0,0,date("m")-1,1,date("Y"));
					$sql = "SELECT * FROM domain_stat_product_max_bandwidth WHERE buy_id=$this_buy_id AND time>=$timeval2 AND time<$timeval1 ORDER BY time ASC";
				}				
				else if($timeval==30)
				{
					$timeval1 = mktime(0,0,0,date("m"),1,date("Y"));
					$sql = "SELECT * FROM domain_stat_product_max_bandwidth WHERE buy_id=$this_buy_id AND time>=$timeval1 ORDER BY time ASC";
				}
				else
				{
					if($timeval==1)
					{
						$timeval = $timenow-24*60*60;
					}
					else if($timeval==7)
					{
						$timeval = $timenow-24*60*60*7;
					}
					else if($timeval==30)
					{
						$timeval = $timenow-24*60*60*30;
					}
				
					//查找此域名的流量统计
					$sql = "SELECT * FROM domain_stat_product_max_bandwidth WHERE buy_id=$this_buy_id AND time>=$timeval ORDER BY time ASC";
				}
								
				
				//查找此域名的流量统计
				$result2 = mysql_query($sql,$db_link);
				if(!$result2)
				{
					continue;
				}			
				
				$aryDataDown=array();
				$aryDataUp=array();
				
				$row_count2 = mysql_num_rows($result2);	
				for($k=0;$k<$row_count2;$k++)
				{
					$stat_time = mysql_result($result2,$k,"time");
					$bandwidth_down = mysql_result($result2,$k,"bandwidth_down");	
					$bandwidth_up = mysql_result($result2,$k,"bandwidth_up");						
					
					$aryDataDown[$k][0] = $stat_time;
					$aryDataDown[$k][1] = $bandwidth_down;	
					
					$aryDataUp[$k][0] = $stat_time;
					$aryDataUp[$k][1] = $bandwidth_up;			
				}
				
				$aryAllData[0]["name"]="用户下载峰值带宽";
				$aryAllData[0]["data"]=$aryDataDown;
				
				$aryAllData[1]["name"]="用户上传峰值带宽";
				$aryAllData[1]["data"]=$aryDataUp;
			}
			echo  json_encode($aryAllData);
			mysql_close($db_link);
		}		
	}			
}
?>
