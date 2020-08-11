<?php

/**
 * Classe que implementa a ControllerPessoa
 */
class ControllerPessoa extends Controller{
    function __construct() {
        $this->carregaClassesMvc('Pessoa');
    }
    
    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        
        $this->Persistencia->adicionaOrderBy('empdes', 0 );
      //  $this->Persistencia->adicionaFiltro('empcod','5');     
    }
    //busca representante para um cliente
    public function buscaRep($sEmpcod){
        $this->Persistencia->adicionaFiltro('empcod',$sEmpcod);
        $oPessoaRep = $this->Persistencia->consultarWhere();
        return $oPessoaRep->getRepcod();
    }
    
    
  }
