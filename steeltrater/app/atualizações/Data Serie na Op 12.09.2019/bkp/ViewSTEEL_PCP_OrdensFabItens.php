<?php

/* 
 *Classe que implementa a view da produção steeltrater
 * @author Avanei Martendal
 * 
 * @since 25/06/2018
 */
class ViewSTEEL_PCP_OrdensFabItens extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oOp = new CampoConsulta('Op','op');
        
        $this->addCampos($oOp);
    }
}
