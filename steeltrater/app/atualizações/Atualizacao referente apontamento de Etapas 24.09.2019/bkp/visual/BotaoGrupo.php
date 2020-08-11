<?php
/**
 * Classe que implementa a estrutura de um Botão Agrupodor SPLIT
 *
 * @author Everton Porath
 * @since 17/10/2013
 */
class BotaoGrupo {
      private $texto;
      private $icone;
      private $aBotoesFilhos;
      
      public function __construct($sTexto,$sIcone = null){
          $this->setTexto($sTexto);
          $this->setIcone($sIcone);
          $this->aBotoesFilhos = array();
      }
      public function addItem($oBotaoGrupo){
          $this->aBotoesFilhos[]=$oBotaoGrupo;
      }
      public function getItens(){
          return $this->aBotoesFilhos;
      }
      
      public function getTexto() {
          return $this->texto;
      }

      public function setTexto($texto) {
          $this->texto = $texto;
      }

      public function getIcone() {
          return $this->icone;
      }

      public function setIcone($icone) {
          $this->icone = $icone;
      }
}
?>