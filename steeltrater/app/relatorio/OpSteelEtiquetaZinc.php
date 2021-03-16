<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
require '../../biblioteca/code/code39.php';
include("../../includes/Config.php");

// Define the parameters for the shell command
$location = "\\rexsistema\delonei\Notas";
$user = "administrator";
$pass = "M@quinas@4321";
$letter = "L";

// Map the drive
system("net use " . $letter . ": \"" . $location . "\" " . $pass . " /user:" . $user . " /persistent:no>nul 2>&1");

// Open the directory
//captura o número da op
date_default_timezone_set('America/Sao_Paulo');
$aOps = $_REQUEST['ops'];
$data = date("d/m/y");                     //função para pegar a data local
$hora = date("H:i");                       //para pegar a hora com a função date
$useRel = $_REQUEST['userRel'];

class PDF extends FPDF {
    
}

//CRIA UM NOVO ARQUIVO PDF NO TAMANHO [80,175]
$pdf = new PDF_Code39('P', 'mm', [80, 150]);
$pdf->SetMargins(3, 4);
$pdf->SetAutoPageBreak(FALSE);
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$sLogo = '../../biblioteca/assets/images/steelrel.png';

$icont = 0;
$iQnt = 0;
foreach ($aOps as $key => $aOp) {

    //Quebra pagina após duas op
    if (($icont == 1) || ($iQnt > 1)) {
        $pdf->AddPage();
        $icont = 0;
    }
    $icont++;

    //busca os dados do banco pegando a op do foreach
    $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    $sSql = "select op, 
            convert(varchar,STEEL_PCP_ordensFab.data,103)as data,
            documento,
            durezaNucMin,durezaNucMax,
            durezaSuperfMin,durezaSuperfMax,
            expCamadaMin,expCamadaMax,NucEscala, SuperEscala,
            emp_razaosocial,
            prodes,
            prod,
            opcliente,
            material,
            dureza,
            quant,
            peso,
            receita,
            convert(varchar,dataprev,103) as dataprev,
            seqMat,
            retrabalho,
            op_retrabalho,
            referencia,
            obs,
            tipoOrdem, 
            receita_zinc,
            receita_zincdesc,
            processozinc
            from STEEL_PCP_ordensFab left outer join STEEL_PCP_receitas 
            on STEEL_PCP_ordensFab.receita = STEEL_PCP_receitas.cod
            where op =" . $aOp . " ";
    $dadosOp = $PDO->query($sSql);
    $row = $dadosOp->fetch(PDO::FETCH_ASSOC);

    //busca itens do tratamento
    $sSqlItens = "select tratdes,STEEL_PCP_ordensFabItens.temperatura,STEEL_PCP_ordensFabItens.tratamento, STEEL_PCP_ordensFabItens.CamadaEspessura, 
                STEEL_PCP_ordensFabItens.PesoDoCesto, STEEL_PCP_ordensFabItens.TempoZinc,
                STEEL_PCP_tratamentos.tratcod,tratrevencomp 
                from STEEL_PCP_ordensFabItens left outer join STEEL_PCP_tratamentos 
                on STEEL_PCP_ordensFabItens.tratamento = STEEL_PCP_tratamentos.tratcod  
                left outer join STEEL_PCP_receitasitens
                on STEEL_PCP_ordensFabItens.receita = STEEL_PCP_receitasitens.cod  
                where op =" . $aOp . " and receita = " . $row['receita_zinc'] . " order by receita_seq";

    $dadosItensOp = $PDO->query($sSqlItens);

    //Conta quantidade de linhas do processo que o relatório vai ter para imprimir corretamente o campo camada
    $sSqlCont = "select count (tratdes) as total
                from STEEL_PCP_ordensFabItens left outer join STEEL_PCP_tratamentos 
                on STEEL_PCP_ordensFabItens.tratamento = STEEL_PCP_tratamentos.tratcod  
                where op =" . $aOp . " and receita = " . $row['receita_zinc'] . " ";

    $dadosQuant = $PDO->query($sSqlCont);
    $oQuant = $dadosQuant->fetch(PDO::FETCH_ASSOC);
    $iQnt = (int) $oQuant['total'];

    //lógica para saber onde buscar o forno
    $sSqlcount = "select count (prod) as fornocont from STEEL_PCP_fornoProd where prod = " . $row['prod'] . " ";
    $dadosCount = $PDO->query($sSqlcount);
    $iContForno = $dadosCount->fetch(PDO::FETCH_OBJ);
    if ($iContForno->fornocont > 0) {
        $sSqlForno = "select fornosigla from STEEL_PCP_forno left outer join STEEL_PCP_fornoProd
                   on STEEL_PCP_forno.fornocod = STEEL_PCP_fornoProd.fornocod 
                   where prod = " . $row['prod'] . " ";
    } else {
        $sSqlForno = "select fornosigla  from STEEL_PCP_forno where tipoOrdem = '" . $row['tipoOrdem'] . "'";
    }
    $dadosForno = $PDO->query($sSqlForno);

    $sSqlMaterial = "select seqmat,STEEL_PCP_PRODMATRECEITA.matcod,matdes, obs
                    from STEEL_PCP_PRODMATRECEITA left outer join steel_pcp_material
                    on STEEL_PCP_PRODMATRECEITA.matcod = steel_pcp_material.matcod
                    where seqmat =" . $row['seqMat'] . " ";
    $dadosMaterial = $PDO->query($sSqlMaterial);
    $rowMat = $dadosMaterial->fetch(PDO::FETCH_ASSOC);

    if (($iQnt > 2) && ($icont == 2)) {
        $pdf->AddPage();
        $pdf->SetXY(3, 4);
        $icont = 0;
    }

    //inicia os dados da op
    $pdf->Cell(74, 6, $pdf->Image($sLogo, $pdf->GetX() + 25, $pdf->GetY(), 30), 1, 1, 'C');

    if ($row['retrabalho'] == 'Sim' || $row['retrabalho'] == 'Sim S/Cobrança') {
        $pdf->SetFont('Arial', 'B', 10.5);
        $pdf->Cell(74, 8, 'OP - RETRABALHO - ZINCAGEM', 1, 1, 'C');
        $pdf->Code39(10, $pdf->GetY() + 1, $row['op'], 1.4, 7);
        $pdf->Cell(74, 9, ' ', 'L,B,T,R', 1, 'C');
    } else {
        $pdf->SetFont('Arial', 'B', 10.5);
        $pdf->Cell(74, 8, 'ORDEM DE PRODUÇÃO - ZINCAGEM ', 1, 1, 'C');
        $pdf->Code39(10, $pdf->GetY() + 1, $row['op'], 1.4, 7);
        $pdf->Cell(74, 9, ' ', 'L,B,T,R', 1, 'C');
    }

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(37, 5, 'Data: ' . $data, 'L,B,R', 0, 'L');
    $pdf->Cell(37, 5, 'Número: ' . $row['op'], 'L,B,R', 1, 'L');

    //$row['data']
    //dados da ordem de produção
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->MultiAlignCell(74, 5, 'Cliente: ' . substr($row['emp_razaosocial'], 0, 40), 'B,R,L', 1, 'L');
    //nota fiscal do cliente
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(22, 5, 'NF do cliente:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(15, 5, $row['documento'], 'B,R', 0, 'L');

    //op do cliente
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(22, 5, 'Op do cliente:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(15, 5, $row['opcliente'], 'B,R', 1, 'L');

    //produto
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->MultiAlignCell(74, 5, $row['referencia'] . " - " . $row['prodes'], 'L,B,R', 1, 'L');

    if ($row['retrabalho'] == 'Sim') {
        //OP origem
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(25, 5, 'OP Origem:', 'B,L', 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(49, 5, $row['op_retrabalho'], 'B,R', 1, 'L');
    }

    //quantidade de peças
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(18, 5, 'Qt. de peças: ', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(12, 5, number_format($row['quant'], 2, ',', '.'), 'B,R', 0, 'L');

    //peso
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(15, 5, 'Peso total: ', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(12, 5, number_format($row['peso'], 2, ',', '.'), 'B,R', 0, 'L');
    //Inicio Parte feita pelo Cleverton Hoffmann
    //receita/it nr.:
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(11, 5, 'Receita: ', 'B,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(6, 5, $row['receita_zinc'], 'B,R', 1, 'L');

//    $pdf->SetFont('Arial', 'B', 9);
//    $pdf->Cell(74, 6, 'PROCESSO DE ZINCAGEM', 1, 1, 'C');

    $conter = array(1, 1);
    //Austenitização //Revenir e Eneg. 

    while ($rowIten = $dadosItensOp->fetch(PDO::FETCH_ASSOC)) {

        //Etapas do processo
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(74, 5, 'Processo Tratamento:  ' . $rowIten['tratdes'], 'L,B,R', 1, 'L');

        //Tempo
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(16, 5, 'Tempo', 'L,B,R', 0, 'C');

        //Tempo
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, 5, 'Peso Cesto', 'L,B,R', 0, 'C');

        //Camada Espessura
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(36, 5, 'Camada Espessura', 'L,B,R', 1, 'C');

        //Tempo
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(16, 5, number_format($rowIten['TempoZinc'], 0, ',', '.'), 'L,B,R', 0, 'C');

        //Peso do Cesto
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(22, 5, number_format($rowIten['PesoDoCesto'], 0, ',', '.'), 'L,B,R', 0, 'C');

        //Camada Espessura
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(36, 5, number_format($rowIten['CamadaEspessura'], 2, ',', '.'), 'L,B,R', 1, 'C');
    }

    //Inspeção sistema de dosagem:
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(35, 5, 'Inspeção dosagem:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(39, 5, '', 'B,R', 1, 'L');

    //Inspeção início da saída:
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(35, 5, 'Inspeção início da saída:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(39, 5, '', 'B,R', 1, 'L');

    //Inspeção fim da saída:
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(35, 5, 'Inspeção fim da saída:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(39, 5, '', 'B,R', 1, 'L');

    //Entrega Prev
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(35, 5, 'Entrega Prevista:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(39, 5, $row['dataprev'], 'B,R', 1, 'L');

    //Observações
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->MultiAlignCell(74, 5, 'Obs.: ' . $rowMat['obs'] . ' - ' . $row['obs'], 1, 1, 'L');

    //Fim Parte feita pelo Cleverton Hoffmann
    $pdf->Ln();
}

$pdf->Output('I', 'solvenda.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
