<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 20/06/2018
 */

class ControllerDELX_NFS_NotaFiscal extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('DELX_NFS_NOTAFISCAL');
    }
}
