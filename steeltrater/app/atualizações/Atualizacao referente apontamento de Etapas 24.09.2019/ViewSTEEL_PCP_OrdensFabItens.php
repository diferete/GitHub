<?php

/* 
 *Classe que implementa a view da produção steeltrater
 * @author Avanei Martendal
 * 
 * @since 25/06/2018
 */
class ViewSTEEL_PCP_OrdensFabItens extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oOp = new CampoConsulta('Op','op');
        
        $this->addCampos($oOp);
    }
    
     public function gridApontaEtapa() {
         $oGridEtapa = new Grid("");
        
       
         $oOpGrid = new CampoConsulta('Op','op');
         
          //botao que inicia um processo
         $oBotaoStart = new CampoConsulta('', 'iniciarEtapa', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_BOTAOSUCCES);
         $oBotaoStart->setBHideTelaAcao(true);
         $oBotaoStart->setILargura(15);
         $oBotaoStart->setSTitleAcao('Inicia etapa do apontamento!');
         $oBotaoStart->addAcao('STEEL_PCP_OrdensFabApontEtapas', 'criaTelaModalApontaIniciar', 'modalApontaIniciar');
         $oBotaoStart->setSTituloBotaoModal('INICIAR');
        
         $oBotaoFinalizar = new CampoConsulta('Finalizar etapa', 'finalizarEtapa', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_BOTAOPRIMARY );
         $oBotaoFinalizar->setBHideTelaAcao(true);
         $oBotaoFinalizar->setILargura(15);
         $oBotaoFinalizar->setSTitleAcao('Finaliza etapa!');
         $oBotaoFinalizar->addAcao('STEEL_PCP_OrdensFabApontEtapas', 'criaTelaModalApontaFinalizar', 'modalApontaFinalizar');
         $oBotaoFinalizar->setSTituloBotaoModal('FINALIZAR');
        
         //botao que retorna um processo
         $oBotaoRetornar = new CampoConsulta('Retornar etapa', 'retornarEtapa', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_BOTAODANGER );
         $oBotaoRetornar->setBHideTelaAcao(true);
         $oBotaoRetornar->setILargura(15);
         $oBotaoRetornar->setSTitleAcao('Retorna apontamento!');
         $oBotaoRetornar->addAcao('STEEL_PCP_OrdensFabApontEtapas', 'retornaApontamento', '');
         $oBotaoRetornar->setSTituloBotaoModal('RETORNAR');
         
        
         
         $oReceitaSeq = new CampoConsulta('Etapa','receita_seq');
         $oTratamento = new CampoConsulta('Tratamento','STEEL_PCP_Tratamentos.tratdes');
         $oTratamento->setILargura(280);
         $oFornodesConsulta = new CampoConsulta('Forno/Trefila','fornodes');
         $oDataEntConsulta = new CampoConsulta('Data Ent.','dataent_forno', CampoConsulta::TIPO_DATA);
         $oHoraEntConsulta = new CampoConsulta('Hora Ent.','horaent_forno', CampoConsulta::TIPO_TIME);
         $oDataSaidaConsulta = new CampoConsulta('Data Saída','datasaida_forno', CampoConsulta::TIPO_DATA);
         $oHoraSaidaConsulta = new CampoConsulta('Hora Saída','horasaida_forno', CampoConsulta::TIPO_TIME);
         
         $oSituacaoConsulta = new CampoConsulta('Situação','situacao');
        $oSituacaoConsulta->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA);
         $oSituacaoConsulta->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
         $oSituacaoConsulta->setBComparacaoColuna(true);
         $oSituacaoConsulta->setILargura(11);
         
         $oUserEntConsulta = new campoconsulta('Usuário Ent.','usernome');
         $oUserSaidaConsulta = new campoconsulta('Usuário Saída','usernomesaida');
        
        $oGridEtapa->addCampos($oBotaoStart,$oBotaoFinalizar,$oBotaoRetornar,$oOpGrid,$oReceitaSeq,$oTratamento,$oSituacaoConsulta,
                 $oFornodesConsulta,$oDataEntConsulta,$oHoraEntConsulta,$oUserEntConsulta,$oDataSaidaConsulta,
                 $oHoraSaidaConsulta,$oUserSaidaConsulta);

        $aCampos = $oGridEtapa->getArrayCampos();
        return $aCampos;
    }
}
