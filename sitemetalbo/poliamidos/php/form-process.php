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
if ($_POST["msg_estado"] == "0"){
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


$EmailTo = "vendas@poliamidos.com.br;".",";
$EmailTo .= "compras@poliamidos.com.br;".",";
$EmailTo .='alexandre@metalbo.com.br';
$Subject = "NOVA MENSAGEM SITE POLIAMIDOS!";

// prepare email body text
$Body = "";
$Body .= "Name: ";
$Body .= $name ."<br/>";
$Body .= "\n";
$Body .= "Email: ";
$Body .= $email."<br/>";
$Body .= "\n";
$Body .= "Estado: ";
$Body .= $msg_estado."<br/>";
$Body .= "\n";
$Body .= "Subject: ";
$Body .= $msg_subject."<br/>";
$Body .= "\n";
$Body .= "Message: ";
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