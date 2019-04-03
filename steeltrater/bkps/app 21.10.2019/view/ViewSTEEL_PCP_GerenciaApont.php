<?php

/* 
 * Classe que implementa STEEL_PCP_GerenciaApont
 * 
 * @author Cleverton Hoffmann
 * @since 06/08/2018
 */

class ViewSTEEL_PCP_GerenciaApont extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oOp = new CampoConsulta('Op','op');
        $oSeq = new CampoConsulta('Seq','seq');
        $oCodForno = new CampoConsulta('Cod.Forno','fornocod');
        $oDesForno = new CampoConsulta('Forno','fornodes');
        $oCodProd = new CampoConsulta('Cod.Prod.','procod');
        $oDesProd = new CampoConsulta('Descrição','prodes');
        $oDataEnt = new CampoConsulta('Data Ent.','dataent_forno', CampoConsulta::TIPO_DATA);
        $oHoraEnt = new CampoConsulta('Hora Ent.','horaent_forno');
        $oDataSai = new CampoConsulta('Data Saida','datasaida_forno', CampoConsulta::TIPO_DATA);
        $oHoraSai = new CampoConsulta('Hora Saida','horasaida_forno');
        $oSituacao = new CampoConsulta('Situação', 'situacao');
        
        $oSituacao->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
        $oSituacao->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO,CampoConsulta::MODO_COLUNA);
        $oSituacao->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
        
        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO_IGUAL,1);
        $oSeqFiltro = new Filtro($oSeq, Filtro::CAMPO_TEXTO_IGUAL,1);
        $oFornoFiltro = new Filtro($oCodForno, Filtro::CAMPO_TEXTO_IGUAL,1);
        $oCodProdFiltro = new Filtro($oCodProd, Filtro::CAMPO_TEXTO_IGUAL,1);
        $oSituafiltro = new Filtro($oSituacao, Filtro::CAMPO_TEXTO,2);
        $this->addFiltro($oOpFiltro,$oSeqFiltro,$oFornoFiltro,$oCodProdFiltro,$oSituafiltro);
        
        $this->addCampos($oOp,$oSeq,$oCodForno,$oDesForno,$oSituacao,$oCodProd,
                $oDesProd,$oDataEnt,$oHoraEnt,$oDataSai,$oHoraSai);
    }
    
    public function criaTela() {
        parent::criaTela();
              
        $oOp = new Campo('Op nº.','op', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq = new Campo('Seq','seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setSValor(1);
        $oSeq->setBCampoBloqueado(true);
        // $oCodForno = new Campo('Cod.Forno','fornocod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        //$oDesForno = new Campo('Forno','fornodes', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCodProd = new Campo('Cod.Prod.','procod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDesProd = new Campo('Descrição','prodes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
       
        
                
         //Cod. forno
        $oCodForno = new Campo('Cod.Forno','fornocod',Campo::TIPO_BUSCADOBANCOPK,2);
        $oCodForno->setSValor('');
        $oCodForno->addValidacao(false, Validacao::TIPO_STRING);
        
        //Forno
        $oDesForno = new Campo('Forno','fornodes',Campo::TIPO_BUSCADOBANCO, 4);
        $oDesForno->setSIdPk($oCodForno->getId());
        $oDesForno->setClasseBusca('STEEL_PCP_Forno');
        $oDesForno->addCampoBusca('fornocod', '','');
        $oDesForno->addCampoBusca('fornodes', '','');
        $oDesForno->setSIdTela($this->getTela()->getId());
        $oDesForno->setSValor('');
        $oDesForno->addValidacao(false, Validacao::TIPO_STRING);
        
        //declarar o campo descrição do forno
        $oCodForno->setClasseBusca('STEEL_PCP_Forno');
        $oCodForno->setSCampoRetorno('fornocod',$this->getTela()->getId());
        $oCodForno->addCampoBusca('fornodes',$oDesForno->getId(),  $this->getTela()->getId());
      
        $oSituacao = new Campo('Situação', 'situacao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSituacao->addItemSelect('Finalizado', 'Finalizado');
        $oSituacao->addItemSelect('Processo', 'Processo');
               
        $oDataEnt = new Campo('Data Entrada', 'dataent_forno', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataEnt->setSValor(Util::getPrimeiroDiaMes());
        $oDataEnt->addValidacao(false, Validacao::TIPO_STRING);
        $oDataSai = new Campo('Data Saída', 'datasaida_forno', Campo::TIPO_DATA, 2, 2, 12, 12);
        //$oDataSai->setSValor(Util::getDataAtual());
        
        $oHoraEnt = new Campo('Hora de Entrada', 'horaent_forno', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oHoraEnt->setBTime(true);
        $oHoraEnt->addValidacao(false, Validacao::TIPO_STRING);
        $oHoraSai = new Campo('Hora de Saída', 'horasaida_forno', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oHoraSai->setBTime(true);        
        
        //$oCodProd->setClasseBusca('STEEL_PCP_OrdensFab');
        //$oCodProd->setSCampoRetorno('op',$this->getTela()->getId());
        //$oCodProd->addCampoBusca('prod', $oDesProd->getId(), $this->getTela()->getId());
       
        $sBuscaProd ='var recod = $("#'.$oOp->getId().'").val();if(recod!==""){'
                . 'requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_OrdensFab","buscaProduto","'.$oCodProd->getId().','.$oDesProd->getId().'");}';
        $oOp->addEvento(Campo::EVENTO_SAIR,$sBuscaProd);           
  
        $this->addCampos(array($oOp,$oSeq,$oCodProd,$oDesProd),array($oCodForno,$oDesForno),
                array($oDataEnt,$oDataSai),array($oHoraEnt,$oHoraSai),$oSituacao);
    } 
}
