<?php
	if(strpos($_GET["control"],"obat")===0){//obat_24697_267_22_2
		$flag=explode("_",$_GET["control"]);
		mysqli_query($GLOBALS["con"],"INSERT INTO t_obat (id_diagnosis,obat,jumlah) VALUES ($flag[1],$flag[3],$flag[4])");
		$_GET["flag"]="$flag[1]|$flag[2]";
	}

	$grid3="";
	$nomor=1;
	$flag=explode("|",$_GET["flag"]);
	if($_SESSION["permissions"]=="dokter"){
		$q=mysqli_query($GLOBALS["con"],"SELECT t_obat.id_obat,t_obat.id_diagnosis,m_obat.obat,t_obat.jumlah FROM t_obat INNER JOIN m_obat ON t_obat.obat=m_obat.id_obat WHERE id_diagnosis=$flag[0]");
		while($h=mysqli_fetch_array($q)){
			$grid3=$grid3.
				"<tr class='".($nomor==1?"click":"out")."' onmouseover=f_event(this,event,2) onmouseout=f_event(this,event,2) onclick=f_navigator(this,event,3,'dokter')>".
					"<td class='top font bd center'>".$nomor++."</td>".
					"<td class='hidden'>$h[id_obat]</td>".
					"<td class='hidden'>$h[id_diagnosis]</td>".
					"<td class='top font bd'>$h[obat]</td>".
					"<td class='top font bd' style='text-align:right'>$h[jumlah]</td>".
				"</tr>";
		}

		$temp="<option value=''></option>";
		$q=mysqli_query($GLOBALS["con"],"SELECT m_diagnosis_obat.id_obat,m_obat.obat FROM m_diagnosis_obat INNER JOIN m_obat ON m_diagnosis_obat.id_obat=m_obat.id_obat WHERE m_diagnosis_obat.id_diagnosis=$flag[1] ORDER BY obat");
		while($h=mysqli_fetch_array($q)){$temp="$temp<option value='$flag[0]_$flag[1]_$h[id_obat]'>$h[obat]</option>";}
		$onchange="onchange=if(e('obat').value!=''&&e('jumlah').value!='')e('iframe').src='index.php?control=obat_'+e('obat').value+'_'+e('jumlah').value";

		$grid3=
			"<table id='grid2' style='border-collapse:collapse;width:100%'>".
				"<tr class='out' style='text-align:center;font-weight:bold'>".
					"<td class='center fontb bd'>No.</td>".
					"<td class='hidden'>ID Obat</td>".
					"<td class='hidden'>ID Diagnosis</td>".
					"<td class='center fontb bd'>Obat</td>".
					"<td class='center fontb bd'>Jumlah</td>".
				"</tr>".
				"$grid3".
				"<tr class='out' onmouseover=f_event(this,event,2) onmouseout=f_event(this,event,2)>".
					"<td class='top font bd center'>".$nomor++."</td>".
					"<td class='hidden'></td>".
					"<td class='hidden'></td>".
					"<td class='top font bd'><select id='obat' class='text' $onchange>$temp</select></td>".
					"<td class='top font bd'><input id='jumlah' type='text' class='text' $onchange></td>".
				"</tr>".
			"</table>";
	}
	echo "<script>parent.e('div3').innerHTML='".addslashes($grid3)."'</script>";
?>
