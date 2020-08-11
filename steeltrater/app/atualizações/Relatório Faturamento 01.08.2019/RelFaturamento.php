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

$aDados = explode('&', $_SERVER['QUERY_STRING']);
$aTipoMov ='';
foreach ($aDados as $key => $oValue) {
    if(strstr($oValue, '=', true)=='nfs_tipomovimentocodigo'){
       $aTipoMov = $aTipoMov.substr(strstr($oValue, '='),1).',';             
    }
}
if($aTipoMov!==''){
     $aTipoMov = substr($aTipoMov, 0, -1);
}
//Pega os dados passados como filtros
$dtinicial = $_REQUEST['dataini'];
$dtfinal = $_REQUEST['datafinal'];
$sEmpcod = $_REQUEST['emp_codigo'];
$sEmpDes = $_REQUEST['emp_razaosocial'];
$sProd = $_REQUEST['prod'];
$sProdDes = $_REQUEST['DELX_PRO_Produtos_pro_descricao'];
$sGrupCod = $_REQUEST['pro_grupocodigo'];
$sGrupDes = $_REQUEST['DELX_PRO_Grupo_pro_grupodescricao'];
$sSubGrupCod = $_REQUEST['pro_subgrupocodigo'];
$sSubGrupDes = $_REQUEST['DELX_PRO_Subgrupo_pro_subgrupodescricao'];
$sFamiliaCod = $_REQUEST['pro_familiacodigo'];
$sFamiliaDes = $_REQUEST['DELX_PRO_Familia_pro_familiadescricao'];
$sSubFamiliaCod = $_REQUEST['pro_subfamiliacodigo'];
$sSubFamiliaDes = $_REQUEST['DELX_PRO_Subfamilia_pro_subfamiliadescricao'];
$sGrupCodFin = $_REQUEST['pro_grupocodigofin'];
$sGrupDesFin = $_REQUEST['pro_grupodescricaofin'];
$sSubGrupCodFin = $_REQUEST['pro_subgrupocodigofin'];
$sSubGrupDesFin = $_REQUEST['pro_subgrupodescricaofin'];
$sFamiliaCodFin = $_REQUEST['pro_familiacodigofin'];
$sFamiliaDesFin = $_REQUEST['pro_familiadescricaofin'];
$sSubFamiliaCodFin = $_REQUEST['pro_subfamiliacodigofin'];
$sSubFamiliaDesFin = $_REQUEST['pro_subfamiliadescricaofin'];
if(isset($_REQUEST['sVenda'])){
  $sVenda =$_REQUEST['sVenda']; 
}else{
  $sVenda=false;  
}
if($sVenda){
    $sSomenteVenda = 'Sim';
}else{
    $sSomenteVenda = 'Não';
}

$bIten =false;
if(isset($_REQUEST['sIten'])){
   $bIten = $_REQUEST['sIten']; 
}

//$sSituaca = $_REQUEST['situaca'];
//$sRetrabalho = $_REQUEST['retrabalho'];
//Inserção do cabeçalho
$pdf->Cell(37, 10, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45), 0, 0, 'J');

$pdf->SetFont('Arial', '', 15);
$pdf->Cell(110, 10, 'Relatório de Notas Fiscais', '', 0, 'C', 0);

$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(52, 7, 'Data: ' . $data
        . '        Hora: ' . $hora
        . ' Usuário: ' . $useRel
        . ' ', '', 'L', 0); //'B,R,T'
$pdf->Cell(0, 5, '', 'T', 1, 'L');

//Filtros escolhidos
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 6, 'Filtros escolhidos:', '', 0, 'L', 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(65, 6, 'Data inicial: ' . $dtinicial .
        '   Data final: ' . $dtfinal .
        ' ', '', 0, 'L', 0);
$pdf->MultiCell(190, 6, 'Tipos de Movimento: ' .$aTipoMov
        . ' ', '', 'L', 0); 
$pdf->Cell(190, 6,'CNPJ: '.$sEmpcod.
        '   Razao Social: '.$sEmpDes.
        ' ', '', 1, 'L', 0);
$pdf->Cell(120, 6, 'Cód.Produto: ' . $sProd .
        '   Produto: ' . $sProdDes .
        ' ', '',1, 'L', 0);
$pdf->Cell(190, 6, 'Cod.Grupo: '.$sGrupCod.
        '   Grupo: '.$sGrupDes.
        '   Cod.GrupoFinal: '.$sGrupCod.
        '   GrupoFinal: '.$sGrupDesFin.
        ' ', '', 1, 'L', 0);
$pdf->Cell(190, 6, 'Cod.SubGrupo: '.$sSubGrupCod.
        '   SubGrupo: '.$sSubGrupDes.
        '   Cod.SubGrupoFinal: '.$sSubGrupCodFin.
        '   SubGrupoFinal: '.$sSubGrupDesFin.
        ' ', '', 1, 'L', 0);
$pdf->Cell(190, 6, 'Cod.Familia: '.$sFamiliaCod.
        '   Familia: '.$sFamiliaDes.
        '   Cod.FamiliaFinal: '.$sFamiliaCodFin.
        '   FamiliaFinal: '.$sFamiliaDesFin.
        ' ', '', 1, 'L', 0);
$pdf->Cell(190, 6, 'Cod.SubFamilia: '.$sSubFamiliaCod.
        '   SubFamilia: '.$sSubFamiliaDes.
        '   Cod.SubFamiliaFinal: '.$sSubFamiliaCodFin.
        '   SubFamiliaFinal: '.$sSubFamiliaDesFin.
        ' ', '', 1, 'L', 0);
$pdf->Cell(190, 6, 'Lista somente produtos que gera financeiro: '.$sSomenteVenda.' ', '', 1, 'L', 0);

//Inicio
//busca os dados do banco
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSqli = "select NFS_NOTAFISCAL.nfs_notafiscalseq,
                NFS_NOTAFISCAL.NFS_NotaFiscalNumero,
                NFS_NotaFiscalSerieRF,
                NFS_NotaFiscalCFOP,
                NFS_NotaFiscalDataEmissao,NFS_NotaFiscalEmpCNPJ,
                convert(varchar,NFS_NotaFiscalDataEmissao,103)as dataEmissao,
                NFS_NotaFiscalEmpEntDescricao,
                NFS_NotaFiscalPesoBruto,
                NFS_NotaFiscalPesoLiquido,
                NFS_NotaFiscalVolumes,
                NFS_NotaFiscalVolumeEspecie,
                NFS_NotaFiscalValorProdutos,
                NFS_NotaFiscalValorTotal,
                SUM(NFS_NotaFiscalItemValorTotal) as ValorTotalVenda,
                NFS_NotaFiscalValorDesconto,
                SUM(NFS_NotaFiscalItemDesconto) as DescontoItem
                from NFS_NOTAFISCAL left outer join NFS_NOTAFISCALITEM
                on NFS_NOTAFISCAL.NFS_NotaFiscalFilial = NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial
                and NFS_NOTAFISCAL.NFS_NotaFiscalSeq = NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq
                where NFS_NotaFiscalDataEmissao between '". $dtinicial ."' and '". $dtfinal ."'
                and NFS_NotaFiscalTipo ='S'
                and NFS_NotaFiscalSituacao ='C'
                and NFS_NotaFiscalCancelada ='N' ".
               "and NFS_NotaFiscalItemGrupoCodigo between '". $sGrupCod ."' and '". $sGrupCodFin ."' ".
               "and NFS_NotaFiscalItemSubGrupoCodi between '". $sSubGrupCod."' and '". $sSubGrupCodFin ."' ".
               "and NFS_NotaFiscalItemFamiliaCodig between '". $sFamiliaCod."' and '". $sFamiliaCodFin ."' ".
               "and NFS_NotaFiscalItemSubFamiliaCo between '". $sSubFamiliaCod."' and '". $sSubFamiliaCodFin ."' ";
                //filtro de cliente
                if($sEmpcod !==''){
                     $sSqli .= " and NFS_NotaFiscalEmpCNPJ = '".$sEmpcod."'";
                }
                //filtro de produto
                if($sProd !==''){
                     $sSqli .= " and NFS_NOTAFISCALITEM.NFS_NotaFiscalItemProduto = '".$sProd."'";
                }
                //filtro de movimento
                if($aTipoMov !==''){
                     $sSqli .= " and NFS_NotaFiscalTipoMovimento in (".$aTipoMov.")";
                }
                //filtro para trazer apenas venda
                if($sSomenteVenda=='Sim'){
                    $sSqli .= " and NFS_NotaFiscalItemMovVenda = 'S' ";
                }
               
$sSqli .=     " group by  NFS_NOTAFISCAL.nfs_notafiscalseq,NFS_NOTAFISCAL.NFS_NotaFiscalNumero,NFS_NotaFiscalSerieRF,
                NFS_NotaFiscalCFOP,NFS_NotaFiscalDataEmissao,NFS_NotaFiscalEmpCNPJ,
                NFS_NotaFiscalEmpEntDescricao,NFS_NotaFiscalPesoBruto,
                NFS_NotaFiscalPesoLiquido,NFS_NotaFiscalVolumes,
                NFS_NotaFiscalVolumeEspecie,NFS_NotaFiscalValorProdutos,
                NFS_NotaFiscalValorTotal,NFS_NotaFiscalValorDesconto
                order by NFS_NotaFiscalDataEmissao desc  ";

$dadosRela = $PDO->query($sSqli);

$pdf->Cell(0, 3, '', '', 1, 'L');

//Títulos do relatório
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(10, 5, 'NF', 'L,B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(12, 5, 'Data', 'L,B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(20, 5, 'CNPJ', 'B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(78, 5, 'Razão Social', 'B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(16, 5, 'Peso Bruto', 'L,B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(18, 5, 'Peso Líquido', 'B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(14, 5, 'Volumes', 'B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(16, 5, 'Valor Prod.', 'B,R,T', 0, 'C', 0); 

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(16, 5, 'Valor Total', 'B,R,T', 1, 'C', 0);

$total_produtos =0;
$total_finan = 0;
$total_desconto = 0;
while ($row = $dadosRela->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(10, 5, $row['NFS_NotaFiscalNumero'], 'L,B,R,T', 0, 'C', 0);
    
    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(12, 5, $row['dataEmissao'], 'L,B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(20, 5, $row['NFS_NotaFiscalEmpCNPJ'], 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(78, 5, $row['NFS_NotaFiscalEmpEntDescricao'], 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(16, 5,  number_format($row['NFS_NotaFiscalPesoBruto'], 2, ',', '.'), 'L,B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(18, 5,  number_format($row['NFS_NotaFiscalPesoLiquido'], 2, ',', '.'), 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(14, 5, number_format( $row['NFS_NotaFiscalVolumes'], 2, ',', '.'), 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(16, 5, number_format($row['ValorTotalVenda'], 2, ',', '.'), 'B,R,T', 0, 'C', 0);
    
    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(16, 5, number_format($row['NFS_NotaFiscalValorTotal'], 2, ',', '.'), 'B,R,T', 1, 'C', 0);
    
    //totaliza valor dos produtos
    $total_produtos = $total_produtos+$row['ValorTotalVenda'];
    //total valor total
    $total_finan =  $total_finan+$row['NFS_NotaFiscalValorTotal'];
    //total desconto 
    $total_desconto = $total_desconto + $row['DescontoItem'];
    
    //traz os itens
    if($bIten){
        $sSeqNota = $row['nfs_notafiscalseq'];
        //gera comando para relatório
        $sSqlIten = "select NFS_NOTAFISCAL.nfs_notafiscalseq,
                    NFS_NotaFiscalItemSeq,
                    NFS_NOTAFISCAL.NFS_NotaFiscalNumero,
                    pdv_insserv,op,pesoOp,
                    NFs_notaFiscalItemPedidoCodigo,
                    NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial,
                    NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq,
                    NFS_NotaFiscalItemQuantidade,
                    NFS_NotaFiscalItemValorOrigina,
                    NFS_NotaFiscalItemValorUnitari,
                    NFS_NotaFiscalItemValorTotal,
                    NFS_NotaFiscalItemMovCodigo,
                    NFS_NotaFiscalItemMovVenda,
                    NFS_NotaFiscalItemMovFinanceir,
                    NFS_NotaFiscalItemProduto,
                    NFS_NotaFiscalItemProdutoNomeM,
                    NFS_NotaFiscalItemProdutoUNMan,
                    NFS_NotaFiscalItemCFOP,
                    NFS_NotaFiscalItemPedidoCodigo,
                    NFS_NotaFiscalItemPedidoItemSe/*SUM(NFS_NotaFiscalItemValorTotal) as ValorItem*/
                    from NFS_NOTAFISCALITEM left outer join NFS_NOTAFISCAL
                    on NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial = NFS_NOTAFISCAL.NFS_NotaFiscalFilial
                    and NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq = NFS_NOTAFISCAL.NFS_NotaFiscalSeq 
                    left outer join STEEL_PCP_CargaInsumoServ
                    on NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial = STEEL_PCP_CargaInsumoServ.pdv_pedidofilial
                    and NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoCodigo = STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo
                    and NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoItemSe = STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq 
                    where NFS_NOTAFISCAL.nfs_notafiscalseq ='".$sSeqNota."'
                    and NFS_NotaFiscalItemGrupoCodigo between '". $sGrupCod ."' and '". $sGrupCodFin ."' 
                    and NFS_NotaFiscalItemSubGrupoCodi between '". $sSubGrupCod."' and '". $sSubGrupCodFin ."' 
                    and NFS_NotaFiscalItemFamiliaCodig between '". $sFamiliaCod."' and '". $sFamiliaCodFin ."' 
                    and NFS_NotaFiscalItemSubFamiliaCo between '". $sSubFamiliaCod."' and '". $sSubFamiliaCodFin ."' 
                    order by NFS_NotaFiscalItemSeq";
        //cabeçalho dos itens
        $pdf->Cell(0, 1, '', '', 1, 'L');

        //Títulos do relatório
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(15, 5, 'Produto', 'B', 0, 'C', 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(76, 5, 'Descrição', 'B', 0, 'C', 0);
        
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(12, 5, 'Op', 'B', 0, 'C', 0);
        
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(13, 5, 'Carga', 'B', 0, 'C', 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(13, 5, 'Tipo', 'B', 0, 'C', 0);
        
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(15, 5, 'Peso', 'B', 0, 'C', 0);
        
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(15, 5, 'Qt.', 'B', 0, 'C', 0);
        
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(8, 5, 'Un', 'B', 0, 'C', 0);
        
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(15, 5, 'Vlr.Unit', 'B', 0, 'C', 0);
        
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(16, 5, 'Total', 'B', 1, 'C', 0);
        
        //carrega os itens
        $pdf->SetFont('Arial', '', 6);
        
        $dadosItensNota = $PDO->query($sSqlIten);
        $TotalValorRetorno =0;
        $TotalValorInsumo=0;
        $TotalValorServico=0;
        
        $TotalProdutosItens=0;
        while ($rowItensNota = $dadosItensNota->fetch(PDO::FETCH_ASSOC)) {
            $pdf->Cell(15, 5, $rowItensNota['NFS_NotaFiscalItemProduto'], '', 0, 'L', 0);
            $pdf->Cell(76, 5, $rowItensNota['NFS_NotaFiscalItemProdutoNomeM'], '', 0, 'L', 0);
            $pdf->Cell(12, 5, $rowItensNota['op'], '', 0, 'C', 0);
            $pdf->Cell(13, 5, $rowItensNota['NFS_NotaFiscalItemPedidoCodigo'], '', 0, 'L', 0);
            $pdf->Cell(13, 5, $rowItensNota['pdv_insserv'], '', 0, 'L', 0); 
            $pdf->Cell(16, 5, number_format($rowItensNota['pesoOp'], 2, ',', '.'), '', 0, 'C', 0);
            $pdf->Cell(16, 5, number_format($rowItensNota['NFS_NotaFiscalItemQuantidade'], 2, ',', '.'), '', 0, 'C', 0);
            $pdf->Cell(8, 5, $rowItensNota['NFS_NotaFiscalItemProdutoUNMan'], '', 0, 'C', 0); 
            $pdf->Cell(15, 5, number_format($rowItensNota['NFS_NotaFiscalItemValorUnitari'], 2, ',', '.'), '', 0, 'C', 0);
            $pdf->Cell(16, 5, number_format($rowItensNota['NFS_NotaFiscalItemValorTotal'], 2, ',', '.'), '', 1, 'C', 0);
            //totalizadores
            if($rowItensNota['pdv_insserv']=='RETORNO'){
                $TotalValorRetorno = $TotalValorRetorno+$rowItensNota['NFS_NotaFiscalItemValorTotal'];
            }
            if($rowItensNota['pdv_insserv']=='INSUMO'){
                $TotalValorInsumo = $TotalValorInsumo+$rowItensNota['NFS_NotaFiscalItemValorTotal'];
            }
            if($rowItensNota['pdv_insserv']=='SERVIÇO'){
                $TotalValorServico = $TotalValorServico+$rowItensNota['NFS_NotaFiscalItemValorTotal'];
            }
            $TotalProdutosItens = $TotalProdutosItens + $rowItensNota['NFS_NotaFiscalItemValorTotal'];
           }
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, 'Valor Retorno: '.number_format($TotalValorRetorno, 2, ',', '.'), '', 0, 'L', 0);
        $pdf->Cell(40, 5, 'Valor Insumo: '.number_format($TotalValorInsumo, 2, ',', '.'), '', 0, 'L', 0);
        $pdf->Cell(40, 5, 'Valor Serviço: '.number_format($TotalValorServico, 2, ',', '.'), '', 0, 'L', 0);
        $pdf->Cell(40, 5, 'Valor Total: '.number_format($TotalProdutosItens, 2, ',', '.'), '', 1, 'L', 0);
        $pdf->ln(5);
        
        
        
    }
    
}
//gera total retirando descontos

$total_produtosDesc = $total_produtos - $total_desconto;
$pdf->Cell(0, 8, '', '', 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(120, 5, 'Valor Total: '.number_format($total_finan, 2, ',', '.'), 'B', 1, 'L', 0);
$pdf->Cell(0, 3, '', '', 1, 'L');
$pdf->Cell(120, 5, 'Descontos aplicados: '.number_format($total_desconto, 2, ',', '.'), 'B', 1, 'L', 0);
$pdf->Cell(0, 3, '', '', 1, 'L');
if($sSomenteVenda=='Sim'){
 $pdf->Cell(120, 5, 'Valor Produtos e serviços que são venda: '.number_format($total_produtos, 2, ',', '.'), 'B', 1, 'L', 0);
 $pdf->Cell(0, 3, '', '', 1, 'L');
 $pdf->Cell(120, 5, 'Valor Produtos e serviços que são venda (Com Desconto): '.number_format($total_produtosDesc, 2, ',', '.'), 'B', 1, 'L', 0);
 
}else{
 $pdf->Cell(120, 5, 'Valor Produtos: '.number_format($total_produtos, 2, ',', '.'), 'B', 1, 'L', 0);
 $pdf->Cell(0, 3, '', '', 1, 'L');
 $pdf->Cell(120, 5, 'Valor Produtos (Com Descontos): '.number_format($total_produtosDesc, 2, ',', '.'), 'B', 1, 'L', 0);
}



//Fim  

$pdf->Output('I', 'RelFaturamento.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 
 