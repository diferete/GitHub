<?php

// Diretórios
if ($_REQUEST['output'] == 'email') {
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

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $sRepCod = $_REQUEST['repcod'];
        $this->SetXY(15, 274);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação
        $sRepDados = retornaArrayCabRepres($sRepCod);
        $x = $this->GetX();
        $y = $this->GetY();
        if ($_REQUEST['output'] == 'email') {
            $this->SetFont('Arial', '', 10); // seta fonte no rodape
            $this->Cell(80, 5, $sRepDados->nome, 0, 1, 'L');
            $this->SetFont('Arial', '', 8);
            $this->Cell(80, 2, $sRepDados->email1, 0, 1, 'L');
            $this->Cell(80, 3, $sRepDados->email2, 0, 1, 'L');
            $this->SetXY($x + 70, $y);
            $this->SetFont('Arial', '', 8);
            $this->Cell(50, 5, 'FONE: ' . $sRepDados->fone1, 0, 1, 'L');
            $this->SetFont('Arial', '', 8);
            $this->SetX($x + 70);
            $this->Cell(50, 3, 'FONE: ' . $sRepDados->fone2, 0, 0, 'L');
            $this->SetXY($x + 100, $y + 3);
            $this->SetFont('Arial', '', 9);
            $this->Cell(83, 5, 'Metalbo Indústria de Fixadores Metálicos LTDA.', 0, 0, 'R');
            $this->Image('biblioteca/assets/images/metalbo-preta.png', 185, 286, 20);
        } else {

            $this->SetFont('Arial', '', 10); // seta fonte no rodape
            $this->Cell(80, 5, $sRepDados->nome, 0, 1, 'L');
            $this->SetFont('Arial', '', 8);
            $this->Cell(80, 2, $sRepDados->email1, 0, 1, 'L');
            $this->Cell(80, 3, $sRepDados->email2, 0, 1, 'L');
            $this->SetXY($x + 70, $y);
            $this->SetFont('Arial', '', 8);
            $this->Cell(50, 5, 'FONE: ' . $sRepDados->fone1, 0, 1, 'L');
            $this->SetX($x + 70);
            $this->SetFont('Arial', '', 8);
            $this->Cell(50, 3, 'FONE: ' . $sRepDados->fone2, 0, 0, 'L');
            $this->SetXY($x + 100, $y + 3);
            $this->SetFont('Arial', '', 9);
            $this->Cell(83, 5, 'Metalbo Indústria de Fixadores Metálicos LTDA.', 0, 0, 'R');
            $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 185, 286, 20);
        }
    }

}

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE
//SETAR O TÍTULO DA PÁGINA
$NR = $_REQUEST['nr'];
$sTabCab = $_REQUEST['tabcab'];
$sTabIten = $_REQUEST['itencab'];
$sDiretorio = $_REQUEST['diroffice'];
if (isset($_REQUEST['logo'])) {
    $sLogo = $_REQUEST['logo'];
} else {
    $sLogo = '';
}
$sImgRel = $_REQUEST['imgrel'];


$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = "  select " . $sTabCab . ".NR,CNPJ,CLIENTE,widl.emp01.empfone,
            CODPGT,CPGT,ODCOMPRA,
            TRANSCNPJ,TRANSP,CODREP,REP,convert(varchar," . $sTabCab . ".DATA,103)as data,OBS,
            " . $sTabCab . ".DATA as dataemiss,
            CONVERT(varchar,DTENT,103)as dtent,contato,cidnome,estcod,frete
            from " . $sTabCab . " left outer join widl.EMP01
            on " . $sTabCab . ".CNPJ = widl.EMP01.empcod left outer join widl.CID01
            on widl.EMP01.cidcep = widl.CID01.cidcep
            where " . $sTabCab . ".NR =" . $NR;
$dadoscab = $PDO->query($sSql);
while ($row = $dadoscab->fetch(PDO::FETCH_ASSOC)) {
    $nrsol = $row["NR"];
    $cnpj = $row["CNPJ"];
    $cliente = $row["CLIENTE"];
    $empfone = $row["empfone"];
    $codpgt = $row["CODPGT"];
    $condpag = $row["CPGT"];
    $odcompra = $row["ODCOMPRA"];
    $transcnpj = $row["TRANSCNPJ"];
    $transp = $row["TRANSP"];
    $codrep = $row["CODREP"];
    $rep = $row["REP"];
    $data = $row["data"];
    $obs = $row["OBS"];
    $cidnome = $row["cidnome"];
    $estcod = $row["estcod"];
    $dtent = $row["dtent"];
    $contato = $row["contato"];
    $frete = $row["frete"];
    $dataEmiss = $row['dataemiss'];
}

$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);
$pdf->Rect(2, 32, 206, 50);

if ($_REQUEST['output'] == 'email') {
    if ($sLogo != 'semlogo') {
        if ($sImgRel != '') {
            $pdf->Image('Uploads/' . $sImgRel, 3, 10, 40);
        } else {
            $pdf->Image('biblioteca/assets/images/logomet.png', 3, 10, 40);
        }
    }
} else {
    if ($sLogo != 'semlogo') {
        if ($sImgRel != '') {
            $pdf->Image('../../Uploads/' . $sImgRel, 3, 10, 40);
        } else {
            $pdf->Image('../../biblioteca/assets/images/logomet.png', 3, 10, 40);
        }
    }
}

$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(190, 18, 'COTAÇÃO DE VENDA Nº ' . $NR . '', 0, 1, 'C');
$pdf->Ln(5);
//cliente
$pdf->SetFont('arial', '', 9);
$pdf->Cell(30, 5, "Cliente:", 0, 0, 'L');
$pdf->Cell(30, 5, $cnpj, 0, 0, 'L');
$pdf->Cell(130, 5, $cliente, 0, 1, 'L');
//cidade
$pdf->Cell(30, 5, "Cidade:", 0, 0, 'L');
$pdf->setFont('arial', '', 9);
$pdf->Cell(50, 5, $cidnome, 0, 0, 'L');
//estado
$pdf->Cell(20, 5, "Estado:", 0, 0, 'L');
$pdf->setFont('arial', '', 9);
$pdf->Cell(50, 5, $estcod, 0, 1, 'L');
//telefone
$pdf->Cell(30, 5, "Telefone:", 0, 0, 'L');
$pdf->setFont('arial', '', 9);
$pdf->Cell(50, 5, $empfone, 0, 1, 'L');
//Ordem de compra
$pdf->Cell(30, 5, "Ordem de compra:", 0, 0, 'L');
$pdf->setFont('arial', '', 9);
$pdf->Cell(50, 5, $odcompra, 0, 1, 'L');
//transportadora
$pdf->Cell(30, 5, "Transportadora:", 0, 0, 'L');
$pdf->setFont('arial', '', 9);
$pdf->Cell(30, 5, $transcnpj, 0, 0, 'L');
//estado
$pdf->Cell(80, 5, $transp, 0, 1, 'L');
//frete
$pdf->Cell(30, 5, "Frete:", 0, 0, 'L');
$pdf->setFont('arial', '', 9);
$pdf->Cell(50, 5, $frete, 0, 1, 'L');
//representante
$pdf->Cell(30, 5, "Representante:", 0, 0, 'L');
$pdf->setFont('arial', '', 9);
$pdf->Cell(15, 5, $codrep, 0, 0, 'L');
//estado
$pdf->Cell(80, 5, $rep, 0, 1, 'L');
//data emissao
$pdf->Cell(30, 5, "Data Emissão:", 0, 0, 'L');
$pdf->setFont('arial', '', 9);
$pdf->Cell(50, 5, $data, 0, 0, 'L');
$pdf->Cell(20, 5, "Cond. Pgto:", 0, 0, 'L');
$pdf->setFont('arial', '', 9);
$pdf->Cell(30, 5, $condpag, 0, 1, 'L');
//data de entrega
$pdf->Cell(30, 5, "Data Faturamento:", 0, 0, 'L');
$pdf->setFont('arial', '', 9);
$pdf->Cell(50, 5, $dtent, 0, 1, 'L');
$pdf->Ln(5);
//observação
$pdf->Rect(2, 82, 206, 34);
$pdf->Cell(60, 5, "Obs", 0, 1, 'L');
$pdf->MultiCell(190, 7, $obs, 0, 'J');


/* * ********************** CABEÇALHO DA TABELA ************************* */
//define a altura inicial dos dados
$pdf->SetY(117);
$iAlturaRet = 122; // Y (altura) INICIAL DOS DADOS 
$l = 5; // ALTURA DA LINHA

$pdf->Cell(9, 5, 'Seq', 0, 0, 'L');
$pdf->Cell(18, 5, 'Código', 0, 0, 'L');
$pdf->Cell(115, 5, 'Descrição', 0, 0, 'L');
$pdf->Cell(20, 5, 'Qt Cto', 0, 0, 'L');
$pdf->Cell(20, 5, 'R$');
$pdf->Cell(20, 5, 'R$ Total', 0, 1, 'L');
/**
 * Select dos dados
 */
$nrItens = $_REQUEST['nr'];

if (strtotime($dataEmiss) >= strtotime('2022-03-01')) {
    $sIpi = '7.5';
} else {
    $sIpi = '10';
}

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
//gera o somatório
$sSql = "select sum(VLRTOT)as total,sum(coalesce(quant*propesprat,0))as peso,
sum(VLRTOT+(VLRTOT*" . $sIpi . "/100))as totalipi 
from " . $sTabIten . " inner join widl.prod01(nolock) 
on " . $sTabIten . ".CODIGO = widl.prod01.procod   
where NR =" . $nrItens;
$row = $PDO->query($sSql);
$rowTotal = $row->fetch(PDO::FETCH_OBJ);
$total = $rowTotal->total;
$totalPeso = $rowTotal->peso;
$totalipi = $rowTotal->totalipi;

$sSql = "select seq,CODIGO,DESCRICAO,QUANT,VLRUNIT,VLRTOT,pdfdisp from " . $sTabIten . " where NR =" . $nrItens . " order by seq";
$dadosItens = $PDO->query($sSql);
while ($row = $dadosItens->fetch(PDO::FETCH_ASSOC)) {
    $seq = $row['seq'];
    $codigo = $row['CODIGO'];
    $descricao = $row['DESCRICAO'];
    $quant = $row['QUANT'];
    $vlrunit = $row['VLRUNIT'];
    $vlrtot = $row['VLRTOT'];
    //$disp = $row['pdfdisp'];

    $pdf->setFont('arial', '', 8);
    if ($iAlturaRet + $l >= 275) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $iAlturaRet = 10;  // Altura na segunda página
        $pdf->Rect(2, $iAlturaRet, 206, 5);

        $pdf->Cell(9, 5, 'Seq', 0, 0, 'L');
        $pdf->Cell(18, 5, 'Código', 0, 0, 'L');
        $pdf->Cell(115, 5, 'Descrição', 0, 0, 'L');
        $pdf->Cell(20, 5, 'Qt Cto', 0, 0, 'L');
        $pdf->Cell(20, 5, 'R$');
        $pdf->Cell(20, 5, 'R$ Total', 0, 1, 'L');
        $iAlturaRet = $iAlturaRet + 5;
    }
    $pdf->Cell(9, 5, $seq, 0, 0, 'L');
    $pdf->Cell(18, 5, $codigo, 0, 0, 'L');
    $pdf->Cell(115, 5, $descricao, 0, 0, 'L');
    $pdf->Cell(20, 5, number_format($quant, 2, ',', '.'), 0, 0, 'L');
    $pdf->Cell(20, 5, number_format($vlrunit, 2, ',', '.'), 0, 0, 'L');
    $pdf->Cell(20, 5, number_format($vlrtot, 2, ',', '.'), 0, 1, 'L');
    //$pdf->Cell(18, 5, $disp, 0, 1, 'L');
    $pdf->Rect(2, $iAlturaRet, 206, 5);
    $iAlturaRet = $iAlturaRet + 5;
}
//totalizadores
$pdf->setFont('arial', '', 9);
$pdf->Ln(5);
$pdf->Cell(10, 5, "Peso:", 0, 0, 'L');
$pdf->Cell(20, 5, number_format($totalPeso, 2, ',', '.'), 0, 0, 'L');
$pdf->Cell(115, 5, "", 0, 0, 'L');
$pdf->Cell(28, 5, "Total Produtos: R$", 0, 0, 'L');
$pdf->Cell(20, 5, number_format($total, 2, ',', '.'), 0, 1, 'L');

$pdf->Cell(145, 5, "", 0, 0, 'L');
$pdf->Cell(28, 5, "Total c/ipi:         R$", 0, 0, 'L');
$pdf->Cell(20, 5, number_format($totalipi, 2, ',', '.'), 0, 1, 'L');

if (isset($_REQUEST['st'])) {
    $pdf->Cell(145, 5, "", 0, 0, 'L');
    $pdf->Cell(28, 5, "Total St:            R$", 0, 0, 'L');
    $pdf->Cell(20, 5, $_REQUEST['st'], 0, 0, 'L');
}

if ($_REQUEST['output'] == 'email') {
    $pdf->Output('F', 'app/relatorio/representantes/' . $sDiretorio . '/cotacao' . $NR . '.pdf'); // GERA O PDF NA TELA
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
} else {
    $pdf->Output('I', 'cotacao' . $NR . '.pdf');
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
}


if ($_REQUEST['output'] == 'email') {
    $oEmail = new Email();
    $oEmail->setMailer();
    $oEmail->setEnvioSMTP();
    $oEmail->setServidor(Config::SERVER_SMTP);
    $oEmail->setPorta(Config::PORT_SMTP);
    $oEmail->setAutentica(true);
    $oEmail->setUsuario(Config::EMAIL_SENDER);
    $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
    $oEmail->setProtocoloSMTP(Config::PROTOCOLO_SMTP);
    $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('Relatórios Web Metalbo'));

    $oEmail->setAssunto(utf8_decode('Cotaçao de venda nº' . $NR));
    $oEmail->setMensagem(utf8_decode('Anexo cotação de venda nº' . $NR));
    $oEmail->limpaDestinatariosAll();

    // Para
    $aEmails = array();
    $aEmails[] = $_SESSION['email'];
    foreach ($aEmails as $sEmail) {
        $oEmail->addDestinatario($sEmail);
    }

    $oEmail->addAnexo('app/relatorio/representantes/' . $sDiretorio . '/cotacao' . $NR . '.pdf', utf8_decode('Cotação de venda nº' . $NR . '.pdf'));
    $aRetorno = $oEmail->sendEmail();
    if ($aRetorno[0]) {
        return true;
    } else {
        return false;
    }
}
/*
 * Função que retorna um array do nome, email e número de telefone dos representantes
 */

function retornaArrayCabRepres($sRepCod) {

    $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    $sSql = "select nome,email1,email2, fone1, fone2 from tbrepsite where repcodoffice=" . $sRepCod . " group by nome, email1,email2, fone1, fone2";
    $row = $PDO->query($sSql);
    $rowTotal = $row->fetch(PDO::FETCH_OBJ);
    return $rowTotal;
}
