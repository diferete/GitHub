<?php

// Diretórios
require('../../biblioteca/graficos/Grafico.php');
//require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

$sUserRel = $_REQUEST['userRel'];
$sData = date('d/m/Y');
$sHora = date('H:i');
if (isset($_REQUEST['det'])){
    $bTip = $_REQUEST['det'];
}else{
    $bTip = false;
}
$dDatini = $_REQUEST['dataini'];
$dDatfin = $_REQUEST['datafinal'];
$sNrFat = $_REQUEST['nrfat'];
$sNrNota = $_REQUEST['nrnotaoc'];    
$sNrCon = $_REQUEST['nrconhe'];  
if (isset($_REQUEST['cnpj'])){
    $sCnpj = $_REQUEST['cnpj'];
}else{
    $sCnpj = null;
}

$sCodtip = $_REQUEST['codtipo'];
        
class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

$pdf = new PDF_Grafico('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);

$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(100, 10, 'Relatório de Conhecimento de Frete', 0, 0, 'L');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 5, 'Data: ' . $sData .
        '  Hora: ' . $sHora, 0, 'L');

$pdf->Ln(5);
$pdf->Cell(0, 0, "", "B", 1, 'C');
$pdf->Ln(3);

//Filtros
$pdf->Cell(20, 5, "Filtros:", "", 0, 'L');
if($sCodtip==1){
                $pdf->SetFont('arial', 'B', 9);
                $pdf->Cell(30, 5, 'Tipo: Venda', '', 0, 'L');
            }else if($sCodtip==2){
                $pdf->SetFont('arial', 'B', 9);
                $pdf->Cell(30, 5, 'Tipo: Compra', '', 0, 'L');
            }else{
                $pdf->SetFont('arial', 'B', 9);
                $pdf->Cell(30, 5, 'Tipo: Todos', '', 0, 'L');
}
if (isset($_REQUEST['cnpj'])){
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(50, 5, 'CNPJ: '.$sCnpj, '', 0, 'L');
}else{
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(50, 5, 'CNPJ: Todos', '', 0, 'L');
}
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 5, 'Data entre: '.$dDatini.' - '.$dDatfin, '', 1, 'L');
$pdf->Ln(3);

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sAuxCnpj = '';
//Detalhado
if($bTip){
    
    
    $sql = "select nr,tbgerecfrete.cnpj,empdes,
            nrconhe,nrfat,nrnotaoc,totakg,totalnf,valorserv,convert (varchar,data,103) as data,sit,usuario,
            convert (varchar,dataem,103) as dataem, codtipo
            from tbgerecfrete left outer join widl.EMP01
            on tbgerecfrete.cnpj = widl.EMP01.empcod";
    
    $sql.=" where dataem between '" . $dDatini . "' and '" . $dDatfin . "'"; 
    
    if(isset($sCnpj)){
        $sql.=" and cnpj = '" . $sCnpj . "'";
    }
    if(isset($sNrFat)&&$sNrFat!=''){
        $sql.=" and nrfat ='" . $sNrFat . "'";
    }
    if(isset($sCodtip)&&$sCodtip!=0){
        $sql.=" and codtipo = '" . $sCodtip . "'";
    } 
    if(isset($sNrNota)&&$sNrNota!=''){
        $sql.=" and nrnotaoc = '" . $sNrNota . "'";
    } 
    if(isset($sNrCon)&&$sNrCon!=''){
        $sql.=" and nrconhe = '" . $sNrCon . "'";
    } 
    
    $sth = $PDO->query($sql);
    
    $iQntTotal = 0;
    $iTotalKg = 0;
    $iTotalNotas = 0;
    $iTotalServ = 0;
    $iTotalServVenda = 0;
    $iTotalServCompra = 0;
    $iVenda = 0;
    $iCompra = 0;
    $iTotalMedSevNot = 0;
    $iTotalPorcMedPrecKg = 0;
    
    $iN = 0;
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
         
         if($sAuxCnpj!=$row['cnpj']||$iN==0){
            $pdf->Ln(5);
            $pdf = cabecalho($pdf, $row);
            $sAuxCnpj=$row['cnpj'];
            $iN++;
         }
         
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(15, 5, $row['nr'], 'R,B,T,L', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(22, 5, $row['nrconhe'], 'R,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(22, 5, $row['nrfat'], 'R,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(22, 5, $row['nrnotaoc'], 'R,B,T,L', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(25, 5, number_format($row['totakg'],2), 'R,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(25, 5, number_format($row['totalnf'],2,',','.'), 'R,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(25, 5, number_format($row['valorserv'],2), 'R,B,T,L', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        if($row['codtipo']==1){
            $pdf->Cell(20, 5, 'Venda', 'R,B,T', 0, 'L');
            $iVenda++;
            $iTotalServVenda = $iTotalServVenda + $row['valorserv'];
        }else{
            $pdf->Cell(20, 5, 'Compra', 'R,B,T', 0, 'L'); 
            $iCompra++;
            $iTotalServCompra = $iTotalServCompra + $row['valorserv'];
        }
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(25, 5, $row['dataem'], 'R,B,T', 1, 'L');
              
        //Contadores
        $iQntTotal++;
        $iTotalKg = $iTotalKg + $row['totakg'];
        $iTotalNotas = $iTotalNotas + $row['totalnf'];
        $iTotalServ = $iTotalServ +  $row['valorserv'];
        if($row['totalnf']!=0){
            $iTotalMedSevNot = $iTotalMedSevNot + ($row['valorserv']/$row['totalnf']);
        }else{
            $iTotalMedSevNot = $iTotalMedSevNot + ($row['valorserv']);
        }
        if($row['totakg']!=0){
            $iTotalPorcMedPrecKg = $iTotalPorcMedPrecKg + ($row['totalnf']/$row['totakg']);
        }else{
            $iTotalPorcMedPrecKg = $iTotalPorcMedPrecKg + ($row['totalnf']);   
        }
        $pdf = quebraPagina($pdf->GetY()+15, $pdf, $row);
    }
    $pdf->Ln(5);
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(50, 5, 'Totalizadores:', '', 1, 'L');
    $pdf->Ln(2);
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(50, 5, 'Notas: ' . $iQntTotal, '', 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(70, 5, 'Valor dos Serviços Compra(R$): ' . number_format($iTotalServCompra,2,',','.'), '', 1, 'L');
    $pdf->Ln(2);
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(50, 5, 'Quantidade de Venda: ' . $iVenda, '', 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(70, 5, 'Valor dos Serviços Venda(R$): ' . number_format($iTotalServVenda,2,',','.'), '', 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(50, 5, 'Valor total das notas(R$): ' . number_format($iTotalNotas,2,',','.'), '', 1, 'L');
    $pdf->Ln(2);
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(50, 5, 'Quantidade de Compra: ' . $iCompra, '', 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(70, 5, 'Valor dos Serviços Total(R$): ' . number_format($iTotalServ,2,',','.'), '', 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(40, 5, 'Total de Peso(Kg): ' . $iTotalKg, '', 1, 'L');
    $pdf->Ln(2);
    if($iQntTotal==0||$iQntTotal==null){
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(40, 5, 'Total Valor Médio Preço/Kg(R$): ' . '0', '', 1, 'L');
        $pdf->Ln(2);
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(40, 5, 'Total Valor Médio (valor serviço/valor nota): ' .'0'.' % ', '', 1, 'L');
    }else{
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(40, 5, 'Total Valor Médio Preço/Kg(R$): ' . number_format($iTotalPorcMedPrecKg/$iQntTotal,2), '', 1, 'L');
        $pdf->Ln(2);
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(40, 5, 'Total Valor Médio (valor serviço/valor nota): ' . number_format(($iTotalMedSevNot*100)/$iQntTotal,2).' % ', '', 1, 'L');
    }
    
//Resumido
}else{
    
    $sql = "select nrfat,tbgerecfrete.cnpj,empdes,
            round(SUM(valorserv),2) as TotalGeral, convert (varchar,dataem,103) as dataem
            from tbgerecfrete left outer join widl.EMP01
            on tbgerecfrete.cnpj = widl.EMP01.empcod";
    $sql.=" where dataem between '" . $dDatini . "' and '" . $dDatfin . "'"; 
    if(isset($sCnpj)){
        $sql.=" and cnpj = '" . $sCnpj . "'";
    }        
    if(isset($sCodtip)&&$sCodtip!=0){
        $sql.=" and codtipo = '" . $sCodtip . "'";
    } 
    if(isset($sNrFat)&&$sNrFat!=''){
        $sql.=" and nrfat = '" . $sNrFat . "'";
    } 
    if(isset($sNrNota)&&$sNrNota!=''){
        $sql.=" and nrnotaoc = '" . $sNrNota . "'";
    } 
    if(isset($sNrCon)&&$sNrCon!=''){
        $sql.=" and nrconhe = '" . $sNrCon . "'";
    } 
    
    $sql.=" group by tbgerecfrete.cnpj,empdes,nrfat,dataem";
      
    $sth = $PDO->query($sql);
    $iN = 0;
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
         if($iN == 0){            
            $pdf->SetFont('arial', 'B', 9);
            $pdf->Cell(23, 5, 'Nº da Fatura', 'L,B,T', 0, 'L');
            $pdf->SetFont('arial', 'B', 9);
            $pdf->Cell(28, 5, 'CNPJ','L,B,T', 0, 'L'); 
            $pdf->SetFont('arial', 'B', 9);
            $pdf->Cell(105, 5, 'Empresa', 'L,B,T', 0, 'L'); 
            $pdf->SetFont('arial', 'B', 9);
            $pdf->Cell(25, 5, 'Total Geral', 'L,B,T', 0, 'L');
            $pdf->SetFont('arial', 'B', 9);
            $pdf->Cell(23, 5, 'Data Emissão', 'L,B,T,R', 1, 'L');
            $iN++;
         }
                
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(23, 5, $row['nrfat'], 'R,B,T,L', 0, 'L');
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(28, 5, $row['cnpj'], 'R,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(105, 5, $row['empdes'], 'R,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(25, 5, number_format($row['TotalGeral'],2,',','.'), 'R,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(23, 5, $row['dataem'], 'R,B,T', 1, 'L');
        
        if(isset($array[$row['empdes']])){
            $array[$row['empdes']] = number_format($array[$row['empdes']] + $row['TotalGeral'],2,',','.');
        }else{
            $array[$row['empdes']] = number_format($row['TotalGeral'],2,',','.');
        }
        $pdf = quebraPagina($pdf->GetY()+15, $pdf, null);
    }
    
    $pdf->AddPage();
    $pdf->Ln(10);
    //Colunm diagram
    $pdf->SetFont('Arial', 'BIU', 12);
    $pdf->Cell(0, 5, 'Gráfico do total geral por transportadora', 0, 1);
    $pdf->Ln(30);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();

    /* 
     * Largura do Campo do Gráfico
     * Altura do Campo Gráfico
     * Array de dados
     * %1 = texto
     * %v = valor
     * (%p) = porcentagem
     * Array de corres do Gráfico
     * Comprimento máximo das Barras de 1 á 3 e 0 como padrão
     * Quantidade de Divisões
     */
    if(isset($array)){
    $iTam2 = count($array);

    $pdf->PieChart(200, 200, $array, '%l : %v (%p)', null, 0, 10);
    }
}

$pdf->Output('I', 'relGerenciaFrete.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  

//Função que quebra página em uma dada altura do PDF
function quebraPagina($i, $pdf, $row) {
    if ($i >= 270) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
        if($row!=null){
        $pdf = cabecalho($pdf, $row);
        }
    }
    return $pdf;
}

function cabecalho($pdf, $row){
    
            $pdf->SetFont('arial', 'B', 9);
            $pdf->Cell(60, 5, 'CNPJ','L,B,T,R', 0, 'L'); 
            $pdf->SetFont('arial', 'B', 9);
            $pdf->Cell(141, 5, 'Empresa', 'L,B,T,R', 1, 'L'); 
            $pdf->SetFont('arial', '', 9);
            $pdf->Cell(60, 5, $row['cnpj'], 'L,B,T,R', 0, 'L');
            $pdf->SetFont('arial', '', 9);
            $pdf->Cell(141, 5, $row['empdes'], 'L,B,T,R', 1, 'L');
            $pdf->Ln(1);
            
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(15, 5, 'Nr', 'L,B,T', 0, 'L');
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(22, 5, 'Conhecimento', 'L,B,T', 0, 'L');
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(22, 5, 'Fatura', 'L,B,T,R', 0, 'L');
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(22, 5, 'Nota', 'L,B,T', 0, 'L');
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(25, 5, 'Total Kg', 'L,B,T', 0, 'L');
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(25, 5, 'Total R$', 'L,B,T,R', 0, 'L');
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(25, 5, 'Valor Serviço', 'L,B,T,R', 0, 'L');
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(20, 5, 'Tipo', 'L,B,T,R', 0, 'L');
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(25, 5, 'Dt. Emissão', 'L,B,T,R', 1, 'L');
            return $pdf;
}