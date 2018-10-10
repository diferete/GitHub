<?php

/**
 * Persistencia da classe slides, que é responsável por controlar slides
 * Atualmente é utilizada na classe
 * @author Carlos
 */
class PersistenciaSlides extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbslides');
        
        $this->adicionaRelacionamento('slidid', 'slidid', true, true, true);
        $this->adicionaRelacionamento('sliddesc', 'sliddesc');
        $this->adicionaRelacionamento('slidimg', 'slidimg');
        $this->adicionaRelacionamento('slidativo', 'slidativo');
        $this->adicionaRelacionamento('slidusuario', 'slidusuario');
        $this->adicionaRelacionamento('sliddata', 'sliddata');
    }

    
    /**
     * Método responsável por retornar array de model, para que os dados possam serem utilizados em outras plataformas
     * @return Array Models
     */
    public function getSlides(){
   
        $sql = "select "
            ."tbslides.slidid as 'tbslides.slidid', "
            ."tbslides.sliddesc as 'tbslides.sliddesc',"
            ."tbslides.slidimg as 'tbslides.slidimg', "
            ."tbslides.sliddata as 'tbslides.sliddata' "
            ."from tbslides where slidativo = 'true'";
     
        $result = $this->getObjetoSql($sql);
            while($oRowBD = $result->fetch(PDO::FETCH_OBJ)){
                $oModel = $this->getNewModel();
                $this->carregaModelBanco($oModel,$oRowBD);
                $aRetorno[] = $oModel;
            }
            return $aRetorno;
    }
}
