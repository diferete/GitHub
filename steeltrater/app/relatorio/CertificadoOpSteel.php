<?php

if(isset($_REQUEST['email'])){
  $sEmailRequest ='S';  
}else{
   $sEmailRequest ='N'; 
}

// Diretórios
if($sEmailRequest=='S'){     
  include 'biblioteca/fpdf/fpdf.php';
  }else{
  include '../../biblioteca/fpdf/fpdf.php';
  include("../../includes/Config.php"); 
  include("../../includes/Fabrica.php");
  include("../../biblioteca/Utilidades/Email.php");  
 }


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
if($sEmailRequest=='S'){ 
  $sLogo ='biblioteca/assets/images/steelrel.png';
}else{
    $sLogo ='../../biblioteca/assets/images/steelrel.png';
    }
$pdf->SetMargins(5,5,5);


$aNrs = $_REQUEST['nrcert'];

$icont=0;
$sCertsRel='';
foreach ($aNrs as $key => $aNr) {
    //Quebra pagina após duas op
    if($icont == 1){
         $pdf->AddPage();
         $pdf->SetXY(5,5);
         $icont=0;
    }
    $icont++;
    
    $sCertsRel .=$aNr.','; 

//Caminho do usuário, data e hora
date_default_timezone_set('America/Sao_Paulo');
$data      = date("d/m/y");                     //função para pegar a data local
$hora      = date("H:i");                       //para pegar a hora com a função date
$useRel=$_REQUEST['userRel'];

//Inserção do cabeçalho
$pdf->Cell(40,10,$pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY()+2, 40, 10),0,0,'L');

//busca os dados do banco pegando a op do foreach
     $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSql = "select STEEL_PCP_Certificado.nrcert,
            convert(varchar,STEEL_PCP_Certificado.dataensaio,103)as dataensaio,
            convert(varchar,STEEL_PCP_Certificado.dataemissao,103)as dataemissao,
            empdes,notasteel,notacliente,
            STEEL_PCP_ordensFab.durezaNucMin,
            STEEL_PCP_ordensFab.durezaNucMax,
            STEEL_PCP_ordensFab.NucEscala,
            STEEL_PCP_ordensFab.durezaSuperfMin ,
            STEEL_PCP_ordensFab.durezaSuperfMax ,
            STEEL_PCP_ordensFab.superEscala,
            STEEL_PCP_ordensFab.expCamadaMin,
            STEEL_PCP_ordensFab.expCamadaMax,
            STEEL_PCP_Certificado.durezaNucMin as certDurezaNucMin,
            STEEL_PCP_Certificado.durezaNucMax as certDurezaNucMax,
            STEEL_PCP_Certificado.NucEscala as certNucEscala,
            STEEL_PCP_Certificado.durezaSuperfMin as certDurezaSuperfMin,
            STEEL_PCP_Certificado.durezaSuperfMax as certDurezaSuperfMax,
            STEEL_PCP_Certificado.superEscala as certSuperEscala,
            STEEL_PCP_Certificado.expCamadaMin as certExpCamadaMin,
            STEEL_PCP_Certificado.expCamadaMax as certExpCamadaMax,
            tratrevencomp,receita,inspeneg,
            STEEL_PCP_Certificado.procod,
            STEEL_PCP_Certificado.prodes,
            STEEL_PCP_Certificado.peso,
            STEEL_PCP_Certificado.opcliente,
            STEEL_PCP_Certificado.op
            from STEEL_PCP_Certificado left outer join STEEL_PCP_ordensFab 
            on STEEL_PCP_ordensFab.op = STEEL_PCP_Certificado.op
            where STEEL_PCP_Certificado.nrcert =".$aNr." ";
   $dadosNr = $PDO->query($sSql);
   $row = $dadosNr->fetch(PDO::FETCH_ASSOC);
   
   
   $sSqlItens ="select tratdes,STEEL_PCP_ordensFabItens.tratamento,
                STEEL_PCP_tratamentos.tratcod,tratrevencomp 
                from STEEL_PCP_ordensFabItens left outer join STEEL_PCP_tratamentos 
                on STEEL_PCP_ordensFabItens.tratamento = STEEL_PCP_tratamentos.tratcod  
                where op =".$row['op']." order by op";
        
    $dadosItensOp = $PDO->query($sSqlItens);
    
$pdf->SetFont('Arial','',15);
$pdf->Cell(110,15,'CONTROLE DE QUALIDADE', '',0, 'C',0);

$pdf->SetFont('Arial','',9);
$pdf->MultiCell(52,7,'Data: '.$data
        .'        Hora:'.$hora
        .' Usuário:'.$useRel 
        .' ','','L',0);
$pdf->Cell(0,2,'','B',1,'L');
$pdf->Cell(0,1,'','',1,'L');
$pdf->Cell(0,5,'','',1,'L');
 
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(199, 5, 'CERTIFICADO Nº: '.$aNr,'B',1,'L');
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
 $pdf->Cell(25, 5,$row['procod'],'',0,'L');
 $pdf->Cell(120, 5,$row['prodes'],'',1,'L');
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
     $sk = '+';
     $ik=0;
     $oTratamento = '';
     while($rowIten = $dadosItensOp->fetch(PDO::FETCH_ASSOC)){
        //analisa se é necessário buscar o complemento da descrição do tratamento na tela ordensFab
        $rowReve['tratrevencomp'] ='';
        if($rowIten['tratrevencomp']=='Sim'){
            $sSqlOpRevenimento = "select tratrevencomp from STEEL_PCP_ordensFab  where op =".$row['op']."  ";
            $dadosReven=$PDO->query($sSqlOpRevenimento);
            $rowReve = $dadosReven->fetch(PDO::FETCH_ASSOC);
        }
       $pdf->SetFont('Arial','B',10);
       $oTratamento = $rowIten['tratdes'].' '.$rowReve['tratrevencomp'].''.$sk.'';
       $pdf->Cell(36, 5,$oTratamento,'',0,'L');
       $sk = substr_replace($sk, ' ', 0);
       if ($ik==0){
           $oTratamento1 = $oTratamento;
           $ik++;
       }
    }
    $pdf->Cell(0,5,'','',1,'L');
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
 $pdf->Cell(144, 5, $row['op'],'',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ////////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Execução no Processo: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(36, 5,$oTratamento1.' '.$oTratamento,'',0,'L');
 $pdf->Cell(0,5,'','',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Dureza da Superfície: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, number_format($row['certDurezaSuperfMin'], 0, ',', '.')." - ".
            number_format($row['certDurezaSuperfMax'], 0, ',', '.')."  ".$row['certSuperEscala'],'',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Dureza do Núcleo: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(144, 5, number_format($row['certDurezaNucMin'], 0, ',', '.')." - ".
            number_format($row['certDurezaNucMax'], 0, ',', '.')."  ".$row['certNucEscala'],'',1,'L');
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
 $pdf->Cell(144, 5, number_format($row['certExpCamadaMin'], 3, ',', '.')." - ".
                          number_format($row['certExpCamadaMax'], 3, ',', '.').'mm','',1,'L');
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
 $pdf->Cell(144, 5, $row['receita'],'',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 ///////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(55, 5, 'Inspeção do Enegrecimento: ','',0,'R');
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(119, 5, $row['inspeneg'],'',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 
 
 //////////////////////////////////////////
 $pdf->Cell(0,10,'','',1,'L');
 /////////////////////////////////////////
 
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(199, 5, 'CONCLUSÃO','B',1,'L');
 $pdf->Cell(0,2,'','',1,'L');
 /////////////////////////////////////////////
 $pdf->SetFont('Arial','',10);
 $pdf->Cell(199, 5, 'Foram atingidas suas especificações conforme solicitado no documento de remessa. ','',0,'L');
 
 
$pdf->Ln();

}


 //retira ultimo caracter var de ops separado por vírgula
 $sCertsRel = substr_replace($sCertsRel, '', -1);
 if($sEmailRequest=='S'){
    $pdf->Output('F','app/relatorio/steeltrater_cert/Certificado '.$sCertsRel.'.pdf'); // GERA O PDF NA TELA
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
  }else{
    $pdf->Output('I','Certificado '.$sCertsRel.'.pdf');
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
  }  


//envia por email se necessário
if($sEmailRequest=='S'){ 
      
      $oEmail = new Email();
      $oEmail->setMailer();
      /*testes*/
      $oEmail->setEnvioSMTP();
      //$oEmail->setServidor('mail.construtoramatosteixeira.com.br');
      $oEmail->setServidor('smtp.terra.com.br');
      $oEmail->setPorta(587);
      $oEmail->setAutentica(true);
      $oEmail->setUsuario('metalboweb@metalbo.com.br');
      $oEmail->setSenha('filialwe');
      $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'),utf8_decode('Certificados SteelTrater'));
       
      $oEmail->setAssunto(utf8_decode('Certificado número(s) '.$sCertsRel));
      $oEmail->setMensagem(utf8_decode('Anexo certificado número(s) '.$sCertsRel));
      $oEmail->limpaDestinatariosAll();
      
      //busca array de destinatários
      //$_REQUEST['empresaCert']
    if(isset($_REQUEST['empresaCert'])){
        $sEmpCert =$_REQUEST['empresaCert'];
      }else{
         $sEmpCert =''; 
      }

      $aEmails = array();
      $oContatos = Fabrica::FabricarController('STEEL_PCP_contatoCert');
      $oContatos->Persistencia->adicionaFiltro('emp_codigo',$sEmpCert);
      $aModelContato = $oContatos->Persistencia->getArrayModel();
      foreach ($aModelContato as $oContatoCert) {
          $aEmails[]=$oContatoCert->getEmpcertemail();
      }
      //para se não tiver contatos
      if(count($aEmails)==0){
         $oModal = new Modal('Atenção!', 'Não tem cadastro de e-mail para esta empresa!', Modal::TIPO_INFO, false);
         echo $oModal->getRender();
      }
        
      // Para
      $aDestinatario = array();
      //$aEmails[] = 'avaneim@gmail.com';
      foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
            $aDestinatario[]=$sEmail;
        }
        
      // Cópia
    //  $aCopia = array();
    //  $aCopia[] = 'avaneim@gmail.com';
    //  $aCopia[] = 'avanei@rexmaquinas.com.br';
      
       // foreach ($aCopia as $sCopia) {
        //    $oEmail->addDestinatarioCopia($sCopia);
        //    $aDestinatario[]=$sCopia;
       // }
        
        $oEmail->addAnexo('app/relatorio/steeltrater_cert/Certificado '.$sCertsRel.'.pdf', utf8_decode('Certificado(s) '.$sCertsRel));
        
        $aRetorno = $oEmail->sendEmail();
        if($aRetorno[0]){
            $oMensagem = new Mensagem('Sucesso!', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        }else{
            $oMensagem = new Mensagem('Atenção!', 'E-mail não enviado '.$aRetorno[1], Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
        $aRetorno[2]=$aDestinatario;
        return $aRetorno;
 }