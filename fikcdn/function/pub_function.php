<?php	

// POST数据
function PubFunc_HttpPost($url, $post = NULL)
{
	 $context = array();
	 if (is_array($post))
	 {
		 $post = json_encode($post);
		 $context['http'] = array
		 (   
			 'timeout' => 60,
			 'method'  => 'POST',
			 'content' => $post,
		 );
	 }
	 else
	 {
		 $context['http'] = array
		 (   
			 'timeout' =>60,
			 'method'  => 'POST',
			 //'header' => 'Content-Type: text/html; charset=gb2312',
			 'content' => http_build_query(array(''=>''), '', '&'),
		 );
	 }
	 return file_get_contents($url, false, stream_context_create($context)); 
}

/**
 * Send a POST requst using cURL
 * @param string $url to request
 * @param array $post values to send
 * @param array $options for cURL
 * @return string
 */
function PubFunc_CurlPost($url, array $post = NULL, array $options = array())
{
    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_POSTFIELDS => http_build_query($post)
    );
	
    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
	
	$connection[0] = "Connection: close"; 
	curl_setopt($ch, CURLOPT_HTTPHEADER, $connection);
	
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0');
    
    if( ! $result = curl_exec($ch))
    {
        //trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}


/**
 * Send a GET requst using cURL
 * @param string $url to request
 * @param array $get values to send
 * @param array $options for cURL
 * @return string
 */
function PubFunc_CurlGet($url, array $get = NULL, array $options = array())
{   
    $defaults = array(
        CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get),
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => TRUE
    );
   
    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
	
	$connection[0] = "Connection: close"; 
	curl_setopt($ch, CURLOPT_HTTPHEADER, $connection);
	
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0');
    
    if( ! $result = curl_exec($ch))
    {
        //trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
} 


function PubFunc_CreateRandStr($randlen)
{
	$table='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	$sRand='';
	for($i=0;$i<$randlen;$i++)
	{
		$ch=$table[rand(0,61)];
		$sRand.=$ch;
	}
	return $sRand;
}

function PubFunc_EchoAndExit($echo_value)
{
	echo $echo_value;
	exit();
}

function PubFunc_EchoJsonAndExit(array $aryResul,$dbLink)
{
	if($dbLink)
	{
		mysql_close($dbLink);
	}
	echo json_encode($aryResul);
	exit();
}

function PubFunc_GetRemortIP()
{
    if (!isset($_SERVER["HTTP_X_FORWARDED_FOR"])) /* 存在 X-Forwarded-For 吗? */ 
    {
        return $_SERVER["REMOTE_ADDR"];
    }
    
    return $_SERVER["HTTP_X_FORWARDED_FOR"]; /* 返回用户 IP */ 
}

function PubFunc_KBToString($nKB)
{
	if($nKB<0)
	{
		$nKB = 0;
	}

	if($nKB<1024)
	{
		$sReturn=$nKB."KB";
		return $sReturn;
	}

	$value =round($nKB / (1024),2);
	if($value<1024)
	{
		$sReturn=$value." MB";
		return $sReturn;
	}

	return PubFunc_MBToString($value);
}

function PubFunc_MBToString($nMB)
{
	if($nMB<0)
	{
		$nMB = 0;
	}

	if($nMB<1024)
	{
		$nMB = round($nMB,2);
		$sReturn=$nMB." MB";
		return $sReturn;
	}

	$value =round($nMB / (1024),2);
	if($value<1024)
	{
		$sReturn=$value." GB";
		return $sReturn;
	}
	
	$value =round($nMB / (1024*1024),2);
	if($value<1024)
	{
		$sReturn=$value." TB";
		return $sReturn;
	}

	$sReturn=$value." TB";
	return $sReturn;
}

function PubFunc_ByteToString($nBytes)
{
	if($nBytes<0)
	{
		$nBytes = 0;
	}

	if($nBytes<1024)
	{
		$sReturn=$nBytes."Byte";
		return $sReturn;
	}

	$value =round($nBytes / (1024),2);
	if($value<1024)
	{
		$sReturn=$value."KB";
		return $sReturn;
	}

	return PubFunc_KBToString($value);
}

function PubFunc_GBToString($nGB)
{
	if($nGB<0)
	{
		$nGB = 0;
	}

	if($nGB<1024)
	{
		$sReturn=$nGB." GB";
		return $sReturn;
	}

	$value =round($nGB / (1024),2);

	$sReturn=$value." TB";
	return $sReturn;
}

function PubFunc_GetUrlDomain($url)
{
 	//preg_match("/[^\.\/]+\.[^\.\/]+$/", $url, $matches);
	preg_match("/^(http:\/\/)?([^\/]+)/i", $url, $matches);

	//print_r($matches);
	return $matches[2];
}

function PubFunc_IsDigit($str)
{
	if(preg_match("/^[\d]{1,36}$/",$str)){
		return true;
	}else{
		return false;
	}
}

function PubFunc_CutHttp($url)
{
	if(substr($url,0,7)=="http://")
	{
		return substr($url,7);
	}
	else if(substr($url,0,6)=="http:/")
	{
		return substr($url,6);
	}	
	else if(substr($url,0,5)=="http:")
	{
		return substr($url,5);
	}	
	return $url;
}

function PubFunc_IsHomePage($url)
{
	$sUrl = PubFunc_CutHttp($url);
	
	$nPos = stripos($sUrl,"/");
	if($nPos==false)
	{
		return true;
	}
	
	return false;
	
}

?>	