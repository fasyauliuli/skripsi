<?php
	$grid1="";
	$nomor=1;
	if($_SESSION["permissions"]=="petugas"){
		$flag=explode("|",$_GET["flag"]."|||");
		if($flag[2]=="")$flag[2]=1;

		if($_GET["control"]=="start" or $flag[0]=="Pegawai"){
			$q=mysqli_query($GLOBALS["con"],"SELECT * FROM m_pengunjung WHERE pekerjaan='pegawai' AND nama LIKE '%$flag[1]%' ORDER BY nama");
			while($h=mysqli_fetch_array($q)){
				if($nomor==$flag[2])$_GET["flag"]=$h["id_pengunjung"];
				$grid1=$grid1.
					"<tr class='".($nomor==$flag[2]?"click":"out")."' onmouseover=f_event(this,event,1) onmouseout=f_event(this,event,1) onclick=f_navigator(this,event,1,'petugas')>".
						"<td class='top font bd center'>".$nomor++."</td>".
						"<td class='hidden'>$h[id_pengunjung]</td>".
						"<td class='top font bd'>$h[nama]<br>".date("d/m/Y",strtotime($h["tanggal_lahir"]))."<br>$h[kelamin]<br>".date("d/m/Y",strtotime($h["mulai_kerja"]))."<br>$h[nik]</td>".
						"<td class='top font bd'>$h[hp]<br>$h[email]<br>$h[rfid]<br>$h[barcode]</td>".
						"<td class='top font bd'>$h[alamat]</td>".
					"</tr>";
			}
			$grid1=
				"<table id='grid1' style='border-collapse:collapse;width:100%'>".
					"<tr class='out' style='text-align:center;font-weight:bold'>".
						"<td class='center fontb bd'>No.</td>".
						"<td class='hidden'>ID Pengunjung</td>".
						"<td class='center fontb bd' style='width:180px'>Nama<br>Tanggal Lahir<br>Jenis Kelamin<br>Mulai Kerja<br>NIK</td>".
						"<td class='center fontb bd'>Handphone<br>Email<br>RFID<br>Barcode</td>".
						"<td class='center fontb bd'>Alamat</td>".
					"</tr>".
					"$grid1".
				"</table>";
		}
		else{
			$q=mysqli_query($GLOBALS["con"],"SELECT * FROM m_pengunjung WHERE ".($flag[0]=="Pengunjung Umum"?"pekerjaan<>'pegawai' AND ":"")."nama LIKE '%$flag[1]%' ORDER BY nama");
			while($h=mysqli_fetch_array($q)){
				if($nomor==$flag[2])$_GET["flag"]=$h["id_pengunjung"];
				$grid1=$grid1.
					"<tr class='".($nomor==$flag[2]?"click":"out")."' onmouseover=f_event(this,event,1) onmouseout=f_event(this,event,1) onclick=f_navigator(this,event,1,'petugas')>".
						"<td class='top font bd center'>".$nomor++."</td>".
						"<td class='hidden'>$h[id_pengunjung]</td>".
						"<td class='top font bd'>$h[nama]<br>".date("d/m/Y",strtotime($h["tanggal_lahir"]))."<br>$h[kelamin]</td>".
						"<td class='top font bd'>$h[pekerjaan]</td>".
						"<td class='top font bd'>$h[alamat]</td>".
					"</tr>";
			}
			$grid1=
				"<table id='grid1' style='border-collapse:collapse;width:100%'>".
					"<tr class='out' style='text-align:center;font-weight:bold'>".
						"<td class='center fontb bd'>No.</td>".
						"<td class='hidden'>ID Pengunjung</td>".
						"<td class='center fontb bd' style='width:180px'>Nama<br>Tanggal Lahir<br>Jenis Kelamin</td>".
						"<td class='center fontb bd'>Pekerjaan</td>".
						"<td class='center fontb bd'>Alamat</td>".
					"</tr>".
					"$grid1".
				"</table>";
		}
	}
	elseif($_SESSION["permissions"]=="dokter"){
		if($_GET["flag"]=="")$_GET["flag"]=1;
		$q=mysqli_query($GLOBALS["con"],"SELECT id_kunjungan,t_kunjungan.id_pengunjung,antrian,CONCAT(nama,'<br>',DATE_FORMAT(tanggal_lahir,'%d/%m/%Y'),' (',FLOOR(".
			"TIMESTAMPDIFF(MONTH,tanggal_lahir,CURDATE())/12),' tahun ',TIMESTAMPDIFF(MONTH,tanggal_lahir,CURDATE())%12,' bulan)<br>',kelamin,'<br>',pekerjaan) AS nama,".
			"tanggal,m_user.full_name AS petugas,m_user_1.full_name AS dokter FROM t_kunjungan INNER JOIN m_user ON t_kunjungan.petugas=m_user.id_user LEFT JOIN m_user ".
			"AS m_user_1 ON t_kunjungan.dokter=m_user_1.id_user INNER JOIN m_pengunjung ON t_kunjungan.id_pengunjung=m_pengunjung.id_pengunjung ".
			"WHERE tanggal BETWEEN '".date("Y-m-d",time())." 00:00:00' AND '".date("Y-m-d",time())." 23:59:59' ORDER BY antrian");
		while($h=mysqli_fetch_array($q)){
			if($h["antrian"]==$_GET["flag"])$_GET["flag"]=$h["id_kunjungan"];
			$grid1=$grid1.
				"<tr class='".($nomor==$flag[2]?"click":"out")."' onmouseover=f_event(this,event,1) onmouseout=f_event(this,event,1) onclick=f_navigator(this,event,1,'obat')>".
					"<td class='hidden'>$h[id_pengunjung]</td>".
					"<td class='hidden'>$h[id_kunjungan]</td>".
					"<td class='top font bd center'>$h[antrian]</td>".
					"<td class='top font bd'>$h[nama]</td>".
					"<td class='hidden'>$h[tanggal]</td>".
					"<td class='top font bd'>$h[petugas]<br>$h[dokter]</td>".
				"</tr>";
		}
		$grid1=
			"<table id='grid1' style='border-collapse:collapse;width:100%'>".
				"<tr class='out' style='text-align:center;font-weight:bold'>".
					"<td class='center fontb bd' style='width:25px'>No.</td>".
					"<td class='hidden'>ID Pengunjung</td>".
					"<td class='hidden'>ID Kunjungan</td>".
					"<td class='center fontb bd' style='width:180px'>Nama<br>Tanggal Lahir (Usia)<br>Jenis Kelamin<br>Pekerjaan</td>".
					"<td class='hidden'>Tanggal</td>".
					"<td class='center fontb bd'>Petugas<br>Dokter</td>".
				"</tr>".
				"$grid1".
			"</table>";
	}
	elseif($_SESSION["permissions"]=="obat"){
		if($_GET["flag"]=="")$_GET["flag"]=1;
		$q=mysqli_query($GLOBALS["con"],"SELECT m_obat.id_obat,m_obat.obat,Sum(t_obat.jumlah) AS jumlah,m_obat.unit FROM (((t_kunjungan INNER JOIN ".
			"t_diagnosis ON t_kunjungan.id_kunjungan=t_diagnosis.id_kunjungan) INNER JOIN t_obat ON t_diagnosis.id_diagnosis=t_obat.id_diagnosis) INNER JOIN m_diagnosis ON ".
			"t_diagnosis.diagnosis=m_diagnosis.id_diagnosis) INNER JOIN m_obat ON t_obat.obat=m_obat.id_obat ".
			"WHERE t_kunjungan.tanggal Between '2016-06-15' And '2016-06-15 23:59:59' GROUP BY m_obat.obat, m_obat.unit");
		while($h=mysqli_fetch_array($q)){
			$grid1=$grid1.
				"<tr class='".($nomor==1?"click":"out")."' onmouseover=f_event(this,event,1) onmouseout=f_event(this,event,1) onclick=f_navigator(this,event,1,'obat')>".
					"<td class='hidden'>$h[id_obat]</td>".
					"<td class='top font bd center'>".$nomor++."</td>".
					"<td class='top font bd'>$h[obat]</td>".
					"<td class='top font bd'>$h[jumlah]&nbsp;$h[unit]</td>".
				"</tr>";
		}
		$grid1=
			"<table id='grid1' style='border-collapse:collapse;width:100%'>".
				"<tr class='out'>".
					"<td class='hidden'>ID Obat</td>".
					"<td class='center fontb bd' style='width:25px'>No.</td>".
					"<td class='center fontb bd' style='width:100%'>Obat</td>".
					"<td class='center fontb bd'>Jumlah</td>".
				"</tr>".
				"$grid1".
			"</table>";
	}
	elseif($_SESSION["permissions"]=="inventory"){
		if($_GET["flag"]=="")$_GET["flag"]=1;
		$q=mysqli_query($GLOBALS["con"],"SELECT m_obat.id_obat,m_obat.obat,Sum(Query6.total) AS jumlah,m_obat.unit FROM m_obat LEFT JOIN (SELECT t_obat_stock.obat,".
			"Sum(t_obat_stock.jumlah) AS total FROM t_obat_stock GROUP BY t_obat_stock.obat UNION ALL SELECT t_obat.obat,-Sum(jumlah) AS total FROM t_obat GROUP BY t_obat.obat) ".
			"AS Query6 ON m_obat.id_obat=Query6.obat GROUP BY m_obat.id_obat,m_obat.obat,m_obat.unit ");
		while($h=mysqli_fetch_array($q)){
			$grid1=$grid1.
				"<tr class='".($nomor==1?"click":"out")."' onmouseover=f_event(this,event,1) onmouseout=f_event(this,event,1) onclick=f_navigator(this,event,1,'obat')>".
					"<td class='hidden'>$h[id_obat]</td>".
					"<td class='top font bd center'>".$nomor++."</td>".
					"<td class='top font bd'>$h[obat]</td>".
					"<td class='top font bd'>".($h["jumlah"]==""?0:$h["jumlah"])."&nbsp;$h[unit]</td>".
				"</tr>";
		}
		$grid1=
			"<table id='grid1' style='border-collapse:collapse;width:100%'>".
				"<tr class='out'>".
					"<td class='hidden'>ID Obat</td>".
					"<td class='center fontb bd' style='width:25px'>No.</td>".
					"<td class='center fontb bd' style='width:100%'>Obat</td>".
					"<td class='center fontb bd'>Jumlah</td>".
				"</tr>".
				"$grid1".
			"</table>";
	}

	echo "<script>parent.e('div1').innerHTML='".addslashes($grid1)."'</script>";
	include "include/query2.php";
?>
