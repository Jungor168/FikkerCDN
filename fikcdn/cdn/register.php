<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Fikker CDN 用户帐号注册</title> 
  
<style type="text/css">

html, body {
  margin: 0;
  padding: 0;
}
h1,
h2,
h3,
h4,
h5,
h6,
p,
blockquote,
pre,
a,
abbr,
acronym,
address,
cite,
code,
del,
dfn,
em,
img,
q,
s,
samp,
small,
strike,
strong,
sub,
sup,
tt,
var,
dd,
dl,
dt,
li,
ol,
ul,
fieldset,
form,
label,
legend,
button,
table,
caption,
tbody,
tfoot,
thead,
tr,
th{
  margin: 0;
  padding: 0;
  border: 0;
  font-weight: normal;
  font-size: 12px;
  line-height: 1;
 font-family: verdana, Tahoma, Arial, "微软雅黑", "宋体", sans-serif;
}

td {
  margin: 0;
  padding: 0;
  border: 0;
  font-weight: normal;
  font-size: 15px;
  line-height: 1;
 font-family: verdana, Tahoma, Arial, "微软雅黑", "宋体", sans-serif;
}

/*------
topbar
------*/
body{
	background:#ffffff;
	
}
.container{
	margin:0px auto;
	zoom:1;
	width:990px;
	/*overflow:hidden;*/
}

.container:before, .container:after {
  display: table;
  content: "";
  zoom: 1;
}
.container:after {
  clear: both;
}
.container-fluid {
  position: relative;
  min-width: 940px;
  padding-left: 20px;
  padding-right: 20px;
  zoom: 1;
}
.container-fluid:before, .container-fluid:after {
  display: table;
  content: "";
  zoom: 1;
}
.container-fluid:after {
  clear: both;
}
.container-fluid > .sidebar {
  position: absolute;
  top: 0;
  left: 20px;
  width: 220px;
}
.container-fluid > .content {
  margin-left: 240px;
}
a {
  color: #1a6cc1;
  text-decoration: none;
  line-height: inherit;
  font-weight: inherit;
}
a:hover {
  color: #00438a;
  text-decoration: underline;
}
.pull-right {
  float: right;
}
.pull-left {
  float: left;
}
.hide {
  display: none;
}
.show {
  display: block;
}
.row {
  zoom: 1;
  margin-left: -20px;
}

.row > .offset-one-third {
  margin-left: 340px;
}

.row > .offset-two-thirds {
  margin-left: 660px;
}

.topbar{
	height:46px;
	/* background:#1c8ad6; */
	background:#1c86d1;
	margin-bottom:60px;
}

.nav_string {
  font-family: verdana, Tahoma, Arial, "微软雅黑", "宋体", sans-serif;
  float:left;
  font-weight: bold;
  margin-top:15px;
  margin-left:15px;
  color: #ffffff;
  font-size: 20px;
}

.span4 {
  width: 220px;
}

.span10 {
  padding-top: 22px;
  width: 580px;
}


input.span4, textarea.span4 {
  display: inline-block;
  float: none;
  width: 210px;
  margin-left: 0;
}

/*----------------
footer
-----------------------*/
footer {
	border-top:1px solid #e7e8e9;
	padding:20px;	
}
 footer p{
	font-family: verdana, Tahoma, Arial, "微软雅黑", "宋体", sans-serif;
 	font-size:13px;
 	color:#979797;
 	text-align:center;
 }

.page-account-clean aside {
  padding-left:60px;
  padding-top: 82px;
  border-left:1px dashed #ddd;
  height: 300px;
}
.row:after {
  clear: both;
}
.row > [class*="span"] {
  display: inline;
  float: left;
  margin-left: 20px;
}

.btn_string
{
	font-family: verdana, Tahoma, Arial, "微软雅黑", "宋体", sans-serif;
 	font-size:16px;
	font-weight: bold;
 	text-align:center;
}

.input_tips_txt{
	font-family: verdana, Tahoma, Arial, "微软雅黑", "宋体", sans-serif;
	font-size: 12px;
	margin-left:8px;
	line-height: 25px;
	color: #ff0000;
}

.input_tips_txt5{
	font-family: verdana, Tahoma, Arial, "微软雅黑", "宋体", sans-serif;
	font-size: 12px;
	margin-left:8px;
	line-height: 25px;
	font-weight: bold;
	color: #ff0000;
}

 </style> 
    <!--[if lt IE 9]>
  <script type="text/javascript">
// iepp v2.1pre @jon_neal & @aFarkas github.com/aFarkas/iepp
// html5shiv @rem remysharp.com/html5-enabling-script
// Dual licensed under the MIT or GPL Version 2 licenses
/*@cc_on(function(a,b){function r(a){var b=-1;while(++b<f)a.createElement(e[b])}if(!window.attachEvent||!b.createStyleSheet||!function(){var a=document.createElement("div");return a.innerHTML="<elem></elem>",a.childNodes.length!==1}())return;a.iepp=a.iepp||{};var c=a.iepp,d=c.html5elements||"abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|subline|summary|time|video",e=d.split("|"),f=e.length,g=new RegExp("(^|\\s)("+d+")","gi"),h=new RegExp("<(/*)("+d+")","gi"),i=/^\s*[\{\}]\s*$/,j=new RegExp("(^|[^\\n]*?\\s)("+d+")([^\\n]*)({[\\n\\w\\W]*?})","gi"),k=b.createDocumentFragment(),l=b.documentElement,m=b.getElementsByTagName("script")[0].parentNode,n=b.createElement("body"),o=b.createElement("style"),p=/print|all/,q;c.getCSS=function(a,b){try{if(a+""===undefined)return""}catch(d){return""}var e=-1,f=a.length,g,h=[];while(++e<f){g=a[e];if(g.disabled)continue;b=g.media||b,p.test(b)&&h.push(c.getCSS(g.imports,b),g.cssText),b="all"}return h.join("")},c.parseCSS=function(a){var b=[],c;while((c=j.exec(a))!=null)b.push(((i.exec(c[1])?"\n":c[1])+c[2]+c[3]).replace(g,"$1.iepp-$2")+c[4]);return b.join("\n")},c.writeHTML=function(){var a=-1;q=q||b.body;while(++a<f){var c=b.getElementsByTagName(e[a]),d=c.length,g=-1;while(++g<d)c[g].className.indexOf("iepp-")<0&&(c[g].className+=" iepp-"+e[a])}k.appendChild(q),l.appendChild(n),n.className=q.className,n.id=q.id,n.innerHTML=q.innerHTML.replace(h,"<$1font")},c._beforePrint=function(){if(c.disablePP)return;o.styleSheet.cssText=c.parseCSS(c.getCSS(b.styleSheets,"all")),c.writeHTML()},c.restoreHTML=function(){if(c.disablePP)return;n.swapNode(q)},c._afterPrint=function(){c.restoreHTML(),o.styleSheet.cssText=""},r(b),r(k);if(c.disablePP)return;m.insertBefore(o,m.firstChild),o.media="print",o.className="iepp-printshim",a.attachEvent("onbeforeprint",c._beforePrint),a.attachEvent("onafterprint",c._afterPrint)})(this,document)@*/
  </script>
  <![endif]--> 
<script language="javascript" src="../js/urlencode.js"></script> 
<script language="javascript" src="../js/fikcnd_event.js"></script>
<script language="javascript" src="../js/client_function.js"></script>
<script language="javascript" src="../js/ajax.js"></script>
<script language="javascript" src="../js/cookie.js"></script>  
<script language="javascript" src="../js/md5.js"></script>
<script type="text/javascript">	  
function ChangeCheckCode(){
	document.getElementById("span_check_code").innerHTML='<img src="../function/checkcode.php" alt="验证码" height="20" width="50" />';
}

function OnRegisterUser(){
	var txtUsername	 =document.getElementById("txtUsername").value;
	var txtPasswd    =document.getElementById("txtPasswd").value;
	var txtRealname  =document.getElementById("txtRealname").value;
	var txtCompanyName  =document.getElementById("txtCompanyName").value;
	var txtPhone	 =document.getElementById("txtPhone").value;
	var txtQQ   	 =document.getElementById("txtQQ").value;
	var txtAddr 	 =document.getElementById("txtAddr").value;
	var txtCheckCode =document.getElementById("txtCheckCode").value;
	
	if (txtUsername.length==0 ){ 
	  	document.getElementById("tipsUsername").innerHTML="请输入登录用户名";
		document.getElementById("txtUsername").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsUsername").innerHTML="";
	}

	if (txtPasswd.length<6 ){ 
	  	document.getElementById("tipsPasswd").innerHTML="密码必须大于等于6位";
		document.getElementById("txtPasswd").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsPasswd").innerHTML="";
	}	
	
	if (txtRealname.length==0 ){ 
	  	document.getElementById("tipsRealname").innerHTML="请输入用户姓名";
		document.getElementById("txtRealname").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsRealname").innerHTML="";
	}	
		
	
	if (txtPhone.length==0 ){ 
	  	document.getElementById("tipsPhone").innerHTML="请输入联系电话或手机";
		document.getElementById("txtPhone").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsPhone").innerHTML="";
	}
	
	if (txtQQ.length==0 ){ 
	  	document.getElementById("tipsQQ").innerHTML="请输入QQ号";
		document.getElementById("txtQQ").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsQQ").innerHTML="";
	}
	
	if (txtCheckCode.length==0 ){ 
	  	document.getElementById("tipsCheckCode").innerHTML="请输入验证码";
		document.getElementById("txtCheckCode").focus();
	  	return false;
	}
	else
	{
		document.getElementById("tipsCheckCode").innerHTML="";
	}
	
	var postURL="./api.php?mod=user&action=register";
	var postStr="username="+UrlEncode(txtUsername)+ "&password=" + UrlEncode(hex_md5(txtPasswd)) + "&realname=" + UrlEncode(txtRealname)
			         + "&compname=" + UrlEncode(txtCompanyName) + "&phone=" + UrlEncode(txtPhone) + "&qq=" + UrlEncode(txtQQ) +  "&addr=" + UrlEncode(txtAddr)+"&checkcode="+txtCheckCode;				 
				 
	AjaxClientBasePost("user","register","POST",postURL,postStr);
}

function FikCdn_ClientUserRegisterResult(sResponse)
{
	var json = eval("("+sResponse+")");
	if(json["Return"]=="True"){
		alert("注册用户登录帐号成功。");
		location.href = "./login.php"; 
	}	
	else{
		var nErrorNo = json["ErrorNo"];
		var strErr = json["ErrorMsg"];	
	
		if(nErrorNo==30004){
			document.getElementById("tipsCheckCode").innerHTML="验证码错误";
			document.getElementById("txtCheckCode").focus();
			return false;
		}
		else if(nErrorNo==20014){
			document.getElementById("tipsUsername").innerHTML="用户帐号已经存在";
			document.getElementById("txtUsername").focus();
		}
		else
		{
			alert(strErr);
		}
	}		
}

</script>  
</head>
<body>
  
    <!-- Topbar
    ================================================== -->
    <nav class="topbar">
      <div class="topbar-inner">
        <div class="container">
                <h1 class="nav_string">Fikker CDN 帐号注册</h1>          
        </div>
      </div>
    </nav>

    <!-- Page
    ================================================== -->

<div id='page'>

    <div class='container'>
        <div class="page-account-clean page-signup row">
					 <section class='span10'>
                       
                       <table width="800" border="0">
					   <tr height="35">
					   		<td width="105" align="right"><span class="input_tips_txt5">*</span>用户帐号：</td>
							<td><input id="txtUsername" name="txtUsername" type="text" style="height:20px; width:240px;font-size:15px;" maxlength="64"  /><span class="input_tips_txt" id="tipsUsername" ></span></td>
							<td></td>					   
					   </tr>
					   <tr height="35">
					   		<td align="right"><span class="input_tips_txt5">*</span>登录密码：</td>
							<td><input id="txtPasswd" name="txtPasswd" type="password" style="height:20px; width:240px" maxlength="32"  /><span class="input_tips_txt" id="tipsPasswd" ></span></td>
							<td></td>					   
					   </tr >
					   
					   <tr height="35">
					   		<td align="right"><span class="input_tips_txt5">*</span>联系人：</td>
							<td><input id="txtRealname" name="txtRealname" type="text" style="height:20px; width:140px" maxlength="64"  /><span class="input_tips_txt" id="tipsRealname" ></span></td>
							<td></td>					   
					   </tr>						 
					   <tr height="35">
					   		<td align="right">公司名称：</td>
							<td><input id="txtCompanyName" name="txtCompanyName" type="text" style="height:20px; width:340px" maxlength="128"  /><span class="input_tips_txt" id="tipsCompanyName" ></span></td>
							<td></td>					   
					   </tr>					   					   
					   <tr height="35">
					   		<td align="right"><span class="input_tips_txt5">*</span>联系电话：</td>
							<td><input id="txtPhone" name="txtPhone" type="text" style="height:20px; width:140px" maxlength="32"  /><span class="input_tips_txt" id="tipsPhone" ></span></td>
							<td></td>					   
					   </tr>						   
					   <tr height="35">
					   		<td align="right"><span class="input_tips_txt5">*</span>QQ号：</td>
							<td><input id="txtQQ" name="txtQQ" type="text" style="height:20px; width:140px" maxlength="20"  /><span class="input_tips_txt" id="tipsQQ" ></span></td>
							<td></td>					   
					   </tr>					
					   <tr height="35">
					   		<td align="right">联系地址：</td>
							<td><input id="txtAddr" name="txtAddr" type="text" style="height:20px; width:340px" maxlength="128"  /><span class="input_tips_txt" id="tipsAddr" ></span></td>
							<td></td>					   
					   </tr>	
					   
					   	<tr height="35">
					   		<td align="right"><span class="input_tips_txt5">*</span>验证码：</td>
							<td><input id="txtCheckCode" name="txtCheckCode" type="text" style="height:20px; width:70px" maxlength="6"  />							
							<span id="span_check_code" style="clear:both;"><img src="../function/checkcode.php" alt="验证码" height="20" width="50" style="vertical-align:text-bottom;display:inline-block;" /></span>
							<a href="#" onClick="javescript:ChangeCheckCode();" > 更换验证码</a>&nbsp; <span class="input_tips_txt" id="tipsCheckCode" ></span></td>
							<td></td>					   
					   </tr>	
					   
					   <tr height="28">
					   		<td></td>
							<td></td>
							<td></td>					   
					   </tr>
					   	<tr height="35">
						<td align="center"> </td>
						<td>
						<input name="btn_register"  class="btn_string" type="submit" style="width:120px;height:32px;cursor:pointer;" value="注册" onClick="OnRegisterUser();" /> 
						</td>
						</tr>
						
						 <tr height="58">
					   		<td></td>
							<td></td>
							<td></td>					   
					  	 </tr>

					   </table>
					</section>
            
            <aside class='span4'>
                <p>已经有了账户？ 
                <a href='login.php'>马上登录</a></p>                <br />
                <br />
                <br>          
            </aside>
        </div>
        
    </div>
</div><!--end of #page-->

<script src="https://statics.dnspod.cn/yantai/js/libs/seajs/1.2.0/sea.js"></script>
<script src="https://statics.dnspod.cn/yantai/js/config.js?v=201307040122"></script>
<script>seajs.use('https://statics.dnspod.cn/yantai/js/login.js?v=201307040122');</script>


    <!-- footer
    ================================================== -->
<div>        
    <footer>
      <p>&copy; 2013 Fikker, Inc. All rights reserved.</p>
    </footer>
</div>
<style>

</body>
</html>
