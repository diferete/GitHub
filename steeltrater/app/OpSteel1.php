<?php


// Diretórios
require '../../biblioteca/fpdf/fpdf.php'; 
include("../../includes/Config.php"); 

//captura o número da op
$aOps = $_REQUEST['ops'];
$nrOp ='108966'; 
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

$sLogo ='../../biblioteca/assets/images/steelrel.png'; 
$pdf->SetMargins(5,5,5);
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
     $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
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
    
    //inicia os dados da op
    $pdf->Cell(37,10,$pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 33.78),1,0,'L');
    
    $pdf->SetFont('Arial','',15);

    if ($row['retrabalho']=='Sim'){
        $pdf->Cell(110,10,'ORDEM DE PRODUÇÃO - RETRABALHO',1,0,'C');
        //$pdf->SetFont('Arial','',9);
    }else{
        $pdf->Cell(110,10,'                  ORDEM DE PRODUÇÃO ',1,0,'L');
    }
 

    $pdf->SetFont('Arial','B',9);
    $pdf->MultiCell(52,5,'Número:    '.$row['op'].'                                 '
            . 'Data:          '.$row['data'].' '
            . ' ',1,'J');
    //dados da ordem de produção
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Cliente:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(132, 5, $row['emp_razaosocial'],'B,R',0,'L');
    //nota fiscal do cliente
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(22, 5, 'NF do cliente:','B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, $row['documento'],'B,R',1,'L');
    
    //produto
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Produto:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(132, 5, $row['prod']." - ".$row['prodes'],'B',0,'L');
    
    if ($row['retrabalho']=='Sim'){
    //OP origem
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(20, 5, 'OP Origem:','B,L',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(32, 5, $row['op_retrabalho'],'B,R',1,'L');
    }else{
    $pdf->Cell(52, 5, "  ",'B,R',1,'L');    
    }
    //material
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Material:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, $rowMat['matdes'],'B,R',0,'L');
    //op do cliente
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(21, 5, 'Op do cliente:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(25, 5, $row['opcliente'],'B,R',0,'L');
    //dureza Nuc
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(26, 5, 'Dureza Núcleo:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(28, 5, number_format($row['durezaNucMin'], 0, ',', '.')." - ".
            number_format($row['durezaNucMax'], 0, ',', '.')."  ".$row['NucEscala'],'B',0,'L');
   
    //dureza Superf
    if (($row['durezaSuperfMin']!=0)&&($row['durezaSuperfMax']!=0)){
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(29, 5, 'Dureza Superficial:','L,B',0,'L');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(25, 5, number_format($row['durezaSuperfMin'], 0, ',', '.')." - ".
            number_format($row['durezaSuperfMax'], 0, ',', '.')."  ".$row['SuperEscala'],'B,R',1,'L');
    }else{
        $pdf->Cell(54, 5, '','B,R',1,'L');
    }
    
    //inspeção recebimento
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(40, 5, 'Inspeção de recebimento:','L,B',0,'L');
    $pdf->Cell(159, 5, '     Oxidação superficial (    )              Empenamento (    )   '
            . '     Trincas (    )                  Material / Classe (    )','B,R',1,'L');
    //forno previsto
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 10, 'Forno previsto:','L,B',0,'L');
    
    $iComp=14; //Altera o comprimento que mostra os campos dos fornos trazidos no select
    $iCont=1;
    while($rowForno = $dadosForno->fetch(PDO::FETCH_ASSOC)){
    $pdf->SetFont('Arial','',9);
    $pdf->Cell($iComp, 10, $rowForno['fornosigla'].'(   )','B',0,'L');
    $iCont++;
    }
    $ConTotal=($iCont*$iComp);
    $iCompri=188-$ConTotal;
    $pdf->Cell($iCompri, 10, '','B,R',1,'L');
    //quantidade de peças
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(37, 5, 'Quantidade de peças:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, number_format($row['quant'], 2, ',', '.'),'B,R',0,'L');
    
    //peso
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(37, 5, 'Peso total:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, number_format($row['peso'], 2, ',', '.'),'B,R',0,'L');
    //Inicio Parte feita pelo Cleverton Hoffmann
    //receita/it nr.:
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(35, 5, 'Receita:','B,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, $row['receita'],'B,R',1,'L');
    
    //
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(199,6,'TRATAMENTO TÉRMICO',1,1,'C');
    
    //Etapas do processo
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(60, 5, 'Etapas do Processo','L,B',0,'L');
    
    //Temp.ºC
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(17, 5, 'Temp.ºC','L,B',0,'C');
    
    //Tempo
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(16, 5, 'Tempo','L,B',0,'C');
    
    //Resfriamento
    //$pdf->SetFont('Arial','',9);
   // $pdf->Cell(22, 5, 'Resfriamento','L,B',0,'C');
    
    //Camada (MM)
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(30, 5, 'Camada (MM)','L,B',0,'C');
    
    //Dureza
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(16, 5, 'Dureza','L,B',0,'C');
    
    //Visto
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(16, 5, 'Visto','L,B',0,'C');
    
    //Data
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(18, 5, 'Data','L,B,R',0,'C');
    
    //Inspeção Final
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(26, 5, 'Inspeção Final','L,B,R',1,'C');
    
    $conter=array(1,1);
    //Austenitização //Revenir e Eneg. 
    $iK = 0;
    $rowReve['tratrevencomp'] ='';
    while($rowIten = $dadosItensOp->fetch(PDO::FETCH_ASSOC)){
        //analisa se é necessário buscar o complemento da descrição do tratamento na tela prod/mat/receita
        $rowReve['tratrevencomp'] ='';
        if($rowIten['tratrevencomp']=='Sim'){
            $sSqlProdMatRevenimento = "select tratrevencomp from steel_pcp_prodmatreceita where seqmat =".$row['seqMat']."  ";
            $dadosReven=$PDO->query($sSqlProdMatRevenimento);
            $rowReve = $dadosReven->fetch(PDO::FETCH_ASSOC);
          
        }
        
       $pdf->SetFont('Arial','B',8);
       $sReveComplemento = $rowReve['tratrevencomp'];
       $pdf->Cell(60, 5,$rowIten['tratdes'].' '.$rowReve['tratrevencomp'],'L,B',0,'L');
       
       //Temp.ºC
       $pdf->SetFont('Arial','B',8);
       $pdf->Cell(17, 5, number_format($rowIten['temperatura'], 0, ',', '.'),'L,B',0,'C');
       
       //Tempo
       $pdf->SetFont('Arial','B',8);
       $pdf->Cell(16, 5, number_format($rowIten['tempo'], 0, ',', '.'),'L,B',0,'C');
       
       //Camada (MM)
       if ($iK==0){
            //Camada (MM)
            if (($row['expCamadaMin']!='')||($row['expCamadaMax']!='')){
                 $pdf->SetFont('Arial','B',9);
                 $pdf->Cell(30, 10, number_format($row['expCamadaMin'], 3, ',', '.')." - ".
                          number_format($row['expCamadaMax'], 3, ',', '.'),'L,B',0,'C');
            }else{
                 $pdf->Cell(30, 5, ' _ _ _ ','L',0,'C');
            }
            $iK++;       
       }else {
           $pdf->Cell(30, 5, ' ','L',0,'C');
       }
      // $pdf->Cell(22, 5,'','L,B',0,'C');
       
       //Dureza
       $pdf->SetFont('Arial','',8);
       $pdf->Cell(16, 5, '','L,B',0,'C');

       //Visto
       $pdf->SetFont('Arial','',8);
       $pdf->Cell(16, 5, '','L,B',0,'C');

       //Data
       $pdf->SetFont('Arial','',8);
       $pdf->Cell(18, 5, '/','L,B,R',0,'C');
       
       
       //Inspeção final
       $pdf->Cell(26, 5, '','L,R',1,'C');
 
    }
    
    //Inspeção sistema de dosagem:
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(70, 5, 'Inspeção sistema de dosagem:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','T,B',0,'L');
    
    //Inspeção separação:
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(69, 5, 'Inspeção separação:','L,B,T',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','T,B,R',1,'L');
    
    //Inspeção início da saída:
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(70, 5, 'Inspeção início da saída:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','B,R',0,'L');
    
    //Inspeção fim da saída:
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(69, 5, 'Inspeção fim da saída:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','B,R',1,'L');
    
    //Inspeção visual enegrecimento
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(50, 5, 'Inspeção visual enegrecimento:','L,B',0,'L');
    if ($rowReve['tratrevencomp']!=='À SECO'){
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'Bom (    )','B',0,'C');
    $pdf->Cell(25, 5, 'Tolerável (    )','B',0,'C');
    $pdf->Cell(25, 5, 'Ruim (    )','B',0,'C');
    $pdf->Cell(74, 5, '','B,R',1,'L');
    }else{
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(25, 5, 'Não aplicado (    )','B',0,'C');   
    $pdf->Cell(124, 5, '','B,R',1,'L');
    }
    
    //Entrega Prev
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(37, 5, 'Entrega Prev.:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, $row['dataprev'],'B,R',0,'L');
    
    //Resp. execução
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(37, 5, 'Resp. execução:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','B,R',0,'L');
    
    //Resp. insp. final 
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(35, 5, 'Resp. insp. final:','B,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','B,R',1,'L');
    
     //Data execução
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(37, 5, 'Data execução: ','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','B,R',0,'L');
    
    //Data liberação
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(37, 5, 'Data liberação:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','B,R',0,'L');
    
    //Produtividade 
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(35, 5, 'Produtividade:','B,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','B,R',1,'L');
    
     //Número da NF
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(37, 5, 'Número da NF:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','B,R',0,'L');
    
    //Data entrega
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(37, 5, 'Data entrega:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','B,R',0,'L');
    
    //Número da caixa
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(35, 5, 'Número da caixa:','B,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '','B,R',1,'L');
    
    //Observações
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(199,5,'Observações:',1,1,'L');
    
    //Formulário - PG 06 - 09/10/2017
    $pdf->SetFont('Arial','',2);
    $pdf->Cell(199,1,'','',1);
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(199,1,'Formulário - PG 06 - 09/10/2017','',1,'L');
    $pdf->SetFont('Arial','',2);
    $pdf->Cell(199,1,'','',1);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(199,1,'---------------------------------------------------------------------------------------------------------'
            . '','',1);
    $pdf->SetFont('Arial','',4);
    $pdf->Cell(199,3,'','',1);
    
//ETIQUETA DE IDENTIFICAÇÃO DE RETORNO
    //STEELTRATER
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, 'STEELTRATER',1,0,'C');
    
    //ETIQUETA DE IDENTIFICAÇÃO DE RETORNO
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(169, 5, 'ETIQUETA DE IDENTIFICAÇÃO DE RETORNO',1,1,'C');
    
    //Cliente
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Cliente:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(119, 5, $row['emp_razaosocial'],'B,R',0,'L');

    //Data de entrada
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(35, 5, 'Data de entrada:','B,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, $row['data'],'B,R',1,'L');
    
    
    //Número da OP
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(37, 5, 'Número da OP:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5,$row['op'] ,'B,R',0,'L');
    
    //OP do cliente
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(37, 5, 'OP do cliente:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, $row['opcliente'],'B,R',0,'L');
    
    //receita/it nr.:
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(35, 5, 'Receita:','B,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, $row['receita'],'B,R',1,'L');
    
    //Dureza Nucleo
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(27, 5, 'Dureza Núcleo:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(27, 5, number_format($row['durezaNucMin'], 0, ',', '.')." - ".
            number_format($row['durezaNucMax'], 0, ',', '.')."  ".$row['NucEscala'],'B',0,'L');
    
    //Dureza Superf
    if (($row['durezaSuperfMin']!=0)&&($row['durezaSuperfMax']!=0)){
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(29, 5, 'Dureza Superficial:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(25, 5, number_format($row['durezaSuperfMin'], 0, ',', '.')." - ".
            number_format($row['durezaSuperfMax'], 0, ',', '.')."  ".$row['SuperEscala'],'B',0,'L');
    }else{
        $pdf->Cell(54, 5, '','B,R',0,'L');
    }
    
    //Dureza obtida:
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(31, 5, 'Dureza obtida:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(25, 5, '','B,R',0,'L');
    
    //Material
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(14, 5, 'Material:','B,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(21, 5, $rowMat['matdes'],'B,R',1,'L');
    
    //Produto
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'Produto:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(139, 5, $row['prod']." - ".$row['prodes'],'B,R',0,'L');
    
    //Peso
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(14, 5, 'Peso:','B,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(21, 5, number_format($row['peso'], 2, ',', '.'),'B,R',1,'L');
    
    
    //Fim Parte feita pelo Cleverton Hoffmann
    $pdf->Ln();
    
}
 
 $pdf->Output('I','solvenda.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
