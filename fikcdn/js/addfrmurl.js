//var vURL=document.location.href.replace("//","").split("/")[2];
//parent.document.getElementById("VURL").value=vURL;
function resetiframeHeight(){
	var iframeHeight=document.documentElement.clientHeight-20-28-30-Hadjust+"px";
	document.getElementById(setiframeID).style.height=iframeHeight;
}
resetiframeHeight();

