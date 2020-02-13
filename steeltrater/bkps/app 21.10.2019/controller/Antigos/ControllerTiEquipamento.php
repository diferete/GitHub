<?php

/**
 * Controller da Classe que mantem os equipamentos do setor de Tecnologia da Informação da Metalbo
 *
 * @author Carlos
 */
class ControllerTiEquipamento extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('TiEquipamento');
    }
}
