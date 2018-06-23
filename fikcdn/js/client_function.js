var BT="";
var BL="";
//登录结果返回函数
function FikCdn_ClientLoginResult(sResponse,returnOBJId)
{
	var needRe;
	var returnOBJ;
	
	returnOBJ=document.getElementById("tipsLoginResult"); 
	needRe = 1;

	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){		
		var username = json["username"];	
		var auth_random = json["auth_random"];	
	
		addCookie("fikcdn_client_username",username,36000000);
		addCookie("fikcdn_client_auth",auth_random,0);
		
		window.location.href = "./main.php"; 
	}	
	else{
		var nErrorNo = json["ErrorNo"];	
		if(nErrorNo==20000){
			if(needRe)	returnOBJ.innerHTML = "登录失败，参数错误。";
		}
		else if(nErrorNo==20010){
			if(needRe)	returnOBJ.innerHTML = "登录失败，连接数据库错误。";
		}
		else if(nErrorNo==20011 ){
			if(needRe){	returnOBJ.innerHTML = "登录失败，用户名不存在或密码错误。"; document.getElementById("txtUsername").focus(); }
		}
		else if(nErrorNo==30004 ){
			if(needRe){	returnOBJ.innerHTML = "登录失败，验证码错误。"; document.getElementById("txtCheckCode").focus(); }
		}		
		else if(nErrorNo==30001){
			if(needRe)	returnOBJ.innerHTML = "登录失败，此用户已被冻结，请联系系统管理员。";
		}
	}
}

function FikCdn_ClientLogoutResult(sResponse)
{
	delCookie("fikcdn_client_auth");
	parent.location.href = "./login.php"; 
}

function FikCdn_ClientStartDomainResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){
		alert("开启域名加速成功。");
		location.reload();
	}	
	else{
		var nErrorNo = json["ErrorNo"];
		var strErr = json["ErrorMsg"];	
	
		if(nErrorNo==30003){
			parent.location.href = "./login.php"; 
		}
		else
		{
			alert(strErr);
		}
	}		
}

function FikCdn_ClientStopDomainResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){
		alert("暂停域名加速成功。");
		location.reload();
	}	
	else{
		var nErrorNo = json["ErrorNo"];
		var strErr = json["ErrorMsg"];	
	
		if(nErrorNo==30003){
			parent.location.href = "./login.php"; 
		}
		else
		{
			alert(strErr);
		}
	}		
}