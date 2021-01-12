<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
        <title>Pesquisa de Satisfação - Metalbo</title>
        <link rel="shortcut icon" href="images/metalb.ico" type="image/x-icon" />
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" />

    </head>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top"><table width="100%" cellpadding="2" cellspacing="2">
                    <tr>
                        <td><center>
                                <p>
                                    <?php
// verifica se os campos do formulaios não estão vazios
                                    if (!empty($_POST["cortesia"]) && !empty($_POST["receptividade"]) && !empty($_POST["qualidade"]) && !empty($_POST["contato"]) && !empty($_POST["aspectos_visuais"]) && !empty($_POST["especificacoes"]) && !empty($_POST["embalagens"]) && !empty($_POST["prazo"]) && !empty($_POST["iso"]) && !empty($_POST["nome"]) && !empty($_POST["empresa"]) && !empty($email)) {

                                        //$pra_quem = "avaneim@gmail.com, pesquisa@rexmaquinas.com.br, pesquisa@rexmaquinas.com.br, damatec@gmail.com, suporte@infodigitalle.com.br";
                                        //$pra_quem = "pesquisa@metalbo.com.br";
                                        $pra_quem = "pesquisa@metalbo.com.br";


                                        // Criando a variável que irá representar o corpo do e-mail
                                        $msg .= "<br>";
                                        $msg = "Empresa: <b>";
                                        $msg .= $empresa;
                                        $msg .= "</b><br>";
                                        $msg .= "Responsável pelo preenchimento: <b>";
                                        $msg .= $nome;
                                        $msg .= "</b><br>";
                                        $msg .= "E-mail: ";
                                        $msg .= $email;
                                        $msg .= "<br>";
                                        $msg .= "<br>";




                                        $msg .= "<table width='536' border='1' cellpadding='1' cellspacing='1' class='formulario' id='questionario_tabela'>";
                                        $msg .= "<tr>";
                                        $msg .= "<td width='90'><div align='center'>ITEM</div></td>";
                                        $msg .= "<td width='280'><div align='center'>ASPECTO</div></td>";
                                        $msg .= "<td width='148'><div align='center'>GRAU DE SATISFAÇÃO </div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td rowspan='4'><div align='center'>ATENDIMENTO</div></td>";
                                        $msg .= "<td>CORTESIA: Demonstra educa&ccedil;&atilde;o e cordialidade</td>";
                                        $msg .= "<td><div align='center'>";
                                        $msg .= $cortesia;
                                        $msg .= "</div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td>RECEPTIVIDADE: Responde as solicita&ccedil;&otilde;es reclama&ccedil;&otilde;es e sugest&otilde;es</td>";
                                        $msg .= "<td><div align='center'>";
                                        $msg .= $receptividade;
                                        $msg .= "</div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td>QUALIDADE: R&aacute;pida e eficaz</td>";
                                        $msg .= "<td><div align='center'>";
                                        $msg .= $qualidade;
                                        $msg .= "</div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td>CONTATO: Os contatos atendem a sua necessidade</td>";
                                        $msg .= "<td><div align='center'>";
                                        $msg .= $contato;
                                        $msg .= "</div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td rowspan='4'><div align='center'>PRODUTOS</div></td>";
                                        $msg .= "<td>ASPECTOS VISUAIS: Atende as expectativas</td>";
                                        $msg .= "<td><div align='center'>";
                                        $msg .= $aspectos_visuais;
                                        $msg .= "</div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td>ESPECIFICA&Ccedil;&Otilde;ES: Atende aos requisitos especificados</td>";
                                        $msg .= "<td><div align='center'>";
                                        $msg .= $especificacoes;
                                        $msg .= "</div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td>EMBALAGENS: Garante a prote&ccedil;&atilde;o e a movimenta&ccedil;&atilde;o</td>";
                                        $msg .= "<td><div align='center'>";
                                        $msg .= $embalagens;
                                        $msg .= "</div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td>PRAZO DE ENTREGA: Na data combinada</td>";
                                        $msg .= "<td><div align='center'>";
                                        $msg .= $prazo;
                                        $msg .= "</div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td rowspan='4'><div align='center'>ISO 9001</div></td>";
                                        $msg .= "<td>ISO: Qual a importância de os produtos adquiridos serem certificados.</td>";
                                        $msg .= "<td><div align='center'>";
                                        $msg .= $iso;
                                        $msg .= "</div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "</table>";



                                        /*
                                          $msg .= "CORTESIA: Demonstra educação e cordialidade: ";
                                          $msg .= $cortesia;
                                          $msg .= "\r\n";
                                          $msg .= "RECEPTIVIDADE: Responde as solicitações reclamações e sugestões: ";
                                          $msg .= $receptividade;
                                          $msg .= "\r\n";
                                          $msg .= "QUALIDADE: Rápida e eficaz: ";
                                          $msg .= $qualidade;
                                          $msg .= "\r\n";
                                          $msg .= "CORDIALIDADE: Agilidade e simplicidade no atendimento de emergência: ";
                                          $msg .= $cordialidade;
                                          $msg .= "\r\n";
                                          $msg .= "PRESTEZA: Deseja nos ajudar: ";
                                          $msg .= $presteza;
                                          $msg .= "\r\n";
                                          $msg .= "ASPECTOS VISUAIS: Atende as expectativas: ";
                                          $msg .= $aspectos_visuais;
                                          $msg .= "\r\n";
                                          $msg .= "ESPECIFICAÇÕES: Atende aos requisitos especificados: ";
                                          $msg .= $especificacoes;
                                          $msg .= "\r\n";
                                          $msg .= "EMBALAGENS: Garante a proteção e a movimentação: ";
                                          $msg .= $embalagens;
                                          $msg .= "\r\n";
                                          $msg .= "PRAZO DE ENTREGA: Na data combinada: ";
                                          $msg .= $prazo;
                                          $msg .= "\r\n";
                                          $msg .= "\r\n";
                                          $msg .= "\r\n";
                                         */

                                        // Criando a variável adicional de headers

                                        $headers = "From: " . $empresa . "<pesquisa@metalbo.com.br>\n"; //Observe que eu utilizei o header 'From' que é um header padrão.
                                        $headers .= "X-Sender:<" . $email . ">\n";
                                        $headers .= "X-mailer: PHP\n";
                                        $headers .= "X-Priority: 1\n";
                                        $headers .= "Return-path: <pesquisa@metalbo.com.br>\n";
                                        $headers .= "Content-Type: text/html; charset=iso-8859-1\n";

                                        /*
                                          $headers = "From: "; //Observe que eu utilizei o header 'From' que é um header padrão.
                                          $headers .= $empresa;
                                          $headers .= " <";
                                          $headers .= $email;
                                          $headers .= ">";
                                         */
                                        if (mail("$pra_quem", "Pesquisa - Grau de Satisfação", $msg, $headers)) {
                                            ?>
                                            <!--AQUI VAI A RESPOSTA DE OK-->
                                            <? include("estrutura/topo.php");?>
                                            <div class="container-fluid">
                                                <div class="row-fluid">
                                                    <div class="span2">
                                                        <? include("estrutura/menulat.php"); ?>
                                                    </div><!-- FIM DA DIV DO MENU LATERAL-->
                                                    <div class="span9 corPadrao margemTop50 alert alert-success">
                                                        <hr /><br /><br /><br />
                                                        <h3>OBRIGADO PELA SUAS RESPOSTAS!</h3> 
                                                        <br /><br />
                                                        <h3>A METALBO AGRADECE PELA SUA ATEN&Ccedil;&Atilde;O!</h3>    
                                                    </div> <!--FIM SPAN 10 -->       
                                                </div><!--FIM ROW-->
                                            </div><!--FIM CONTAINER-->

                                            <footer>
                                                <? include("estrutura/rodape.php"); ?>
                                            </footer>
                                            <?php
                                        } else {
                                            ?>
                                            <!--AQUI VAI A RESPOSTA DE ERRO-->
                                            <? include("estrutura/topo.php");?>
                                            <div class="container-fluid">
                                                <div class="row-fluid">
                                                    <div class="span2">
                                                        <? include("estrutura/menulat.php"); ?>
                                                    </div><!-- FIM DA DIV DO MENU LATERAL-->
                                                    <div class="span9 corPadrao margemTop50 alert alert-danger">
                                                        <hr /><br /><br /><br />
                                                        <h3>SUAS RESPOSTAS N&Atilde;O PUDERAM SER ENVIADAS!</h3> 
                                                        <br />
                                                        <h3>TENTE NOVAMENTE!</h3>    
                                                        <br />
                                                        <h3><a href="javascript:history.back(1)">Voltar</a></h3>
                                                    </div> <!--FIM SPAN 10 -->       
                                                </div><!--FIM ROW-->
                                            </div><!--FIM CONTAINER-->

                                            <footer>
                                                <? include("estrutura/rodape.php"); ?>
                                            </footer>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <!--AQUI VAI A RESPOSTA DE CAMPOS VAZIOS-->
                                        <? include("estrutura/topo.php");?>
                                        <div class="container-fluid">
                                            <div class="row-fluid">
                                                <div class="span2">
                                                    <? include("estrutura/menulat.php"); ?>
                                                </div><!-- FIM DA DIV DO MENU LATERAL-->
                                                <div class="span9 corPadrao margemTop50 alert alert-danger"">
                                                    <hr /><br /><br /><br />
                                                    <h3>PREENCHA TODOS CAMPOS POR FAVOR!</h3> 
                                                    <br />   
                                                    <br />
                                                    <h3><a href="javascript:history.back(1)">Voltar</a></h3>
                                                </div> <!--FIM SPAN 10 -->       
                                            </div><!--FIM ROW-->
                                        </div><!--FIM CONTAINER-->

                                        <footer>
                                            <? include("estrutura/rodape.php"); ?>
                                        </footer>
                                        <?php
                                    }
                                    ?>
                                </p>
                                <p>&nbsp;</p>
                            </center></td>
                    </tr>
                </table>    </td>
        </tr>
    </table>
