<?php
	date_default_timezone_set('America/Mexico_City');
	include('class.consultas.php');
	include('DataCorreo.php');
	include('encript.php');
	$ObjetoJson 		= json_decode($_POST['user']);
	$Json       		= new Json;
	/*Array de response*/
	 $response = array (
			"campo"     => "",
            "error_msg" => ""
    );
	if($ObjetoJson->Nombre==""){
		$response["campo"]     = "Nombre";
		$response["error_msg"]   = "<div class='alert alert-danger text-center'>El Campo Nombre Esta Vacio</div>";
		echo json_encode($response);
	}else if($ObjetoJson->Apellidos==""){
		$response["campo"]     = "Apellidos";
		$response["error_msg"]   = "<div class='alert alert-danger text-center'>El Campo Apellidos Esta Vacio</div>";
		echo json_encode($response);
	}else if($ObjetoJson->Email==""){
		$response["campo"]       = "Email";
		$response["error_msg"]   = "<div class='alert alert-danger text-center'>El Campo Email Esta Vacio</div>";
		echo json_encode($response);
	}else if($Json->verificaremail($ObjetoJson->Email)==false){
			$response["campo"]       = "Email";
			$response["error_msg"]   = "<div class='alert alert-danger text-center'>El Email es Incorrecto</div>";
			echo json_encode($response);
	}else if($ObjetoJson->Edad==""){
		$response["campo"]     = "Edad";
		$response["error_msg"]   = "<div class='alert alert-danger text-center'>El Campo Edad Esta Vacio</div>";
		echo json_encode($response);
	}else{
			$JsonVerificaMail            = $Json->JsonVerificaMail($ObjetoJson->Email);
			if($JsonVerificaMail==true){
				$response["error_msg"]   = "<div class='alert alert-danger text-center'>El Email ".$ObjetoJson->Email." Ya esta en Uso</div>";
				echo json_encode($response);
			}else{
				$AgregaObjetoJson   	     = $Json->AddObjetoJson($ObjetoJson);
				if($AgregaObjetoJson==true){
					$IdCliente               = 0;
					$CodigoActivacion        = "";
					$UltimoIdJson            = $Json->JsonUltimoId();
					foreach($UltimoIdJson as $UltimoId){
						$IdCliente           = $UltimoId["ID"];
					}
					/*Generamos coreo*/
					/*Generamos Codigo Activacion*/
					$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
					for($i=0;$i<12;$i++) {
					    $CodigoActivacion .= substr($str,rand(0,62),1);
					}
					/*Generamos Password*/
					$newPass = '';
					$pattern = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
					for ($i = 0; $i < 15; $i++) {
						$newPass .= $pattern[rand(0, 53)];
					}
					$JsonAsignaPassword      = $Json->JsonGuardaPassword(Encrypter::encrypt($newPass), $IdCliente);
					$JsonAddActivacion       = $Json->AddActivacion($IdCliente,$CodigoActivacion, date('Y-m-j H:i:s'));
					$urlActivacion           = 'http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['REQUEST_URI'],0,-10).'AccountActive.php?account='.Encrypter::encrypt($IdCliente).'&code='.Encrypter::encrypt($CodigoActivacion);
					/*Enviamos Email*/
					$html                   = '<html>';
                    $html                   = $html.'<head>';
                    $html                   = $html.'<title>:TOKEN:</title>';
                    $html                   = $html.'<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">';
                    $html                   = $html.'<meta name="GENERATOR" content="Quanta Plus KDE">';
                    $html                   = $html.'<style type="text/css">';
                    $html                   = $html.'.Imprime {';
                    $html                   = $html.' font-family:Courier New; font-size:14.4px; } @page{ margin: 0;}';
                    $html                   = $html.' hr {border: 1px dashed grey; height: 0; width: 100%;}';
                    $html                   = $html.'</style>';
                    $html                   = $html.'</head>';
                    $html                   = $html.'<body> ';
                    $html                   = $html.'<hr/>Bienvenid@: <strong>'.$ObjetoJson->Nombre.' '.$ObjetoJson->Apellidos.'</strong> <br/>';
                    $html                   = $html.'Le Enviamos el Codigo de Activacion, para que Active su Cuenta<br/>';
                    $html                   = $html.'Codigo de Activacion: <strong>'.$CodigoActivacion.'</strong><br/>';
					$html                   = $html.'Usuario: '.$ObjetoJson->Email.'<br/>';
					$html                   = $html.'Password: '.$newPass.'<br/>';
                    $html                   = $html.'Liga de Activacion: ';
					$html                   = $html."<a href='".$urlActivacion."'>".$urlActivacion."</a>";
					$html 					= $html.'<br/><br/>----------Desarrollos en PHP----------<br/><br/>';
                    $html                   = $html.'</body>';
                    $html                   = $html.'</html>';

                    $para                   = $ObjetoJson->Email;
                    $titulo                 = "Desarrollos en PHP - Activar Cuenta";
                    $StatusMail             = enviarMail($para,$titulo,$html);
					
					$response["error_msg"]   = "<div class='alert alert-success text-center'>Informacion Almacenada Correctamente, Verifica tu Bandeja de Entrada para Activar tu cuenta</div>";
					echo json_encode($response);
				}else{
					$response["error_msg"]   = "<div class='alert alert-danger text-center'>Ups Hubo Un error Intente de Nuevo</div>";
					echo json_encode($response);
				}
			}
			
			
		
	}
	/**/
?>  