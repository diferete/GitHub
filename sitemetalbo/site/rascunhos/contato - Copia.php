<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CONTATO METALBO</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" />
<script src="jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="jquery/jquery.maskedinput.js" type="text/javascript"> </script>
<script type="text/javascript">

jQuery.noConflict();
(function($) {
$(function() {
$('.mask-data').mask('99/99/9999'); //data
$('.mask-hora').mask('99:99'); //hora
$('.mask-fone').mask('(99) 9999-9999'); //telefone
$('.mask-rg').mask('99.999.999-9'); //RG
$('.mask-ag').mask('9999-9'); //Agência
$('.mask-ag').mask('9.999-9'); //Conta
});
})(jQuery);

</script>

<script type="text/javascript">
  $(document).ready(function(e) {
    alert("teste");
});
</script>

</head>
<body>
<? include("estrutura/topo.php");?>
    <div class="container-fluid"
    	<div class="row-fluid">
	    	<div class="span2">
   				<? include("estrutura/menulat.php"); ?>
  			</div><!-- FIM DA DIV DO MENU LATERAL-->
			<div class="span10 margemTop50">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h4> ENTRE EM CONTATO COM A METALBO </h4>
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
    					</div>
  				</div>
                
                <div class="control-group">
    				<label class="control-label" >NOME:</label>
    					<div class="controls">
     						<input type="text" name="id_nome" id="id_nome" required="required" />
					         
    					</div>
  				</div>
                
                <div class="control-group">
    				<label class="control-label" >EMPRESA:</label>
    					<div class="controls">
     						<input type="text" name="id_empresa" id="id_empresa" required="required" />
					         
    					</div>
  				</div>
                
                <div class="control-group">
    				<label class="control-label">EMAIL:</label>
    					<div class="controls">
     						<input type="text" name="id_email" id="id_email" required="required"/>
    					</div>
  				</div>
                
                <div class="control-group">
    				<label class="control-label">CIDADE:</label>
    					<div class="controls">
     						<input type="text" name="id_cidade" id="id_cidade" required="required"/>
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
    					</div>
                   </div>
                   <div class="control-group">
    				<label class="control-label">TELEFONE:</label>
    					<div class="controls">
     						<input type="text" name="id_telefone" id="id_telefone" class="mask-fone" required="required" />
    					</div>
                        
  				  </div>
                  
                  <div class="control-group">
    				<label class="control-label" for="inputEmail" >COMENTÁRIO:</label>
                    <div class="controls">
                      <textarea rows="10" style="width:400px" name="id_comem" id="id_comem"></textarea><br/>
                    </div>
  			 	  </div>
               <hr />
               <div class="control-group">
    		    <div class="controls">
      			  <button type="button" class="btn btn-primary btn-success" value="Enviar" id="envia">Enviar Dados!</button>
    			</div>
  			  </div>
              <div class="span8 alert-success">
              <h4 id="result">Dados enviados com sucesso em breve responderemos sua solicitação! </h4> 
              </div>
             </form> 
          </div>
            
            
            
            
            
            
            </div>
        </div>
    </div>
<footer>
	<? include("estrutura/rodape.php"); ?>
</footer>

</body>
</html>