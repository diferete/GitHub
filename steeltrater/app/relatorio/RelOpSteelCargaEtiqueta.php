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
//$dir = opendir($letter.":/PDF");
//captura o número da op
date_default_timezone_set('America/Sao_Paulo');
$aOps = array();
$bCert = false;
if (isset($_REQUEST['nOp'])) {
    foreach ($_REQUEST['nOp'] as $key) {
        array_push($aOps, $key);
    }
    $bCert = true;
    $pFilial = '';
    $nCargas = '';
} else {
    //Request dados chave primária
    $pFilial = $_REQUEST['pedFilial'];
    $nCargas = $_REQUEST['nCarga'];
    $bBal = false;
    if (isset($_REQUEST['pesoBal'])) {
        $bBal = $_REQUEST['pesoBal'];
    }
    $i = 0;
}

class PDF extends FPDF {
    
}

$data = date("d/m/y");                     //função para pegar a data local
$hora = date("H:i");                       //para pegar a hora com a função date
$useRel = $_REQUEST['userRel'];

//monta paginação de 2 em dois
$sLogo = '../../biblioteca/assets/images/steelrel.png';

//$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf = new PDF_Code39('P', 'mm', [60, 75]);
$pdf->SetMargins(3, 2.5);
$pdf->SetAutoPageBreak(FALSE);
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$icont = 0;
$iQnt = 0;
$iBol = 0;
if (!$bCert) {
    foreach ($nCargas as $key => $aCarga) {

        $sSql = "SELECT DISTINCT STEEL_PCP_CargaInsumoServ.op
                from pdv_pedido left outer join pdv_pedidoitem 
                on pdv_pedido.PDV_PedidoFilial = pdv_pedidoitem.PDV_PedidoFilial
                and pdv_pedido.PDV_PedidoCodigo = pdv_pedidoitem.PDV_PedidoCodigo left outer join PRO_PRODUTO
                on pdv_pedidoitem.PDV_PedidoItemProduto = PRO_PRODUTO.PRO_Codigo left outer join STEEL_PCP_CargaInsumoServ
                on pdv_pedidoitem.PDV_PedidoFilial = STEEL_PCP_CargaInsumoServ.pdv_pedidofilial
                and pdv_pedidoitem.PDV_PedidoCodigo = STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo
                and pdv_pedidoitem.PDV_PedidoItemSeq= STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq
                LEFT OUTER JOIN STEEL_PCP_ordensFab ON STEEL_PCP_CargaInsumoServ.op = STEEL_PCP_ordensFab.op
                where pdv_pedido.PDV_PedidoCodigo='" . $aCarga . "' ";
        $dadosCarga = $PDO->query($sSql);

        //  $rowOps = $dadosCarga->fetch(PDO::FETCH_ASSOC);
        while ($rowCarga = $dadosCarga->fetch(PDO::FETCH_ASSOC)) {
            array_push($aOps, $rowCarga['op']);
        }
        foreach ($aOps as $key => $aOp) {
            if ($aOp != null) {
                //Quebra pagina após duas op
                if (($icont == 1)) {
                    $pdf->AddPage();
                    $icont = 0;
                }
                $icont++;

                //busca os dados do banco pegando a op do foreach
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

                //inicia os dados da op
                $pdf->Cell(54, 7, $pdf->Image($sLogo, $pdf->GetX() + 13, $pdf->GetY(), 30), 1, 1, 'L');

                $pdf->SetFont('Arial', 'B', 9);

                $pdf->Cell(54, 5, 'ORDEM DE PRODUÇÃO ', 1, 1, 'C');
                $pdf->Code39(10, $pdf->GetY() + 1, $row['op'], 1, 5);
                $pdf->Cell(54, 7, ' ', 'L,B,T,R', 1, 'C');

                $sSqlCargaCert = "SELECT durezasuperfmin,
                    durezasuperfmax,
                    superescala,
                    durezanucmin,
                    durezanucmax,
                    nucescala,
                    expcamadamin,
                    expcamadamax,
                    inspeneg, 
                    micrografia,
                    conclusao,
                    usuario,
                    convert(varchar,dataemissao,3)as dataemissao,
                    convert(varchar,hora,8)as hora,
                    fiodurezasol,fioesferio,fiodescarbonetatotal,fiodescarbonetaparcial,diamfinalmin,diamfinalmax
                    FROM STEEL_PCP_certificado
                    WHERE OP =" . $aOp . " ";
                $dadosCert = $PDO->query($sSqlCargaCert);
                $rowCert = $dadosCert->fetch(PDO::FETCH_ASSOC);

                $sSqlApont = "SELECT *
                FROM STEEL_PCP_ordensFabApont
                WHERE OP =" . $aOp . " ";
                $dadosApont = $PDO->query($sSqlApont);
                $rowApont = $dadosApont->fetch(PDO::FETCH_ASSOC);

                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(54, 4, substr($rowCert['usuario'], 0, 20), 'L,B,R', 1, 'L');
                $pdf->Cell(19, 4, 'Dt.: ' . $rowCert['dataemissao'], 'L,B,R', 0, 'L');
                $pdf->Cell(16, 4, 'Hr: ' . substr($rowCert['hora'], 0, 5), 'L,B,R', 0, 'L');
                $pdf->Cell(19, 4, 'Nº: ' . $row['op'], 'L,B,R', 1, 'L');

                $pdf->SetFont('Arial', 'B', 4);
                $pdf->Cell(199, 1, '', '', 1);

                //ETIQUETA DE IDENTIFICAÇÃO DE RETORNO
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(54, 4, 'IDENTIFICAÇÃO DE RETORNO', 1, 1, 'C');

                //Cliente
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->MultiAlignCell(54, 3.7, 'Cliente: ' . $row['emp_razaosocial'], 1, 1, 'L', false);

                //Data de entrada
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(20, 4, 'Data Entrada:', 'L,B', 0, 'L');
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(34, 4, $row['data'], 'B,R', 1, 'R');

                if ($row['tipoOrdem'] == 'F' || $row['tipoOrdem'] == 'A') {
                    //Corrida fio máquina
                    $pdf->SetFont('Arial', 'B', 8);
                    $pdf->Cell(18, 4, 'Corrida:', 'L,B', 0, 'L');
                    $pdf->SetFont('Arial', 'B', 8);
                    $pdf->Cell(36, 4, $rowApont['corrida'], 'B,R', 1, 'L');
                } else {
                    //OP do cliente
                    $pdf->SetFont('Arial', 'B', 8);
                    $pdf->Cell(18, 4, 'OP Cliente:', 'L,B', 0, 'L');
                    $pdf->SetFont('Arial', 'B', 8);
                    $pdf->Cell(36, 4, $row['opcliente'], 'B,R', 1, 'L');
                }

                //Peso
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(9, 4, 'Peso:', 'B,L', 0, 'L');
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(16, 4, number_format($row['peso'], 2, ',', '.'), 'B,R', 0, 'R');

                //Material
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(12, 4, 'Material:', 'B,L', 0, 'L');
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(17, 4, $rowMat['matdes'], 'B,R', 1, 'L');

                if ($rowCert['durezanucmin'] != '' && $rowCert['durezanucmax'] != '' && $rowCert['durezanucmin'] != '0.00' && $rowCert['durezanucmax'] != '0.00') {
                    //Dureza obtida:
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(22, 4, 'Dureza Núcleo:', 'L,B', 0, 'L');
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(32, 4, number_format($rowCert['durezanucmin'], 2, ',', '.') . " - " .
                            number_format($rowCert['durezanucmax'], 2, ',', '.') . "  " . $rowCert['nucescala'], 'B,R', 1, 'L');
                }
                if ($rowCert['durezasuperfmin'] != '' && $rowCert['durezasuperfmax'] != '' && $rowCert['durezasuperfmin'] != '0.00' && $rowCert['durezasuperfmax'] != '0.00') {
                    //Dureza superficial:
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(22, 4, 'Dureza Sup.:', 'L,B', 0, 'L');
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(32, 4, number_format($rowCert['durezasuperfmin'], 2, ',', '.') . " - " .
                            number_format($rowCert['durezasuperfmax'], 2, ',', '.') . "  " . $rowCert['superescala'], 'B,R', 1, 'L');
                }
                if ($rowCert['expcamadamin'] != '' && $rowCert['expcamadamax'] != '' && $rowCert['expcamadamin'] != '0.00' && $rowCert['expcamadamax'] != '0.00') {
                    //Expessura da camada:
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(22, 4, 'Expessura Cam.:', 'L,B', 0, 'L');
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(32, 4, number_format($rowCert['expcamadamin'], 2, ',', '.') . " - " .
                            number_format($rowCert['expcamadamax'], 2, ',', '.'), 'B,R', 1, 'L');
                }

                if ($row['tipoOrdem'] == 'F' || $row['tipoOrdem'] == 'A') {
                    //Produto
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->MultiAlignCell(54, 3.7, 'Produto Final: ' . $rowApont['procod'] . " - " . $rowApont['prodes'], 1, 1, 'L');
                } else {
                    //Produto
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->MultiAlignCell(54, 3.7, 'Produto: ' . $row['referencia'] . " - " . $row['prodes'], 1, 1, 'L');
                }

                if ($rowCert['fiodurezasol'] != '' && $rowCert['fiodurezasol'] != '0.00') {
                    //Expessura da camada:
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(19, 4, 'Dureza (HRB):', 'L,B', 0, 'L');
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(8, 4, number_format($rowCert['fiodurezasol'], 2, ',', '.'), 'B,R', 0, 'L');
                }
                if ($rowCert['fioesferio'] != '' && $rowCert['fioesferio'] != '0.00') {
                    //Expessura da camada:
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(19, 4, 'Esferiod.(%):', 'L,B', 0, 'L');
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(8, 4, number_format($rowCert['fioesferio'], 2, ',', '.'), 'B,R', 1, 'L');
                }
                if ($rowCert['fiodescarbonetatotal'] != '' && $rowCert['fiodescarbonetatotal'] != '0.00') {
                    //Expessura da camada:
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(19, 4, 'Desc.Tot(µm):', 'L,B', 0, 'L');
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(8, 4, number_format($rowCert['fiodescarbonetatotal'], 2, ',', '.'), 'B,R', 0, 'L');
                }
                if ($rowCert['fiodescarbonetaparcial'] != '' && $rowCert['fiodescarbonetaparcial'] != '0.00') {
                    //Expessura da camada:
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(19, 4, 'Desc.Par.(µm):', 'L,B', 0, 'L');
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(8, 4, number_format($rowCert['fiodescarbonetaparcial'], 2, ',', '.'), 'B,R', 1, 'L');
                }
                if ($rowCert['diamfinalmin'] != '' && $rowCert['diamfinalmax'] != '') {
                    //Expessura da camada:
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(32, 4, 'Diâmetro Final(mm):', 'L,B', 0, 'L');
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(22, 4, number_format($rowCert['diamfinalmin'], 2, ',', '.') . " - " .
                            number_format($rowCert['diamfinalmax'], 2, ',', '.'), 'B,R', 1, 'L');
                }
                //Fim Parte feita pelo Cleverton Hoffmann
            }
        }
    }
} else {
    foreach ($aOps as $key => $aOp) {
        if ($aOp != null) {
            //Quebra pagina após duas op
            if (($icont == 1)) {
                $pdf->AddPage();
                $icont = 0;
            }
            $icont++;

            //busca os dados do banco pegando a op do foreach
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

            //inicia os dados da op
            $pdf->Cell(54, 7, $pdf->Image($sLogo, $pdf->GetX() + 13, $pdf->GetY(), 30), 1, 1, 'L');

            $pdf->SetFont('Arial', 'B', 9);

            $pdf->Cell(54, 5, 'ORDEM DE PRODUÇÃO ', 1, 1, 'C');
            $pdf->Code39(10, $pdf->GetY() + 1, $row['op'], 1, 5);
            $pdf->Cell(54, 7, ' ', 'L,B,T,R', 1, 'C');

            $sSqlCargaCert = "SELECT durezasuperfmin,
                durezasuperfmax,
                superescala,
                durezanucmin,
                durezanucmax,
                nucescala,
                expcamadamin,
                expcamadamax,
                inspeneg, 
                micrografia,
                conclusao,
                usuario,
                convert(varchar,dataemissao,3)as dataemissao,
                convert(varchar,hora,8)as hora,
                fiodurezasol,fioesferio,fiodescarbonetatotal,fiodescarbonetaparcial,diamfinalmin,diamfinalmax
                FROM STEEL_PCP_certificado
                WHERE OP =" . $aOp . " ";
            $dadosCert = $PDO->query($sSqlCargaCert);
            $rowCert = $dadosCert->fetch(PDO::FETCH_ASSOC);

            $sSqlApont = "SELECT *
                FROM STEEL_PCP_ordensFabApont
                WHERE OP =" . $aOp . " ";
            $dadosApont = $PDO->query($sSqlApont);
            $rowApont = $dadosApont->fetch(PDO::FETCH_ASSOC);

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(54, 4, substr($rowCert['usuario'], 0, 20), 'L,B,R', 1, 'L');
            $pdf->Cell(19, 4, 'Dt.: ' . $rowCert['dataemissao'], 'L,B,R', 0, 'L');
            $pdf->Cell(16, 4, 'Hr: ' . substr($rowCert['hora'], 0, 5), 'L,B,R', 0, 'L');
            $pdf->Cell(19, 4, 'Nº: ' . $row['op'], 'L,B,R', 1, 'L');

            $pdf->SetFont('Arial', 'B', 4);
            $pdf->Cell(199, 1, '', '', 1);

            //ETIQUETA DE IDENTIFICAÇÃO DE RETORNO
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(54, 4, 'IDENTIFICAÇÃO DE RETORNO', 1, 1, 'C');

            //Cliente
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->MultiAlignCell(54, 3.7, 'Cliente: ' . $row['emp_razaosocial'], 1, 1, 'L', false);

            //Data de entrada
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 4, 'Data Entrada:', 'L,B', 0, 'L');
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(34, 4, $row['data'], 'B,R', 1, 'R');

            if ($row['tipoOrdem'] == 'F' || $row['tipoOrdem'] == 'A') {
                //Corrida fio máquina
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(18, 4, 'Corrida:', 'L,B', 0, 'L');
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(36, 4, $rowApont['corrida'], 'B,R', 1, 'L');
            } else {
                //OP do cliente
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(18, 4, 'OP Cliente:', 'L,B', 0, 'L');
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(36, 4, $row['opcliente'], 'B,R', 1, 'L');
            }

            //Peso
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(9, 4, 'Peso:', 'B,L', 0, 'L');
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(16, 4, number_format($row['peso'], 2, ',', '.'), 'B,R', 0, 'R');

            //Material
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(12, 4, 'Material:', 'B,L', 0, 'L');
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(17, 4, $rowMat['matdes'], 'B,R', 1, 'L');

            if ($rowCert['durezanucmin'] != '' && $rowCert['durezanucmax'] != '' && $rowCert['durezanucmin'] != '0.00' && $rowCert['durezanucmax'] != '0.00') {
                //Dureza obtida:
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(22, 4, 'Dureza Núcleo:', 'L,B', 0, 'L');
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(32, 4, number_format($rowCert['durezanucmin'], 2, ',', '.') . " - " .
                        number_format($rowCert['durezanucmax'], 2, ',', '.') . "  " . $rowCert['nucescala'], 'B,R', 1, 'L');
            }
            if ($rowCert['durezasuperfmin'] != '' && $rowCert['durezasuperfmax'] != '' && $rowCert['durezasuperfmin'] != '0.00' && $rowCert['durezasuperfmax'] != '0.00') {
                //Dureza superficial:
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(22, 4, 'Dureza Sup.:', 'L,B', 0, 'L');
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(32, 4, number_format($rowCert['durezasuperfmin'], 2, ',', '.') . " - " .
                        number_format($rowCert['durezasuperfmax'], 2, ',', '.') . "  " . $rowCert['superescala'], 'B,R', 1, 'L');
            }
            if ($rowCert['expcamadamin'] != '' && $rowCert['expcamadamax'] != '' && $rowCert['expcamadamin'] != '0.00' && $rowCert['expcamadamax'] != '0.00') {
                //Expessura da camada:
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(22, 4, 'Expessura Cam.:', 'L,B', 0, 'L');
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(32, 4, number_format($rowCert['expcamadamin'], 2, ',', '.') . " - " .
                        number_format($rowCert['expcamadamax'], 2, ',', '.'), 'B,R', 1, 'L');
            }

            if ($row['tipoOrdem'] == 'F' || $row['tipoOrdem'] == 'A') {
                //Produto
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->MultiAlignCell(54, 3.7, 'Produto Final: ' . $rowApont['procod'] . " - " . $rowApont['prodes'], 1, 1, 'L');
            } else {
                //Produto
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->MultiAlignCell(54, 3.7, 'Produto: ' . $row['referencia'] . " - " . $row['prodes'], 1, 1, 'L');
            }

            if ($rowCert['fiodurezasol'] != '' && $rowCert['fiodurezasol'] != '0.00') {
                //Expessura da camada:
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(19, 4, 'Dureza(HRB):', 'L,B', 0, 'L');
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(8, 4, number_format($rowCert['fiodurezasol'], 2, ',', '.'), 'B,R', 0, 'L');
            }
            if ($rowCert['fioesferio'] != '' && $rowCert['fioesferio'] != '0.00') {
                //Expessura da camada:
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(19, 4, 'Esferiod.(%):', 'L,B', 0, 'L');
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(8, 4, number_format($rowCert['fioesferio'], 2, ',', '.'), 'B,R', 1, 'L');
            }
            if ($rowCert['fiodescarbonetatotal'] != '' && $rowCert['fiodescarbonetatotal'] != '0.00') {
                //Expessura da camada:
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(19, 4, 'Desc.Tot(µm):', 'L,B', 0, 'L');
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(8, 4, number_format($rowCert['fiodescarbonetatotal'], 2, ',', '.'), 'B,R', 0, 'L');
            }
            if ($rowCert['fiodescarbonetaparcial'] != '' && $rowCert['fiodescarbonetaparcial'] != '0.00') {
                //Expessura da camada:
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(19, 4, 'Desc.Par.(µm):', 'L,B', 0, 'L');
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(8, 4, number_format($rowCert['fiodescarbonetaparcial'], 2, ',', '.'), 'B,R', 1, 'L');
            }
            if ($rowCert['diamfinalmin'] != '' && $rowCert['diamfinalmax'] != '') {
                //Expessura da camada:
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(32, 4, 'Diâmetro Final(mm):', 'L,B', 0, 'L');
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(22, 4, number_format($rowCert['diamfinalmin'], 2, ',', '.') . " - " .
                        number_format($rowCert['diamfinalmax'], 2, ',', '.'), 'B,R', 1, 'L');
            }

            //Fim Parte feita pelo Cleverton Hoffmann
        }
    }
}
if (!isset($_REQUEST['parD'])) {
    $pdf->Output('I', 'RelOpSteelCargaEtiqueta.pdf');
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
} else {
    $pdf->Output('D', 'RelOpSteelCargaEtiqueta.pdf');
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 
}