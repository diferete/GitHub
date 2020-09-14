<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 03/10/2018
 */

class ViewSTEEL_PCP_Certificado extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        
        $oNr = new CampoConsulta('Nr.', 'nrcert');
        $oOp = new CampoConsulta('Op', 'op');
        $oNotaSteel = new CampoConsulta('Nota.Retorno', 'notasteel');
        $oNotaClient = new CampoConsulta('Nota.Entrada', 'notacliente');
        $oOpcliente = new CampoConsulta('OP_Cli', 'opcliente');
        //$oEmpCod = new CampoConsulta('Empresa', 'empcod');
        $oEmpDes = new CampoConsulta('Cliente', 'empdes');
        $oEmpDes->setBTruncate(true);
        $oProduto = new CampoConsulta('Produto', 'prodes');
        $oDataEnsaio = new CampoConsulta('Data Ensaio', 'dataensaio', CampoConsulta::TIPO_DATA);
        $oPeso = new CampoConsulta('Peso', 'peso');
        
        $oSitEmail = new CampoConsulta('Email','sitEmail');
        $oSitEmail->addComparacao('NãoEnv', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO,CampoConsulta::MODO_COLUNA, false, '');
        $oSitEmail->addComparacao('Env', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA, false, '');
        
        //botao 
        $oBotaoHist = new CampoConsulta('','liberar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_FLAG);
        $oBotaoHist->setBHideTelaAcao(true);
        $oBotaoHist->setILargura(15);
        $oBotaoHist->setSTitleAcao('Histórico de envio!');
        $oBotaoHist->addAcao('STEEL_PCP_histEmailcert','criaTelaModalHist','modalHist');
        $this->addModais($oBotaoHist);
       // $this->getTela()->setBFocoCampo(true);
        
        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO_IGUAL, 1);
        $oFiltroCliente = new Filtro($oEmpDes, Filtro::CAMPO_TEXTO, 3);
        $oFiltroNotaSteel = new Filtro($oNotaSteel, Filtro::CAMPO_TEXTO_IGUAL, 1);
        $oFiltroNotaCliente = new Filtro($oNotaClient, Filtro::CAMPO_TEXTO_IGUAL, 1);

        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oFiltroNotaSteel,$oOpFiltro,$oFiltroCliente,$oFiltroNotaCliente);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir/E-mail',Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'STEEL_PCP_Certificado', 'acaoMostraRelCertificado', '', false, 'CertificadoOpSteel',false,'',false,'',true);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar E-mail', 'STEEL_PCP_Certificado', 'geraPdfCert', '', false, 'CertificadoOpSteel',false,'',false,'',true);
        $this->addDropdown($oDrop1);
        
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->addCampos($oNr,$oOp,$oNotaSteel,$oNotaClient,$oOpcliente,$oEmpDes,$oProduto,$oDataEnsaio,$oSitEmail,$oBotaoHist);
    
        $this->getTela()->setIAltura(700);
        //------------------------------------------
      /*  $oLinha = new Campo('Dados da nota de retorno','linha', Campo::TIPO_LABEL,12,12,12,12);
        $oNotaRetorno = new Campo('Nota de retorno','notaretorno', Campo::TIPO_TEXTO,2,2,2,2);
        $oNotaRetorno->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDataRetorno = new Campo('Data','data', Campo::TIPO_DATA,2,2,2);
        $oDataRetorno->setSCorFundo(Campo::FUNDO_AMARELO);
        $oHoraRet = new campo('Hora','horaretorno', Campo::TIPO_TEXTO,2,2,2);
        $oUsuárioRet= new campo('Usuário','userRet', Campo::TIPO_TEXTO,3,3,3);
        
         $this->getTela()->setSEventoClick('var chave=""; $("#'.$this->getTela()->getSId().' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","NfRep","camposGrid","'.$this->getTela()->getSId().'"+","+chave+","+"'.$oOrdens->getId().'"+","+"'.$oAllOrdem->getId().'");'
                . 'requestAjax("'.$this->getTela()->getSId().'-form","NfRepIten","getDadosGridDetalhe","'.$oGridItens->getId().'",chave);');
      
        $this->addCamposGrid($oLinha,$oNotaRetorno,$oDataRetorno,$oHoraRet,$oUsuárioRet);*/
        
    }

    public function criaTela() {
        parent::criaTela();
        
        $oTab = new TabPanel();
        $oAbaPadrao = new AbaTabPanel('PADRÃO');
        $oAbaPadrao->setBActive(true);
   
        $this->addLayoutPadrao('Aba');
        
         $sAcao =  $this->getSRotina();
        
        $oDadosOp = $this->getAParametrosExtras();
        
        date_default_timezone_set('America/Sao_Paulo');
       
        $oNr = new Campo('Nr.', 'nrcert', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);
        
        $oOp = new Campo('Op','op',Campo::TIPO_BUSCADOBANCOPK,1,2,12,12);
        $oOp->setClasseBusca('STEEL_PCP_OrdensFab');
        $oOp->setSCampoRetorno('op',$this->getTela()->getId());
        $oOp->setSCorFundo(Campo::FUNDO_AMARELO);
        $oOp->addValidacao(false, Validacao::TIPO_INTEIRO);
        if(method_exists($oDadosOp, 'getOp')) 
         {$oOp->setSValor($oDadosOp->getOp());
         $oOp->setBCampoBloqueado(TRUE);
         }
         if($sAcao=='acaoAlterar'){$oOp->setBCampoBloqueado(true);}
                
        $oNotaSteel = new Campo('Nota retorno', 'notasteel', Campo::TIPO_TEXTO, 1, 2, 12, 12);
        $oNotaSteel->setBFocus(true);
        
        $oDataRetorno = new Campo('Data Retorno','dataNotaRetorno', Campo::TIPO_DATA,2,2,2,2);
        
        $oNotaClient = new Campo('Nota rec.', 'notacliente', Campo::TIPO_TEXTO, 1, 2, 12, 12);
        $oNotaClient->addValidacao(false, Validacao::TIPO_INTEIRO);
        
        if(method_exists($oDadosOp, 'getDocumento')) 
         {$oNotaClient->setSValor($oDadosOp->getDocumento());
         $oNotaClient->setBCampoBloqueado(TRUE);
         }
        $oOpcliente = new Campo('OP Cliente.', 'opcliente', Campo::TIPO_TEXTO, 1, 2, 12, 12);
        //$oOpcliente->addValidacao(false, Validacao::TIPO_INTEIRO);
        if(method_exists($oDadosOp, 'getOpcliente')) 
         {$oOpcliente->setSValor($oDadosOp->getOpcliente());
         $oOpcliente->setBCampoBloqueado(TRUE);
         }
       
        //cliente
        $oEmp_codigo = new Campo('Empresa','empcod',Campo::TIPO_BUSCADOBANCOPK,2);
        $oEmp_codigo->addValidacao(false, Validacao::TIPO_INTEIRO);
        if(method_exists($oDadosOp, 'getEmp_codigo')) 
         {$oEmp_codigo->setSValor($oDadosOp->getEmp_codigo());
         $oEmp_codigo->setBCampoBloqueado(TRUE);
         }
        
        
        //campo descrição do cliente adicionando o campo de busca
        $oEmp_des = new Campo('Descricao','empdes',Campo::TIPO_BUSCADOBANCO, 4);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '','');
        $oEmp_des->addCampoBusca('emp_razaosocial', '','');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        $oEmp_des->addValidacao(false, Validacao::TIPO_STRING);
        if(method_exists($oDadosOp, 'getEmp_razaosocial')) 
         {$oEmp_des->setSValor($oDadosOp->getEmp_razaosocial());
         $oEmp_des->setBCampoBloqueado(TRUE);
         }
        
        //declarar o campo descrição
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo',$this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial',$oEmp_des->getId(),  $this->getTela()->getId());
        
        $oCodProd = new Campo('Produto', 'procod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCodProd->setSCorFundo(Campo::FUNDO_MONEY);
       // $oCodProd->addValidacao(false, Validacao::TIPO_INTEIRO);
        $oCodProd->setBCampoBloqueado(TRUE);
        if(method_exists($oDadosOp, 'getProd')) 
         {$oCodProd->setSValor($oDadosOp->getProd());
         $oCodProd->setBCampoBloqueado(TRUE);
         }
        
        $oProduto = new Campo('Descrição', 'prodes', Campo::TIPO_TEXTO, 4, 3, 12, 12);
        $oProduto->setSCorFundo(Campo::FUNDO_MONEY);
       // $oProduto->addValidacao(false, Validacao::TIPO_STRING);
        if(method_exists($oDadosOp, 'getProdes')) 
         {$oProduto->setSValor($oDadosOp->getProdes());
         $oProduto->setBCampoBloqueado(TRUE);
         }
        
        $oDataEnsaio = new Campo('Data Ensaio', 'dataensaio', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataEnsaio->setSValor(date('d/m/Y'));
        $oDataEnsaio->addValidacao(false, Validacao::TIPO_STRING);
        $oQuant = new Campo('Qt.', 'quant', Campo::TIPO_DECIMAL, 1, 2, 12, 12);
        $oQuant->addValidacao(false, Validacao::TIPO_DECIMAL);
        if(method_exists($oDadosOp, 'getquant')) 
         {$oQuant->setSValor(number_format($oDadosOp->getQuant(), 2, ',', '.'));
         $oQuant->setBCampoBloqueado(TRUE);
         }
        
        $oPeso = new Campo('Peso', 'peso', Campo::TIPO_DECIMAL, 1, 2, 12, 12);
        $oPeso->setSValor(number_format($oPeso, 2, ',', '.'));
        $oPeso->addValidacao(false, Validacao::TIPO_DECIMAL);
        if(method_exists($oDadosOp, 'getPeso')) 
         {$oPeso->setSValor(number_format($oDadosOp->getPeso(), 2, ',', '.'));
         $oPeso->setBCampoBloqueado(TRUE);
         }
        
        
        //linha
        $oLinha1 = new Campo('','linha', Campo::TIPO_LINHA,12);
        $oLinha1->setApenasTela(true);
        
        //apontamentos do certificado 
        
        $oLabel1 = new campo($this->addIcone(Base::ICON_EDITAR).'Apontar valores encontrados','label1', Campo::TIPO_LABEL,12);
        $oLabel1->setApenasTela(true);
        
        $oSupDurMin = new Campo('Dur.SuperfMin','durezaSuperfMin', Campo::TIPO_DECIMAL,2);
        $oSupDurMax = new Campo('Dur.SuperfMax','durezaSuperfMax', Campo::TIPO_DECIMAL,2);
        
        $oSupEscala = new Campo('Escala','SuperEscala', Campo::CAMPO_SELECTSIMPLE,1);
        $oSupEscala->addItemSelect('HRC','HRC');
        $oSupEscala->addItemSelect('HV','HV');
        $oSupEscala->addItemSelect('HRB','HRB');
        $oSupEscala->addItemSelect('HRA','HRA');
        $oSupEscala->addItemSelect('HB','HB');
        
        $oNucDurMin = new Campo('Dur.NucMin','durezaNucMin', Campo::TIPO_DECIMAL,2);
        $oNucDurMax = new Campo('Dur.NucMax','durezaNucMax', Campo::TIPO_DECIMAL,2);
        
       
        $oNucEscala = new Campo('Escala','NucEscala', Campo::CAMPO_SELECTSIMPLE,1);
        $oNucEscala->addItemSelect('HRC','HRC');
        $oNucEscala->addItemSelect('HV','HV');
        $oNucEscala->addItemSelect('HRB','HRB');
        $oNucEscala->addItemSelect('HRA','HRA');
        $oNucEscala->addItemSelect('HB','HB');
        
        $oCamDurMin = new Campo('Exp.CamadaMin','expCamadaMin', Campo::TIPO_TESTE,2);
      
        $oCamDurMax = new Campo('Exp.CamadaMax','expCamadaMax', Campo::TIPO_TESTE,2);
        
        $oInsEneg = new Campo('Insp.Enegrecimento','inspeneg', Campo::CAMPO_SELECTSIMPLE,2);
        $oInsEneg->addItemSelect('Bom', 'Bom');
        $oInsEneg->addItemSelect('Tolerável', 'Tolerável');
        $oInsEneg->addItemSelect('Ruim', 'Ruim');
        $oInsEneg->addItemSelect('Não Aplicável', 'Não Aplicável');
        
        $oDataEmi=new Campo('Emissão','dataemissao', Campo::TIPO_TEXTO,1);
        $oDataEmi->setSValor(date('d/m/Y'));
        $oDataEmi->setBCampoBloqueado(true);
        
        $oHora = new Campo('Hora','hora', Campo::TIPO_TEXTO,1,2,12,12);
        $oHora->setBCampoBloqueado(true);
        $oHora->setBTime(true);
        $oHora->setSValor (date('H:i'));
        
        $oUser = new Campo('Usuário','usuario', Campo::TIPO_TEXTO,2,2,12,12);
        $oUser->setBCampoBloqueado(true);
        $oUser->setSValor($_SESSION['nome']);
        
        $oStatusEmail = new Campo('E-mail','sitEmail', Campo::TIPO_TEXTO,1);
        $oStatusEmail->setBCampoBloqueado(true);
        $oStatusEmail->setSValor('NãoEnv');
     
        
         //ativa o fechamento da tela ao inserir
        $this->getTela()->setBFecharTelaIncluir(true);
        
        if($oDadosOp==null){
         //adiciona os eventos ao sair do campo op e do botao pesquisar
         $sEventoOp = 'var OpSteel =  $("#'.$oOp->getId().'").val();if(OpSteel !==""){requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_Certificado","consultaOpDados",'
                 . '"'.$oEmp_codigo->getId().','.$oEmp_des->getId().','.$oCodProd->getId().','.$oProduto->getId()
                 .','.$oOpcliente->getId().','.$oPeso->getId().','.$oNotaClient->getId().','.$oQuant->getId().'");}'
                 . 'else{$("#'.$oEmp_codigo->getId().'").val(""); $("#'.$oEmp_des->getId().'").val(""); '
                 . '$("#'.$oCodProd->getId().'").val(""); $("#'.$oProduto->getId().'").val(""); '
                 . '$("#'.$oOpcliente->getId().'").val(""); $("#'.$oPeso->getId().'").val("");  '
                 . '$("#'.$oNotaClient->getId().'").val(""); $("#'.$oQuant->getId().'").val("");};';
         $oOp->addEvento(Campo::EVENTO_SAIR,$sEventoOp);
        }
        
        //busca obs do produto material receita
        if(method_exists($oDadosOp, 'getSeqmat')){//if(method_exists($oDadosOp, 'getquant'))
            $oProdMatReceita = Fabrica::FabricarController('STEEL_PCP_prodMatReceita');
            $oProdMatReceita->Persistencia->adicionaFiltro('seqmat',$oDadosOp->getSeqmat());
            $oDadosProdMat = $oProdMatReceita->Persistencia->consultarWhere();
        }
        
        //conclusão
        $oConclusao = new campo('Conclusão','conclusao', Campo::TIPO_TEXTAREA,10);
        if(method_exists($oDadosOp, 'getSeqmat')){
            $oConclusao->setSValor(''.$oDadosProdMat->getObs().'  '.$oDadosOp->getObs().'   Foram atingidas suas especificações conforme solicitado no documento de remessa.');
        }
        
        
       
        $oAbaFioMaquina = new AbaTabPanel('FIO MÁQUINA');
                   
        $oAbaLog = new AbaTabPanel('LOG');
        
        $oFioDurezaSol = new Campo('Dureza.Solicitada(HRB)','fioDurezaSol', Campo::TIPO_DECIMAL,2);
        $oFioEsferio = new campo('Esferiodização(%)','fioEsferio', Campo::TIPO_DECIMAL,2);
        $oFioDescarbonetaTotal = new campo('Descarb.Total(µm)','fioDescarbonetaTotal', Campo::TIPO_DECIMAL,2);
        $oFioDescarbonetaParcial = new campo('Descarb.Parcial(µm)','fioDescarbonetaParcial', Campo::TIPO_DECIMAL,2);
        $oDiamFinalMin = new campo('Diâmetro Final Mínimo(mm)','DiamFinalMin',Campo::TIPO_DECIMAL,3);
        $oDiamFinalMax = new campo('Diâmetro Final Máximo(mm)','DiamFinalMax',Campo::TIPO_DECIMAL,3);
        
        $oAbaPadrao->addCampos(array($oSupDurMin,$oSupDurMax,$oSupEscala),
                           array($oNucDurMin,$oNucDurMax,$oNucEscala),
                           array($oCamDurMin,$oCamDurMax,$oInsEneg)
                           );
        
        $oAbaFioMaquina->addCampos(array($oFioDurezaSol,$oFioEsferio),array($oFioDescarbonetaTotal,$oFioDescarbonetaParcial),array($oDiamFinalMin,$oDiamFinalMax));
          
        $oAbaLog->addCampos($oDataEmi,$oHora,$oUser,$oStatusEmail);
        
        $oTab->addItems($oAbaPadrao,$oAbaFioMaquina,$oAbaLog);        
        
        $this->addCampos(array($oNr,$oOp,$oNotaSteel,$oDataRetorno),
                array($oEmp_codigo,$oEmp_des),
                array($oOpcliente,$oNotaClient,$oCodProd, $oProduto),
                array($oQuant,$oPeso,$oDataEnsaio),$oLinha1,$oLabel1,
                $oLinha1,
                $oTab,$oConclusao
                );
    }

    /**
     * Cria tela modal
     */
     public function criaTelaModal($sDados) {
        parent::criaTela();
        
        $oTab = new TabPanel();
        $oAbaPadrao = new AbaTabPanel('PADRÃO');
        $this->setBTela(true);
   
        $this->addLayoutPadrao('Aba');
        
         //$sAcao =  $this->getSRotina();
        
        $oDadosOp = $this->getAParametrosExtras();
        
        //busca dados do certificado se há certificado
        
        $oCert = Fabrica::FabricarController('STEEL_PCP_Certificado');
        $oCert->Persistencia->adicionaFiltro('nrcert',$oDadosOp->getNrcert());
        $oDadosCert = $oCert->Persistencia->consultarWhere();
        
        
        
        
        
        date_default_timezone_set('America/Sao_Paulo');
       
        $oNr = new Campo('Cert.', 'nrcert', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);
        if(method_exists($oDadosOp, 'getNrcert')) 
         {$oNr->setSValor($oDadosOp->getNrcert());
         }
        
        $oOp = new Campo('Op','op',Campo::TIPO_TEXTO,2,2,12,12);
        $oOp->setSCorFundo(Campo::FUNDO_AMARELO);
        $oOp->setBCampoBloqueado(TRUE);
        
        if(method_exists($oDadosOp, 'getOp')) 
         {$oOp->setSValor($oDadosOp->getOp());
         }
        
        $oCodProd = new Campo('Produto', 'procod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCodProd->setSCorFundo(Campo::FUNDO_MONEY);
        $oCodProd->addValidacao(false, Validacao::TIPO_INTEIRO);
       // $oCodProd->setBCampoBloqueado(TRUE);
        if(method_exists($oDadosOp, 'getProd')) 
         {$oCodProd->setSValor($oDadosOp->getProd());
         $oCodProd->setBCampoBloqueado(TRUE);
         }
        
        $oProduto = new Campo('Descrição', 'prodes', Campo::TIPO_TEXTO, 4, 3, 12, 12);
        $oProduto->setSCorFundo(Campo::FUNDO_MONEY);
        $oProduto->addValidacao(false, Validacao::TIPO_STRING);
        if(method_exists($oDadosOp, 'getProdes')) 
         {$oProduto->setSValor($oDadosOp->getProdes());
         $oProduto->setBCampoBloqueado(TRUE);
         }
        
        $oDataEnsaio = new Campo('Data Ensaio', 'dataensaio', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataEnsaio->setSValor(date('d/m/Y'));
        $oDataEnsaio->addValidacao(false, Validacao::TIPO_STRING);
        
        //linha
        $oLinha1 = new Campo('','linha', Campo::TIPO_LINHA,12);
        $oLinha1->setApenasTela(true);
        
        //apontamentos do certificado 
        
        $oLabel1 = new campo($this->addIcone(Base::ICON_EDITAR).'Apontar valores encontrados','label1', Campo::TIPO_LABEL,12);
        $oLabel1->setApenasTela(true);
        
        $oSupDurMin = new Campo('Dur.SuperfMin','durezaSuperfMin', Campo::TIPO_DECIMAL,2);
        if($oDadosCert->getDurezaSuperfMin()!==null){
            $oSupDurMin->setSValor(number_format($oDadosCert->getDurezaSuperfMin(), 2, ',', '.'));
            //number_format($Quanttotal, 2, ',', '.')
        }
        
        $oSupDurMax = new Campo('Dur.SuperfMax','durezaSuperfMax', Campo::TIPO_DECIMAL,2);
        if($oDadosCert->getDurezaSuperfMax()!==null){
            $oSupDurMax->setSValor(number_format($oDadosCert->getDurezaSuperfMax(), 2, ',', '.'));
        }
        
        $oSupEscala = new Campo('Escala','SuperEscala', Campo::CAMPO_SELECTSIMPLE,1);
        $oSupEscala->addItemSelect('HRC','HRC');
        $oSupEscala->addItemSelect('HV','HV');
        $oSupEscala->addItemSelect('HRB','HRB');
        $oSupEscala->addItemSelect('HRA','HRA');
        $oSupEscala->addItemSelect('HB','HB');
        
        $oNucDurMin = new Campo('Dur.NucMin','durezaNucMin', Campo::TIPO_DECIMAL,2);
        if($oDadosCert->getDurezaNucMin()!==null){
            $oNucDurMin->setSValor(number_format($oDadosCert->getDurezaNucMin(), 2, ',', '.'));
        }
        
        $oNucDurMax = new Campo('Dur.NucMax','durezaNucMax', Campo::TIPO_DECIMAL,2);
        if($oDadosCert->getDurezaNucMax()!==null){
            $oNucDurMax->setSValor(number_format($oDadosCert->getDurezaNucMax(), 2, ',', '.'));
            //number_format($Quanttotal, 2, ',', '.')
        }
       
        $oNucEscala = new Campo('Escala','NucEscala', Campo::CAMPO_SELECTSIMPLE,1);
        $oNucEscala->addItemSelect('HRC','HRC');
        $oNucEscala->addItemSelect('HV','HV');
        $oNucEscala->addItemSelect('HRB','HRB');
        $oNucEscala->addItemSelect('HRA','HRA');
        $oNucEscala->addItemSelect('HB','HB');
        
        $oCamDurMin = new Campo('Exp.CamadaMin','expCamadaMin', Campo::TIPO_TESTE,2);
        if($oDadosCert->getExpCamadaMin()!==null){
            $oCamDurMin->setSValor($oDadosCert->getExpCamadaMin());
            //number_format($Quanttotal, 2, ',', '.')
        }
      
        $oCamDurMax = new Campo('Exp.CamadaMax','expCamadaMax', Campo::TIPO_TESTE,2);
        if($oDadosCert->getExpCamadaMax()!==null){
            $oCamDurMax->setSValor($oDadosCert->getExpCamadaMax());
            //number_format($Quanttotal, 2, ',', '.')
        }
        
        $oInsEneg = new Campo('Insp.Enegrecimento','inspeneg', Campo::CAMPO_SELECTSIMPLE,2);
        $oInsEneg->addItemSelect('Bom', 'Bom');
        $oInsEneg->addItemSelect('Tolerável', 'Tolerável');
        $oInsEneg->addItemSelect('Ruim', 'Ruim');
        $oInsEneg->addItemSelect('Não Aplicável', 'Não Aplicável');
        
        $oDataEmi=new Campo('Emissão','dataemissao', Campo::TIPO_TEXTO,1);
        $oDataEmi->setSValor(date('d/m/Y'));
        $oDataEmi->setBCampoBloqueado(true);
        
        $oHora = new Campo('Hora','hora', Campo::TIPO_TEXTO,1,2,12,12);
        $oHora->setBCampoBloqueado(true);
        $oHora->setBTime(true);
        $oHora->setSValor (date('H:i'));
        
        $oUser = new Campo('Usuário','usuario', Campo::TIPO_TEXTO,2,2,12,12);
        $oUser->setBCampoBloqueado(true);
        $oUser->setSValor($_SESSION['nome']);
        
        $oStatusEmail = new Campo('E-mail','sitEmail', Campo::TIPO_TEXTO,1);
        $oStatusEmail->setBCampoBloqueado(true);
        $oStatusEmail->setSValor('NãoEnv');
     
        
         //ativa o fechamento da tela ao inserir
        $this->getTela()->setBFecharTelaIncluir(true);
        
       //busca obs do produto material receita
        $oProdMatReceita = Fabrica::FabricarController('STEEL_PCP_prodMatReceita');
        $oProdMatReceita->Persistencia->adicionaFiltro('seqmat',$oDadosOp->getSeqmat());
        $oDadosProdMat = $oProdMatReceita->Persistencia->consultarWhere();
        
        //conclusão
        $oConclusao = new campo('Conclusão','conclusao', Campo::TIPO_TEXTAREA,10);
        if($oDadosCert->getConclusao()!== null){
            $oConclusao->setSValor(''.$oDadosProdMat->getObs().'   '.$oDadosOp->getObs().'  '.$oDadosCert->getConclusao());
        }else{
            $oConclusao->setSValor(''.$oDadosProdMat->getObs().'  '.$oDadosOp->getObs().'  '.$oDadosCert->getConclusao().' Foram atingidas suas especificações conforme solicitado no documento de remessa.');
        }
        
        $oAbaFioMaquina = new AbaTabPanel('FIO MÁQUINA');
                   
        $oAbaLog = new AbaTabPanel('LOG');
        
        $oFioDurezaSol = new Campo('Dureza.Solicitada(HRB)','fioDurezaSol', Campo::TIPO_DECIMAL,2);
        if($oDadosCert->getFioDurezaSol()!==null){
            $oFioDurezaSol->setSValor(number_format($oDadosCert->getFioDurezaSol(), 2, ',', '.'));
             //number_format($Quanttotal, 2, ',', '.')
            
        }
        $oFioEsferio = new campo('Esferiodização(%)','fioEsferio', Campo::TIPO_DECIMAL,2);
        if($oDadosCert->getFioEsferio()!==null){
            $oFioEsferio->setSValor(number_format($oDadosCert->getFioEsferio(), 2, ',', '.'));
            //number_format($Quanttotal, 2, ',', '.')
        }
        
        $oFioDescarbonetaTotal = new campo('Descarb.Total(µm)','fioDescarbonetaTotal', Campo::TIPO_DECIMAL,2);
        if($oDadosCert->getFioDescarbonetaTotal()!==null){
            $oFioDescarbonetaTotal->setSValor(number_format($oDadosCert->getFioDescarbonetaTotal(), 2, ',', '.'));
            
        }
        $oFioDescarbonetaParcial = new campo('Descarb.Parcial(µm)','fioDescarbonetaParcial', Campo::TIPO_DECIMAL,2);
        if($oDadosCert->getFioDescarbonetaParcial()!==null){
            $oFioDescarbonetaParcial->setSValor(number_format($oDadosCert->getFioDescarbonetaParcial(), 2, ',', '.'));
        }
        $oDiamFinalMin = new campo('Diâmetro Final Mínimo(mm)','DiamFinalMin',Campo::TIPO_DECIMAL,3);
        if($oDadosCert->getDiamFinalMin()!==null){
            $oDiamFinalMin->setSValor(number_format($oDadosCert->getDiamFinalMin(), 2, ',', '.'));
        }
        $oDiamFinalMax = new campo('Diâmetro Final Máximo(mm)','DiamFinalMax',Campo::TIPO_DECIMAL,3);
        if($oDadosCert->getDiamFinalMax()!==null){
            $oDiamFinalMax->setSValor(number_format($oDadosCert->getDiamFinalMax(), 2, ',', '.'));
        }
        
        $oAbaPadrao->addCampos(array($oSupDurMin,$oSupDurMax,$oSupEscala),
                           array($oNucDurMin,$oNucDurMax,$oNucEscala),
                           array($oCamDurMin,$oCamDurMax,$oInsEneg)
                           );
        
        $oAbaFioMaquina->addCampos(array($oFioDurezaSol,$oFioEsferio),array($oFioDescarbonetaTotal,$oFioDescarbonetaParcial),array($oDiamFinalMin,$oDiamFinalMax));
          
        $oAbaLog->addCampos($oDataEmi,$oHora,$oUser,$oStatusEmail);
        
        //$oTab->addItems($oAbaPadrao,$oAbaFioMaquina,$oAbaLog);
        if($oDadosOp->getTipoOrdem()=='P'){
             $oAbaPadrao->setBActive(true);
            $oTab->addItems($oAbaPadrao,$oAbaLog);
        }
        if($oDadosOp->getTipoOrdem()=='F' || $oDadosOp->getTipoOrdem()=='A'){
            $oAbaFioMaquina->setBActive(true);
            $oTab->addItems($oAbaFioMaquina,$oAbaLog);
        }
        
        //evento sair da op
        $oOp->addEvento(Campo::EVENTO_SAIR,'$("#'.$oSupDurMin->getId().'").focus();');
        
        $oBtnInserir = new Campo('Gravar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","geraCertCarga",'  //acaoIncluirDetSteel  pedAcaoDetalheIten
               . '"'.$this->getTela()->getId().'-form,'.$oOp->getId().','.$sDados.'","modalAponta,");';
        $oBtnInserir->getOBotao()->addAcao($sAcao);
        
        $this->addCampos(array($oNr,$oOp,$oCodProd, $oProduto,$oDataEnsaio),
                $oTab,$oConclusao,$oBtnInserir
                );
    }


}
