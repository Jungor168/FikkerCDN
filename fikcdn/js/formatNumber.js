function FormatNumber(srcStr,nAfterDot){
	var srcStr,nAfterDot;
	srcStr = ""+srcStr+"";
	strLen = srcStr.length;				//原长度
	dotPos = srcStr.indexOf(".",0);		//切分点
	if (dotPos==-1){
		resultStr = srcStr+".";
		for (i=0;i<nAfterDot;i++){
			var resultStr = resultStr+"0";
		}
　　　　	return resultStr;
	}else{
		var tmpChar=srcStr.split(".");
		var AFDOTChar=tmpChar[1];
		if(AFDOTChar=="")AFDOTChar="0";
		var AFDOTlen=AFDOTChar.length;
		var AFDOTlen=parseInt(AFDOTlen);
		var nAfterDot=parseInt(nAfterDot);


		if(AFDOTlen==nAfterDot){
			var resultStr=tmpChar[0]+"."+AFDOTChar;
			return resultStr;
		}

		if(AFDOTlen<nAfterDot){
			for(var i=0;i<(nAfterDot-AFDOTlen);i++){
				AFDOTChar=AFDOTChar+"0";
			}
			var resultStr=String(tmpChar[0])+"."+String(AFDOTChar);
			return resultStr;
		}
				
		if(AFDOTlen>nAfterDot){
			AFDOTChar=AFDOTChar.substring(0,nAfterDot);
			var resultStr=String(tmpChar[0])+"."+String(AFDOTChar);
			return resultStr;
		}
	}
}

//以下为实时监控部分
function KBToString(nowSIZE){
	nowSIZE=parseInt(nowSIZE);
	if(nowSIZE<1024){
		return nowSIZE+" KB";
	}
	else if(nowSIZE>1024*1024*1024){
		nowSIZE=(nowSIZE/(1024.00*1024.00*1024.00)).toFixed(2) +" TB";
		return nowSIZE;
	}
	else if(nowSIZE>1024*1024){
		nowSIZE=(nowSIZE/(1024.00*1024.00)).toFixed(2) +" GB";
		return nowSIZE;
	}else{
		nowSIZE=(nowSIZE/1024.00).toFixed(2) +" MB";
		return nowSIZE;
	}
}

//检查是否是邮箱格式
function CheckMailFormat(sMail){
	var strReg="";
	var r;
	var strText=sMail

	strReg=/^\w+((-\w+)|(\.\w+))*\@{1}\w+\.{1}\w{2,4}(\.{0,1}\w{2}){0,1}/ig;

	r=strText.search(strReg);
	
	if(r==-1) {	
		return false;
	}
	return true;
}

//检查是否是纯数字
function isNumberFormat(str)
{
     var re = /^[1-9]+[0-9]*]*$/;   //判断字符串是否为数字 /^[0-9]+.?[0-9]*$/     //判断正整数 /^[1-9]+[0-9]*]*$/    
     if (!re.test(str))
    {
        return false;
     }
	 return true;
}

//位数不够补0
function numAddZero(num, n) {
	return Array(n-(''+num).length+1).join(0)+num; 
}