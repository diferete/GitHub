<?php 
 /*
 * Implementa a classe persistencia MET_MANUT_OSServico
 * @author Cleverton Hoffmann
 * @since 06/10/2021
 */
 
class PersistenciaMET_MANUT_OSServico extends Persistencia {
 
    public function __construct() {
        parent::__construct();
 
        $this->setTabela('MET_MANUT_OSServico');
        $this->adicionaRelacionamento('fil_codigo','fil_codigo', true, true);
        $this->adicionaRelacionamento('codserv','codserv', true, true, true);
        $this->adicionaRelacionamento('servico','servico');
        $this->adicionaRelacionamento('codsetor','codsetor');
        $this->adicionaRelacionamento('codsetor','MET_CAD_Setores.codsetor', false, false, false);
        $this->adicionaRelacionamento('tipcod','tipcod');
        $this->adicionaRelacionamento('ciclo','ciclo');
        $this->adicionaRelacionamento('resp','resp');
        $this->adicionaRelacionamento('usercad','usercad');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('hora','hora');
        $this->adicionaRelacionamento('sit','sit');
                
        $this->adicionaOrderBy('codserv', 1);    
        $this->adicionaJoin('MET_CAD_Setores');
        
        $this->setSTop('50');
    } 
    
}