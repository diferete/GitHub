<?php

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

//Caminho do usuário, data e hora
date_default_timezone_set('America/Sao_Paulo');
$data      = date("d/m/y");                     //função para pegar a data local
$hora      = date("H:i");                       //para pegar a hora com a função date
$useRel= $_REQUEST['userRel'];
$nrTabela = $_REQUEST['nr'];

$pdf->Cell(37,12,$pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45),0,0,'J');

$pdf->SetFont('Arial','',15);
$pdf->Cell(110,10,'Tabela de preços nº '.$nrTabela, '',0, 'C',0); 

$pdf->SetFont('Arial','',9);
$pdf->MultiCell(52,5,'Data: '.$data
        .'        Hora:'.$hora
        .' Usuário:'.$useRel 
        .' ','','L',0); //'B,R,T'
$pdf->Cell(0,3,'','',1,'L');
$pdf->Cell(0,3,'','T',1,'L');

 //busca os dados do banco
     $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSqli = "select steel_pcp_tabcabpreco.nr,
                steel_pcp_tabcabpreco.nometabela,
                STEEL_PCP_TabItemPreco.receita,
                STEEL_PCP_receitas.peca,
                STEEL_PCP_TabItemPreco.prod,
                PRO_PRODUTO.pro_descricao,
                pro_ncm,preco,tipo
                 from steel_pcp_tabcabpreco left outer join STEEL_PCP_TabItemPreco
                on steel_pcp_tabcabpreco.nr = STEEL_PCP_TabItemPreco.nr left outer join STEEL_PCP_receitas
                on STEEL_PCP_TabItemPreco.receita = STEEL_PCP_receitas.cod left outer join PRO_PRODUTO 
                on STEEL_PCP_TabItemPreco.prod = PRO_PRODUTO.PRO_Codigo
                where steel_pcp_tabcabpreco.nr ='".$nrTabela."' 
                order by seq"; 
          
   $dadosRelatorio = $PDO->query($sSqli);
   
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(15, 5, 'Cod.Rec','B',0,'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(55, 5, 'Receita','B',0,'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(15, 5, 'Produto','B',0,'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(65, 5, 'Descrição','B',0,'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(25, 5, 'NCM','B',0,'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(25, 5, 'Preço','B',1,'L');
            
    while($row = $dadosRelatorio->fetch(PDO::FETCH_ASSOC)){
            $pdf->Cell(15, 5, $row['receita'],'',0,'L');
            $pdf->Cell(55, 5, $row['peca'],'',0,'L');
            $pdf->Cell(15, 5, $row['prod'],'',0,'L');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(65, 5, $row['pro_descricao'],'',0,'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(25, 5, $row['pro_ncm'],'B',0,'L');
            $pdf->SetFillColor(225,225,225);
            $pdf->Cell(25, 5, number_format($row['preco'],2,',','.'),'',1,'L');
           // $pdf->SetFillColor(255,255,255);
           
    }



$pdf->Output('I','RelOpSteel2.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 