<?php

class ToolsXML{
    public $errMsg;
    public $errStatus;
    public $priKEY;
    public $pubKEY;
    public $certKEY;
    public $keyPass;
    private $URLPortal;
    private $versao;
    private $chave;
    private $cnpj;
    private $cte;
    
    function __construct($cnpj){        
        $this->URLPortal = 'http://www.portalfiscal.inf.br/cte';
        if($_SESSION['empresa']==9){
            $this->keyPass="62566113904";
        }    
        else {    
            $this->keyPass="12345678";
        }        
        // Recuperação da versão
        $this->versao = "2.00"; 
        $this->cnpj = $cnpj;
        $this->loadCerts($cnpj);
    }
    public function getCte() {
        return $this->cte;
    }

    public function setCte($cte) {
        $this->cte = $cte;
        return $this;
    }

        
    public function getChave() {
        return $this->chave;
    }

    public function setChave($chave) {
        $this->chave = $chave;
        return $this;
    }
    

    private function loadCerts($cnpj){
            $sPath = str_replace("\\","/",dirname(__FILE__));
            $dir = $sPath.'/certificados/';
        
            // Monta o path completo com o nome da chave privada
            $this->priKEY = $dir . $cnpj . '_priKEY.pem';
            // Monta o path completo com o nome da chave publica
            $this->pubKEY = $dir . $cnpj . '_pubKEY.pem';
            // Monta o path completo com o nome do certificado (chave publica e privada) em formato pem
            $this->certKEY = $dir . $cnpj . '_certKEY.pem';
            // Verificar se o nome do certificado e
            // Monta o caminho completo até o certificado pfx
            $pCert = $dir . $cnpj . '.pfx';
            // Verifica se o arquivo existe
            if(!file_exists($pCert)) {
                    $this->errMsg = 'Certificado não encontrado!!';
                    $this->errStatus = true;
                    return false;
            }
            // Carrega o certificado em um string
            $key = file_get_contents($pCert);
            // Carrega os certificados e chaves para um array denominado $x509certdata
            if (!openssl_pkcs12_read($key, $x509certdata, $this->keyPass)) {
                    $this->errMsg = 'O certificado não pode ser lido!! Provavelmente corrompido ou com formato inválido!!';
                    $this->errStatus = true;
                    return false;
            }
            // Verifica sua validade
            $aResp = $this->validCerts($x509certdata['cert']);
            if ($aResp['error'] != '') {
                    $this->errMsg = 'Certificado invalido!! - ' . $aResp['error'];
                    $this->errStatus = true;
                    return false;
            }
            // Verifica se arquivo já existe
            if (file_exists($this->priKEY)) {
                    // Se existir verificar se é o mesmo
                    $conteudo = file_get_contents($this->priKEY);
                    // Comparar os primeiros 30 digitos
                    if (!substr($conteudo, 0, 30) == substr($x509certdata['pkey'], 0, 30)) {
                             // Se diferentes gravar o novo
                            if (!file_put_contents($this->priKEY,$x509certdata['pkey'])) {
                                    $this->errMsg = 'Impossivel gravar no diretório!!! Permissão negada!!';
                                    $this->errStatus = true;
                                    return false;
                            }
                    }
            } else {
                    // Salva a chave privada no formato pem para uso so SOAP
                    if (!file_put_contents($this->priKEY, $x509certdata['pkey'])) {
                                   $this->errMsg = 'Impossivel gravar no diretório!!! Permissão negada!!';
                                   $this->errStatus = true;
                                   return false;
                    }
            }
            // Verifica se arquivo com a chave publica já existe
            if (file_exists($this->pubKEY)) {
                    // Se existir verificar se é o mesmo atualmente instalado
                    $conteudo = file_get_contents($this->pubKEY);
                    // Comparar os primeiros 30 digitos
                    if (!substr($conteudo, 0, 30) == substr($x509certdata['cert'], 0, 30)) {
                            // Se diferentes gravar o novo
                            $n = file_put_contents($this->pubKEY, $x509certdata['cert']);
                            // Salva o certificado completo no formato pem
                            $n = file_put_contents($this->certKEY, $x509certdata['pkey'] . "\r\n" . $x509certdata['cert']);
                    }
            } else {
                    // Se não existir salva a chave publica no formato pem para uso do SOAP
                    $n = file_put_contents($this->pubKEY, $x509certdata['cert']);
                    // Salva o certificado completo no formato pem
                    $n = file_put_contents($this->certKEY, $x509certdata['pkey'] . "\r\n" . $x509certdata['cert']);
            }
            return true;
    } 
    private function validCerts($cert){
            $flagOK = true;
            $errorMsg = "";
            $data = openssl_x509_read($cert);
            $cert_data = openssl_x509_parse($data);
            // Reformata a data de validade;
            $ano = substr($cert_data['validTo'], 0, 2);
            $mes = substr($cert_data['validTo'], 2, 2);
            $dia = substr($cert_data['validTo'], 4, 2);
            // Obtem o timeestamp da data de validade do certificado
            $dValid = gmmktime(0,0,0,$mes,$dia,$ano);
            // Obtem o timestamp da data de hoje
            $dHoje = gmmktime(0, 0, 0, date("m"), date("d"), date("Y"));
            // Compara a data de validade com a data atual
            if ($dValid < $dHoje) {
                    $flagOK = false;
                    $errorMsg = "A Validade do certificado expirou em [" . $dia . '/' . $mes . '/' . $ano . "]";
            } else {
                    $flagOK = $flagOK && true;
            }
            // Diferença em segundos entre os timestamp
            $diferenca = $dValid - $dHoje;
            // Convertendo para dias
            $diferenca = round($diferenca / (60 * 60 * 24), 0);
            // Carregando a propriedade
            $daysToExpire = $diferenca;
            // Convertendo para meses e carregando a propriedade
            $m = ($ano * 12 + $mes);
            $n = (date("y") * 12 + date("m"));
            // Numero de meses até o certificado expirar
            $monthsToExpire = ($m - $n);
            $this->certMonthsToExpire = $monthsToExpire;
            $this->certDaysToExpire = $daysToExpire;
            return array(
                    'status' => $flagOK,
                    'error' => $errorMsg,
                    'meses' => $monthsToExpire,
                    'dias' => $daysToExpire);
    } //Fim validCerts
    
    public function signXML($docxml, $tagid=''){//docXml
        if ( $tagid == '' ){
                $this->errMsg = "Uma tag deve ser indicada para que seja assinada!!\n";
                $this->errStatus = true;
                return false;
        }
        if ( $docxml == '' ){
                $this->errMsg = "Um xml deve ser passado para que seja assinado!!\n";
                $this->errStatus = true;
                return false;
        }
        //echo 'alerta 01!!!';
        // obter o chave privada para a ssinatura
        $fp = fopen($this->priKEY, "r");
        $priv_key = fread($fp, 8192);
        fclose($fp);
        $pkeyid = openssl_get_privatekey($priv_key);
        //echo 'alerta 02!!!';
        // limpeza do xml com a retirada dos CR, LF e TAB
        $order = array("\r\n", "\n", "\r", "\t");
        $replace = '';
        $docxml = str_replace($order, $replace, $docxml);
        //echo 'alerta 03!!!';
        // carrega o documento no DOM
        $xmldoc = new DOMDocument();
        $xmldoc->preservWhiteSpace = false; //elimina espaços em branco
        $xmldoc->formatOutput = false;
        //echo 'alerta 04!!!';
        // muito importante deixar ativadas as opçoes para limpar os espacos em branco
        // e as tags vazias
        if ($xmldoc->loadXML($docxml,LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG)){
                $root = $xmldoc->documentElement;
        } else {
                $this->errMsg = "Erro ao carregar o XML, provavel erro na passagem do parametro do arquivo!\n";
                $this->errStatus = true;
                return false;
        }
        //echo 'alerta 05!!!';	
        //extrair a tag com os dados a serem assinados
        $node = $xmldoc->getElementsByTagName($tagid)->item(0);
        $id = trim($node->getAttribute("Id"));
        $idnome = preg_replace('/[^0-9]/','', $id);
        //echo 'alerta 06!!!';
        //extrai os dados da tag para uma string
        $dados = $node->C14N(false,false,NULL,NULL);
        //calcular o hash dos dados
        $hashValue = hash('sha1',$dados,true);
        //converte o valor para base64 para serem colocados no xml
        $digValue = base64_encode($hashValue);
        //monta a tag da assinatura digital
        $Signature = $xmldoc->createElementNS('http://www.w3.org/2000/09/xmldsig#','Signature');
        $root->appendChild($Signature);
        $SignedInfo = $xmldoc->createElement('SignedInfo');
        $Signature->appendChild($SignedInfo);
        //echo 'alerta 07!!!';
        //Cannocalization
        $newNode = $xmldoc->createElement('CanonicalizationMethod');
        $SignedInfo->appendChild($newNode);
        
        $newNode->setAttribute('Algorithm','http://www.w3.org/TR/2001/REC-xml-c14n-20010315');
        //SignatureMethod
        $newNode = $xmldoc->createElement('SignatureMethod');
        $SignedInfo->appendChild($newNode);
        $newNode->setAttribute('Algorithm','http://www.w3.org/2000/09/xmldsig#rsa-sha1');
        //Reference
        $Reference = $xmldoc->createElement('Reference');
        $SignedInfo->appendChild($Reference);
        $Reference->setAttribute('URI', '#'.$id);
        //Transforms
        $Transforms = $xmldoc->createElement('Transforms');
        $Reference->appendChild($Transforms);
        //Transform
        $newNode = $xmldoc->createElement('Transform');
        $Transforms->appendChild($newNode);
        $newNode->setAttribute('Algorithm','http://www.w3.org/2000/09/xmldsig#enveloped-signature');
        //echo 'alerta 08!!!';
        //Transform
        $newNode = $xmldoc->createElement('Transform');
        $Transforms->appendChild($newNode);
        $newNode->setAttribute('Algorithm','http://www.w3.org/TR/2001/REC-xml-c14n-20010315');
        //DigestMethod
        $newNode = $xmldoc->createElement('DigestMethod');
        $Reference->appendChild($newNode);
        $newNode->setAttribute('Algorithm','http://www.w3.org/2000/09/xmldsig#sha1');
        //DigestValue
        $newNode = $xmldoc->createElement('DigestValue',$digValue);
        $Reference->appendChild($newNode);
        // extrai os dados a serem assinados para uma string
        $dados = $SignedInfo->C14N(false,false,NULL,NULL);
        //inicializa a variavel que irá receber a assinatura
        $signature = '';
        //echo 'alerta 09 signature!!!';
        //executa a assinatura digital usando o resource da chave privada
        $resp = openssl_sign($dados,$signature,$pkeyid);
        //codifica assinatura para o padrao base64
        $signatureValue = base64_encode($signature);
        //SignatureValue
        $newNode = $xmldoc->createElement('SignatureValue',$signatureValue);
        $Signature->appendChild($newNode);
        //KeyInfo
        $KeyInfo = $xmldoc->createElement('KeyInfo');
        $Signature->appendChild($KeyInfo);
        //X509Data
        $X509Data = $xmldoc->createElement('X509Data');
        $KeyInfo->appendChild($X509Data);
        //echo 'alerta 010!!!';
        //carrega o certificado sem as tags de inicio e fim
        $cert = $this->cleanCerts($this->pubKEY);
        //X509Certificate
        $newNode = $xmldoc->createElement('X509Certificate',$cert);
        $X509Data->appendChild($newNode);
        //grava na string o objeto DOM
        //$xmldoc->preserveWhiteSpace = false;
        $docxml = $xmldoc->saveXML();
        
        // libera a memoria
        openssl_free_key($pkeyid);
        //echo 'alerta 011!!!';
        //retorna o documento assinado
        //echo $docxml;
        return $docxml;

    } //fim signXML
    
    private function cleanCerts($certFile){
            // Carregar a chave publica do arquivo pem
            $pubKey = file_get_contents($certFile);
            // Inicializa variavel
            $data = '';
            // Carrega o certificado em um array usando o LF como referencia
            $arCert = explode("\n", $pubKey);
            foreach ($arCert as $curData) {
                    // Remove a tag de inicio e fim do certificado
                    if (strncmp($curData, '-----BEGIN CERTIFICATE', 22) != 0 && strncmp($curData, '-----END CERTIFICATE', 20) != 0 ) {
                            // Carrega o resultado numa string
                            $data .= trim($curData);
                    }
            }
            return $data;
    }
    public function validXML($docXml){
            $sPath = str_replace("\\","/",dirname(__FILE__));
            $xsdFile = $sPath.'/validacao/cte_v1.04.xsd';
            
            // Habilita a manipulaçao de erros da libxml
            libxml_use_internal_errors(true);
            // instancia novo objeto DOM
            $xmldoc = new DOMDocument();
            // carrega o xml
            $sPath = str_replace("\\","/",dirname(__FILE__));
            
            $xml = $xmldoc->loadXML($sPath.'/../'.$docXml);
            //$ctefile = file_get_contents($sPath.'/../'.$docXml);

            $errorMsg='';
            // valida o xml com o xsd
            if ( !$xmldoc->schemaValidate($xsdFile) ) {
                    /**
                     * Se não foi possível validar, você pode capturar
                     * todos os erros em um array
                     * Cada elemento do array $arrayErrors
                     * será um objeto do tipo LibXmlError
                     */
                    // carrega os erros em um array
                    $aIntErrors = libxml_get_errors();
                    //libxml_clear_errors();
                    $flagOK = false;
                    foreach ($aIntErrors as $intError){
                            switch ($intError->level) {
                                    case LIBXML_ERR_WARNING:
                                            $errorMsg .= " Atençao $intError->code: ";
                                            break;
                                    case LIBXML_ERR_ERROR:
                                            $errorMsg .= " Erro $intError->code: ";
                                            break;
                                    case LIBXML_ERR_FATAL:
                                            $errorMsg .= " Erro Fatal $intError->code: ";
                                            break;
                            }
                            $errorMsg .= $intError->message . ';';
                    }
            } else {
                    $flagOK = true;
                    $errorMsg = '';
            }
            $this->errStatus = $flagOK;
            $this->errMsg = $errorMsg;
            
            return $flagOK;
    } //fim validXML
    
    /**
     * Método antigo, descontinuado
     */
   /* public function cancelarCte($id, $protId, $xJust,$tipoAmbiente,$uf) {
        // Variável de retorno
        $aRetorno = array('bStat' => false,'cStat' => '','xMotivo' => '','dhRecbto' => '','nProt' => '');
        
        $servico = 'CteCancelamento';
        $metodo = 'CTeCancelamento';
        $namespace = $this->URLPortal . '/wsdl/' . $servico;
        $urlsefaz = $this->retornaUrlSefaz($metodo,$uf,$tipoAmbiente);
		
        $cabec = '<cteCabecMsg xmlns="' . $namespace . '"><cUF>' . $uf . '</cUF><versaoDados>' . $this->versao  . '</versaoDados></cteCabecMsg>';
        // Montagem dos dados da mensagem SOAP
        $dXML = '<cancCTe xmlns="' . $this->URLPortal . '" versao="' . $this->versao  . '">';
        $dXML .= '<infCanc Id="ID' . $id . '"><tpAmb>' . $tipoAmbiente . '</tpAmb><xServ>CANCELAR</xServ><chCTe>' . $id . '</chCTe><nProt>' . $protId . '</nProt><xJust>' . $xJust . '</xJust></infCanc></cancCTe>';
        // Assinar a mensagem
        $dXML = $this->signXML($dXML, 'infCanc');
        $dados = '<cteDadosMsg xmlns="' . $namespace . '">' . $dXML . '</cteDadosMsg>';
        // Remove as tags xml que porventura tenham sido inclusas ou quebras de linhas
        $dados = str_replace('<?xml version="1.0"?>','', $dados);
        $dados = str_replace('<?xml version="1.0" encoding="utf-8"?>','', $dados);
        $dados = str_replace('<?xml version="1.0" encoding="UTF-8"?>','', $dados);
        $dados = str_replace(array("\r","\n","\s"),"", $dados);
        // Envia a solicitação via SOAP
        $retorno = $this->sendSOAP2($namespace, $cabec, $dados, $metodo, $tipoAmbiente,$uf);
        // Verifica o retorno
        if ($retorno) {
            // Tratar dados de retorno
            $doc = new DOMDocument();
            $doc->formatOutput = false;
            $doc->preserveWhiteSpace = false;
            $doc->loadXML($retorno, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
			
            // Status do serviço se 101 cancelamento aceito
            $aRetorno['bStat'] = $aRetorno['cStat'] == 101;
            $aRetorno['cStat'] = $doc->getElementsByTagName('cStat')->item(0)->nodeValue;
            $aRetorno['xMotivo'] = iconv("utf-8","iso8859-1",$doc->getElementsByTagName('xMotivo')->item(0)->nodeValue);
            $aRetorno['dhRecbto'] = date("d/m/Y H:i", $this->convertTime($doc->getElementsByTagName('dhRecbto')->item(0)->nodeValue));
            $aRetorno['nProt'] = $doc->getElementsByTagName('nProt')->item(0)->nodeValue;
            $aRetorno['cUF'] = $doc->getElementsByTagName('cUF')->item(0)->nodeValue;
	    // Gravar o retorno na pasta temp
            $nome = Config::ARQ_FOLDER_TEMP.'/cte'.$this->getChave().'-protcanc.xml';          
            
            $nome = $doc->save($nome);
        } else {
            $aRetorno['xMotivo'] = 'Não houve retorno Soap.';
            $aRetorno['bStat'] = false;
        }
        return $aRetorno;
    }*/ // Fim cancelCT
    
    public function cancelarPorEvento($chCte,$nProt,$xJust,$tpAmb,$uf){

        $aRetorno = array('bStat' => false,'cStat' => '','xMotivo' => '','dhRecbto' => '','nProt' => '');
        
        try{
            if (strlen($xJust) < 15){
                $aRetorno['xMotivo'] = "A justificativa deve ter pelo menos 15 digitos!!";
                $aRetorno['bStat'] = false;
                return $aRetorno;
                
            }
            if (strlen($xJust) > 255){
                $aRetorno['xMotivo'] = "A justificativa deve ter no máximo 255 digitos!!";
                $aRetorno['bStat'] = false;
                return $aRetorno;
            }
            if (strlen($chCte) != 44){
                $aRetorno['xMotivo'] = "Uma chave de CTe válida não foi passada como parâmetro $chCTe.";
                $aRetorno['bStat'] = false;
                return $aRetorno;
            }
            //estabelece o codigo do tipo de evento CANCELAMENTO
            $tpEvento = '110111';
            $descEvento = 'Cancelamento';
            //para cancelamento o numero sequencia do evento sempre será 1
            $nSeqEvento = '1';
            //remove qualquer caracter especial
            $xJust = $this->cleanString($xJust);
            //decompor a chCte e pegar o tipo de emissão
            //$tpEmiss = substr($chCte, 34, 1);
            $numLote = substr(str_replace(',','',number_format(microtime(true)*1000000,0)),0,15);
            //Data e hora do evento no formato AAAA-MM-DDTHH:MM:SSTZD (UTC)
            $dhEvento = date('Y-m-d').'T'.date('H:i:s').$this->timeZone;
            //se o envio for para svan mudar o numero no orgão para 91
            /*if ($this->enableSVAN){
                $cOrgao='90';
            } else {*/
                $cOrgao=$uf;
            //}
            //montagem do namespace do serviço
            $servico = 'CteRecepcaoEvento';
            $metodo = 'cteRecepcaoEvento';
            //montagem do namespace do serviço
            $namespace = $this->URLPortal.'/wsdl/'.$servico;
            
            //de acordo com o manual versão 5 de março de 2012
            // 2   +    6     +    44         +   2  = 54 digitos
            //?ID? + tpEvento + chave da NF-e + nSeqEvento
            //garantir que existam 2 digitos em nSeqEvento para montar o ID com 54 digitos
            if (strlen(trim($nSeqEvento))==1){
                $zenSeqEvento = str_pad($nSeqEvento, 2, "0", STR_PAD_LEFT);
            } else {
                $zenSeqEvento = trim($nSeqEvento);
            }
            $id = "ID".$tpEvento.$chCte.$zenSeqEvento;
            //monta mensagem
            $Ev='';
            $Ev .= "<eventoCTe xmlns=\"$this->URLPortal\" versao=\"$this->versao\">";
            $Ev .= "<infEvento Id=\"$id\">";
            $Ev .= "<cOrgao>$cOrgao</cOrgao>";
            $Ev .= "<tpAmb>$tpAmb</tpAmb>";
            $Ev .= "<CNPJ>$this->cnpj</CNPJ>";
            $Ev .= "<chCTe>$chCte</chCTe>";
            $Ev .= "<dhEvento>$dhEvento</dhEvento>";
            $Ev .= "<tpEvento>$tpEvento</tpEvento>";
            $Ev .= "<nSeqEvento>$nSeqEvento</nSeqEvento>";
            $Ev .= "<detEvento versaoEvento=\"$this->versao\">";
            $Ev .= "<evCancCTe><descEvento>$descEvento</descEvento>";
            $Ev .= "<nProt>$nProt</nProt>";
            $Ev .= "<xJust>$xJust</xJust>";
            $Ev .= "</evCancCTe></detEvento></infEvento></eventoCTe>";
            //assinatura dos dados
            $tagid = 'infEvento';
            $Ev = $this->signXML($Ev, $tagid);
            $Ev = str_replace('<?xml version="1.0"?>','', $Ev);
            $Ev = str_replace('<?xml version="1.0" encoding="utf-8"?>','', $Ev);
            $Ev = str_replace('<?xml version="1.0" encoding="UTF-8"?>','', $Ev);
            $Ev = str_replace(array("\r","\n","\s"),"", $Ev);
            //carrega uma matriz temporária com os eventos assinados
            //montagem dos dados
            /*$dados = '';
            $dados .= "<envEvento xmlns=\"$this->URLPortal\" versao=\"$this->versao\">";
            $dados .= "<idLote>$numLote</idLote>";
            $dados .= $Ev;
            $dados .= "</envEvento>";
             * 
             */
            $dados = $Ev;            
            //montagem da mensagem
            $cabec = "<cteCabecMsg xmlns=\"$namespace\"><cUF>$uf</cUF><versaoDados>$this->versao</versaoDados></cteCabecMsg>";
            $dados = "<cteDadosMsg xmlns=\"$namespace\">$dados</cteDadosMsg>";
            //grava solicitação em temp
            /*$arqName = Config::ARQ_FOLDER_TEMP.'/cte'.$this->getChave().'-eventCanc.xml';          
            if (!file_put_contents($arqName,$Ev)){
                $aRetorno['xMotivo'] = "Falha na gravação do arquivo $arqName";
                $aRetorno['bStat'] = false;
                return $aRetorno;
            }*/
            $retorno = $this->sendSOAP2($namespace, $cabec, $dados, $metodo, $tpAmb,$uf);
            //verifica o retorno
            if (!$retorno){
                //não houve retorno
                $aRetorno['xMotivo'] = "Nao houve retorno Soap.";
                $aRetorno['bStat'] = false;
                return $aRetorno;
            }
            //tratar dados de retorno
            $xmlretEvent = new DOMDocument('1.0', 'utf-8'); //cria objeto DOM
            $xmlretEvent->formatOutput = false;
            $xmlretEvent->preserveWhiteSpace = false;
            $xmlretEvent->loadXML($retorno,LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            $retEnvEvento = $xmlretEvent->getElementsByTagName("retEventoCTe")->item(0);
            $cStat = !empty($retEnvEvento->getElementsByTagName('cStat')->item(0)->nodeValue) ? $retEnvEvento->getElementsByTagName('cStat')->item(0)->nodeValue : '';
            $xMotivo = !empty($retEnvEvento->getElementsByTagName('xMotivo')->item(0)->nodeValue) ? $retEnvEvento->getElementsByTagName('xMotivo')->item(0)->nodeValue : '';
            if ($cStat == ''){
                $aRetorno['xMotivo'] = "cStat está em branco, houve erro na comunicação Soap.";
                $aRetorno['bStat'] = false;
                return $aRetorno;
            }
            //tratar erro de versão do XML
            if ($cStat == '238' || $cStat == '239'){
                $aRetorno['xMotivo'] = "Versão do arquivo XML não suportada no webservice!!";
                $aRetorno['bStat'] = false;
                return $aRetorno;
            }
            if ($cStat != 135){
                //se cStat <> 135 houve erro e o lote foi rejeitado
                $xMotivo  = utf8_decode($xMotivo);
                $aRetorno['xMotivo'] = "Retorno de ERRO: $cStat - $xMotivo";
                $aRetorno['bStat'] = false;
                return $aRetorno;
            }
            else { 
                $aRetorno['xMotivo'] = "Cancelado com sucesso.";
                $aRetorno['bStat'] = true;
            }

            $doc = new DOMDocument();
            $doc->formatOutput = false;
            $doc->preserveWhiteSpace = false;
            $doc->loadXML($retorno, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            
            //salva o arquivo xml
            $arquivo = Config::ARQ_FOLDER_TEMP.'/cte'.$this->getChave().'-protcanc.xml';          
            $nome = $doc->save($arquivo);
            $this->gravaArquivoBanco($this->getCte(), $arquivo, 6);
            
            if ($cStat == 135){
                $oControllerCteXML = Fabrica::FabricarController('CteXml');
                $oControllerCteXML->Model->setCte($this->Model);
                $oControllerCteXML->Model->setSituacao(PersistenciaCteXml::SITUACAO_HOMOLOGADO);
                $oControllerCteXML->Model = $oControllerCteXML->Persistencia->consultar();

                $oControllerArquivo = Fabrica::FabricarController('Arquivo');
                $novonome = $oControllerArquivo->getBDtoFile($oControllerCteXML->Model->getArquivo());

                $retorno = $this->addProtCanc($novonome,$arquivo);
                $arqProtocolado = Config::ARQ_FOLDER_TEMP.'/cte'.$this->getChave().'-cancelado.xml';
                if (!file_put_contents($arqProtocolado, $retorno) ) {
                    unlink($arqProtocolado);
                }
                $this->gravaArquivoBanco($this->getCte(), $arqProtocolado, 7);
                unlink($arqProtocolado);    
                unlink($novonome);
            }
            unlink($arquivo);
            
        } catch (nfephpException $e) {
            $aRetorno['xMotivo'] = 'Não houve retorno Soap.';
            $aRetorno['bStat'] = false;
        }
        return $aRetorno;
    } //fim cancEvent
    
    public function cartaCorrecao($chCte,$grupo,$campo,$valor,$tpAmb,$uf){
        $aRetorno = array('bStat' => false,'cStat' => '','xMotivo' => '','dhRecbto' => '','nProt' => '');
        
        try{
            //estabelece o codigo do tipo de evento CANCELAMENTO
            $tpEvento = '110110';
            $descEvento = 'Carta de Correcao';
            //para cancelamento o numero sequencia do evento sempre será 1
            $nSeqEvento = '1';
            //remove qualquer caracter especial
            //$xJust = $this->cleanString($xJust);
            //decompor a chCte e pegar o tipo de emissão
            //$tpEmiss = substr($chCte, 34, 1);
            $numLote = substr(str_replace(',','',number_format(microtime(true)*1000000,0)),0,15);
            //Data e hora do evento no formato AAAA-MM-DDTHH:MM:SSTZD (UTC)
            $dhEvento = date('Y-m-d').'T'.date('H:i:s').$this->timeZone;
            //se o envio for para svan mudar o numero no orgão para 91
            /*if ($this->enableSVAN){
                $cOrgao='90';
            } else {*/
                $cOrgao=$uf;
            //}
            //montagem do namespace do serviço
            $servico = 'CteRecepcaoEvento';
            $metodo = 'cteRecepcaoEvento';
            //montagem do namespace do serviço
            $namespace = $this->URLPortal.'/wsdl/'.$servico;
            
            //de acordo com o manual versão 5 de março de 2012
            // 2   +    6     +    44         +   2  = 54 digitos
            //?ID? + tpEvento + chave da NF-e + nSeqEvento
            //garantir que existam 2 digitos em nSeqEvento para montar o ID com 54 digitos
            if (strlen(trim($nSeqEvento))==1){
                $zenSeqEvento = str_pad($nSeqEvento, 2, "0", STR_PAD_LEFT);
            } else {
                $zenSeqEvento = trim($nSeqEvento);
            }
            $id = "ID".$tpEvento.$chCte.$zenSeqEvento;
            //monta mensagem
            $Ev='';
            $Ev .= "<eventoCTe xmlns=\"$this->URLPortal\" versao=\"$this->versao\">";
            $Ev .= "<infEvento Id=\"$id\">";
            $Ev .= "<cOrgao>$cOrgao</cOrgao>";
            $Ev .= "<tpAmb>$tpAmb</tpAmb>";
            $Ev .= "<CNPJ>$this->cnpj</CNPJ>";
            $Ev .= "<chCTe>$chCte</chCTe>";
            $Ev .= "<dhEvento>$dhEvento</dhEvento>";
            $Ev .= "<tpEvento>$tpEvento</tpEvento>";
            $Ev .= "<nSeqEvento>$nSeqEvento</nSeqEvento>";
            $Ev .= "<detEvento versaoEvento=\"$this->versao\">";
            $Ev .= "<evCCeCTe><descEvento>$descEvento</descEvento>";
            /*$Ev .= "<infCorrecao>";
            $Ev .= "<grupoAlterado>$grupo</grupoAlterado>";
            $Ev .= "<campoAlterado>$campo</campoAlterado>";
            $Ev .= "<valorAlterado>$valor</valorAlterado>";
            $Ev .= "<nroItemAlterado>1</nroItemAlterado>";
            $Ev .= "</infCorrecao>";*/
            $Ev .= "<infCorrecao>";
            $Ev .= "<grupoAlterado>veic</grupoAlterado>";
            $Ev .= "<campoAlterado>placa</campoAlterado>";
            $Ev .= "<valorAlterado>MJJ1477</valorAlterado>";
            $Ev .= "<nroItemAlterado>1</nroItemAlterado>";
            $Ev .= "</infCorrecao>";
            $Ev .= "<infCorrecao>";
            $Ev .= "<grupoAlterado>veic</grupoAlterado>";
            $Ev .= "<campoAlterado>RENAVAM</campoAlterado>";
            $Ev .= "<valorAlterado>489429394</valorAlterado>";
            $Ev .= "<nroItemAlterado>1</nroItemAlterado>";
            $Ev .= "</infCorrecao>";            
            $Ev .= "<infCorrecao>";
            $Ev .= "<grupoAlterado>veic</grupoAlterado>";
            $Ev .= "<campoAlterado>placa</campoAlterado>";
            $Ev .= "<valorAlterado>MHU3198</valorAlterado>";
            $Ev .= "<nroItemAlterado>2</nroItemAlterado>";
            $Ev .= "</infCorrecao>";
            $Ev .= "<infCorrecao>";
            $Ev .= "<grupoAlterado>veic</grupoAlterado>";
            $Ev .= "<campoAlterado>RENAVAM</campoAlterado>";
            $Ev .= "<valorAlterado>255461550</valorAlterado>";
            $Ev .= "<nroItemAlterado>2</nroItemAlterado>";
            $Ev .= "</infCorrecao>";          
            $Ev .= "<xCondUso>A Carta de Correcao e disciplinada pelo Art. 58-B do CONVENIO/SINIEF 06/89: Fica permitida a utilizacao de carta de correcao, para regularizacao de erro ocorrido na emissao de documentos fiscais relativos a prestacao de servico de transporte, desde que o erro nao esteja relacionado com: I - as variaveis que determinam o valor do imposto tais como: base de calculo, aliquota, diferenca de preco, quantidade, valor da prestacao;II - a correcao de dados cadastrais que implique mudanca do emitente, tomador, remetente ou do destinatario;III - a data de emissao ou de saida.</xCondUso>";
            $Ev .= "</evCCeCTe></detEvento></infEvento></eventoCTe>";
            //assinatura dos dados
            $tagid = 'infEvento';
            $Ev = $this->signXML($Ev, $tagid);
            $Ev = str_replace('<?xml version="1.0"?>','', $Ev);
            $Ev = str_replace('<?xml version="1.0" encoding="utf-8"?>','', $Ev);
            $Ev = str_replace('<?xml version="1.0" encoding="UTF-8"?>','', $Ev);
            $Ev = str_replace(array("\r","\n","\s"),"", $Ev);
            //carrega uma matriz temporária com os eventos assinados
            //montagem dos dados
            /*$dados = '';
            $dados .= "<envEvento xmlns=\"$this->URLPortal\" versao=\"$this->versao\">";
            $dados .= "<idLote>$numLote</idLote>";
            $dados .= $Ev;
            $dados .= "</envEvento>";
             * 
             */
            $dados = $Ev;            
            //montagem da mensagem
            $cabec = "<cteCabecMsg xmlns=\"$namespace\"><cUF>$uf</cUF><versaoDados>$this->versao</versaoDados></cteCabecMsg>";
            $dados = "<cteDadosMsg xmlns=\"$namespace\">$dados</cteDadosMsg>";
            //grava solicitação em temp
            $arqName = Config::ARQ_FOLDER_TEMP.'/cte'.$this->getChave().'-eventCarCorrecao.xml';          
            if (!file_put_contents($arqName,$Ev)){
                $aRetorno['xMotivo'] = "Falha na gravação do arquivo $arqName";
                $aRetorno['bStat'] = false;
                return $aRetorno;
            }
            /*
            libxml_use_internal_errors(true);
            $objDom = new DomDocument();

            $objDom->load($arqName);
            if (!$objDom->schemaValidate(Config::ARQ_FOLDER_TEMP.'/evCancCTe_v2.00.xsd')) {
                $arrayAllErrors = libxml_get_errors();
            }
            */
            $retorno = $this->sendSOAP2($namespace, $cabec, $dados, $metodo, $tpAmb,$uf);
            //verifica o retorno
            if (!$retorno){
                //não houve retorno
                $aRetorno['xMotivo'] = "Nao houve retorno Soap.";
                $aRetorno['bStat'] = false;
                return $aRetorno;
            }
            //tratar dados de retorno
            $xmlretEvent = new DOMDocument('1.0', 'utf-8'); //cria objeto DOM
            $xmlretEvent->formatOutput = false;
            $xmlretEvent->preserveWhiteSpace = false;
            $xmlretEvent->loadXML($retorno,LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            $retEnvEvento = $xmlretEvent->getElementsByTagName("retEventoCTe")->item(0);
            $cStat = !empty($retEnvEvento->getElementsByTagName('cStat')->item(0)->nodeValue) ? $retEnvEvento->getElementsByTagName('cStat')->item(0)->nodeValue : '';
            $xMotivo = !empty($retEnvEvento->getElementsByTagName('xMotivo')->item(0)->nodeValue) ? $retEnvEvento->getElementsByTagName('xMotivo')->item(0)->nodeValue : '';
            if ($cStat == ''){
                $aRetorno['xMotivo'] = "cStat está em branco, houve erro na comunicação Soap.";
                $aRetorno['bStat'] = false;
                return $aRetorno;
            }
            //tratar erro de versão do XML
            if ($cStat == '238' || $cStat == '239'){
                $aRetorno['xMotivo'] = "Versão do arquivo XML não suportada no webservice!!";
                $aRetorno['bStat'] = false;
                return $aRetorno;
            }
            if ($cStat != 135){
                //se cStat <> 135 houve erro e o lote foi rejeitado
                $xMotivo  = utf8_decode($xMotivo);
                $aRetorno['xMotivo'] = "Retorno de ERRO: $cStat - $xMotivo";
                $aRetorno['bStat'] = false;
                return $aRetorno;
            }
            else { 
                $aRetorno['xMotivo'] = "Cancelado com sucesso.";
                $aRetorno['bStat'] = true;
            }

            $doc = new DOMDocument();
            $doc->formatOutput = false;
            $doc->preserveWhiteSpace = false;
            $doc->loadXML($retorno, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            
            //salva o arquivo xml
            $nome = Config::ARQ_FOLDER_TEMP.'/cte'.$this->getChave().'-protcanc.xml';          
            
            $nome = $doc->save($nome);
            
        } catch (nfephpException $e) {
            $aRetorno['xMotivo'] = 'Não houve retorno Soap.';
            $aRetorno['bStat'] = false;
        }
        return $aRetorno;
    } //fim cancEvent
    
    public function inutilizarCte($id,$ano,$modelo,$serie,$numero,$xJust,$tipoAmbiente,$uf) {
        // Variável de retorno
        $aRetorno = array('bStat' => false,'cStat' => '','xMotivo' => '','dhRecbto' => '','nProt' => '');

        $servico = 'CteInutilizacao';
        $metodo = 'CTeInutilizacao';
        $namespace = $this->URLPortal . '/wsdl/' . $servico;
        $urlsefaz = $this->retornaUrlSefaz($metodo,$uf,$tipoAmbiente);
	
        $id = 'ID' . $uf . $this->cnpj . $modelo . str_pad($serie, 3, '0', STR_PAD_LEFT) . str_pad($numero, 9, '0', STR_PAD_LEFT) . str_pad($numero, 9, '0', STR_PAD_LEFT);
	// Montagem do cabeçalho da comunicação SOAP
        
        $cabec = '<cteCabecMsg xmlns="' . $namespace . '"><cUF>' . $uf . '</cUF><versaoDados>' . $this->versao . '</versaoDados></cteCabecMsg>';
	// Montagem do corpo da mensagem
        $dXML = '<inutCTe xmlns="' . $this->URLPortal . '" versao="' . $this->versao . '">';
        $dXML .= '<infInut Id="' . $id . '">';
        $dXML .= '<tpAmb>' . $tipoAmbiente . '</tpAmb>';
        $dXML .= '<xServ>INUTILIZAR</xServ>';
        $dXML .= '<cUF>' . $uf . '</cUF>';
        $dXML .= '<ano>' . $ano . '</ano>';
        $dXML .= '<CNPJ>' . $this->cnpj . '</CNPJ>';
        $dXML .= '<mod>57</mod>';
        $dXML .= '<serie>' . $serie . '</serie>';
        $dXML .= '<nCTIni>' . $numero . '</nCTIni>';
        $dXML .= '<nCTFin>' . $numero . '</nCTFin>';
        $dXML .= '<xJust>' . $xJust . '</xJust>';
        $dXML .= '</infInut>';
        $dXML .= '</inutCTe>';
        // Assina a lsolicitação de inutilização
        $dXML = $this->signXML($dXML, 'infInut');
          
        $dados = '<cteDadosMsg xmlns="' . $namespace . '">' . $dXML . '</cteDadosMsg>';
        // Remove as tags xml que porventura tenham sido inclusas ou quebras de linhas
        $dados = str_replace('<?xml version="1.0"?>','', $dados);
        $dados = str_replace('<?xml version="1.0" encoding="utf-8"?>','', $dados);
        $dados = str_replace('<?xml version="1.0" encoding="UTF-8"?>','', $dados);
        $dados = str_replace(array("\r","\n","\s"),"", $dados);
        // Envia a solicitação via SOAP
        $retorno = $this->sendSOAP2($namespace, $cabec, $dados, $metodo, $tipoAmbiente,$uf);
        // Verifica o retorno
        if ($retorno) {
            // Tratar dados de retorno
            $doc = new DOMDocument();
            $doc->formatOutput = false;
            $doc->preserveWhiteSpace = false;
            $doc->loadXML($retorno, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
			
            // Status do serviço se 101 cancelamento aceito
            $aRetorno['bStat'] = $aRetorno['cStat'] == 102;
            $aRetorno['cStat'] = $doc->getElementsByTagName('cStat')->item(0)->nodeValue;
            $aRetorno['xMotivo'] = iconv("utf-8","iso8859-1",$doc->getElementsByTagName('xMotivo')->item(0)->nodeValue);
            $aRetorno['dhRecbto'] = date("d/m/Y H:i", $this->convertTime($doc->getElementsByTagName('dhRecbto')->item(0)->nodeValue));
            $aRetorno['nProt'] = $doc->getElementsByTagName('nProt')->item(0)->nodeValue;
            $aRetorno['cUF'] = $doc->getElementsByTagName('cUF')->item(0)->nodeValue;
	    // Gravar o retorno na pasta temp
            $arquivo = Config::ARQ_FOLDER_TEMP.'/cte'.$this->getChave().'-protinut.xml';          
            
            $nome = $doc->save($arquivo);
            $this->gravaArquivoBanco($this->getCte(), $arquivo, 8);
            unlink($arquivo);
            
        } else {
            $aRetorno['xMotivo'] = 'Não houve retorno Soap.';
            $aRetorno['bStat'] = false;
        }
        return $aRetorno;
    } 

    public function sendCte($aCTe, $lote,$tipoAmbiente, $uf) {
        // Variavel de retorno do metodo
        $aRetorno = array('bStat'=>false,'cStat'=>'','xMotivo'=>'','dhRecbto'=>'','nRec'=>'');
        // Verifica se o SCAN esta habilitado
        /*if (!$this->enableSCAN){
            $aURL = $this->aURL;
        } else {
            $aURL = $this->loadSEFAZ( $this->raizDir . 'config' . DIRECTORY_SEPARATOR . $this->cteURLfile,$this->tpAmb,'SCAN');
        }*/
        // Identificação do serviço
        $servico = 'CteRecepcao';
        // Recuperação do método
        $metodo = 'cteRecepcaoLote';
        // Montagem do namespace do serviço
        $namespace = $this->URLPortal . '/wsdl/' . $servico;
        // Limpa a variavel
        $sCTe = '';

        $sCTe = implode('', $aCTe);
        $sCTe = str_replace(array('<?xml version="1.0" encoding="utf-8"?>', '<?xml version="1.0" encoding="UTF-8"?>'), '', $sCTe);
        $sCTe = str_replace(array("\r", "\n", "\s"), "", $sCTe);
        $cabec = '<cteCabecMsg xmlns="' . $namespace . '"><cUF>' . $uf . '</cUF><versaoDados>' . $this->versao . '</versaoDados></cteCabecMsg>';
        $dados = '<cteDadosMsg xmlns="' . $namespace . '"><enviCTe xmlns="' . $this->URLPortal . '" versao="' . $this->versao . '"><idLote>' . $lote . '</idLote>'. $sCTe . '</enviCTe></cteDadosMsg>';
        $retorno = $this->sendSOAP2($namespace, $cabec, $dados, $metodo, $tipoAmbiente, $uf);
        // Verifica o retorno         
        if ($retorno) {
          // Tratar dados de retorno
          $doc = new DOMDocument();
          $doc->formatOutput = false;
          $doc->preserveWhiteSpace = false;
          $doc->loadXML($retorno, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
          $cStat = !empty($doc->getElementsByTagName('cStat')->item(0)->nodeValue) ? $doc->getElementsByTagName('cStat')->item(0)->nodeValue : '';
          if ($cStat == ''){
              return false;
          }    

          $aRetorno['bStat'] = ($cStat == '103');
          // Status do serviço  
          $aRetorno['cStat'] = $doc->getElementsByTagName('cStat')->item(0)->nodeValue;
          // Motivo da resposta (opcional)
          $aRetorno['xMotivo'] = !empty($doc->getElementsByTagName('xMotivo')->item(0)->nodeValue) ? $doc->getElementsByTagName('xMotivo')->item(0)->nodeValue : '';
          // Data e hora da mensagem (opcional)
          $aRetorno['dhRecbto'] = !empty($doc->getElementsByTagName('dhRecbto')->item(0)->nodeValue) ? date("d/m/Y H:i", $this->convertTime($doc->getElementsByTagName('dhRecbto')->item(0)->nodeValue)) : '';
          // Numero do recibo do lote enviado (opcional)
          $aRetorno['nRec'] = !empty($doc->getElementsByTagName('nRec')->item(0)->nodeValue) ? $doc->getElementsByTagName('nRec')->item(0)->nodeValue : '';
          // Grava o retorno na pasta temp
          $nome = Config::ARQ_FOLDER_TEMP.'/cte'.$this->getChave().'-recibo-envio.xml';          
          //$nome = 'lote-rec.xml';
          $ret = $doc->save($nome);
          $this->gravaArquivoBanco($this->getCte(), $nome, 3);
          unlink($nome);

        } else {
            $aRetorno['xMotivo'] = 'Não houve retorno Soap.';
            $aRetorno['bStat'] = false;
        }
        return $aRetorno;
    } 
    
    public function retornoCte($recibo,$tipoAmbiente, $uf) {
        // Variavel de retorno do metodo
        $aRetorno = array('bStat'=>false,'cStat'=>'','xMotivo'=>'','dhRecbto'=>'','nRec'=>'');
        // Identificação do serviço
        $servico = 'CteRetRecepcao';
        // Recuperação do método
        $metodo = 'cteRetRecepcao';
        // Montagem do namespace do serviço
        $namespace = $this->URLPortal . '/wsdl/' . $servico;
        // Limpa a variavel
        /*$sCTe = '';

        $sCTe = implode('', $aCTe);
        $sCTe = str_replace(array('<?xml version="1.0" encoding="utf-8"?>', '<?xml version="1.0" encoding="UTF-8"?>'), '', $sCTe);
        $sCTe = str_replace(array("\r", "\n", "\s"), "", $sCTe);
        */
        $cabec = '<cteCabecMsg xmlns="' . $namespace . '"><cUF>' . $uf . '</cUF><versaoDados>' . $this->versao . '</versaoDados></cteCabecMsg>';
        $dados = '<cteDadosMsg xmlns="' . $namespace . '"><consReciCTe xmlns="' . $this->URLPortal . '" versao="' . $this->versao . '"><tpAmb>' .  $tipoAmbiente . '</tpAmb><nRec>' . $recibo . '</nRec></consReciCTe></cteDadosMsg>';
        $retorno = $this->sendSOAP2($namespace, $cabec, $dados, $metodo, $tipoAmbiente, $uf);
        // Verifica o retorno         
        if ($retorno) {
          // Tratar dados de retorno
          $doc = new DOMDocument();
          $doc->formatOutput = false;
          $doc->preserveWhiteSpace = false;
          $doc->loadXML($retorno, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
          $cStat = $doc->getElementsByTagName('cStat')->item(1)->nodeValue;
          $aRetorno['bStat'] = ($cStat == '100');
          // Status do serviço  
          $aRetorno['cStat'] = $cStat;
          // Motivo da resposta (opcional)
          $aRetorno['xMotivo'] = $doc->getElementsByTagName('xMotivo')->item(1)->nodeValue;
          // Data e hora da mensagem (opcional)
          $aRetorno['dhRecbto'] = !empty($doc->getElementsByTagName('dhRecbto')->item(0)->nodeValue) ? date("d/m/Y H:i", $this->convertTime($doc->getElementsByTagName('dhRecbto')->item(0)->nodeValue)) : '';
          // Numero do recibo do lote enviado (opcional)
          $aRetorno['nRec'] = !empty($doc->getElementsByTagName('nRec')->item(0)->nodeValue) ? $doc->getElementsByTagName('nRec')->item(0)->nodeValue : '';
          $aRetorno['nProt'] = $doc->getElementsByTagName('nProt')->item(0)->nodeValue;
          // Grava o retorno na pasta temp
          $arquivo = Config::ARQ_FOLDER_TEMP.'/cte'.$this->getChave().'-recibo-retorno.xml';
          //$nome = 'lote-rec.xml';
          $nome = $doc->save($arquivo);
          
          $arqAssinado = Config::ARQ_FOLDER_TEMP.'/cte'.$this->getChave().'-sign.xml';
          $this->gravaArquivoBanco($this->getCte(), $arquivo, 4);
          if($cStat == '100'){
            $retorno = $this->addProt($arqAssinado,$arquivo);
            $arqProtocolado = Config::ARQ_FOLDER_TEMP.'/cte'.$this->getChave().'-protcte.xml';
            if ( file_put_contents($arqProtocolado, $retorno) ) {
                unlink($arqAssinado);
            }
            $this->gravaArquivoBanco($this->getCte(), $arqProtocolado, 5);
            unlink($arqProtocolado);          
          }   
          unlink($arquivo);          
          
        } else {
            $aRetorno['xMotivo'] = 'Não houve retorno Soap';
            $aRetorno['bStat'] = $aRetorno['bStat'];
            $aRetorno['cStat'] = '';
            $aRetorno['nProt'] = '';
        }
        return $aRetorno;
    } 
    
    private function retornaUrlSefaz($metodo,$uf,$ambiente){
        $aRecepcao = array();
        $aRecepcao[] = 'https://cte.sefaz.mt.gov.br/ctews/services/CteRecepcao';
        $aRecepcao[] = 'https://producao.cte.ms.gov.br/cteWEB/CteRecepcao.asmx';
        $aRecepcao[] = 'https://cte.fazenda.mg.gov.br/cte/services/CteRecepcao';
        $aRecepcao[] = 'https://cte.fazenda.pr.gov.br/cte/CteRecepcao?wsdl';
        $aRecepcao[] = 'https://cte.sefaz.rs.gov.br/ws/cterecepcao/CteRecepcao.asmx';
        $aRecepcao[] = 'https://nfe.fazenda.sp.gov.br/cteWEB/services/cteRecepcao.asmx';
        $aRecepcao[] = 'https://homologacao.sefaz.mt.gov.br/ctews/services/CteRecepcao';
        $aRecepcao[] = 'https://homologacao.cte.ms.gov.br/cteWEB/CteRecepcao.asmx';
        $aRecepcao[] = 'https://hcte.fazenda.mg.gov.br/cte/services/CteRecepcao';
        $aRecepcao[] = 'https://homologacao.cte.fazenda.pr.gov.br/cte/CteRecepcao?wsdl';
        $aRecepcao[] = 'https://homologacao.cte.sefaz.rs.gov.br/ws/cterecepcao/CteRecepcao.asmx';
        $aRecepcao[] = 'https://homologacao.nfe.fazenda.sp.gov.br/cteWEB/services/cteRecepcao.asmx';
            
        $aRetRececpacao = array();
        $aRetRececpacao[] = 'https://cte.sefaz.mt.gov.br/ctews/services/CteRetRecepcao';
        $aRetRececpacao[] = 'https://producao.cte.ms.gov.br/cteWEB/CteRetRecepcao.asmx';
        $aRetRececpacao[] = 'https://cte.fazenda.mg.gov.br/cte/services/CteRetRecepcao';
        $aRetRececpacao[] = 'https://cte.fazenda.pr.gov.br/cte/CteRetRecepcao?wsdl';
        $aRetRececpacao[] = 'https://cte.sefaz.rs.gov.br/ws/cteretrecepcao/CteRetRecepcao.asmx';
        $aRetRececpacao[] = 'https://nfe.fazenda.sp.gov.br/cteWEB/services/cteRetRecepcao.asmx';
        $aRetRececpacao[] = 'https://homologacao.sefaz.mt.gov.br/ctews/services/CteRetRecepcao';
        $aRetRececpacao[] = 'https://homologacao.cte.ms.gov.br/cteWEB/CteRetRecepcao.asmx';
        $aRetRececpacao[] = 'https://hcte.fazenda.mg.gov.br/cte/services/CteRetRecepcao';
        $aRetRececpacao[] = 'https://homologacao.cte.fazenda.pr.gov.br/cte/CteRetRecepcao?wsdl';
        $aRetRececpacao[] = 'https://homologacao.cte.sefaz.rs.gov.br/ws/cteretrecepcao/CteRetRecepcao.asmx';
        $aRetRececpacao[] = 'https://homologacao.nfe.fazenda.sp.gov.br/cteWEB/services/cteRetRecepcao.asmx';
            
        $aCancelamento = array();
        $aCancelamento[] = 'https://cte.sefaz.mt.gov.br/ctews/services/CteCancelamento';
        $aCancelamento[] = 'https://producao.cte.ms.gov.br/cteWEB/CteCancelamento.asmx';
        $aCancelamento[] = 'https://cte.fazenda.mg.gov.br/cte/services/CteCancelamento';    
        $aCancelamento[] = 'https://cte.fazenda.pr.gov.br/cte/CteCancelamento?wsdl';
        $aCancelamento[] = 'https://cte.sefaz.rs.gov.br/ws/ctecancelamento/ctecancelamento.asmx';
        $aCancelamento[] = 'https://nfe.fazenda.sp.gov.br/cteWEB/services/cteCancelamento.asmx';
        $aCancelamento[] = 'https://homologacao.sefaz.mt.gov.br/ctews/services/CteCancelamento';
        $aCancelamento[] = 'https://homologacao.cte.ms.gov.br/cteWEB/CteCancelamento.asmx';
        $aCancelamento[] = 'https://hcte.fazenda.mg.gov.br/cte/services/CteCancelamento';
        $aCancelamento[] = 'https://homologacao.cte.fazenda.pr.gov.br/cte/CteCancelamento?wsdl';
        $aCancelamento[] = 'https://homologacao.cte.sefaz.rs.gov.br/ws/ctecancelamento/ctecancelamento.asmx';
        $aCancelamento[] = 'https://homologacao.nfe.fazenda.sp.gov.br/cteWEB/services/cteCancelamento.asmx';
            
        $aInutilizacao = array();
        $aInutilizacao[] = 'https://cte.sefaz.mt.gov.br/ctews/services/CteInutilizacao';
        $aInutilizacao[] = 'https://producao.cte.ms.gov.br/cteWEB/CteInutilizacao.asmx';
        $aInutilizacao[] = 'https://cte.fazenda.mg.gov.br/cte/services/CteInutilizacao';
        $aInutilizacao[] = 'https://cte.fazenda.pr.gov.br/cte/CteInutilizacao?wsdl';
        $aInutilizacao[] = 'https://cte.sefaz.rs.gov.br/ws/cteinutilizacao/cteinutilizacao.asmx';
        $aInutilizacao[] = 'https://nfe.fazenda.sp.gov.br/cteWEB/services/cteInutilizacao.asmx';    
        $aInutilizacao[] = 'https://homologacao.sefaz.mt.gov.br/ctews/services/CteInutilizacao';
        $aInutilizacao[] = 'https://homologacao.cte.ms.gov.br/cteWEB/CteInutilizacao.asmx';
        $aInutilizacao[] = 'https://hcte.fazenda.mg.gov.br/cte/services/CteInutilizacao';
        $aInutilizacao[] = 'https://homologacao.cte.fazenda.pr.gov.br/cte/CteInutilizacao?wsdl';
        $aInutilizacao[] = 'https://homologacao.cte.sefaz.rs.gov.br/ws/cteinutilizacao/cteinutilizacao.asmx';
        $aInutilizacao[] = 'https://homologacao.nfe.fazenda.sp.gov.br/cteWEB/services/cteInutilizacao.asmx';
            
        $aConsultaProtocolo = array();
        $aConsultaProtocolo[] = 'https://cte.sefaz.mt.gov.br/ctews/services/CteConsulta';
        $aConsultaProtocolo[] = 'https://producao.cte.ms.gov.br/cteWEB/CteConsulta.asmx';
        $aConsultaProtocolo[] = 'https://cte.fazenda.mg.gov.br/cte/services/CteConsulta';
        $aConsultaProtocolo[] = 'https://cte.fazenda.pr.gov.br/cte/CteConsulta?wsdl';
        $aConsultaProtocolo[] = 'https://cte.sefaz.rs.gov.br/ws/cteconsulta/cteconsulta.asmx'; 
        $aConsultaProtocolo[] = 'https://nfe.fazenda.sp.gov.br/cteWEB/services/cteConsulta.asmx';
        $aConsultaProtocolo[] = 'https://homologacao.sefaz.mt.gov.br/ctews/services/CteConsulta';
        $aConsultaProtocolo[] = 'https://homologacao.cte.ms.gov.br/cteWEB/CteConsulta.asmx';
        $aConsultaProtocolo[] = 'https://hcte.fazenda.mg.gov.br/cte/services/CteConsulta';
        $aConsultaProtocolo[] = 'https://homologacao.cte.fazenda.pr.gov.br/cte/CteConsulta?wsdl';
        $aConsultaProtocolo[] = 'https://homologacao.cte.sefaz.rs.gov.br/ws/cteconsulta/cteconsulta.asmx';
        $aConsultaProtocolo[] = 'https://homologacao.nfe.fazenda.sp.gov.br/cteWEB/services/cteConsulta.asmx';
            
            
        $aStatusServico = array();
        $aStatusServico[] = 'https://cte.sefaz.mt.gov.br/ctews/services/CteStatusServico';
        $aStatusServico[] = 'https://producao.cte.ms.gov.br/cteWEB/CteStatusServico.asmx';
        $aStatusServico[] = 'https://cte.fazenda.mg.gov.br/cte/services/CteStatusServico';
        $aStatusServico[] = 'https://cte.fazenda.pr.gov.br/cte/CteStatusServico?wsdl';
        $aStatusServico[] = 'https://cte.sefaz.rs.gov.br/ws/ctestatusservico/ctestatusservico.asmx';
        $aStatusServico[] = 'https://nfe.fazenda.sp.gov.br/cteWEB/services/cteStatusServico.asmx';    
        $aStatusServico[] = 'https://homologacao.sefaz.mt.gov.br/ctews/services/CteStatusServico';
        $aStatusServico[] = 'https://homologacao.cte.ms.gov.br/cteWEB/CteStatusServico.asmx';
        $aStatusServico[] = 'https://hcte.fazenda.mg.gov.br/cte/services/CteStatusServico';
        $aStatusServico[] = 'https://homologacao.cte.fazenda.pr.gov.br/cte/CteStatusServico?wsdl';
        $aStatusServico[] = 'https://homologacao.cte.sefaz.rs.gov.br/ws/ctestatusservico/ctestatusservico.asmx';
        $aStatusServico[] = 'https://homologacao.nfe.fazenda.sp.gov.br/cteWEB/services/cteStatusServico.asmx';
            
        $aRecepcaoEvento = array();
        $aRecepcaoEvento[] = 'https://cte.sefaz.mt.gov.br/ctews2/services/CteRecepcaoEvento?wsdl';
        $aRecepcaoEvento[] = 'https://producao.cte.ms.gov.br/cteWEB/CteRecepcaoEvento.asmx';
        $aRecepcaoEvento[] = 'https://cte.fazenda.mg.gov.br/cte/services/RecepcaoEvento';
        $aRecepcaoEvento[] = 'https://cte.fazenda.pr.gov.br/cte/CteRecepcaoEvento?wsdl';
        $aRecepcaoEvento[] = 'https://cte.sefaz.rs.gov.br/ws/cterecepcaoevento/cterecepcaoevento.asmx';
        $aRecepcaoEvento[] = 'https://nfe.fazenda.sp.gov.br/cteweb/services/cteRecepcaoEvento.asmx';        
        $aRecepcaoEvento[] = 'https://homologacao.sefaz.mt.gov.br/ctews2/services/CteRecepcaoEvento?wsdl';
        $aRecepcaoEvento[] = 'https://homologacao.cte.ms.gov.br/cteWEB/CteRecepcaoEvento.asmx';
        $aRecepcaoEvento[] = 'https://hcte.fazenda.mg.gov.br/cte/services/RecepcaoEvento';
        $aRecepcaoEvento[] = 'https://homologacao.cte.fazenda.pr.gov.br/cte/CteRecepcaoEvento?wsdl';
        $aRecepcaoEvento[] = 'https://homologacao.cte.sefaz.rs.gov.br/ws/cterecepcaoevento/cterecepcaoevento.asmx';
        $aRecepcaoEvento[] = 'https://homologacao.nfe.fazenda.sp.gov.br/cteweb/services/cteRecepcaoEvento.asmx';
            
        $servico='';
        $iInd = $this->retornaIndUf($uf,$ambiente);
        switch ($metodo){
        case 'cteRecepcaoLote':
            return $aRecepcao[$iInd];
            break;
        case 'cteRetRecepcao':
            return $aRetRececpacao[$iInd];
            break;
        case 'CTeCancelamento':
            return $aCancelamento[$iInd];
            break;
        case 'CTeInutilizacao':
            return $aInutilizacao[$iInd];
            break;
        case 'cteConsultaCT':
            return $aConsultaProtocolo[$iInd];
            break;
        case 'cteStatusServicoCT':
            return $aStatusServico[$iInd];
            break;
        case 'consultaCadastro':
            return $aRecepcaoEvento[$iInd];
            break;
        case 'cteRecepcaoEvento':
            return $aRecepcaoEvento[$iInd];
            break;
        }        
    }
    private function retornaIndUf($uf,$amb){
        $ind  = 0;
        $ind2 = 0;
        $aEstado['TO']=17;
        if($uf==51){
            $ind = 0;
            $ind2 = 6;
        }
        else if($uf==50){
            $ind = 1;
            $ind2 = 7;
        }
        else if($uf==31){
            $ind = 2;
            $ind2 = 8;
        }
        else if($uf==41){
            $ind = 3;
            $ind2 = 9;
        }
        else if($uf==35 or
           $uf==16 or
           $uf==26 or
           $uf==14){
            $ind = 5;
            $ind2 = 11;
        }
        else {
            $ind = 4;
            $ind2 = 10;
        }
        if ($amb==2){
            return $ind2;
        }
        else {
            return $ind;
        }
    }

    private function sendSOAP2($namespace,$cabecalho,$dados,$metodo,$ambiente,$uf){
        $urlsefaz = $this->retornaUrlSefaz($metodo,$uf,$ambiente);
        //monta a terminação do URL
        $data = '';
        $data .= '<?xml version="1.0" encoding="utf-8"?>';
        $data .= '<soap12:Envelope ';
        $data .= 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
        $data .= 'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ';
        $data .= 'xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">';
        $data .= '<soap12:Header>';
        $data .= $cabecalho;
        $data .= '</soap12:Header>';
        $data .= '<soap12:Body>';
        $data .= $dados;
        $data .= '</soap12:Body>';
        $data .= '</soap12:Envelope>';
        //Tabela de codigos HTTP
        $cCode['0']="Indefinido";
        //[Informational 1xx]
        $cCode['100']="Continue";
        $cCode['101']="Switching Protocols";
        //[Successful 2xx]
        $cCode['200']="OK";
        $cCode['201']="Created";
        $cCode['202']="Accepted";
        $cCode['203']="Non-Authoritative Information";
        $cCode['204']="No Content";
        $cCode['205']="Reset Content";
        $cCode['206']="Partial Content";
        //[Redirection 3xx]
        $cCode['300']="Multiple Choices";
        $cCode['301']="Moved Permanently";
        $cCode['302']="Found";
        $cCode['303']="See Other";
        $cCode['304']="Not Modified";
        $cCode['305']="Use Proxy";
        $cCode['306']="(Unused)";
        $cCode['307']="Temporary Redirect";
        //[Client Error 4xx]
        $cCode['400']="Bad Request";
        $cCode['401']="Unauthorized";
        $cCode['402']="Payment Required";
        $cCode['403']="Forbidden";
        $cCode['404']="Not Found";
        $cCode['405']="Method Not Allowed";
        $cCode['406']="Not Acceptable";
        $cCode['407']="Proxy Authentication Required";
        $cCode['408']="Request Timeout";
        $cCode['409']="Conflict";
        $cCode['410']="Gone";
        $cCode['411']="Length Required";
        $cCode['412']="Precondition Failed";
        $cCode['413']="Request Entity Too Large";
        $cCode['414']="Request-URI Too Long";
        $cCode['415']="Unsupported Media Type";
        $cCode['416']="Requested Range Not Satisfiable";
        $cCode['417']="Expectation Failed";
        //[Server Error 5xx]
        $cCode['500']="Internal Server Error";
        $cCode['501']="Not Implemented";
        $cCode['502']="Bad Gateway";
        $cCode['503']="Service Unavailable";
        $cCode['504']="Gateway Timeout";
        $cCode['505']="HTTP Version Not Supported";
        //
        $tamanho = strlen($data);
        $parametros = Array('Content-Type: application/soap+xml;charset=utf-8;action="'.$namespace."/".$metodo.'"','SOAPAction: "'.$metodo.'"',"Content-length: $tamanho");
        $_aspa = '"';
        $oCurl = curl_init();
        if(is_array($this->aProxy)){
                curl_setopt($oCurl, CURLOPT_HTTPPROXYTUNNEL, 1);
                curl_setopt($oCurl, CURLOPT_PROXYTYPE, "CURLPROXY_HTTP");
                curl_setopt($oCurl, CURLOPT_PROXY, $this->aProxy['IP'].':'.$this->aProxy['PORT']);
                if( $this->aProxy['PASS'] != '' ){
                        curl_setopt($oCurl, CURLOPT_PROXYUSERPWD, $this->aProxy['USER'].':'.$this->aProxy['PASS']);
                        curl_setopt($oCurl, CURLOPT_PROXYAUTH, "CURLAUTH_BASIC");
                } //fim if senha proxy
        }//fim if aProxy

        curl_setopt($oCurl, CURLOPT_URL, $urlsefaz.'');
        curl_setopt($oCurl, CURLOPT_PORT , 443);
        curl_setopt($oCurl, CURLOPT_VERBOSE, 1); //apresenta informações de conexão na tela
        curl_setopt($oCurl, CURLOPT_HEADER, 1); //retorna o cabeçalho de resposta
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 3);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($oCurl, CURLOPT_SSLCERT, $this->pubKEY);
        curl_setopt($oCurl, CURLOPT_SSLKEY, $this->priKEY);
        curl_setopt($oCurl, CURLOPT_POST, 1);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER,$parametros);

        $__xml = curl_exec($oCurl);
        $info = curl_getinfo($oCurl); //informações da conexão
        $txtInfo ="";
        $txtInfo .= "URL=$info[url]\n";
        $txtInfo .= "Content type=$info[content_type]\n";
        $txtInfo .= "Http Code=$info[http_code]\n";
        $txtInfo .= "Header Size=$info[header_size]\n";
        $txtInfo .= "Request Size=$info[request_size]\n";
        $txtInfo .= "Filetime=$info[filetime]\n";
        $txtInfo .= "SSL Verify Result=$info[ssl_verify_result]\n";
        $txtInfo .= "Redirect Count=$info[redirect_count]\n";
        $txtInfo .= "Total Time=$info[total_time]\n";
        $txtInfo .= "Namelookup=$info[namelookup_time]\n";
        $txtInfo .= "Connect Time=$info[connect_time]\n";
        $txtInfo .= "Pretransfer Time=$info[pretransfer_time]\n";
        $txtInfo .= "Size Upload=$info[size_upload]\n";
        $txtInfo .= "Size Download=$info[size_download]\n";
        $txtInfo .= "Speed Download=$info[speed_download]\n";
        $txtInfo .= "Speed Upload=$info[speed_upload]\n";
        $txtInfo .= "Download Content Length=$info[download_content_length]\n";
        $txtInfo .= "Upload Content Length=$info[upload_content_length]\n";
        $txtInfo .= "Start Transfer Time=$info[starttransfer_time]\n";
        $txtInfo .= "Redirect Time=$info[redirect_time]\n";
        $txtInfo .= "Certinfo=$info[certinfo]\n";
        $n = strlen($__xml);
        $x = stripos($__xml, "<");
        $xml = substr($__xml, $x, $n-$x);
        //$this->soapDebug = $data."\n\n".$txtInfo."\n".$__xml;
        if ($__xml === false){
                //não houve retorno
                $this->errMsg = curl_error($oCurl) . $info['http_code'] . $cCode[$info['http_code']];
                $this->errStatus = true;
        } else {
                //houve retorno mas ainda pode ser uma mensagem de erro do webservice
                $this->errMsg = $info['http_code'] . ' ' . $cCode[$info['http_code']];
                $this->errStatus = false;
        }
        curl_close($oCurl);
        return $xml;
    } 
    private function convertTime($DH){
        if ($DH) {
            $aDH = explode('T', $DH);
            $adDH = explode('-', $aDH[0]);
            $atDH = explode(':', $aDH[1]);
            $timestampDH = mktime($atDH[0], $atDH[1], $atDH[2], $adDH[1], $adDH[2], $adDH[0]);
            return $timestampDH;
        }
    }
    
     private function cleanString($texto){
        $aFind = array('&','á','à','ã','â','é','ê','í','ó','ô','õ','ú','ü','ç','Á','À','Ã','Â','É','Ê','Í','Ó','Ô','Õ','Ú','Ü','Ç');
        $aSubs = array('e','a','a','a','a','e','e','i','o','o','o','u','u','c','A','A','A','A','E','E','I','O','O','O','U','U','C');
        $novoTexto = str_replace($aFind,$aSubs,$texto);
        $novoTexto = preg_replace("/[^a-zA-Z0-9 @,-.;:\/]/", "", $novoTexto);
        return $novoTexto;
    }//fim __cleanString
    
    public function addProt($ctefile, $protfile) {
            //protocolo do lote enviado
            $prot = new DOMDocument(); //cria objeto DOM
            $prot->formatOutput = false;
            $prot->preserveWhiteSpace = false;
            //CTe enviada
            $doccte = new DOMDocument(); //cria objeto DOM
            $doccte->formatOutput = false;
            $doccte->preserveWhiteSpace = false;
            //carrega o arquivo na veriável
            $xmlcte = file_get_contents($ctefile);
            $doccte->loadXML($xmlcte,LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            $cte = $doccte->getElementsByTagName("CTe")->item(0);
            //$infCTe = $doccte->getElementsByTagName("infCTe")->item(0);
            //$versao = trim($infCTe->getAttribute("versao"));
            //carrega o protocolo e seus dados
            $xmlprot = file_get_contents($protfile);
            $prot->loadXML($xmlprot,LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            $protCTe = $prot->getElementsByTagName("protCTe")->item(0);
            $protver = trim($protCTe->getAttribute("versao"));
            $tpAmb = $prot->getElementsByTagName("tpAmb")->item(0)->nodeValue;
            $verAplic = $prot->getElementsByTagName("verAplic")->item(0)->nodeValue;
            $chCTe=$prot->getElementsByTagName("chCTe")->item(0)->nodeValue;
            $dhRecbto=$prot->getElementsByTagName("dhRecbto")->item(0)->nodeValue;
            $nProt=$prot->getElementsByTagName("nProt")->item(0)->nodeValue;
            $digVal=$prot->getElementsByTagName("digVal")->item(0)->nodeValue;
            $cStat=$prot->getElementsByTagName("cStat")->item(0)->nodeValue;
            $xMotivo=$prot->getElementsByTagName('xMotivo')->item(1)->nodeValue;
            //cria a CTe processada com a tag do protocolo
            $proccte = new DOMDocument('1.0', 'utf-8');
            $proccte->formatOutput = false;
            $proccte->preserveWhiteSpace = false;
            //cria a tag cteProc
            $cteProc = $proccte->createElement('cteProc');
            $proccte->appendChild($cteProc);
            //estabele o atributo de versão
            $cteProc_att1 = $cteProc->appendChild($proccte->createAttribute('versao'));
            $cteProc_att1->appendChild($proccte->createTextNode($protver));
            //estabelece o atributo xmlns
            $cteProc_att2 = $cteProc->appendChild($proccte->createAttribute('xmlns'));
            $cteProc_att2->appendChild($proccte->createTextNode($this->URLcte));
            //inclui CTe
            $node = $proccte->importNode($cte, true);
            $cteProc->appendChild($node);
            //cria tag protCTe
            $protCTe = $proccte->createElement('protCTe');
            $cteProc->appendChild($protCTe);
            //estabele o atributo de versão
            $protCTe_att1 = $protCTe->appendChild($proccte->createAttribute('versao'));
            $protCTe_att1->appendChild($proccte->createTextNode($this->versao));
            //cria tag infProt
            $infProt = $proccte->createElement('infProt');
            $protCTe->appendChild($infProt);
            $infProt->appendChild($proccte->createElement('tpAmb',$tpAmb));
            $infProt->appendChild($proccte->createElement('verAplic',$verAplic));
            $infProt->appendChild($proccte->createElement('chCTe',$chCTe));
            $infProt->appendChild($proccte->createElement('dhRecbto',$dhRecbto));
            $infProt->appendChild($proccte->createElement('nProt',$nProt));
            $infProt->appendChild($proccte->createElement('digVal',$digVal));
            $infProt->appendChild($proccte->createElement('cStat',$cStat));
            $infProt->appendChild($proccte->createElement('xMotivo',$xMotivo));
            //salva o xml como string em uma variável
            $procXML = $proccte->saveXML();
            //remove as informações indesejadas
            $procXML = str_replace('default:','',$procXML);
            $procXML = str_replace(':default','',$procXML);
            $procXML = str_replace("\n",'',$procXML);
            $procXML = str_replace("\r",'',$procXML);
            $procXML = str_replace("\s",'',$procXML);
            $procXML = str_replace('CTe xmlns="http://www.portalfiscal.inf.br/cte" xmlns="http://www.w3.org/2000/09/xmldsig#"','CTe xmlns="http://www.portalfiscal.inf.br/cte"',$procXML);
            return $procXML;
    } //fim addProt
    public function addProtCanc($ctefile, $protfile) {
        //protocolo do lote enviado
        $prot = new DOMDocument(); //cria objeto DOM
        $prot->formatOutput = false;
        $prot->preserveWhiteSpace = false;
        //CTe enviada
        $doccte = new DOMDocument(); //cria objeto DOM
        $doccte->formatOutput = false;
        $doccte->preserveWhiteSpace = false;
        //carrega o arquivo na veriável
        $xmlcte = file_get_contents($ctefile);
        $doccte->loadXML($xmlcte,LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
        $cte = $doccte->getElementsByTagName("CTe")->item(0);
        //$infCTe = $doccte->getElementsByTagName("infCanc")->item(0);
        //$versao = trim($cte->getAttribute("versao"));
        //carrega o protocolo e seus dados
        $xmlprot = file_get_contents($protfile);
        $prot->loadXML($xmlprot,LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
        $protCTe = $prot->getElementsByTagName("retEventoCTe")->item(0);
        $protver = trim($protCTe->getAttribute("versao"));
        $tpAmb = $prot->getElementsByTagName("tpAmb")->item(0)->nodeValue;
        $verAplic =
        $prot->getElementsByTagName("verAplic")->item(0)->nodeValue;
        $cUF = $prot->getElementsByTagName("cUF")->item(0)->nodeValue;
        $chCTe=$prot->getElementsByTagName("chCTe")->item(0)->nodeValue;
        $dhRecbto=$prot->getElementsByTagName("dhRecbto")->item(0)->nodeValue;
        $nProt=$prot->getElementsByTagName("nProt")->item(0)->nodeValue;
        $cStat=$prot->getElementsByTagName("cStat")->item(0)->nodeValue;
        $xMotivo="Cancelado - ".$prot->getElementsByTagName("xMotivo")->item(0)->nodeValue;
        //cria a CTe processada com a tag do protocolo
        $proccte = new DOMDocument('1.0', 'utf-8');
        $proccte->formatOutput = false;
        $proccte->preserveWhiteSpace = false;
        //cria a tag cteProc
        $cteProc = $proccte->createElement('procCancCTe');
        $proccte->appendChild($cteProc);
        //estabele o atributo de versão
        $cteProc_att1 = $cteProc->appendChild($proccte->createAttribute('versao'));
        $cteProc_att1->appendChild($proccte->createTextNode($protver));
        //estabelece o atributo xmlns
        $cteProc_att2 = $cteProc->appendChild($proccte->createAttribute('xmlns'));
        $cteProc_att2->appendChild($proccte->createTextNode($this->URLcte));
        //inclui CTe
        $node = $proccte->importNode($cte, true);
        $cteProc->appendChild($node);
        //cria tag protCTe
        $protCTe = $proccte->createElement('retCancCTe');
        $cteProc->appendChild($protCTe);
        //estabele o atributo de versão
        $protCTe_att1 = $protCTe->appendChild($proccte->createAttribute('versao'));
        $protCTe_att1->appendChild($proccte->createTextNode($this->versao));
        $protCTe_att2 = $protCTe->appendChild($proccte->createAttribute('xmlns'));
        $protCTe_att2->appendChild($proccte->createTextNode($this->URLcte));
        //cria tag infProt
        $infProt = $proccte->createElement('infCanc');
        $infProt_att1 = $infProt->appendChild($proccte->createAttribute('Id'));
        $infProt_att1->appendChild($proccte->createTextNode('ID'.$nProt));
        $protCTe->appendChild($infProt);
        $infProt->appendChild($proccte->createElement('tpAmb',$tpAmb));
        $infProt->appendChild($proccte->createElement('verAplic',$verAplic));
        $infProt->appendChild($proccte->createElement('cStat',$cStat));
        $infProt->appendChild($proccte->createElement('xMotivo',$xMotivo));
        $infProt->appendChild($proccte->createElement('cUF',$cUF));
        $infProt->appendChild($proccte->createElement('chCTe',$chCTe));
        $infProt->appendChild($proccte->createElement('dhRecbto',$dhRecbto));
        $infProt->appendChild($proccte->createElement('nProt',$nProt));
        //salva o xml como string em uma variável
        $procXML = $proccte->saveXML();
        //remove as informações indesejadas
        $procXML = str_replace('default:','',$procXML);
        $procXML = str_replace(':default','',$procXML);
        $procXML = str_replace("\n",'',$procXML);
        $procXML = str_replace("\r",'',$procXML);
        $procXML = str_replace("\s",'',$procXML);
        $procXML = str_replace('cancCTe xmlns="http://www.portalfiscal.inf.br/cte" xmlns="http://www.w3.org/2000/09/xmldsig#"','cancCTe xmlns="http://www.portalfiscal.inf.br/cte"',$procXML);
        return $procXML;
    } //fim addProtCanc
    
    public function gravaArquivoBanco($oCte,$endereco,$situacao){
        $oControllerArquivo = Fabrica::FabricarController('Arquivo');
        $aRet = $oControllerArquivo->addFileFromController($endereco,false);
        if($aRet[0]){
            $aParts = explode("&",$aRet[1]);
            $aEmp = explode("=",$aParts[0]);
            $aArq = explode("=",$aParts[1]);
            $oModelCteXml = Fabrica::FabricarModel('CteXml');
            $oPersCteXml = Fabrica::FabricarPersistencia('CteXml');
            $oPersCteXml->setModel($oModelCteXml);
            $oModelCteXml->setCte($oCte);
            $oModelCteXml->setCodigoEmpresa($aEmp[1]);
            $oModelCteXml->getArquivo()->setCodigo($aArq[1]);
            $oModelCteXml->setSituacao($situacao);
            $ret = $oPersCteXml->inserir();
            if($situacao==5){
                $oModelCteXml->setSituacao(1);
                $ret = $oPersCteXml->excluir(true);
                $oModelCteXml->setSituacao(2);
                $ret = $oPersCteXml->excluir(true);
                $oModelCteXml->setSituacao(3);
                $ret = $oPersCteXml->excluir(true);
                $oModelCteXml->setSituacao(4);
                $ret = $oPersCteXml->excluir(true);
            }
        }
    }    
}

?>

