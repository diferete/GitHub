<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 25/06/2018
 */


class ControllerDELX_NFS_TipoMovimento extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('DELX_NFS_TIPOMOVIMENTO');
    }
}