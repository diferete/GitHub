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
        $oHoraEnt = new CampoConsulta('Hora Ent.','horaent_forno', CampoConsulta::TIPO_TIME);
        $oDataSai = new CampoConsulta('Data Saida','datasaida_forno', CampoConsulta::TIPO_DATA);
        $oHoraSai = new CampoConsulta('Hora Saida','horasaida_forno', CampoConsulta::TIPO_TIME);
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

        $this->getTela()->setBUsaCarrGrid(true);
        
        $this->addCampos($oOp,$oSeq,$oCodForno,$oDesForno,$oSituacao,$oCodProd,
                $oDesProd,$oDataEnt,$oHoraEnt,$oDataSai,$oHoraSai);
        
        $this->getTela()->setiAltura(650);
    }
    
    public function criaTela() {
        parent::criaTela();
              
        $oOp = new Campo('Op nº.','op', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oOp->addValidacao(false, Validacao::TIPO_STRING);
        $oSeq = new Campo('Seq','seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);
        $oCodProd = new Campo('Cod.Prod.','procod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCodProd->setBCampoBloqueado(true);
        $oDesProd = new Campo('Descrição','prodes', Campo::TIPO_TEXTO, 4, 4, 12, 12);        
        $oDesProd->setBCampoBloqueado(true);
                
         //Cod. forno
        $oCodForno = new Campo('Cod.Forno','fornocod',Campo::TIPO_BUSCADOBANCOPK,2);
        $oCodForno->setSValor('');
        $oCodForno->addValidacao(false, Validacao::TIPO_STRING);
        
        //Forno
        $oDesForno = new Campo('Descrição Forno','fornodes',Campo::TIPO_BUSCADOBANCO, 4);
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
        $oSituacao->addItemSelect('Processo', 'Processo');
        $oSituacao->addItemSelect('Finalizado', 'Finalizado');
    //    $oSituacao->addItemSelect('Retornado', 'Retornado');
               
        $oDataEnt = new Campo('Data Entrada', 'dataent_forno', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataEnt->setSValor(Util::getPrimeiroDiaMes());
        $oDataEnt->addValidacao(false, Validacao::TIPO_STRING);
        $oDataSai = new Campo('Data Saída', 'datasaida_forno', Campo::TIPO_DATA, 2, 2, 12, 12);
        
        $oHoraEnt = new Campo('Hora de Entrada', 'horaent_forno', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oHoraEnt->setBTime(true);
        $oHoraEnt->addValidacao(false, Validacao::TIPO_STRING);
        $oHoraSai = new Campo('Hora de Saída', 'horasaida_forno', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oHoraSai->setBTime(true);           
        
        //user entrada
        $oUserEntcodigo = new Campo('Cod.Usuário Entrada','coduser',Campo::TIPO_BUSCADOBANCOPK,2);
        $oUserEntcodigo->setSValor('');
        $oUserEntcodigo->addValidacao(false, Validacao::TIPO_STRING);
        
        //campo descrição do usuário
        $oUserEntdes = new Campo('Descrição','usernome',Campo::TIPO_BUSCADOBANCO, 4);
        $oUserEntdes->setSIdPk($oUserEntcodigo->getId());
        $oUserEntdes->setClasseBusca('MET_TEC_Usuario');
        $oUserEntdes->addCampoBusca('usucodigo', '','');
        $oUserEntdes->addCampoBusca('usunome', '','');
        $oUserEntdes->setSIdTela($this->getTela()->getId());
        $oUserEntdes->setSValor('');
        $oUserEntdes->addValidacao(false, Validacao::TIPO_STRING);
        
        //declarar o campo descrição
        $oUserEntcodigo->setClasseBusca('MET_TEC_Usuario');
        $oUserEntcodigo->setSCampoRetorno('usucodigo',$this->getTela()->getId());
        $oUserEntcodigo->addCampoBusca('usunome',$oUserEntdes->getId(),  $this->getTela()->getId());
                
        //user saida
        $oUserSaicodigo = new Campo('Cod.Usuário Saída','codusersaida',Campo::TIPO_BUSCADOBANCOPK,2);
        $oUserSaicodigo->setSValor('');
        
        //campo descrição do usuário
        $oUserSaides = new Campo('Descrição','usernomesaida',Campo::TIPO_BUSCADOBANCO, 4);
        $oUserSaides->setSIdPk($oUserSaicodigo->getId());
        $oUserSaides->setClasseBusca('MET_TEC_Usuario');
        $oUserSaides->addCampoBusca('usucodigo', '','');
        $oUserSaides->addCampoBusca('usunome', '','');
        $oUserSaides->setSIdTela($this->getTela()->getId());
        $oUserSaides->setSValor('');
        
        //declarar o campo descrição
        $oUserSaicodigo->setClasseBusca('MET_TEC_Usuario');
        $oUserSaicodigo->setSCampoRetorno('usucodigo',$this->getTela()->getId());
        $oUserSaicodigo->addCampoBusca('usunome',$oUserSaides->getId(),  $this->getTela()->getId());
        
        $oTurno = new campo('Turno','turnoSteel', Campo::CAMPO_SELECTSIMPLE,2,2,2,2);
        $oTurno->addItemSelect('Turno A','Turno A');
        $oTurno->addItemSelect('Turno B','Turno B');
        $oTurno->addItemSelect('Turno C','Turno C');
        $oTurno->addItemSelect('Turno D','Turno D');  
        
        $oLinha1 = new campo('','linha', Campo::TIPO_LINHABRANCO,12,12,12,12);
        $oLinha1->setApenasTela(true);
        
        $oFieldE = new FieldSet('Entrada');
        $oFieldE->addCampos( array($oUserEntcodigo,$oUserEntdes),$oLinha1,array($oDataEnt,$oHoraEnt));
        $oFieldE->setOculto(FALSE);
        
        $oFieldS = new FieldSet('Saída');
        $oFieldS->addCampos( array($oUserSaicodigo,$oUserSaides),$oLinha1, array($oDataSai,$oHoraSai));
        $oFieldS->setOculto(FALSE);
        
        $sBuscaProd ='var recod = $("#'.$oOp->getId().'").val();if(recod!==""){'
                . 'requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_OrdensFab","buscaProduto","'.$oCodProd->getId().','.$oDesProd->getId().'");}';
        $oOp->addEvento(Campo::EVENTO_SAIR,$sBuscaProd);           
  
       
        
        $this->addCampos(array($oOp,$oSeq,$oCodProd,$oDesProd), $oLinha1, array($oCodForno,$oDesForno),$oLinha1, $oFieldE,$oLinha1, $oFieldS, array($oSituacao, $oTurno));
    } 
}
