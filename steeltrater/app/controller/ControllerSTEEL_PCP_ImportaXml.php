<?php

/* 
 * Classe que implementa a controller de importaçao de xml
 * @author Avanei Martendal
 * @since 13/02/2019
 */

class ControllerSTEEL_PCP_ImportaXml extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_ImportaXml');
    }
    
    public function antesIncluir($sParametros = null) {
        parent::antesIncluir($sParametros);
         $this->setBDesativaBotaoPadrao(true);
    }
    
    public function Upload(){
         if(isset($_FILES)){
            foreach($_FILES as $oAtual){
                if(isset($oAtual)){
                    $oArquivo['CAMPO'] = $_REQUEST['nome'];
                    
                    //Captura raiz do servidor, concatenando pasta do projeto e url de upload
                   // $oArquivo['DIRETORIO'] = $_SERVER['DOCUMENT_ROOT'].Config::PROJ_FOLDER . '/Uploads/';
                     $oArquivo['DIRETORIO'] = 'ImpNfe/steeltrater/';  //ImpNfe\steeltrater
                     
                    //Caputura nome do arquivo a ser feito upload
                    $oArquivo['NOME'] = $oAtual['name'];
                    
                    //Captura nome do arquivo temporario a ser movido para pasta escolhida
                    $oArquivo['TEMP'] = $oAtual['tmp_name'];
                    
                    //Captura extensão do arquivo
                    $oArquivo['EXTENSAO'] = pathinfo($oArquivo['NOME'],PATHINFO_EXTENSION);
                    
                    //Cria novo nome, junto com a extensão
                    $oArquivo['NOME_NOVO'] =$oArquivo['NOME'];  //md5(date("d_m_y_h_i_s")). '.' . $oArquivo['EXTENSAO'];
                    
                     //Concatena pasta diretorio, juntamente com novo nome do arquivo   
                    $oArquivo['DIR_NOME'] = $oArquivo['DIRETORIO'] . $oArquivo['NOME_NOVO'];
                   
                    /*$fp = fopen("bloco1.txt", "w");
                    $escreve = fwrite($fp,$oArquivo['NOME_NOVO']);
                    fclose($fp);*/
                    
                    
                    //Move arquivo temporario para pasta escolhida juntamente com seu novo nome.
                    move_uploaded_file($oArquivo['TEMP'],$oArquivo['DIR_NOME']);
                    
                    $sRetorno = json_encode(['uploaded' => 'true', 'nome' => $oArquivo['NOME_NOVO'], 'campo' => $oArquivo['CAMPO']]);
                    echo $sRetorno;
                    
                    $this->importaXml($oArquivo);
                   
                } else {
                    echo '0';
                }
            }
        } else {
            echo '0';
        }
    }
    
    public function importaXml($aArquivo){
        //verifica se o arquivo existe
        if (file_exists($aArquivo['DIR_NOME'])){
            
	    $arquivo = $aArquivo['DIR_NOME'];
            $xml = simplexml_load_file($arquivo);
	    // imprime os atributos do objeto criado
            if (empty($xml->protNFe->infProt->nProt)){
		echo "<h4>Arquivo sem dados de autorização!</h4>";
		exit;	
		}
	    $chave = $xml->NFe->infNFe->attributes()->Id;
	    $chave = strtr(strtoupper($chave), array("NFE" => NULL));  	
            //</ide>
            $cUF = $xml->NFe->infNFe->ide->cUF;    		    //<cUF>41</cUF>  Código do Estado do Fator gerador
            $cNF = $xml->NFe->infNFe->ide->cNF;       	    //<cNF>21284519</cNF>   Código número da nfe
            $natOp = $xml->NFe->infNFe->ide->natOp;         //<natOp>V E N D A</natOp>  Resumo da Natureza de operação
            $indPag = $xml->NFe->infNFe->ide->indPag;      //<indPag>2</indPag> 0 – pagamento à vista; 1 – pagamento à prazo; 2 - outros
            $mod = $xml->NFe->infNFe->ide->mod;            //<mod>55</mod> Modelo do documento Fiscal
            $serie = $xml->NFe->infNFe->ide->serie;    	   //<serie>2</serie> 
            $nNF =  $xml->NFe->infNFe->ide->nNF;   	       //<nNF>19685</nNF> Número da Nota Fiscal
            $dEmi = $xml->NFe->infNFe->ide->dhEmi;          //<dEmi>2011-09-06</dEmi> Data de emissão da Nota Fiscal
            $tpNF = $xml->NFe->infNFe->ide->tpNF;         //<tpNF>1</tpNF>  0-entrada / 1-saída
            $cMunFG = $xml->NFe->infNFe->ide->cMunFG;     //<cMunFG>4106407</cMunFG> Código do municipio Tabela do IBGE
            $tpImp = $xml->NFe->infNFe->ide->tpImp;       //<tpImp>1</tpImp> 
            $tpEmis = $xml->NFe->infNFe->ide->tpEmis;     //<tpEmis>1</tpEmis>
            $cDV = $xml->NFe->infNFe->ide->cDV;           //<cDV>0</cDV>
            $tpAmb = $xml->NFe->infNFe->ide->tpAmb;       //<tpAmb>1</tpAmb>
            $finNFe = $xml->NFe->infNFe->ide->finNFe;     //<finNFe>1</finNFe>
            $procEmi = $xml->NFe->infNFe->ide->procEmi;   //<procEmi>0</procEmi>
            $verProc = $xml->NFe->infNFe->ide->verProc;   //<verProc>2.0.0</verProc>
            //</ide>
            $xMotivo = $xml->protNFe->infProt->xMotivo;	
            $nProt = $xml->protNFe->infProt->nProt;
            
            // <emit> Emitente
            $emit_CPF = $xml->NFe->infNFe->emit->CPF;
            $emit_CNPJ = $xml->NFe->infNFe->emit->CNPJ;  				
            $emit_xNome = $xml->NFe->infNFe->emit->xNome; 				
            $emit_xFant = $xml->NFe->infNFe->emit->xFant;     			
            //<enderEmit>
            $emit_xLgr = $xml->NFe->infNFe->emit->enderEmit->xLgr;		//<xLgr>AV. AGOSTINHO DUCCI , 409</xLgr>
            $emit_nro= $xml->NFe->infNFe->emit->enderEmit->nro; 			//<nro>.</nro>
            $emit_xBairro = $xml->NFe->infNFe->emit->enderEmit->xBairro; //<xBairro>PARQUE INDUSTRIAL</xBairro>
            $emit_cMun = $xml->NFe->infNFe->emit->enderEmit->cMun; 		//<cMun>4106407</cMun>
            $emit_xMun = $xml->NFe->infNFe->emit->enderEmit->xMun; 		//<xMun>CORNELIO PROCOPIO</xMun>
            $emit_UF = $xml->NFe->infNFe->emit->enderEmit->UF; 			//<UF>PR</UF>
            $emit_CEP = $xml->NFe->infNFe->emit->enderEmit->CEP; 		//<CEP>86300000</CEP>
            $emit_cPais = $xml->NFe->infNFe->emit->enderEmit->cPais; 	//<cPais>1058</cPais>
            $emit_xPais = $xml->NFe->infNFe->emit->enderEmit->xPais; 	//<xPais>BRASIL</xPais>
            $emit_fone = $xml->NFe->infNFe->emit->enderEmit->fone; 		//<fone>4335242165</fone>
            //</enderEmit>
            $emit_IE = $xml->NFe->infNFe->emit->IE; 				   //<IE>9014134104</IE>
            $emit_IM = $xml->NFe->infNFe->emit->IM; 				   //<IM>8636</IM>
            $emit_CNAE = $xml->NFe->infNFe->emit->CNAE; 			   //<CNAE>4789099</CNAE>
            $emit_CRT = $xml->NFe->infNFe->emit->CRT; //<CRT>3</CRT>
             //</emit>
            //<dest>
            $dest_cnpj =  $xml->NFe->infNFe->dest->CNPJ;       		        //<CNPJ>01153928000179</CNPJ>
		//<CPF></CPF>
            $dest_xNome = $xml->NFe->infNFe->dest->xNome;       		      //<xNome>AGROVENETO S.A.- INDUSTRIA DE ALIMENTOS  -002825</xNome>

//***********************************************************************************************************************************************	
		

            //<enderDest>
            $dest_xLgr = $xml->NFe->infNFe->dest->enderDest->xLgr;            //<xLgr>ALFREDO PESSI, 2.000</xLgr>
            $dest_nro =  $xml->NFe->infNFe->dest->enderDest->nro;     		  //<nro>.</nro>
            $dest_xBairro = $xml->NFe->infNFe->dest->enderDest->xBairro;      //<xBairro>PARQUE INDUSTRIAL</xBairro>
            $dest_cMun = $xml->NFe->infNFe->dest->enderDest->cMun;            //<cMun>4211603</cMun>
            $dest_xMun = $xml->NFe->infNFe->dest->enderDest->xMun;            //<xMun>NOVA VENEZA</xMun>
            $dest_UF = $xml->NFe->infNFe->dest->enderDest->UF;                //<UF>SC</UF>
            $dest_CEP = $xml->NFe->infNFe->dest->enderDest->CEP;              //<CEP>88865000</CEP>
            $dest_cPais = $xml->NFe->infNFe->dest->enderDest->cPais;          //<cPais>1058</cPais>
	    $dest_xPais = $xml->NFe->infNFe->dest->enderDest->xPais;          //<xPais>BRASIL</xPais>
            //</enderDest>
	    $dest_IE = $xml->NFe->infNFe->dest->IE;                           //<IE>253323029</IE>
            //</dest>
            //Totais
        /*
          <total>
                <ICMSTot>
                  <vBC>0.00</vBC>
                  <vICMS>0.00</vICMS>
                  <vBCST>0.00</vBCST>
                  <vST>0.00</vST>
                  <vProd>555.00</vProd>
                  <vFrete>0.00</vFrete>
                  <vSeg>0.00</vSeg>
                  <vDesc>0.00</vDesc>
                  <vII>0.00</vII>
                  <vIPI>0.00</vIPI>
                  <vPIS>3.62</vPIS>
                  <vCOFINS>16.66</vCOFINS>
                  <vOutro>0.00</vOutro>
                  <vNF>555.00</vNF>
                </ICMSTot>
              </total>
        */

                $vBC = $xml->NFe->infNFe->total->ICMSTot->vBC;
                $vBC = number_format((double) $vBC, 2, ",", ".");
                $vICMS = $xml->NFe->infNFe->total->ICMSTot->vICMS;
                $vICMS = number_format((double) $vICMS, 2, ",", ".");
                $vBCST = $xml->NFe->infNFe->total->ICMSTot->vBCST;
                $vBCST = number_format((double) $vBCST, 2, ",", ".");
                $vST = $xml->NFe->infNFe->total->ICMSTot->vST;
                $vST = number_format((double) $vST, 2, ",", ".");
                $vProd = $xml->NFe->infNFe->total->ICMSTot->vProd;
                $vProd = number_format((double) $vProd, 2, ",", "."); 
                $vNF = $xml->NFe->infNFe->total->ICMSTot->vNF;
                $vNF = number_format((double) $vNF, 2, ",", ".");
                $vFrete = number_format((double) $xml->NFe->infNFe->total->ICMSTot->vFrete, 2, ",", ".");
                $vSeg = number_format((double)   $xml->NFe->infNFe->total->ICMSTot->vSeg, 2, ",", ".");
                $vDesc = number_format((double) $xml->NFe->infNFe->total->ICMSTot->vDesc, 2, ",", ".");
                $vIPI = number_format((double) $xml->NFe->infNFe->total->ICMSTot->	vIPI, 2, ",", ".");	
                
                
                //PASSA PELOS ITENS DA NOTA 
                $seq = 0;
	foreach($xml->NFe->infNFe->det as $item) {
		$seq++;
		$codigo = $item->prod->cProd;
		$xProd = $item->prod->xProd;
                $xPed = $item->prod->xPed;
                $nItemPed = $item->prod->nItemPed;
		$NCM = $item->prod->NCM;
		$CFOP = $item->prod->CFOP;
		$uCom = $item->prod->uCom;
		$qCom = $item->prod->qCom;
		$qCom =  (double) $qCom;                    //number_format((double) $qCom, 2, ",", ".");
		$vUnCom = $item->prod->vUnCom;
		$vUnCom =  (double) $vUnCom;                          //number_format((double) $vUnCom, 2, ",", ".");
		$vProd = $item->prod->vProd;
		$vProd = (double) $vProd;                                 //number_format((double) $vProd, 2, ",", ".");	
		$vBC_item = $item->imposto->ICMS->ICMS00->vBC;
		$icms00 = $item->imposto->ICMS->ICMS00;
		$icms10 = $item->imposto->ICMS->ICMS10;
		$icms20 = $item->imposto->ICMS->ICMS20;
		$icms30 = $item->imposto->ICMS->ICMS30;
		$icms40 = $item->imposto->ICMS->ICMS40;
		$icms50 = $item->imposto->ICMS->ICMS50;
		$icms51 = $item->imposto->ICMS->ICMS51;
		$icms60 = $item->imposto->ICMS->ICMS60;
		$ICMSSN102 = $item->imposto->ICMS->ICMSSN102; 
		if(!empty($ICMSSN102)) 
			{
				$bc_icms = "0.00";	
				$pICMS = "0	";
				$vlr_icms = "0.00";
			}		
		
		
		if (!empty($icms00))
		{
			$bc_icms = $item->imposto->ICMS->ICMS00->vBC;
			$bc_icms = number_format((double) $bc_icms, 2, ",", ".");
			$pICMS = $item->imposto->ICMS->ICMS00->pICMS;
			$pICMS = round($pICMS,0);
			$vlr_icms = $item->imposto->ICMS->ICMS00->vICMS;
			$vlr_icms = number_format((double) $vlr_icms, 2, ",", ".");
		}
		if (!empty($icms20))
		{
			$bc_icms = $item->imposto->ICMS->ICMS20->vBC;
			$bc_icms = number_format((double) $bc_icms, 2, ",", ".");
			$pICMS = $item->imposto->ICMS->ICMS20->pICMS;
			$pICMS = round($pICMS,0);
			$vlr_icms = $item->imposto->ICMS->ICMS20->vICMS;
			$vlr_icms = number_format((double) $vlr_icms, 2, ",", ".");
		}
			if(!empty($icms30)) 
			{
				$bc_icms = "0.00";	
				$pICMS = "0	";
				$vlr_icms = "0.00";
			}
			if(!empty($icms40)) 
			{
				$bc_icms = "0.00";	
				$pICMS = "0	";
				$vlr_icms = "0.00";
			}
			if(!empty($icms50)) 
			{
				$bc_icms = "0.00";	
				$pICMS = "0	";
				$vlr_icms = "0.00";
			}
			if(!empty($icms51)) 
			{
				$bc_icms = $item->imposto->ICMS->ICMS51->vBC;
				$pICMS = $item->imposto->ICMS->ICMS51->pICMS;
				$pICMS = round($pICMS,0);
				$vlr_icms = $item->imposto->ICMS->ICMS51->vICMS;
			}
		if(!empty($icms60)) 
		{
			$bc_icms = "0,00";	
			$pICMS = "0	";
			$vlr_icms = "0,00";
		}
		$IPITrib = $item->imposto->IPI->IPITrib;
		if (!empty($IPITrib))
		{
			$bc_ipi =$item->imposto->IPI->IPITrib->vBC;
			$bc_ipi = number_format((double) $bc_ipi, 2, ",", ".");
			$perc_ipi =  $item->imposto->IPI->IPITrib->pIPI;
			$perc_ipi = round($perc_ipi,0);
			$vlr_ipi = $item->imposto->IPI->IPITrib->vIPI;
			$vlr_ipi = number_format((double) $vlr_ipi, 2, ",", ".");
		}
		$IPINT = $item->imposto->IPI->IPINT;
		{
			$bc_ipi = "0,00";
			$perc_ipi =  "0";
			$vlr_ipi = "0,00";
		}	
                //traz campo infoAds
                $sInfoAd = $item->infAdProd;
                
                //carrega os dados no model
                $this->Model->setEmpcod((string)$emit_CNPJ);
                $this->Model->setEmpdes((string)$emit_xNome);
                $this->Model->setNfnro((string) $nNF);
                $this->Model->setNfser((string) $serie);
                $this->Model->setNfseq($seq);
                $this->Model->setProcod((string) $codigo);
                $this->Model->setProdes((string)$xProd );
                $this->Model->setUn((string)$uCom );
                $this->Model->setQtd((string)$qCom);
                $this->Model->setVlrUnit($vUnCom);
                $this->Model->setVlrTotal($vProd);
                $this->Model->setDataimp(Util::getDataAtualYMD());
                $this->Model->setHoraimp($date = date('H:i'));
                $this->Model->setOpSteel('0');
                $this->Model->setXPed((string)$xPed);
                $this->Model->setNItemPed((string)$nItemPed);
                $this->Model->setDataemidoc($dEmi);   //$dEmi
                $this->Model->setNfsnfechv($chave);
                //seta o ncm
                $iCarac = strlen($NCM);
                
                if($iCarac=8){
                    $NCM =$NCM .'000';
                }
                
                $this->Model->setNcm(Util::mask($NCM, Util::MASCARA_NCM));
                //busca informações da op no XML
                $sOpCliente = $this->buscaOP((string)$emit_CNPJ,(string)$xProd,(string)$sInfoAd,(string) $codigo);
                $this->Model->setOpCliente($sOpCliente);
                
                
                $aErro = $this->Persistencia->inserir();
                if($aErro[0]){
                    $oMensagem = new Mensagem('Sucesso!', 'Item importado.', Mensagem::TIPO_SUCESSO);
                   // echo $oMensagem->getRender();
                }else{
                    $oMensagem = new Mensagem('Atenção!', 'Item não foi importado.'.$this->Model->getProcod(), Mensagem::TIPO_ERROR);
                   // echo $oMensagem->getRender();
                }
        }
       }else{
           $oModal = new Modal('Atenção','Verifica o arquivo XML', Modal::TIPO_AVISO, false,true, FALSE);
          // echo $oModal->getRender();
       }
    }
    /**
     * Busca informações da ordem de produção
     */
    
    public function buscaOP($sCnpj,$sProd,$infAdicional,$codProd){
        $sOpCliente ='';
        if($sCnpj=='82638388000115'){   //blufix  82638388000115
          $sOpCliente =$infAdicional;
        }
        
        if($sCnpj=='3606226000129'){
           $sLote = strstr($sProd, 'lote');
           if($sLote == null || $sLote=''){
              $sLote = strstr($sProd, 'LOTE');   
           }
           $sOpCliente = $sLote; 
        }
        
        if($sCnpj=='76812379000104'){
            $sOpCliente = $codProd;
        }
        
        //xml ejot
        if($sCnpj =='16746136000185'){
           $sOpCliente =$infAdicional; 
        }
        //xml fey
        if($sCnpj =='84229624000175'){
           $sOpCliente =$infAdicional; 
        }
        
        return $sOpCliente;
        
    }
}

