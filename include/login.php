<?php
	if($_GET["flag"]=="logout"){
		$_GET["control"]="home";
		$_GET["flag"]="";
		$_SESSION["full_name"]="";
		$_SESSION["id_user"]="";
		$_SESSION["permissions"]="";
		$_SESSION["visits"]="";
		f_action();
	}
	else{
		$flag=explode("|",$_GET["flag"]);
		$q=mysqli_query($GLOBALS["con"],"SELECT * FROM m_user WHERE user='$flag[0]' AND password='$flag[1]'");
		if($h=mysqli_fetch_array($q)){//login berhasil
			mysqli_query($GLOBALS["con"],"UPDATE m_user SET visits=$h[visits]+1,last_visit_date='".date('Y-m-d H:i:s',time())."' WHERE id_user=$h[id_user]");
			if($h['expired_date']<date("Y-m-d H:i:s",time())){//login berhasil tetapi akun sudah kadaluarsa
				echo "<script>alert('Akun anda sudah kadaluarsa. Hubungi Administrator')</script>";
			}
			elseif($h["active"]==0){//login berhasil tetapi akun diblok oleh admin
				echo "<script>alert('Karena alasan tertentu, akun anda diblokir. hubungi Administrator')</script>";
			}
			else{//login sukses
				$_GET["control"]="start";
				$_GET["flag"]="";
				$_SESSION["full_name"]=$h["full_name"];
				$_SESSION["id_user"]=$h["id_user"];
				$_SESSION["permissions"]=$h["permissions"];
				$_SESSION["visits"]=$h["visits"];
				f_action();
			}
		}
		else{//login gagal
			echo "<script>alert('Nama pengguna dan/atau sandi tidak cocok, login gagal .....')</script>";
		}
	}
?>