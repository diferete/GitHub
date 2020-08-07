<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerEmpenhoPed extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('EmpenhoPed');
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        $this->Persistencia->limpaFiltro();
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if ($aCampos['cnpj'] !== '') {
            $this->Persistencia->adicionaFiltro('empcod', $aCampos['cnpj']);
        }


        $this->Persistencia->setSqlWhere("  
      widl.PEV01.pdvnro = widl.PEDV01.pdvnro 
      and widl.pev01.empcod=widl.emp01.empcod 
      and widl.pev01.filcgc =  75483040000211 
      and widl.pev01.empcod <> 75483040000211  
      and widl.PEV01.pdvsituaca = 'O'
      and (widl.pedv01.pdvproqtdp - widl.pedv01.pdvproqtdf)>0
      and widl.PEDV01.procod =" . $aCampos['codigo'] . "
      order by pdvemissao");

        //and widl.PEDV01.procod =10111201
    }

    /**
     * id do mercado interno
     */
    public function SomaEmpenho($sDados) {

        $aDados = explode(',', $sDados);

        $aTotal = $this->Persistencia->somaPedidos($aDados[0]);

        echo '$("#' . $aDados[1] . '").val("' . number_format($aTotal['interno'], 2, ',', '.') . '");'
        . '$("#' . $aDados[2] . '").val("' . number_format($aTotal['export'], 2, ',', '.') . '");'
        . '$("#' . $aDados[3] . '").val("' . number_format($aTotal['exportlib'], 2, ',', '.') . '");';
    }

}
