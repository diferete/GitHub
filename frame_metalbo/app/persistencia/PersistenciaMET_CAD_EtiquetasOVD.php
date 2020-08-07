<?php 
 /*
 * Implementa a classe persistencia MET_CAD_EtiquetasOVD
 * @author Cleverton Hoffmann
 * @since 08/07/2020
 */
 
class PersistenciaMET_CAD_EtiquetasOVD extends Persistencia {
 
    public function __construct() {
        parent::__construct();
 
        $this->setTabela('tbOvd');
        $this->adicionaRelacionamento('procod','procod', true, true);
        $this->adicionaRelacionamento('codovd','codovd');
        $this->adicionaRelacionamento('descovd','descovd');
        $this->adicionaRelacionamento('descricao','descricao');
        $this->adicionaRelacionamento('descricao2','descricao2');
        $this->adicionaRelacionamento('medida','medida');
        $this->adicionaRelacionamento('ean','ean');
        $this->adicionaRelacionamento('pecas','pecas');
        $this->adicionaRelacionamento('centosnormal','centosnormal');
        $this->adicionaRelacionamento('centosmaster','centosmaster');
        $this->adicionaRelacionamento('unmaster','unmaster');
        $this->adicionaRelacionamento('unnormal','unnormal');
        $this->adicionaRelacionamento('imagem','imagem');
        $this->adicionaRelacionamento('unmed','unmed');
        $this->adicionaRelacionamento('descesp','descesp');
        $this->adicionaRelacionamento('rosca','rosca');
        $this->adicionaRelacionamento('tipo','tipo');
        
        $this->adicionaOrderBy('procod', 1);
        $this->setSTop(50);
    } 
    
}