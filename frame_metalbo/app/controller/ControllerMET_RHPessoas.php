<?php

/*
 * Implementa a classe controler RH Pessoas
 * @author Cleverton Hoffmann
 * @since 16/03/202
 */

class ControllerMET_RHPessoas extends Controller{
    function __construct() {
        $this->carregaClassesMvc('MET_RHPessoas');
    }
    
    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);
        $this->buscaDados();        
    }
    
    public function buscaDados(){
        $aParame1 = $this->Persistencia->buscaSetor();
        $aParame2 = $this->Persistencia->buscaEscala();
        $aParame3 = $this->Persistencia->buscaFuncao();
        $aParame[1] = $aParame1;
        $aParame[2] = $aParame2;
        $aParame[3] = $aParame3;
        
        $this->View->setAParametrosExtras($aParame);
        return true;
    }
    
    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);
        $this->buscaDados();   
    }
    
    public function acaoMostraRelEspecifico($renderTo, $sMetodo = '') {
        parent::acaoMostraRelEspecifico($renderTo, $sMetodo);

        $aDados = explode(',',$_REQUEST['parametros']['parametros[']);
        $sCampos ='seq='.implode('|', $_REQUEST['parametrosCampos']);
        
        $sCampos = $sCampos.'&'.'tipo='.$aDados[2];
        
        $sSistema = "app/relatorio";
        $sRelatorio = 'relFunFichaCursos.php?';

        $sCampos .= $this->getSget();

        $sCampos .= '&output=tela';
        $oWindow = 'window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '", "' . $sCampos . '", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow;
                
   }
   
   /*
     * Mensagem de Finalização da Ficha de Contratação de Funcionários
     */
    public function msgFinalizaFicha($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $this->Persistencia->adicionaFiltro('seq', $aCamposChave['seq']);
        $oSeqAtual = $this->Persistencia->consultarWhere();
        $this->getMetodoCriaTela();
        if ($oSeqAtual->getSit() !== 'AGUARDANDO') {
            $oMensagem = new Modal('Atenção!', 'A Ficha Nº' . $aCamposChave['seq'] . ' não pode ser finalizada, somente é possível finalizar fichas em com situação aguardando!', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem->getRender();
        } else {

            $oMensagem = new Modal('Atenção!', 'Deseja finalizar a ficha ' . $aCamposChave['seq'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("' . $aDados[3] . '-form","' . $sClasse . '","finalizaFicha","' . $sDados . '");');
            echo $oMensagem->getRender();
        }
    }

    /*
     * Finaliza a Ficha de Contratação de Funcionários
     */
    public function finalizaFicha($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        //chama o método na persistencia
        $aRetorno = $this->Persistencia->finalizarFicha($aCamposChave);

        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('Atenção!', 'A ficha ' . $aCamposChave['seq'] . ' foi finalizado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Mensagem('Erro!', 'A ficha ' . $aCamposChave['seq'] . ' não foi finalizado com sucesso! >>>>' . $aRetorno[1], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
        }
        $this->Persistencia->limpaFiltro();
        $this->getDadosConsulta($aDados[1], TRUE, null);
    }
  
}
