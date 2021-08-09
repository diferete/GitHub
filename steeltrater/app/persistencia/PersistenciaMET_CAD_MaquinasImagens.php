<?php 
 /*
 * Implementa a classe persistencia MET_CAD_MaquinasImagens
 * @author Cleverton Hoffmann
 * @since 03/08/2021
 */
 
class PersistenciaMET_CAD_MaquinasImagens extends Persistencia {
 
    public function __construct() {
        parent::__construct();
 
        $this->setTabela('MET_CAD_MaquinasImagens');
        $this->adicionaRelacionamento('fil_codigo','fil_codigo', true, true);
        $this->adicionaRelacionamento('fil_codigo','DELX_FIL_Empresa.fil_codigo', false, false, false);
        $this->adicionaRelacionamento('cod','cod', true, true);
        $this->adicionaRelacionamento('cod','MET_CAD_Maquinas.codigoMaq', false, false, false);    
        $this->adicionaRelacionamento('seq','seq', true, true, true);
        $this->adicionaRelacionamento('obs','obs');
        $this->adicionaRelacionamento('link','link');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('coduser','coduser');
        $this->adicionaRelacionamento('coduser','MET_TEC_USUARIO.usucodigo', false, false, false);
        
        $this->adicionaJoin('DELX_FIL_EMPRESA');
        $sAnd = ' and MET_CAD_MaquinasImagens.fil_codigo = MET_CAD_Maquinas.fil_codigo ';
        $this->adicionaJoin('MET_CAD_Maquinas', null, 1, 'cod', 'codigoMaq', $sAnd);
        $this->adicionaJoin('MET_TEC_USUARIO', null, 1, 'coduser', 'usucodigo');
               
    } 
    
    public function getIncrementoFinal($iFilcodigo, $iCod){
        $sSql = "SELECT MAX(seq) AS maximo FROM MET_CAD_MaquinasImagens WHERE cod = " . $iCod . " AND fil_codigo = " . $iFilcodigo;
        $oObj = $this->consultaSql($sSql);
        return $oObj->maximo;
    }
}