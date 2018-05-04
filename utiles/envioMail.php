<?php


/***
 * 
 * dirección email:                     apps@eneasp.com    

cuenta de usuario:                 apps@eneasp.com

contraseña:                            AppsEneasp15!

correo WEBMAIL:                  webmail.eneasp.com:88

correo saliente SMTP:           smtp.eneasp.com       puerto: 465   seguridad: SSL-TLS   requiere autentificación: SI

correo entrante POP3            pop.eneasp.com         puerto: 995   seguridad: SSL-TLS

correo entrante IMAP            imap.eneasp.com       puerto: 993   seguridad: SSL-TLS
 */
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP

$mail->Host = 'smtp.office365.com';						  // Specify main and backup SMTP servers

$mail->SMTPAuth = true;                               // Enable SMTP authentication

$mail->Username = 'info@eneasp.com';                 // SMTP username

$mail->Password = 'David@110167!';                           // SMTP password

$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'info@eneasp.com';

$mail->FromName = 'Eneasp';

$mail->addAddress('info@eneasp.com', 'Joe User');     // Add a recipient

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments

//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

$mail->isHTML(true);                                  // Set email format to HTML



$mail->Subject = 'Here is the subject';

$mail->Body    = 'This is the HTML message body <b>in bold!</b>';

$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



if(!$mail->send()) {

	echo 'Message could not be sent.';

	echo 'Mailer Error: ' . $mail->ErrorInfo;

} else {

	echo 'Message has been sent';

}

?>