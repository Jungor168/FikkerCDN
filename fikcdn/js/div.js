//massage_box:提示层
//mask:遮盖层,用于锁屏
//msgBOXTitle:提示层标题,如不设置则显示操作提示
//msgBOXURL:提示层内嵌套的URL

//设置应用层
document.writeln("<style>");
document.writeln("#massage_box {");
document.writeln("position: absolute;");
document.writeln("z-index: 2;");
document.writeln("clear:both;");
document.writeln("display:none;");
document.writeln("table {color:#666666;}");
document.writeln("a:link,a:hover,a:active,a:visited{color: #1875C6; text-decoration: none;}");
document.writeln("}");

document.writeln("#mask {");
document.writeln("position: absolute;");
document.writeln("top: 0;");
document.writeln("left: 0;");
document.writeln("width: expression(body.scrollWidth);");
document.writeln("height: expression(body.scrollHeight);");
document.writeln("background: #666;");
document.writeln("filter: ALPHA(opacity=60);");
document.writeln("z-index: 1;");
document.writeln("visibility: hidden;");
document.writeln("display: none;");
document.writeln("}");

document.writeln(".msgTitle {");
document.writeln("font-size:14px;color: #666666;");
document.writeln("a:link,a:hover,a:active,a:visited{color: #1875C6; text-decoration: none;}");
document.writeln("}");
document.writeln("</style>");

document.writeln("<div id=\"massage_box\" style=\"display:none;\">")
document.writeln("<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"FFFFFF\">");
document.writeln("<tr>");
document.writeln( "	<td width=\"16\" height=\"28\"><img src=\"../images/T-L.gif\"></td>");
document.writeln( "	<td width=\"100%\" ID=\"msgBOXTitle\" class=\"msgTitle\" background=\"../images/T-M.gif\" style=padding-left:6px;></td>");
document.writeln( "	<td width=\"35\" background=\"../images/T-M.gif\"><a href=\"javascript:closeMSGBOX()\"><span style=\"font-family:宋体\;font-size:14px;\">×</span></a></td>");
document.writeln( "	<td width=\"16\"><img src=\"../images/T-R.gif\"></td>");
document.writeln("</tr>");

document.writeln("<tr>");
document.writeln("	<td background=\"../images/M-L.gif\"></td>");
document.writeln("	<td colspan=\"2\" id=\"boxM\" style=\"background:#ffffff;\"><iframe marginheight=\"0\" marginwidth=\"0\" frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"auto\" src=\"\" id=\"msgBOXURL\" name=\"msgBOXURL\"></iframe></td>");
document.writeln("	<td background=\"../images/M-R.gif\"></td>");
document.writeln("</tr>");
document.writeln("<tr>");
document.writeln("	<td background=\"../images/B-L.gif\" height=\"4\"></td>");
document.writeln("	<td colspan=\"2\" background=\"../images/B-M.gif\"></td>");
document.writeln("	<td background=\"../images/B-R.gif\"></td>");
document.writeln("</tr>");
document.writeln("</table>");
document.writeln("</div>");
document.writeln("<div id=\"mask\" style=\"display:none;\"></div>");

//获得浏览器版本号(by discuz)
function browserVersion(types) {
	var other = 1;
	for(i in types) {
		var v = types[i] ? types[i] : i;
		if(USERAGENT.indexOf(v) != -1) {
			var re = new RegExp(v + '(\\/|\\s)([\\d\\.]+)', 'ig');
			var matches = re.exec(USERAGENT);
			var ver = matches != null ? matches[2] : 0;
			other = ver !== 0 && v != 'mozilla' ? 0 : other;
		}else {
			var ver = 0;
		}
		eval('BROWSER.' + i + '= ver');
		//alert('BROWSER.' + i + '=' + ver); /*调试浏览器版本显示*/
	}
	BROWSER.other = other;
}

var BROWSER = {};
var USERAGENT = navigator.userAgent.toLowerCase();
browserVersion({'ie':'msie','firefox':'','chrome':'','opera':'','safari':'','mozilla':'','webkit':'','maxthon':'','qq':'qqbrowser'});
if(BROWSER.safari) {
	BROWSER.firefox = true;
}
BROWSER.opera = BROWSER.opera ? opera.version() : 0;

//显示层
function showMSGBOX(ifmask,boxw,boxh,boxt,boxl,boxMh,boxurl,msgBOXTitle){//是否使用遮盖层(true,false)，弹窗宽度，弹窗高度，距离顶端，距离左端，包含IFRAME高度，IFRAME地址，标题
	//判断锁屏
	var maskOBJ=document.getElementById("mask"); 
	if(ifmask=="true"){
		maskOBJ.style.visibility="visible";			//锁屏
		maskOBJ.style.display="block";
		document.body.style.overflow="hidden";		//隐藏滚动条
	}
	
	//设置标题
	if(msgBOXTitle==""||msgBOXTitle==undefined)msgBOXTitle="操作提示:";
	document.getElementById("msgBOXTitle").innerHTML=msgBOXTitle;
	
	//对弹窗进行定位
	var showOBJ=document.getElementById("massage_box");
	if(boxl==""){showOBJ.style.left=document.body.clientWidth/2-boxw/2 + "px";}else{showOBJ.style.left=boxl + "px";}
	if(boxt==""){
		if(BROWSER.chrome || BROWSER.webkit || BROWSER.safari)
		showOBJ.style.top=document.body.scrollTop+(document.documentElement.clientHeight/2-boxh/2)-10 + "px";
		else showOBJ.style.top=document.documentElement.scrollTop+(document.documentElement.clientHeight/2-boxh/2)-10 + "px";
	}else{showOBJ.style.top=boxt + "px";}
	showOBJ.style.width=boxw+"px";
	showOBJ.style.height=boxh+"px";
	
	//设置IFRAME高度，嵌套页面
	var msgBOXURLOBJ=document.getElementById("msgBOXURL"); 
	if(boxMh!="")msgBOXURLOBJ.style.height=boxh+"px";
	msgBOXURLOBJ.src=boxurl;
	
	//显示弹窗
	showOBJ.style.display="block";
}

//关闭层
function closeMSGBOX(){
	maskOBJ=document.getElementById("mask"); 
	showOBJ=document.getElementById("massage_box");
	maskOBJ.style.display="none";
	showOBJ.style.display="none";
	document.getElementById("msgBOXURL").src="";
}

//滚动条回顶部
function FloatTop(){
	document.body.scrollTop=0 + "px";
}

function resetMSGBOX(){
	var showOBJ=document.getElementById("massage_box");

	if(showOBJ.style.display!="none"){
		showOBJ.style.left=document.body.clientWidth/2-showOBJ.style.width.replace("px","")/2 + "px";
		var OT=showOBJ.style.height.replace("px","")/2
		showOBJ.style.top=document.documentElement.scrollTop+(document.documentElement.clientHeight/2-OT)-10 + "px";
	}
}

//禁止横向滚动条
//document.body.style.overflowX="hidden";
//document.body.style.overflowY="true";
//页面打开后自动设置纵向滚动条
//document.body.style.overflow="auto";
