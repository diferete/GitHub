<?php

$errorMSG = "";

// NAME
if (empty($_POST["nome"])) {
    $errorMSG = " Nome ";
} else {
    $nome = $_POST["nome"];
}

// EMAIL
if (empty($_POST["email"])) {
    $errorMSG .= " E-mail ";
} else {
    $email = $_POST["email"];
}

// MSG SUBJECT
if (empty($_POST["assunto"]) || $_POST["assunto"] == 'null') {
    $errorMSG .= " Assunto ";
} else {
    $assunto = $_POST["assunto"];
}

// ESTADO
if (empty($_POST["uf"]) || $_POST["uf"] == 'null') {
    $errorMSG .= " Estado ";
} else {
    $uf = $_POST["uf"];
}

// MESSAGE
if (empty($_POST["mensagem"])) {
    $errorMSG .= " Mensagem ";
} else {
    $mensagem = $_POST["mensagem"];
}

//CIDADE
if (empty($_POST["cidade"]) || $_POST["cidade"] == 'null') {
    $errorMSG .= " Cidade ";
} else {
    $cidade = $_POST["cidade"];
}

if ($assunto == 'Cotações' && $uf == 'Acre') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Alagoas') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Amapá') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Amazonas') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Bahia') {
    $sEmail = "rosilva@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Ceará') {
    $sEmail = "diana@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Distrito Federal') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Espírito Santo') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Goiás') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Maranhão') {
    $sEmail = "diana@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Mato Grosso') {
    $sEmail = "diana@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Mato Grosso do Sul') {
    $sEmail = "diana@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Minas Gerais') {
    $sEmail = "luciana@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Paraná') {
    $sEmail = "diana@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Paraíba') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Pará') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Pernambuco') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Piauí') {
    $sEmail = "diana@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Rio de Janeiro') {
    $sEmail = "rosilva@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Rio Grande do Norte') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Rio Grande do Sul') {
    $sEmail = "luciana@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Rondônia') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Roraima') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Santa Catarina') {
    $sEmail = "rosilva@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Sergipe') {
    $sEmail = "rosilva@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'São Paulo') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}
if ($assunto == 'Cotações' && $uf == 'Tocantins') {
    $sEmail = "cristiano@metalbo.com.br;";
    $sEmail .= "diego@metalbo.com.br";
}



if ($assunto == 'Apresentações') {
    $sEmail = "contato@metalbo.com.br";
}
if ($assunto == 'NFe') {
    $sEmail = "nfe@metalbo.com.br";
}
if ($assunto == 'Compras') {
    $sEmail = "compras@metalbo.com.br";
}
if ($assunto == 'Outros') {
    $sEmail = "alexandre@metalbo.com.br";
}


$EmailTo = $sEmail;
$Subject = "Nova mensagem do site Metalbo!";

// prepare email body text
$Body = "";
$Body .= "Nome: ";
$Body .= $nome . "<br/>";
$Body .= "\n";
$Body .= "Email: ";
$Body .= $email . "<br/>";
$Body .= "\n";
$Body .= "Estado: ";
$Body .= $uf . "<br/>";
$Body .= "\n";
$Body .= "Cidade: ";
$Body .= $cidade . "<br/>";
$Body .= "\n";
$Body .= "Assunto: ";
$Body .= $assunto . "<br/>";
$Body .= "\n";
$Body .= "Menssagem: ";
$Body .= $mensagem . "<br/>";
$Body .= "\n";

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$headers .= "From: $email";

// send email
//$success = mail($EmailTo, $Subject, $Body, "From:".$email);


if ($errorMSG == "") {
    $success = mail($EmailTo, $Subject, $Body, $headers);
    if ($success && $errorMSG == "") {
        echo "success";
    } else {
        if ($errorMSG == "") {
            echo "Algo deu errado, tente novamente (:";
        } else {
            echo $errorMSG;
        }
    }
} else {
    echo $errorMSG;
}

?>