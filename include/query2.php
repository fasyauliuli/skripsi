<?php
	if(strpos($_GET["control"],"diagnosis")===0){
		$flag=explode("_",$_GET["control"]);
		mysqli_query($GLOBALS["con"],"INSERT INTO t_diagnosis (id_kunjungan,diagnosis) VALUES ($flag[1],$flag[2])");
		$_GET["flag"]=$flag[1];
	}
	
	$grid2="";
	$nomor=1;
	if($_SESSION["permissions"]=="petugas"){
		$date=date("Y-m-d",time());
		$q=mysqli_query($GLOBALS["con"],"SELECT id_kunjungan,t_kunjungan.id_pengunjung,antrian,CONCAT(nama,' (',kelamin,')','<br>',DATE_FORMAT(tanggal_lahir,'%d/%m/%Y'),' (',FLOOR(".
			"TIMESTAMPDIFF(MONTH,tanggal_lahir,CURDATE())/12),' tahun ',TIMESTAMPDIFF(MONTH,tanggal_lahir,CURDATE())%12,' bulan)<br>',pekerjaan) AS nama,".
			"tanggal,m_user.full_name AS petugas,m_user_1.full_name AS dokter FROM t_kunjungan INNER JOIN m_user ON t_kunjungan.petugas=m_user.id_user LEFT JOIN m_user ".
			"AS m_user_1 ON t_kunjungan.dokter=m_user_1.id_user INNER JOIN m_pengunjung ON t_kunjungan.id_pengunjung=m_pengunjung.id_pengunjung ".
			"WHERE tanggal BETWEEN '".date("Y-m-d",time())." 00:00:00' AND '".date("Y-m-d",time())." 23:59:59' ORDER BY antrian");
		while($h=mysqli_fetch_array($q)){
			$grid2=$grid2.
				"<tr class='".($nomor==mysqli_num_rows($q)?"click":"out")."' onmouseover=f_event(this,event,1) onmouseout=f_event(this,event,1) onclick=f_navigator(this,event,2,'petugas')>".
					"<td class='hidden'>$h[id_pengunjung]</td>".
					"<td class='hidden'>$h[id_kunjungan]</td>".
					"<td class='top font bd center'>$h[antrian]</td>".
					"<td class='top font bd'>$h[nama]</td>".
					"<td class='hidden'>$h[tanggal]</td>".
				"</tr>";
			$nomor++;
		}
		$grid2=
			"<table id='grid2' style='border-collapse:collapse;width:100%'>".
				"<tr class='out' style='text-align:center;font-weight:bold'>".
					"<td class='center fontb bd' style='width:25px'>No.</td>".
					"<td class='hidden'>ID Pengunjung</td>".
					"<td class='hidden'>ID Kunjungan</td>".
					"<td class='center fontb bd' style='width:180px'>Nama (Jenis Kelamin)<br>Tanggal Lahir (Usia)<br>Pekerjaan</td>".
					"<td class='hidden'>Tanggal</td>".
				"</tr>".
				"$grid2".
			"</table>";
	}
	elseif($_SESSION["permissions"]=="dokter"){
		$temp="<option value=''></option>";
		$q=mysqli_query($GLOBALS["con"],"SELECT id_diagnosis,diagnosis FROM m_diagnosis ORDER BY diagnosis");
		while($h=mysqli_fetch_array($q)){$temp="$temp<option value='$_GET[flag]_$h[id_diagnosis]'>$h[diagnosis]</option>";}

		$q=mysqli_query($GLOBALS["con"],"SELECT t_diagnosis.id_diagnosis,t_diagnosis.id_kunjungan,t_diagnosis.diagnosis,m_diagnosis.diagnosis AS diagnosis1 FROM t_diagnosis ".
			"INNER JOIN m_diagnosis ON t_diagnosis.diagnosis=m_diagnosis.id_diagnosis WHERE t_diagnosis.id_kunjungan=$_GET[flag]");
		while($h=mysqli_fetch_array($q)){
			if($nomor==1)$_GET["flag"]="$h[id_diagnosis]|$h[diagnosis]";
			$grid2=$grid2.
				"<tr class='".($nomor==1?"click":"out")."' onmouseover=f_event(this,event,2) onmouseout=f_event(this,event,2) onclick=f_navigator(this,event,2,'dokter')>".
					"<td class='top font bd center'>".$nomor++."</td>".
					"<td class='hidden'>$h[id_diagnosis]</td>".
					"<td class='hidden'>$h[id_kunjungan]</td>".
					"<td class='hidden'>$h[diagnosis]</td>".
					"<td class='top font bd'>$h[diagnosis1]</td>".
				"</tr>";
		}
		
		$grid2=
			"<table id='grid2' style='border-collapse:collapse;width:100%'>".
				"<tr class='out' style='text-align:center;font-weight:bold'>".
					"<td class='center fontb bd'>No.</td>".
					"<td class='hidden'>ID Diagnosis</td>".
					"<td class='hidden'>ID Kunjungan</td>".
					"<td class='hidden'>Diagnosis</td>".
					"<td class='center fontb bd'>Diagnosis</td>".
				"</tr>".
				"$grid2".
				"<tr class='out' onmouseover=f_event(this,event,2) onmouseout=f_event(this,event,2)>".
					"<td class='top font bd center'>".$nomor++."</td>".
					"<td class='hidden'></td>".
					"<td class='hidden'></td>".
					"<td class='top font bd'><select id='diagnosis' class='text' onchange=e('iframe').src='index.php?control=diagnosis_'+this.value>$temp</select></td>".
				"</tr>".
			"</table>";
	}
	elseif($_SESSION["permissions"]=="obat"){
		$q=mysqli_query($GLOBALS["con"],"SELECT t_kunjungan.antrian,CONCAT(nama,' (',kelamin,')','<br>',DATE_FORMAT(tanggal_lahir,'%d/%m/%Y'),' (',FLOOR(".
			"TIMESTAMPDIFF(MONTH,tanggal_lahir,CURDATE())/12),' tahun ',TIMESTAMPDIFF(MONTH,tanggal_lahir,CURDATE())%12,' bulan)<br>',pekerjaan) AS nama,m_diagnosis.diagnosis,".
			"m_obat.obat,CONCAT(t_obat.jumlah,' ',m_obat.unit) AS jumlah FROM ((((m_pengunjung INNER JOIN t_kunjungan ON m_pengunjung.id_pengunjung=t_kunjungan.id_pengunjung) ".
			"INNER JOIN t_diagnosis ON t_kunjungan.id_kunjungan=t_diagnosis.id_kunjungan) INNER JOIN t_obat ON t_diagnosis.id_diagnosis=t_obat.id_diagnosis) ".
			"INNER JOIN m_diagnosis ON t_diagnosis.diagnosis=m_diagnosis.id_diagnosis) INNER JOIN m_obat ON t_obat.obat=m_obat.id_obat ".
			"WHERE t_kunjungan.tanggal Between '2016-06-15' AND '2016-06-15 23:59:59' AND m_obat.id_obat=$_GET[flag] ".
			"ORDER BY t_kunjungan.antrian");
		while($h=mysqli_fetch_array($q)){
			$grid2=$grid2.
				"<tr class='".($nomor==1?"click":"out")."' onmouseover=f_event(this,event,2) onmouseout=f_event(this,event,2) onclick=f_navigator(this,event,2,'obat')>".
					"<td class='top font bd center'>".$nomor++."</td>".
					"<td class='top font bd'>$h[nama]</td>".
					"<td class='top font bd'>$h[diagnosis]</td>".
					"<td class='top font bd'>$h[obat]</td>".
					"<td class='top font bd'>$h[jumlah]</td>".
				"</tr>";
		}
		
		$grid2=
			"<table id='grid2' style='border-collapse:collapse;width:100%'>".
				"<tr class='out' style='text-align:center;font-weight:bold'>".
					"<td class='center fontb bd'>No.</td>".
					"<td class='center fontb bd'>Nama<br>Tanggal Lahir (Usia)<br>Jenis Kelamin<br>Pekerjaan</td>".
					"<td class='center fontb bd'>Diagnosis</td>".
					"<td class='center fontb bd'>Obat</td>".
					"<td class='center fontb bd'>Jumlah</td>".
				"</tr>".
				"$grid2".
			"</table>";
	}
	elseif($_SESSION["permissions"]=="inventory"){
		$total=0;
		$q=mysqli_query($GLOBALS["con"],"SELECT DATE_FORMAT(Q.tanggal_,'%d/%m/%Y') AS tanggal,Q.jumlah_ AS jumlah FROM (SELECT DATE_FORMAT(tanggal,'%Y-%m-%d') AS tanggal_,".
			"Sum(-jumlah) AS jumlah_ FROM t_obat INNER JOIN t_diagnosis ON t_obat.id_diagnosis=t_diagnosis.id_diagnosis INNER JOIN t_kunjungan ON ".
			"t_diagnosis.id_kunjungan=t_kunjungan.id_kunjungan WHERE t_obat.obat=$_GET[flag] GROUP BY tanggal_ UNION SELECT DATE_FORMAT(tanggal,'%Y-%m-%d') AS tanggal_,".
			"Sum(t_obat_stock.jumlah) AS jumlah_ FROM t_obat_stock WHERE t_obat_stock.obat=$_GET[flag] GROUP BY t_obat_stock.tanggal) AS Q ORDER BY Q.tanggal_,Q.jumlah_ DESC");
		while($h=mysqli_fetch_array($q)){
			$total=$total+$h["jumlah"];
			$grid2=$grid2.
				"<tr class='".($nomor==1?"click":"out")."' onmouseover=f_event(this,event,2) onmouseout=f_event(this,event,2) onclick=f_navigator(this,event,2,'obat')>".
					"<td class='top font bd center'>".$nomor++."</td>".
					"<td class='top center font bd'>$h[tanggal]</td>".
					"<td class='top center font bd'>".($h["jumlah"]>0?$h["jumlah"]:"-")."</td>".
					"<td class='top center font bd'>".($h["jumlah"]>0?"-":-$h["jumlah"])."</td>".
					"<td class='top center font bd'>$total</td>".
				"</tr>";
		}
		
		$grid2=
			"<table id='grid2' style='border-collapse:collapse;width:100%'>".
				"<tr class='out' style='text-align:center;font-weight:bold'>".
					"<td class='center fontb bd'>No.</td>".
					"<td class='center fontb bd'>Tanggal</td>".
					"<td class='center fontb bd'>Penambahan</td>".
					"<td class='center fontb bd'>Pengurangan</td>".
					"<td class='center fontb bd'>Persediaan</td>".
				"</tr>".
				"$grid2".
			"</table>";
	}
	
	echo "<script>parent.e('div2').innerHTML='".addslashes($grid2)."'</script>";
	include "include/query3.php";
?>
