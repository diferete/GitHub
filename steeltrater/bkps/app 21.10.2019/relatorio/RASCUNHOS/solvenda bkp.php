<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php'; 
include("../../includes/Config.php"); 

class PDF extends FPDF {
   
    function Header(){ 
      //Cabeçalho do relatporio
        $nrHeader = $_REQUEST['nr'];
      /*
       * Conexão com banco de dados 
       */
      $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
      $sSql = "  select PDFVENDA.NR,CNPJ,CLIENTE,widl.emp01.empfone,
            CODPGT,CPGT,ODCOMPRA,
            TRANSCNPJ,TRANSP,CODREP,REP,convert(varchar,PDFVENDA.DATA,103)as data,OBS,
            CONVERT(varchar,DTENT,103)as dtent,contato,cidnome,estcod,frete
            from PDFVENDA left outer join widl.EMP01
            on PDFVENDA.CNPJ = widl.EMP01.empcod left outer join widl.CID01
            on widl.EMP01.cidcep = widl.CID01.cidcep
            where PDFVENDA.NR =".$nrHeader;
      $dadoscab = $PDO->query($sSql);
      while($row = $dadoscab->fetch(PDO::FETCH_ASSOC)){
          $nrsol = $row["NR"];
          $cnpj = $row["CNPJ"];
          $cliente = $row["CLIENTE"];
          $empfone = $row["empfone"];
          $codpgt = $row["CODPGT"];
          $condpag = $row["CPGT"];
          $odcompra = $row["ODCOMPRA"];
          $transcnpj = $row["TRANSCNPJ"];
          $transp = $row["TRANSP"];
          $codrep = $row["CODREP"];
          $rep = $row["REP"];
          $data = $row["data"];
          $obs = $row["OBS"];
          $cidnome = $row["cidnome"];
          $estcod = $row["estcod"];
          $dtent = $row["dtent"];
          $contato = $row["contato"];
          $frete = $row["frete"];
      }



      
        $l=5; // Define a altura da linha como 5
        $this->SetXY(10,10); // DEFINE O X E O Y NA PAGINA
        //seta as margens
        $this->SetMargins(2,2,2); 
       
        /*
         * Margem da página
         * 
         * Cria retangulo que começa nos ponto x = 10 e y = 10 
         * com a largura de 190 e altura de 280
         * 
         */
        $this->Rect(2,32,206,50);  

        /*
         * Adiona imagem na posição do eixo x = 10 e eixo y = 15
         */
        
        $this->Image('../../biblioteca/assets/images/logoemp.png',3,10,40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
     
        $this->SetFont('Arial','B',16);
      
        $this->Cell(190,18,'SOLICITAÇÃO DE VENDA Nº '.$nrHeader.'',0,1,'C');
        $this->Ln(5);
        //cliente
        $this->SetFont('arial','',9);
        $this->Cell(30,5,"Cliente:",0,0,'L');
        $this->Cell(30,5,$cnpj,0,0,'L');
        $this->Cell(130,5,$cliente,0,1,'L');
        //cidade
        $this->Cell(30,5,"Cidade:",0,0,'L');
        $this->setFont('arial','',9);
        $this->Cell(50,5,$cidnome,0,0,'L');
        //estado
        $this->Cell(30,5,"Estado:",0,0,'L');
        $this->setFont('arial','',9);
        $this->Cell(50,5,$estcod,0,1,'L');
        //telefone
        $this->Cell(30,5,"Telefone:",0,0,'L');
        $this->setFont('arial','',9);
        $this->Cell(50,5,$empfone,0,1,'L');
        //Ordem de compra
        $this->Cell(30,5,"Ordem de compra:",0,0,'L');
        $this->setFont('arial','',9);
        $this->Cell(50,5,$odcompra,0,1,'L');
       //transportadora
        $this->Cell(30,5,"Transportadora:",0,0,'L');
        $this->setFont('arial','',9);
        $this->Cell(30,5,$transcnpj,0,0,'L');
        //estado
        $this->Cell(80,5,$transp,0,1,'L');
        //frete
        $this->Cell(30,5,"Frete:",0,0,'L');
        $this->setFont('arial','',9);
        $this->Cell(50,5,$frete,0,1,'L');
         //representante
        $this->Cell(30,5,"Representante:",0,0,'L');
        $this->setFont('arial','',9);
        $this->Cell(30,5,$codrep,0,0,'L');
        //estado
        $this->Cell(80,5,$rep,0,1,'L');
        //data emissao
        $this->Cell(30,5,"Data Emissão:",0,0,'L');
        $this->setFont('arial','',9);
        $this->Cell(50,5,$data,0,1,'L');
        //data de entrega
        $this->Cell(30,5,"Data Faturamento:",0,0,'L');
        $this->setFont('arial','',9);
        $this->Cell(50,5,$dtent,0,1,'L');
        $this->Ln(5);
        //observação
        $this->Rect(2,82,206,25); 
        $this->Cell(60,5,"Obs",0,1,'L');
        $this->MultiCell(190,5,$obs,0,'J');
        $this->Ln(15);
        
    }
    
    function Footer(){ // Cria rodapé
        $this->SetXY(15,283);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial','',7); // seta fonte no rodape
        $this->Cell(190,7,'Página '.$this->PageNo().' de {nb}',0,0,'C'); // paginação
    }




}

$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE


/************************ CABEÇALHO DA TABELA **************************/

 //$pdf->Cell(0,5,"Seq.    Código       Descrição                             "
 //        . "                                                                                     Qt.Cto            Unit                Total",1,1,'L');
 /**
  * Select dos dados
  */
 /*$nrItens = $_REQUEST['nr'];
  $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
      $sSql = "select seq,CODIGO,DESCRICAO,QUANT,VLRUNIT,VLRTOT from PDFITENVENDA where NR =".$nrItens." order by seq";
      
 $dadosItens = $PDO->query($sSql);
 $iAlturaRet = 113;
 $iAltinicial = 113;
 while ($row = $dadosItens->fetch(PDO::FETCH_ASSOC)){
    $seq = $row['seq'];
    $codigo = $row['CODIGO'];
    $descricao = $row['DESCRICAO'];
    $quant = $row['QUANT'];
    $vlrunit = $row['VLRUNIT'];
    $vlrtot = $row['VLRTOT'];
   
    
    $pdf->Rect(2,$iAlturaRet,206,5);
    
    $pdf->Cell(8,5,$seq,0,0,'L');
    $pdf->Cell(18,5,$codigo,0,0,'L');
    $pdf->Cell(115,5,$descricao,0,0,'L');
    $pdf->Cell(20,5,number_format($quant, 2, ',', '.'),0,0,'L');
    $pdf->Cell(20,5,number_format($vlrunit, 2, ',', '.'),0,0,'L');
    $pdf->Cell(23,5,number_format($vlrtot, 2, ',', '.'),0,1,'L');
    
    $iAluraRet = $iAlturaRet+5;
 }*/

/*$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(213,213,213);
$y = 32;
$l = 6;

$pdf->SetY($y);
$pdf->SetX(10);
$pdf->Rect(10,$y,22,$l);
$pdf->SetDrawColor(0,0,0);
$pdf->Cell(22,$l,'CÓDIGO',0,0,'C',TRUE);

$pdf->SetY($y);
$pdf->SetX(32);
$pdf->Rect(32,$y,140,$l);
$pdf->Cell(140,$l,'DESCRIÇÃO',0,2,'',TRUE);

$pdf->SetY($y);
$pdf->SetX(172);
$pdf->Rect(172,$y,10,$l);
$pdf->Cell(10,$l,'UN',0,2,'C',TRUE);

$pdf->SetY($y);
$pdf->SetX(182);
$pdf->Rect(182,$y,18,$l);
$pdf->Cell(18,$l,'PESO',0,2,'C',TRUE);
   
/**********************************************************************/

/*$pdf->SetFont('Arial','',8);
$y = 39; // Y (altura) INICIAL DOS DADOS 
$l=6; // ALTURA DA LINHA

/*
 * Conexão com banco de dados 
 */
/*$PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    
//grupo=1&grupo1=2&subgrupo=1&subgrupo1=2&familia=1&familia1=2&subfamilia=1&subfamilia1=2&codigo=10110101
$aRequest = $_REQUEST;

$Codigo = $aRequest['codigo'];

$GrupoInicial = $aRequest['grupo'];
$GrupoFinal = $aRequest['grupo1'];

$SubGrupoInicial = $aRequest['subgrupo'];
$SubGrupoFinal = $aRequest['subgrupo1'];

$FamiliaInicial = $aRequest['familia'];
$FamiliaFinal = $aRequest['familia1'];

$SubFamiliaInicial = $aRequest['subfamilia'];
$SubFamiliaFinal = $aRequest['subfamilia1'];*/

/*if(!empty($Codigo)){
    $sFiltro = "where procod = ".$Codigo;
}else{
    $sFiltro = "where grucod between ".$GrupoInicial." and ".$GrupoFinal
      ." and subcod between ".$SubGrupoInicial." and ".$SubGrupoFinal 
      ." and famcod between ".$FamiliaInicial." and ".$FamiliaFinal 
      ." and famsub between ".$SubFamiliaInicial." and ".$SubFamiliaFinal." order by procod" ;
}
$sql = "select * from widl.prod01 ". $sFiltro; 
$sth = $PDO->query($sql);

while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    
// ENQUANTO OS DADOS VÃO PASSANDO, O FPDF VAI INSERINDO OS DADOS NA PAGINA

    $procod = $row["procod"];
    $prodes = $row["prodes"]; 
    $pround = $row["pround"]; 
    $propesprat = number_format($row["propesprat"], 3 );
    
    if($y + $l >= 275){    // 275 é o tamanho da página

        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $y=34;             // Altura na segunda página

    }

    //DADOS
    $pdf->SetY($y);
    $pdf->SetX(15);
  //  $pdf->Rect(10,$y,18,$l);
    $pdf->Cell(22,$l,$procod,0,0,'C');

    
    $pdf->SetY($y);
    $pdf->SetX(32);
    //$pdf->Rect(28,$y,85,$l);
    $pdf->Cell(130,$l,$prodes,0,2);
   
    $pdf->SetY($y);
    $pdf->SetX(172);
    //$pdf->Rect(113,$y,10,$l);
    $pdf->Cell(10,$l,$pround,0,2,'C');
    
    $pdf->SetY($y);
    $pdf->SetX(182);
    //$pdf->Rect(123,$y,15,$l);
    $pdf->Cell(18,$l,$propesprat.' KG',0,2,'C');
   
    $y += $l;
}*/
if($_REQUEST['output']=='email'){
$pdf->Output('F','representantes/'.$_REQUEST['dir'].'/solvenda'.$_REQUEST['nr'].'.pdf'); // GERA O PDF NA TELA
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
}else{
  $pdf->Output('I','solvenda'.$_REQUEST['nr'].'.pdf');
  Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
}