<?php 
 /*
 * Implementa a classe controler MET_MANUT_OSPesqProd
 * @author Cleverton Hoffmann
 * @since 27/09/2021
 */
 
class ControllerMET_MANUT_OSPesqProd extends Controller {
 
    public function __construct() {
        $this->carregaClassesMvc('MET_MANUT_OSPesqProd');
    } 
 
    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        
        $oContPar = Fabrica::FabricarController('STEEL_PCP_ParametrosProd');
        $oContPar->Persistencia->adicionaFiltro('parametro', "PARAMENTRO PARA O SISTEMA DE CONSULTA DE MATERIAL OS");
        $oModelDadosPar = $oContPar->Persistencia->consultarWhere();
        $sDados = $oModelDadosPar->getObs();
        $aGrupDados = explode(',', $sDados);
        $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aGrupDados, Persistencia::LIGACAO_AND, Persistencia::GRUPO);
        
    }
    
}