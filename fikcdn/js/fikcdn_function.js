var BT="";
var BL="";

//登录结果返回函数
function FikCdn_AdminLoginResult(sResponse,returnOBJId)
{
	var needRe;
	var returnOBJ;
	
	returnOBJ=document.getElementById("tipsLoginResult"); 
	needRe = 1;

	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){		
		var username = json["username"];	
		var auth_random = json["auth_random"];	
	
		addCookie("fikcdn_admin_username",username,36000);
		addCookie("fikcdn_admin_auth",auth_random,0);
		
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

function FikCdn_AdminLogoutResult(sResponse)
{
	delCookie("fikcdn_admin_auth");
	parent.location.href = "./login.php"; 
}

function fikcdn_ModifyStatusGroupResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="true"){		
		var grpid = json["id"];
		var status = json["status"];
		var ObjName1 = "span_status_"+grpid;
		var ObjName2 = "span_href_status_"+grpid;
		if(status==1)
		{
			document.getElementById(ObjName1).innerHTML ='上线中';
			
			var str = '<a href="#" onclick="javescript:groupDown('+grpid+');" title="套餐下线">套餐下线</a>';
			document.getElementById(ObjName2).innerHTML =str;
		}
		else
		{
			document.getElementById(ObjName1).innerHTML ='已下线';
			
			var str = '<a href="#" onclick="javescript:groupUp('+grpid+');" title="套餐上线">套餐上线</a>';
			document.getElementById(ObjName2).innerHTML =str;
		}
	}	
	else{
		var nErrorNo = json["ErrorNo"];
		if(nErrorNo==30000){
			parent.location.href = "./login.php"; 
		}	
		else if(nErrorNo==20000){
			alert("修改套餐状态失败，参数错误。");	
		}	
		else if(nErrorNo==20010){
			alert("修改套餐状态失败，连接数据库错误。");	
		}	
		else if(nErrorNo==20016){
			alert("修改套餐状态失败，套餐不存在。");	
		}		
		else {
			var str = "修改套餐状态失败,错误号："+nErrorNo;
			alert(str);	
		}	 
	}		
}


function fikcdn_SearchUserResult(sResponse)
{
	document.getElementById("div_search_result").innerHTML = sResponse
}

function fikcdn_SearchNodeResult(sResponse)
{
	document.getElementById("div_search_result").innerHTML = sResponse
}

function fikcdn_SearchDomainResult(sResponse)
{
	document.getElementById("div_search_result").innerHTML = sResponse
}

function fikcdn_SearchRechargeResult(sResponse)
{
	document.getElementById("div_search_result").innerHTML = sResponse
}

function fikcdn_SearchBuyHistoryResult(sResponse)
{
	document.getElementById("div_search_result").innerHTML = sResponse	
}

function fikcdn_AddPullResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="true"){		
		alert("增加拉取任务成功。");	
		document.getElementById("txtUrl").value="";
	}	
	else{
		var nErrorNo = json["ErrorNo"];
		if(nErrorNo==30000){
			parent.location.href = "./login.php"; 
		}	
		else if(nErrorNo==20000){
			alert("增加拉取任务失败，参数错误。");	
		}	
		else if(nErrorNo==20010){
			alert("增加拉取任务失败，连接数据库错误。");	
		}	
		else if(nErrorNo==20014){
			alert("增加拉取任务失败，任务已经存在。");	
		}	
		else if(nErrorNo==20012){
			alert("增加拉取任务失败， 写入数据库错误。");	
		}	
		else if(nErrorNo==20016){
			alert("增加拉取任务失败， 用户不存在。");	
		}		
		else {
			var str = "增加拉取任务失败,错误号："+nErrorNo;
			alert(str);	
		}	 
	}			
}

function fikcdn_DelPullResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="true"){		
		 location.reload();
	}
	else{
		var nErrorNo = json["ErrorNo"];
		if(nErrorNo==30000){
			parent.location.href = "./login.php"; 
		}	
		else if(nErrorNo==20000){
			alert("删除拉取任务失败，参数错误。");	
		}	
		else if(nErrorNo==20010){
			alert("删除拉取任务失败，连接数据库错误。");	
		}	
		else if(nErrorNo==20016){
			alert("删除拉取任务失败，任务不存在。");	
		}		
		else {
			var str = "删除拉取任务失败,错误号："+nErrorNo;
			alert(str);	
		}	 
	}		
}

function fikcdn_ModifyStatusPullResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="true"){		
		location.reload();
	}
	else{
		var nErrorNo = json["ErrorNo"];
		if(nErrorNo==30000){
			parent.location.href = "./login.php"; 
		}	
		else if(nErrorNo==20000){
			alert("修改任务状态失败，参数错误。");	
		}	
		else if(nErrorNo==20010){
			alert("修改任务状态失败，连接数据库错误。");	
		}	
		else if(nErrorNo==20015){
			alert("修改任务状态失败，任务不存在。");	
		}		
		else {
			var str = "修改任务状态失败,错误号："+nErrorNo;
			alert(str);	
		}	 
	}	
}

function fikcdn_ModifyDomainStatusResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="true"){		
		var nDomainID = json["id"];
		var nNodeID = json["nodeid"];
		var nProxyID = json["ProxyID"];
		var nUpstreamID = json["UpstreamID"];
		
		var sOpt = "opt_"+nNodeID;
		document.getElementById(sOpt).style.display="none";
		
		var sNodeStatus = "add_status_"+nNodeID;
		document.getElementById(sNodeStatus).innerHTML = "修改成功";
	}	
	else{
		var nErrorNo = json["ErrorNo"];
		var nDomainID = json["id"];
		var nNodeID = json["nodeid"];
		
		var sOpt = "opt_"+nNodeID;
		document.getElementById(sOpt).style.display="block";
		
		var sNodeStatus = "add_status_"+nNodeID;
		
		if(nErrorNo==30000){
			parent.location.href = "./login.php"; 
		}	
		else if(nErrorNo==20000){
			document.getElementById(sNodeStatus).innerHTML = "修改失败，参数错误";
		}	
		else if(nErrorNo==20010){
			document.getElementById(sNodeStatus).innerHTML = "修改失败，连接数据库错误";
		}	
		else if(nErrorNo==40000){
			document.getElementById(sNodeStatus).innerHTML = "修改失败，连接节点错误";
		}	
		else if(nErrorNo==40001){
			var nFikErrorNo = json["FikErrorNo"];
			if(nFikErrorNo==20)
			{
				document.getElementById(sNodeStatus).innerHTML = "修改失败，登录密码错误。";
			}
			else
			{
				document.getElementById(sNodeStatus).innerHTML = "修改失败，Fikker 错误号:"+nFikErrorNo;
			}
		}	
		else if(nErrorNo==30002){
			document.getElementById(sNodeStatus).innerHTML = "修改失败，管理员密码错误";
		}	
		else if(nErrorNo==50000){
			document.getElementById(sNodeStatus).innerHTML = "修改失败，域名已过期";
		}	
		else if(nErrorNo==50002){
			document.getElementById(sNodeStatus).innerHTML = "修改失败，域名不存在";
		}		
		else {
			var str = "修改失败,错误号："+nErrorNo;
			document.getElementById(sNodeStatus).innerHTML = str;
		}		
	}	
}

function fikcdn_DelNodeDomainResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="true"){		
		var nDomainID = json["id"];
		var nNodeID = json["nodeid"];
		var nProxyID = json["ProxyID"];
		var nUpstreamID = json["UpstreamID"];
		
		var sOpt = "opt_"+nNodeID;
		document.getElementById(sOpt).style.display="none";
		
		var sNodeStatus = "add_status_"+nNodeID;
		document.getElementById(sNodeStatus).innerHTML = "删除域名成功";
	}	
	else{
		var nErrorNo = json["ErrorNo"];
		var nDomainID = json["id"];
		var nNodeID = json["nodeid"];
		
		var sOpt = "opt_"+nNodeID;
		document.getElementById(sOpt).style.display="block";
		
		var sNodeStatus = "add_status_"+nNodeID;
		
		if(nErrorNo==30000){
			parent.location.href = "./login.php"; 
		}
		else if(nErrorNo==20000){
			document.getElementById(sNodeStatus).innerHTML = "删除域名失败，参数错误";
		}	
		else if(nErrorNo==20010){
			document.getElementById(sNodeStatus).innerHTML = "删除域名失败，连接数据库错误";
		}	
		else if(nErrorNo==40000){
			document.getElementById(sNodeStatus).innerHTML = "删除域名失败，不能连接节点服务器";
		}	
		else if(nErrorNo==40001){
			var nFikErrorNo = json["FikErrorNo"];
			if(nFikErrorNo==20)
			{
				document.getElementById(sNodeStatus).innerHTML = "删除域名失败，登录密码错误。";
			}
			else
			{
				document.getElementById(sNodeStatus).innerHTML = "删除域名失败，Fikker 错误号:"+nFikErrorNo;
			}
		}	
		else if(nErrorNo==30002){
			document.getElementById(sNodeStatus).innerHTML = "删除域名失败，管理员密码错误";
		}
		else{
			var str = "修改失败,错误号："+nErrorNo;
			document.getElementById(sNodeStatus).innerHTML = str;
		}
	}
}







