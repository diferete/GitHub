<?php

/* 
 * Persistencia da classe para liberar media de preço
 * @author Avanei Martendal
 * @since 25/07/2016
 */

class PersistenciaAutSolCot extends Persistencia{
    public function __construct() {
        parent::__construct();
        $this->setTabela('pdfautsolcot');
        
        $this->adicionaRelacionamento('id', 'id',true);
        $this->adicionaRelacionamento('nr', 'nr');
        $this->adicionaRelacionamento('tipo', 'tipo');
        $this->adicionaRelacionamento('empcod', 'Pessoa.empcod');
        $this->adicionaRelacionamento('media', 'media');
        $this->adicionaRelacionamento('codrep', 'codrep');
        
        $this->adicionaJoin('Pessoa',NULL,1,'empcod','empcod');
        $this->adicionaOrderBy('id',1);
    }
    
    /*
    * Liberar a solicitação ou cotação
     * 
     */
    
    public function libeSolCot($sNr,$sTipo,$sEmpcod){
        $sSql ="select COUNT(*) as qt from pdfautSolCot "
               ."where nr =".$sNr." and tipo =".$sTipo." and empcod=".$sEmpcod."";
        
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        if($row->qt > 0){
          $sLib = 'LiberadoSolCot';
          return $sLib;   
        }else{
          return NULL;
        }
        
        
        
    }
}