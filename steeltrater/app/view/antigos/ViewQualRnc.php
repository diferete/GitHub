<?php

/* 
 * Implemanta a view da classe QualRnc
 * @author Avanei Martendal
 * @since 10/09/2017
 */


class ViewQualRnc extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oNr = new CampoConsulta('Nr','nr');
        $oCliente = new CampoConsulta('Cliente','empdes');
        $oOfficeDes = new CampoConsulta('Representante','officedes');
        
        $oData = new CampoConsulta('Data','datains', CampoConsulta::TIPO_DATA);
        
        
        
        $oSit = new CampoConsulta('Sit','situaca');
        $oSit->addComparacao('Liberado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);
        $oSit->addComparacao('Representante', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_LINHA);
        
        $oDropDow = new Dropdown('Liberações', Dropdown::TIPO_SUCESSO);
        $oDropDow->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR).'Liberar Metalbo','QualRnc','msgliberaMet','', false,'');
                
        $oDropDow1 = new Dropdown('Visualizar', Dropdown::TIPO_PRIMARY);
        $oDropDow1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM).'Visualizar', 'QualRncVenda', 'acaoMostraRelConsulta','', false, 'rc');    
     
        
        $this->setUsaDropdown(true);
        $this->addDropdown($oDropDow,$oDropDow1);
        
        $oFilCli = new Filtro($oCliente, Filtro::CAMPO_TEXTO,3);
        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO,1);
        $this->addFiltro($oFilNr,$oFilCli);
        $this->addCampos($oNr,$oCliente,$oOfficeDes,$oData,$oSit);
        $this->setBScrollInf(true);
        $this->setUsaAcaoExcluir(false);
    }
    
    public function criaTela() {
        parent::criaTela();
       
        $oField = new FieldSet('Informações');
        $oField->setOculto(true);
        
        $oFilcgc = new Campo('','filcgc', Campo::TIPO_TEXTO,1);
        $oFilcgc->setSValor('75483040000211');
        $oFilcgc->setBCampoBloqueado(true);
        $oFilcgc->setBOculto(true);
        
        $oNr = new Campo('','nr', Campo::TIPO_TEXTO,1);
        $oNr->setBCampoBloqueado(true);
        $oNr->setBOculto(true);
        
        $oUsucodigo = new Campo('','usucodigo', Campo::TIPO_TEXTO,1);
        $oUsucodigo->setSValor($_SESSION['codUser']);
        $oUsucodigo->setBCampoBloqueado(true);
        $oUsucodigo->setBOculto(true);
        
        $oUsunome = new campo('','usunome', Campo::TIPO_TEXTO,1);
        $oUsunome->setSValor($_SESSION['nome']);
        $oUsunome->setBCampoBloqueado(true);
        $oUsunome->setBOculto(true);
        
        $oDataIns = new Campo('','datains', Campo::TIPO_TEXTO,1);
        $oDataIns->setSValor(date('d/m/Y'));
        $oDataIns->setBCampoBloqueado(true);
        $oDataIns->setBOculto(true);
        
        $oHora = new campo('','horains', Campo::TIPO_TEXTO,1);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);
        $oHora->setBOculto(true);
        
        //cliente
        $oEmpcod = new Campo('...','Pessoa.empcod', Campo::TIPO_BUSCADOBANCOPK,2);
        $oEmpcod->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpcod->setBFocus(true);
        $oEmpcod->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '3');
        
        $oEmpdes = new Campo('Cliente','empdes', Campo::TIPO_BUSCADOBANCO,4);
        $oEmpdes->setSIdPk($oEmpcod->getId());
        $oEmpdes->setClasseBusca('Pessoa');
        $oEmpdes->addCampoBusca('empcod', '','');
        $oEmpdes->addCampoBusca('empdes', '','');
        $oEmpdes->setSIdTela($this->getTela()->getid());
        $oEmpdes->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oEmpcod->setClasseBusca('Pessoa');
        $oEmpcod->setSCampoRetorno('empcod', $this->getTela()->getid());
        $oEmpcod->addCampoBusca('empdes',$oEmpdes->getId(),  $this->getTela()->getId());
        
        //responsável por vendas
        $oRespVenda = new campo('...','resp_venda_cod', Campo::TIPO_BUSCADOBANCOPK,1,1,1,1);
        $oRespVenda->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        
       
        $oRespVendaNome = new Campo('Resp. Vendas','resp_venda_nome', Campo::TIPO_BUSCADOBANCO,3,3,3,3);
        $oRespVendaNome->setSIdPk($oRespVenda->getId());
        $oRespVendaNome->setClasseBusca('User');
        $oRespVendaNome->addCampoBusca('usucodigo', '','');
        $oRespVendaNome->addCampoBusca('usunome', '','');
        $oRespVendaNome->setSIdTela($this->getTela()->getid());
        
        $oRespVenda->setClasseBusca('User');
        $oRespVenda->setSCampoRetorno('usucodigo',$this->getTela()->getId());
        $oRespVenda->addCampoBusca('usunome',$oRespVendaNome->getId(),  $this->getTela()->getId());
        
        $oFieldContato = new FieldSet('Informações contato');
        
        $oContato = new campo('Contato','contato', Campo::TIPO_TEXTO,2);
        
        $oCelular = new Campo('Celular','celular', Campo::TIPO_TEXTO,2);
        $oEmail = new campo('E-mail','email', Campo::TIPO_TEXTO,2);
        $oEmail->addValidacao(true, Validacao::TIPO_EMAIL);
        
        $oInd = new campo('Indústria','ind', Campo::TIPO_CHECK,1);
        $oInd->setIMarginTop(15);
        $oComer = new campo('Comércio','comer', Campo::TIPO_CHECK,1);
        $oComer->setIMarginTop(15);
        
        $oFieldContato->addCampos(array($oContato,$oCelular,$oEmail,$oInd,$oComer));
        
        /*dados da nota fiscal*/
        $oFieldNf = new FieldSet('Nota fiscal');
        $oNf = new Campo('Nota fiscal','nf', Campo::TIPO_TEXTO,1);
        $oNf->setSCorFundo(Campo::FUNDO_MONEY);
        $oNf->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', 2);
        
        $oDataNf = new Campo('Data.Nf','datanf', Campo::TIPO_TEXTO,1);
        $oOdCompra = new Campo('Od.Compra','odcompra', Campo::TIPO_TEXTO,1);
        $oPedido = new campo('Pedido','odcompra', Campo::TIPO_TEXTO,1);
        $oValor = new campo('Valor','valor', Campo::TIPO_TEXTO,1);
        $oPeso = new campo('Peso','peso', Campo::TIPO_TEXTO,1);
        
         $sCallBack = 'requestAjax("'.$this->getTela()->getId().'-form","QualRnc","buscaNf","'.$oDataNf->getId().','.$oValor->getId().','.$oPeso->getId().'");';
        
        $oNf->addEvento(Campo::EVENTO_SAIR, $sCallBack);
        
        $oFieldNf->addCampos(array($oNf,$oDataNf,$oOdCompra,$oPedido,$oValor,$oPeso));
        
        $oFieldEmb = new FieldSet('Embalagem');
        $oLote = new Campo('Nº Lote','lote', Campo::TIPO_TEXTO,2);
        $oOp = new Campo('Ordem Produção','op', Campo::TIPO_TEXTO,2);
        $oFieldEmb->addCampos(array($oLote,$oOp));
        
        $oDescNaoConf = new Campo('Descrição da não conformidade','naoconf', Campo::TIPO_TEXTAREA,9);
        $oDescNaoConf->setILinhasTextArea(5);
        $oDescNaoConf->setSCorFundo(Campo::FUNDO_MONEY);

        $oDadosProduto = new FieldSet('Dados do produto');
        
         //campo código do produto
        $oCodigo = new Campo('Codigo','procod',Campo::TIPO_BUSCADOBANCOPK,2);
        $oCodigo->setSIdHideEtapa($this->getSIdHideEtapa());
        $oCodigo->setITamanho(Campo::TAMANHO_PEQUENO);
        
        
        //campo descrição do produto adicionando o campo de busca
        $oProdes = new Campo('Produto','prodes',Campo::TIPO_BUSCADOBANCO, 3);
        $oProdes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oProdes->setSIdPk($oCodigo->getId());
        $oProdes->setClasseBusca('Produto');
        $oProdes->addCampoBusca('procod', '','');
        $oProdes->addCampoBusca('prodes', '','');
        $oProdes->setSIdTela($this->getTela()->getid());
        
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodigo->setClasseBusca('Produto');
        $oCodigo->setSCampoRetorno('procod',$this->getTela()->getId());
        $oCodigo->addCampoBusca('prodes',$oProdes->getId(),  $this->getTela()->getId());
        
        $oAplicacao = new Campo('Aplicação','aplicacao', Campo::TIPO_TEXTO,2);
        $oQuant = new Campo('Quantidade','quant', Campo::TIPO_TEXTO,1);
        
        $oQuanNconf = new Campo('Quant. não conforme','quantnconf', Campo::TIPO_TEXTO,2);
        
        $oAceito = new Campo('Aceito condicionalmente','aceitocond', Campo::TIPO_CHECK,2);
        $oAceito->setIMarginTop(15);
        $oReprovar = new Campo('Reprovar','reprovar', Campo::TIPO_CHECK,2);
        $oReprovar->setIMarginTop(15);
        
        $oDadosProduto->addCampos(array($oCodigo,$oProdes,$oQuant,$oAplicacao),array($oQuanNconf,$oAceito,$oReprovar));
        
        $oDataAbertura = new Campo('Data','data', Campo::TIPO_DATA,2);
        $oDataAbertura->setSValor(date('d/m/Y'));
        
        $oResp = new Campo('Responsável','nome', Campo::TIPO_TEXTO,3);
        $oResp->setSValor($_SESSION['nome']);
        $oResp->setIMarginTop(3);
        
        $oAnexos = new FieldSet('Anexos');
        
        $oAnexo1 = new Campo('Anexo1','anexo1', Campo::TIPO_UPLOAD,2);
        $oAnexo2 = new Campo('Anexo2','anexo2', Campo::TIPO_UPLOAD,2);
        $oAnexo3 = new Campo('Anexo3','anexo3', Campo::TIPO_UPLOAD,2);
        
        $oAnexos->addCampos(array($oAnexo1,$oAnexo2,$oAnexo3));
        $oAnexos->setOculto(true);
        
       
        $oOfficecod = new Campo('','officecod', Campo::TIPO_TEXTO,1);
        $oOfficecod->setSValor($_SESSION['repoffice']);
        $oOfficecod->setBOculto(true);
        
        $oOfficeDes = new Campo('','officedes', Campo::TIPO_TEXTO,2);
        $oOfficeDes->setSValor($_SESSION['repofficedes']);
        $oOfficeDes->setBOculto(true);
        
        //situacao
        $oSituaca = new Campo('','situaca', Campo::TIPO_TEXTO,1);
        $oSituaca->setSValor('Representante');
        $oSituaca->setBOculto(true);
      
         //seta ids uploads para enviar no request para limpar
        $this->setSIdUpload(','.$oAnexo1->getId().','.$oAnexo2->getId().','.$oAnexo3->getId());
        
        
                 
    /*$this->adicionaRelacionamento('situaca','situaca');
        
        $this->adicionaRelacionamento('obsSit','obsSit');*/
    
      
        
        $this->addCampos(array($oEmpcod,$oEmpdes),array($oRespVenda,$oRespVendaNome),$oFieldContato,$oFieldNf,$oFieldEmb,$oDescNaoConf,$oDadosProduto,array($oDataAbertura,$oResp),$oAnexos,
                array($oFilcgc,$oNr,$oUsucodigo,$oUsunome,$oDataIns,$oHora,$oOfficecod,$oOfficeDes,$oSituaca));
    }
    
    
}
