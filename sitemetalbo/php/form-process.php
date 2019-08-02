<?php

$errorMSG = "";

// NAME
if (empty($_POST["name"])) {
    $errorMSG = "Name is required ";
} else {
    $name = $_POST["name"];
}

// EMAIL
if (empty($_POST["email"])) {
    $errorMSG .= "Email is required ";
} else {
    $email = $_POST["email"];
}

// MSG SUBJECT
if (empty($_POST["msg_subject"])) {
    $errorMSG .= "Subject is required ";
} else {
    $msg_subject = $_POST["msg_subject"];
}

// ESTADO
if (empty($_POST["msg_estado"])) {
    $errorMSG .= "State is required ";
} else {
    $msg_estado = $_POST["msg_estado"];
}

// MESSAGE
if (empty($_POST["message"])) {
    $errorMSG .= "Message is required ";
} else {
    $message = $_POST["message"];
}

//CIDADE
if (empty($_POST["cidade"])) {
    $$errorMSG .= "City is required";
} else {
    $cidade = $_POST["cidade"];
}


$EmailTo = "contato@metalbo.com.br;".",";
$EmailTo .= "avanei@rexmaquinas.com.br;".",";
$EmailTo .="alexandre@metalbo.com.br";
$Subject = "Nova mensagem do site Metalbo!";

// prepare email body text
$Body = "";
$Body .= "Nome: ";
$Body .= $name ."<br/>";
$Body .= "\n";
$Body .= "Email: ";
$Body .= $email."<br/>";
$Body .= "\n";
$Body .= "Estado: ";
$Body .= $msg_estado."<br/>";
$Body .= "\n";
$Body .= "Cidade: ";
$Body .= $cidade . "<br/>";
$Body .= "\n";
$Body .= "Assunto: ";
$Body .= $msg_subject."<br/>";
$Body .= "\n";
$Body .= "Menssagem: ";
$Body .= $message."<br/>";
$Body .= "\n";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$headers .= "From: $email";

// send email
//$success = mail($EmailTo, $Subject, $Body, "From:".$email);
$success = mail($EmailTo, $Subject, $Body, $headers);

// redirect to success page
if ($success && $errorMSG == ""){
   echo "success";
}else{
    if($errorMSG == ""){
        echo "Algo deu errado, tente novamente (:";
    } else {
        echo $errorMSG;
    }
}

?>