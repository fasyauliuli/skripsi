<?php
	$document= 
		"<div class='bgbox' style='width:900px'>".
			"<table class='fontb' style='width:100%;border-collapse:collapse'>".
				"<tr>".
					"<td style='width:230px'>".
						"<table style='border-collapse:collapse'>".
							"<tr><td class='labelr font'>User:</td><td>$_SESSION[full_name]</td></tr>".
							//"<tr><td class='labelr font'>Start:</td><td>".date("d/m/Y H:i:s",time())."</td></tr>".
							//"<tr><td class='labelr font'>Visits:</td><td>$_SESSION[visits]</td></tr>".
							//"<tr><td class='labelr font'>Duration:</td><td id='duration'></td></tr>".
							"<tr><td colspan=2><button id='logout' class='button1 fontb' onclick=f_event(this,event,0)>Logout</button></td></tr>".
						"</table>".
					"</td>".
					"<td class='center' style='padding:0px 0px 8px'><img class='picbox' src='image/logo login.png' style='height:90px'></td>".
					"<td class='center' style='width:230px'>".($_SESSION["permissions"]!="dokter"?"":"<button id='report' class='button1 fontb' onclick=f_event(this,event,0)>Report</button>")."</td>".
				"</tr>".
			"</table>".
			"<div id='form'></div>".
		"</div>";

	echo "<script>parent.e('body').innerHTML='".addslashes($document)."';</script>";
		
	if($_SESSION["permissions"]=="petugas"){
		$form=
			"<table style='border-collapse:collapse'>".
				"<tr>".
					"<td class='middle fontb bd'>".
						"Daftar Pengunjung:&nbsp;".
						f_list("status","Pegawai|Pengunjung Umum|Tampilkan Semua","","").
						"<span style='float:right'>Cari:&nbsp;<input id='cari' type='text' class='text font' style='width:200px' onkeyup=f_event(this,event,1)></span>".
					"</td>".
					"<td class='middle fontb bd'>Daftar Antrian:</td>".
				"</tr>".
				"<tr>".
					"<td class='top bd'><div id='div1' style='width:600px;height:450px;overflow-y:scroll'></div></td>".
					"<td class='top bd' style='width:100%'><div id='div2' style='height:450px;overflow-y:scroll'></div></td>".
				"</tr>".
				"<tr>".
					"<td class='center top bd'>".
						"<button id='delete' class='button1 fontb' onclick=f_event(this,event,1) title='Delete selected record'>x Del</button>&nbsp;&nbsp;".
						"<button id='first' class='button1 fontb' onclick=f_navigator(this,event,1,'petugas') title='Move to first record'><< First</button>".
						"<button id='previous' class='button1 fontb' onclick=f_navigator(this,event,1,'petugas') title='Move to previous record'>< Prev</button>".
						"<button id='next' class='button1 fontb' onclick=f_navigator(this,event,1,'petugas') title='Move to next record'>Next ></button>".
						"<button id='last' class='button1 fontb' onclick=f_navigator(this,event,1,'petugas') title='Move to last record'>Last >></button>&nbsp;&nbsp;".
						"<button id='edit' class='button1 fontb' onclick=f_event(this,event,1) title='Edit selected record'>Edit !</button>&nbsp;&nbsp;".
						"<button id='new' class='button1 fontb' onclick=f_event(this,event,1) title='New record'>New +</button>".
					"</td>".
					"<td class='center top bd'>".
						"<button id='delete' class='button1 fontb' onclick=f_navigator(this,event,2) title='Delete selected record'>x Del</button>".
//						"<button id='edit' class='button1 fontb' onclick=f_navigator(this,event,2) title='Edit selected record'>Detail !</button>".
						"<button id='daftar' class='button1 fontb' onclick=f_event(this,event,1) title='New record'>Daftar +</button>".
					"</td>".
				"</tr>".
			"</table>".
			"<div class='hidden' id='cover'>".
				"<div id='editor' class='bgbox' style='position:absolute;width:500px'>".
					"<div id='editor_caption' colspan=2 class='center fontb' style='padding-bottom:10px'></div>".
					"<table id='form_pegawai' class='bd' style='width:100%;padding:5px'>".
						"<tr class='hidden'><td class='labelr font'>ID Pengunjung:</td><td><input id='input1' type='text' class='text font'></td></tr>".
						"<tr><td class='labelr font'>Nama:</td><td><input id='input2' type='text' class='text font'></td></tr>".
						"<tr>".
							"<td class='labelr font'>Tanggal Lahir:</td>".
							"<td class='font'>".
								f_range("input3",1,31,0,0)."&nbsp;".
								f_range("input4",1,12,0,0)."&nbsp;".
								f_range("input5",1900,date("Y",time()),0,0).
								"&nbsp;(dd/mm/yyyy)".
							"</td>".
						"</tr>".
						"<tr><td class='labelr font'>Jenis Kelamin:</td><td>".f_list("input6","Pria|Wanita","","")."</td></tr>".
						"<tr>".
							"<td class='labelr font'>Mulai Kerja:</td>".
							"<td class='font'>".
								f_range("input7",1,31,0,0)."&nbsp;".
								f_range("input8",1,12,0,0)."&nbsp;".
								f_range("input9",1900,date("Y",time()),0,0).
								"&nbsp;(dd/mm/yyyy)".
							"</td>".
						"</tr>".
						"<tr><td class='labelr font'>NIK:</td><td><input id='input10' type='text' class='text font'></td></tr>".
						"<tr><td class='labelr font'>Handphone:</td><td><input id='input11' type='text' class='text font'></td></tr>".
						"<tr><td class='labelr font'>Email:</td><td><input id='input12' type='text' class='text font'></td></tr>".
						"<tr><td class='labelr font'>RFID:</td><td><input id='input13' type='text' class='text font'></td></tr>".
						"<tr><td class='labelr font'>Barcode:</td><td><input id='input14' type='text' class='text font'></td></tr>".
						"<tr><td class='labelr font top'>Alamat:</td><td><textarea id='input15' class='text font' style='height:50px;resize:none'></textarea></td></tr>".
					"</table>".
					"<table id='form_umum' class='hidden' style='width:100%;padding:5px'>".
						"<tr class='hidden'><td class='labelr font'>ID Pengunjung:</td><td><input id='input16' type='text' class='text font'></td></tr>".
						"<tr><td class='labelr font'>Nama:</td><td><input id='input17' type='text' class='text font'></td></tr>".
						"<tr>".
							"<td class='labelr font'>Tanggal Lahir:</td>".
							"<td class='font'>".
								f_range("input18",1,31,0,0)."&nbsp;".
								f_range("input19",1,12,0,0)."&nbsp;".
								f_range("input20",1900,date("Y",time()),0,0).
								"&nbsp;(dd/mm/yyyy)".
							"</td>".
						"</tr>".
						"<tr><td class='labelr font'>Jenis Kelamin:</td><td>".f_list("input21","Pria|Wanita","","")."</td></tr>".
						"<tr><td class='labelr font'>Pekerjaan:</td><td>".f_list("input22","Pegawai Negeri|Pegawai Swasta|Pelajar/Mahasiswa|Wiraswasta","","")."</td></tr>".
						"<tr><td class='labelr font top'>Alamat:</td><td><textarea id='input23' class='text font' style='height:50px;resize:none'></textarea></td></tr>".
					"</table>".
					"<div colspan=2 class='center' style='padding-top:10px'>".
						"<button id='cancel' class='button fontb' onclick=f_event(this,event,1)>Cancel</button>".
						"<button id='save' class='button fontb' onclick=f_event(this,event,1)>Save</button>".
					"</div>".
				"</div>".
			"</div>";
	}
	elseif($_SESSION["permissions"]=="dokter"){
		$form=
			"<table style='border-collapse:collapse'>".
				"<tr>".
					"<td class='middle fontb bd'>".
						"Tanggal:&nbsp;".
							f_range("input18",1,31,date("d",time()),0)."&nbsp;".
							f_range("input19",1,12,date("m",time()),"")."&nbsp;".
							f_range("input20",2000,date("Y",time()),date("Y",time()),"").
							"&nbsp;(dd/mm/yyyy)".
					"</td>".
					"<td class='middle fontb bd'>Diagnosis:</td>".
					"<td class='middle fontb bd'>Obat:</td>".
				"</tr>".
				"<tr>".
					"<td class='top bd'><div id='div1' style='width:400px;height:450px;overflow-y:scroll'></div></td>".
					"<td class='top bd'><div id='div2' style='width:200px;height:450px;overflow-y:scroll'></div></td>".
					"<td class='top bd' style='width:100%'><div id='div3' style='height:450px;overflow-y:scroll'></div></td>".
				"</tr>".
				"<tr>".
					"<td class='center top bd'>".
						"<button id='first' class='button1 fontb' onclick=f_navigator(this,event,1,'dokter') title='Move to first record'><< First</button>".
						"<button id='previous' class='button1 fontb' onclick=f_navigator(this,event,1,'dokter') title='Move to previous record'>< Prev</button>".
						"<button id='next' class='button1 fontb' onclick=f_navigator(this,event,1,'dokter') title='Move to next record'>Next ></button>".
						"<button id='last' class='button1 fontb' onclick=f_navigator(this,event,1,'dokter') title='Move to last record'>Last >></button>&nbsp;&nbsp;".
					"</td>".
					"<td class='center top bd'>".
						"<button id='delete' class='button1 fontb' onclick=f_navigator(this,event,2) title='Delete selected record'>x Del</button>".
						"<button id='ok1' class='button1 fontb' onclick=f_event(this,event,2) title='New record'>Ok</button>".
					"</td>".
					"<td class='center top bd'>".
						"<button id='delete' class='button1 fontb' onclick=f_navigator(this,event,3) title='Delete selected record'>x Del</button>".
						"<button id='ok2' class='button1 fontb' onclick=f_event(this,event,3) title='New record'>Ok</button>".
					"</td>".
				"</tr>".
			"</table>".
			"<div class='hidden' id='cover'>".
				"<div id='print' class='bgbox' style='position:absolute;width:850px'>".
				"</div>".
			"</div>";
	}
	elseif($_SESSION["permissions"]=="obat"){
		$form=
			"<table style='border-collapse:collapse'>".
				"<tr>".
					"<td class='middle fontb bd'>".
						"Transaksi Obat Tanggal:&nbsp;".
							f_range("input18",1,31,date("d",time()),0)."&nbsp;".
							f_range("input19",1,12,date("m",time()),"")."&nbsp;".
							f_range("input20",2000,date("Y",time()),date("Y",time()),"").
					"</td>".
					"<td class='middle fontb bd'>Detail Transaksi:</td>".
				"</tr>".
				"<tr>".
					"<td class='top bd'><div id='div1' style='width:300px;height:450px;overflow-y:scroll'></div></td>".
					"<td class='top bd' style='width:100%'><div id='div2' style='height:450px;overflow-y:scroll'></div></td>".
				"</tr>".
				"<tr>".
					"<td class='center top bd'>".
						"<button id='first' class='button1 fontb' onclick=f_navigator(this,event,1,'obat') title='Move to first record'><< First</button>".
						"<button id='previous' class='button1 fontb' onclick=f_navigator(this,event,1,'obat') title='Move to previous record'>< Prev</button>".
						"<button id='next' class='button1 fontb' onclick=f_navigator(this,event,1,'obat') title='Move to next record'>Next ></button>".
						"<button id='last' class='button1 fontb' onclick=f_navigator(this,event,1,'obat') title='Move to last record'>Last >></button>".
					"</td>".
					"<td class='center top bd'>".
						"<button id='delete' class='button1 fontb' onclick=f_navigator(this,event,2) title='Delete selected record'>x Del</button>".
//						"<button id='edit' class='button1 fontb' onclick=f_navigator(this,event,2) title='Edit selected record'>Detail !</button>".
						"<button id='daftar' class='button1 fontb' onclick=f_event(this,event,1) title='New record'>Daftar +</button>".
					"</td>".
				"</tr>".
			"</table>";
	}
	elseif($_SESSION["permissions"]=="inventory"){
		$form=
			"<table style='border-collapse:collapse'>".
				"<tr>".
					"<td class='middle fontb bd'>".
						"Transaksi Obat Tanggal:&nbsp;".
							f_range("input18",1,31,date("d",time()),0)."&nbsp;".
							f_range("input19",1,12,date("m",time()),"")."&nbsp;".
							f_range("input20",2000,date("Y",time()),date("Y",time()),"").
					"</td>".
					"<td class='middle fontb bd'>Detail Transaksi:</td>".
				"</tr>".
				"<tr>".
					"<td class='top bd'><div id='div1' style='width:300px;height:450px;overflow-y:scroll'></div></td>".
					"<td class='top bd' style='width:100%'><div id='div2' style='height:450px;overflow-y:scroll'></div></td>".
				"</tr>".
				"<tr>".
					"<td class='center top bd'>".
						"<button id='first' class='button1 fontb' onclick=f_navigator(this,event,1,'inventory') title='Move to first record'><< First</button>".
						"<button id='previous' class='button1 fontb' onclick=f_navigator(this,event,1,'inventory') title='Move to previous record'>< Prev</button>".
						"<button id='next' class='button1 fontb' onclick=f_navigator(this,event,1,'inventory') title='Move to next record'>Next ></button>".
						"<button id='last' class='button1 fontb' onclick=f_navigator(this,event,1,'inventory') title='Move to last record'>Last >></button>".
					"</td>".
					"<td class='center top bd'>".
						"<button id='delete' class='button1 fontb' onclick=f_navigator(this,event,2) title='Delete selected record'>x Del</button>".
//						"<button id='edit' class='button1 fontb' onclick=f_navigator(this,event,2) title='Edit selected record'>Detail !</button>".
						"<button id='daftar' class='button1 fontb' onclick=f_event(this,event,1) title='New record'>Daftar +</button>".
					"</td>".
				"</tr>".
			"</table>";
	}
			
	echo "<script>parent.e('form').innerHTML='".addslashes($form)."'</script>";
	include "include/query1.php";
//----------------------------------------------------------------------------------------------------------------------------------------------------------
?>
