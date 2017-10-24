<?php
	$report="";
	$nomor=1;
	$flag=explode("|",$_GET["flag"]);
	if($_SESSION["permissions"]=="dokter"){
//		$q=mysqli_query($GLOBALS["con"],"SELECT t_kunjungan.id_kunjungan,t_kunjungan.antrian,CONCAT('<b>',nama,'</b>','<br>',DATE_FORMAT(tanggal_lahir,'%d/%m/%Y'),' (',FLOOR(TIMESTAMPDIFF(MONTH,tanggal_lahir,CURDATE())/12),' tahun ',TIMESTAMPDIFF(MONTH,tanggal_lahir,CURDATE())%12,' bulan)<br>',kelamin,'<br>',pekerjaan) AS nama FROM m_pengunjung INNER JOIN t_kunjungan ON m_pengunjung.id_pengunjung=t_kunjungan.id_pengunjung WHERE t_kunjungan.tanggal Between '".date("Y-m-d",time())."' And '".date("Y-m-d 23:59:59",time())."' ORDER BY t_kunjungan.antrian");
		$q=mysqli_query($GLOBALS["con"],"SELECT t_kunjungan.id_kunjungan,t_kunjungan.antrian,CONCAT('<b>',nama,'</b>','<br>',DATE_FORMAT(tanggal_lahir,'%d/%m/%Y'),' (',FLOOR(TIMESTAMPDIFF(MONTH,tanggal_lahir,CURDATE())/12),' tahun ',TIMESTAMPDIFF(MONTH,tanggal_lahir,CURDATE())%12,' bulan)<br>',kelamin,'<br>',pekerjaan) AS nama FROM m_pengunjung INNER JOIN t_kunjungan ON m_pengunjung.id_pengunjung=t_kunjungan.id_pengunjung WHERE t_kunjungan.tanggal Between '2016-07-20' And '2016-07-20 23:59:59' ORDER BY t_kunjungan.antrian");
		while($h=mysqli_fetch_array($q)){
			$report1="";
			$q1=mysqli_query($GLOBALS["con"],"SELECT m_diagnosis.diagnosis, m_obat.obat,CONCAT(t_obat.jumlah,' ',m_obat.unit) AS jumlah FROM ((t_diagnosis INNER JOIN t_obat ON t_diagnosis.id_diagnosis=t_obat.id_diagnosis) INNER JOIN m_diagnosis ON t_diagnosis.diagnosis=m_diagnosis.id_diagnosis) INNER JOIN m_obat ON t_obat.obat=m_obat.id_obat WHERE t_diagnosis.id_kunjungan=$h[id_kunjungan]");
			while($h1=mysqli_fetch_array($q1)){
				$report1=$report1.
					"<tr>".
						"<td class='left top font' style='width:200px;padding:0px 5px'>$h1[diagnosis]</td>".
						"<td class='left top font' style='width:200px;padding:0px 5px'>$h1[obat]</td>".
						"<td class='left top font' style='width:100px;padding:0px 5px'>$h1[jumlah]</td>".
					"</tr>";
			}
			$report1="<table style='border-collapse:collapse'>$report1</table>";
			$report=$report.
				"<tr>".
					"<td class='center top font bd1'>".$nomor++."</td>".
					"<td class='left top font bd1'>$h[nama]</td>".
					"<td class='left top font bd1'>$report1</td>".
				"</tr>";
		}
		$report=
			"<button id='printreport' class='button1 fontb' onclick=f_event(this,event,0)>Print</button>".
			"<button id='closereport' class='button1 fontb' onclick=f_event(this,event,0)>Close</button>".
			"<div id='print0' class='center bd' style='height:600px;overflow-y:scroll'>".
				"<table id='print1' style='border-collapse:collapse;width:100%'>".
					"<tr><td colspan=3 class='center middle fontb' style='font-size:14px'>LAPORAN HARIAN KUNJUNGAN PASIEN KLINIK PT. MUS<BR>tanggal: ".date("d/m/Y",time())."<br><br></td></tr>".
					"<tr>".
						"<td class='center middle fontb bd1'>No.</td>".
						"<td class='center middle fontb bd1'>Nama</td>".
						"<td class='left top fontb bd1'>".
							"<table>".
								"<tr>".
									"<td class='left top fontb' style='width:200px'>Diagnosis</td>".
									"<td class='left top fontb' style='width:200px'>Obat</td>".
									"<td class='left top fontb' style='width:100px'>Jumlah</td>".
								"</tr>".
							"</table>".
						"</td>".
					"</tr>".
					"$report".
				"</table><br>".
			"</div>";
	}
	echo "<script>parent.e('print').innerHTML='".addslashes($report)."'</script>";
?>
