<?php

if (isset($_REQUEST['email'])) {
    $sEmailRequest = 'S';
} else {
    $sEmailRequest = 'N';
}

// Diretórios
if ($sEmailRequest == 'S') {
    include 'biblioteca/fpdf/fpdf.php';
} else {
    include '../../biblioteca/fpdf/fpdf.php';
    include("../../includes/Config.php");
    include("../../includes/Fabrica.php");
    include("../../biblioteca/Utilidades/Email.php");
}

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação
    }

}

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(5, 5); // DEFINE O X E O Y NA PAGINA
//Caminho da logo
if ($sEmailRequest == 'S') {
    $sLogo = 'biblioteca/assets/images/steelrel.png';
} else {
    $sLogo = '../../biblioteca/assets/images/steelrel.png';
}
$pdf->SetMargins(5, 5, 5);


$aNrs = $_REQUEST['nrcert'];
$sNomeCert = $_REQUEST['notaRetorno'];

$icont = 0;
$sCertsRel = '';
foreach ($aNrs as $key => $aNr) {
    //Quebra pagina após duas op
    if ($icont == 1) {
        $pdf->AddPage();
        $pdf->SetXY(5, 5);
        $icont = 0;
    }
    $icont++;

    $sCertsRel .= $aNr . ',';

//Caminho do usuário, data e hora
    date_default_timezone_set('America/Sao_Paulo');
    $data = date("d/m/y");                     //função para pegar a data local
    $hora = date("H:i");                       //para pegar a hora com a função date
    $useRel = $_REQUEST['userRel'];

//Inserção do cabeçalho
    $pdf->Cell(40, 10, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY() + 2, 40, 10), 0, 0, 'L');

//busca os dados do banco pegando a op do foreach
    $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    $sSql = "select STEEL_PCP_Certificado.nrcert,
            convert(varchar,STEEL_PCP_Certificado.dataensaio,103)as dataensaio,
            convert(varchar,STEEL_PCP_Certificado.dataemissao,103)as dataemissao,
            empdes,notasteel,notacliente,
            convert(varchar,STEEL_PCP_ordensFab.data,103) as datafab,
            STEEL_PCP_ordensFab.matdes,
            STEEL_PCP_ordensFab.referencia,
            STEEL_PCP_ordensFab.durezaNucMin,
            STEEL_PCP_ordensFab.durezaNucMax,
            STEEL_PCP_ordensFab.NucEscala,
            STEEL_PCP_ordensFab.durezaSuperfMin ,
            STEEL_PCP_ordensFab.durezaSuperfMax ,
            STEEL_PCP_ordensFab.superEscala,
            STEEL_PCP_ordensFab.expCamadaMin,
            STEEL_PCP_ordensFab.expCamadaMax,
            STEEL_PCP_ordensFab.fioDurezaSol,
            STEEL_PCP_ordensFab.fioEsferio,
            STEEL_PCP_ordensFab.fioDescarbonetaTotal,
            STEEL_PCP_ordensFab.fioDescarbonetaParcial,
            STEEL_PCP_ordensFab.DiamFinalMin,
            STEEL_PCP_ordensFab.DiamFinalMax,
            STEEL_PCP_Certificado.durezaNucMin as certDurezaNucMin,
            STEEL_PCP_Certificado.durezaNucMax as certDurezaNucMax,
            STEEL_PCP_Certificado.NucEscala as certNucEscala,
            STEEL_PCP_Certificado.durezaSuperfMin as certDurezaSuperfMin,
            STEEL_PCP_Certificado.durezaSuperfMax as certDurezaSuperfMax,
            STEEL_PCP_Certificado.superEscala as certSuperEscala,
            STEEL_PCP_Certificado.expCamadaMin as certExpCamadaMin,
            STEEL_PCP_Certificado.expCamadaMax as certExpCamadaMax,
            STEEL_PCP_Certificado.fioDurezaSol as certFioDurezaSol,
            STEEL_PCP_Certificado.fioEsferio as certFioEsferio,
            STEEL_PCP_Certificado.fioDescarbonetaTotal as certFioDescarbonetaTotal,
            STEEL_PCP_Certificado.fioDescarbonetaParcial as certFioDescarbonetaParcial,
            STEEL_PCP_Certificado.DiamFinalMin as certDiamFinalMin,
            STEEL_PCP_Certificado.DiamFinalMax as certDiamFinalMax,
            tratrevencomp,receita,inspeneg,receita_des,
            STEEL_PCP_Certificado.procod,
            STEEL_PCP_Certificado.prodes,
            STEEL_PCP_Certificado.peso,
            STEEL_PCP_Certificado.opcliente,
            STEEL_PCP_Certificado.op,
            STEEL_PCP_Certificado.conclusao, tipoOrdem, prodFinal, prodesFinal,
            convert(varchar,STEEL_PCP_Certificado.dataNotaRetorno,103) as dataNotaRetorno,
            STEEL_PCP_Certificado.micrografia
            from STEEL_PCP_Certificado left outer join STEEL_PCP_ordensFab 
            on STEEL_PCP_ordensFab.op = STEEL_PCP_Certificado.op
            where STEEL_PCP_Certificado.nrcert =" . $aNr . " ";
    $dadosNr = $PDO->query($sSql);
    $row = $dadosNr->fetch(PDO::FETCH_ASSOC);

    $sSqlItens = "select tratdes,STEEL_PCP_ordensFabItens.tratamento,
                STEEL_PCP_tratamentos.tratcod,tratrevencomp 
                from STEEL_PCP_ordensFabItens left outer join STEEL_PCP_tratamentos 
                on STEEL_PCP_ordensFabItens.tratamento = STEEL_PCP_tratamentos.tratcod  
                where op =" . $row['op'] . " order by op";

    $dadosItensOp = $PDO->query($sSqlItens);

    $pdf->SetFont('Arial', '', 15);
    $pdf->Cell(110, 15, 'CONTROLE DE QUALIDADE', '', 0, 'C', 0);

    $pdf->SetFont('Arial', '', 9);
    $pdf->MultiCell(52, 7, 'Data: ' . $data
            . '        Hora:' . $hora
            . ' Usuário:' . $useRel
            . ' ', '', 'L', 0);
    $pdf->Cell(0, 2, '', 'B', 1, 'L');
    $pdf->Cell(0, 1, '', '', 1, 'L');
    $pdf->Cell(0, 5, '', '', 1, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(199, 5, 'CERTIFICADO Nº: ' . $aNr, 'B', 1, 'L');
    $pdf->Cell(0, 2, '', '', 1, 'L');
    /////////////////////////////////////////////
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 5, 'Empresa: ', '', 0, 'R');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(144, 5, $row['empdes'], '', 1, 'L');
    $pdf->Cell(0, 2, '', '', 1, 'L');
    /////////////////////////////////////////////
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 5, 'Nota Fiscal de Recebimento: ', '', 0, 'R');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(80, 5, $row['notacliente'], '', 0, 'L');

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(10, 5, 'Data entrada: ', '', 0, 'R');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(54, 5, $row['datafab'], '', 1, 'L');
    $pdf->Cell(0, 2, '', '', 1, 'L');
    ////////////////////////////////////////////
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 5, 'Nota Fiscal de Retorno: ', '', 0, 'R');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(80, 5, $row['notasteel'], '', 0, 'L');

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(10, 5, 'Data saída: ', '', 0, 'R');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(54, 5, $row['dataNotaRetorno'], '', 1, 'L');
    $pdf->Cell(0, 2, '', '', 1, 'L');
    ///////////////////////////////////////////
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 5, 'Data de Realização do Ensaio: ', '', 0, 'R');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(80, 5, $row['dataensaio'], '', 0, 'L');

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(10, 5, 'Peso: ', '', 0, 'R');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(54, 5, number_format($row['peso'], 2, ',', '.'), '', 1, 'L');
    $pdf->Cell(0, 2, '', '', 1, 'L');
    //////////////////////////////////////////
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 5, 'Op do Cliente: ', '', 0, 'R');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(144, 5, $row['opcliente'], '', 1, 'L');
    $pdf->Cell(0, 2, '', '', 1, 'L');
    //////////////////////////////////////////
    //VERIFICA DIFERENÇA DE PRODUTO PADRÃO E PRODUTO ACABADO
    //Verifica se fio maquina ou Arrame
    if (($row['tipoOrdem'] == "F") || ($row['tipoOrdem'] == "A")) {

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Descrição das peças: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, $row['referencia'], '', 0, 'L');
        $pdf->Cell(120, 5, $row['prodesFinal'], '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');

        //////////////////////////////////////////
        $pdf->Cell(0, 6, '', '', 1, 'L');
        /////////////////////////////////////////

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(199, 5, 'ESPECIFICAÇÕES DO CLIENTE', 'B', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        /////////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Material: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, $row['matdes'], '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ////////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Tratamento Térmico: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(36, 5, $row['receita_des'], '', 0, 'L');
        $pdf->Cell(0, 5, '', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');

        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Dureza Solicitada: ', '', 0, 'R'); ////////////////////////////////////////
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, number_format($row['fioDurezaSol'], 0, ',', '.') . "  HRB", '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Resistência a Tração: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, 'N/A', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Descarbonetação (Parcial - Total): ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, number_format($row['fioDescarbonetaParcial'], 2, ',', '.') . ' - '
                . number_format($row['fioDescarbonetaTotal'], 2, ',', '.') . ' µm', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        //////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Esferoidização: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, number_format($row['fioEsferio'], 2, ',', '.') . ' %', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        //////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Diametro Solicitado (Mín. - Máx.): ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, number_format($row['DiamFinalMin'], 2, ',', '.') . ' - '
                . number_format($row['DiamFinalMax'], 2, ',', '.') . ' mm', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////
        //////////////////////////////////////////
        $pdf->Cell(0, 6, '', '', 1, 'L');
        /////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(199, 5, 'RESULTADOS DO TRATAMENTO', 'B', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        /////////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Ordem de Produção: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, $row['op'], '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ////////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Execução no Processo: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(36, 5, $row['receita_des'], 0, 'L');
        $pdf->Cell(0, 5, '', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');

        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Dureza Obtida: ', '', 0, 'R'); ////////////////////////////////////////
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, number_format($row['certFioDurezaSol'], 0, ',', '.') . "  HRB", '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ////////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Resistência a Tração: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, 'N/A', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Descarbonetação (Parcial - Total): ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, number_format($row['certFioDescarbonetaParcial'], 2, ',', '.') . ' - '
                . number_format($row['certFioDescarbonetaTotal'], 2, ',', '.') . ' µm', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Esferoidização: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, number_format($row['certFioEsferio'], 2, ',', '.') . ' %', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        //////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Diametro Encontrado (Mín. - Máx.): ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, number_format($row['certDiamFinalMin'], 2, ',', '.') . ' - '
                . number_format($row['certDiamFinalMax'], 2, ',', '.') . ' mm', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');

        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Número da Receita: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, $row['receita'], '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////
        //////////////////////////////////////////
        $pdf->Cell(0, 5, '', '', 1, 'L');
        /////////////////////////////////////////

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(199, 5, 'CONCLUSÃO', 'B', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        /////////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(199, 5, $row['conclusao'], 0, 'J');
    }

    //Verifica se padrão
    if ($row['tipoOrdem'] == "P") {

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Descrição das peças: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, $row['referencia'], '', 0, 'L');
        $pdf->Cell(120, 5, $row['prodes'], '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');

        //////////////////////////////////////////
        $pdf->Cell(0, 6, '', '', 1, 'L');
        /////////////////////////////////////////

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(199, 5, 'ESPECIFICAÇÕES DO CLIENTE', 'B', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        /////////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Material: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, $row['matdes'], '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ////////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Tratamento Térmico: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $sk = '+';
        $ik = 0;
        $oTratamento = '';
        while ($rowIten = $dadosItensOp->fetch(PDO::FETCH_ASSOC)) {
            //analisa se é necessário buscar o complemento da descrição do tratamento na tela ordensFab
            $rowReve['tratrevencomp'] = '';
            if ($rowIten['tratrevencomp'] == 'Sim') {
                $sSqlOpRevenimento = "select tratrevencomp from STEEL_PCP_ordensFab  where op =" . $row['op'] . "  ";
                $dadosReven = $PDO->query($sSqlOpRevenimento);
                $rowReve = $dadosReven->fetch(PDO::FETCH_ASSOC);
            }
            $pdf->SetFont('Arial', 'B', 10);
            $oTratamento = $rowIten['tratdes'] . ' ' . $rowReve['tratrevencomp'] . '' . $sk . '';
            $sk = substr_replace($sk, ' ', 0);
            if ($ik == 0) {
                $oTratamento1 = $oTratamento;
                $ik++;
            }
        }
        $pdf->Cell(36, 5, $oTratamento1 . ' ' . $oTratamento, '', 0, 'L');
        $pdf->Cell(0, 5, '', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');

        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Dureza Solicitada da Superfície: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        if (($row['durezaSuperfMin'] != 0) && ($row['durezaSuperfMax'] != 0)) {
            $pdf->Cell(144, 5, number_format($row['durezaSuperfMin'], 0, ',', '.') . " - " .
                    number_format($row['durezaSuperfMax'], 0, ',', '.') . "  " . $row['superEscala'], '', 1, 'L');
        } else if ($row['durezaSuperfMax'] != 0) {
            $pdf->Cell(144, 5, "Max " . number_format($row['durezaSuperfMax'], 0, ',', '.') . "  " . $row['superEscala'], '', 1, 'L');
        } else if ($row['durezaSuperfMin'] != 0) {
            $pdf->Cell(144, 5, "Min " . number_format($row['durezaSuperfMin'], 0, ',', '.') . "  " . $row['superEscala'], '', 1, 'L');
        } else {
            $pdf->Cell(144, 5, 'N/A', '', 1, 'L');
        }

        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Dureza Solicitada do Núcleo: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);

        if ((number_format($row['durezaNucMin'], 0, ',', '.') != '0') || (number_format($row['durezaNucMax'], 0, ',', '.') != '0')) {
            $pdf->Cell(144, 5, number_format($row['durezaNucMin'], 0, ',', '.') . " - " .
                    number_format($row['durezaNucMax'], 0, ',', '.') . "  " . $row['NucEscala'], '', 1, 'L');
        } else {
            $pdf->Cell(144, 5, 'N/A', '', 1, 'L');
        }

        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Resistência a Tração: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, 'N/A', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Profundidade da Camada: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        if ((number_format($row['expCamadaMin'], 3, ',', '.') != '0,000') || (number_format($row['expCamadaMax'], 3, ',', '.') != '0,000')) {
            $pdf->Cell(144, 5, number_format($row['expCamadaMin'], 3, ',', '.') . " - " .
                    number_format($row['expCamadaMax'], 3, ',', '.') . ' mm', '', 1, 'L');
        } else {
            $pdf->Cell(144, 5, 'N/A', '', 1, 'L');
        }

        $pdf->Cell(0, 2, '', '', 1, 'L');
        //////////////////////////////////////////
        $pdf->Cell(0, 6, '', '', 1, 'L');
        /////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(199, 5, 'RESULTADOS DO TRATAMENTO', 'B', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        /////////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Ordem de Produção: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, $row['op'], '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ////////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Execução no Processo: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(36, 5, $oTratamento1 . ' ' . $oTratamento, '', 0, 'L');
        $pdf->Cell(0, 5, '', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');

        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Dureza da Superfície: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        if (($row['certDurezaSuperfMin'] != 0) && ($row['certDurezaSuperfMax'] != 0)) {
            $pdf->Cell(144, 5, number_format($row['certDurezaSuperfMin'], 0, ',', '.') . " - " .
                    number_format($row['certDurezaSuperfMax'], 0, ',', '.') . "  " . $row['superEscala'], '', 1, 'L');
        } else if ($row['certDurezaSuperfMax'] != 0) {
            $pdf->Cell(144, 5, "Max " . number_format($row['certDurezaSuperfMax'], 0, ',', '.') . "  " . $row['superEscala'], '', 1, 'L');
        } else if ($row['certDurezaSuperfMin'] != 0) {
            $pdf->Cell(144, 5, "Min " . number_format($row['certDurezaSuperfMin'], 0, ',', '.') . "  " . $row['superEscala'], '', 1, 'L');
        } else {
            $pdf->Cell(144, 5, 'N/A', '', 1, 'L');
        }
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Dureza do Núcleo: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        if ((number_format($row['certDurezaNucMin'], 0, ',', '.') != '0') || (number_format($row['certDurezaNucMax'], 0, ',', '.') != '0')) {
            $pdf->Cell(144, 5, number_format($row['certDurezaNucMin'], 0, ',', '.') . " - " .
                    number_format($row['certDurezaNucMax'], 0, ',', '.') . "  " . $row['certNucEscala'], '', 1, 'L');
        } else {
            $pdf->Cell(144, 5, 'N/A', '', 1, 'L');
        }
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Resistência a Tração: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, 'N/A', '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Profundidade da Camada: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        if ((number_format($row['certExpCamadaMin'], 3, ',', '.') != '0,000') || (number_format($row['certExpCamadaMax'], 3, ',', '.') != '0,000')) {
            $pdf->Cell(144, 5, number_format($row['certExpCamadaMin'], 3, ',', '.') . " - " .
                    number_format($row['certExpCamadaMax'], 3, ',', '.') . 'mm', '', 1, 'L');
        } else {
            $pdf->Cell(144, 5, 'N/A', '', 1, 'L');
        }
        $pdf->Cell(0, 2, '', '', 1, 'L');

        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Micrografia: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        if($row['micrografia']==null){
            $pdf->Cell(144, 5,'Isento de Ferrita Delta, carbonetação e Descarbonetação', '', 1, 'L');
        }else{
            $pdf->Cell(144, 5, $row['micrografia'], '', 1, 'L');
        }
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Número da Receita: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(144, 5, $row['receita'], '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        ///////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, 'Inspeção do Enegrecimento: ', '', 0, 'R');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(119, 5, $row['inspeneg'], '', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');

        //////////////////////////////////////////
        $pdf->Cell(0, 5, '', '', 1, 'L');
        /////////////////////////////////////////

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(199, 5, 'CONCLUSÃO', 'B', 1, 'L');
        $pdf->Cell(0, 2, '', '', 1, 'L');
        /////////////////////////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(199, 5, $row['conclusao'], 0, 'J');
    }

    $pdf->Ln();
}

//retira ultimo caracter var de ops separado por vírgula
$sCertsRel = substr_replace($sCertsRel, '', -1);
if ($sEmailRequest == 'S') {
    $pdf->Output('F', 'app/relatorio/steeltrater_cert/Certificado NF ' . $sNomeCert . '.pdf'); // GERA O PDF NA TELA
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
} else {
    $pdf->Output('I', 'Certificado NF ' . $sNomeCert . '.pdf');
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
}

//pega hora do dia
$hr = date(" H ");
if ($hr >= 12 && $hr < 18) {
    $resp = "Boa tarde!";
} else if ($hr >= 0 && $hr < 12) {
    $resp = "Bom dia!";
} else {
    $resp = "Boa noite!";
}


//envia por email se necessário
if ($sEmailRequest == 'S') {

    $oEmail = new Email();
    $oEmail->setMailer();
    /* testes */
    $oEmail->setEnvioSMTP();
    //$oEmail->setServidor('mail.construtoramatosteixeira.com.br');
  /*  $oEmail->setServidor('smtp.terra.com.br');
    $oEmail->setPorta(587);
    $oEmail->setAutentica(true);
    $oEmail->setUsuario('laboratorio@steeltrater.com.br');
    $oEmail->setSenha('n2w5p7k4');
    $oEmail->setRemetente(utf8_decode('laboratorio@steeltrater.com.br'), utf8_decode('Certificados SteelTrater'));*/
    
     $oEmail->setServidor('smtp.gmail.com');
        $oEmail->setPorta(465);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@gmail.com');
        $oEmail->setSenha('7&t+Ah8*Qz!z');
        $oEmail->setProtocoloSMTP('ssl');
        $oEmail->setRemetente(utf8_decode('metalboweb@gmail.com'), utf8_decode('Certificados SteelTrater'));

    $oEmail->setAssunto(utf8_decode('Certificado(s) NF ' . $sNomeCert));
    $oEmail->setMensagem(utf8_decode($resp . '<br/><br/>Segue em anexo os certificados da nota fiscal  ' . $sNomeCert));
    $oEmail->limpaDestinatariosAll();

    //busca array de destinatários
    //$_REQUEST['empresaCert']
    if (isset($_REQUEST['empresaCert'])) {
        $sEmpCert = $_REQUEST['empresaCert'];
    } else {
        $sEmpCert = '';
    }

    $aEmails = array();
    $oContatos = Fabrica::FabricarController('STEEL_PCP_contatoCert');
    $oContatos->Persistencia->adicionaFiltro('emp_codigo', $sEmpCert);
    $aModelContato = $oContatos->Persistencia->getArrayModel();
    foreach ($aModelContato as $oContatoCert) {
        $aEmails[] = $oContatoCert->getEmpcertemail();
    }
    //para se não tiver contatos
    if (count($aEmails) == 0) {
        $oModal = new Modal('Atenção!', 'Não tem cadastro de e-mail para esta empresa!', Modal::TIPO_INFO, false);
        echo $oModal->getRender();
    }

    // Para
    $aDestinatario = array();
    //$aEmails[] = 'avaneim@gmail.com';
    foreach ($aEmails as $sEmail) {
        $oEmail->addDestinatario($sEmail);
        $aDestinatario[] = $sEmail;
    }

    $oEmail->addAnexo('app/relatorio/steeltrater_cert/Certificado NF ' . $sNomeCert . '.pdf', utf8_decode('Certificado(s) NF ' . $sNomeCert));

    $aRetorno = $oEmail->sendEmail();
    if ($aRetorno[0]) {
        $oMensagem = new Mensagem('Sucesso!', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
        echo $oMensagem->getRender();
    } else {
        $oMensagem = new Mensagem('Atenção!', 'E-mail não enviado ' . $aRetorno[1], Mensagem::TIPO_WARNING);
        echo $oMensagem->getRender();
    }
    $aRetorno[2] = $aDestinatario;
    return $aRetorno;
}