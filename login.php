<?php
	session_start();
	date_default_timezone_set('America/Mexico_City');
	include('class.consultas.php');
	include('encript.php');
	$ObjetoJson 		= json_decode($_POST['user']);
	$Json       		= new Json;
	/*Array de response*/
	 $response = array (
			"campo"     => "",
			"url"       => "",
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
	}else if($ObjetoJson->Password==""){
		$response["campo"]     = "Password";
		$response["error_msg"]   = "<div class='alert alert-danger text-center'>El Campo Password esta Vacio</div>";
		echo json_encode($response);
	}else{
			
			/*Verificamos que exista el email*/
			$JsonVerificaMail    = $Json->JsonVerificaMail($ObjetoJson->Email);
			$Estatus             = "0";
			if($JsonVerificaMail==true){
				$JsonLogin       = $Json->JsonLogin($ObjetoJson->Email, Encrypter::encrypt($ObjetoJson->Password));

				if(!empty($JsonLogin)){
					foreach ($JsonLogin as $key => $value) {
						# code...
						$_SESSION['login']       = $value["nombre"]." ".$value["apellidos"];
						$Estatus                 = $value["estatus"];
					}
					if($Estatus=="0"){
						$_SESSION['login']       = "";
						$response["error_msg"]   = "<div class='alert alert-danger text-center'>Error: La cuenta esta Inactiva</div>";
						echo json_encode($response);
					}else{
						$response["url"]         = "Principal.php";//
						$response["error_msg"]   = "<div class='alert alert-success text-center'>Iniciando Sesion....</div>";
						echo json_encode($response);
					}
					
				}else{
					$response["error_msg"]   = "<div class='alert alert-danger text-center'>Email/Contraseña Incorrecto</div>";
					echo json_encode($response);
				}
			}else{
				$response["error_msg"]   = "<div class='alert alert-danger text-center'>El Correo No Existe</div>";
				echo json_encode($response);
			}
		
	}
	/**/
?>  