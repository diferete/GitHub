<?php


// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
require '../../biblioteca/code/code39.php';
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
//Instancia classe que imprime o código de barras
$pdf=new PDF_Code39();
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
$iop = 0;
foreach ($aOps as $key => $aOp) {
    //Quebra pagina após três receitas ou duas páginas
    if(($icont > 3)||($iop>1)){
         $pdf->AddPage();
         $pdf->SetXY(5,5);
         $icont=0;
         $iop = 0;
    } 
    $iop++;
    //busca os dados do banco pegando a op do foreach
        
    $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSql = "select op, 
            convert(varchar,STEEL_PCP_ordensFab.data,103)as data,
            documento,peca,
            durezaNucMin,durezaNucMax,
            durezaSuperfMin,durezaSuperfMax,
            expCamadaMin,expCamadaMax,NucEscala, SuperEscala,
            emp_razaosocial,instTrab, progForno,
            prodes,fioDurezaSol,fioEsferio,
            fioDescarbonetaTotal,fioDescarbonetaParcial,
            DiamFinalMin,DiamFinalMax,
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
            op_retrabalho, prodFinal,prodesFinal,tipoOrdem,referencia,tipoOrdem
            from STEEL_PCP_ordensFab left outer join STEEL_PCP_receitas 
            on STEEL_PCP_ordensFab.receita = STEEL_PCP_receitas.cod
            where op =".$aOp." ";
   $dadosOp = $PDO->query($sSql);
   $row = $dadosOp->fetch(PDO::FETCH_ASSOC);
   
   //busca itens do tratamento
    $sSqlItens ="select tratdes,STEEL_PCP_ordensFabItens.tratamento,
                STEEL_PCP_tratamentos.tratcod,tratrevencomp 
                from STEEL_PCP_ordensFabItens left outer join STEEL_PCP_tratamentos 
                on STEEL_PCP_ordensFabItens.tratamento = STEEL_PCP_tratamentos.tratcod  
                where op =".$aOp." order by receita_seq";
        
    $dadosItensOp = $PDO->query($sSqlItens);
    
    if ($iop>1){
    $pdf->Cell(199,5,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -'
            . ' - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -'
            . ' - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -', '',1, 'C',0);
    }
    
    //Inserção do cabeçalho
  //  $pdf->Cell(45,10,$pdf->Image($sLogo, $pdf->GetX()+2, $pdf->GetY(), 40,10),1,0,'J');
    $pdf->Cell(37,8,$pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 33.78),1,0,'L');
    
    $pdf->SetFont('Arial','',14);
    //$pdf->Cell(102,10,'ORDEM DE PRODUÇÃO', 1,0, 'C',0);
    
    if ($row['retrabalho']=='Sim'){
        $pdf->Cell(110,8,'ORDEM DE PRODUÇÃO - RETRABALHO',1,0,'C',0);
        //código que imprime o código de barras
        $pdf->Code39(155,$pdf->GetY()+1,$row['op'],1,5);
        $pdf->Cell(52,8,' ','L,B,T,R',1,'C');    
    }else{
        $pdf->Cell(110,8,'ORDEM DE PRODUÇÃO',1,0,'C',0);
        //código que imprime o código de barras
        $pdf->Code39(155,$pdf->GetY()+1,$row['op'],1,5);
        $pdf->Cell(52,8,' ','L,B,T,R',1,'C');    
    }   
    
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(50,5,'Usuário: '.$useRel,'L,B,R',0,'L');
    $pdf->Cell(50,5,'Data: '.$data,'L,B,R',0,'L');
    $pdf->Cell(47,5,'Hora: '.$hora,'L,B,R',0,'L');
    $pdf->Cell(52,5,'Número: '.$row['op'],'L,B,R',1,'L');
   
    //dados da ordem de produção
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Cliente:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(124, 5, $row['emp_razaosocial'],'B',0,'L');
    
    if ($row['retrabalho']=='Sim'){
             
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(25, 5, 'OP Origem:','L,B,R',0,'L');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(35, 5, $row['op_retrabalho'],'B,R',1,'C');
    
    }else{
        
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(25, 5, '','B',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(35, 5, '','B,R',1,'C');
        
    }
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Produto: ','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(124, 5, $row['referencia'].' - '.$row['prodes'],'B,R',0,'L');
    
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
    
    //if ($row['tipoOrdem']=='A'){
        
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(26, 5, 'Produto Final: ','L,B',0,'L');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(173, 5, $row['prodFinal'].'  -  '.$row['prodesFinal'],'B,R',1,'L');
              
    //}else{
    ////////////////
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(199, 5, 'Especificacões','B,R,L',1,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(35, 5, 'Dureza Solicitada :','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(40, 5, 'Máx. '.number_format($row['fioDurezaSol'], 0, ',', '.').' HRB','B,R',0,'L');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'Esferoidização:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(25, 5, 'Mín. '.number_format($row['fioEsferio'], 0, ',', '.').'%','B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(44, 5, 'Descarbonetação(Parcial-Total):','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, number_format($row['fioDescarbonetaParcial'], 0, ',', '.').'µm - '
            .number_format($row['fioDescarbonetaTotal'], 0, ',', '.').'µm','B,R',1,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(39, 5, 'Diâmetro Final (µm):','L,B,R',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(18, 5, number_format($row['DiamFinalMin'], 2, ',', '.'),'B,R',0,'C');
    $pdf->Cell(18, 5, number_format($row['DiamFinalMax'], 2, ',', '.'),'B,R',0,'C');
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 5, 'Acabamento:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(99, 5, $row['peca'],'B,R',1,'L');
    //}
    
    //$pdf->Cell(199, 2, '','B',1,'C');
   // $pdf->Cell(199, 1, '','B',1,'C');    
   // $pdf->Cell(199, 1, '','',1,'C');
    
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(199, 5, 'TRATAMENTOS','',1,'C');
    
    while($rowIten = $dadosItensOp->fetch(PDO::FETCH_ASSOC)){
        
        $sNumTrat = (int) $rowIten['tratcod'];
        
        switch ($sNumTrat){
            //CEMENTAÇÃO
            case 1:
                $pdf->Cell(199, 1, '','',1,'C');
                
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(65, 5, $rowIten['tratdes'],'L,T,B,R',0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(25, 5, 'Cementação Prevista','T,B',0,'L');
                $pdf->Cell(109, 5, '','B,R,T',1,'C');

//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(39, 5, 'Data Realizada:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(36, 5, '','B,R',0,'C');
//
//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(25, 5, 'Responsável:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(99, 5, '','B,R',1,'L');
                
                $icont++;
                break;
            //AUSTENITIZAÇÃO
            case 4:
                $pdf->Cell(199, 1, '','',1,'C');
                
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(65, 5, $rowIten['tratdes'],'L,T,B,R',0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(25, 5, 'Autenitização Prevista','T,B',0,'L');
                $pdf->Cell(109, 5, '','B,R,T',1,'C');

//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(39, 5, 'Data Realizada:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(36, 5, '','B,R',0,'C');
//
//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(25, 5, 'Responsável:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(99, 5, '','B,R',1,'L');
                
                $icont++;
                break;
            //RECOZIMENTO
            case 9:
                $pdf->Cell(199, 1, '','',1,'C');
                
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(65, 5, $rowIten['tratdes'],'L,T,B,R',0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(25, 5, 'Recozimento Previsto','T,B',0,'L');
                $pdf->Cell(109, 5, '','B,R,T',1,'C');

//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(39, 5, 'Data Realizada:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(36, 5, '','B,R',0,'C');
//
//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(25, 5, 'Responsável:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(99, 5, '','B,R',1,'L');
                
                $icont++;
                break;
            //ESFEROIDIZAÇÃO DE FIO MÁQUINA
            case 15:
                $pdf->Cell(199, 1, '','',1,'C');
                
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(65, 5, $rowIten['tratdes'],'L,T,B,R',0,'L');
                
              //  $pdf->Cell(109, 5, ' FP 09 (  )  FP 12(  )','T,B,R',1,'C');

                $pdf->SetFont('Arial','',9);
                $pdf->Cell(13, 5, 'Receita :','L,B,T',0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(22, 5, $row['receita'],'B,R,T',0,'C');

                $pdf->SetFont('Arial','',9);
                $pdf->Cell(5, 5, 'IT:','L,B,T',0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(25, 5, $row['instTrab'],'B,R,T',0,'C');

                $pdf->SetFont('Arial','',9);
                $pdf->Cell(30, 5, 'Programa do Forno:','L,T,B',0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(39, 5, $row['progForno'],'B,R,T',1,'C');
                
                //Inicia a impressão da linha forno previsto
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(25, 5, 'Forno Previsto:','B,T,L',0,'L');
                
                 //lógica para saber onde buscar o forno
                $sSqlcount = "select count (prod) as fornocont from STEEL_PCP_fornoProd where prod = ".$row['prod']." ";
                $dadosCount = $PDO->query($sSqlcount);
                $iContForno = $dadosCount->fetch(PDO::FETCH_OBJ);
                if ($iContForno->fornocont >0){
                    $sSqlForno="select fornosigla from STEEL_PCP_forno left outer join STEEL_PCP_fornoProd
                               on STEEL_PCP_forno.fornocod = STEEL_PCP_fornoProd.fornocod 
                               where prod = ".$row['prod']." ";
                } else{
                    $sSqlForno="select fornosigla  from STEEL_PCP_forno where tipoOrdem = '".$row['tipoOrdem']."'";
                }
                $dadosForno=$PDO->query($sSqlForno);
                
                $iComp=16; //Altera o comprimento que mostra os campos dos fornos trazidos no select
                $iCont=1;
                while($rowForno = $dadosForno->fetch(PDO::FETCH_ASSOC)){
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell($iComp, 5, $rowForno['fornosigla'].'(   ) ','B',0,'L');
                $iCont++;
                }
                $ConTotal=($iCont*$iComp);
                $iCompri=190-$ConTotal;
                $pdf->Cell($iCompri, 5, '','B,R',1,'L');
                
                
              // $pdf->SetFont('Arial','B',9);
              // $pdf->Cell(74, 5, '','B,R',1,'C');

                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(199, 5, 'Inspeção da Esferoidização','B,R,L',1,'C');

//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(39, 5, 'Data Realizada:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(36, 5, '','B,R',0,'C');
//
//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(25, 5, 'Responsável:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(99, 5, '','B,R',1,'L');

                $pdf->SetFont('Arial','',9);
                $pdf->Cell(35, 5, 'Dureza Encontrada :','L,B',0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(40, 5, '','B,R',0,'L');

                $pdf->SetFont('Arial','',9);
                $pdf->Cell(25, 5, 'Esferoidização:','L,B',0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(30, 5, '','B,R',0,'C');

                $pdf->SetFont('Arial','',9);
                $pdf->Cell(30, 5, 'Descarbonetação:','L,B',0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(39, 5, '','B,R',1,'C');
               
                $icont++;
                break;
            //TREFILA
            case 20:
                $pdf->Cell(199, 1, '','',1,'C');
                
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(65, 5, $rowIten['tratdes'],'L,T,B,R',0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(25, 5, 'Trefila Prevista:','T,B',0,'L');
                $pdf->Cell(109, 5, '','B,R,T',1,'C');

                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(199, 5, 'Inspeção da Trefila','B,R,L',1,'C');

//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(39, 5, 'Data Realizada:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(36, 5, '','B,R',0,'C');
//
//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(25, 5, 'Responsável:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(99, 5, '','B,R',1,'L');

                $pdf->SetFont('Arial','',9);
                $pdf->Cell(57, 5, 'Diâmetro Inicial (µm):','L,B',0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(18, 5, '','L,B,R',0,'C');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(18, 5, '','L,B,R',0,'C');

                $pdf->SetFont('Arial','',9);
                $pdf->Cell(70, 5, 'Diâmetro Final (µm): ','L,B',0,'R');
                $pdf->Cell(18, 5, '','L,B,R',0,'C');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(18, 5, '','L,B,R',1,'C');
                
                $icont++;
                break;
            //REVENIR
            case 21:
                $pdf->Cell(199, 1, '','',1,'C');
                
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(65, 5, $rowIten['tratdes'],'L,T,B,R',0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(25, 5, 'Revenimento Previsto','T,B',0,'L');
                $pdf->Cell(109, 5, '','B,R,T',1,'C');

//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(39, 5, 'Data Realizada:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(36, 5, '','B,R',0,'C');
//
//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(25, 5, 'Responsável:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(99, 5, '','B,R',1,'L');
                
                $icont++;
                break;
            //FOSFATIZAÇÃO
            case 22:
                $pdf->Cell(199, 1, '','',1,'C');
                
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(65, 5, $rowIten['tratdes'],'L,T,B,R',0,'L');
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(25, 5, 'Maquina Prevista:','T,B',0,'L');
                $pdf->Cell(109, 5, '','B,R,T',1,'C');

//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(39, 5, 'Data Realizada:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(36, 5, '','B,R',0,'C');
//
//                $pdf->SetFont('Arial','',9);
//                $pdf->Cell(25, 5, 'Responsável:','L,B',0,'L');
//                $pdf->SetFont('Arial','B',9);
//                $pdf->Cell(99, 5, '','B,R',1,'L');
                
                $icont++;
                break;
        }
        
        
    }
        $pdf->Cell(199,1, '','',1,'C');
        //INSPEÇÃO FINAL
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(199, 5, 'Inspeção Final','B,R,L,T',1,'C');

//        $pdf->SetFont('Arial','',9);
//        $pdf->Cell(39, 5, 'Data Realizada:','L,B',0,'L');
//        $pdf->SetFont('Arial','B',9);
//        $pdf->Cell(36, 5, '','B,R',0,'C');
//
//        $pdf->SetFont('Arial','',9);
//        $pdf->Cell(25, 5, 'Responsável:','L,B',0,'L');
//        $pdf->SetFont('Arial','B',9);
//        $pdf->Cell(99, 5, '','B,R',1,'L');

        $pdf->SetFont('Arial','',9);
        $pdf->Cell(35, 5, 'Dureza Encontrada :','L,B',0,'L');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(40, 5, '','B,R',0,'L');

        $pdf->SetFont('Arial','',9);
        $pdf->Cell(25, 5, 'Esferoidização:','L,B',0,'L');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(30, 5, '','B,R',0,'C');

        $pdf->SetFont('Arial','',9);
        $pdf->Cell(30, 5, 'Descarbonetação:','L,B',0,'L');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(39, 5, '','B,R',1,'C');

        $pdf->SetFont('Arial','',9);
        $pdf->Cell(39, 5, 'Diâmetro Final (µm):','L,B',0,'L');
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
        
    
    //Fim Parte feita pelo Cleverton Hoffmann
    $pdf->Ln();
    
}
 
$pdf->Output('I','RelOpSteel3.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 
