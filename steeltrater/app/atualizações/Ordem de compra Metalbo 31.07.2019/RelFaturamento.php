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
$pdf->MultiCell(190, 7, 'Tipos de Movimento: ' .$aTipoMov
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

//Inicio
//busca os dados do banco
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSqli = "select NFS_NOTAFISCAL.NFS_NotaFiscalNumero,
                NFS_NotaFiscalSerieRF,
                NFS_NotaFiscalCFOP,
                NFS_NotaFiscalDataEmissao,NFS_NotaFiscalEmpCNPJ,
                NFS_NotaFiscalEmpEntDescricao,
                NFS_NotaFiscalPesoBruto,
                NFS_NotaFiscalPesoLiquido,
                NFS_NotaFiscalVolumes,
                NFS_NotaFiscalVolumeEspecie,
                NFS_NotaFiscalValorProdutos,
                NFS_NotaFiscalValorTotal,
                NFS_NotaFiscalValorDesconto
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
$sSqli .=     " group by  NFS_NOTAFISCAL.NFS_NotaFiscalNumero,NFS_NotaFiscalSerieRF,
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
$pdf->Cell(17, 5, 'Nota Fiscal', 'L,B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(22, 5, 'CNPJ', 'B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(95, 5, 'Razão Social', 'B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(16, 5, 'Peso Bruto', 'L,B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(18, 5, 'Peso Líquido', 'B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(14, 5, 'Volumes', 'B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(16, 5, 'Valor Total', 'B,R,T', 1, 'C', 0);


while ($row = $dadosRela->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(17, 5, $row['NFS_NotaFiscalNumero'], 'L,B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(22, 5, $row['NFS_NotaFiscalEmpCNPJ'], 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(95, 5, $row['NFS_NotaFiscalEmpEntDescricao'], 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(16, 5,  number_format($row['NFS_NotaFiscalPesoBruto'], 2, ',', '.'), 'L,B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(18, 5,  number_format($row['NFS_NotaFiscalPesoLiquido'], 2, ',', '.'), 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(14, 5, number_format( $row['NFS_NotaFiscalVolumes'], 2, ',', '.'), 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(16, 5, number_format($row['NFS_NotaFiscalValorTotal'], 2, ',', '.'), 'B,R,T', 1, 'C', 0);
    
}

//Fim  

$pdf->Output('I', 'RelFaturamento.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 
 