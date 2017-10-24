<?php
	$keyup="onkeyup={e('login').disabled=(e('user').value!=''&&e('password').value!=''?'':'disabled');if(event.keyCode==13&&e('login').disabled=='')e('login').click()}";
	$document= 
		"<div class='bgbox' style='width:900px'>".
			"<table style='border-collapse:collapse;width:100%'>".
				"<tr><td class='center' style='padding:0px 0px 15px'><img class='picbox' src='image/logo home.png' style='width:100%'></td></tr>".
				"<tr>".
					"<td class='bd' style='padding:40px 0px'>".
						"<table style='width:400px;padding:5px;margin:auto'>".
							"<tr><td class='labelr font'>User Name:</td><td><input id='user' type='text' class='text font' autocomplete='off' $keyup></td></tr>".
							"<tr><td class='labelr font'>Password:</td><td><input id='password' type='password' class='text font' $keyup></td></tr>".
							"<tr><td colspan=2 style='padding-top:20px;text-align:right'><button id='login' class='button1 fontb' disabled onclick=f_event(this,event)>Login</button></td></tr>".
						"</table>".
					"</td>".
				"</tr>".
			"</table>".
		"</div>";
		
	echo "<script>parent.document.body.innerHTML='".addslashes("<div id='body'>$document</div><iframe id='iframe' style='display:none'></iframe>")."';</script>";
?>
