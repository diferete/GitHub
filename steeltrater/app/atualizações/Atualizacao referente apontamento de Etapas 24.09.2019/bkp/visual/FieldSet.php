<?php
/**
 * Classe que implementa a estrutura FielSet do ExtJs
 *
 * @author Carlos Eduardo
 * @since 11/03/2016
 */
class FieldSet {
      private $sId;
      private $sTitulo;
      private $aCampos;
      private $Oculto;
      
      function __construct($sTitulo) {
          $this->sId = Base::getId();
          $this->sTitulo = $sTitulo;
          $this->Oculto = false;
      }
      
      function addCampos(){
          $aDados = func_get_args();
          $this->setACampos($aDados);
      }
              
      function getSId() {
          return $this->sId;
      }

      function getSTitulo() {
          return $this->sTitulo;
      }

      function getACampos() {
          return $this->aCampos;
      }

      function setSId($sId) {
          $this->sId = $sId;
      }

      function setSTitulo($sTitulo) {
          $this->sTitulo = $sTitulo;
      }

      function setACampos($aCampos) {
          $this->aCampos = $aCampos;
      }
      function getOculto() {
        ($this->Oculto)?$sOculto = 'true':$sOculto = 'false';
        return $sOculto;
      }
      /**
       * Método que define se o campo é oculto 
       * @param boolean $Oculto Se true, campo fica oculto
       */
      function setOculto($Oculto) {
          $this->Oculto = $Oculto;
      }
      
    function getRenderCampos($oCampo){
        
        switch ($oCampo){
            case is_array($oCampo):
                $sRow = '<div class="row">';
                    foreach($oCampo as $CampoArray){
                        $sRow .= $CampoArray->getRender();
                    }
                $sRow .= '</div>';

                $sRetorno = $sRow;
            break;
            case is_a($oCampo, 'Campo'):
                $sRow = '<div class="row">'
                 .$oCampo->getRender()
                .'</div>';
                
                $sRetorno = $sRow;
            break;
            case is_a($oCampo, 'FieldSet'):
                 $sRow = '<div class="row">'
                 .$oCampo->getRender()
                .'</div>';
                
                $sRetorno = $sRow;
            break;
        }
          
        return $sRetorno;
    }

      public function getRender(){
        $sFieldSet = '<fieldset class="fieldset coolfieldset" id="'.$this->getSId().'"  >'

                    .'<legend >'.$this->getSTitulo().':</legend>';
                      //  .'<div class="row">';
                    foreach ($this->aCampos as $oCampo){
                        $sFieldSet .= $this->getRenderCampos($oCampo);
                    }
        $sFieldSet .= //'</div>'.
                      '</fieldset>'
                      .'<script> $("#'.$this->getSId().'").coolfieldset('
                          .'{ collapsed:'.$this->getOculto().' }'
                      .'); </script>';
        

        return $sFieldSet;
    }

    

}
?>
