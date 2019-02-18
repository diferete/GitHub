<?php

/* 
 *Controller da classe aponta lista
 * 
 * @author Cleverton Hoffmann
 * @since 31/07/2018
 */

class ControllerSTEEL_PCP_OrdensFabApontLista extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_OrdensFabApontLista');
    }
    
     /**
     * Cria a tela Modal para a proposta
     * @param type $sDados
     */
    public function criaTelaModalProposta($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $aChave = explode('=', $aDados[2]);
    
          //busca os dados da ordem de produção
            $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
            $oOpDados=$oOp->buscaOp($aChave[1]);
            //busca fornos
            $oForno = Fabrica::FabricarController('STEEL_PCP_Forno');
            $oFornoSel = $oForno->Persistencia->getArrayModel();
            $this->View->setAParametrosExtras($oOpDados);
            $this->View->setAModelDados($oFornoSel);
            $this->View->criaModalOp();
            //busca lista pela op
            $oLista= Fabrica::FabricarController('STEEL_PCP_ordensFabLista');
            $oListaDate = $oLista->Persistencia->adicionaFiltro('op',$aChave[1]);
            $oListaDate = $oLista->Persistencia->consultarWhere();
            if($oListaDate->getSituacao()=='Processo'){
               $oMensagem = new Modal('Atenção','Esta lista da op nº '. $aChave[1] . ' já está em processo!', Modal::TIPO_AVISO,false,true);
              echo $oMensagem->getRender(); 
              echo'$("#modalLista-btn").click();';
            }else{

            $sLimpa = "$('#" . $aDados[0] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
            }
        
            
    }
    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
       
        $aWhere = $this->Persistencia->getListaWhere();
        
        foreach ($aWhere as $key => $aAtual) {
            if($aAtual['campo']=='STEEL_PCP_ordensFabLista.situacao'){
                if($aAtual['valor']=='slista'){
                    if($key==0){
                     $this->Persistencia->setSWhereManual(" where coalesce(STEEL_PCP_ordensFabLista.situacao,'') ='' ");   
                    }else{
                    $this->Persistencia->setSWhereManual(" and coalesce(STEEL_PCP_ordensFabLista.situacao,'') ='' ");
                    }
                    unset($aWhere[$key]);
                }
            }
        } 
        $this->Persistencia->setAListaWhere($aWhere);
        
    }
    
    public function msgExcluirLista($sDados){
        $aDados = explode(',',$sDados);
        
        $sChave =htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        
        $oLista = Fabrica::FabricarController('STEEL_PCP_ordensFabLista');
        $oLista->Persistencia->adicionaFiltro('op',$aCamposChave['op']);
        $iCount = $oLista->Persistencia->getCount();
        if($iCount == 0){
            $oMensagem = new Modal('Atenção','Esta a op nº '. $aCamposChave['op'] . ' não está adicionada a uma lista para excluir!', Modal::TIPO_AVISO,false,true);
            echo $oMensagem->getRender();        
        }else{
        $oListaCons = $oLista->Persistencia->consultarWhere();
        
        if($oListaCons->getSituacao()=='Processo'){
            $oMensagem = new Modal('Atenção','Esta a op nº '. $aCamposChave['op'] . ' já está em processo!', Modal::TIPO_AVISO,false,true);
            echo $oMensagem->getRender();   
        }else{
        
            $oMensagem = new Modal('Atenção!', 'Deseja excluir a lista da op nº' . $aCamposChave['op'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","STEEL_PCP_ordensFabLista","excluirLista","' . $sDados . '");');

            echo $oMensagem->getRender();
        }
        
        }
        
    }
    
    
}