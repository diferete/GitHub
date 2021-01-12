<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contato - História</title>
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
   $("#id_falarcom").blur(function(){
	   if($('#id_falarcom').val()=="Escolha o Setor..."){
		 setInvalid('id_falarcom'); 
	   }else{
		 setValid('id_falarcom');  
	   }
	   
   })
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
   $("#id_empresa").blur(function(){
	if($('#id_empresa').val().length < 4) {
		setInvalid('id_empresa');
		//alert (validacao);
	} else {
		setValid('id_empresa');
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
			var id_falarcom =$('#id_falarcom').val();
	        var id_nome =$('#id_nome').val();
			var id_empresa =$('#id_empresa').val();
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
<? include("estrutura/topo.php");?>
    <div class="container-fluid">
    	<div class="row-fluid">
	    	<div class="span2">
   				<? include("estrutura/menulat.php"); ?>
  			</div><!-- FIM DA DIV DO MENU LATERAL-->
			<div class="span6 margemTop50">
            	<div class="panel panel-default corPadrao">
                <div class="panel-heading">
                  <h4 class="corPadrao"> ENTRE EM CONTATO COM A METALBO </h4>
                </div>
                   <div class="panel-body">
                     <form class="form-horizontal" name="formcontato" id="formcontato">
                        <div class="control-group">
                            <label class="control-label">FALAR COM:</label>
                                <div class="controls">
                                    <select name="id_falarcom" id="id_falarcom">
                                        <option>Escolha o Setor...</option>
                                        <option value="vendas">Vendas</option>
                                        <option value="compras">Compras</option>
                                        <option value="qual">Qualidade</option>
                                    </select>
                                    <span class="erro alert-error" id="id_falarcom-erro">Preencha um setor por favor!</span>
                                </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" >NOME:</label>
                                <div class="controls">
                                    <input type="text" name="id_nome" id="id_nome" required="required" />
                                    <span class="erro alert-error" id="id_nome-erro">Preencha o nome completo por favor!</span>
                                     
                                </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" >EMPRESA:</label>
                                <div class="controls">
                                    <input type="text" name="id_empresa" id="id_empresa" />
                                    <span class="erro alert-error" id="id_empresa-erro">Preencha a empresa por favor!</span> 
                                </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label">EMAIL:</label>
                                <div class="controls">
                                    <input type="text" name="id_email" id="id_email" />
                                    <span class="erro alert-error" id="id_email-erro">Preencha um email por favor!</span>
                                </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label">CIDADE:</label>
                                <div class="controls">
                                    <input type="text" name="id_cidade" id="id_cidade" />
                                    <span class="erro alert-error" id="id_cidade-erro">Preencha uma cidade por favor!</span> 
                                </div>
                                
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label">ESTADO:</label>
                                <div class="controls">
                                    <select name="id_estado" id="id_estado">
                                        <option>Escolha o Estado</option>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espirito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraiba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantis</option>
                                    </select>
                                    <span class="erro alert-error" id="id_estado-erro">Preencha um estado por favor!</span>
                                </div>
                           </div>
                           <div class="control-group">
                            <label class="control-label">TELEFONE:</label>
                                <div class="controls">
                                    <input type="text" name="id_telefone" id="id_telefone" class="phone"  />
                                    <span class="erro alert-error" id="id_telefone-erro">Preencha um telefone por favor!</span> 
                                </div>
                                
                          </div>
                          
                          <div class="control-group">
                            <label class="control-label" for="inputEmail" >COMENTÁRIO:</label>
                            <div class="controls">
                              <textarea rows="10" style="width:400px" name="id_comem" id="id_comem"></textarea><br/>
                              <span class="erro alert-error" id="id_comem-erro">Preencha um comentário por favor!</span> 
                            </div>
                          </div>
                       <hr />
                       <div class="control-group">
                        <div class="controls">
                          <a href="#" class="btn btn-success"  id="atualiza">ENVIAR DADOS!</a> 
                        </div>
                      </div>
                      <div class="span6" id="result">
                       
                      </div>
                     </form> 
                  </div>
            </div>
         </div> 
         
         
         <div class="span3 margemTop50">
             <div class="alert alert-success">
				CONFIRA NOSSA LOCALIZAÇÃO            
             </div>
<iframe width="300" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.br/maps?f=q&amp;source=s_q&amp;hl=pt-BR&amp;geocode=&amp;q=Rex+M%C3%A1quinas+Equipamentos,+Trombudo+Central+-+Santa+Catarina&amp;aq=t&amp;sll=-27.185355,-49.622769&amp;sspn=0.363422,0.676346&amp;ie=UTF8&amp;hq=Rex+M%C3%A1quinas+Equipamentos,&amp;hnear=Trombudo+Central+-+Santa+Catarina&amp;t=h&amp;ll=-27.286176,-49.784031&amp;spn=0.005721,0.006437&amp;z=16&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com.br/maps?f=q&amp;source=embed&amp;hl=pt-BR&amp;geocode=&amp;q=Rex+M%C3%A1quinas+Equipamentos,+Trombudo+Central+-+Santa+Catarina&amp;aq=t&amp;sll=-27.185355,-49.622769&amp;sspn=0.363422,0.676346&amp;ie=UTF8&amp;hq=Rex+M%C3%A1quinas+Equipamentos,&amp;hnear=Trombudo+Central+-+Santa+Catarina&amp;t=h&amp;ll=-27.286176,-49.784031&amp;spn=0.005721,0.006437&amp;z=16" style="color:#0000FF;text-align:left">Exibir mapa ampliado</a></small>
         </div>
         
         
         <div class="span3 margemTop25">
             <div class="alert alert-danger">
				CONFIRA NOSSA LOCALIZAÇÃO            
             </div>
			<div class="panel panel-default corPadrao">
                <div class="panel-heading">
             		Informações Gerais
                </div>
                <div class="panel-body">
					<strong>REX MAQUINAS E EQUIPAMENTOS LTDA.</strong><br>
                    Rodovia SC-426 Trevo BR-470<br>
                    Centro - Trombudo Central<br>
                    SC - BRASIL<br>
                    CEP: 89176-000<br>
                    <abbr title="Phone">Fone:</abbr> 55 (47) 3544-8400 <br/>
                    <abbr title="Phone">Fax:</abbr> 55 (47) 3544-0396
                    <address><br />
					<strong>Email Contato</strong><br>
					<a href="mailto:#">metalbo@metalbo.com.br</a>
					</address>
                </div>
             </div>

         </div>
         
           	
            
        </div>
    </div>
<footer>
	<? include("estrutura/rodape.php"); ?>
</footer>

</body>
</html>