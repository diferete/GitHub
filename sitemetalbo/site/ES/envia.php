<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" />

<title>Documento sem título</title>
</head>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><table width="100%" cellpadding="2" cellspacing="2">
      <tr>
        <td><center>
          <p>
<? $id_falarcom = $_POST['id_falarcom'];
  
   $id_nome = $_POST['id_nome'];
   
    $id_empresa = $_POST['id_empresa'];
   
    $id_email = $_POST['id_email'];
   
   $id_cidade = $_POST['id_cidade'];
   
   $id_estado = $_POST['id_estado'];
   
    $id_telefone = $_POST['id_telefone'];
   
   $id_comem = $_POST['id_comem'];
   
  
   
  if ($id_falarcom == "Escolha o Setor..." or  strlen($id_nome)< 8 or strlen($id_empresa) < 4
  or strlen($id_email)<4  or strlen($id_cidade)<2 or $id_estado == "Escolha o Estado" or $id_telefone == ""
  or $id_comem == "" ){
	echo "<div class='alert-error'><h5>";
	echo "Verifique campos não preechidos por favor!";   
	echo "</h5></div>";   
   }else
   {




// Destinatário
  $para = "webmaster@metalbo.com.br";

  // Assunto do e-mail
  $assunto = "Contato do site"; 
  
  
  // Monta o corpo da mensagem com os campos
 /* $corpo .= "<table width='536' border='1' cellpadding='1' cellspacing='1' class='formulario' id='contatos'>";
  $corpo .= "<tr>";
  $corpo .= "<td>Setor</td>";
  $corpo .= "<td>$id_falarcom</td>";  
  $corpo .= "</tr>";
  
  $corpo .= "<tr>";
  $corpo .= "<td>Nome</td>";
  $corpo .= "<td>$id_nome</td>";  
  $corpo .= "</tr>";  
  
  $corpo .= "<tr>";
  $corpo .= "<td>Empresa</td>";
  $corpo .= "<td>$id_empresa</td>";  
  $corpo .= "</tr>";
  
  $corpo .= "<tr>";
  $corpo .= "<td>Email</td>";
  $corpo .= "<td>$id_email</td>";  
  $corpo .= "</tr>";
  
  $corpo .= "<tr>";
  $corpo .= "<td>Cidade</td>";
  $corpo .= "<td>$id_cidade</td>";  
  $corpo .= "</tr>"; 
  
  $corpo .= "<tr>";
  $corpo .= "<td>Estado</td>";
  $corpo .= "<td>$id_estado</td>";  
  $corpo .= "</tr>"; 
  
  $corpo .= "<tr>";
  $corpo .= "<td>Telefone</td>";
  $corpo .= "<td>$id_telefone</td>";  
  $corpo .= "</tr>"; 
  $corpo .="</table>";*/
  
  
  $corpo ="Setor: $id_falarcom";
  $corpo .= "<br>";
  $corpo .= "<br>";  
  $corpo .= "Nome: $id_nome <br/>Empresa: $id_empresa <br/>";
  $corpo .= "E-mail: $id_email <br/>Cidade: $id_cidade <br/>";
  $corpo .= "Estado: $id_estado <br>Telefone: $id_telefone";
  $corpo .= "Comentário: $id_comem";
  
  
   // Cabeçalho do e-mail
  $header = "From: $nome <$para> Reply-to: $email ";
  $header .= "Content-Type: text/html; charset=iso-8859-1 ";
  
 
   
   if(@mail($para, $assunto, $corpo, $header)){
 echo "<div class='alert-success'><h4>";
 echo "Sua mensagem foi enviada corretamente, em breve entraremos em contato obrigado!";
 echo "</h4></div>";
 } else {
 echo "<div class='alert-error'><h3>";
 echo "Falha no envio! Tente novamente!";
 echo "</h3></div>";

 }

   }

?> 
            </p>
          <p>&nbsp;</p>
        </center></td>
      </tr>
    </table>    </td>
  </tr>
</table>  
