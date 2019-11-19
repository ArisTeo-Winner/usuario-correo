<?php
	include('encript.php');
	$cliente  = Encrypter::decrypt($_GET['account']);
	$codigo   = Encrypter::decrypt($_GET['code']);
 ?>
<!doctype html>
 
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Desarrollos en PHP - Activacion de Cuenta Via Email</title>
    <link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="stylesheet" href="css/estilo.css" />
	<link rel="stylesheet" href="css/bootstrap.css" />
    <script src="js/jquery-1.8.2.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script>
	$(document).ready(function(){
		// Dar el foco al recuadro del código
		$("#Activacion").focus();	
		// Al hacer click en el botón para guardar
		$("#guarda").click(function()
		{
				var User = new Object();
				User.Codigo     = $('input#Activacion').val();
				User.Id         = $('input#id').val();
				$("#mensaje").append("<div class='modal1'><div class='center1'> <center> <img src='img/gif-load.gif'> Activando Cuenta...</center></div></div>");
				var DatosJson = JSON.stringify(User);
				$.post('ActivaCuenta.php',
					{ 
						user: DatosJson
					},
					function(data, textStatus) {
						$("#"+data.campo+"").focus();
						$("#mensaje").html(data.error_msg);
					}, 
					"json"		
				);
				return false;
		});
	});
    </script>
</head>
<body>

 
 <center>
	<form name="formulario" id="formulario" method="post" action="">
	<table width="50%">
		<tr>
			<td><br/><div id="mensaje"></div></td>
		</tr>
		<tr>
			<td><center>
				<table border=0 class="ventanas" width="70%">
					<tr>
    				  <td colspan="2" class="tabla_ventanas_login" height="10"><legend align="center">::: Activar Cuenta ::: </legend></td>
					</tr>
					<tr><td colspan=2><br/></td></tr>
					<tr>
						<td colspan=2><center>
							<table>
								<tr>
								<td align="right">Codigo de Activacion: </td><td><input type="text" class="caja"  name="Activacion" id="Activacion" />	<input type="hidden" id="id" name="id" value="<?php echo $cliente; ?>" /></td>
								</tr>
								
								<tr><td colspan=2><center><input type="submit" id="guarda" name="guarda" class="btn btn-sm btn-success" value="Activar Cuenta" /></center></td></tr>

							</table>
						</center>
						</td>
					</tr>
					
				   </table>
				</center>
			</td>
		</tr>

	</table>
	</form>
   
 </center>
</body>
</html>