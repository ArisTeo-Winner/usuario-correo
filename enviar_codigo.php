<?php
	session_start();
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
	if($ObjetoJson->Email==""){
		$response["campo"]     = "Email";
		$response["error_msg"]   = "<div class='alert alert-danger text-center'>Teclea un Email</div>";
		echo json_encode($response);
	}else if($Json->verificaremail($ObjetoJson->Email)==false){
			$response["campo"]       = "Email";
			$response["error_msg"]   = "<div class='alert alert-danger text-center'>El Email es Incorrecto</div>";
			echo json_encode($response);
	}else{
			
			/*Verificamos que exista el email*/
			$JsonVerificaMail    = $Json->JsonVerificaMail($ObjetoJson->Email);
			$Id                  = 0;
			$NombreCompleto      = "";
			if($JsonVerificaMail==true){
				$JsonBuscarCliente  = $Json->JsonBuscarCliente($ObjetoJson->Email);
				foreach ($JsonBuscarCliente as $key => $value) {
						 $Id          		= $value["id"];
						 $NombreCompleto    = $value["nombre"]." ".$value["apellidos"];
				}
				$JsonCode = $Json->JsonBuscoCodigoActivacion($Id);
				$codeNew  = "";
				$Estatus  = "0";

				if(!empty($JsonCode)){
					foreach ($JsonCode as $key => $value) {
						# code...
						$codeNew  		 = $value["codigo_activacion"];
						$Estatus         = $value["estatus"];
					}
				}else{
					/*Generamos Codigo Activacion*/
					$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
					for($i=0;$i<12;$i++) {
					    $codeNew .= substr($str,rand(0,62),1);
					}
					$JsonAddActivacion       = $Json->AddActivacion($Id,$codeNew, date('Y-m-j H:i:s'));
				}
				if($Estatus=="1"){
					$response["error_msg"]   = "<div class='alert alert-danger text-center'>Error: La Cuenta Ya Fue Activada</div>";
					echo json_encode($response);
				}else{
					/*Enviamos Email*/
					$urlActivacion          = 'http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['REQUEST_URI'],0,-17).'AccountActive.php?account='.Encrypter::encrypt($Id).'&code='.Encrypter::encrypt($codeNew);
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
                    $html                   = $html.'<hr/>Bienvenid@: <strong>'.$NombreCompleto.'</strong> <br/>';
                    $html                   = $html.'Le Enviamos el Codigo de Activacion, para que Active su Cuenta<br/>';
                    $html                   = $html.'Codigo de Activacion: <strong>'.$codeNew.'</strong><br/>';
                    $html                   = $html.'Liga de Activacion: ';
					$html                   = $html."<a href='".$urlActivacion."'>".$urlActivacion."</a>";
					$html 					= $html.'<br/><br/>----------Desarrollos en PHP----------<br/><br/>';
                    $html                   = $html.'</body>';
                    $html                   = $html.'</html>';

                    $para                   = $ObjetoJson->Email;
                    $titulo                 = "Desarrollos en PHP - Activar Cuenta";
                    $StatusMail             = enviarMail($para,$titulo,$html);
					
					$response["error_msg"]   = "<div class='alert alert-success text-center'>Le Enviamos el Codigo de Activacion a su Correo, Sigue los Pasos para Activar su Cuenta</div>";
					echo json_encode($response);
				}
								
			}else{
				$response["error_msg"]   = "<div class='alert alert-danger text-center'>El Correo No Existe</div>";
				echo json_encode($response);
			}
		
	}
	/**/
?>  