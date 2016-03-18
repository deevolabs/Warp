<?
require_once 'PHPMailerAutoload.php';
$mail_autenticado = new PHPMailer();
$mail_autenticado->IsSMTP();       // set mailer to use SMTP
$mail_autenticado->Host       = "mail.barbiemarley.com.br"; 

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail_autenticado->SMTPDebug = 0;
$mail_autenticado->SMTPAuth = true;     // turn on SMTP authentication
$mail_autenticado->SMTPSecure = "tls";                 // sets the prefix to the servier
$mail_autenticado->Host       = "smtp.gmail.com"; 
$mail_autenticado->Port       = 587;     
$mail_autenticado->Username = 'contato@barbiemarley.com.br';  // a valid email here
$mail_autenticado->Password = 'fsdfsddfsdfsfds';  // the password from email
$mail_autenticado->From = 'contato@barbiemarley.com.br';
//$mail_autenticado->AddReplyTo($R_DATA['email'], $R_DATA['name']);
$mail_autenticado->FromName = $this->getSenderName();
$mail_autenticado->AddAddress($email);
$mail_autenticado->Subject = $this->getProcessedTemplateSubject($variables);
$mail_autenticado->IsHTML(true);
$mail_autenticado->Body = 'teste';
$mail_autenticado->AltBody = 'Este é um corpo de mensagem de texto...';
if (!$mail_autenticado->send()) {
	echo "ERRO";
} else {
	return "DEU CERTO";
}
?>