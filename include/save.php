<?php
	$data=explode("|",urldecode($_GET["flag"]));
	if($data[3]=="daftar"){//pendaftaran pengujung -> ||3047|daftar
		$max=1;
		$q=mysqli_query($GLOBALS["con"],"SELECT MAX(antrian) FROM t_kunjungan WHERE tanggal BETWEEN '".date("Y-m-d 0:0:0",time())."' AND DATE_SUB(DATE_ADD('".date("Y-m-d 0:0:0",time())."',INTERVAL 1 DAY),INTERVAL 1 SECOND)");
		while($h=mysqli_fetch_array($q)){$max=($h[0]==""?0:$h[0])+1;}
		mysqli_query($GLOBALS["con"],"INSERT INTO t_kunjungan (id_pengunjung,tanggal,antrian,petugas) VALUES ($data[2],'".date("Y-m-d H:i:s",time())."',$max,$_SESSION[id_user])");
		$_GET["flag"]=$data[2];
		include "include/query2.php";
		return;
	}
	elseif($data[3]=="delete"){//delete -> Pegawai|x|3057|delete|3|3
		mysqli_query($GLOBALS["con"],"DELETE FROM m_pengunjung WHERE id_pengunjung='$data[2]'");
		$temp=($data[4]==$data[5]?$data[4]-1:$data[4]);
		$_GET["flag"]="$data[0]|$data[1]|$temp";
	}
	elseif($data[2]<>""){//edit
		if($data[0]=="Pegawai"){//Pegawai|z|3047|Abram Eliezer Ginting|26|2|1996|Pria|26|8|2007|199602262007081001|08416967444|abramelie@mekarsari.com|1062E79157A87387ABCB2DE9|00041262055929|Jl. Bunga Mawar no. 86, Medan Selayang, Medan
			mysqli_query($GLOBALS["con"],"UPDATE m_pengunjung SET nama='$data[3]',tanggal_lahir='$data[6]-$data[5]-$data[4]',".
				"kelamin='$data[7]',mulai_kerja='$data[10]-$data[9]-$data[8]',nik='$data[11]',hp='$data[12]',email='$data[13]',".
				"rfid='$data[14]',barcode='$data[15]',alamat='$data[16]' WHERE id_pengunjung=$data[2]");
		}
		else{//z|Pengunjung Umum|943|Abdul Hafidz Harada Laily|9|5|1998|Pria|Pelajar/Mahasiswa|Jl.Raya Penggilingan Kp.Pedaengan. RT.013/008 Jakarta Timur
			mysqli_query($GLOBALS["con"],"UPDATE m_pengunjung SET nama='$data[3]',tanggal_lahir='$data[6]-$data[5]-$data[4]',".
				"kelamin='$data[7]',pekerjaan='$data[8]',alamat='$data[9]' WHERE id_pengunjung=$data[2]");
		}
		$_GET["flag"]=$data[0]."|".(stristr($data[3],$data[1])==""?"":$data[1]);
	}
	elseif($data[2]==""){//new
		if($data[0]=="Pegawai"){
			mysqli_query($GLOBALS["con"],"INSERT INTO m_pengunjung (nama,tanggal_lahir,kelamin,mulai_kerja,nik,hp,email,rfid,barcode,alamat,pekerjaan) VALUES ('$data[3]',".
				"'$data[6]-$data[5]-$data[4]','$data[7]','$data[10]-$data[9]-$data[8]','$data[11]','$data[12]','$data[13]','$data[14]','$data[15]','$data[16]','pegawai')");
		}
		else{
			mysqli_query($GLOBALS["con"],"INSERT INTO m_pengunjung (nama,tanggal_lahir,kelamin,pekerjaan,alamat) ".
				"VALUES ('$data[3]','$data[6]-$data[5]-$data[4]','$data[7]','$data[8]','$data[9]')");
		}
		$q=mysqli_query($GLOBALS["con"],"SELECT id_pengunjung FROM m_pengunjung ORDER BY id_pengunjung DESC LIMIT 0,1");
		while($h=mysqli_fetch_array($q)){$data[2]=$h["id_pengunjung"];}

		$_GET["flag"]=$data[0]."|".(stristr($data[3],$data[1])!=""?$data[1]:"");
	}

	include "include/query1.php";
	if($data[3]=="delete")echo "<script>parent.f_event('aftersave','$data[1]|$temp|delete')</script>";
	else echo "<script>parent.f_event('aftersave','".(stristr($data[3],$data[1])!=""?$data[1]:"")."|$data[2]|')</script>";
?>