<?php	

include_once('define.php');
include_once('../db/db.php');
include_once('pub_function.php');

// 定义
$FikCacheError_ServerBusy					=10;	//Fikker 服务器忙;
$FikCacheError_NoSupport					=11;	//没有找到对应项或此功能暂未实现, 请检查 Fikker 版本;
$FikCacheError_TryOverdue					=12;	//试用期已过
$FikCacheError_PasswordError				=20;	//用户名或密码错误			
$FikCacheError_SessionHasOverdue			=21;	//用户会话闲置时间太久, 已超时, 需重新登录;
$FikCacheError_KeeperNoPower				=22;	//监控员没有对系统进行修改的权限;
$FikCacheError_PostFieldError				=23;	//提交表单(字段)格式有误, 请检查表单(字段)名称, 大小和长度;
$FikCacheError_AddUrlExistOrSyntaxError		=30;	//缓存管理, 要添加的 URL 已经存在或 URL 正则表达式语法错;
$FikCacheError_ModifyUrlError				=31;	//缓存管理, 要修改的 URL 已经不存在或 URL 正则表达式语法错;
$FikCacheError_DelSyntaxError				=32;	//清理缓存, 要清理的 URL 正则表达式语法错;
$FikCacheError_AddBlackConflict				=40; 	//黑名单管理, 要添加的黑名单已经存在或与已有黑名单有冲突;
$FikCacheError_ModifyBlackConflict			=41;	//黑名单管理, 要修改的黑名单已经不存在或与已有黑名单有冲突;
$FikCacheError_AddProxyHostHasExist			=50;	//主机管理, 要添加的代理主机已经存在;
$FikCacheError_ModifyProxyHostError			=51;	//主机管理, 要修改的代理主机已经不存在或与已有主机名有冲突;
$FikCacheError_AddUpStreamHostHasExist		=52;	//主机管理, 要添加的源站已经存在;
$FikCacheError_ModifyUpStreamHostError		=53;	//主机管理, 要修改的源站已经不存在或与已有源站名有冲突;
$FikCacheError_SSLCrtError					=54;	//主机管理, 要修改的源站已经不存在或与已有源站名有冲
$FikCacheError_SSLKeyError					=55;	//主机管理, 要修改的源站已经不存在或与已有源站名有冲
$FikCacheError_CrtAndKeyNotMatch			=56;	//主机管理, 要修改的源站已经不存在或与已有源站名有冲

$FikCacheError_AddRewriteUrlError			=60;	//转向管理, 要添加的转向 URL 已经存在或 URL 正则表达式语法错;
$FikCacheError_ModifyRewriteUrlError		=61;	//转向管理, 要修改的转向 URL 已经不存在或 URL 正则表达式语法错;
$FikCacheError_AddProtectUrlError			=70;	//防盗链管理, 要添加的保护链 URL 已经存在或 URL 正则表达式语法错;
$FikCacheError_ModifyProtectUrlError		=71;	//防盗链管理, 要修改的保护链 URL 已经不存在或 URL 正则表达式语法错;
$FikCacheError_AddPermitUrlError			=72;	//引用链管理, 要添加的引用链 URL 已经存在或 URL 正则表达式语法错;
$FikCacheError_ModifyPermitUrlError			=73;	//引用链管理, 要修改的引用链 URL 已经不存在或 URL 正则表达式语法错;
$FikCacheError_AddStatUrlError				=80;	//分量统计管理, 要添加的引用链 URL 已经存在或 URL 正则表达式语法错误;
$FikCacheError_ModifyStatUrlError			=81;	//分量统计管理, 要修改的引用链 URL 已经不存在或 URL 正则表达式语法错;
$FikCacheError_RealtimeStatConfigIsNotExist	=90;	//实时监控, 要监控的分量统计配置已不存在;
$FikCacheError_RealtimeStatConfigIsNotExist =100;  	//集群主服务器配置错误, 与已使用的端口存在冲突;

// 超时周期的单位
$FikFCache_ExpireUnit[0] = '天';
$FikFCache_ExpireUnit[1] = '小时';
$FikFCache_ExpireUnit[2] = '分钟';
$FikFCache_ExpireUnit[3] = '秒';

$FikFCache_Icase[0]= "不忽略";
$FikFCache_Icase[1]= "忽略";

$FikFCache_Icookie[0]= "不忽略";
$FikFCache_Icookie[1]= "忽略";

$FikFCache_Olimit[0] = "缓存到公共缓存";
$FikFCache_Olimit[1] = "缓存到会员缓存";
$FikFCache_Olimit[2] = "缓存到游客缓存";

$FikFCache_Rules[0] = "通配符";
$FikFCache_Rules[1] = "正则表达式";
$FikFCache_Rules[2] = "精确匹配";

$FikFCache_IsDiskCache[0]= "不允许";
$FikFCache_IsDiskCache[1]= "允许";

$FikRCache_Olimit[0] = "拒绝公共缓存";
$FikRCache_Olimit[1] = "拒绝会员缓存";
$FikRCache_Olimit[2] = "拒绝游客缓存";

$FikRCache_CacheLocation[0] = "拒绝双缓存";
$FikRCache_CacheLocation[1] = "只拒绝硬盘缓存";

$FikRewrite_Flag[0] = "Last";
$FikRewrite_Flag[1] = "Return";
$FikRewrite_Flag[2] = "Round";
$FikRewrite_Flag[3] = "Continue";


function FikApi_Login($ip,$port,$passwd)
{	
	global $FikConfig_KeeperLogin; 	

	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=sign&cmd=in";
	
	if($FikConfig_KeeperLogin)
	{
		$postAry["Username"] = "keeper";
	}
	else
	{
		$postAry["Username"] = "admin";
	}
	$postAry["Password"] = $passwd;
	
	$aryOptions = array();
	 
	$result=PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
	return	$result;
}

function FikApi_KeeperLogin($ip,$port,$passwd)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=sign&cmd=in";
	
	$postAry["Username"] = "keeper";
	$postAry["Password"] = $passwd;
	
	$aryOptions = array();
	 
	$result=PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
	return	$result;
}

function FikApi_GetAuth($ip,$port,$sessionid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=auth&cmd=status";
	
	$postAry["SessionID"] = $sessionid;
	
	$aryOptions = array();
	 
	$result = 
	PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
			
	return	$result;
}

function FikApi_ListFCache($ip,$port,$sessionid)
{	
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=fcache&cmd=list";
	
	$postAry["SessionID"] = urlencode($sessionid);
	
	$aryOptions = array();
	 
	$result = 
	PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
	$ary = json_decode($result,true); 
		
	return	$ary;	
}

function FikApi_CleanCache($ip,$port,$sessionid,$clear_url)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=thiscache&cmd=cleancache";
	
	$postAry["Url"] = $clear_url;
	$postAry["WithCluster"] = 0;
	$postAry["Icase"] = 0;
	$postAry["Rules"] = 2;
	$postAry["SessionID"] = urlencode($sessionid);
	$aryOptions = array();
	
	//print_r($postAry);
	
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_CleanCacheDir($ip,$port,$sessionid,$clear_url)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=thiscache&cmd=cleancache";
	
	$postAry["Url"] = $clear_url;
	$postAry["WithCluster"] = 0;
	$postAry["Icase"] = 1;
	$postAry["Rules"] = 0;
	$postAry["SessionID"] = urlencode($sessionid);
	$aryOptions = array();
	
	//print_r($postAry);
	
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
	$ary = json_decode($result,true);
	return	$ary;	
}

function FikApi_Relogin($nid,$ip,$port,$passwd,$dblink)
{
	$strResult = FikApi_Login($ip,$port,$passwd);
	$aryResult = json_decode($strResult,true); 
	
	$aryReturn = array();
	
	if (!is_array($aryResult))
	{
		$sql = "UPDATE fikcdn_node SET status=2 WHERE id='$nid'";
		$result = mysql_query($sql,$dblink);
		$aryReturn["Return"]="False";
		$aryReturn["ErrorNo"]=-1;
		return $aryReturn;
	}
	
	if($aryResult["Return"]=="False")
	{		
		$FikErrorNo = $aryResult["ErrorNo"];
		if($aryResult["ErrorNo"] == $FikCacheError_PasswordError)
		{
			$sql = "UPDATE fikcdn_node SET status=3 WHERE id='$nid'";
			$result = mysql_query($sql,$dblink);
			//$aryResult = array('Return'=>'false','ErrorNo'=>$FikCacheError_PasswordError);
			//PubFunc_EchoJsonAndExit($aryResult,$db_link);
		}		
		
		$aryReturn["Return"]="False";
		$aryReturn["ErrorNo"]=-2;
		$aryReturn["FikErrorNo"]=$FikErrorNo;
		return $aryReturn;
	}
	
	$fik_version 		= $aryResult["Version"];
	$fik_VersionExt 	= $aryResult["VersionExt"];
	$fik_session 		= $aryResult["SessionID"];
	$fik_LastLoginTime 	= $aryResult["LastLoginTime"];
	
	$sql = "UPDATE fikcdn_node SET status=1,fik_version='$fik_version',SessionID='$fik_session',fik_LastLoginTime='$fik_LastLoginTime',version_ext='$fik_VersionExt' WHERE id='$nid'";	
	$result = mysql_query($sql,$dblink);
	
	//print_r($aryResult);
	$aryReturn["Return"]="True";
	$aryReturn["SessionID"]=$fik_session;
	return $aryReturn;
}

function fikapi_realtimelist($ip,$port,$sessionid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=realtime&cmd=list";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$aryOptions = array();
	 
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
	$ary = json_decode($result,true); 
		
	return	$ary;	
}

function fikapi_realtimetotalstat($ip,$port,$sessionid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=realtime&cmd=totalstat";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$aryOptions = array();
	 
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
			
	$ary = json_decode($result,true); 
		
	return	$ary;		
}

function FikApi_ProxyList($ip,$port,$sessionid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=proxy&cmd=list";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$aryOptions = array();
	 
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
	
	//var_dump($result);
			
	$ary = json_decode($result,true); 
		
	return	$ary;		
}

function FikApi_ProxyQueryDomain($ip,$port,$sessionid,$sDomain)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=proxy&cmd=list";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["IncludeCrt"] = 0;
	$postAry["IncludeStat"] = 0;
	$aryOptions = array();
	$aryReturn = array();

	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		$aryReturn["Return"]="False";
		$aryReturn["ErrorNo"]=-1;
		return $aryReturn;
	}
	
	//var_dump($result);
	
	$aryFikResult = json_decode($result,true); 
	if($aryFikResult["Return"]=="True")
	{
		//print_r($aryFikResult);
		
		$nNumOfLists = $aryFikResult["NumOfLists"];
		for($k=0;$k<$nNumOfLists;$k++)
		{
			$nNo = $aryFikResult["Lists"][$k]["NO"];
			$nProxyID = $aryFikResult["Lists"][$k]["ProxyID"];
			$sHost = $aryFikResult["Lists"][$k]["Host"];
			$nBalance = $aryFikResult["Lists"][$k]["Balance"];
			$bEnable = $aryFikResult["Lists"][$k]["Enable"];
			$StartTime = $aryFikResult["Lists"][$k]["StartTime"];
			$EndTime = $aryFikResult["Lists"][$k]["EndTime"];
			$RequestCount = $aryFikResult["Lists"][$k]["RequestCount"];
			$UploadCount = $aryFikResult["Lists"][$k]["UploadCount"];
			$DownloadCount = $aryFikResult["Lists"][$k]["DownloadCount"];
			$IpCount = $aryFikResult["Lists"][$k]["IpCount"];
			$sNote = $aryFikResult["Lists"][$k]["Note"];
			
			if(strlen($bEnable)<=0) $bEnable=1;																												
			if($sHost==$sDomain)
			{		
				$aryReturn["Return"]="True";		
				$aryReturn["ProxyID"]=$nProxyID;
				return $aryReturn;									
			}
		}
		
		$aryReturn["Return"]="False";
		$aryReturn["ErrorNo"]=-3;		
		return $aryReturn;
	}		
	
	if($aryFikResult["Return"]=="False")
	{
		$aryReturn["Return"]="False";	
		$aryReturn["ErrorNo"]=-2;	
		$aryReturn["FikErrorNo"]=$aryFikResult["ErrorNo"];
		return $aryReturn;					
	}
	
	$aryReturn["Return"]="False";
	$aryReturn["ErrorNo"]=-1;
	return $aryReturn;	
}

function FikApi_ProxyAdd($ip,$port,$sessionid,$sHost,$sNode)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=proxy&cmd=add";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Host"] = $sHost;
	$postAry["Balance"] = 1;
	$postAry["Note"] = $sNode;
	$aryOptions = array();
	 
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
			
	$ary = json_decode($result,true); 
	
	//print_r($ary);

	return	$ary;		
}

function FikApi_ProxyQuery($ip,$port,$sessionid,$nProxyID)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=proxy&cmd=query";
	
	$postAry["SessionID"] = $sessionid;
	$postAry["ProxyID"] = $nProxyID;
	$postAry["IncludeCrt"] = 0;
	$postAry["IncludeStat"] = 0;
	$aryOptions = array();
	 
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
			
	$ary = json_decode($result,true); 
	return	$ary;	
}

function FikApi_ProxyDel($ip,$port,$sessionid,$nProxyID)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=proxy&cmd=del";
	
	$postAry["SessionID"] = $sessionid;
	$postAry["ProxyID"] = $nProxyID;
	$aryOptions = array();
	 
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
			
	$ary = json_decode($result,true); 
	return	$ary;	
}

function FikApi_UpstreamList($ip,$port,$sessionid,$nProxyID)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=upstream&cmd=list";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["ProxyID"] = $nProxyID;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_UpstreamAdd($ip,$port,$sessionid,$nProxyID,$Host,$Node,$UpsSSLOpt)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=upstream&cmd=add";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["ProxyID"] = $nProxyID;
	$postAry["SSLOpt"] = $UpsSSLOpt;
	$postAry["Host"] = $Host;
	$postAry["Node"] = $Node;
	$aryOptions = array();
	 
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
	$ary = json_decode($result,true); 	
	
	//print_r($ary);

	return	$ary;		
}

function FikApi_UpstreamModify($ip,$port,$sessionid,$nProxyID,$nUpstreamID,$Host,$Node)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=upstream&cmd=modify";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["UpstreamID"] = $nUpstreamID;
	$postAry["ProxyID"] = $nProxyID;
	$postAry["Host"] = $Host;
	$postAry["Node"] = $Node;
	$aryOptions = array();
	 
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
	$ary = json_decode($result,true); 	

	return	$ary;		
}



function FikApi_UpstreamDel($ip,$port,$sessionid,$nProxyID,$nUpstreamID)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=upstream&cmd=del";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["ProxyID"] = $nProxyID;
	$postAry["UpstreamID"] = $nUpstreamID;
	$aryOptions = array();
	
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
			
	$ary = json_decode($result,true); 

	return	$ary;		
}

//启用/暂停代理主机:
function FikApi_ProxyEnable($ip,$port,$sessionid,$nProxyID,$bEnable)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=proxy&cmd=enable";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["ProxyID"] = $nProxyID;
	$postAry["Enable"] = $bEnable;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

//启用/暂停代理主机:
function FikApi_ProxyClean($ip,$port,$sessionid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=proxy&cmd=clean";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

//获取强制缓存列表
function FikApi_FCacheList($ip,$port,$sessionid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=fcache&cmd=list";
	echo $url;
	$postAry["SessionID"] = urlencode($sessionid);
	$aryOptions = array();
			
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_FCacheQuery($ip,$port,$sessionid,$Wid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=fcache&cmd=query";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Wid"] = $Wid;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_FCacheAdd($ip,$port,$sessionid,$Url,$Icase,$Rules,$Expire,$Unit,$Icookie,$Olimit,$IsDiskCache,$Note)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=fcache&cmd=add";
	echo 'url='.$url.'<br />';
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Url"] = $Url;
	$postAry["Icase"] = $Icase;	
	$postAry["Rules"] = $Rules;	
	$postAry["Expire"] = $Expire;	
	$postAry["Unit"] = $Unit;	
	$postAry["Icookie"] = $Icookie;					
	$postAry["Olimit"] = $Olimit;					
	$postAry["IsDiskCache"] = $IsDiskCache;						
	$postAry["Note"] = $Note;			
	$aryOptions = array();
	
	print_r($postAry);
			
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_FCacheModify($ip,$port,$sessionid,$Wid,$Url,$Icase,$Rules,$Expire,$Unit,$Icookie,$Olimit,$IsDiskCache,$Note)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=fcache&cmd=modify";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Wid"] = $Wid;
	$postAry["Url"] = $Url;
	$postAry["Icase"] = $Icase;	
	$postAry["Rules"] = $Rules;	
	$postAry["Expire"] = $Expire;	
	$postAry["Unit"] = $Unit;	
	$postAry["Icookie"] = $Icookie;					
	$postAry["Olimit"] = $Olimit;					
	$postAry["IsDiskCache"] = $IsDiskCache;						
	$postAry["Note"] = $Note;			
	$aryOptions = array();
	print_r($postAry);
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_FCacheDel($ip,$port,$sessionid,$Wid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=fcache&cmd=del";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Wid"] = $Wid;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_FCacheUp($ip,$port,$sessionid,$Wid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=fcache&cmd=up";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Wid"] = $Wid;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_FCacheDown($ip,$port,$sessionid,$Wid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=fcache&cmd=down";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Wid"] = $Wid;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

//获取拒绝缓存列表
function FikApi_RCacheList($ip,$port,$sessionid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rcache&cmd=list";

	$postAry["SessionID"] = urlencode($sessionid);
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_RCacheQuery($ip,$port,$sessionid,$Wid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rcache&cmd=query";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Wid"] = $Wid;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_RCacheDel($ip,$port,$sessionid,$Wid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rcache&cmd=del";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Wid"] = $Wid;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_RCacheUp($ip,$port,$sessionid,$Wid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rcache&cmd=up";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Wid"] = $Wid;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_RCacheDown($ip,$port,$sessionid,$Wid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rcache&cmd=down";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Wid"] = $Wid;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_RCacheAdd($ip,$port,$sessionid,$Url,$Icase,$Rules,$Olimit,$CacheLocation,$Note)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rcache&cmd=add";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Url"] = $Url;
	$postAry["Icase"] = $Icase;	
	$postAry["Rules"] = $Rules;				
	$postAry["Olimit"] = $Olimit;					
	$postAry["CacheLocation"] = $CacheLocation;						
	$postAry["Note"] = $Note;			
	$aryOptions = array();
			
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_RCacheModify($ip,$port,$sessionid,$Wid,$Url,$Icase,$Rules,$Olimit,$CacheLocation,$Note)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rcache&cmd=modify";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Wid"] = $Wid;
	$postAry["Url"] = $Url;
	$postAry["Icase"] = $Icase;	
	$postAry["Rules"] = $Rules;		
	$postAry["Olimit"] = $Olimit;								
	$postAry["CacheLocation"] = $CacheLocation;						
	$postAry["Note"] = $Note;			
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

//获取转向管理列表
function FikApi_RewriteList($ip,$port,$sessionid)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rewrite&cmd=list";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_RewriteQuery($ip,$port,$sessionid,$RewriteID)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rewrite&cmd=query";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["RewriteID"] = $RewriteID;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_RewriteDel($ip,$port,$sessionid,$RewriteID)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rewrite&cmd=del";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["RewriteID"] = $RewriteID;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_RewriteUp($ip,$port,$sessionid,$RewriteID)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rewrite&cmd=up";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["RewriteID"] = $RewriteID;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_RewriteDown($ip,$port,$sessionid,$RewriteID)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rewrite&cmd=down";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["RewriteID"] = $RewriteID;
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_RewriteAdd($ip,$port,$sessionid,$SourceUrl,$DestinationUrl,$Icase,$Flag,$Note)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rewrite&cmd=add";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["SourceUrl"] = $SourceUrl;
	$postAry["DestinationUrl"] = $DestinationUrl;	
	$postAry["Icase"] = $Icase;	
	$postAry["Flag"] = $Flag;	
	$postAry["Note"] = $Note;			
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_RewriteModify($ip,$port,$sessionid,$RewriteID,$SourceUrl,$DestinationUrl,$Icase,$Flag,$Note)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=rewrite&cmd=modify";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["RewriteID"] = $RewriteID;
	$postAry["SourceUrl"] = $SourceUrl;
	$postAry["DestinationUrl"] = $DestinationUrl;	
	$postAry["Icase"] = $Icase;	
	$postAry["Flag"] = $Flag;	
	$postAry["Note"] = $Note;			
	$aryOptions = array();
		
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result){
		return false;
	}
			
	$ary = json_decode($result,true); 	
	return	$ary;	
}

function FikApi_SSLProxyAdd($ip,$port,$sessionid,$sHost,$this_status,$sNode,$SSLOpt,$SSLCrtContent,$SSLKeyContent,$SSLExtraParams)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=proxy&cmd=add";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["Host"] = $sHost;
	$postAry["Balance"] = 1;
	$postAry["Enable"] 	= $this_status;
	$postAry["Note"] = htmlspecialchars_decode($sNode);
	$postAry["SSLOpt"] = htmlspecialchars_decode($SSLOpt);
	$postAry["SSLCrtContent"] = htmlspecialchars_decode($SSLCrtContent);
	$postAry["SSLKeyContent"] = htmlspecialchars_decode($SSLKeyContent);
	$postAry["SSLExtraParams"] = htmlspecialchars_decode($SSLExtraParams);
	$aryOptions = array();
	
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
	
	$ary = json_decode($result,true);
	
	//print_r($ary);

	return	$ary;
}

function FikApi_SSLProxyModify($ip,$port,$sessionid,$nProxy,$sHost,$this_status,$sNode,$SSLOpt,$SSLCrtContent,$SSLKeyContent,$SSLExtraParams)
{
	$url ="http://".$ip.":".$port."/fikker/webcache.fik?type=proxy&cmd=modify";
	
	$postAry["SessionID"] = urlencode($sessionid);
	$postAry["ProxyID"] = $nProxy;
	$postAry["Balance"] = 1;
	$postAry["Host"] 	= $sHost;
	$postAry["Note"] 	= htmlspecialchars_decode($sNode);
	$postAry["Enable"] 	= $this_status;
	$postAry["SSLOpt"] 	= $SSLOpt;
	$postAry["SSLCrtContent"] = htmlspecialchars_decode($SSLCrtContent);
	$postAry["SSLKeyContent"] = htmlspecialchars_decode($SSLKeyContent);
	$postAry["SSLExtraParams"] = htmlspecialchars_decode($SSLExtraParams);
	$aryOptions = array();
	 
	$result = PubFunc_CurlPost($url,$postAry,$aryOptions);
	if(!$result)
	{
		return false;
	}
			
	$ary = json_decode($result,true); 
	
	//print_r($ary);

	return	$ary;		
}

?>	