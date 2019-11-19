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
	if($ObjetoJson->Id==""){
		$response["error_msg"]   = "<div class='alert alert-danger text-center'>Error: Url Incorrecto</div>";
		echo json_encode($response);
	}else if($ObjetoJson->Codigo==""){
		$response["campo"]     = "Activacion";
		$response["error_msg"]   = "<div class='alert alert-danger text-center'>El Codigo de Activacion esta Vacio</div>";
		echo json_encode($response);
	}else{
			$JsonAcountActivo            = $Json->JsonAcountActivo($ObjetoJson->Id,$ObjetoJson->Codigo);
			if(!empty($JsonAcountActivo)){
				foreach ($JsonAcountActivo as $key => $value) {
					# code...
					$Estatus	= $value["estatus"];
					if($Estatus==1){
						$response["error_msg"]   = "<div class='alert alert-danger text-center'>Error: La Cuenta ya Fue Activada <a href='index.html'>Inicia Sesion Aqui</a></div>";
						echo json_encode($response);
					}else{
						$JsonActivarCuenta       = $Json->ActivarCuenta($ObjetoJson->Id, date('Y-m-j H:i:s'), $ObjetoJson->Codigo);
						if($JsonActivarCuenta==true){
							$response["error_msg"]   = "<div class='exito'>Cuenta Activada con Exito <a href='index.html'>Inicia Sesion Aqui</a></div>";
							echo json_encode($response);
						}else{
							$response["error_msg"]   = "<div class='alert alert-danger text-center'>Ups Hubo un Error Intente mas Tarde</div>";
							echo json_encode($response);
						}
						
					}
				}
				
			}else{
				$response["error_msg"]   = "<div class='alert alert-danger text-center'>El Codigo de Activacion No existe</div>";
				echo json_encode($response);
			}
			
			
			
			
		
	}
	/**/
?>  