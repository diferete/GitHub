<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");

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
$sLogo = '../../biblioteca/assets/images/steelrel.png';
$pdf->SetMargins(5, 5, 5);

//Caminho do usuário, data e hora
date_default_timezone_set('America/Sao_Paulo');
$data = date("d/m/y");                     //função para pegar a data local
$hora = date("H:i");                       //para pegar a hora com a função date
$useRel = $_REQUEST['userRel'];

//Request dados chave primária
$pFilial = $_REQUEST['pedFilial'];
$nCargas = $_REQUEST['nCarga'];
$bBal = false;
if (isset($_REQUEST['pesoBal'])) {
    $bBal = $_REQUEST['pesoBal'];
}
$i = 0;
foreach ($nCargas as $key => $aCarga) {
    $i++;
    $pdf = quebraPagina($pdf->GetY() + 16, $pdf);

    //Inserção do cabeçalho
    $pdf->Cell(37, 15, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45), 0, 0, 'J');

    $pdf->SetFont('Arial', '', 15);
    $pdf->Cell(110, 10, 'ROMANEIO CARGA Nº ' . $aCarga, '', 0, 'C', 0);

    $pdf->SetFont('Arial', '', 9);
    $pdf->MultiCell(52, 7, 'Data: ' . $data
            . '        Hora:' . $hora
            . ' Usuário:' . $useRel
            . ' ', '', 'L', 0); //'B,R,T'
    $pdf->Cell(0, 5, '', 'T', 1, 'L');


    //busca os dados do banco pegando a carga do foreach
    $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    $sSql = "select PDV_PedidoEmpCodigo,
                pdv_pedido.PDV_PedidoDataEmissao, 
                pdv_pedido.PDV_PedidoSituacao, 
                pdv_pedido.PDV_PedidoAprovacao,
                pdv_pedidoitem.PDV_PedidoItemSeq,
                PDV_PedidoItemProduto,
                PDV_PedidoItemProdutoNomeManua,
                PDV_PedidoItemQtdPedida,
                PDV_PedidoItemProdutoUnidadeMa,
                PDV_PedidoItemValorUnitario,
                PDV_PedidoItemValorTotal,
                pdv_pedidoitemordemcompra,
                pdv_pedidoitemseqordemcompra,
                pro_ncm,STEEL_PCP_CargaInsumoServ.op, pdv_insserv, pesoBal, pesoCaixa, pesoDif
                from pdv_pedido left outer join pdv_pedidoitem 
                on pdv_pedido.PDV_PedidoFilial = pdv_pedidoitem.PDV_PedidoFilial
                and pdv_pedido.PDV_PedidoCodigo = pdv_pedidoitem.PDV_PedidoCodigo left outer join PRO_PRODUTO
                on pdv_pedidoitem.PDV_PedidoItemProduto = PRO_PRODUTO.PRO_Codigo left outer join STEEL_PCP_CargaInsumoServ
                on pdv_pedidoitem.PDV_PedidoFilial = STEEL_PCP_CargaInsumoServ.pdv_pedidofilial
                and pdv_pedidoitem.PDV_PedidoCodigo = STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo
                and pdv_pedidoitem.PDV_PedidoItemSeq= STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq
                LEFT OUTER JOIN STEEL_PCP_ordensFab ON STEEL_PCP_CargaInsumoServ.op = STEEL_PCP_ordensFab.op
                where pdv_pedido.PDV_PedidoCodigo='" . $aCarga . "' order by pdv_pedidoitem.pdv_pedidoitemseq";
    $dadosCarga = $PDO->query($sSql);

    $iConta = 0;
    $dValorTotal = 0;
    while ($rowIten = $dadosCarga->fetch(PDO::FETCH_ASSOC)) {

        if ($iConta == 0) {
            $iConta++;
            //Pega dados da empresa
            $sSql2 = "select emp_razaosocial "
                    . "from emp_pessoa where emp_codigo=" . $rowIten['PDV_PedidoEmpCodigo'] . " ";
            $dadosEmp = $PDO->query($sSql2);
            $row2 = $dadosEmp->fetch(PDO::FETCH_ASSOC);

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(20, 5, 'CLIENTE:', '', 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(35, 5, $rowIten['PDV_PedidoEmpCodigo'] . '   -   ', '', 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(110, 5, $row2['emp_razaosocial'], '', 1, 'L');

            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(20, 5, 'DATA:', '', 0, 'L');
            $dt = new DateTime($rowIten['PDV_PedidoDataEmissao']);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(20, 5, $dt->format('d/m/Y'), '', 1, 'L');

            $pdf->Cell(199, 5, '', 'B', 1);
            $pdf->Cell(199, 5, '', '', 1);

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(15, 5, 'CÓDIGO', 'B', 0, 'L');
            if ($bBal) {
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(70, 5, 'DESCRIÇÃO', 'B', 0, 'L');
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(15, 5, 'OD.', 'B', 0, 'L');
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(10, 5, 'SEQ.', 'B', 0, 'L');
            }else{
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(95, 5, 'DESCRIÇÃO', 'B', 0, 'L');
            }
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(13, 5, 'OP.', 'B', 0, 'L');
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(13, 5, 'QTD.', 'B', 0, 'L');
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(8, 5, 'UN.', 'B', 0, 'L');
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 5, 'VALOR', 'B', 0, 'L');
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(15, 5, 'TOTAL', 'B', 0, 'L');
            $pdf->Cell(20, 5, 'NCM', 'B', 1, 'L');
        }

        $pdf = quebraPagina($pdf->GetY(), $pdf);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(15, 5, trim($rowIten['PDV_PedidoItemProduto']), 'B', 0, 'L');
        if ($bBal) {
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(70, 5, $rowIten['PDV_PedidoItemProdutoNomeManua'], 'B', 0, 'L');
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(15, 5, $rowIten['pdv_pedidoitemordemcompra'], 'B', 0, 'L');
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(10, 5, $rowIten['pdv_pedidoitemseqordemcompra'], 'B', 0, 'L');
        }else{
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(95, 5, $rowIten['PDV_PedidoItemProdutoNomeManua'], 'B', 0, 'L');
        }
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(13, 5, $rowIten['op'], 'B', 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(13, 5, number_format($rowIten['PDV_PedidoItemQtdPedida'], 2, ',', '.'), 'B', 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(8, 5, $rowIten['PDV_PedidoItemProdutoUnidadeMa'], 'B', 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(20, 5, number_format($rowIten['PDV_PedidoItemValorUnitario'], 9, ',', '.'), 'B', 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(15, 5, number_format($rowIten['PDV_PedidoItemValorTotal'], 2, ',', '.'), 'B', 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(20, 5, $rowIten['pro_ncm'], 'B', 1, 'L');              

        $dValorTotal = $dValorTotal + (($rowIten['PDV_PedidoItemQtdPedida']) * ($rowIten['PDV_PedidoItemValorUnitario']));

        if ($bBal && ($rowIten['pdv_insserv'] == 'RETORNO')) {
            $pdf->SetFillColor(255, 255, 125);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(23, 4, 'Peso Balança:', 'B', 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(20, 4, number_format($rowIten['pesoBal'], 2, ',', '.'), 'B', 0, 'L',1);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(23, 4, 'Peso Caixa:', 'B', 0, 'L',1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(20, 4, number_format($rowIten['pesoCaixa'], 2, ',', '.'), 'B', 0, 'L',1);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(25, 4, 'Diferença peso:', 'B', 0, 'L',1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(20, 4, number_format($rowIten['pesoDif'], 2, ',', '.'), 'B', 0, 'L',1);
            $pdf->Cell(68, 4, '', 'B', 1, 'L', 1);
        }
        $pdf->SetTextColor(0, 0, 0);
    }
    $pdf->Cell(199, 1, '', '', 1);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(170, 5, 'VALOR TOTAL = ', '', 0, 'R');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(20, 5, number_format($dValorTotal, 2, ',', '.'), '', 1, 'L');

    $pdf->Cell(199, 5, '', 'B', 1);
    $pdf->Cell(199, 1, '', 'B', 1);
    $pdf->Cell(199, 5, '', '', 1);
    //Fim Parte feita pelo Cleverton Hoffmann
}

$pdf->Output('I', 'RelRomaneioCarga.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
//Função que quebra página em uma dada altura do PDF

function quebraPagina($i, $pdf) {
    if ($i >= 270) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
    return $pdf;
}
