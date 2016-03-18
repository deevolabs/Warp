<?php
if ( isset($_POST) )
{

    $subject = 'Envio de e-mail - teste';
    $data_arr = $_POST;

    $desejaReceberEmail;
    $desejaReceberSMS;

    if (isset($_POST['check-email'])) {
        $desejaReceberEmail = 'Sim';        
    } else {
        $desejaReceberEmail = 'Não';
    }

    if (isset($_POST['check-sms'])) {
        $desejaReceberSMS = 'Sim';      
    } else {
        $desejaReceberSMS = 'Não';
    }

    $mensagem_email =  "<h1>{$subject}</h1>
                        <p><strong>Nome:</strong> {$data_arr['name']}</p>
                        <p><strong>Email:</strong> {$data_arr['email']}</p>
                        <p><strong>Departamento:</strong> {$data_arr['departamento']}</p>
                        <p><strong>Mensagem:</strong> {$data_arr['message']}</p>
                        <p><strong>Deseja receber e-mail:</strong> {$desejaReceberEmail}</p>";
                        
    $msg_sucesso = '<span class="success">Seu email foi enviado.</span>';
    $msg_erro = '<span class="error">Error, mensagem não enviada</span>';


require '../phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;



$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'davi@deevo.com.br';                            // SMTP username
$mail->Password = 'qwert@12345';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
//$mail->SMTPDebug = 1;
$mail->Port = 587; //Indica a porta de conexão para a saída de e-mails
//$mail->Host = 'smtp.latindmp.com.br';
$mail->From = 'davi@deevo.com.br';
$mail->FromName = 'Deevo - Contato';
//$mail->addAddress('dexter@deevo.com.br', 'Fabio Dexter');  // Add a recipient
$mail->addAddress('davi@deevo.com.br', 'Davi Roberto');  // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES['anexo']['tmp_name'], $_FILES['anexo']['name']);
}

$mail->Subject = 'Contato';
$mail->Body    = "
                <html>
                    <head>
                        <title>{$subject}</title>
                    </head>
                    <body>
                        {$mensagem_email}
                    </body>
                </html>
            ";
$mail->AltBody = $mensagem_email;

if(!$mail->send()) {
   echo $msg_erro;
   //echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}

echo $msg_sucesso;

}

?>
