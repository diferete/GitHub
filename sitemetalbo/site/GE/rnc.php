<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Rnc - Metalbo</title>
<link rel="shortcut icon" href="images/metalb.ico" type="image/x-icon" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" />
<script src="jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="jquery/jquery.maskedinput.js" type="text/javascript"> </script>
<script type="text/javascript">
 jQuery(function($){
   $(".maskdata").mask("99/99/9999");
   $(".phone").mask("(99) 9999-9999");
   $("#tin").mask("99-9999999");
   $("#ssn").mask("999-99-9999");
   $('.hora').mask('99:99'); 
});
</script>
<style>
.erro {
      display: none;
}

</style>
<script type="text/javascript">
$(document).ready(function(){
	validacao = 1;
	//valida o setor
	//valida o nome
	$("#id_nome").blur(function(){
	if($('#id_nome').val().length < 8) {
		setInvalid('id_nome');
		//alert (validacao);
	} else {
		setValid('id_nome');
		//alert (validacao);
	}
    })
 //valida empresa
   $("#id_cnpj").blur(function(){
	if($('#id_cnpj').val().length < 4) {
		setInvalid('id_cnpj');
		//alert (validacao);
	} else {
		setValid('id_cnpj');
		//alert (validacao);
	}
    })
//valida email
   $("#id_email").blur(function(){
	if($('#id_email').val().length < 4) {
		setInvalid('id_email');
		//alert (validacao);
	} else {
		setValid('id_email');
		//alert (validacao);
	}
    })
//valida cidade
   $("#id_cidade").blur(function(){
	if($('#id_cidade').val().length < 2) {
		setInvalid('id_cidade');
		//alert (validacao);
	} else {
		setValid('id_cidade');
		//alert (validacao);
	}
    })
	//valida o estado
   $("#id_estado").blur(function(){
	   if($('#id_estado').val()=="Escolha o Estado"){
		 setInvalid('id_estado'); 
	   }else{
		 setValid('id_estado');  
	   }
	   
   })
//telefone
   $("#id_telefone").blur(function(){
	if($('#id_telefone').val().length < 2) {
		setInvalid('id_telefone');
		//alert (validacao);
	} else {
		setValid('id_telefone');
		//alert (validacao);
	}
    })
//comentario
   $("#id_comem").blur(function(){
	if($('#id_comem').val().length < 2) {
		setInvalid('id_comem');
		//alert (validacao);
	} else {
		setValid('id_comem');
		//alert (validacao);
	}
    })
function setValid(element) {
	$('#'+element+'-erro').css('display','none');
	$('#'+element).css('border','solid 1px green');
	validacao = 0;
}

function setInvalid(element) {
	$('#'+element+'-erro').css('display','block');
	$('#'+element).css('border','solid 1px red');
	validacao = 1;
	}


$('#atualiza').click(function(e) {
	   e.preventDefault();
			$('#result').ajaxStart(function() {
			var iconCarregando = $('<img src="images/loading.gif"/> <span class="destaque">Carregando. Por favor aguarde...</span>');
			$(this).html(iconCarregando);
			});
	        var id_nome =$('#id_nome').val();
			var id_cnpjç =$('#id_cnpj').val();
			var id_email =$('#id_email').val();
			var id_cidade =$('#id_cidade').val();
			var id_estado =$('#id_estado').val();
			var id_telefone =$('#id_telefone').val();
			var id_comem =$('#id_comem').val();
			$.post('envia.php',
	      { id_falarcom: id_falarcom, id_nome: id_nome, id_empresa: id_empresa, id_email:id_email,
		   id_cidade: id_cidade, id_estado: id_estado,id_telefone:id_telefone, id_comem: id_comem}, 
			function(data) {
				var espera = function() { $('#result').html(data) };
				setTimeout(espera, 0);
			},
			'html');
		 //limparform();
		  });	

function limparform(){
	$("#formcontato")[0].reset();
	
}

});

</script>
</head>

<body>
<? include("estrutura/topo.php"); ?>
	<div class="span2">
    	<? include("estrutura/menulat.php"); ?>
    </div>
    <div class="span12 margemTop50 margemTop50">
    <div class="span2">
    </div>
		<div class="span8 margemTop50">
        	<div class="panel panel-default corPadrao">
            	<div class="panel-heading">
                  <h4 class="corPadrao"> RECLAMAÇÃO DE NÃO CONFORMIDADE METALBO </h4>
                </div>
                   <div class="panel-body">
                     <form class="form-horizontal" name="formcontato" id="formcontato">
                     
                     <fieldset>
                     <legend>DADOS DO CLIENTE</legend>
                      <div class="control-group">
                            <label for="id_nome" class="control-label" >NOME:</label>
                                <div class="controls">
                                    <input type="text" name="id_nome" id="id_nome" required="required" />
                                    <span class="erro alert-error" id="id_nome-erro">Preencha o nome completo por favor!</span>
                                     
                                </div>
                        </div>
                     
                       <div class="control-group">
                            <label for="id_cnpj" class="control-label" >CNPJ:</label>
                                <div class="controls">
                                    <input type="text" name="id_cnpj" id="id_cnpj" />
                                    <span class="erro alert-error" id="id_cnpj-erro">Preencha o cnpj corretamente por favor!</span> 
                                </div>
                       </div>
                       
                       <div class="control-group">
                            <label for="id_cliente" class="control-label">CLIENTE:</label>
                                <div class="controls">
                                    <input type="text" name="id_cliente" id="id_cliente" />
                                    <span class="erro alert-error" id="id_cliente-erro">Preencha o cliente correto por favor!!</span>
                                </div>
                        </div>
                     	</fieldset>
                     	<fieldset>
                        <legend>DADOS DO PRODUTO</legend>
                        <div class="control-group">
                            <label for="id_procod" class="control-label">CÓDIGO DO PRODUTO:</label>
                                <div class="controls">
                                    <input type="text" name="id_procod" id="id_procod" />
                                    <span class="erro alert-error" id="id_procod-erro">Preencha o código do produto correto por favor!!</span>
                                </div>
                        </div>
                        
                        <div class="control-group">
                            <label for="id_prodes" class="control-label">DESCRIÇÃO DO PRODUTO:</label>
                                <div class="controls">
                                    <input type="text" name="id_prodes" id="id_prodes" />
                                    <span class="erro alert-error" id="id_prodes-erro">Preencha a descrição correto por favor!!</span>
                                </div>
                        </div>
                        
                        <div class="control-group">
                            <label for="id_op" class="control-label">OP</label>
                                <div class="controls">
                                    <input type="text" name="id_op" id="id_op" />
                                    <span class="erro alert-error" id="id_op-erro">Preencha o op correto por favor!!</span>
                                </div>
                        </div>
                        
                        <div class="control-group">
                            <label for="id_lote" class="control-label">LOTE</label>
                                <div class="controls">
                                    <input type="text" name="id_lote" id="id_lote" />
                                    <span class="erro alert-error" id="id_lote-erro">Preencha o lote correto por favor!!</span>
                                </div>
                        </div>
                        
                        <div class="control-group">
                            <label for="id_qtdtot" class="control-label">QUANTIDADE TOTAL:</label>
                                <div class="controls">
                                    <input type="text" name="id_qtdtot" id="id_qtdtot" />
                                    <span class="erro alert-error" id="id_qtdtot-erro">Preencha a quantidade correto por favor!!</span>
                                </div>
                        </div>
                        
                        <div class="control-group">
                            <label for="id_qtdnconf" class="control-label">QUANTIDADE NÃO CONFORME:</label>
                                <div class="controls">
                                    <input type="text" name="id_qtdnconf" id="id_qtdnconf" />
                                    <span class="erro alert-error" id="id_qtdnconf-erro">Preencha a quantidade não conforme!!</span>
                                </div>
                        </div>
                        
                        <div class="control-group">
                            <label for="id_numnf" class="control-label">Nº NF:</label>
                                <div class="controls">
                                    <input type="text" name="id_numnf" id="id_numnf" />
                                    <span class="erro alert-error" id="id_numnf-erro">Preencha o nº da NF correto por favor!!</span>
                                </div>
                        </div>
                        
                        <div class="control-group">
                            <label for="id_coment" class="control-label">DESCRIÇÃO PROBLEMA:</label>
                                <div class="controls">
                                    <textarea rows="8" id="id_coment" name="id_coment"></textarea>
                                    <span class="erro alert-error" id="id_coment-erro">Preencha a descrição correto por favor!!</span>
                                </div>
                        </div>
                        
                        <div class="control-group">
                        	<div class="controls">
                                <label class="radio">
                                	<input type="radio" name="decisao" id="id_notificar" value="Notificar" checked>
                                    	Somente Notificar
                                </label>
                                <label class="radio">
  									<input type="radio" name="decisao" id="id_devolver" value="Devolver">
  										Devolver Mercadoria
								</label>
							</div>
                        </div>                       
                        </fieldset>
                        <fieldset>
                        <legend>DADOS DEVOLUÇÃO</legend>
                        <div class="control-group">
                            <label for="id_frete" class="control-label">FRETE R$:</label>
                                <div class="controls">
                                    <input type="number" name="id_frete" id="id_frete" />
                                    <span class="erro alert-error" id="id_frete-erro">Preencha o valor correto por favor!!</span>
                                </div>
                        </div>
                        
                        <div class="control-group">
                            <label for="id_dataenvio" class="control-label">DATA ENVIO:</label>
                                <div class="controls">
                                    <input type="date" name="id_dataenvio" id="id_dataenvio" />
                                    <span class="erro alert-error" id="id_dataenvio-erro">Preencha a data corretamente por favor!!</span>
                                </div>
                        </div>
                        </fieldset>
                     
                     </form>
                   </div>
             </div>
         </div>
    </div>  
  <div class="span2">
  </div>  
    
    
    </div>
<footer>
	<? include("estrutura/rodape.php"); ?>
</footer>    
</body>
</html>
