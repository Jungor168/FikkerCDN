var ACPDIVID="ACPList"			//ACP层ID
var ACPTABID="ACPTAB"			//ACP层中表格ID
var TRColor="#FFFFFF"			//行默认背景色
var TRselectedColor="#EAEAEA";	//选中时行的颜色
var ACPHeight=200;				//ACP层高度
//=======================创建ACP层=======================
document.writeln("<style>");
document.writeln("#ACPList {");
document.writeln("position: absolute;");
document.writeln("z-index: 1;");
document.writeln("clear:both;");
document.writeln("display:none;");
document.writeln("overflow-y:auto;");
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

document.writeln("<div id=\""+ACPDIVID+"\"></div>");
//=======================================================


//=============================================================
//显示ACP层
function ACPList(reOBJID,ACPData){//调用方式：返回的对象ID，调用的数据源
	hideSelectOBJ()//在IE6下，层无法遮盖select，无奈
	closeMSGBOX();
	var reOBJ=document.getElementById(reOBJID);		//返回对象
	var reOBJValue=reOBJ.value.toUpperCase();		//返回对象的当前值
	//if(reOBJValue!=""){	//判断当前返回对象是否有输入，此处不判断
		rowNo=-1;					
		document.getElementById("ACPList").scrollTop=0;	//重置搜索条位置
		//=======================定位层=======================
		var ACPDIVOBJ=document.getElementById(ACPDIVID);
		var reOBJStyle=getAbsoluteCoords(reOBJ);
		ACPDIVOBJ.style.left=reOBJStyle.left+"px";
		ACPDIVOBJ.style.top=reOBJStyle.top+reOBJStyle.height+"px";
		ACPDIVOBJ.style.width=reOBJStyle.width-2+18+18+18+"px";
		ACPDIVOBJ.style.height=ACPHeight + "px";
		ACPDIVOBJ.style.display="block";
		ACPDIVOBJWidth=ACPDIVOBJ.style.width.replace("px","");
		//====================================================
		var showCharTOP="<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"font-size:12px;color:666666;table-layout:fixed;line-height:18px;\" id=\""+ACPTABID+"\">";	//ACP表格头部
		var showChar="";

		//====================================================
		//通过ACPData生成表格
		if(ACPData.NumOfLists!=0){
			for(var i=0;i<ACPData.Lists.length;i++){
			/*
				showChar=showChar + "<tr style=\"cursor:pointer;color:#666666;height:20px;\" onMouseOver=\"javascript:this.style.backgroundColor='"+TRselectedColor+"'\" onMouseOut=\"javascript:this.style.backgroundColor='"+TRColor+"'\" ID=\"RT"+ACPData.Lists[i].NO+"TR\">"+"\n";
				showChar=showChar + "	<td ID=\"RT"+ACPData.Lists[i].NO+"TD\" onMouseOver=\"showrealtimeviewset('"+"RT"+ACPData.Lists[i].NO+"TD"+"')\" onMouseOut=\"hiderealtimeviewset();\" onclick=\"javascript:ACPCLick('','','"+ACPData.Lists[i].NO+"')\" style=\"padding-left:3px;border-bottom:1px dashed #666;white-space:nowrap;overflow:hidden\" width=\""+(ACPDIVOBJWidth-20-40)+"\" >"+ACPData.Lists[i].RequestUrl+"</td>"+"\n";
				showChar=showChar + "	<td ID=\"DELRTH\" width=\"40\" style=\"padding-left:8px;border-bottom:1px dashed #666;\" onclick=\"javascript:rthdelCONBOX('"+ACPData.Lists[i].NO+"')\">[删除]</td>"+"\n";
				showChar=showChar + "<tr>"+"\n";
			*/
				showChar=showChar + "<tr style=\"cursor:pointer;color:#666666;height:20px;\" onMouseOver=\"javascript:this.style.backgroundColor='"+TRselectedColor+"';if(len(\'"+ACPData.Lists[i].RequestUrl.replace(new RegExp("[\\\\]","g"),"|")+"\')>=74)showrealtimeviewset('"+"RT"+ACPData.Lists[i].NO+"TD"+"')\" onMouseOut=\"javascript:this.style.backgroundColor='"+TRColor+"';hiderealtimeviewset();\" ID=\"RT"+ACPData.Lists[i].NO+"TR\">"+"\n";
				showChar=showChar + "	<td width=\"100%\" style=\"border-bottom:1px dashed #666;\">"+"\n";
				showChar=showChar + "		<table width=\""+(ACPDIVOBJWidth-20)+"\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"table-layout:fixed;font-size:12px;\">"+"\n";
				
				if(ACPData.Lists[i].Title!=""){
				showChar=showChar + "			<tr height=\"20\">"+"\n";
				showChar=showChar + "				<td ID=\"TITLE\" width=\""+(ACPDIVOBJWidth-20-25)+"\" style=\"white-space:nowrap;text-overflow:ellipsis;overflow:hidden;\" onclick=\"javascript:ACPCLick('','','"+ACPData.Lists[i].NO+"')\">"+"\n";
				showChar=showChar + "<div noWrap style=width:" + (ACPDIVOBJWidth-20-25) + ";text-overflow:ellipsis;overflow:hidden;>";
				showChar=showChar + ACPData.Lists[i].Title;
				showChar=showChar + "</div>"+"\n";
				showChar=showChar + "				</td>"+"\n";
				showChar=showChar + "				<td width=\"25\"></td>"+"\n";
				showChar=showChar + "			</tr>"+"\n";
				}
				
				showChar=showChar + "			<tr height=\"20\">"+"\n";
				showChar=showChar + "				<td width=\""+(ACPDIVOBJWidth-20-25)+"\" style=\"white-space:nowrap;text-overflow:ellipsis;overflow:hidden;color:#1875C6\" onclick=\"javascript:ACPCLick('','','"+ACPData.Lists[i].NO+"')\">"+"\n";
				showChar=showChar + "<div noWrap ID=\"RT"+ACPData.Lists[i].NO+"TD\" style=width:" + (ACPDIVOBJWidth-20-25) + ";text-overflow:ellipsis;overflow:hidden;>"
				showChar=showChar + ACPData.Lists[i].RequestUrl;
				showChar=showChar + "</div>"+"\n";
				showChar=showChar + "				</td>"+"\n";
				showChar=showChar + "				<td width=\"25\" align=\"center\" ID=\"DELRTH\" onclick=\"javascript:rthdelCONBOX('"+ACPData.Lists[i].NO+"')\">"+"\n";
				showChar=showChar + "<img id=\"DELRTHBUTTON\" src=\"image\/delete-button.gif\">"+"\n";
				showChar=showChar + "				</td>"+"\n";
				showChar=showChar + "			</tr>"+"\n";
				
				showChar=showChar + "		</table>"+"\n";
				showChar=showChar + "	</td>"+"\n";
				showChar=showChar + "</tr>"+"\n";
			}
		}
		//var showChar="<tr><td>tttttttttttttt</td></tr>";
		//ACP表格生成完毕
		//====================================================
		if(showChar!=""){				//拼接表格尾部进行输出，写入ACP层中
			showChar=showCharTOP + showChar + "</table>";
			ACPDIVOBJ.innerHTML=showChar;
		}else{
			//HideACPList();
		}
	//}
}
//=============================================================

//=============================================================
//键盘选择ACP层中的某行
var rowNo=-1;
function ACPKEYDOWN(reOBJID,hitKey){
	if(document.getElementById(ACPDIVID).style.display=="none"||document.getElementById(ACPDIVID).style.display=="")return;
	var ACPLH=22;			//为控制滚动条位置设定的高
	if(Sys.ie)ACPLH=20;

	if(hitKey==38){
		for(var k=0;k<document.getElementById(ACPTABID).rows.length;k++)document.getElementById(ACPTABID).rows[k].style.backgroundColor=TRColor;
        	if(rowNo==0)rowNo++;
		//控制滚动条位置
		var tmpRN=rowNo%document.getElementById(ACPTABID).rows.length;
		
		if(tmpRN!=0){//首行不可进行上移操作
			if(rowNo>6){
				document.getElementById(ACPDIVID).scrollTop=document.getElementById(ACPDIVID).scrollTop-ACPLH;
			}else{
				document.getElementById(ACPDIVID).scrollTop=0;
			}
	       	document.getElementById(ACPTABID).rows[--rowNo%document.getElementById(ACPTABID).rows.length].style.backgroundColor=TRselectedColor;

			if(!(Sys.ie)){
				document.getElementById(reOBJID).value=document.getElementById(ACPTABID).rows[rowNo%document.getElementById(ACPTABID).rows.length].textContent;
			}else{
				document.getElementById(reOBJID).value=document.getElementById(ACPTABID).rows[rowNo%document.getElementById(ACPTABID).rows.length].innerText;
			}
		}
	}

	if(hitKey==40){
		for(var k=0;k<document.getElementById(ACPTABID).rows.length;k++)document.getElementById(ACPTABID).rows[k].style.backgroundColor=TRColor;
		//控制滚动条位置
		var tmpRN=rowNo%document.getElementById(ACPTABID).rows.length;

		if(tmpRN>6)document.getElementById(ACPDIVID).scrollTop=(tmpRN-2)*ACPLH;
		if(tmpRN>document.getElementById(ACPTABID).rows.length-2)document.getElementById(ACPDIVID).scrollTop=0;
       	document.getElementById(ACPTABID).rows[++rowNo%document.getElementById(ACPTABID).rows.length].style.backgroundColor=TRselectedColor; 

		if(!(Sys.ie)){
			document.getElementById(reOBJID).value=document.getElementById(ACPTABID).rows[rowNo%document.getElementById(ACPTABID).rows.length].textContent;
		}else{
			document.getElementById(reOBJID).value=document.getElementById(ACPTABID).rows[rowNo%document.getElementById(ACPTABID).rows.length].innerText;
		}
   	}

	//此处可增加代码，对于其他要求的参数进行修改
	//var FID=document.getElementById(ACPTABID).rows[rowNo%document.getElementById(ACPTABID).rows.length].id;
	//document.getElementById("FID").value=FID;
}



	
//=============================================================
//点击ACP层中的某行
function ACPCLick(reValue,reOBJID,hitFID){	//返回值，返回到对象的ID，选中行的ID
//在这里rthARR是返回的实时监控保存配置
	hitFID=hitFID-1;
	document.getElementById("RequestUrl").value=rthARR.Lists[hitFID].RequestUrl;
	document.getElementById("Rules").value=rthARR.Lists[hitFID].Rules;
	document.getElementById("Icase").checked=false;
	document.getElementById("HitCache").checked=false;
	document.getElementById("HitMemberCache").checked=false;
	document.getElementById("Location").checked=false;
	document.getElementById("UserAgent").checked=false;
	document.getElementById("DateTime").checked=false;
	document.getElementById("InvalidRequest").checked=false;
	if(rthARR.Lists[hitFID].Icase==1)document.getElementById("Icase").checked=true;
	if(rthARR.Lists[hitFID].HitCache==1)document.getElementById("HitCache").checked=true;
	if(rthARR.Lists[hitFID].HitMemberCache==1)document.getElementById("HitMemberCache").checked=true;
	if(rthARR.Lists[hitFID].Location==1)document.getElementById("Location").checked=true;
	if(rthARR.Lists[hitFID].UserAgent==1)document.getElementById("UserAgent").checked=true;
	if(rthARR.Lists[hitFID].DateTime==1)document.getElementById("DateTime").checked=true;
	if(rthARR.Lists[hitFID].InvalidRequest==1)document.getElementById("InvalidRequest").checked=true;

	HideACPList();
	//此处可增加：当返回对象的VALUE不为空，则执行某个函数
	//document.getElementById("FID").value=hitFID;
	//if(document.getElementById(reOBJ).value!="")doSearch();
}


//=============================================================
//隐藏ACP层
function HideACPList(){
	document.getElementById(ACPDIVID).style.display="none";
	hiderealtimeviewset();
	showSelectOBJ();//隐藏ACP层时，设置SELECT为显示
}

//=============================================================
//点击空白处隐藏ACP层
window.document.onclick= Object_Onclick;
function Object_Onclick(){
	if(Sys.ie){
		cstrID=window.document.activeElement.id;
	}else{
		cstrID=window.event.target.id;
	}
//alert(cstrID);
	if(cstrID==""){
		HideACPList();//隐藏ACP层
		hiderealtimeviewset();//隐藏TIPS层
	}
} 
