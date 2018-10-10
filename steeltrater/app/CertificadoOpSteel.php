<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php'; 
include("../../includes/Config.php"); 

class PDF extends FPDF {
    function Footer(){ // Cria rodapé
        $this->SetXY(15,278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial','',7); // seta fonte no rodape
        $this->Cell(190,7,'Página '.$this->PageNo().' de {nb}',0,1,'C'); // paginação
        }
}

$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(5,5); // DEFINE O X E O Y NA PAGINA

//Caminho da logo
$sLogo ='../../biblioteca/assets/images/steelrel.png'; 
$pdf->SetMargins(5,5,5);

$aNrs = $_REQUEST['nrcert'];

$icont=0;

foreach ($aNrs as $key => $aNr) {
    //Quebra pagina após duas op
    if($icont == 1){
         $pdf->AddPage();
         $pdf->SetXY(5,5);
         $icont=0;
    }
    $icont++;

//Caminho do usuário, data e hora
date_default_timezone_set('America/Sao_Paulo');
$data      = date("d/m/y");                     //função para pegar a data local
$hora      = date("H:i");                       //para pegar a hora com a função date
$useRel=$_REQUEST['userRel'];

//Inserção do cabeçalho
$pdf->Cell(40,10,$pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY()+2, 40, 10),0,0,'L');

//busca os dados do banco pegando a op do foreach
     $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSql = "select nrcert,
            convert(varchar,STEEL_PCP_Certificado.dataensaio,103)as dataensaio,
            convert(varchar,STEEL_PCP_Certificado.dataemissao,103)as dataemissao,
            empdes,notasteel,notacliente,durezaNucMin,durezaNucMax,NucEscala,
            durezaSuperfMin,durezaSuperfMax,superEscala,expCamadaMin,expCamadaMax,
            tratrevencomp,
            STEEL_PCP_Certificado.prodes,
            STEEL_PCP_Certificado.peso,
            STEEL_PCP_Certificado.opcliente,
            STEEL_PCP_Certificado.op
            from STEEL_PCP_Certificado left outer join STEEL_PCP_ordensFab 
            on STEEL_PCP_ordensFab.op = STEEL_PCP_Certificado.op
            where nrcert =".$aNr." ";
   $dadosNr = $PDO->query($sSql);
   $row = $dadosNr->fetch(PDO::FETCH_ASSOC);
   
$pdf->SetFont('Arial','',15);
$pdf->Cell(110,15,'CONTROLE DE QUALIDADE', '',0, 'C',0);

$pdf->SetFont('Arial','',9);
$pdf->MultiCell(52,7,'Data: '.$data
        .'        Hora:'.$hora
        .' Usuário:'.$useRel 
        .' ','','L',0);
$pdf->Cell(0,2,'','B',1,'L');
$pdf->Cell(0,1,'','B',1,'L');
$pdf->Cell(0,5,'','',1,'L');
 
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(199, 5, 'DADOS DA REMESSA NR.: '.$aNr,'B',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 /////////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Empresa: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, $row['empdes'],'',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 /////////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Nota Fiscal de Recebimento: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(80, 5, $row['notacliente'],'',0,'L');
 
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(10, 5, 'Data: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(54, 5, $row['dataemissao'],'',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ////////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Nota Fiscal de Retorno: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(80, 5, $row['notasteel'],'',0,'L');
 
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(10, 5, 'Data: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(54, 5, $row['dataensaio'],'',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Data de Realização do Ensaio: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(80, 5, $row['dataensaio'],'',0,'L');
 
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(10, 5, 'Peso: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(54, 5,number_format($row['peso'], 2, ',', '.'),'',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 //////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Op do Cliente: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, $row['opcliente'],'',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 //////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Descrição das peças: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5,$row['prodes'],'',1,'L');
 $pdf->Cell(0,2,'','',1,'L');

 //////////////////////////////////////////
 $pdf->Cell(0,10,'','',1,'L');
 /////////////////////////////////////////
 
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(199, 5, 'ESPECIFICAÇÕES DO CLIENTE','B',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 /////////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Material: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, '1018','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ////////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Tratamento Térmico: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, $row['tratrevencomp'],'',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Dureza da Superfície: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, number_format($row['durezaSuperfMin'], 0, ',', '.')." - ".
            number_format($row['durezaSuperfMax'], 0, ',', '.')."  ".$row['superEscala'],'',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Dureza do Núcleo: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, number_format($row['durezaNucMin'], 0, ',', '.')." - ".
            number_format($row['durezaNucMax'], 0, ',', '.')."  ".$row['NucEscala'],'',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Resistência a Tração: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, 'N/A','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Profundidade da Camada: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, number_format($row['expCamadaMin'], 3, ',', '.')." - ".
                          number_format($row['expCamadaMax'], 3, ',', '.').'mm','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Esfereodização: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, 'N/A','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Micrografia: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, 'N/A','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 
 //////////////////////////////////////////
 $pdf->Cell(0,10,'','',1,'L');
 /////////////////////////////////////////
 
  $pdf->SetFont('Arial','B',10);
 $pdf->Cell(199, 5, 'RESULTADOS DO TRATAMENTO','B',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 /////////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Ordem de Produção: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, '108308','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ////////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Execução no Processo: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, 'CEMENTAÇÃO + REVENIR E ENEG.','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Dureza da Superfície: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, '454 - 481 HV','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Dureza do Núcleo: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, '278 - 295 HV','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Resistência a Tração: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, 'N/A','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Profundidade da Camada: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, '0,100mm','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Esfereodização: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, 'N/A','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Micrografia: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, 'N/A','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Número da Receita: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, '400','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Inspeção do Enegrecimento: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, '(  ) Bom     (   ) Tolerável     (   )Ruim     (   ) Não Aplicável','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 
 //////////////////////////////////////////
 $pdf->Cell(0,10,'','',1,'L');
 /////////////////////////////////////////
 
  $pdf->SetFont('Arial','B',10);
 $pdf->Cell(199, 5, 'CONCLUSÃO','B',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 /////////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(199, 5, 'Foram atingidas.... ','',0,'L');
 
 
$pdf->Ln();

}
$pdf->Output('I','RelOpSteel2.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 