<?php


// Diretórios
require '../../biblioteca/fpdf/fpdf.php'; 
include("../../includes/Config.php"); 

//captura o número da op
$aOps = $_REQUEST['ops'];
//monta paginação de 2 em dois

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
$useRel=$_REQUEST['userRel'];

$icont=0;

foreach ($aOps as $key => $aOp) {
    //Quebra pagina após duas op
    if($icont == 2){
         $pdf->AddPage();
         $pdf->SetXY(5,5);
         $icont=0;
    }
    $icont++;
    
    //busca os dados do banco pegando a op do foreach
    /* $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
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
            op_retrabalho
            from STEEL_PCP_ordensFab left outer join STEEL_PCP_receitas 
            on STEEL_PCP_ordensFab.receita = STEEL_PCP_receitas.cod
            where op =".$aOp." ";
   $dadosOp = $PDO->query($sSql);
   $row = $dadosOp->fetch(PDO::FETCH_ASSOC);
   
   //busca itens do tratamento
    $sSqlItens ="select tratdes,temperatura,STEEL_PCP_ordensFabItens.tratamento,resfriamento,tempo,
                STEEL_PCP_tratamentos.tratcod,tratrevencomp 
                from STEEL_PCP_ordensFabItens left outer join STEEL_PCP_tratamentos 
                on STEEL_PCP_ordensFabItens.tratamento = STEEL_PCP_tratamentos.tratcod  
                where op =".$aOp." order by receita_seq";
        
    $dadosItensOp = $PDO->query($sSqlItens);
    //lógica para saber onde buscar o forno
    $sSqlcount = "select count (prod) as fornocont from STEEL_PCP_fornoProd where prod = ".$row['prod']." ";
    $dadosCount = $PDO->query($sSqlcount);
    $iContForno = $dadosCount->fetch(PDO::FETCH_OBJ);
    if ($iContForno->fornocont >0){
        $sSqlForno="select fornosigla from STEEL_PCP_forno left outer join STEEL_PCP_fornoProd
                   on STEEL_PCP_forno.fornocod = STEEL_PCP_fornoProd.fornocod 
                   where prod = ".$row['prod']." ";
    } else{
        $sSqlForno="select fornosigla  from STEEL_PCP_forno";
    }
    $dadosForno=$PDO->query($sSqlForno);
    
    
    $sSqlMaterial = "select seqmat,STEEL_PCP_PRODMATRECEITA.matcod,matdes
                    from STEEL_PCP_PRODMATRECEITA left outer join steel_pcp_material
                    on STEEL_PCP_PRODMATRECEITA.matcod = steel_pcp_material.matcod
                    where seqmat =".$row['seqMat']." ";
    $dadosMaterial=$PDO->query($sSqlMaterial);
    $rowMat = $dadosMaterial->fetch(PDO::FETCH_ASSOC);
    */
    
    //inicia os dados da op
    
    $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSql = "select op, 
            convert(varchar,STEEL_PCP_ordensFab.data,103)as data,
            documento,peca,
            durezaNucMin,durezaNucMax,
            durezaSuperfMin,durezaSuperfMax,
            expCamadaMin,expCamadaMax,NucEscala, SuperEscala,
            emp_razaosocial,instTrab, progForno,
            prodes,
            prod,
            opcliente,
            matdes,
            dureza,
            quant,
            peso,
            receita,
            convert(varchar,dataprev,103) as dataprev,
            seqMat,
            retrabalho,
            op_retrabalho
            from STEEL_PCP_ordensFab left outer join STEEL_PCP_receitas 
            on STEEL_PCP_ordensFab.receita = STEEL_PCP_receitas.cod
            where op =".$aOp." ";
   $dadosOp = $PDO->query($sSql);
   $row = $dadosOp->fetch(PDO::FETCH_ASSOC);
    
    $sSqlItens ="select fioDurezaSol,fioEsferio,
                fioDescarbonetaTotal,fioDescarbonetaParcial,
                DiamFinalMin,DiamFinalMax
                from STEEL_PCP_ordensFab left outer join STEEL_PCP_prodMatReceita 
                on  STEEL_PCP_ordensFab.seqMat = STEEL_PCP_prodMatReceita.seqmat  
                where op =".$row['op']." order by op";
        
    $dadosItensOp = $PDO->query($sSqlItens);
    $rowIten = $dadosItensOp->fetch(PDO::FETCH_ASSOC);
    
    //Inserção do cabeçalho
    $pdf->Cell(45,10,$pdf->Image($sLogo, $pdf->GetX()+2, $pdf->GetY(), 40,10),1,0,'J');

    $pdf->SetFont('Arial','',14);
    $pdf->Cell(102,10,'ORDEM DE PRODUÇÃO', 1,0, 'C',0);
    
    $pdf->SetFont('Arial','',9);
    $pdf->MultiCell(52,5,'Data: '.$data
            .'        Hora:'.$hora
            .' Usuário:'.$useRel 
            .' ',1,'L',0);
    
    //dados da ordem de produção
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Cliente:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(124, 5, $row['emp_razaosocial'],'B,R',0,'L');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'Nº','L,B,R',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(35, 5, $row['op'],'B,R',1,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Produto: ','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(124, 5, $row['prod'].' - '.$row['prodes'],'B,R',0,'L');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'DATA:','L,B,R',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(35, 5, $row['data'],'B,R',1,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Material:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, $row['matdes'],'B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(19, 5, 'OP do cliente:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, $row['opcliente'],'B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Peso:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, number_format($row['peso'], 2, ',', '.'),'B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'NF do Cliente:','L,B,R',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(35, 5, $row['documento'],'B,R',1,'C');
    
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(199, 5, 'Especificacões','B,R,L',1,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(35, 5, 'Dureza Solicitada :','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(40, 5, 'Máx. '.number_format($rowIten['fioDurezaSol'], 0, ',', '.').' HRB','B,R',0,'L');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'Esferiodização:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(25, 5, 'Mín. '.number_format($rowIten['fioEsferio'], 0, ',', '.').'%','B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(44, 5, 'Descarbonetação(Parcial-Total):','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, number_format($rowIten['fioDescarbonetaParcial'], 0, ',', '.').'mm - '
            .number_format($rowIten['fioDescarbonetaTotal'], 0, ',', '.').'mm','B,R',1,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(39, 5, 'Diâmetro Final (mm):','L,B,R',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(18, 5, number_format($rowIten['DiamFinalMin'], 2, ',', '.'),'B,R',0,'C');
    $pdf->Cell(18, 5, number_format($rowIten['DiamFinalMax'], 2, ',', '.'),'B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'Acabamento:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(99, 5, $row['peca'],'B,R',1,'L');
    
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(199, 5, 'Tratamento','B,R,L',1,'C');
    
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(65, 5, 'Esferoidização de Fio Máquina:','L,B,R',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(25, 5, 'Forno Previsto:','B',0,'L');
    $pdf->Cell(109, 5, ' FP 09 (  )  FP 12(  )','B,R',1,'C');

    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Receita :','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(20, 5, $row['receita'],'B,R',0,'L');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'IT:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(15, 5, $row['instTrab'],'B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(30, 5, 'Programa do Forno:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, $row['progForno'],'B,R',0,'C');
    
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(74, 5, '','B,R',1,'C');
    
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(199, 5, 'Inspeção da Esferiodização','B,R,L',1,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(39, 5, 'Data Realizada:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(36, 5, '','B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'Responsável:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(99, 5, '','B,R',1,'L');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(35, 5, 'Dureza Encontrada :','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(40, 5, '','B,R',0,'L');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'Esferiodização:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(30, 5, 'Descarbonetação:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(39, 5, '','B,R',1,'C');
    
    $pdf->Cell(199, 3, '','',1,'C');
    
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(65, 5, 'Fosfatização de Fio de Máquina:','T,L,B,R',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(25, 5, 'Maquina Prevista:','T,B',0,'L');
    $pdf->Cell(109, 5, '','B,R,T',1,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(39, 5, 'Data Realizada:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(36, 5, '','B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'Responsável:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(99, 5, '','B,R',1,'L');
    
    $pdf->Cell(199, 3, '','',1,'C');
    
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(65, 5, 'Trefilação de Fio Máquina:','T,L,B,R',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(25, 5, 'Trefila Prevista:','T,B',0,'L');
    $pdf->Cell(109, 5, '','B,R,T',1,'C');
    
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(199, 5, 'Inspeção da Esferiodização','B,R,L',1,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(39, 5, 'Data Realizada:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(36, 5, '','B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'Responsável:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(99, 5, '','B,R',1,'L');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(57, 5, 'Diâmetro Inicial (mm):','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(18, 5, '','L,B,R',0,'C');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(18, 5, '','L,B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(70, 5, 'Diâmetro Final (mm): ','L,B',0,'R');
    $pdf->Cell(18, 5, '','L,B,R',0,'C');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(18, 5, '','L,B,R',1,'C');
    
    $pdf->Cell(199, 3, '','',1,'C');
    
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(199, 5, 'Inspeção Final','B,R,L,T',1,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(39, 5, 'Data Realizada:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(36, 5, '','B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'Responsável:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(99, 5, '','B,R',1,'L');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(35, 5, 'Dureza Encontrada :','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(40, 5, '','B,R',0,'L');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'Esferiodização:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(30, 5, 'Descarbonetação:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(39, 5, '','B,R',1,'C');
   
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(39, 5, 'Diâmetro Final (mm):','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(18, 5, '','L,B,R',0,'C');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(18, 5, '','L,B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'NF de Entrega: ','L,B',0,'L');
    $pdf->Cell(30, 5, '','B,R',0,'C');
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(30, 5, 'Data de entrega: ','L,B',0,'L');
    $pdf->Cell(39, 5, '','B,R',0,'C');
    
    $pdf->Cell(199,5, '','',1,'C');
    
    
    //Fim Parte feita pelo Cleverton Hoffmann
    $pdf->Ln();
    
}
 
$pdf->Output('I','RelOpSteel3.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 
