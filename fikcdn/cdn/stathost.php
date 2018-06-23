<?php
include_once("./head.php");

// 组ID
$buy_id 		= isset($_GET['buy_id'])?$_GET['buy_id']:'';
?>
<script language="javascript" type="text/javascript" src="../flot/excanvas.js"></script>
<script language="javascript" type="text/javascript" src="../flot/jquery.js"></script>
<script language="javascript" type="text/javascript" src="../flot/jquery.flot.js"></script>
<script language="javascript" type="text/javascript" src="../flot/jquery.flot.stack.js"></script>
<script type="text/javascript">	
function selectGroup(){
	var txtGid		 =document.getElementById("grpSelect").value;
	window.location.href="stat_domain_bandwidth_down.php?buy_id="+txtGid;
}

// 将 GMT 时间转换为本地时间 
// phpLocalTime 时间格式 "2010/12/09 00:00:00"
function  ConvDate(phpLocalTime)
{
	var d=new Date(phpLocalTime); //"2010/12/09 00:00:00");

	day = d.getHours();

	d = d.setHours(8+day);

	d = new Date(d);

	x = d.getTime(); 
	
	return x;
}

var __StatDataSets;
$(function () {

	function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 15,
            border: '1px solid #aaa',
            padding: '2px',
            'background-color': '#efefef',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }
	
 	var previousPoint = null;
 
    $("#placeholder").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));
     
		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;
				
				$("#tooltip").remove();
				//var x = item.datapoint[0].toFixed(2),
				var	y = item.datapoint[1];
				
				showTooltip(item.pageX, item.pageY,
							y+" mbps");
			}
		}
		else {
			$("#tooltip").remove();
			previousPoint = null;            
		}
        
    });	
	
    $("#placeholder2").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));
     
		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;
				
				$("#tooltip").remove();
				//var x = item.datapoint[0].toFixed(2),
				var	y = item.datapoint[1];
				
				showTooltip(item.pageX, item.pageY,
							y+" mbps");
			}
		}
		else {
			$("#tooltip").remove();
			previousPoint = null;            
		}
        
    });    
	$("#placeholder3").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));
     
		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;
				
				$("#tooltip").remove();
				//var x = item.datapoint[0].toFixed(2),
				var	y = item.datapoint[1];
				
				showTooltip(item.pageX, item.pageY,
							y+" GB");
			}
		}
		else {
			$("#tooltip").remove();
			previousPoint = null;            
		}
        
    });
	$("#placeholder4").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));
     
		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;
				
				$("#tooltip").remove();
				//var x = item.datapoint[0].toFixed(2),
				var	y = item.datapoint[1];
				var nValue;
				nValue = y+ " 万次";	
				
				showTooltip(item.pageX, item.pageY,
							nValue);
			}
		}
		else {
			$("#tooltip").remove();
			previousPoint = null;            
		}
        
    });						
});

function getDomainMaxBandwidthStatData(domain_id,timeval)
{
	var xmlhttp;
	
    if (window.XMLHttpRequest)
	{
	  	// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
	}
	else
	{
	  	// code for IE6, IE5
	  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var sTimeformat;
	
	if(timeval==1)
	{
		sTimeformat = "%H:%M";
	}
	else
	{
		sTimeformat = "%0m-%0d";
	}
	
	xmlhttp.onreadystatechange=function()
	{
	  	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	
			/*
		    var data = [
					{
						label: "United States",
						data: [[1990, 18.9], [1991, 18.7], [1992, 18.4], [1993, 19.3], [1994, 19.5], [1995, 19.3], [1996, 19.4], [1997, 20.2], [1998, 19.8], [1999, 19.9], [2000, 20.4], [2001, 20.1], [2002, 20.0], [2003, 19.8], [2004, 20.4]]
					},
					{
            			label: "Russia", 
			            data: [[1992, 13.4], [1993, 12.2], [1994, 10.6], [1995, 10.2], [1996, 10.1], [1997, 9.7], [1998, 9.5], [1999, 9.7], [2000, 9.9], [2001, 9.9], [2002, 9.9], [2003, 10.3], [2004, 10.5]]
        			}];
			*/	
			var sResponse= xmlhttp.responseText;
			//document.getElementById("textStatDataTable").innerHTML=sResponse;	
			__StatDataSets = eval('('+sResponse+')');
			
			var data = [];
			for(var key in __StatDataSets)
			{
				data.push(__StatDataSets[key]);				
			}
					
			$(function(){			
				var opt ={		
					points:{show:false, clickable:true, hoverable:true},		
					lines:{show:true, lineWidth:1},	
				    grid: { hoverable: true, clickable: true,borderWidth: 1,borderColor: "#E3E6EB" },
					legend: {show:true,backgroundColor:"#FFFFE9",backgroundOpacity:0,container: $("#showChartLegend")},
					xaxis: {show:true,mode:"time", timeformat: sTimeformat}
				}; 
			
				$.plot($("#placeholder"),data,opt);			
			});
		}
	}

	var postUrl = "request_stat_data.php?mod=proxy&action=one_max_bandwidth"+"&domain_id=" + domain_id +"&timeval="+timeval;
	xmlhttp.open("GET",postUrl,true);
	xmlhttp.send(null);
	return false;
}

function OnClickCheckBox(domain_id)
{
	var sCheckBoxID = "domain_is_focus_"+domain_id;
	var is_focus=1;
	var isChecked = document.getElementById(sCheckBoxID).checked;
	if(isChecked)
	{
		is_focus=1;
	}
	else
	{
		is_focus=0;
	}
	
	var postURL="./ajax_domain.php?mod=domain&action=focus";
	var postStr="domain_id="+UrlEncode(domain_id)+"&is_focus=" + UrlEncode(is_focus);
					 
	AjaxBasePost("domain","focus","POST",postURL,postStr);		
}

function getDomainBandwidthStatData(domain_id,timeval)
{
	var xmlhttp;
	
    if (window.XMLHttpRequest)
	{
	  	// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
	}
	else
	{
	  	// code for IE6, IE5
	  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	if(timeval==1)
	{
		sTimeformat = "%H:%M";
	}
	else
	{
		sTimeformat = "%0m-%0d";
	}	
	
	xmlhttp.onreadystatechange=function()
	{
	  	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	
			/*
		    var data = [
					{
						label: "United States",
						data: [[1990, 18.9], [1991, 18.7], [1992, 18.4], [1993, 19.3], [1994, 19.5], [1995, 19.3], [1996, 19.4], [1997, 20.2], [1998, 19.8], [1999, 19.9], [2000, 20.4], [2001, 20.1], [2002, 20.0], [2003, 19.8], [2004, 20.4]]
					},
					{
            			label: "Russia", 
			            data: [[1992, 13.4], [1993, 12.2], [1994, 10.6], [1995, 10.2], [1996, 10.1], [1997, 9.7], [1998, 9.5], [1999, 9.7], [2000, 9.9], [2001, 9.9], [2002, 9.9], [2003, 10.3], [2004, 10.5]]
        			}];
			*/	
			var sResponse= xmlhttp.responseText;
			//document.getElementById("textStatDataTable").innerHTML=sResponse;	
			__StatDataSets = eval('('+sResponse+')');
			
			var data = [];
			for(var key in __StatDataSets)
			{
				data.push(__StatDataSets[key]);				
			}
					
			$(function(){			
				var opt ={		
					points:{show:false, clickable:true, hoverable:true},		
					lines:{show:true, lineWidth:1},	
				    grid: { hoverable: true, clickable: true,borderWidth: 1,borderColor: "#E3E6EB" },
					legend: {show:true,backgroundColor:"#FFFFE9",backgroundOpacity:0,container: $("#showChartLegend2")},
					xaxis: {show:true,mode:"time", timeformat: sTimeformat}
				}; 
			
				$.plot($("#placeholder2"),data,opt);			
			});
		}
	}

	var postUrl = "request_stat_data.php?mod=proxy&action=one_bandwidth"+"&domain_id=" + domain_id +"&timeval="+timeval;
	xmlhttp.open("GET",postUrl,true);
	xmlhttp.send(null);
	return false;
}

function getDomainFlawData(domain_id,timeval)
{
	var xmlhttp;
	
    if (window.XMLHttpRequest)
	{
	  	// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
	}
	else
	{
	  	// code for IE6, IE5
	  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
	  	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	
			/*
		    var data = [
					{
						label: "United States",
						data: [[1990, 18.9], [1991, 18.7], [1992, 18.4], [1993, 19.3], [1994, 19.5], [1995, 19.3], [1996, 19.4], [1997, 20.2], [1998, 19.8], [1999, 19.9], [2000, 20.4], [2001, 20.1], [2002, 20.0], [2003, 19.8], [2004, 20.4]]
					},
					{
            			label: "Russia", 
			            data: [[1992, 13.4], [1993, 12.2], [1994, 10.6], [1995, 10.2], [1996, 10.1], [1997, 9.7], [1998, 9.5], [1999, 9.7], [2000, 9.9], [2001, 9.9], [2002, 9.9], [2003, 10.3], [2004, 10.5]]
        			}];
			*/	
			var sResponse= xmlhttp.responseText;
			//document.getElementById("textStatDataTable").innerHTML=sResponse;	
			__StatDataSets = eval('('+sResponse+')');
			
			var data = [];
			for(var key in __StatDataSets)
			{
				data.push(__StatDataSets[key]);				
			}
					
			$(function(){			
				var opt ={		
					points:{show:false, clickable:true, hoverable:true},		
					lines:{show:true, lineWidth:1},	
				    grid: { hoverable: true, clickable: true,borderWidth: 1,borderColor: "#E3E6EB" },
					legend: {show:true,backgroundColor:"#FFFFE9",backgroundOpacity:0,container: $("#showChartLegend3")},
					xaxis: {show:true,mode:"time", timeformat: "%0m-%0d"}
				}; 
			
				$.plot($("#placeholder3"),data,opt);			
			});
		}
	}

	var postUrl = "request_stat_data.php?mod=proxy&action=one_DomainFlaw"+"&domain_id=" + domain_id +"&timeval="+timeval;
	xmlhttp.open("GET",postUrl,true);
	xmlhttp.send(null);
	return false;
}

function getDomainRequestCountData(domain_id,timeval)
{
	var xmlhttp;
	
    if (window.XMLHttpRequest)
	{
	  	// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
	}
	else
	{
	  	// code for IE6, IE5
	  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
	  	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	
			/*
		    var data = [
					{
						label: "United States",
						data: [[1990, 18.9], [1991, 18.7], [1992, 18.4], [1993, 19.3], [1994, 19.5], [1995, 19.3], [1996, 19.4], [1997, 20.2], [1998, 19.8], [1999, 19.9], [2000, 20.4], [2001, 20.1], [2002, 20.0], [2003, 19.8], [2004, 20.4]]
					},
					{
            			label: "Russia", 
			            data: [[1992, 13.4], [1993, 12.2], [1994, 10.6], [1995, 10.2], [1996, 10.1], [1997, 9.7], [1998, 9.5], [1999, 9.7], [2000, 9.9], [2001, 9.9], [2002, 9.9], [2003, 10.3], [2004, 10.5]]
        			}];
			*/	
			var sResponse= xmlhttp.responseText;
			//document.getElementById("textStatDataTable").innerHTML=sResponse;	
			__StatDataSets = eval('('+sResponse+')');
			
			var data = [];
			for(var key in __StatDataSets)
			{
				data.push(__StatDataSets[key]);				
			}
					
			$(function(){			
				var opt ={		
					points:{show:false, clickable:true, hoverable:true},		
					lines:{show:true, lineWidth:1},	
				    grid: { hoverable: true, clickable: true,borderWidth: 1,borderColor: "#E3E6EB" },
					legend: {show:true,backgroundColor:"#FFFFE9",backgroundOpacity:0,container: $("#showChartLegend4")},
					xaxis: {show:true,mode:"time", timeformat: "%0m-%0d"}
				}; 
			
				$.plot($("#placeholder4"),data,opt);			
			});
		}
	}

	var postUrl = "request_stat_data.php?mod=proxy&action=one_RequestCount"+"&domain_id=" + domain_id +"&timeval="+timeval;
	xmlhttp.open("GET",postUrl,true);
	xmlhttp.send(null);
	return false;
}

function OnSelectDomain()
{
	msgboxOBJ=document.getElementById("msgbox"); 
	msgboxOBJ.style.display="block";	
	document.getElementById("txtGrpName").value="";
}

function OnSelectMaxBandwidthDate()
{
	var txtDomainID = document.getElementById("txtDomainID").value;
	var nMaxBandwidthDateSelect = document.getElementById("MaxBandwidthDateSelect").value;
	
	getDomainMaxBandwidthStatData(txtDomainID,nMaxBandwidthDateSelect);
}

function OnSelectBandwidthDate()
{
	var txtDomainID = document.getElementById("txtDomainID").value;
	var nBandwidthDateSelect = document.getElementById("BandwidthDateSelect").value;
	
	getDomainBandwidthStatData(txtDomainID,nBandwidthDateSelect);
}

function OnSelectFlawDate()
{
	var txtDomainID = document.getElementById("txtDomainID").value;
	var nFlawDateSelect = document.getElementById("FlawDateSelect").value;
	
	getDomainFlawData(txtDomainID,nFlawDateSelect);
}

function OnSelectRequestCountDate()
{
	var txtDomainID = document.getElementById("txtDomainID").value;
	var nRequestCountDateSelect = document.getElementById("RequestCountDateSelect").value;
	
	getDomainRequestCountData(txtDomainID,nRequestCountDateSelect);
}

</script>

<div style="min-width:780px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F9FA">
  <tr>
    <td width="17" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td valign="top" background="../images/content-bg.gif">
	   <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2" >
			<tr height="31" class="TabToolTitle">
				<td height="31" width="85"><span class="title_bt">流量统计</span></td>
			</tr>
        </table>
	</td>
    <td width="16" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>    
<?php  
	$domain_id 	= isset($_GET['id'])?$_GET['id']:'';
	
  	$db_link = FikCDNDB_Connect();
	if($db_link)
	{
		$sql = "SELECT * FROM fikcdn_domain WHERE id=$domain_id;"; 
		$result = mysql_query($sql,$db_link);
		if($result)
		{
			$hostname  	 = mysql_result($result,0,"hostname");	
			$username = mysql_result($result,0,"username");
			$buy_id = mysql_result($result,0,"buy_id");
			$group_id = mysql_result($result,0,"group_id");
		}		
	}
?>
  <tr height="500">
  	  <input id="txtDomainID" type="hidden" size="20" maxlength="256" value="<?php echo $domain_id; ?>" />
	  <td valign="middle" background="../images/mail_leftbg.gif">&nbsp;</td> 
	  <td valign="top">
	   	<table width="800" border="0" class="dataintable">
			<tr height="30">
			<td bgcolor="#FFFFE6"><span class="input_tips_txt3"><?php echo $hostname; ?> 峰值带宽统计(单位：mbps)： </span>
			<div class="div_search_title" style="padding-right:330px">
				<select id="MaxBandwidthDateSelect" style="width:120px" onChange="OnSelectMaxBandwidthDate()">
					<option value="1" >最近24小时</option>				
					<option value="7" >最近七天</option>
					<option value="30" >最近三十天</option>
					<option value="60" >上月</option>
				</select>
			</div></td>
			</tr>
		</table>
		<table border="0" style="float:left">
		<tr>
		 <td width="820"><div id="placeholder" style="width:780px;height:280px; float:left;"></div></td>
		 		 <td style="padding-top:0px;">
			<div id="showChartLegend" style="padding-top:0px;height:280px;"></div>
		</td>	
		 </tr>
		</table> 
		
	   	<table width="800" border="0" class="dataintable">
			<tr height="30">
			<td bgcolor="#FFFFE6"><span class="input_tips_txt3"><?php echo $hostname; ?> 带宽统计(单位：mbps)： </span>
			<div class="div_search_title" style="padding-right:330px">
				<select id="BandwidthDateSelect" style="width:120px" onChange="OnSelectBandwidthDate()">
					<option value="1" >最近24小时</option>				
					<option value="7" >最近七天</option>
				<!--	<option value="30" >最近三十天</option> -->
				</select>
			</div></td>
			</tr>
		</table>
		<table border="0" style="float:left">
		<tr>
		 <td width="820"><div id="placeholder2" style="width:780px;height:280px; float:left;"></div></td>
		 		 <td style="padding-top:0px;">
			<div id="showChartLegend2" style="padding-top:0px;height:280px;"></div>
		</td>	
		 </tr>
		</table> 
				
	   	<table width="800" border="0" class="dataintable">
			<tr height="30">
			<td bgcolor="#FFFFE6"><span class="input_tips_txt3"><?php echo $hostname; ?> 流量统计(单位：GB)： </span>
			<div class="div_search_title" style="padding-right:330px">
				<select id="FlawDateSelect" name="FlawDateSelect" style="width:120px" onChange="OnSelectFlawDate()">			
					<option value="15" >最近十五天</option>
					<option value="30" >最近一个月</option>
					<option value="60" >最近三个月</option>
				</select>
			</div></td>
			</tr>
		</table>
		<table border="0" style="float:left">
		<tr>
		 <td width="820"><div id="placeholder3" style="width:780px;height:280px; float:left;"></div></td>
		 		 <td style="padding-top:0px;">
			<div id="showChartLegend3" style="padding-top:0px;height:280px;"></div>
		</td>	
		 </tr>
		</table> 
		
	   	<table width="800" border="0" class="dataintable">
			<tr height="30">
			<td bgcolor="#FFFFE6"><span class="input_tips_txt3"><?php echo $hostname; ?> 请求数统计(单位：万次)： </span>
			<div class="div_search_title" style="padding-right:330px">
				<select id="RequestCountDateSelect" style="width:120px" onChange="OnSelectRequestCountDate()">			
					<option value="15" >最近十五天</option>
					<option value="30" >最近一个月</option>
					<option value="60" >最近三个月</option>
				</select>
			</div></td>
			</tr>
		</table>
		<table border="0" style="float:left">
		<tr>
		 <td width="820"><div id="placeholder4" style="width:780px;height:280px; float:left;"></div></td>
		 		 <td style="padding-top:0px;">
			<div id="showChartLegend4" style="padding-top:0px;height:280px;"></div>
		</td>	
		 </tr>
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

<div id="textStatDataTable"></div>

<script type="text/javascript">	
getDomainMaxBandwidthStatData(<?php echo $domain_id; ?>,1);

var nIntervalID = setInterval(ontimeout,250);
var nCount =0;

	function ontimeout(){ 
		if(nCount==0)
		{
			nCount++;
			getDomainBandwidthStatData(<?php echo $domain_id; ?>,1);	
		}
		else if(nCount==1)
		{
			nCount++;
			getDomainFlawData(<?php echo $domain_id; ?>,15);
		}		
		else if(nCount==2)
		{	
			nCount++;
			getDomainRequestCountData(<?php echo $domain_id; ?>,15);
		}
		else
		{
			clearInterval(nIntervalID);
		}
	}

</script>
<?php

include_once("./tail.php");
?>
