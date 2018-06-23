

function AjaxBasePost(sRespCmd,sAction,AjaxMode,postURL,postStr,returnOBJId,returnOBJId2){
	var ajaxReq;
	var sResponse;
	var IfchkTimeOut=true;
	var needRe=0;
	var needRe2=0;
	var ifdebug=false;
	var returnOBJ;
	var returnOBJ2;
	
	if(typeof(returnOBJId) == "undefined"){
		needRe=0;
	}else{
		returnOBJ=document.getElementById(returnOBJId); 
		needRe=1;
	}
	
	if(typeof(returnOBJId2) == "undefined"){
		needRe2=0;
	}else{
		returnOBJ2=document.getElementById(returnOBJId2); 
		needRe2=1;
	}
	
	if (window.XMLHttpRequest){
	  	// code for IE7+, Firefox, Chrome, Opera, Safari
	  	ajaxReq=new XMLHttpRequest();
	}
	else{
	  	// code for IE6, IE5
	  	ajaxReq=new ActiveXObject("Microsoft.XMLHTTP");
	}
		
	function ontimeout(){ 
		if(IfchkTimeOut==true){
			ajaxReq.abort();
			if(needRe==1){
				var strurl;
				var index1 = postURL.indexOf('?');
				if(index1==-1){
					strurl=postURL + "?" + postStr;
				}
				else{
					strurl=postURL + "&" + postStr;
				}
				returnOBJ.innerHTML = "连接超时，<a href=" + strurl + " target=_blank>请点此查看</a>";
			}
		}
	}
	
	if(AjaxMode=="POST"){
		ajaxReq.open("POST",postURL,true);
		setTimeout(ontimeout,15000);
		ajaxReq.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
		ajaxReq.send(postStr);
	}else{
		var strurl;
		if(typeof(postStr) != "undefined" && postStr.length>0 ){
			var index1 = postURL.indexOf('?');
			if(index1==-1){
				strurl=postURL + "?" + postStr;
			}
			else{
				strurl=postURL + "&" + postStr;
			}
		}else{
			strurl=postURL;
		}
		
		setTimeout(ontimeout,15000);//判断连接超时
		ajaxReq.open("GET",strurl,true);
		ajaxReq.send(null);
	}	

	ajaxReq.onreadystatechange=function(){
	  	if ( (ajaxReq.readyState==4 && ajaxReq.status==200) || (ajaxReq.readyState==4 && ajaxReq.status==0)){
			IfchkTimeOut=false;
			sResponse = ajaxReq.responseText;
			if(sRespCmd=="login"){
				if(sAction=="logging"){						//登录验证
					FikCdn_AdminLoginResult(sResponse,returnOBJId);
				}
				else if(sAction=="logout"){
					FikCdn_AdminLogoutResult(sResponse);
				}
			}
			else if(sRespCmd=="fiknode"){
				if(sAction=="add"){
					FikCdn_AddNodeResult(sResponse);
				}		
				else if(sAction=="modify"){
					FikCdn_ModifyNodeResult(sResponse);
				}
				else if(sAction=="del"){
					FikCdn_DelNodeResult(sResponse);
				}		
				else if(sAction=="cleanhost"){
					FikCdn_CleanHostResult(sResponse);
				}			
				else if(sAction=="modifystatus"){
					FikCdn_ModifyStatusNodeResult(sResponse);
				}
				else if(sAction=="reconfighost"){
					fikcdn_ReConfigHostResult(sResponse);
				}
			}
			else if(sRespCmd=="modifypasswd"){
				FikCdn_ModifyPasswdResult(sResponse);
			}
			else if(sRespCmd=="fikgroup"){
				if(sAction=="add")	{
					FikCdn_AddGroupResult(sResponse);
				}	
				else if(sAction=="modify"){
					FikCdn_ModifyGroupResult(sResponse);
				}
				else if(sAction=="del"){
					FikCdn_DelGroupResult(sResponse);
				}
				else if(sAction=="modifystatus"){
					fikcdn_ModifyStatusGroupResult(sResponse);
				}
			}		
			else if(sRespCmd=="domain"){
				if(sAction=="add"){
					FikCdn_AddDomainResult(sResponse);				
				}
				else if(sAction=="del"){
					FikCdn_DelDomainResult(sResponse);	
				}			
				else if(sAction=="cleancache"){
					FikCdn_CleanCacheResult(sResponse);	
				}		
				else if(sAction=="cleandircache"){
					FikCdn_CleanDirCacheResult(sResponse);	
				}
				else if(sAction=="modify"){
					FikCdn_ModifyDomainResult(sResponse);	
				}		
				else if(sAction=="startdomain"){
					fikcdn_StartDomainResult(sResponse);	
				}
				else if(sAction=="modifystatus"){
					fikcdn_ModifyDomainStatusResult(sResponse);	
				}	
				else if(sAction=="delnodedomain"){
					fikcdn_DelNodeDomainResult(sResponse);	
				}				
				else if(sAction=="start"){
					FikCdn_StartDomainResult(sResponse);
				}					
				else if(sAction=="stop"){
					FikCdn_StopDomainResult(sResponse);
				}				
				else if(sAction=="verify"){
					FikCdn_VerifyDomainResult(sResponse);
				}	
				else if(sAction=="modifyset"){
					FikCdn_ModifySetDomainResult(sResponse);
				}	
			}
			else if(sRespCmd=="search"){
				if(sAction=="user"){
					fikcdn_SearchUserResult(sResponse);	
				}
				else if(sAction=="node"){
					fikcdn_SearchNodeResult(sResponse);	
				}
				else if(sAction=="domain"){
					fikcdn_SearchDomainResult(sResponse);	
				}				
				else if(sAction=="recharge"){
					fikcdn_SearchRechargeResult(sResponse);	
				}
				else if(sAction=="buyhistory"){
					fikcdn_SearchBuyHistoryResult(sResponse);	
				}			
				else if(sAction=="order"){
					fikcdn_SearchBuyHistoryResult(sResponse);	
				}		
				else if(sAction=="buy"){
					fikcdn_SearchBuyHistoryResult(sResponse);	
				}
			}
			else if(sRespCmd=="user"){
				if(sAction=="add"){
					FikCdn_AddUserResult(sResponse);	
				}		
				else if(sAction=="del"){
					FikCdn_DelUserResult(sResponse);	
				}	
				else if(sAction=="modify"){
					fikcdn_ModifyUserResult(sResponse);	
				}
			}
			else if(sRespCmd=="pull"){
				if(sAction=="addpull"){
					fikcdn_AddPullResult(sResponse);	
				}
				else if(sAction=="delpull"){
					fikcdn_DelPullResult(sResponse);	
				}
				else if(sAction=="modifystatus"){
					fikcdn_ModifyStatusPullResult(sResponse);	
				}		
			}
			else if(sRespCmd=="recharge"){
				if(sAction=="add"){
					fikcdn_AddRechargeResult(sResponse);	
				}
			}
			else if(sRespCmd=="admin"){		
				if(sAction=="modify"){
					FikCdn_ModifyAdminResult(sResponse);	
				}
			}
			else if(sRespCmd=="logs"){
				if(sAction=="clearloginlog"){
					FikCdn_ClearLoginLogResult(sResponse);	
				}
			}
			else if(sRespCmd=="setting"){
				if(sAction=="modifyinfo"){
					FikCdn_ModifyInfoResult(sResponse);	
				}
				else if(sAction=="modifypasswd"){
					FikCdn_ModifyPasswdResult(sResponse);	
				}
			}			
			else if(sRespCmd=="order"){
				if(sAction=="modify"){
					FikCdn_ModifyOrderResult(sResponse);	
				}	
				else if(sAction=="del"){
					FikCdn_DelOrderResult(sResponse);	
				}
			}
			else if(sRespCmd=="product"){
				if(sAction=="add"){
					FikCdn_AddProductResult(sResponse);	
				}	
				else if(sAction=="modify"){
					FikCdn_ModifyProductResult(sResponse);	
				}	
				else if(sAction=="del"){
					FikCdn_DelProductResult(sResponse);	
				}
			}
			else if(sRespCmd=="upstream"){
				if(sAction=="add"){
					FikCdn_AddUpstreamResult(sResponse);	
				}	
				else if(sAction=="del"){
					FikCdn_DelUpstreamResult(sResponse);	
				}	
				else if(sAction=="same_config"){
					FikCdn_SameNodeConfigUpstreamResult(sResponse);	
				}				
				else if(sAction=="modify"){
					FikCdn_ModifyUpstreamResult(sResponse);	
				}
			}
			else if(sRespCmd=="buy"){
				if(sAction=="del"){
					FikCdn_DelBuyResult(sResponse);	
				}			
				else if(sAction=="modify"){
					FikCdn_ModifyBuyResult(sResponse);	
				}
				else if(sAction=="startdomain"){
					FikCdn_StartBuyDomainResult(sResponse);	
				}
				else if(sAction=="stopdomain"){
					FikCdn_StopBuyDomainResult(sResponse);	
				}				
			}
			else if(sRespCmd=="task"){
				if(sAction=="del"){
					FikCdn_DelTaskResult(sResponse);	
				}
				else if(sAction=="reexecute"){
					FikCdn_ReExecuteTaskResult(sResponse);	
				}	
				else if(sAction=="autodel"){
					FikCdn_SetAutoDelTaskResult(sResponse);	
				}		
			}
			else if(sRespCmd=="fcache"){
				if(	sAction=="list"){
					FikCdn_RefreshFCacheResult(sResponse);
				}
				else if(sAction == "add"){
					FikCdn_AddFCacheResult(sResponse);	
				}
				else if(sAction == "modify"){
					FikCdn_ModifyFCacheResult(sResponse);	
				}	
				else if(sAction == "del"){
					FikCdn_DelFCacheResult(sResponse);	
				}
				else if(sAction == "up"){
					FikCdn_UpFCacheResult(sResponse);
				}	
				else if(sAction == "down"){
					FikCdn_DownFCacheResult(sResponse);
				}	
				else if(sAction == "sync"){
					FikCdn_SyncFCacheResult(sResponse);
				}
			}
			else if(sRespCmd=="rcache"){
				if(	sAction=="list"){
					FikCdn_RefreshRCacheResult(sResponse);
				}	
				else if(sAction == "add"){
					FikCdn_AddRCacheResult(sResponse);
				}	
				else if(sAction == "modify"){
					FikCdn_ModifyRCacheResult(sResponse);	
				}	
				else if(sAction == "del"){
					FikCdn_DelRCacheResult(sResponse);	
				}				
				else if(sAction == "up"){
					FikCdn_UpRCacheResult(sResponse);
				}	
				else if(sAction == "down"){
					FikCdn_DownRCacheResult(sResponse);
				}	
				else if(sAction == "sync"){
					FikCdn_SyncRCacheResult(sResponse);
				}
			}
			else if(sRespCmd=="rewrite"){
				if(	sAction=="list"){
					FikCdn_RefreshRewriteResult(sResponse);
				}
				else if(sAction == "add"){
					FikCdn_AddRewriteResult(sResponse);	
				}	
				else if(sAction == "modify"){
					FikCdn_ModifyRewriteResult(sResponse);	
				}	
				else if(sAction == "del"){
					FikCdn_DelRewriteResult(sResponse);	
				}	
				else if(sAction == "up"){
					FikCdn_UpRewriteResult(sResponse);
				}	
				else if(sAction == "down"){
					FikCdn_DownRewriteResult(sResponse);
				}
				else if(sAction == "sync"){
					FikCdn_SyncRewriteResult(sResponse);
				}
			}			
			
		}
	}
}

function RealtimeAjaxBasePost(sRespCmd,sAction,AjaxMode,postURL,postStr,returnOBJId,returnOBJId2){
	var ajaxReq;
	var sResponse;
	var IfchkTimeOut=true;
	var needRe=0;
	var needRe2=0;
	var ifdebug=false;
	var returnOBJ;
	var returnOBJ2;
	
	if(typeof(returnOBJId) == "undefined"){
		needRe=0;
	}else{
		returnOBJ=document.getElementById(returnOBJId); 
		needRe=1;
	}
	
	if(typeof(returnOBJId2) == "undefined"){
		needRe2=0;
	}else{
		returnOBJ2=document.getElementById(returnOBJId2); 
		needRe2=1;
	}
	
	if (window.XMLHttpRequest){
	  	// code for IE7+, Firefox, Chrome, Opera, Safari
	  	ajaxReq=new XMLHttpRequest();
	}
	else{
	  	// code for IE6, IE5
	  	ajaxReq=new ActiveXObject("Microsoft.XMLHTTP");
	}
		
	function ontimeout(){ 
		if(IfchkTimeOut==true){
			ajaxReq.abort();
			if(needRe==1){
				var strurl;
				var index1 = postURL.indexOf('?');
				if(index1==-1){
					strurl=postURL + "?" + postStr;
				}
				else{
					strurl=postURL + "&" + postStr;
				}
				returnOBJ.innerHTML = "连接超时，<a href=" + strurl + " target=_blank>请点此查看</a>";
			}
		}
	}
	
	if(AjaxMode=="POST"){
		ajaxReq.open("POST",postURL,true);
		setTimeout(ontimeout,25000);
		ajaxReq.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
		ajaxReq.send(postStr);
	}else{
		var strurl;
		if(typeof(postStr) != "undefined" && postStr.length>0 ){
			var index1 = postURL.indexOf('?');
			if(index1==-1){
				strurl=postURL + "?" + postStr;
			}
			else{
				strurl=postURL + "&" + postStr;
			}
		}else{
			strurl=postURL;
		}
		
		setTimeout(ontimeout,25000);//判断连接超时
		ajaxReq.open("GET",strurl,true);
		ajaxReq.send(null);
	}	

	ajaxReq.onreadystatechange=function(){
	  	if ( (ajaxReq.readyState==4 && ajaxReq.status==200) || (ajaxReq.readyState==4 && ajaxReq.status==0)){
			IfchkTimeOut=false;
			sResponse = ajaxReq.responseText;
			if(sRespCmd=="fiknode"){
				if(sAction=="realtime"){
					FikCdn_NodeRealtimeResult(sResponse);
				}				
				else if(sAction=="auth"){
					FikCdn_NodeAuthResult(sResponse);
				}
			}
		}

	}
}

function urlencode(text){
	text = text.toString();
	var matches = text.match(/[\x90-\xFF]/g);
	if (matches)
	{
		for (var matchid = 0; matchid < matches.length; matchid++)
		{
			var char_code = matches[matchid].charCodeAt(0);
			text = text.replace(matches[matchid], '%u00' + (char_code & 0xFF).toString(16).toUpperCase());
		}
	}
	return escape(text).replace(/\+/g, "%2B");
}



function AjaxClientBasePost(sRespCmd,sAction,AjaxMode,postURL,postStr,returnOBJId,returnOBJId2){
	var ajaxReq;
	var sResponse;
	var IfchkTimeOut=true;
	var needRe=0;
	var needRe2=0;
	var ifdebug=false;
	var returnOBJ;
	var returnOBJ2;
	
	if(typeof(returnOBJId) == "undefined"){
		needRe=0;
	}else{
		returnOBJ=document.getElementById(returnOBJId); 
		needRe=1;
	}
	
	if(typeof(returnOBJId2) == "undefined"){
		needRe2=0;
	}else{
		returnOBJ2=document.getElementById(returnOBJId2); 
		needRe2=1;
	}
	
	if (window.XMLHttpRequest){
	  	// code for IE7+, Firefox, Chrome, Opera, Safari
	  	ajaxReq=new XMLHttpRequest();
	}
	else{
	  	// code for IE6, IE5
	  	ajaxReq=new ActiveXObject("Microsoft.XMLHTTP");
	}
		
	function ontimeout(){ 
		if(IfchkTimeOut==true){
			ajaxReq.abort();
			if(needRe==1){
				var strurl;
				var index1 = postURL.indexOf('?');
				if(index1==-1){
					strurl=postURL + "?" + postStr;
				}
				else{
					strurl=postURL + "&" + postStr;
				}
				returnOBJ.innerHTML = "连接超时，<a href=" + strurl + " target=_blank>请点此查看</a>";
			}
		}
	}
	
	if(AjaxMode=="POST"){
		ajaxReq.open("POST",postURL,true);
		setTimeout(ontimeout,15000);
		ajaxReq.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
		ajaxReq.send(postStr);
	}else{
		var strurl;
		if(typeof(postStr) != "undefined" && postStr.length>0 ){
			var index1 = postURL.indexOf('?');
			if(index1==-1){
				strurl=postURL + "?" + postStr;
			}
			else{
				strurl=postURL + "&" + postStr;
			}
		}else{
			strurl=postURL;
		}
		
		setTimeout(ontimeout,15000);//判断连接超时
		ajaxReq.open("GET",strurl,true);
		ajaxReq.send(null);
	}	

	ajaxReq.onreadystatechange=function(){
	  	if ( (ajaxReq.readyState==4 && ajaxReq.status==200) || (ajaxReq.readyState==4 && ajaxReq.status==0)){
			IfchkTimeOut=false;
			sResponse = ajaxReq.responseText;
			if(sRespCmd=="login"){
				if(sAction=="logging"){						//登录验证
					FikCdn_ClientLoginResult(sResponse,returnOBJId);
				}
				else if(sAction=="logout"){
					FikCdn_ClientLogoutResult(sResponse);
				}
			}
			else if(sRespCmd=="setting"){
				if(sAction=="modifyinfo"){
					FikCdn_ClientModifyInfoResult(sResponse);
				}
				else if(sAction=="modifypasswd"){	
					FikCdn_ClientModifyPasswdResult(sResponse);
				}
			}
			else if(sRespCmd=="domain"){
				if(sAction=="add"){
					FikCdn_ClientAddDomainResult(sResponse);
				}	
				else if(sAction=="modify"){
					FikCdn_ClientModifyDomainResult(sResponse);
				}	
				else if(sAction=="del"){
					FikCdn_ClientDelDomainResult(sResponse);
				}				
				else if(sAction=="start"){
					FikCdn_ClientStartDomainResult(sResponse);
				}					
				else if(sAction=="stop"){
					FikCdn_ClientStopDomainResult(sResponse);
				}
				else if(sAction=="cleancache"){
					FikCdn_ClientClearCacheDomainResult(sResponse);
				}				
				else if(sAction=="cleandircache"){
					FikCdn_ClientCleanDirCacheResult(sResponse);	
				}	
			}
			else if(sRespCmd=="order")
			{
				if(sAction=="add"){
					FikCdn_ClientAddOrderResult(sResponse);
				}
				else if(sAction=="del"){
					FikCdn_ClientDelOrderResult(sResponse);
				}	
				else if(sAction=="pay"){
					FikCdn_ClientPayOrderResult(sResponse);
				}
				else if(sAction=="renewal"){
					FikCdn_ClientRenewalOrderResult(sResponse);
				}
				else if(sAction=="submit"){
					FikCDN_SubmitOrderResult(sResponse);
				}
				else if(sAction=="rechdel"){
					FikCDN_DelOrderResult(sResponse);
				}
			}
			else if(sRespCmd=="user")
			{
				if(sAction=="register")
				{
					FikCdn_ClientUserRegisterResult(sResponse);
				}
			}
		}

	}
}

function ChkKeyDown(){
	if(window.event){   
    		keynum = event.keyCode;   
	}else if(event.which){   
    		keynum = event.which;   
    	}
	if(keynum==13||keynum==32)return true;
}

function left(mainStr,lngLen) { 
	if (lngLen>0) {return mainStr.substring(0,lngLen);} 
	else{return null;} 
} 

