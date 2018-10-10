<?php
/**
 * Classe que implementa a estrutura das mensagens 
 *
 * @author Avanei Martendal
 * @since 01/12/2015
 */
class Mensagem {
    private $sId; //id
    private $iTipo;//define o tipo da mensagem
    private $sTitulo; //title
    private $sMsg; //msg
   
    const TIPO_SUCESSO = 0;
    const TIPO_WARNING = 1;
    const TIPO_ERROR = 2;
    const TIPO_INFO = 3;

    /**
     * Construtor da classe Mensagem
     * 
     */
    public function __construct($sTitulo, $sMsg, $iTipo = self::TIPO_SUCESSO){
        $this->sId = Base::getId();
        $this->setITipo($iTipo);
        $this->setSTitulo($sTitulo);
        $this->setSMsg($sMsg);
       
    }
    /**
     * 
     * retorna o tipo da mensagem
     */
    function getITipo() {
        return $this->iTipo;
    }
   /**
    * seta o tipo da mensagem
    */
    function setITipo($iTipo) {
        $this->iTipo = $iTipo;
    }

     /**
     * 
     * retorna o id da mensagem
     */
    function getSId() {
        return $this->sId;
    }
     /**
     * 
     * retorna o título da mensagem
     */
    function getSTitulo() {
        return $this->sTitulo;
    }
    /**
     * 
     * retorna a mensagem
     */
    function getSMsg() {
        return $this->sMsg;
    }
    /**
     * 
     * seta o id
     */
    function setSId($sId) {
        $this->sId = $sId;
    }
     /**
     * 
     * seta o título
     */
    function setSTitulo($sTitulo) {
        $this->sTitulo = $sTitulo;
    }
     /**
     * 
     * seta a mensagem
     */
    function setSMsg($sMsg) {
        $this->sMsg = $sMsg;
    }

        
    /** 
     * Gera a string do objeto para que possa ser renderizado
     * pelo JSON
     * 
     * @return string String do objeto a ser renderizado 
     */    
    public function getRender(){
        switch ($this->getITipo()){
        case self::TIPO_SUCESSO:
            $sTipo ='success';
        break;
        case self::TIPO_WARNING:
            $sTipo='warning';
        break;
        case self::TIPO_ERROR:
            $sTipo='error';
        break;
        case self::TIPO_INFO:
            $sTipo='info';
        break;
        }
        
        $sMensagem = 'toastr.options = {'
        .'"closeButton": true,'
        .'"debug": false,'
        .'"newestOnTop": false,'
        .'"progressBar": true,'
        .'"positionClass": "toast-top-right",'
        .'"preventDuplicates": false,'
        .'"onclick": null,'
        .'"showDuration": "300",'
        .'"hideDuration": "1000",'
        .'"timeOut": "5000",'
        .'"extendedTimeOut": "1000",'
        .'"showEasing": "swing",'
        .'"hideEasing": "linear",'
        .'"showMethod": "fadeIn",'
        .'"hideMethod": "fadeOut"'
        .'};'
        .'toastr["'.$sTipo.'"]("'.$this->getSMsg().'", "'.$this->getSTitulo().'");';
        
        return $sMensagem;
    }
}
?>