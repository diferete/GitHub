<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
        <title>Pesquisa de Satisfação - Metalbo</title>
        <link rel="shortcut icon" href="images/metalb.ico" type="image/x-icon" />
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css?v=26" type="text/css" />

    </head>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top"><table width="100%" cellpadding="2" cellspacing="2">
                    <tr>
                        <td><center>
                                <p>
                                    <?php
                                    // verifica se os campos do formulaios nao estao vazios
                                    if (!empty($_POST["cortesia"]) && !empty($_POST["receptividade"]) && /* !empty($_POST["qualidade"]) && !empty($_POST["contato"]) && !empty($_POST["aspectos_visuais"]) && */!empty($_POST["especificacoes"]) && !empty($_POST["embalagens"]) && !empty($_POST["prazo"])/* && !empty($_POST["iso"]) */ && !empty($_POST["nome"]) && !empty($_POST["empresa"]) && !empty($_POST["email"])) {

                                        $cortesia = $_POST["cortesia"];
                                        $receptividade = $_POST["receptividade"];
                                        /*
                                          $qualidade = $_POST["qualidade"];
                                          $contato = $_POST["contato"];
                                          $aspectos_visuais = $_POST["aspectos_visuais"];
                                         */
                                        $especificacoes = $_POST["especificacoes"];
                                        $embalagens = $_POST["embalagens"];
                                        $prazo = $_POST["prazo"];
                                        $nome = $_POST["nome"];
                                        $empresa = $_POST["empresa"];
                                        $email = $_POST["email"];

                                        $pra_quem = "pesquisa@metalbo.com.br";
                                        //$pra_quem = "alexandre@metalbo.com.br";
                                        // Criando a variavel que ira representar o corpo do e-mail
                                        $msg .= "<br>";
                                        $msg = "Empresa: <b>";
                                        $msg .= $empresa;
                                        $msg .= "</b><br>";
                                        $msg .= "Nome: <b>";
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
                                        $msg .= "<td width='148'><div align='center'>GRAU DE SATISFA&Ccedil;&Atilde;O </div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td rowspan='4'><div align='center'>ATENDIMENTO</div></td>";
                                        $msg .= "<td>Avalie nossos vendedores com relação a educação e cordialidade.</td>";
                                        $msg .= "<td><div align='center'>";
                                        $msg .= $cortesia;
                                        $msg .= "</div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td>Nossos vendedores atendem suas solicicatções, reclamações e sugestões?</td>";
                                        $msg .= "<td><div align='center'>";
                                        $msg .= $receptividade;
                                        $msg .= "</div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td rowspan='4'><div align='center'>PRODUTOS</div></td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td>Os produtos recebidos atendem as ESPECIFICAÇÕES solicitadas?</td>";
                                        $msg .= "<td>";
                                        $msg .= "<div align='center'>";
                                        $msg .= $especificacoes;
                                        $msg .= "</div>";
                                        $msg .= "</td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td>A EMBALAGEM garante a proteção dos produtos até o destino final?</td>";
                                        $msg .= "<td>";
                                        $msg .= "<div align='center'>";
                                        $msg .= $embalagens;
                                        $msg .= "</div>";
                                        $msg .= "</td>";
                                        $msg .= "</tr>";
                                        $msg .= "<tr>";
                                        $msg .= "<td>O PRAZO DE ENTREGA atende as suas necessidades?</td>";
                                        $msg .= "<td>";
                                        $msg .= "<div align='center'>";
                                        $msg .= $prazo;
                                        $msg .= "</div>";
                                        $msg .= "</td>";
                                        $msg .= "</tr>";
                                        $msg .= "</table>";



                                        // Criando a variável adicional de headers

                                        $headers = "From: " . $empresa . "<" . $email . ">\n"; //Observe que eu utilizei o header 'From' que é um header padrão.
                                        $headers .= "X-Sender:<" . $email . ">\n";
                                        $headers .= "X-mailer: PHP\n";
                                        $headers .= "X-Priority: 1\n";
                                        $headers .= "Return-path: <" . $email . ">\n";
                                        $headers .= "Content-Type: text/html; charset=utf-8\n";

                                        /*
                                          $headers = "From: "; //Observe que eu utilizei o header 'From' que é um header padrão.
                                          $headers .= $empresa;
                                          $headers .= " <";
                                          $headers .= $email;
                                          $headers .= ">";
                                         */
                                        if (mail("$pra_quem", "Pesquisa de Satisfação - 2020", $msg, $headers)) {
                                            ?>
                                            <!--AQUI VAI A RESPOSTA DE OK-->
                                            <? include("estrutura/topo.php"); ?>
                                            <div class="container-fluid">
                                                <div class="row-fluid">
                                                    <div class="span2">
                                                        <? include("estrutura/menulat.php"); ?>
                                                    </div><!-- FIM DA DIV DO MENU LATERAL-->
                                                    <div class="span9 corPadrao margemTop50 alert alert-success">
                                                        <hr /><br /><br /><br />
                                                        <h3>OBRIGADO POR SUAS RESPOSTAS!</h3> 
                                                        <br /><br />
                                                        <h3>A METALBO AGRADECE PELA SUA ATENCAO!</h3>    
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
                                            <? include("estrutura/topo.php"); ?>
                                            <div class="container-fluid">
                                                <div class="row-fluid">
                                                    <div class="span2">
                                                        <? include("estrutura/menulat.php"); ?>
                                                    </div><!-- FIM DA DIV DO MENU LATERAL-->
                                                    <div class="span9 corPadrao margemTop50 alert alert-danger">
                                                        <hr /><br /><br /><br />
                                                        <h3>SUAS RESPOSTAS NÃO PUDERAM SER ENVIADAS!</h3> 
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
                                        <? include("estrutura/topo.php"); ?>
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
