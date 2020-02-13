<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php'; 
include("../../includes/Config.php"); 

class PDF extends FPDF {
    function Footer(){ // Cria rodapé
        $this->SetXY(15,283);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial','',7); // seta fonte no rodape
        $this->Cell(190,7,'Página '.$this->PageNo().' de {nb}',0,0,'C'); // paginação
    }
}
//cptura o pedido de venda
if(isset($_REQUEST['pdvnro'])){
    $pdvnro = $_REQUEST['pdvnro'];
}else{
    $pdvnro = '0';
}
//monta os dados do cabeçalho do produto
$PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = "select widl.pev01.pdvnro,widl.pev01.empcod,widl.emp01.empdes,convert(varchar,pdvemissao,103) as pdvemissao,pdvrepcod,repdes 
                 movcod,pdvtransp,TRANSP.empfant, 
                 pdvfrete,pdvordcomp,pdvcpg,cpgdes,pdvimplant,pdvdtentre,pdvsituaca, 
                 pdvaprova,pdvobs,pdvusu,widl.EMP01.cidcep,cidnome,estcod, 
                 widl.emp01.empend,widl.emp01.empendbair, 
                 widl.emp01.empfone,widl.emp01.empfax,pdvfrete,estcod,repdes,obsvenda, 
                 frete = 
                 case when pdvfrete = 'C' then 'CIF'
                 when pdvfrete = 'F' then 'FOB'  
                 else '' end, 
                 (case when (DATEDIFF(day,GETDATE(),pdvdtentre))<=(3) then 'LIBERADO'
                 else convert(varchar,pdvdtentre,103) end)as newentrega,pdvdtentre,horasep, 
                 convert(varchar,datasep,103)as datasep 
                 from widl.PEV01 LEFT OUTER JOIN 
                 widl.EMP01 ON widl.PEV01.empcod = widl.EMP01.empcod LEFT OUTER JOIN
                 widl.CID01 ON widl.EMP01.cidcep = widl.CID01.cidcep	LEFT OUTER JOIN 
                 widl.EMP01 AS TRANSP ON widl.PEV01.pdvtransp = TRANSP.empcod LEFT OUTER JOIN 
                 widl.VENCPA ON widl.PEV01.pdvcpg = widl.VENCPA.cpgcod LEFT OUTER JOIN 
                 widl.REP01 ON widl.PEV01.pdvrepcod = widl.REP01.repcod LEFT OUTER JOIN 
                 pdfexp ON widl.pev01.pdvnro = pdfexp.pdvnro
                 where widl.pev01.pdvnro =".$pdvnro;
$dadoscab = $PDO->query($sSql);
$row = $dadoscab->fetch(PDO::FETCH_ASSOC);

$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10,10); // DEFINE O X E O Y NA PAGINA


//cabeçalho
 $pdf->SetMargins(3,0,3);
 $pdf->Rect(2,10,38,18);
 // Logo
 $pdf->Image('../../biblioteca/assets/images/logopn.png',4,13,26);
    // Arial bold 15
 $pdf->SetFont('Arial','B',15);
    // Move to the right
 $pdf->Cell(30);
    // Title
 $pdf->Cell(120,18,'PEDIDO DE VENDA Nº   '.$row['pdvnro'],1,0,'L');
    
 $pdf->Rect(160,10,48,18);
 $pdf->SetFont('Arial','',9);
 $pdf->MultiCell(45,5,'Emissão:'.$row['pdvemissao'].'       Usuário:'.$row['pdvusu'].'                        ',0,'J');
 
 $pdf->Rect(2,29,206,39);
 $pdf->Ln(3);
 $pdf->SetFont('Arial','B', 12);
 $pdf->Ln(3);
 $pdf->Cell(20, 7,'Cliente:', 0, 0,'L');
 $pdf->Cell(115, 7, $row['empdes'], 0, 0, 'L');
 $pdf->Cell(30, 7,'Cod. Cliente:', 0, 0,'L');
 $pdf->SetFont('Arial','', 12);
 $pdf->Cell(25, 7,$row['empcod'], 0, 1,'L');
 $pdf->Cell(20);
 $pdf->Cell(115, 7,$row['empend'], 0, 0,'L');
 $pdf->SetFont('Arial','B', 12);
 $pdf->Cell(30, 7,'Fone:', 0, 0,'L');
 $pdf->SetFont('Arial','', 12);
 $pdf->Cell(25, 7,$row['empfone'], 0, 1,'L');
 $pdf->Cell(20);
 $pdf->Cell(130, 7,$row['empendbair'], 0, 1,'L');
 $pdf->Cell(20);
 $pdf->Cell(55, 7,'Cep: '.$row['cidcep'].'', 0, 0,'L');
 $pdf->Cell(85, 7,$row['cidnome'], 0, 0,'L');
 $pdf->Cell(25, 7,$row['estcod'], 0, 1,'L');
 $pdf->Cell(20);
 $pdf->Cell(80, 7,'Cnpj: '.$row['empcod'].'', 0, 1,'L');
 $pdf->Rect(2,69,206,18);
 $pdf->SetFont('Arial','B', 12);
 $pdf->Ln(5);
 $pdf->Cell(20, 7,'Transp:', 0, 0,'L');
 $pdf->SetFont('Arial','', 12);
 $pdf->Cell(90, 7, $row['empfant'], 0, 0, 'L');
 $pdf->SetFont('Arial','B', 12);
 $pdf->Cell(15, 7,'Frete:', 0, 0,'L');
 $pdf->SetFont('Arial','', 12);
 $pdf->Cell(15, 7,$row['frete'], 0, 0,'L');
 $pdf->SetFont('Arial','B', 12);
 $pdf->Cell(35, 7,'Ordem Compra:', 0, 0,'L');
 $pdf->SetFont('Arial','', 12);
 $pdf->Cell(20, 7,$row['pdvordcomp'], 0, 1,'L');
 $pdf->SetFont('Arial','B', 12);
 $pdf->Ln(2);
 $pdf->Cell(20, 7,'Entrega:', 0, 0,'L');
 $pdf->SetFont('Arial','', 12);
 $pdf->Cell(30, 7,$row['newentrega'], 0, 0,'L');
 $pdf->SetFont('Arial','B', 12);
 $pdf->Cell(28, 7,'Cond. Pagto:', 0, 0,'L');
 $pdf->SetFont('Arial','', 12);
 $pdf->Cell(40, 7,$row['cpgdes'], 0, 0,'L');
 $pdf->SetFont('Arial','B', 12);
 $pdf->Cell(34, 7,'Representantes:', 0, 0,'L');
 $pdf->SetFont('Arial','', 12);
 $pdf->Cell(46, 7,$row['repdes'], 0, 1,'L');
 
 $pdf->Rect(2,88,206,45); 
 $pdf->Ln(2);
 $pdf->SetFont('Arial','', 8);
 $pdf->MultiCell(190,3,$row['pdvobs'],0,'J');
 
 
 //define a altura inicial dos dados
//seta as margens
$pdf->SetMargins(2,10,2); 
$pdf->SetY(138);
$iAlturaRet = 140; // Y (altura) INICIAL DOS DADOS 
$l=5; // ALTURA DA LINHA
//cabeçalho da primeira página
 $pdf->SetFont('Arial','', 9);
 $pdf->Cell(17, 5,'Código', 1, 0,'L');
 $pdf->Cell(15, 5,'Peso', 1, 0,'L');
 $pdf->Cell(80, 5,'Produtos', 1, 0,'L');
 $pdf->Cell(19, 5,'Qtd Carreg', 1, 0,'L');
 $pdf->Cell(18, 5,'Saldo', 1, 0,'L');
 $pdf->Cell(17, 5,'Quant', 1, 0,'L');
 $pdf->Cell(17, 5,'Unitário', 1, 0,'L');
 $pdf->Cell(23, 5,'Total', 1, 1,'L');
 
 //definindo os itens do pedido
 $sSqlItens = "select  widl.PEDV01.pdvnro,widl.PEDV01.pdvproseq,widl.pedv01.procod,pdvprodes,pround,pdvproqtdp,pdvprovlta, 
                case when (pdvproqtdp - pdvproqtdf) < 0 then 0 else (pdvproqtdp - pdvproqtdf) end as saldo, 
                case when(pdvproqtdp - pdvproqtdf)*pdvprovlta < 0 then 0 else (pdvproqtdp - pdvproqtdf)*pdvprovlta end as total, 
                case when (pdvproqtdp - pdvproqtdf)* (pdvprovlta)*0.1 < 0 then 0 else (pdvproqtdp - pdvproqtdf)* (pdvprovlta)*0.1 end as IPI, 
                case when (pdvproqtdp - pdvproqtdf)*pdvprovlta + (pdvproqtdp - pdvproqtdf)* (pdvprovlta)*0.1 < 0 then 0 else 
                (pdvproqtdp - pdvproqtdf)*pdvprovlta + (pdvproqtdp - pdvproqtdf)* (pdvprovlta)*0.1 end as TotalComIpi, 
                case when (pdvproqtdp - pdvproqtdf)*propesprat < 0 then 0 else (pdvproqtdp - pdvproqtdf)*propesprat end as peso, 
                case when (pdvproqtdp - pdvproqtdf) < 0 then 0 else (pdvproqtdp - pdvproqtdf) end as quant,
                RTRIM(pdvproobs)as pdvproobs, 
                SUM(ct) as qtcarregada 
                from widl.PEDV01 left outer join  
                widl.prod01 ON widl.PEDV01.procod = widl.prod01.procod left outer join 
                pdfexpitensep on widl.PEDV01.pdvnro = pdfexpitensep.pdvnro and 
                pdfexpitensep.pdvproseq = widl.PEDV01.pdvproseq 
                where widl.PEDV01.pdvnro =".$pdvnro."
                group by   widl.PEDV01.pdvnro,widl.PEDV01.pdvproseq,widl.pedv01.procod, 
                pdvprodes,pround,pdvproqtdp,pdvprovlta,pdvproqtdf,propesprat,pdvproobs 
                order by widl.PEDV01.pdvproseq ";
 $resultIten = $PDO->query($sSqlItens);
 $totalPeso = 0;
 $totalQt = 0;
 $vlrProd = 0;
 $totalIpi=0;
 $valorTotal=0;
 while ($rowIten = $resultIten->fetch(PDO::FETCH_ASSOC)){
     //se passar uma página monta cabeçalho
     if($iAlturaRet + $l >= 275){    // 275 é o tamanho da página

        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $iAlturaRet = 10;  // Altura na segunda página
      
            //cabeçalho da primeira página
        $pdf->SetFont('Arial','', 9);
        $pdf->Cell(17, 5,'Código', 1, 0,'L');
        $pdf->Cell(15, 5,'Peso', 1, 0,'L');
        $pdf->Cell(80, 5,'Produtos', 1, 0,'L');
        $pdf->Cell(19, 5,'Qtd Carreg', 1, 0,'L');
        $pdf->Cell(18, 5,'Saldo', 1, 0,'L');
        $pdf->Cell(17, 5,'Quant', 1, 0,'L');
        $pdf->Cell(17, 5,'Unitário', 1, 0,'L');
        $pdf->Cell(23, 5,'Total', 1, 1,'L');    
        
    } 
     $pdf->Cell(17, 5,$rowIten['procod'], 1, 0,'L');
     $pdf->Cell(15, 5,number_format($rowIten['peso'], 2, ',', '.'), 1, 0,'L');
     $pdf->Cell(80, 5,$rowIten['pdvprodes'], 1, 0,'L');
     $pdf->Cell(19, 5,'', 1, 0,'L');
     $pdf->Cell(18, 5,number_format($rowIten['saldo'], 2, ',', '.'), 1, 0,'L');
     $pdf->Cell(17, 5,number_format($rowIten['pdvproqtdp'], 2, ',', '.'), 1, 0,'L');
     $pdf->Cell(17, 5,number_format($rowIten['pdvprovlta'], 2, ',', '.'), 1, 0,'L');
     $pdf->Cell(23, 5,number_format($rowIten['total'], 2, ',', '.'), 1, 1,'L');
     if($rowIten['pdvproobs']!==''){
       $pdf->Cell(80, 5,'Observação: '.$rowIten['pdvproobs'], 0, 1,'L');   
     }
     //$iAlturaRet = $iAlturaRet+5;
     $totalPeso = $totalPeso+$rowIten['peso'];
     $totalQt = $totalQt + $rowIten['pdvproqtdp'];
     $vlrProd = $vlrProd + $rowIten['total'];
     $totalIpi = $totalIpi + $rowIten['IPI'];
     $valorTotal = $valorTotal+$rowIten['TotalComIpi'];
     
    }
 $pdf->Ln(12);
// $pdf->Rect(2,$iAlturaRet+17,206,18);
 $pdf->SetFont('Arial','B', 12);
 $pdf->Cell(40, 5,'Peso Bruto', 'T', 0,'L');
 $pdf->Cell(40, 5,'Quantidade', 'T', 0,'L');
 $pdf->Cell(60, 5,'Valor Produtos', 'T', 0,'L');
 $pdf->Cell(30, 5,'Valor IPI', 'T', 0,'L');
 $pdf->Cell(35, 5,'Valor Total', 'T', 1,'L');
 $pdf->Ln(2);
 $pdf->Cell(40, 5,number_format($totalPeso, 2, ',', '.'), 0, 0,'L');
 $pdf->Cell(40, 5,number_format($totalQt, 2, ',', '.'), 0, 0,'L');
 $pdf->Cell(60, 5,number_format($vlrProd, 2, ',', '.'), 0, 0,'L');
 $pdf->Cell(30, 5,number_format($totalIpi, 2, ',', '.'), 0, 0,'L');
 $pdf->Cell(35, 5,number_format($valorTotal, 2, ',', '.'), 0, 1,'L');
 $pdf->Output();