<?php

class ControllerSTEEL_PCP_histEmailcert extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_histEmailcert');
    }
    
     /**
     * Cria a tela Modal para a proposta
     * @param type $sDados
     */
    public function criaTelaModalHist($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $aChave = explode('=', $aDados[2]);
        
        $oHist = Fabrica::FabricarController('STEEL_PCP_histEmailcert');
        $oHist->Persistencia->adicionaFiltro('nrcert',$aChave[1]);
        $oCert = $oHist->Persistencia->getarrayModel();
        $this->View->setAParametrosExtras($oCert);
    
          //busca os dados da ordem de produção
            //$oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
            //$oOpDados=$oOp->buscaOp($aChave[1]);
            //busca fornos
            //$oForno = Fabrica::FabricarController('STEEL_PCP_Forno');
            //$oFornoSel = $oForno->Persistencia->getArrayModel();
            //$this->View->setAParametrosExtras($oOpDados);
            //$this->View->setAModelDados($oFornoSel);
            $this->View->criaTela();
            //busca lista pela op
        //    $oLista= Fabrica::FabricarController('STEEL_PCP_ordensFabLista');
        //    $oListaDate = $oLista->Persistencia->adicionaFiltro('op',$aChave[1]);
        //    $oListaDate = $oLista->Persistencia->consultarWhere();
        //    if($oListaDate->getSituacao()=='Processo'){
        //       $oMensagem = new Modal('Atenção','Esta lista da op nº '. $aChave[1] . ' já está em processo!', Modal::TIPO_AVISO,false,true);
        //      echo $oMensagem->getRender(); 
        //      echo'$("#modalLista-btn").click();';
        //    }else{

            $sLimpa = "$('#" . $aDados[0] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
            }
        
            
    
}

