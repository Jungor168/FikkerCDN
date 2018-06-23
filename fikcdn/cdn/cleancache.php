<?php
include_once("./head.php");
?>
<script language="javascript" src="../js/calendar.js"></script>

<script type="text/javascript">
function FikCdn_CleanCache(){
	var productSelect =document.getElementById("productSelect").value; 
	var txtUrl1    =document.getElementById("txtUrl1").value;
	var txtUrl2    =document.getElementById("txtUrl2").value;
	var txtUrl3    =document.getElementById("txtUrl3").value;	
		
	if(productSelect.length==0)
	{
		document.getElementById("tipsProductSelect").innerHTML="您无购买产品套餐，不能更新缓存文件";	
		return false;
	}
	else
	{
		document.getElementById("tipsProductSelect").innerHTML="";
	}
		
	if (txtUrl1.length==0 && txtUrl2.length==0 && txtUrl3.length==0 ){ 
		document.getElementById("tipsUrl1").innerHTML="请输入要更新的缓存文件 URL 地址";
		document.getElementById("txtUrl1").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsUrl1").innerHTML="";
	}
	
	var postURL="./ajax_domain.php?mod=domain&action=cleancache";
	var postStr="buy_id=" + productSelect + "&url1=" + UrlEncode(txtUrl1) + "&url2=" + UrlEncode(txtUrl2)+ "&url3=" + UrlEncode(txtUrl3);
					 
	AjaxClientBasePost("domain","cleancache","POST",postURL,postStr);	
}

function FikCdn_ClientClearCacheDomainResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){		
		var boxURL="msg.php?1.9&msg=缓存更新任务已经提交到后台任务队列中，后台任务执行程序会在一分钟内开始逐个更新各个节点服务器缓存。";
		showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');
					
		document.getElementById("txtUrl1").value="";
		document.getElementById("txtUrl2").value="";
		document.getElementById("txtUrl3").value="";
	}else{
		var nErrorNo = json["ErrorNo"];
		var strErr = json["ErrorMsg"];	
	
		if(nErrorNo==30000){
			parent.location.href = "./login.php"; 
		}else{
			var boxURL="msg.php?1.9&msg="+strErr;
			showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');
		}
	}		
}

function FikCdn_CleanDirCache(){
	var domainSelect =document.getElementById("domainSelect").value; 
	var txtDirUrl    =document.getElementById("txtDirUrl").value;

	if(domainSelect.length==0)
	{
		document.getElementById("tipsDomainSelect").innerHTML="无域名，不能更新目录缓存";	
		return false;
	}
	else
	{
		document.getElementById("tipsDomainSelect").innerHTML="";
	}
		
	if (txtDirUrl.length==0){ 
		document.getElementById("tipsDirUrl").innerHTML="请输入需更新的缓存目录 URL 链接地址";
		document.getElementById("txtDirUrl").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsDirUrl").innerHTML="";
	}
	
	var postURL="./ajax_domain.php?mod=domain&action=cleandircache";
	var postStr="domain_id=" + domainSelect + "&url=" + UrlEncode(txtDirUrl);
					 
	AjaxClientBasePost("domain","cleandircache","POST",postURL,postStr);	
}

function FikCdn_ClientCleanDirCacheResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){		
		var boxURL="msg.php?1.9&msg=缓存更新任务已经提交到后台任务队列中，后台任务执行程序会在一分钟内开始逐个更新各个服务器缓存。";
		showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');		
		document.getElementById("txtDirUrl").value="";
	}else{
		var nErrorNo = json["ErrorNo"];
		var strErr = json["ErrorMsg"];	
	
		if(nErrorNo==30000){
			parent.location.href = "./login.php"; 
		}else{
			var boxURL="msg.php?1.9&msg="+strErr;
			showMSGBOX('',350,100,BT,BL,120,boxURL,'操作提示:');
		}
	}			
}

</script>


<div style="min-width:780px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F9FA">
  <tr>
    <td width="17" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="../images/content-bg.gif">
	   <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2">
			<tr height="31" class="TabToolTitle">
				<td height="31" width="85"><a href="fikcdn_cleancache.php"><span class="title_bt">更新缓存</span></a></td>
				<td width="95%"></td>
			</tr>	
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>    
  <tr height="500">
	  <td valign="middle" background="../images/mail_leftbg.gif">&nbsp;</td>
	  <td valign="top">
		  <table width="800" border="0" class="dataintable">
			<tr>
				<th colspan="2" align="left" height="35">单个文件缓存更新：</th>
			</tr>
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right">域名所属的产品套餐：</td>
				<td><select id="productSelect" style="width:200px">
 <?php
	$client_username 	= $_SESSION['fikcdn_client_username'];
 	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		$sql = "SELECT * FROM fikcdn_buy WHERE username='$client_username';"; 
		$result = mysql_query($sql,$db_link);
		if($result)
		{
			$row_count=mysql_num_rows($result);
			for($i=0;$i<$row_count;$i++)
			{
				$buy_id			= mysql_result($result,$i,"id");	
				$product_id		= mysql_result($result,$i,"product_id");	
				
				$sql = "SELECT * FROM fikcdn_product WHERE id='$product_id';"; 
				$result2 = mysql_query($sql,$db_link);
				if($result2 && mysql_num_rows($result2)>0)
				{
					$product_name = mysql_result($result2,0,"name");
					//$product_name = $product_name.'('.$buy_id.')';	
					echo '<option value="'.$buy_id.'">'.$product_name."</option>";		
				}										
			}
		}
	
		mysql_close($db_link);
	}			
 ?>
				</select><span class="input_tips_txt" id="tipsProductSelect" ></span></td>
			</tr>				
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right">URL 链接地址 一：</td>
				<td><input id="txtUrl1" type="text" size="85" maxlength="1024"  /> <span class="input_tips_txt" id="tipsUrl1" ></span>  </td>
    		</tr>		
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right">URL 链接地址 二：</td>
				<td><input id="txtUrl2" type="text" size="85" maxlength="1024"  /> <span class="input_tips_txt" id="tipsUrl2" ></span>  </td>
    		</tr>
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right">URL 链接地址 三：</td>
				<td><input id="txtUrl3" type="text" size="85" maxlength="1024"  /> <span class="input_tips_txt" id="tipsUrl3" ></span>  </td>
    		</tr>
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="center"> </td>
				<td>
				<input id="Btn_CleanCache"  type="submit" style="width:100px;height:28px" value="提交更新任务" style="cursor:pointer;" onClick="FikCdn_CleanCache();" /> 
				</td>
    		</tr>
			<tr bgcolor="#FFFFE6">
				<td colspan="2" align="left" height="35"><p style="padding-left:70px">
					说明：<br />
					1、缓存更新任务提交到后台任务队列后，系统后台会在几分钟内提交到各个节点服务器上一一执行；<br />
				</p></td>
			</tr>			
			
			<tr bgcolor="#FFFFFF">
				<td colspan="2" align="left" height="35"><p style="padding-left:70px"></td>
			</tr>
			<tr>
				<th colspan="2" align="left" height="35">网站目录缓存更新：</th>
			</tr>
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right">选择清理的域名：</td>
				<td><select id="domainSelect" style="width:200px">
 <?php	
 	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		$sql = "SELECT * FROM fikcdn_domain WHERE username='$client_username';"; 
		$result = mysql_query($sql,$db_link);
		if($result)
		{
			$row_count=mysql_num_rows($result);
			for($i=0;$i<$row_count;$i++)
			{
				$domain_id	= mysql_result($result,$i,"id");
				$hostname	= mysql_result($result,$i,"hostname");	
				echo '<option value="'.$domain_id.'">'.$hostname."</option>";									
			}
		}
	
		mysql_close($db_link);
	}			
 ?>
				</select><span class="input_tips_txt" id="tipsDomainSelect" ></span></td>
			</tr>				
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="right">URL 目录地址：</td>
				<td><input id="txtDirUrl" type="text" size="85" maxlength="1024"  /> <span class="input_tips_txt" id="tipsDirUrl" ></span>  </td>
    		</tr>			
			<tr bgcolor="#FFFFFF" onMouseMove="Event_trOnMouseOver(this)" onMouseOut="Event_trOnMouseOut(this)">
				<td width="200" height="35" align="center"> </td>
				<td>
				<input id="Btn_CleanDirCache"  type="submit" style="width:100px;height:28px" value="提交更新任务" style="cursor:pointer;" onClick="FikCdn_CleanDirCache();" /> 
				</td>
    		</tr>	
			
			<tr bgcolor="#FFFFE6">
				<td colspan="2" align="left" height="35"><p style="padding-left:70px">
					目录更新说明：<br />					
					1、目录文件缓存更新可以做全站更新或者更新某个目录下的所有文件，例如：<br />
					&nbsp;&nbsp;&nbsp;&nbsp;a、全站更新所有已缓存的文件 URL 目录地址用：*<br />
					&nbsp;&nbsp;&nbsp;&nbsp;b、更新目录下所有已缓存的文件 URL 目录地址用：css/*<br />
					2、缓存更新任务提交到后台任务队列后，系统后台会在几分钟内提交到各个节点服务器上一一执行；<br />
				</p></td>
			</tr>		
						
		 </table>
		 <p></p>
		 <table width="800" border="0" class="disc">

		</table>	
		
	  </td> 
	  <td background="../images/mail_rightbg.gif">&nbsp;</td>
  </tr>
  
   <tr>
    <td valign="bottom" background="../images/mail_leftbg.gif"><img src="../images/buttom_left2.gif" width="17" height="17" /></td>
    <td background="../images/buttom_bgs.gif"><img src="../images/buttom_bgs.gif" width="17" height="17"></td>
    <td valign="bottom" background="../images/mail_rightbg.gif"><img src="../images/buttom_right2.gif" width="16" height="17" /></td>
  </tr> 
</table>
</div>

<?php

include_once("./tail.php");
?>
