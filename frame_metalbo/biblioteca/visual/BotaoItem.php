<?php
/**
 * Classe que implementa a estrutura de um Botão Item
 *
 * @author Everton Porath
 * @since 17/10/2013
 */
class BotaoItem {
      private $texto;
      private $classe;
      private $metodo;
      private $icone;
      private $confirmacao;
      private $textoConfirmacao;
      private $mostraTela;
      private $aBotoesFilhos;
      
      public function __construct($sTexto, $sClasse, $sMetodo, $sIcone = null, $bConfirmacao = false, $sConfirmacao = null, $bMostraTela = false){
          $this->setTexto($sTexto);
          $this->setClasse($sClasse);
          $this->setMetodo($sMetodo);
          $this->setIcone($sIcone);
          $this->setConfirmacao($bConfirmacao);
          $this->setTextoConfirmacao($sConfirmacao);
          $this->setMostraTela($bMostraTela);
          $this->aBotoesFilhos = array();
      }
      
      public function getTexto() {
          return $this->texto;
      }

      public function setTexto($texto) {
          $this->texto = $texto;
      }

      public function getClasse() {
          return $this->classe;
      }

      public function setClasse($classe) {
          $this->classe = $classe;
      }

      public function getMetodo() {
          return $this->metodo;
      }

      public function setMetodo($metodo) {
          $this->metodo = $metodo;
      }

      public function getIcone() {
          return $this->icone;
      }

      public function setIcone($icone) {
          $this->icone = $icone;
      }

      public function getConfirmacao() {
          return $this->confirmacao;
      }

      public function setConfirmacao($confirmacao) {
          $this->confirmacao = $confirmacao;
      }

      public function getTextoConfirmacao() {
          return $this->textoConfirmacao;
      }

      public function setTextoConfirmacao($textoConfirmacao) {
          $this->textoConfirmacao = $textoConfirmacao;
      }

      public function getMostraTela() {
          return $this->mostraTela;
      }

      public function setMostraTela($mostraTela) {
          $this->mostraTela = $mostraTela;
      }

}
?>