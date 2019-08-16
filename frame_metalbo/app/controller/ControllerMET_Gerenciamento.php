<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class ControllerMET_Gerenciamento extends Controller {

    function __construct() {
        $this->carregaClassesMvc('MET_Gerenciamento');
        $this->setControllerDetalhe('MET_ItensManPrev');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    //NOVO ----------------------------------------------------------------------------------
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();

        $this->Persistencia->adicionaFiltro('filcgc', $this->Model->getFilcgc());
        $this->Persistencia->adicionaFiltro('nr', $this->Model->getNr());
        $this->Persistencia->adicionaFiltro('codmaq', $this->Model->getCodmaq());
        $this->buscaCelulas();
    }

    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getFilcgc();
        $aRetorno[1] = $this->Model->getNr();
        $aRetorno[2] = $this->Model->getCodmaq();
        return $aRetorno;
    }

    //-----------------------------------------------------------------------------------------

    function beforeInsert() {
        parent::beforeInsert();

        $iCodMaq = $this->Model->getCodmaq();

        $oCodSetor = $this->Persistencia->consultaCodSetor($iCodMaq);

        $this->Model->setCodsetor($oCodSetor->codsetor);

        $this->verificaNrPorMaquina($iCodMaq);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    /*
     * Método que verifica se existe uma Nr cadastrada para a máquina. 
     */

    public function verificaNrPorMaquina($iCodMaq) {

        $iCountMq = $this->Persistencia->verificaQuantMaqAber($iCodMaq);

        if ($iCountMq != 0) {
            $oModal = new Modal('Atenção', 'Já existe uma Manutenção Preventiva aberta para a máquina! \n Altere a máquina selecionada!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
    }

    function beforeUpdate() {
        parent::beforeUpdate();

        $iCodMaq = $this->Model->getCodmaq();

        $oCodSetor = $this->Persistencia->consultaCodSetor($iCodMaq);

        $this->Model->setCodsetor($oCodSetor->codsetor);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);
       
        $sChave = htmlspecialchars_decode($sParametros[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $oValoresAtuais = $this->Persistencia->consultarWhere();
        
        if ($oValoresAtuais->getSitmp() == 'FINALIZADO') {
            $oModal = new Modal('Atenção', 'Não é possivel alterar manutenção pois está finalizada!', Modal::TIPO_AVISO);
            $this->setBDesativaBotaoPadrao(true);
            echo $oModal->getRender();
        }
    }
    
    public function acaoMostraRelEspecifico() {
       parent::acaoMostraRelEspecifico();

        $sNrs = '';
        $aDados = $_REQUEST['parametrosCampos'];
        foreach ($aDados as $key){
            $sNrs = $sNrs.'&'. substr($key,26);
        }
        $aSit = $_REQUEST['parametros'];
        foreach ($aSit as $key1){
            $aSit1 = explode(',', $key1);
        }

        $sSistema ="app/relatorio";
        $sRelatorio = 'relServicoMaquinaMantPrev.php?'.$sNrs.'&Sit='.$aSit1[2];

        $sCampos.= $this->getSget();

        $sCampos.= '&email=N'; 

        $sCampos.='&output=tela';
        $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow; 

        }
        
    public function buscaCelulas(){
        $oControllerMaquina = Fabrica::FabricarController('MET_Maquinas');
        $aParame = $oControllerMaquina->buscaDados();
        $this->View->setAParametrosExtras($aParame);
    }
        
}
