<?php 
 /*
 * Implementa a classe controler STEEL_PCP_ParForno
 * @author Cleverton Hoffmann
 * @since 03/12/2020
 */
 
class ControllerSTEEL_PCP_ParForno extends Controller {
 
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_ParForno');
    } 
    
    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);
        
        //busca forno
        $oFornoUser = Fabrica::FabricarController('STEEL_PCP_fornoUser');
        $oDados = $oFornoUser->pesqFornoUser();
        
        $oForno = Fabrica::FabricarController('STEEL_PCP_Forno');
        $oFornoAtual = $oForno->buscaForno($oDados->getFornocod());

        $aDados[] = $oFornoAtual;

        $oFornos = Fabrica::FabricarController('STEEL_PCP_Forno');
        $oFornoSel = $oFornos->Persistencia->getArrayModel();

        $aDados[] = $oFornoSel;

        $oMotivos = Fabrica::FabricarController('STEEL_PCP_ParMotivo');
        $oMotivos = $oMotivos->Persistencia->getArrayModel();
        
        $aDados[] = $oMotivos;
        
        $this->View->setAParametrosExtras($aDados);       
        
        
    }
 
    public function criaModalApontParada($sDados){
        
        //$this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        //pega todos os campos 
        $aCamposTela = $this->getArrayCampostela();
        
        $this->View->setAParametrosExtras($aCamposTela);
        
        $this->View->criaModalApontaParada();

        //adiciona tela que será dado um show 
        $this->View->getTela()->setSRenderHide("ModalApontaParada");

        $this->View->getTela()->setSRender($aDados[0]);

        //renderiza a tela
        $this->View->getTela()->getRender();
        
    }
    
    
}