<?php

if (isset($_REQUEST['email'])) {
    $sEmailRequest = 'S';
} else {
    $sEmailRequest = 'N';
}

// Diretórios extras para email
if ($sEmailRequest == 'S') {
    include 'biblioteca/fpdf/fpdf.php';
    include("../../includes/Config.php");
    include("../../includes/Fabrica.php");
    include("../../biblioteca/Utilidades/Email.php");
} else {
    include '../../biblioteca/fpdf/fpdf.php';
    include("../../includes/Config.php");
    include("../../includes/Fabrica.php");
    include("../../biblioteca/Utilidades/Email.php");
}

// Diretórios
//require '../../biblioteca/fpdf/fpdf.php';
//include("../../includes/Config.php");

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 285);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação
    }

}

//variaveis request
if ($sEmailRequest == 'S') {
    $filcgc = $_REQUEST['filcgcRc'];
    $nr = $_REQUEST['nrRc'];
} else {
    if (isset($_REQUEST['nr'])) {
        $nr = $_REQUEST['nr'];
        $filcgc = $_REQUEST['filcgc'];
    } else {
        $nr = '0';
        $filcgc = '0';
    }
}




$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE
$pdf->SetAutoPageBreak(true, 2);
$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA


$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
/* $sSql = "select tbrncqual.empcod,tbrncqual.empdes,
  convert(varchar,datains,103) as datains,
  empfone,celular,empend,empendbair,
  cidnome,convert(varchar,datains,103)as datains,email,
  case when ind = 'true' then 'x' else '' end as ind,
  case when comer = 'true' then 'x' else '' end as comer,widl.emp01.cidcep,
  nf,convert(varchar,datanf,103)as datanf,odcompra,pedido,valor,peso,lote,op,naoconf,procod,prodes,aplicacao,
  quant,quantnconf,usuaponta,apontamento,resp_venda_nome,obs_devolucao,
  case when devolucaoacc = 'true' then 'x' else '' end as devolucaoacc,
  case when devolucaorec = 'true' then 'x' else '' end as devolucaorec,
  case when disposicao = '1' then 'x' else '' end as aceitar,
  case when disposicao = '2' then 'x' else '' end as recusar,usunome
  from tbrncqual left outer join widl.EMP01
  on widl.emp01.empcod = tbrncqual.empcod left outer join widl.CID01
  on widl.CID01.cidcep = widl.EMP01.cidcep where nr =" . $nr;
 * 
 */

$sSql = "select tbrncqual.empcod,tbrncqual.empdes,
                convert(varchar,datains,103) as datains,
                empfone,celular,empend,empendbair,usunome,
                cidnome,convert(varchar,datains,103)as datains,email,
                case when ind = 'true' then 'x' else '' end as ind,
                case when comer = 'true' then 'x' else '' end as comer,
                widl.emp01.cidcep,nf,convert(varchar,datanf,103)as datanf,
                odcompra,pedido,valor,peso,lote,op,naoconf,produtos,aplicacao,
                quant,quantnconf,usuaponta,apontamento,devolucao,reclamacao,resp_venda_nome,obs_aponta,obs_fim,usunome_fim,
                case when disposicao = '1' then 'x' else '' end as aceitar,
                case when disposicao = '2' then 'x' else '' end as recusar
                from tbrncqual left outer join widl.EMP01
                on widl.emp01.empcod = tbrncqual.empcod left outer join widl.CID01 
                on widl.CID01.cidcep = widl.EMP01.cidcep where nr =" . $nr;
$dadoscab = $PDO->query($sSql);
$row = $dadoscab->fetch(PDO::FETCH_ASSOC);
//cabeçalho
$pdf->SetMargins(3, 5, 3);
$pdf->Rect(2, 10, 38, 18);

$aProdutos = explode(';', $row['produtos']);

// Logo
if ($sEmailRequest == 'S') {
    $pdf->Image('biblioteca/assets/images/logopn.png', 4, 13, 26);
} else {
    $pdf->Image('../../biblioteca/assets/images/logopn.png', 4, 13, 26);
}

// Arial bold 15
$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(30);
// Title
$pdf->Cell(120, 18, '        Relatório de não conformidade nº   ' . $nr, 1, 0, 'L');

$pdf->Rect(160, 10, 48, 18);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(45, 5, 'Emissão: ' . $row['datains'] . '       Usuário: ' . $row['usunome'] . '                        ', 0, 'J');

$pdf->Rect(2, 32, 206, 30);
$pdf->Ln(10);
//cliente
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Cliente:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['empcod'], 0, 0, 'L');
$pdf->Cell(116, 5, $row['empdes'], 0, 1, 'L');
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Tipo:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(19, 5, '(' . $row['ind'] . ') Indústria', 0, 0, 'L');
$pdf->Cell(19, 5, '(' . $row['comer'] . ') Comécio', 0, 1, 'L');


$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Cidade:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(38, 5, $row['cidnome'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Cep:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(38, 5, $row['cidcep'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(13, 5, "Bairro:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(78, 5, $row['empendbair'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Endereço:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(98, 5, $row['empend'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Fone:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(38, 5, $row['empfone'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Celular:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(38, 5, $row['celular'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(13, 5, "E-mail:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(28, 5, $row['email'], 0, 1, 'L');

$pdf->Rect(2, 65, 206, 25);

$pdf->Ln(7);

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Nota Fiscal:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['nf'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(32, 5, "Data:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['datanf'], 0, 1, '1');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Ordem Compra:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['odcompra'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(32, 5, "Pedido de venda:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['pedido'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Valor:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, number_format($row['valor'], 2, ',', '.'), 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(32, 5, "Peso:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, number_format($row['peso'], 2, ',', '.'), 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Lote:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['lote'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(40, 5, "Ordem de produção:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['op'], 0, 0, 'L');

$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Descrição da não conformidade:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->MultiCell(205, 5, $row['naoconf'], 1, 'L');


$pdf->Ln(5);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Disposição:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(50, 5, '(' . $row['aceitar'] . ') Aceito condicionalmente', 0, 0, 'L');
$pdf->Cell(50, 5, '(' . $row['recusar'] . ') Reprovar', 0, 1, 'L');

$pdf->Ln(5);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Dados do produto", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);


$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Aplicação:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['aplicacao'], 0, 1, 'L');

if ($aProdutos[0] != '') {

    foreach ($aProdutos as $key => $value) {
        $aDadosProd = explode('-', $value);

        $iAltura = $pdf->GetY();
        $pdf->Rect(2, $iAltura, 206, 30);
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(30, 5, "Produto:", 0, 0, 'L');
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(30, 5, $aDadosProd[1], 0, 1, 'L');

        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(30, 5, "Código:", 0, 0, 'L');
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(30, 5, $aDadosProd[0], 0, 1, 'L');

        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(30, 5, "Quantidade:", 0, 0, 'L');
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(30, 5, $aDadosProd[2], 0, 1, 'L');

        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(30, 5, "Quant. não conf:", 0, 0, 'L');
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(30, 5, $aDadosProd[3], 0, 1, 'L');
    }
}



$pdf->Ln(5);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Análise da RC:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);


$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(45, 5, "Responsável pela análise:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['usuaponta'], 0, 1, 'L');

$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Análise da não conformidade:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->MultiCell(205, 5, $row['apontamento'], 0, 'L');



$pdf->Ln(18);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Análise do setor de Vendas:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(26, 5, "Responsável:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(50, 5, $row['resp_venda_nome'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(26, 5, "Devolução:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(50, 5, $row['devolucao'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(26, 5, "Obs Venda:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->MultiCell(205, 5, $row['obs_aponta'], 0, 'L');



$pdf->Ln(18);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Observação final do Representante:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);


$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(26, 5, "Representante:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(50, 5, $row['usunome_fim'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(26, 5, "Obs Rep.:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->MultiCell(205, 5, $row['obs_fim'], 0, 'L');

if ($sEmailRequest == 'S') {
    $pdf->Output('F', 'app/relatorio/rnc/RC' . $nr . '_empresa_' . $filcgc . '.pdf'); // GERA O PDF NA TELA
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
} else {
    $pdf->Output('I', 'RC' . $nr . '.pdf');
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
}

if ($sEmailRequest == 'S') {
    $aDados = array();
    parse_str($sDados, $aDados);
    $sClasse = $this->getNomeClasse();
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('d/m/Y');
    $hora = date('H:m');

    $oEmail = new Email();
    $oEmail->setMailer();

    $oEmail->setEnvioSMTP();
    //$oEmail->setServidor('mail.construtoramatosteixeira.com.br');
    $oEmail->setServidor('smtp.terra.com.br');
    $oEmail->setPorta(587);
    $oEmail->setAutentica(true);
    $oEmail->setUsuario('metalboweb@metalbo.com.br');
    $oEmail->setSenha('Metalbo@@50');
    $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));



    $sSqlRC = "select convert(varchar,datanf,103)as data,nr,officedes,empcod,empdes,nf,odcompra,pedido,valor,peso,aplicacao,naoconf,resp_venda_cod from tbrncqual"
            . " where filcgc = '" . $filcgc . "' and nr = '" . $nr . "'";
    $DadosRC = $PDO->query($sSqlRC);
    $aRow = $DadosRC->fetch(PDO::FETCH_ASSOC);

    $oEmail->setAssunto(utf8_decode('Inserida nova RNC - Reclamação de cliente'));

    $oEmail->setMensagem(utf8_decode('RECLAMAÇÃO Nº ' . $aRow['nr'] . ' FOI LIBERADA PELO REPRESENTANTE<hr><br/>'
                    . '<b>Representante: ' . $_SESSION['nome'] . ' </b><br/>'
                    . '<b>Escritório: ' . $aRow['officedes'] . ' </b><br/>'
                    . '<b>Hora:' . $hora . '  </b><br/>'
                    . '<b>Data do Cadastro: ' . $data . ' </b><br/><br/><br/>'
                    . '<table border = 1 cellspacing = 2 cellpadding = 2 width = "100%">'
                    . '<tr><td><b>Cnpj:</b></td><td> ' . $aRow['empcod'] . ' </td></tr>'
                    . '<tr><td><b>Razão Social:</b></td><td> ' . $aRow['empdes'] . ' </td></tr>'
                    . '<tr><td><b>Nota fiscal:</b></td><td> ' . $aRow['nf'] . ' </td></tr>'
                    . '<tr><td><b>Data da NF.:</b></td><td> ' . $aRow['data'] . ' </td></tr>'
                    . '<tr><td><b>Od. de compra:</b></td><td> ' . $aRow['odcompra'] . ' </td></tr>'
                    . '<tr><td><b>Pedido Nº:</b></td><td> ' . $aRow['pedido'] . ' </td></tr>'
                    . '<tr><td><b>Valor: R$</b></td><td> ' . number_format($aRow['valor'], 2, ',', '.') . ' </td></tr>'
                    . '<tr><td><b>Peso:</b></td><td> ' . number_format($aRow['peso'], 2, ',', '.') . ' </td></tr>'
                    . '<tr><td><b>Aplicação: </b></td><td> ' . $aRow['aplicacao'] . '</td></tr>'
                    . '<tr><td><b>Não conformidade:</b></td><td> ' . $aRow['naoconf'] . ' </td></tr>'
                    . '</table><br/><br/>'
                    . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                    . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

    $oEmail->limpaDestinatariosAll();

    //busca email venda
    $sSqlMail = "select usuemail from tbusuario where usucodigo ='" . $aRow['resp_venda_cod'] . "' ";
    $DadosMail = $PDO->query($sSqlMail);
    $aRowMail = $DadosMail->fetch(PDO::FETCH_ASSOC);


    //enviar e-mail vendas
    $oEmail->addDestinatario($aRowMail['usuemail']);
    //$oEmail->addDestinatario('alexandre@metalbo.com.br');

    $oEmail->addAnexo('app/relatorio/rnc/RC' . $nr . '_empresa_' . $filcgc . '.pdf', utf8_decode('RC nº' . $nr . '_empresa_' . $filcgc));
    $aRetorno = $oEmail->sendEmail();
    if ($aRetorno[0]) {
        $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
        echo $oMensagem->getRender();
    } else {
        $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo ou tente reenviar o e-mail! ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
        echo $oMensagem->getRender();
    }
    return $aRetorno;
}

