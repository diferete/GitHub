<?php 
 /*
 * Implementa a classe controler MET_CAD_Maquinas
 * @author Cleverton Hoffmann
 * @since 13/07/2021
 */
 
class ControllerMET_CAD_Maquinas extends Controller {
 
    public function __construct() {
        $this->carregaClassesMvc('MET_CAD_Maquinas');
    } 
 
    public function relCadMaqSteel($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'RelCadMaqSteel');
    }  
    
    public function beforeInsert() {
        parent::beforeInsert();
        $this->consultaCodMaqRep();
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }
    
    public function beforeUpdate() {
        parent::beforeUpdate();
        $this->consultaCodMaqRep();
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }
    
    /**
     * Método que verifica se código de máquina já existe e não deixa inserir o mesmo
     */
    public function consultaCodMaqRep(){
        $aDados = $this->getArrayCampostela();

        if ($aDados['codigoMaq'] == '') {
            exit;
        } else {
            $dadosMaq = $this->Persistencia->buscaDadosMaq($aDados);
            if ($dadosMaq->cont >= 1) {
                $oMensagem = new Mensagem('Atenção!', 'Cógigo já existente informe outro código!', Mensagem::TIPO_WARNING, 7000);
                echo $oMensagem->getRender();
                echo '$("#codigoMaqMetCad").val("").focus();';
                exit;
            } else {
            }
        }
    }
    
}