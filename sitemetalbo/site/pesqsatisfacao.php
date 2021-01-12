<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Pesquisa de Satisfação - Metalbo</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" />
        <link rel="shortcut icon" href="images/metalb.ico" type="image/x-icon" />
    </head>
    <body>
        <? include("estrutura/topo.php");?>
        <div class="container-fluid"
             <div class="row-fluid">
                <div class="span2">
                    <? include("estrutura/menulat.php"); ?>
                </div><!-- FIM DA DIV DO MENU LATERAL-->
                <div class="span12 margemTop50 paragrafo " style="margin-left:60px">                             
                    <form action="questionario2.php" method="post" enctype="application/x-www-form-urlencoded" 
                          name="enviadados" target="_self" id="enviadados">
                        <div class="span12">
                            <div class="panel panel-heading corPadrao">
                                <div class="panel-title">
                                    <h3 class="corPadrao">PESQUISA DE SATISFAÇÃO METALBO</h3>
                                    <hr/>
                                </div>
                                <div class="panel-body">             
                                    <table class="table table-bordered table-striped span12 corpadrao">
                                        <tr>
                                            <td class="span2">ITEM</td>
                                            <td class="span5">ASPECTO</td>
                                            <td class="span4">GRAU DE SATISFAÇÃO</td>                        
                                        </tr>

                                        <tr>
                                            <td rowspan="4"><div align="center">ATENDIMENTO COMERCIAL (REPRESENTANTES)</div></td>
                                            <td>Avalie nossos vendedores com relação a educação e cordialidade.</td>
                                            <td>
                                                <div align="center">
                                                    <input name="cortesia" type="radio" value="5" />&nbsp;5&nbsp;
                                                    <input name="cortesia" type="radio" value="4" />&nbsp;4&nbsp;
                                                    <input name="cortesia" type="radio" value="3" />&nbsp;3&nbsp; 
                                                    <input name="cortesia" type="radio" value="2" />&nbsp;2&nbsp;
                                                    <input name="cortesia" type="radio" value="1" />&nbsp;1&nbsp;
                                                    <input name="cortesia" type="radio" value="00" />&nbsp;0&nbsp;
                                                </div>
                                            </td>
                                        </tr>        
                                        <tr>
                                            <td>Nossos vendedores atendem suas solicitações, reclamações e sugestões?</td>
                                            <td>
                                                <div align="center">
                                                    <input name="receptividade" type="radio" value="5" />&nbsp;5&nbsp;
                                                    <input name="receptividade" type="radio" value="4" />&nbsp4&nbsp
                                                    <input name="receptividade" type="radio" value="3" />&nbsp3&nbsp
                                                    <input name="receptividade" type="radio" value="2" />&nbsp2&nbsp
                                                    <input name="receptividade" type="radio" value="1" />&nbsp1&nbsp
                                                    <input name="receptividade" type="radio" value="00" />&nbsp0&nbsp
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                          <!--<td>QUALIDADE: Rápida e eficaz.</td>
                                            <td>
                                              <div align="center">
                                                <input name="qualidade" type="radio" value="5" />&nbsp5&nbsp
                                                <input name="qualidade" type="radio" value="4" />&nbsp4&nbsp
                                                <input name="qualidade" type="radio" value="3" />&nbsp3&nbsp
                                                <input name="qualidade" type="radio" value="2" />&nbsp2&nbsp
                                                <input name="qualidade" type="radio" value="1" />&nbsp1&nbsp
                                                <input name="qualidade" type="radio" value="00" />&nbsp0&nbsp
                                              </div>
                                            </td>-->
                                        </tr>
                                        <tr>
                                          <!--<td>CONTATO: Os contatos atendem a sua necessidade.</td>
                                            <td>
                                              <div align="center">
                                                <input name="contato" type="radio" value="5" />&nbsp5&nbsp
                                                <input name="contato" type="radio" value="4" />&nbsp4&nbsp
                                                <input name="contato" type="radio" value="3" />&nbsp3&nbsp
                                                <input name="contato" type="radio" value="2" />&nbsp2&nbsp
                                                <input name="contato" type="radio" value="1" />&nbsp1&nbsp
                                                <input name="contato" type="radio" value="00" />&nbsp0&nbsp
                                               </div>
                                            </td>-->
                                        </tr>
                                        <tr>
                                            <td rowspan="4"><div align="center">PRODUTOS</div></td>
                                              <!--<td>ASPECTO VISUAL: Atende as expectativas.</td>
                                                <td>
                                                  <div align="center">
                                                    <input name="aspectos_visuais" type="radio" value="5" />&nbsp5&nbsp
                                                    <input name="aspectos_visuais" type="radio" value="4" />&nbsp4&nbsp
                                                    <input name="aspectos_visuais" type="radio" value="3" />&nbsp3&nbsp
                                                    <input name="aspectos_visuais" type="radio" value="2" />&nbsp2&nbsp
                                                    <input name="aspectos_visuais" type="radio" value="1" />&nbsp1&nbsp
                                                    <input name="aspectos_visuais" type="radio" value="00" />&nbsp0&nbsp
                                                  </div>
                                                </td>-->
                                        </tr>
                                        <tr>
                                            <td>Os produtos recebidos atendem as ESPECIFICAÇÕES solicitadas?</td>
                                            <td>
                                                <div align="center">
                                                    <input name="especificacoes" type="radio" value="5" />&nbsp5&nbsp
                                                    <input name="especificacoes" type="radio" value="4" />&nbsp4&nbsp
                                                    <input name="especificacoes" type="radio" value="3" />&nbsp3&nbsp
                                                    <input name="especificacoes" type="radio" value="2" />&nbsp2&nbsp
                                                    <input name="especificacoes" type="radio" value="1" />&nbsp1&nbsp
                                                    <input name="especificacoes" type="radio" value="00" />&nbsp0&nbsp
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>A EMBALAGEM garante a proteção dos produtos até o destino final?</td>
                                            <td>
                                                <div align="center">
                                                    <input name="embalagens" type="radio" value="5" />&nbsp5&nbsp
                                                    <input name="embalagens" type="radio" value="4" />&nbsp4&nbsp
                                                    <input name="embalagens" type="radio" value="3" />&nbsp3&nbsp
                                                    <input name="embalagens" type="radio" value="2" />&nbsp2&nbsp
                                                    <input name="embalagens" type="radio" value="1" />&nbsp1&nbsp
                                                    <input name="embalagens" type="radio" value="00" />&nbsp0&nbsp
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>O PRAZO DE ENTREGA das mercadorias atende as suas necessidades?</td>
                                            <td>
                                                <div align="center">
                                                    <input name="prazo" type="radio" value="5" />&nbsp5&nbsp
                                                    <input name="prazo" type="radio" value="4" />&nbsp4&nbsp
                                                    <input name="prazo" type="radio" value="3" />&nbsp3&nbsp
                                                    <input name="prazo" type="radio" value="2" />&nbsp2&nbsp
                                                    <input name="prazo" type="radio" value="1" />&nbsp1&nbsp
                                                    <input name="prazo" type="radio" value="00" />&nbsp0&nbsp
                                                </div>
                                            </td>
                                        </tr> 
                                        <!--<tr>       
                                          <td><div align="center">CERTIFICAÇÃO</div></td>
                                            <td>Na sua visão, qual a perspectiva de mercado para 2015.</td>
                                              <td>
                                                <div align="center">
                                                  <input name="iso" type="radio" value="5" />&nbsp5&nbsp
                                                  <input name="iso" type="radio" value="4" />&nbsp4&nbsp
                                                  <input name="iso" type="radio" value="3" />&nbsp3&nbsp
                                                  <input name="iso" type="radio" value="2" />&nbsp2&nbsp
                                                  <input name="iso" type="radio" value="1" />&nbsp1&nbsp
                                                  <input name="iso" type="radio" value="00" />&nbsp0&nbsp
                                                </div>
                                              </td>
                                        </tr>-->
                                    </table>         
                                    <table class="table span12">     
                                        <tr>
                                            <td>          
                                                <div class="control-group">
                                                    <label class="control-label" >NOME:</label>
                                                    <div class="controls">
                                                        <input type="text" name="nome" id="nome" required="required" /><br />
                                                    </div>
                                                </div>
                                            </td>  
                                            <td>
                                                <div class="control-group">
                                                    <label class="control-label" >EMPRESA:</label>
                                                    <div class="controls">
                                                        <input type="text" name="empresa" id="empresa" required="required" /><br />
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="control-group">
                                                    <label class="control-label" >E-MAIL:</label>
                                                    <div class="controls">
                                                        <input type="text" name="email" id="email" required="required" /><br />
                                                    </div>
                                                </div>
                                            </td>
                                            <tr>
                                                <td>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <button class="btn btn-success" type="submit">Enviar</button>
                                                            <button class="btn btn-danger" type="reset">Limpar Campos</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tr>                    
                                    </table>
                                </div>  
                            </div> 
                        </div>            
                    </form>
                </div>                  
            </div><!--FIM ROW-->
        </div><!--FIM CONTAINER-->

        <footer>
            <? include("estrutura/rodape.php"); ?>
        </footer>
    </body>
</html>
