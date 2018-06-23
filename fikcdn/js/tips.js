document.writeln("<style>");
document.writeln("#tipDIV {");
document.writeln("position: absolute;");
document.writeln("z-index: 3;");
document.writeln("clear:both;");
document.writeln("display:none;");
document.writeln("overflow-y:hidden;");
document.writeln("overflow-x:hidden;");
document.writeln("scrollbar-face-color:#FFFFFF;");
document.writeln("scrollbar-shadow-color:#94c6e1;");
document.writeln("scrollbar-highlight-color:#94c6e1;");
document.writeln("scrollbar-3dlight-color:#FFFFFF;");
document.writeln("scrollbar-darkshadow-color:#FFFFFF;");
document.writeln("scrollbar-track-color:#FFFFFF;");
document.writeln("scrollbar-arrow-color:#94c6e1;");
document.writeln("border:1px solid #A7C5E2;");
document.writeln("background-color:#fff;");
document.writeln("table {color:#666666;}");
document.writeln("a:link,a:hover,a:active,a:visited{color: #1875C6; text-decoration: none;}");
document.writeln("}");
document.writeln("</style>");

document.writeln("<div id=\"tipDIV\"></div>");

function showrealtimeviewset(strOBJ){
	var posOBJ=document.getElementById(strOBJ);
	var posOBJStyle=getAbsoluteCoords(posOBJ);
	var ACPLH=20+1;			//TIPS层对于行的位置
	if(Sys.ie)ACPLH=20+1;
	
	//var mouseXY=getMousePosition();			//鼠标定位效果不好，改为行定位
	//divTips.style.top=mouseXY.y+"px";
	//divTips.style.left=mouseXY.x+"px";
	var ACPDIV=document.getElementById(ACPDIVID);//因为ACP层有滚动条，所以在此取滚动条位置再对TIPS层高度进行修改

	divTips=document.getElementById("tipDIV");
	divTips.style.top=posOBJStyle.top+ACPLH-ACPDIV.scrollTop+"px";
	divTips.style.left=posOBJStyle.left+265+"px";
	divTips.style.height="100px";
	divTips.style.width="360px";
	//获取记录ID
	var strRID=strOBJ.replace("RT","");
	var strRID=parseInt(strRID.replace("TD",""))-1;
	//对TIPS进行填充
	divTips.innerHTML=makeTipsText(strRID);
	divTips.style.display="block";
}
function hiderealtimeviewset(){
	document.getElementById("tipDIV").style.display="none";
}

function makeTipsText(strRID){
	var RequestUrl=rthARR.Lists[strRID].RequestUrl;

	var Title=rthARR.Lists[strRID].Title;
	if(Title=="")Title="无备注"
	
	var Rules=rthARR.Lists[strRID].Rules;	//地址匹配规则
	if(Rules==0)Rules="通配符匹配";
	if(Rules==1)Rules="正则表达式匹配";
	if(Rules==2)Rules="精确匹配";
	var Icase="不忽略";						//匹配时忽略大小写
	if(rthARR.Lists[strRID].Icase==1)Icase="忽略";
	var HitCache="不显示";					//显示缓存命中值
	if(rthARR.Lists[strRID].HitCache==1)HitCache="显示";
	var HitMemberCache="不显示";				//显示会员缓存命中值
	if(rthARR.Lists[strRID].HitMemberCache==1)HitMemberCache="显示";
	var Location="不显示";					//显示地理位置信息
	if(rthARR.Lists[strRID].Location==1)Location="显示";
	var UserAgent="不显示";					//显示浏览器信息(User-Agent)
	if(rthARR.Lists[strRID].UserAgent==1)UserAgent="显示";
	var DateTime="不显示";					//显示用户访问时间戳
	if(rthARR.Lists[strRID].DateTime==1)DateTime="显示";
	var InvalidRequest="不显示";				//显示访问合法性信息
	if(rthARR.Lists[strRID].InvalidRequest==1)InvalidRequest="显示";
//ACP表格头部
	var showCharTOP="<table width=\"350\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"font-size:12px;color:666666;\">"+"\n";
	/*
	showCharTOP=showCharTOP+"<tr>"+"\n";
	//showCharTOP=showCharTOP+"	<td valign=\"top\" height=\"35\" style=\"padding-top:8px;\" style=\"text-align:right;\">实时监控地址：</td>"+"\n";
	showCharTOP=showCharTOP+"	<td colspan=\"4\" valign=\"top\" class=\"underLine\" style=\"padding-top:8px;padding-left:18px;word-wrap:break-word\">"+RequestUrl+"</td>"+"\n";
	showCharTOP=showCharTOP+"</tr>"+"\n";
	showCharTOP=showCharTOP+"<tr>"+"\n";
	showCharTOP=showCharTOP+"	<td width=\"110\" height=\"25\" style=\"text-align:right;\">地址匹配规则：</td>"+"\n";
	showCharTOP=showCharTOP+"	<td width=\"140\">"+Rules+"</td>"+"\n";
	showCharTOP=showCharTOP+"	<td width=\"110\" style=\"text-align:right;\">缓存命中值：</td>"+"\n";
	showCharTOP=showCharTOP+"	<td width=\"140\">"+HitMemberCache+"</td>"+"\n";
	showCharTOP=showCharTOP+"</tr>"+"\n";
	showCharTOP=showCharTOP+"<tr>"+"\n";
	showCharTOP=showCharTOP+"	<td height=\"22\" style=\"text-align:right;\">会员缓存命中值：</td>"+"\n";
	showCharTOP=showCharTOP+"	<td>"+HitMemberCache+"</td>"+"\n";
	showCharTOP=showCharTOP+"	<td style=\"text-align:right;\">地理位置信息：</td>"+"\n";
	showCharTOP=showCharTOP+"	<td>"+Location+"</td>"+"\n";
	showCharTOP=showCharTOP+"</tr>"+"\n";
	showCharTOP=showCharTOP+"<tr>"+"\n";
	showCharTOP=showCharTOP+"	<td height=\"22\" style=\"text-align:right;\">地理位置信息：</td>"+"\n";
	showCharTOP=showCharTOP+"	<td>"+Location+"</td>"+"\n";
	showCharTOP=showCharTOP+"	<td style=\"text-align:right;\">浏览器信息：</td>"+"\n";
	showCharTOP=showCharTOP+"	<td>"+UserAgent+"</td>"+"\n";
	showCharTOP=showCharTOP+"</tr>"+"\n";
	showCharTOP=showCharTOP+"<tr>"+"\n";
	showCharTOP=showCharTOP+"	<td height=\"22\" style=\"text-align:right;\">用户访问时间戳：</td>"+"\n";
	showCharTOP=showCharTOP+"	<td>"+DateTime+"</td>"+"\n";
	showCharTOP=showCharTOP+"	<td style=\"text-align:right;\">访问合法性信息：</td>"+"\n";
	showCharTOP=showCharTOP+"	<td>"+InvalidRequest+"</td>"+"\n";
	showCharTOP=showCharTOP+"</tr>"+"\n";
	showCharTOP=showCharTOP+"<tr>"+"\n";
	showCharTOP=showCharTOP+"	<td colspan=\"4\" valign=\"top\" class=\"underLine\" style=\"padding-top:8px;padding-left:18px;word-wrap:break-word\">"+Title+"</td>"+"\n";
	*/
	/*
	showCharTOP=showCharTOP+"<tr>"+"\n";
	showCharTOP=showCharTOP+"	<td style=\"padding-top:8px;padding-left:0px;word-wrap:break-word\">"+Title+"</td>"+"\n";
	showCharTOP=showCharTOP+"</tr>"+"\n";
	
	showCharTOP=showCharTOP+"<tr>"+"\n";
	showCharTOP=showCharTOP+"	<td style=\"height:18px;\"></td>"+"\n";
	showCharTOP=showCharTOP+"</tr>"+"\n";
	*/
	showCharTOP=showCharTOP+"<tr>"+"\n";
	showCharTOP=showCharTOP+"	<td valign=\"top\" class=\"underLine\" style=\"padding-top:0px;padding-left:0px;word-wrap:break-word\">"+RequestUrl+"</td>"+"\n";
	showCharTOP=showCharTOP+"</tr>"+"\n";

	showCharTOP=showCharTOP+"</table>"

	return showCharTOP;
}
