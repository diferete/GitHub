<?php

/* 
 * Classe que implementa o clontroller da classe satisfação de cliente
 * 
 * @author Avanei Martendal
 * @since 14/01/2018
 */

class ControllerSatisCliente extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('SatisCliente');
        $this->setControllerDetalhe('SatisClientePesq');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }
    
      /**
    * monta os campos para a próxima etapa
    */
   function montaProxEtapa() {
       parent::montaProxEtapa();
       $aRetorno[0]=  $this->Model->getFilcgc();
       $aRetorno[1]= $this->Model->getNr();
       return $aRetorno;
   }
    
   public function getSget() {
       parent::getSget();
       $sCampos ='&usuario='.$_SESSION['nome'];
       return $sCampos;
   }
    
}

