var BT="";
var BL="";
//=============================================================
//判断浏览器
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
		eval('Sys.' + i + '= ver');
		//alert('BROWSER.' + i + '=' + ver); /*调试浏览器版本显示*/
	}
	Sys.other = other;
}

var Sys = {};
var USERAGENT = navigator.userAgent.toLowerCase();
browserVersion({'ie':'msie','firefox':'','chrome':'','opera':'','safari':'','mozilla':'','webkit':'','maxthon':'','qq':'qqbrowser'});
//=============================================================
//捕捉鼠标当前位置
function getMousePosition(){	
	var e=window.event;
	var m=(e.pageX || e.pageY)?{ x:e.pageX, y:e.pageY } : { x:e.clientX + document.documentElement.scrollLeft - document.documentElement.clientLeft, y:e.clientY + document.documentElement.scrollTop  - document.documentElement.clientTop };
	return m;
}
//=============================================================
//获取返回对象的STYLE参数
function getAbsoluteCoords (e) {
	var t = e.offsetTop; var l = e.offsetLeft; var w = e.offsetWidth; var h = e.offsetHeight;
	while  (e=e.offsetParent) { t += e.offsetTop; l += e.offsetLeft; }; 
	return { top: t, left: l, width: w, height: h, bottom: t+h, right: l+w };
}
//=============================================================
//LEFT,RIGHT,MID,LEN函数
function left(mainStr,lngLen){ 
	if (lngLen>0) {return mainStr.substring(0,lngLen);}
	else{return null;}
} 
function right(mainStr,lngLen){ 
	if (mainStr.length-lngLen>=0 && mainStr.length>=0 && mainStr.length-lngLen<=mainStr.length) { 
	return mainStr.substring(mainStr.length-lngLen,mainStr.length);} 
	else{return null;}
} 
function mid(mainStr,starnum,endnum){ 
	if (mainStr.length>=0){ 
	return mainStr.substr(starnum,endnum);
	}else{return null;} 
}
function len(s){ 
	var l = 0; 
	var a = s.split(""); 
	for (var i=0;i<a.length;i++) { 
		if(a[i].charCodeAt(0)<299) { 
			l++; 
		}else{ 
			l+=2; 
		} 
	}
	return l; 
}

function chkNull(chktar){
	var rs=true;
	if(chktar=="undefined"||chktar==undefined||chktar=="")rs=false;
	return rs;
} 


/*
        当 Role == 1 时, 下面参数有效:
        {
            MasterStatus:
            主服务器的当前集群状态: 
            0 - 本服务器当前的角色不是集群主服务器
            1 - 集群主服务器绑定端口失败
            2 - 服务正常
            
            NumOfLists:
            如果存在则等于 1, 如果不存在则为 0;
            
            NO:
            列表项中当前枚举的序号, 即当前正在枚举的是第几项缓存配置, 
            小于等于 NumOfLists 值, 取值范围: 1 ~ NumOfLists;
            
            SlaveID:
            从服务器的名称;
            
            IP:
            从服务器的IP地址;
            
            LoginTime:
            从服务器登录时间;
            
            SlaveStatus:
            从服务器当前的连接状态;
            
            Note:
            备注说明, 最大 500 个字节;
        }
        
        当 Role == 2 时, 下面参数有效:
        {
            SlaveStatus:
            从服务器当前的集群状态: 
            0 - 本服务器当前角色不是集群从服务器
            1 - 连接集群主服务器失败 (网络失败)
            2 - 正在连接集群主服务器 ...
            3 - 连接集群主服务器失败 (认证失败)
            4 - 连接集群主服务器成功
        }

document.getElementById("")
        {
            Binding:
            主服务器的绑定端口;
            
            Auth:
            主服务器的连接登录认证字符串;
            
            Note:
            备注说明, 最大 500 个字节;
        }
        
        当 Role == 2 时, 下面参数有效:
        {
            Host:
            远程主服务器的IP和端口;
            
            Auth:
            连接主服务器的登录认证字符串;
            
            Note:
            备注说明, 最大 500 个字节;
        }
*/

