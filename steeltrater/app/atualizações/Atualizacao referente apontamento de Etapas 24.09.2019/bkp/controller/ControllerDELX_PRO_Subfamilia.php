<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 18/06/2018
 */

class ControllerDELX_PRO_Subfamilia extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('DELX_PRO_Subfamilia');
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            if(isset($aCampos['pro_grupocodigofin'])){
                $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aCampos['pro_grupocodigo'],0, Persistencia::ENTRE,$aCampos['pro_grupocodigofin']); 
                $this->Persistencia->adicionaFiltro('pro_subgrupocodigo', $aCampos['pro_subgrupocodigo'],0, Persistencia::ENTRE,$aCampos['pro_subgrupocodigofin']);
                $this->Persistencia->adicionaFiltro('pro_familiacodigo', $aCampos['pro_familiacodigo'],0, Persistencia::ENTRE,$aCampos['pro_familiacodigofin']);
           }else{
            $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aCampos['pro_grupocodigo']);
            $this->Persistencia->adicionaFiltro('pro_subgrupocodigo', $aCampos['pro_subgrupocodigo']);
            $this->Persistencia->adicionaFiltro('pro_familiacodigo', $aCampos['pro_familiacodigo']);
           }
        }
    }

    public function antesValorBuscaPk() {
        parent::antesValorBuscaPk();

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aCampos['pro_grupocodigo']);
            $this->Persistencia->adicionaFiltro('pro_subgrupocodigo', $aCampos['pro_subgrupocodigo']);
            $this->Persistencia->adicionaFiltro('pro_familiacodigo', $aCampos['pro_familiacodigo']);
        }
    }

}
