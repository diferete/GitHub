<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
<script src="jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" />


<style>
.erro {
        color: red;
        font-size: 10px;
        display: none;
}

</style>
<script type="text/javascript">
 $(document).ready(function(e) {
    $('#atualiza').click(
	  function(e){
	 alert("123"); 	  
	  //valida se o campo nome esta vazio
	if($('#nome').val().length < 8) {
		setInvalid('nome');
	} else {
		setValid('nome');
	}

	//valida se o campo email esta vazio
	if($('#email').val().length < 8) {
		setInvalid('email');
	} else {
		setValid('email');
	}
	
	//valida se o campo senha esta vazio
	if($('#senha').val().length < 8) {
		setInvalid('senha');
	} else {
		setValid('senha');
	}

	//valida se o campo senha esta igual ao campo resenha
	if($('#senha').val() != $('#resenha').val() ) {
		setInvalid('resenha');
	} else {
		setValid('resenha');
	}

	if(errors == 0) {
		$('#signup').submit();		
	}
  
  //valida se o campo nome esta vazio
	if($('#nome').val().length < 8) {
		setInvalid('nome');
	} else {
		setValid('nome');
	}

	//valida se o campo email esta vazio
	if($('#email').val().length < 8) {
		setInvalid('email');
	} else {
		setValid('email');
	}
	
	//valida se o campo senha esta vazio
	if($('#senha').val().length < 8) {
		setInvalid('senha');
	} else {
		setValid('senha');
	}

	//valida se o campo senha esta igual ao campo resenha
	if($('#senha').val() != $('#resenha').val() ) {
		setInvalid('resenha');
	} else {
		setValid('resenha');
	}

	if(errors == 0) {
		$('#atualiza').submit();		
	}
});






function setValid(element) {
	$('#'+element).css('border','solid 1px green');
	$('#'+element+'-erro').css('display','none');
}

function setInvalid(element,msg) {
	$('#'+element).css('border','solid 1px red');
	$('#'+element+'-erro').css('display','block');

	if(msg != '') {
		$('#'+element+'-erro').html(msg);	
	}
}


});

</script>
</head>

<body>
<form id="signup">
   Nome <br>
   <input class="input" type="text" id="nome"><br>
   <span class="erro" id="nome-erro">Preencha o nome completo</span>
   Email <br>
   <input class="input" type="text" name="email" id="email"><br>
   <span class="erro" id="email-erro">Preencha o email completo</span>
   Senha <br>
   <input class="input" type="password" name="senha" id="senha"><br>
   <span class="erro" id="senha-erro">Preencha a senha completo</span>
   Repita a senha <br>
   <input class="input" type="password" name="resenha" id="resenha"><br>
   <span class="erro" id="resenha-erro">Repita a senha corretamente</span>
   
    <a href="#" class="btn btn-success"  id="atualiza">ENVIAR DADOS!</a> 
</form>
   

</body>
</html>