<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");

$Fil_Codigo = $_REQUEST['FIL_Codigo'];
$SUP_PedidoSeq = 0;
$SUP_PedidoSeq = $_REQUEST['SUP_PedidoSeq'];
$meses = $_REQUEST['mes'];

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


$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
/* DADOS GERAIS DA SUP_PEDIDO */
$sSql = "select "
        . "convert(varchar,SUP_PedidoData,103)as SUP_PedidoData,"
        . "SUP_PedidoIdentificador,"
        . "SUP_PEDIDO.SUP_PedidoFornecedor as CNPJFornecedor,"
        . "emp_pessoa.EMP_RazaoSocial as Fornecedor,"
        . "SUP_PedidoTransportador,"
        . "SUP_PedidoValorProduto,"
        . "SUP_PedidoValorServico,"
        . "SUP_PedidoValorTotal,"
        . "SUP_PEDIDOVLRDESCONTO,"
        . "SUP_PEDIDOVALORDESCONTOSERVICO,"
        . "convert(varchar,SUP_PEDIDOMOEDADATA,103)as SUP_PEDIDOMOEDADATA,"
        . "SUP_PedidoImpostoBCalculo,"
        . "SUP_PedidoImpostoValor,"
        . "SUP_PedidoObservacao,"
        . "SUP_PedidoCondicaoPag,"
        . "SUP_PedidoTipo,"
        . "SUP_PedidoMoeda,"
        . "SUP_PedidoTipoFrete,"
        . "SUP_PedidoVlrFrete,"
        . "SUP_PedidoVlrDespesa,"
        . "SUP_PedidoVlrSeguro,"
        . "SUM(SUP_PedidoVlrFrete + SUP_PedidoVlrDespesa + SUP_PedidoVlrSeguro) as FreteDespesasSeguro,"
        . "SUP_PedidoTipoMovimento,"
        . "SUP_PedidoUsuario,"
        . "/*SUP_PedidoUsuarioAprovador,*/"
        . "SUP_PedidoTransportador, "
        . "USU_Nome, "
        . "USU_Email,"
        . "SUP_PEDIDOMOEDAVALORNEG,"
        . "SUP_PEDIDOOBSERVACAO "
        . "from SUP_PEDIDO "
        . "left outer join USU_USUARIO "
        . "on SUP_PEDIDO.SUP_PedidoUsuario = USU_USUARIO.USU_Codigo "
        . "left outer join EMP_PESSOA "
        . "on SUP_PEDIDO.SUP_PedidoFornecedor = emp_pessoa.EMP_Codigo "
        . "left outer join SUP_PEDIDOIMPOSTO "
        . "on SUP_PEDIDO.SUP_PedidoSeq = SUP_PEDIDOIMPOSTO.SUP_PedidoSeq "
        . "where SUP_PEDIDO.SUP_PedidoSeq = " . $SUP_PedidoSeq . " "
        . "and SUP_PEDIDO.FIL_Codigo = " . $Fil_Codigo . " "
        . "group by SUP_PedidoData,SUP_PedidoIdentificador,SUP_PEDIDO.SUP_PedidoFornecedor,emp_pessoa.EMP_RazaoSocial,SUP_PedidoTransportador,SUP_PEDIDOMOEDADATA,"
        . "SUP_PedidoValorProduto,SUP_PedidoValorServico,SUP_PedidoValorTotal,SUP_PEDIDOVLRDESCONTO,SUP_PedidoImpostoBCalculo,"
        . "SUP_PedidoImpostoValor,SUP_PedidoObservacao,SUP_PedidoCondicaoPag,SUP_PedidoTipo,SUP_PedidoMoeda,SUP_PedidoTipoFrete,SUP_PEDIDOVALORDESCONTOSERVICO,"
        . "SUP_PedidoVlrFrete,SUP_PedidoVlrDespesa,SUP_PedidoVlrSeguro,SUP_PedidoTipoMovimento,SUP_PedidoUsuario,SUP_PedidoTransportador,/*SUP_PedidoUsuarioAprovador,*/ USU_Nome, USU_Email, SUP_PEDIDOMOEDAVALORNEG,"
        . "SUP_PEDIDOOBSERVACAO";
$dadosRela = $PDO->query($sSql);
$rowDados = $dadosRela->fetch(PDO::FETCH_ASSOC);

/* DADOS DO FORNECEDOR */
$sSqlEnderecoFornecedor = "SELECT "
        . "emp_enderecologradouro,"
        . "EMP_EnderecoTelefoneDDD,"
        . "emp_enderecoemail,"
        . "emp_endereconumero,"
        . "emp_enderecobairro,"
        . "emp_enderecoinscestadual,"
        . "cid_logradourocep,"
        . "EMP_EnderecoTelefone,"
        . "emp_pessoaenderecolocalizacao,"
        . "emp_pessoaendereco.CID_Codigo,"
        . "emp_enderecotelefoneddd,"
        . "CID_Descricao,"
        . "CID_EstadoCodigo "
        . "FROM emp_pessoaendereco "
        . "left outer join CID_CIDADE "
        . "on emp_pessoaendereco.CID_Codigo = CID_CIDADE.CID_Codigo "
        . "where EMP_Codigo = " . $rowDados['CNPJFornecedor'];
$endFornecedor = $PDO->query($sSqlEnderecoFornecedor);
$rowEndFornecedor = $endFornecedor->fetch(PDO::FETCH_ASSOC);

/* DADOS TRANSPORTADORA */
if ($rowDados['SUP_PedidoTransportador'] == '' || $rowDados['SUP_PedidoTransportador'] == null || $rowDados['SUP_PedidoTransportador'] == 0) {
    $rowTransportador['EMP_RazaoSocial'] = '';
    $rowTransportador['EMP_EnderecoTelefoneDDD'] = '';
    $rowTransportador['EMP_EnderecoTelefone'] = '';
} else {
    $sSqlDadosTransportador = "select "
            . "EMP_RazaoSocial,"
            . "EMP_EnderecoTelefoneDDD,"
            . "EMP_EnderecoTelefone "
            . "from EMP_PESSOA "
            . "left outer join EMP_PESSOAENDERECO "
            . "on EMP_PESSOA.EMP_Codigo = EMP_PESSOAENDERECO.EMP_Codigo "
            . "where EMP_PESSOA.EMP_Codigo = " . $rowDados['SUP_PedidoTransportador'] . "";
    $dadosTransportador = $PDO->query($sSqlDadosTransportador);
    $rowTransportador = $dadosTransportador->fetch(PDO::FETCH_ASSOC);
}

/* CONDIÇÃO DE PAGAMENTO */
$sSqlCondPag = "select "
        . "CPG_Descricao "
        . "from CPG_CONDICAOPAGAMENTO "
        . "where CPG_Codigo = " . $rowDados['SUP_PedidoCondicaoPag'] . "";
$dadosCondPag = $PDO->query($sSqlCondPag);
$rowCondPag = $dadosCondPag->fetch(PDO::FETCH_ASSOC);

/* TIPO DE FRETE */
$sSqlTipoFrete = "select "
        . "FRE_TipoFreteDescricao "
        . "from FRE_TIPOFRETE "
        . "where FRE_TipoFreteCodigo = " . $rowDados['SUP_PedidoTipoFrete'] . "";
$dadosTipoFrete = $PDO->query($sSqlTipoFrete);
$rowTipoFrete = $dadosTipoFrete->fetch(PDO::FETCH_ASSOC);

/* TIPO MOVIMENTO */
$sSqlTipoMovimento = "select "
        . "NFS_TipoMovimentoDescricao "
        . "from NFS_TIPOMOVIMENTO "
        . "where NFS_TipoMovimentoCodigo = " . $rowDados['SUP_PedidoTipoMovimento'] . "";
$dadosTipoMovimento = $PDO->query($sSqlTipoMovimento);
$rowTipoMovimento = $dadosTipoMovimento->fetch(PDO::FETCH_ASSOC);


//------------------------ INICIO CABEÇALHO----------------------------------//
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(52, 5, '', 'L,T,R', 0, 'L');
$pdf->Cell(73, 5, '', 'T,R', 0, 'L');
$pdf->Cell(75, 5, 'Data: ' . $data
        . '  Hora: ' . $hora
        . '  Usuário: ' . $useRel
        . ' ', 'T,R', 1); //'B,R,T'

$pdf->Cell(52, 15, $pdf->Image($sLogo, $pdf->GetX() + 1, $pdf->GetY() - 3, 49, 15), 'B,R,L', 0, 'J');

$pdf->SetFont('Arial', 'B', 15);
$pdf->SetXY($pdf->GetX(), $pdf->GetY() - 5);
$pdf->Cell(73, 10, 'Pedido de Compras', 'R', 0, 'C', 0);
$pdf->SetXY($pdf->GetX(), $pdf->GetY() + 5);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(22, 5, 'Identificador:', 'L', 0, 'L');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(53, 5, '', 'R', 1, 'L');
$pdf->Cell(52, 5, '', 'R', 0, 'L');
$pdf->Cell(18, 5, 'Nº Pedido:', '', 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(55, 5, $SUP_PedidoSeq, 'R', 0, 'L');
$pdf->MultiCell(75, 5, $rowDados['SUP_PedidoIdentificador'], 'R', 1, 0);
$pdf->Cell(52, 3, '', 'R', 0, 'L');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(23, 5, 'Data de Emissão', 'B', 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 5, $rowDados['SUP_PedidoData'], 'R,B', 0, 'L');
$pdf->Cell(75, 5, '', 'R,B', 1, 0);

$pdf->Cell(200, 2, '', 'R, L', 1, '');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, 'Emitente ', 'L', 0, 'L');
$pdf->Cell(180, 5, 'Emitir Nota Fiscal Para:', 'R', 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, 'Filial ', 'L', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(115, 5, 'STEELTRATER TRATAMENTOS TERMICOS LTDA', '', 0, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'CNPJ ', '', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(35, 5, '8.993.358/0001-74', 'R', 1, 'L');


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, 'Endereco ', 'L', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(115, 5, 'RUA DUQUE DE CAXIAS, 377, - CENTRO', '', 0, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Incrição Estadual ', '', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(35, 5, '255462425', 'R', 1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, 'Cidade ', 'L', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(180, 5, 'BRAÇO DO TROMBUDO - SANTA CATARINA (89178000)', 'R', 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, 'Fone ', 'L,B', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(80, 5, '(47) 3547-0751', 'B', 0, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, 'E-mail ', 'B', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(80, 5, 'amanda@steeltrater.com.br', 'R,B', 1, 'L');

$pdf->Ln(5);
//------------------------ FIM CABEÇALHO----------------------------------//
//----------------------PARTE FORNECEDOR----------------------------------//
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, 'Fornecedor ', 'L,T', 0, 'L');
$pdf->Cell(180, 5, '', 'R,T', 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, 'Código ', 'L', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(22, 5, $rowDados['CNPJFornecedor'], '', 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, 'Razão Social ', '', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(73, 5, substr($rowDados['Fornecedor'], 0, 48), '', 0, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'CNPJ ', '', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(35, 5, mask($rowDados['CNPJFornecedor'], '##.###.###/####-##'), 'R', 1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, 'Endereco ', 'L', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(115, 5, $rowEndFornecedor['emp_enderecologradouro'] . ' - ' . $rowEndFornecedor['emp_endereconumero'] . ' - ' . $rowEndFornecedor['emp_enderecobairro'], '', 0, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Incrição Estadual ', '', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(35, 5, $rowEndFornecedor['emp_enderecoinscestadual'], 'R', 1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, 'Cidade ', 'L', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(180, 5, $rowEndFornecedor['CID_Descricao'] . ' - ' . $rowEndFornecedor['CID_EstadoCodigo'] . ' (' . $rowEndFornecedor['cid_logradourocep'] . ')', 'R', 1, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, 'Fone ', 'L,B', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(80, 5, $rowEndFornecedor['EMP_EnderecoTelefone'], 'B', 0, 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, 'E-mail ', 'B', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(80, 5, $rowEndFornecedor['emp_enderecoemail'], 'R,B', 1, 'L');

if ($rowDados['SUP_PEDIDOOBSERVACAO'] != '') {
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(20, 5, 'Observações Pedido ', 'L,T', 0, 'L');
    $pdf->Cell(180, 5, '', 'R,T', 1, 'L');
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(200, 5, $rowDados['SUP_PEDIDOOBSERVACAO'], 'B,R,L', 1, 'L');
}

//TRANSPORTADORA
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(70, 5, 'Transportador', 'L', 0, 'L');
$pdf->Cell(30, 5, 'CNPJ', '', 0, 'L');
$pdf->Cell(23, 5, 'Telefone', '', 0, 'L');
$pdf->Cell(54, 5, 'Tipo de Frete', '', 0, 'L');
$pdf->Cell(23, 5, 'Valor Frete', 'R', 1, 'L');

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(70, 5, $rowTransportador['EMP_RazaoSocial'], 'B,L', 0, 'L');
$pdf->Cell(30, 5, mask($rowDados['SUP_PedidoTransportador'], '##.###.###/####-##'), 'B', 0, 'L');
$pdf->Cell(23, 5, formatPhone($rowTransportador['EMP_EnderecoTelefone']), 'B', 0, 'L');
$pdf->Cell(54, 5, substr($rowTipoFrete['FRE_TipoFreteDescricao'], 0, 34), 'B', 0, 'L');
$pdf->Cell(23, 5, $rowDados['SUP_PedidoVlrFrete'], 'B,R', 1, 'L');


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(90, 5, 'Tipo movimento', 'L', 0, 'L');
$pdf->Cell(40, 5, 'Condição de Pagamento', 'L', 0, 'L');
$pdf->Cell(20, 5, 'Moeda', '', 0, 'L');
$pdf->Cell(25, 5, 'Data Cotação', '', 0, 'L');
$pdf->Cell(25, 5, 'Valor Cotação', 'R', 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(90, 5, $rowTipoMovimento['NFS_TipoMovimentoDescricao'], 'L,B', 0, 'L');
$pdf->Cell(40, 5, $rowCondPag['CPG_Descricao'], 'L,B', 0, 'L');
$pdf->Cell(20, 5, $rowDados['SUP_PedidoMoeda'], 'B', 0, 'L');
if ($rowDados['SUP_PEDIDOMOEDADATA'] == '01/01/1753') {
    $pdf->Cell(25, 5, ' /  /  ', 'B', 0, 'L');
} else {
    $pdf->Cell(25, 5, $rowDados['SUP_PEDIDOMOEDADATA'], 'B', 0, 'L');
}
$pdf->Cell(25, 5, $rowDados['SUP_PEDIDOMOEDAVALORNEG'], 'R,B', 1, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 5, 'Último Aprovador:', 'L,B,R', 1, 'L');
$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(60, 5, /* $rowDados['SUP_PedidoUsuarioAprovador'] */ '', 'B', 0, 'L');
$pdf->Ln(2);
//----------------------FIM FORNECEDOR----------------------------------//

/* DADOS DOS ITENS */
$sSqlItens = "select "
        . "SUP_PedidoItemSeq,"
        . "convert(varchar, SUP_PedidoItemDataNeces, 103)as SUP_PedidoItemDataNeces,"
        . "convert(varchar, SUP_PedidoItemDataEntrega, 103)as SUP_PedidoItemDataEntrega,"
        . "PRO_Codigo,"
        . "SUP_PedidoItemDescricao,"
        . "SUP_PedidoItemUnidade,"
        . "SUP_PedidoItemComQtd,"
        . "SUP_PedidoItemComConv,"
        . "SUP_PedidoItemVlrDesconto,"
        . "SUP_PedidoItemValor "
        . "from SUP_PEDIDOITEM "
        . "where SUP_PedidoSeq =" . $SUP_PedidoSeq . " "
        . "and FIL_Codigo = " . $Fil_Codigo . "";
$dadosItens = $PDO->query($sSqlItens);
$iTotalQuant = 0;
$iTotalDesItens = 0;
$iK = 0;
while ($rowItens = $dadosItens->fetch(PDO::FETCH_ASSOC)) {
    $iNumLinha = 0;

    if ($pdf->GetY() >= 270) {
        $iK = 0;
    }
    $pdf = quebraPagina($pdf->GetY(), $pdf);

    if ($iK == 0) {
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(200, 5, 'Itens do Pedido', '', 1, 'C');
        $pdf->SetFillColor(180, 180, 180);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 5, 'Código', 'L,B,T', 0, 'C', true);
        $pdf->Cell(85, 5, 'Descrição', 'L,B,T', 0, 'L', true);
        $pdf->Cell(6, 5, 'Und', 'L,B,T', 0, 'C', true);
        $pdf->Cell(16, 5, 'Quantidade', 'L,B,T', 0, 'L', true);
        $pdf->Cell(15, 5, 'Unitário ', 'L,B,T', 0, 'L', true);
        $pdf->Cell(14, 5, 'Total ', 'L,B,T', 0, 'L', true);
        $pdf->Cell(13, 5, 'Desconto', 'L,B,T', 0, 'L', true);
        $pdf->Cell(9, 5, '%IPI ', 'L,B,T', 0, 'L', true);
        $pdf->Cell(10, 5, '%ICMS ', 'L,B,T', 0, 'L', true);
        $pdf->Cell(12, 5, 'Entrega ', 'L,B,T,R', 1, 'L', true);
        $pdf->Ln(1);
    } else {
        $pdf->Ln(1);
    }

    $sDescricao = str_replace(array("\n"), " ", $rowItens['SUP_PedidoItemDescricao']);
    $total_string_width = mb_strlen(trim($sDescricao));
    $total_string_width2 = $pdf->GetStringWidth($sDescricao);
    $column_width = 70;
    $column_width2 = 85;
    $number_of_lines = $total_string_width / ($column_width - 1);
    $number_of_lines2 = $total_string_width2 / ($column_width2 - 1);
    //Determina o número de linhas para a 1 e 2 linha de acordo com as divisões realizadas
    if ($number_of_lines2 < 1.5 && $number_of_lines2 > 1.005 && $total_string_width > 63 && $number_of_lines != 1) {
        $number_of_lines = ceil($number_of_lines2);
    } else {
        $number_of_lines = ceil($number_of_lines);
    }

    $line_height = 4;
    $height_of_cell = $number_of_lines * $line_height;
    $height_of_cell = ceil($height_of_cell);

    $pdf->SetFont('Arial', 'B', 6);
    $pdf->SetFillColor(255, 250, 245);
    $pdf->Cell(6, $height_of_cell, $rowItens['SUP_PedidoItemSeq'], 'L,B,T', 0, 'L', true);
    $pdf->Cell(14, $height_of_cell, $rowItens['PRO_Codigo'], 'L,B,T', 0, 'L', true);
    $pdf->MultiAlignCell(85, 4, trim($sDescricao), 1, 0, 'L', true);
    $pdf->Cell(6, $height_of_cell, rtrim($rowItens['SUP_PedidoItemUnidade']), 'L,B,T', 0, 'C', true);
    $pdf->Cell(16, $height_of_cell, number_format($rowItens['SUP_PedidoItemComQtd'], 6, ',', '.'), 'L,B,T', 0, 'R', true);
    $pdf->Cell(15, $height_of_cell, number_format($rowItens['SUP_PedidoItemValor'], 5, ',', '.'), 'L,B,T', 0, 'R', true);
    $pdf->Cell(14, $height_of_cell, number_format($rowItens['SUP_PedidoItemComQtd'] * $rowItens['SUP_PedidoItemValor'], 2, ',', '.'), 'L,B,T', 0, 'R', true);
    $pdf->Cell(13, $height_of_cell, number_format($rowItens['SUP_PedidoItemVlrDesconto'], 2, ',', '.'), 'L,B,T', 0, 'R', true);

    /* IMPOSTOS POR ITEM */
    $sSqlImpostosItem = "select "
            . "SUP_PedidoItemIImposto,"
            . "SUP_PedidoItemIValor,"
            . "SUP_PedidoItemIAliquota "
            . "from SUP_PEDIDOITEMI "
            . "where SUP_PedidoSeq = " . $SUP_PedidoSeq . " "
            . "and SUP_PedidoItemSeq =" . $rowItens['SUP_PedidoItemSeq'] . " "
            . "and FIL_Codigo = " . $Fil_Codigo . " "
            . "order by SUP_PedidoItemIImposto desc";
    $dadosImpostosItem = $PDO->query($sSqlImpostosItem);
    /* Tabela com os tipos de impostos para comparação
      FIS_ImpostoCodigo	FIS_ImpostoDescricao
      1	ICMS
      3	IPI */

    $bIpi = false;
    $bIcms = false;
    while ($rowImpostosItem = $dadosImpostosItem->fetch(PDO::FETCH_ASSOC)) {
        //%IPI
        if ($rowImpostosItem['SUP_PedidoItemIImposto'] == '3') {
            $pdf->Cell(9, $height_of_cell, number_format($rowImpostosItem['SUP_PedidoItemIAliquota'], 3, ',', '.'), 'L,B,T', 0, 'L', true);
            $bIpi = true;
        }
        //%ICMS
        if ($rowImpostosItem['SUP_PedidoItemIImposto'] == '1' && $bIpi == false) {
            $pdf->Cell(9, $height_of_cell, '0,000', 'L,B,T', 0, 'L');
            $pdf->Cell(10, $height_of_cell, number_format($rowImpostosItem['SUP_PedidoItemIAliquota'], 3, ',', '.'), 'L,B,T', 0, 'L', true);
            $bIcms = true;
        } elseif ($rowImpostosItem['SUP_PedidoItemIImposto'] == '1' && $bIpi == true) {
            $pdf->Cell(10, $height_of_cell, number_format($rowImpostosItem['SUP_PedidoItemIAliquota'], 3, ',', '.'), 'L,B,T', 0, 'L', true);
            $bIcms = true;
        }
    }
    if ($bIpi == true && $bIcms == false) {
        $pdf->Cell(10, $height_of_cell, '0,00000', 'L,B,T', 0, 'L', true);
    } elseif ($bIpi == false && $bIcms == false) {
        $pdf->Cell(9, $height_of_cell, '0,000', 'L,B,T', 0, 'L', true);
        $pdf->Cell(10, $height_of_cell, '0,00000', 'L,B,T', 0, 'L', true);
    }

    $pdf->Cell(12, $height_of_cell, $rowItens['SUP_PedidoItemDataEntrega'], 'L,B,T,R', 1, 'L', true);

    $iTotalQuant = $rowItens['SUP_PedidoItemComQtd'] + $iTotalQuant;
    $iTotalDesItens = $rowItens['SUP_PedidoItemVlrDesconto'] + $iTotalDesItens;
    $datainicial = '';
    if ($meses == '6') {
        $datainicial = date('d/m/Y', strtotime('-6 months'));
    } else {
        $datainicial = date("d/m/" . (date("Y") - 1));
    }
    $sqlTopCinco = "select "
            . "SUP_PEDIDOITEM.SUP_PedidoSeq, "
            . "PRO_Codigo,"
            . "SUP_PedidoItemDescricao,"
            . "SUP_PedidoItemUnidade,"
            . "SUP_PedidoItemQtd,"
            . "SUP_PedidoItemValor,"
            . "SUP_PedidoItemValorTotal,"
            . "convert(varchar,SUP_PedidoItemDataNeces,103)as SUP_PedidoItemDataNeces "
            . "from SUP_PEDIDOITEM "
            . "where SUP_PEDIDOITEM.FIL_Codigo = " . $Fil_Codigo . " "
            . "and PRO_Codigo = " . $rowItens['PRO_Codigo'] . " "
            . "and SUP_PEDIDOITEM.SUP_PedidoSeq < " . $SUP_PedidoSeq . " "
            . "and SUP_PedidoItemDataNeces BETWEEN '" . $datainicial . "' AND '" . $data . "' "
            . "order by SUP_PEDIDOITEM.SUP_PedidoSeq desc";
    $dadosTopCinco = $PDO->query($sqlTopCinco);

    $iTotalValor = 0;
    $iMes = 0;
    $iAno = 0;
    $btop5 = false;
    while ($rowTopCinco = $dadosTopCinco->fetch(PDO::FETCH_ASSOC)) {
        if ($iMes == 0) {
            $iMes = explode("/", $rowTopCinco['SUP_PedidoItemDataNeces'])[1];
            $iAno = explode("/", $rowTopCinco['SUP_PedidoItemDataNeces'])[2];
            $iTotalValor = $rowTopCinco['SUP_PedidoItemQtd'] * $rowTopCinco['SUP_PedidoItemValor'];
        } else {
            if ($iMes == explode("/", $rowTopCinco['SUP_PedidoItemDataNeces'])[1]) {
                $iTotalValor = $iTotalValor + $rowTopCinco['SUP_PedidoItemQtd'] * $rowTopCinco['SUP_PedidoItemValor'];
            } else {
                $pdf->Cell(6, 4, '', '', 0, 'L');
                $pdf->Cell(27, 4, '', 'L,T', 0, 'R', true);
                $pdf->Cell(32, 4, '', 'T', 0, 'R', true);
                $pdf->Cell(13, 4, '', 'T', 0, 'L', true);
                $pdf->Cell(29, 4, '', 'T', 0, 'R', true);
                $pdf->Cell(30, 4, 'Valor Total sem Impostos R$: ', 'T', 0, 'L', true);
                $pdf->Cell(16, 4, number_format($iTotalValor, 2, ',', '.'), 'T', 0, 'R', true);
                $pdf->Cell(15, 4, 'Mês/Ano:    ', 'T', 0, 'R', true);
                $pdf->Cell(32, 4, $iMes . '/' . $iAno, 'R,T', 1, 'R', true);
                $iTotalValor = $rowTopCinco['SUP_PedidoItemQtd'] * $rowTopCinco['SUP_PedidoItemValor'];
                $iMes = explode("/", $rowTopCinco['SUP_PedidoItemDataNeces'])[1];
                $iAno = explode("/", $rowTopCinco['SUP_PedidoItemDataNeces'])[2];
            }
        }
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(6, 4, '', '', 0, 'L');
        $pdf->SetFillColor(255, 255, 250);
        $pdf->Cell(27, 4, 'Pedido de Compra:  ', 'L,T,B', 0, 'R', true);
        $pdf->Cell(32, 4, $rowTopCinco['SUP_PedidoSeq'], 'T,B,R', 0, 'R', true);
        $pdf->Cell(15, 4, 'Valor Unitário', 'T,B,L', 0, 'L', true);
        $pdf->Cell(29, 4,'R$ '. number_format($rowTopCinco['SUP_PedidoItemValor'], 5, ',', '.'), 'T,B,R', 0, 'R', true);
        $pdf->Cell(15, 4, 'Quantidade:  ', 'T,B,L', 0, 'L', true);
        $pdf->Cell(29, 4, number_format($rowTopCinco['SUP_PedidoItemQtd'], 2, ',', '.'), 'T,B,R', 0, 'R', true);
        $pdf->Cell(10, 4, 'Data:  ', 'T,B', 0, 'R', true);
        $pdf->Cell(37, 4, $rowTopCinco['SUP_PedidoItemDataNeces'], 'T,B,R', 1, 'R', true);
        $iK = 1;
        $btop5 = true;
    }
    if ($iMes != 0) {
        $pdf->Cell(6, 4, '', '', 0, 'L');
        $pdf->Cell(27, 4, '', 'L,B,T', 0, 'R', true);
        $pdf->Cell(32, 4, '', 'B,T', 0, 'R', true);
        $pdf->Cell(13, 4, '', 'B,T', 0, 'L', true);
        $pdf->Cell(29, 4, '', 'B,T', 0, 'R', true);
        $pdf->Cell(30, 4, 'Valor Total sem Impostos R$: ', 'B,T', 0, 'L', true);
        $pdf->Cell(16, 4, number_format($iTotalValor, 2, ',', '.'), 'B,T', 0, 'R', true);
        $pdf->Cell(15, 4, 'Mês/Ano:    ', 'B,T', 0, 'R', true);
        $pdf->Cell(32, 4, $iMes . '/' . $iAno, 'R,B,T', 1, 'R', true);
    }
    if ($iK == 1 && $btop5 == true) {
        $pdf->Cell(200, 0, '', '', 1, 'L');
        //$pdf->Ln(0.05);
        $iK = 2;
    }
    $iK = 1;
    // $pdf->Ln(0.05);
}


$pdf = quebraPagina($pdf->GetY(), $pdf);
/* IMPOSTOS GERAL DO PEDIDO */
$sSqlImpostosPedido = "select "
        . "SUP_PedidoImpostoCodigo,"
        . "SUP_PedidoImpostoBCalculo,"
        . "SUP_PedidoImpostoValor "
        . "from "
        . "SUP_PEDIDOIMPOSTO "
        . "where SUP_PedidoSeq = " . $SUP_PedidoSeq . " "
        . "and FIL_Codigo = " . $Fil_Codigo . "";
$dadosImpostosPedido = $PDO->query($sSqlImpostosPedido);
$iTotalIPI = 0;
$iTotalICMS = 0;
while ($rowImpostosPedidos = $dadosImpostosPedido->fetch(PDO::FETCH_ASSOC)) {
    /* Tabela com os tipos de impostos para comparação
      FIS_ImpostoCodigo	FIS_ImpostoDescricao
      1	ICMS
      3	IPI */
    if ($rowImpostosPedidos['SUP_PedidoImpostoCodigo'] == '3') {
        $iTotalIPI = $rowImpostosPedidos['SUP_PedidoImpostoValor'];
    }
    if ($rowImpostosPedidos['SUP_PedidoImpostoCodigo'] == '1') {
        $iTotalICMS = $rowImpostosPedidos['SUP_PedidoImpostoValor'];
    }
}

$pdf = quebraPagina($pdf->GetY() + 10, $pdf);
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(30, 4, 'Total Quantidade', 'L,T,R', 0, 'L');
$pdf->Cell(5, 4, '', '', 0, 'L');
$pdf->Cell(28, 4, 'Total do IPI', 'L,T,R', 0, 'L');
$pdf->Cell(5, 4, '', '', 0, 'L');
$pdf->Cell(28, 4, 'Total de ICMS', 'L,T,R', 0, 'L');
$pdf->Cell(5, 4, '', '', 0, 'L');
$pdf->Cell(28, 4, 'Total Desconto Geral', 'L,T,R', 0, 'L');
$pdf->Cell(5, 4, '', '', 0, 'L');
$pdf->Cell(28, 4, 'Total Desconto Itens', 'L,T,R', 0, 'L');
$pdf->Cell(5, 4, '', '', 0, 'L');
$pdf->Cell(33, 4, 'Frete+Despesas+Seguro', 'L,T,R', 1, 'C');

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(30, 4, number_format($iTotalQuant, 6, ',', '.'), 'L,B,R', 0, 'R');
$pdf->Cell(5, 4, '', '', 0, 'L');
$pdf->Cell(28, 4, number_format($iTotalIPI, 2, ',', '.'), 'L,B,R', 0, 'R');
$pdf->Cell(5, 4, '', '', 0, 'L');
$pdf->Cell(28, 4, number_format($iTotalICMS, 2, ',', '.'), 'L,B,R', 0, 'R');
$pdf->Cell(5, 4, '', '', 0, 'L');
$pdf->Cell(28, 4, number_format($rowDados['SUP_PEDIDOVLRDESCONTO'] + $rowDados['SUP_PEDIDOVALORDESCONTOSERVICO'], 2, ',', '.'), 'L,B,R', 0, 'R');
$pdf->Cell(5, 4, '', '', 0, 'L');
$pdf->Cell(28, 4, number_format($iTotalDesItens, 2, ',', '.'), 'L,B,R', 0, 'R');
$pdf->Cell(5, 4, '', '', 0, 'L');
$pdf->Cell(33, 4, number_format($rowDados['FreteDespesasSeguro'], 2, ',', '.'), 'L,B,R', 1, 'R');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(30, 4, 'Usuário Emissor', 'L,T,R', 0, 'L');
$pdf->Cell(137, 4, '', '', 0, 'L');
$pdf->Cell(33, 4, 'Total do Pedido', 'L,T,R', 0, 'L');
$pdf->Cell(2, 4, '', '', 1, 'L');

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(30, 4, rtrim($rowDados['SUP_PedidoUsuario']), 'L,B,R', 0, 'C');
$pdf->Cell(137, 4, '', '', 0, 'L');
$pdf->SetTextColor(0, 0, 255);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(33, 4, number_format($rowDados['SUP_PedidoValorTotal'], 2, ',', '.'), 'L,B,R', 0, 'R');
$pdf->Cell(2, 4, '', '', 1, 'L');
$pdf = quebraPagina($pdf->GetY(), $pdf);
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(40, 4, 'Telefone', 'L,T', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(160, 4, '(47) 3547-0751', 'R,T', 1, 'L');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(40, 4, 'Usuário Comprador', 'L', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(160, 4, $rowDados['USU_Nome'], 'R', 1, 'L');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(40, 4, 'e-mail', 'L,B', 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(160, 4, $rowDados['USU_Email'], 'R,B', 1, 'L');

$pdf = quebraPagina($pdf->GetY(), $pdf);
$pdf->Ln(2);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(99, 4, 'Depto.Compras ', 'L,T,R', 0, 'L');
$pdf->Cell(2, 4, '', '', 0, 'L');
$pdf->Cell(99, 4, 'Diretoria', 'L,T,R', 1, 'L');

$pdf->Cell(99, 4, '', 'L,B,R', 0, 'C');
$pdf->Cell(2, 4, '', '', 0, 'L');
$pdf->Cell(99, 4, '', 'L,B,R', 0, 'R');

$pdf->Output('I', 'RelPedidoCompra.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 

function mask($val, $mask) {
    if ($val == null) {
        return 0;
    } else {
        if (strlen($val) < 14) {
            $val = str_pad($val, 14, '0', STR_PAD_LEFT);
        }
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k++];
            } else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
}

function formatPhone($phone) {
    $formatedPhone = preg_replace('/[^0-9]/', '', $phone);
    $matches = [];
    preg_match('/^([0-9]{2})([0-9]{4,5})([0-9]{4})$/', $formatedPhone, $matches);
    if ($matches) {
        return '(' . $matches[1] . ') ' . $matches[2] . '-' . $matches[3];
    }

    return $phone; // return number without format
}

function quebraPagina($i, $pdf) {

    if ($i >= 270) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }

    return $pdf;
}
