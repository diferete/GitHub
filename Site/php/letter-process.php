<?php


$errorMSG = "";


// EMAIL
if (empty($_POST["email"])) {
    $errorMSG .= "Email is required ";
} else {
    $email = $_POST["email"];
}



$EmailTo = "alexandre@metalbo.com.br";
$Subject = "NEWS LETTER CADASTRADO NO SITE METALBO!";

// prepare email body text
$Body = "";

$Body .= "Email: ";
$Body .= $email;
$Body .= "\n";


// send email
$success = mail($EmailTo, $Subject, $Body, "From:".$email);

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