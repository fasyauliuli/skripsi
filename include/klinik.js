var $cur=[1,1,1,1];
//-- alias document.getElementById ----------------------------------------------------------------------------------------------------------------------------------------------------------
function e($id){return document.getElementById($id);}
//-- set duration after login ---------------------------------------------------------------------------------------------------------------------------------------------------------------
var $h=$n=$s=0;
function f_timer(){
	$s++;
	if($s==60){$s=0;$n++;}
	if($n==60){$n=0;$h++;}
	try{e("duration").innerHTML=("0"+$h).substr(-2,2)+":"+("0"+$n).substr(-2,2)+":"+("0"+$s).substr(-2,2);}catch(err){$h=$n=$s=0;}
}
setInterval(f_timer,1000);
//-- event trigger --------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function f_event($this,$event,$flag){
	var $current=$cur[$flag];
	if($this.id=="status"||($this.id=="cari"&&$event.type=="keyup")){e("iframe").src="index.php?control=query1&flag="+e("status").value+"|"+e("cari").value;$current=1;}
	else if($this.id=="login")e("iframe").src="index.php?control=login&flag="+e('user').value+"|"+e('password').value;
	else if($this.id=="logout")if(confirm("Anda yakin akan logout?")==true)e("iframe").src="index.php?control=login&flag=logout";else return;
	else if($this.id=="daftar")e("iframe").src="index.php?control=save&flag=||"+e("grid1").rows[$current].cells[1].innerHTML+"|daftar";
	else if($this.id=="cancel")e("cover").className="hidden";
	else if($this.id=="closereport")e("cover").className="hidden";
	else if($this.id=="printreport"){
		var $window=window.open("localhost/klinik","_blank","left=0,top=0,width=900,height=800,scrollbars=yes");
		$window.document.write(
			"<script type='text/javascript' src='include/klinik.js'></script>"+
			"<script>f_style()</script>"+
			"<div style='width:8.27in;height:11.29in;margin:0.5in'>"+e("print0").innerHTML+"</div>"
		); 
		$window.location;
		$window.document.close();
		$window.focus();
		$window.print();
		$window.close();
	}
	else if($this.id=="edit"){
		var $e=e("editor"),$c=e("cover");
		$c.className="cover";
		$e.style.left=(($c.offsetWidth-$e.offsetWidth)/2)+"px";
		$e.style.top=(($c.offsetHeight-$e.offsetHeight)/2)+"px";
		e("editor_caption").innerHTML="EDITOR";
		e("form_pegawai").className=(e("status").value=="Pegawai"?"bd":"hidden");
		e("form_umum").className=(e("status").value=="Pegawai"?"hidden":"bd");
		if(e("status").value=="Pegawai"){
			var $temp=e("grid1").rows[$current].cells[2].innerHTML.split("<br>");
			$temp[1]=$temp[1].split("/");
			$temp[3]=$temp[3].split("/");
			e("input1").value=e("grid1").rows[$current].cells[1].innerHTML;
			e("input2").value=$temp[0];
			e("input3").value=Number($temp[1][0]);
			e("input4").value=Number($temp[1][1]);
			e("input5").value=Number($temp[1][2]);
			e("input6").value=$temp[2];
			e("input7").value=Number($temp[3][0]);
			e("input8").value=Number($temp[3][1]);
			e("input9").value=Number($temp[3][2]);
			e("input10").value=$temp[4];
			var $temp=e("grid1").rows[$current].cells[3].innerHTML.split("<br>");
			e("input11").value=$temp[0];
			e("input12").value=$temp[1];
			e("input13").value=$temp[2];
			e("input14").value=$temp[3];
			e("input15").value=e("grid1").rows[$current].cells[4].innerHTML;
		}
		else{
			var $temp=e("grid1").rows[$current].cells[2].innerHTML.split("<br>");
			$temp[1]=$temp[1].split("/");
			e("input16").value=e("grid1").rows[$current].cells[1].innerHTML;
			e("input17").value=$temp[0];
			e("input18").value=Number($temp[1][0]);
			e("input19").value=Number($temp[1][1]);
			e("input20").value=Number($temp[1][2]);
			e("input21").value=$temp[2];
			e("input22").value=e("grid1").rows[$current].cells[3].innerHTML;
			e("input23").value=e("grid1").rows[$current].cells[4].innerHTML;
		}
	}
	else if($this.id=="new"){
		var $e=e("editor"),$c=e("cover");
		$c.className="cover";
		$e.style.left=(($c.offsetWidth-$e.offsetWidth)/2)+"px";
		$e.style.top=(($c.offsetHeight-$e.offsetHeight)/2)+"px";
		e("editor_caption").innerHTML="NEW RECORD";
		e("form_pegawai").className=(e("status").value=="Pegawai"?"bd":"hidden");
		e("form_umum").className=(e("status").value=="Pegawai"?"hidden":"bd");
		if(e("status").value=="Pegawai")for(var $i=1;$i<=15;$i++)e("input"+$i).value="";else for(var $i=16;$i<=23;$i++)e("input"+$i).value="";
	}
	else if($this.id=="save"){
		e("cover").className="hidden";
		$temp=e("status").value+"|"+e("cari").value;
		if(e("status").value=="Pegawai")for(var $i=1;$i<=15;$i++)$temp=$temp+"|"+e("input"+$i).value;else for(var $i=16;$i<=23;$i++)$temp=$temp+"|"+e("input"+$i).value;
		e("iframe").src="index.php?control=save&flag="+encodeURIComponent($temp).replace(/%EF%BF%BD/gi,"%20");
	}
	else if($this=="aftersave"){
		$event=$event.split("|");
		e("cari").value=$event[0];
		for(var $i=1;$i<e("grid1").rows.length;$i++){
			e("grid1").rows[1].className="out";
			if($event[2]==""){if(e("grid1").rows[$i].cells[1].innerHTML==$event[1]){e("grid1").rows[$i].className="click";$current=$i;break;}}
			else{if(e("grid1").rows[$i].cells[0].innerHTML==$event[1]){e("grid1").rows[$i].className="click";$current=$i;break;}}
		}
		var $g=e("grid1").rows[$current].offsetTop,$d=e("div1");
		if($g<$d.scrollTop||$g>$d.scrollTop+$d.offsetHeight)$d.scrollTop=$g;
		var $g=e("grid1").rows[$current].offsetTop+e("grid1").rows[$current].offsetHeight,$d=e("div1");
		if($g>$d.scrollTop+$d.offsetHeight||$g<$d.scrollTop)$d.scrollTop=$g-$d.offsetHeight;
	}
	else if($this.id=="delete"){
		var $flag=e("status").value+"|"+e("cari").value+"|"+e("grid1").rows[$current].cells[1].innerHTML+"|delete|"+e("grid1").rows[$current].cells[0].innerHTML+"|"+(e("grid1").rows.length-1);
		if(confirm("Anda yakin akan menghapus?")==true)e("iframe").src="index.php?control=save&flag="+$flag;
	}
	else if($this.id=="report"){
		e("iframe").src="index.php?control=report&flag=report";
		var $e=e("print"),$c=e("cover");
		$c.className="cover";
		$e.style.left=(($c.offsetWidth-$e.offsetWidth)/2)+"px";
//		$e.style.top=(($c.offsetHeight-$e.offsetHeight)/2)+"px";
	}
	else if($this.className!="click"){$this.className=($event.type=="mouseover"?"over":"out");}
	
	$cur[$flag]=$current;
}
//-- navigator ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function f_navigator($this,$event,$flag,$user){
	var $current=$cur[$flag];
	var $div="div"+$flag;
	var $grid="grid"+$flag;
	if($this.id=="first"){
		e($grid).rows[$current].className="out";$current=1;e($grid).rows[$current].className="click";
		var $g=e($grid).rows[$current].offsetTop,$d=e($div);
		if($g<$d.scrollTop||$g>$d.scrollTop+$d.offsetHeight)$d.scrollTop=$g;
	}
	else if($this.id=="previous"){
		if($current==1)return;
		e($grid).rows[$current].className="out";$current--;e($grid).rows[$current].className="click";
		var $g=e($grid).rows[$current].offsetTop,$d=e($div);
		if($g<$d.scrollTop||$g>$d.scrollTop+$d.offsetHeight)$d.scrollTop=$g;
	}
	else if($this.id=="next"){
		if($current==e($grid).rows.length-1)return;
		e($grid).rows[$current].className="out";$current++;e($grid).rows[$current].className="click";
		var $g=e($grid).rows[$current].offsetTop+e($grid).rows[$current].offsetHeight,$d=e($div);
		if($g>$d.scrollTop+$d.offsetHeight||$g<$d.scrollTop)$d.scrollTop=$g-$d.offsetHeight;
	}
	else if($this.id=="last"){
		e($grid).rows[$current].className="out";$current=e($grid).rows.length-1;e($grid).rows[$current].className="click";
		var $g=e($grid).rows[$current].offsetTop+e($grid).rows[$current].offsetHeight,$d=e($div);
		if($g>$d.scrollTop+$d.offsetHeight||$g<$d.scrollTop)$d.scrollTop=$g-$d.offsetHeight;
	}
	else if($event.type=="click"){
		e($grid).rows[$current].className="out";$current=$this.rowIndex;$this.className="click";
		var $g=e($grid).rows[$current].offsetTop,$d=e($div);
		if($g<$d.scrollTop||$g>$d.scrollTop+$d.offsetHeight)$d.scrollTop=$g;
		var $g=e($grid).rows[$current].offsetTop+e($grid).rows[$current].offsetHeight,$d=e($div);
		if($g>$d.scrollTop+$d.offsetHeight||$g<$d.scrollTop)$d.scrollTop=$g-$d.offsetHeight;
	}

	if($user=="dokter")e("iframe").src="index.php?control=query"+($flag+1)+"&flag="+e($grid).rows[$current].cells[1].innerHTML+($flag==2?"|"+e($grid).rows[$current].cells[3].innerHTML:"");
	if($user=="obat")e("iframe").src="index.php?control=query"+($flag+1)+"&flag="+e($grid).rows[$current].cells[0].innerHTML;
	$cur[$flag]=$current;
	if($user=="dokter")$cur[$flag+1]=1;
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------
f_css=function($selector,style){
	if(!document.styleSheets)return;
	if(document.getElementsByTagName("head").length==0)return;
	var stylesheet;
	var $mediatype;
	if(document.styleSheets.length>0){
		for(var $i=0;$i<document.styleSheets.length;$i++){
			if(document.styleSheets[$i].disabled)continue;
			var media=document.styleSheets[$i].media;
			$mediatype=typeof media;
			if($mediatype=="string")if(media==""||media.indexOf("screen")!=-1)styleSheet=document.styleSheets[$i];
			else if($mediatype=="object")if(media.mediaText==""||media.mediaText.indexOf("screen")!=-1)styleSheet=document.styleSheets[$i];
			if(typeof styleSheet!="undefined")break;
		}
	}
	if(typeof styleSheet=="undefined"){
		var styleSheetElement=document.createElement("style");
		styleSheetElement.type="text/css";
		document.getElementsByTagName("head")[0].appendChild(styleSheetElement);
		for(var $i=0;$i<document.styleSheets.length;$i++){
			if(document.styleSheets[$i].disabled)continue;
			styleSheet=document.styleSheets[$i];
		}
		var media=styleSheet.media;
		$mediatype=typeof media;
	}
	if($mediatype=="string"){
		for(var $i=0;$i< styleSheet.rules.length;$i++){
			if(styleSheet.rules[$i].selectorText.toLowerCase()==$selector.toLowerCase()){
				styleSheet.rules[$i].style.cssText=style;
				return;
			}
		}
		styleSheet.addRule($selector,style);
	}
	else if($mediatype=="object"){
		for(var $i=0;$i<styleSheet.cssRules.length;$i++){
			if(styleSheet.cssRules[$i].selectorText.toLowerCase()==$selector.toLowerCase()){
				styleSheet.cssRules[$i].style.cssText=style;
				return;
			}
		}
		styleSheet.insertRule($selector+"{"+style+"}",0);
	}
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------
var $fontb="font:12px trebuchet ms;font-weight:bold";
var $font=$fontb.replace(";font-weight:bold","");

f_css("td","cursor:default");
f_css(".font",$font);
f_css(".fontb",$fontb);
f_css(".click","background-color:#cccccc");
f_css(".over","background-color:#dddddd");
f_css(".out","background-color:");
f_css(".hidden","display:none");
f_css(".top","vertical-align:top;padding:3px");
f_css(".middle","vertical-align:center;padding:5px");
f_css(".center","text-align:center;padding:3px");
f_css(".left","text-align:left;padding:3px");
f_css(".cover","position:fixed;left:0px;top:0px;width:100%;height:100%;background-color:rgba(0,0,0,.1)");
f_css(".bgbox","margin:auto;background-color:#deebfc;border:solid 2px #79bcff;padding:8px;box-shadow:0px 8px 16px 0px rgba(0,0,0,1);border-radius:10px");
f_css(".picbox","margin:auto;box-shadow:0px 10px 16px 0px rgba(0,0,0,.7)");

f_css(".bd","border:solid 1px #79bcff;overflow:hidden");
f_css(".bd1","border:solid 1px #000000;overflow:hidden");
f_css(".button","width:100px");
f_css(".button1","width:70px;border:solid 1px #79bcff;");

f_css(".text","background-color:#ffffff;border:solid 1px #79bcff;width:98%;padding:2px;overflow:hidden");
f_css(".text1","background-color:#ffffff;border:solid 1px #79bcff;padding:2px;overflow:hidden");
f_css(".labell","padding:0px 4px;text-align:left;width:0px;white-space:nowrap");
f_css(".labelr","padding:0px 4px;text-align:right;width:0px;;white-space:nowrap");
f_css(".labelc","padding:0px 4px;text-align:center;width:0px;;white-space:nowrap");
//------------------------------------------------------------------------------------------------------------------------------------------------------------
