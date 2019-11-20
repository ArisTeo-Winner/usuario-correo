<?php
require 'Mailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();                                      
$mail->Host = 'smtp.gmail.com';                      
$mail->SMTPAuth = true;                               // Activamos la autenticacion
$mail->Username = 'panzhert@gmail.com';       // Correo SMTP 
$mail->Password = 'Rammstein45';                // Contraseña SMTP
$mail->SMTPSecure = 'ssl';                            // Activamos la encriptacion ssl
$mail->Port = 465;                                    // Seleccionamos el puerto del SMTP
$mail->From = 'panzhert@gmail.com';
$mail->FromName = 'Desarrollos PHP';                       
$mail->isHTML(true); 
$mail->CharSet = 'UTF-8';  


function enviarMail($destinatarios,$asunto,$mensaje){
	global $mail;

	//Agregamos a todos los destinatarios
	//foreach ($destinatarios as $correo => $nombre) {
		$mail->addAddress($destinatarios);
	//}
	
	//Añadimos el asunto del mail
	$mail->Subject = $asunto; 

	//Mensaje del email
	$mail->Body    = $mensaje;

	//comprobamos si el mail se envio correctamente y devolvemos la respuesta al servidor
	if(!$mail->send()) {
		return false;
	} else {
		return true;
	} 
}
?>
