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
            tipoOrdem
            from STEEL_PCP_ordensFab left outer join STEEL_PCP_receitas 
            on STEEL_PCP_ordensFab.receita = STEEL_PCP_receitas.cod
            where op =" . $aOp . " ";
    $dadosOp = $PDO->query($sSql);
    $row = $dadosOp->fetch(PDO::FETCH_ASSOC);

    //busca itens do tratamento
    $sSqlItens = "select tratdes,temperatura,STEEL_PCP_ordensFabItens.tratamento,resfriamento,tempo,
                STEEL_PCP_tratamentos.tratcod,tratrevencomp 
                from STEEL_PCP_ordensFabItens left outer join STEEL_PCP_tratamentos 
                on STEEL_PCP_ordensFabItens.tratamento = STEEL_PCP_tratamentos.tratcod  
                where op =" . $aOp . " order by receita_seq";

    $dadosItensOp = $PDO->query($sSqlItens);

    //Conta quantidade de linhas do processo que o relatório vai ter para imprimir corretamente o campo camada
    $sSqlCont = "select count (tratdes) as total
                from STEEL_PCP_ordensFabItens left outer join STEEL_PCP_tratamentos 
                on STEEL_PCP_ordensFabItens.tratamento = STEEL_PCP_tratamentos.tratcod  
                where op =" . $aOp . " ";

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
    $pdf->Cell(20, 5, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 20), 1, 0, 'L');

    $pdf->SetFont('Arial', '', 10);

    if ($row['retrabalho'] == 'Sim' || $row['retrabalho'] == 'Sim S/Cobrança') {
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(54, 5, 'ORDEM DE PRODUÇÃO - RETRABALHO', 1, 1, 'C');
        $pdf->Code39(20, $pdf->GetY() + 1, $row['op'], 1, 5);
        $pdf->Cell(74, 7, ' ', 'L,B,T,R', 1, 'C');
    } else {
        $pdf->Cell(54, 5, 'ORDEM DE PRODUÇÃO ', 1, 1, 'C');
        $pdf->Code39(20, $pdf->GetY() + 1, $row['op'], 1, 5);
        $pdf->Cell(74, 7, ' ', 'L,B,T,R', 1, 'C');
    }

    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(37, 4, 'Data: ' . $data, 'L,B,R', 0, 'L');
    $pdf->Cell(37, 4, 'Número: ' . $row['op'], 'L,B,R', 1, 'L');

    //$row['data']
    //dados da ordem de produção
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(10, 4, 'Cliente:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(64, 4, substr($row['emp_razaosocial'], 0, 40), 'B,R', 1, 'L');
    //nota fiscal do cliente
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(17, 5, 'NF do cliente:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(20, 5, $row['documento'], 'B,R', 0, 'L');

    //op do cliente
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(17, 5, 'Op do cliente:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(20, 5, $row['opcliente'], 'B,R', 1, 'L');

    //produto
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(74, 5, $row['referencia'] . " - " . $row['prodes'], 'L,B,R', 1, 'L');

    if ($row['retrabalho'] == 'Sim') {
        //OP origem
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 5, 'OP Origem:', 'B,L', 0, 'L');
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(54, 5, $row['op_retrabalho'], 'B,R', 1, 'L');
    }

    //material
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(12, 5, 'Material:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(20, 5, $rowMat['matdes'], 'B,R', 0, 'L');

    //dureza Nuc
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(20, 5, 'Dureza Núcleo:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(22, 5, substr(number_format($row['durezaNucMin'], 0, ',', '.') . " - " .
                    number_format($row['durezaNucMax'], 0, ',', '.') . "  " . $row['NucEscala'], 0, 15), 'B,R', 1, 'L');

    //dureza Superf
    if (($row['durezaSuperfMin'] != 0) && ($row['durezaSuperfMax'] != 0)) {
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 5, 'Dureza Superficial:', 'L,B', 0, 'L');
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(44, 5, number_format($row['durezaSuperfMin'], 0, ',', '.') . " - " .
                number_format($row['durezaSuperfMax'], 0, ',', '.') . "  " . $row['SuperEscala'], 'B,R', 1, 'L');
    } else if ($row['durezaSuperfMax'] != 0) {
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 5, 'Dureza Superficial:', 'L,B', 0, 'L');
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(44, 5, "Max " . number_format($row['durezaSuperfMax'], 0, ',', '.') . "  " . $row['SuperEscala'], 'B,R', 1, 'L');
    } else if ($row['durezaSuperfMin'] != 0) {
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 5, 'Dureza Superficial:', 'L,B', 0, 'L');
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(44, 5, "Min " . number_format($row['durezaSuperfMin'], 0, ',', '.') . "  " . $row['SuperEscala'], 'B,R', 1, 'L');
    }

    //quantidade de peças
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(16, 5, 'Qt. de peças:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(12, 5, number_format($row['quant'], 2, ',', '.'), 'B,R', 0, 'L');

    //peso
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(13, 5, 'Peso total:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(11, 5, number_format($row['peso'], 2, ',', '.'), 'B,R', 0, 'L');
    //Inicio Parte feita pelo Cleverton Hoffmann
    //receita/it nr.:
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(10, 5, 'Receita:', 'B,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(12, 5, $row['receita'], 'B,R', 1, 'L');

    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(74, 4, 'TRATAMENTO TÉRMICO', 1, 1, 'C');

    //Etapas do processo
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(40, 4, 'Etap.Proc.', 'L,B', 0, 'L');

    //Temp.ºC
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(17, 4, 'Temp.ºC', 'L,B', 0, 'C');

    //Tempo
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(17, 4, 'Tempo', 'L,B,R', 1, 'C');

    $conter = array(1, 1);
    //Austenitização //Revenir e Eneg. 
    $iK = 0;
    $rowReve['tratrevencomp'] = '';
    $sCamada = '';
    while ($rowIten = $dadosItensOp->fetch(PDO::FETCH_ASSOC)) {
        //analisa se é necessário buscar o complemento da descrição do tratamento na tela prod/mat/receita
        $rowReve['tratrevencomp'] = '';
        if ($rowIten['tratrevencomp'] == 'Sim') {
            $sSqlProdMatRevenimento = "select tratrevencomp from steel_pcp_prodmatreceita where seqmat =" . $row['seqMat'] . "  ";
            $dadosReven = $PDO->query($sSqlProdMatRevenimento);
            $rowReve = $dadosReven->fetch(PDO::FETCH_ASSOC);
        }

        $pdf->SetFont('Arial', 'B', 5);
        $sReveComplemento = $rowReve['tratrevencomp'];
        $pdf->Cell(40, 4, $rowIten['tratdes'] . ' ' . $rowReve['tratrevencomp'], 'L,B', 0, 'L');

        //Temp.ºC
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(17, 4, number_format($rowIten['temperatura'], 0, ',', '.'), 'L,B', 0, 'C');

        //Tempo
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(17, 4, number_format($rowIten['tempo'], 0, ',', '.'), 'L,B,R', 1, 'C');
        
        if ($iK == 0) {
            //Camada (MM)
            if (($row['expCamadaMin'] != '') || ($row['expCamadaMax'] != '')) {
                $sCamada = number_format($row['expCamadaMin'], 3, ',', '.') . " - " .
                        number_format($row['expCamadaMax'], 3, ',', '.');
            } else {
                $sCamada = ' ------- ';
            }
            $iK++;
        }         
    }

    //Camada (MM)
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(74, 4, 'Camada (MM):         '. $sCamada, 'L,B,R', 1, 'L');

    //Inspeção sistema de dosagem:
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(15, 4, 'Inspeção dosagem:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(22, 4, '', 'T,B', 0, 'L');

    //Inspeção separação:
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(15, 4, 'Inspeção separação:', 'L,B,T', 0, 'L');
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(22, 4, '', 'T,B,R', 1, 'L');

    //Inspeção início da saída:
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(15, 4, 'Inspeção início da saída:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(22, 4, '', 'B,R', 0, 'L');

    //Inspeção fim da saída:
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(15, 4, 'Inspeção fim da saída:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(22, 4, '', 'B,R', 1, 'L');

    //Entrega Prev
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(20, 4, 'Entrega Prevista:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(17, 4, $row['dataprev'], 'B,R', 0, 'L');

    //Produtividade 
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(15, 4, 'Produtividade:', 'L,B', 0, 'L');
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(22, 4, '', 'B,R', 1, 'L');

    //Observações
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(74, 4, 'Obs.: ' . $rowMat['obs'] . ' - ' . $row['obs'], 1, 1, 'L');

    //Fim Parte feita pelo Cleverton Hoffmann
    $pdf->Ln();
}

$pdf->Output('I', 'solvenda.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
