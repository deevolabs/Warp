<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

if (!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['periodo']) && !empty($_POST['mensalidade']) && !empty($_POST['titulo_curso']) && !empty($_POST['id_curso']) && !empty($_POST['mensalidade_matutino']) && !empty($_POST['mensalidade_noturno'])) {

    require_once 'PHPMailerAutoload.php';
    $objEmail = new PHPMailer();
    $objEmail->IsSMTP();       // set mailer to use SMTP
    $objEmail->Host       = "smtp.gmail.com"; 

    //Enable SMTP debugging
    $objEmail->SMTPDebug = 0;
    $objEmail->SMTPAuth = true;     // turn on SMTP authentication
    $objEmail->SMTPSecure = "tls";                 // sets the prefix to the servier
    $objEmail->Host       = "smtp.gmail.com"; 
    $objEmail->Port       = 587;     
    $objEmail->Username = 'davi@deevo.com.br';  // a valid email here
    $objEmail->Password = 'qwert@12345';  // the password from email

    $objEmail->From = 'gms.programacao@gmail.com';
    $objEmail->AddAddress('gms.programacao@gmail.com');
    $objEmail->FromName = 'Cadastro curso - FAM';
    $objEmail->Subject = 'Cadastro curso - FAM';

    $objEmail->IsHTML(true);

    $messageSend = '
        <div style="border: 1px solid #eee;margin: 10px;padding: 10px">
            Curso: <b> '.$_POST['titulo_curso'].' </b> <br>
            Período selecionado: <b> '.ucfirst($_POST['periodo']).' </b> <br>
    ';

    if ($_POST['periodo'] == 'matutino') :
        $messageSend .= 'Mensalidade matutino: <b> '.$_POST['mensalidade_matutino'].' </b> <br>';
        $messageSend .= 'ID do curso: <b> '.$_POST['id_curso'].' </b> <br>';
    endif;

    if ($_POST['periodo'] == 'noturno') :
        $messageSend .= 'Mensalidade noturno: <b> '.$_POST['mensalidade_noturno'].' </b> <br>';
        $messageSend .= 'ID do curso: <b> '.$_POST['id_curso'].' </b> <br>';
    endif;

    $messageSend .= '
        <h5> Dados do cadastrado: </h5> <br>
            Nome: <b> '.$_POST['nome'].' </b> <br>
            E-mail: <b> '.$_POST['email'].' </b>
        </div>
    ';

    $objEmail->Body = $messageSend;

    if (!$objEmail->send()) {
        echo "Seu cadastro foi enviado com sucesso!";
    } else {
        return "Ocorreu um erro, verifique os campos digitados.";
    }

}