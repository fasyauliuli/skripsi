<?php
	session_start();
	$session=array("full_name","id_user","permissions","visits");
	for($i=0;$i<count($session);$i++)if(isset($_SESSION[$session[$i]])==false)$_SESSION[$session[$i]]="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style="height:100%">
<head>
	<title>Klinik Mekarsari</title>
	<link type="image/x-icon" rel="icon" href="image/index.ico">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="content-script-type" content="text/javascript"/>
	<script type="text/javascript" src="include/klinik.js"></script>
</head>
<body>
<?php
	ini_set('max_execution_time', 300);
	if(function_exists("date_default_timezone_set"))date_default_timezone_set("Asia/Jakarta");
	$get=array("control","flag");for($i=0;$i<count($get);$i++)if(isset($_GET[$get[$i]])==false)$_GET[$get[$i]]="";
	
	$con=mysqli_connect("localhost","root","","klinik");
	$document="";
	f_action();
	mysqli_close($con);
//----------------------------------------------------------------------------------------------------------------------------------------------------------
function f_action(){
	if($_GET["control"]==""){$_SESSION["user"]="";echo "<iframe src='index.php?control=home' style='display:none'></iframe>";}
	elseif($_GET["control"]=="home")include "include/home.php";
	elseif($_GET["control"]=="login")include "include/login.php";
	elseif($_GET["control"]=="start")include "include/start.php";
	elseif($_GET["control"]=="query1")include "include/query1.php";
	elseif($_GET["control"]=="query2")include "include/query2.php";
	elseif($_GET["control"]=="query3")include "include/query3.php";
	elseif(strpos($_GET["control"],"diagnosis")===0){include "include/query2.php";}
	elseif(strpos($_GET["control"],"obat")===0){include "include/query3.php";}
	elseif($_GET["control"]=="save")include "include/save.php";
	elseif($_GET["control"]=="report")include "include/report.php";
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------
function f_alert($alert){echo "<script>alert('".addslashes($alert)."')</script>";}
//----------------------------------------------------------------------------------------------------------------------------------------------------------
function f_range($id,$min,$max,$default,$topvalue){
	$option=($topvalue==""?"":"<option value=$topvalue>&nbsp;</option>");
	for($i=$min;$i<=$max;$i++)$option=$option."<option value=$i".($default==$i?" selected":"").">$i</option>";
	return "<select id='$id' class='text1 font'>$option</select>";
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------
function f_list($id,$list,$default,$topvalue){
	$list=explode("|",$list);
	$option=($topvalue==""?"":"<option value=$topvalue>&nbsp;</option>");
	for($i=0;$i<count($list);$i++)$option=$option."<option value='$list[$i]'".($default==""?"":" selected").">$list[$i]</option>";
	return "<select id='$id' class='text1 font' onchange=f_event(this,event)>$option</select>";
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------
?>
</body>
</html>
