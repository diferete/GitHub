<?php
	$id_falarcom = $_POST['id_falarcom'];
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
  $para = "contato@metalbo.com.br";

  // Assunto do e-mail
  $assunto = "Contato do site"; 
  
  $corpo ="<b>Setor:</b> $id_falarcom";
  $corpo .= "<br>";
  $corpo .= "<br>";  
  $corpo .= "<b>Nome:</b> $id_nome <br/><b>Empresa:</b> $id_empresa <br/>";
  $corpo .= "<b>E-mail:</b> $id_email <br/><b>Cidade:</b> $id_cidade <br/>";
  $corpo .= "<b>Estado:</b> $id_estado <br/><b>Telefone:</b> $id_telefone<br/>";
  $corpo .= "<b>Comentário:</b> $id_comem";

   // Cabeçalho do e-mail
  $header = "From: $nome <$para> Reply-to: $email ";
  $header .= "\nContent-type: text/html; charset=utf-8";

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












