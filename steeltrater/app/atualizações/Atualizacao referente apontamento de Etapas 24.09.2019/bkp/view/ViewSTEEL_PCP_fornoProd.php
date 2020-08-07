<?php

/* 
 *Classe que implementa a view 
 * @author Avanei Martendal
 * @since 28/08/2018
 */

class ViewSTEEL_PCP_fornoProd extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oProd = new CampoConsulta('Produto','prod');
        $oProd->setILargura(50);
        $oFornoCod = new CampoConsulta('Cod.Forno','STEEL_PCP_Forno.fornocod');
        $oFornoCod->setILargura(50);
        $oFornoDes = new CampoConsulta('Forno','STEEL_PCP_Forno.fornodes');
        
        $oProdFiltro = new Filtro($oProd, Filtro::CAMPO_TEXTO_IGUAL,2);
        $oFornoCodFiltro = new Filtro($oFornoCod, Filtro::CAMPO_TEXTO_IGUAL,2);
        $oFornoDesFiltro = new Filtro($oFornoDes, Filtro::CAMPO_TEXTO_IGUAL,2);
        
        $this->addFiltro($oProdFiltro, $oFornoCodFiltro,$oFornoDesFiltro);
        
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        
        $this->addCampos($oProd,$oFornoCod,$oFornoDes);
    }
  
    public function criaTela() {
        parent::criaTela();
        
        
        $aFornos = $this->getAParametrosExtras();
         //campo código do produto
        $oCodigo = new Campo('Produto','prod',Campo::TIPO_BUSCADOBANCOPK,2);
        $oCodigo->addValidacao(false, Validacao::TIPO_STRING);
         
         
        
        //campo descrição do produto adicionando o campo de busca
        $oProdes = new Campo('...','prodes',Campo::TIPO_BUSCADOBANCO, 4);
        $oProdes->setSIdPk($oCodigo->getId());
        $oProdes->setClasseBusca('DELX_PRO_Produtos');
        $oProdes->addCampoBusca('pro_codigo', '','');
        $oProdes->addCampoBusca('pro_descricao', '','');
        $oProdes->setSIdTela($this->getTela()->getId());
        $oProdes->setApenasTela(true);
        
        
        
        
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodigo->setClasseBusca('DELX_PRO_Produtos');
        $oCodigo->setSCampoRetorno('pro_codigo',$this->getTela()->getId());
        $oCodigo->addCampoBusca('pro_descricao',$oProdes->getId(),  $this->getTela()->getId());
        
        $oLabel1 = new Campo('Fornos / Linhas disponíveis','lbl1', Campo::TIPO_LABEL,12);
        $oLabel1->setApenasTela(true);
        $oLabel1->setIMarginTop(10);
        $oLinha1 = new campo('','lnha1', Campo::TIPO_LINHA,12);
        $oLinha1->setApenasTela(true);
        $oLinha2 = new campo('','lnha2', Campo::TIPO_LINHA,12);
        $oLinha2->setApenasTela(true);
        $this->addCampos(array($oCodigo,$oProdes),$oLinha1,$oLabel1,$oLinha2);
           
        $iCont =0;
        foreach ($aFornos as $key => $oForno) {
           
           $sObjeto = '$oFornos'.$key;
           $sObjeto = new Campo($oForno->getFornodes(),$oForno->getFornocod(), Campo::TIPO_CHECK,4);
           $aObj[]=$sObjeto;
           if($iCont==1){
               $this->addCampos(array($aObj[0],$aObj[1]));
               $aObj=array();
               $iCont =0;
           }else{$iCont++;}
          }
          //analisa se sobrou um registro 
             $iconta = count($aObj);
             if(count($aObj)==1){
               $this->addCampos(array($aObj[0]));  
               $aObj=array();
             }
        
         /*Botão para inserir no banco de dados*/
        $oBotConf = new Campo('Atualizar fornos do produto','',  Campo::TIPO_BOTAOSMALL_SUB,3);
        
       //id form,id incremento,id do grid, id focus,    
        $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","inserirFornos",'
                . '"'.$this->getTela()->getId().'-form,");';//'.$oSeq->getId().','.$sGrid.','.$oTrat->getId().'","'.$oCod->getSValor().',
        //$oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        
        $oLinha3 = new campo('','lnha3', Campo::TIPO_LINHA,12);
        $oLinha3->setApenasTela(true);
        
        $this->addCampos($oLinha3,$oBotConf);
        
        //oculta os botões
        $this->setBOcultaBotTela(true);
        
        
    }
}

