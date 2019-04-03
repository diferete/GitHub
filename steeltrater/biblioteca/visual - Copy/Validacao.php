<?php
/**
 * Classe responsável por implementar validação num formulário
 * 
 * @author Carlos Eduardo Scheffer
 * @since 22/02/2016
 */

class Validacao {
    private $Id;
    private $Nome; //Nome do campo do model
    private $Descricao; //Descrição do campo 
    private $Tipo; //Tipo de validação
    private $RegEx; //String de validação RegEx
    private $Mensagem; //Mensagem de erro
    private $StringMin; //Tamanho minimo da string
    private $StringMax; //Tamanho máximo da string
    private $CampoVazio; //Permite campo vazio
    private $Row;
    private $CampoIgual;
    private $Callback;
    private $Trigger;
    
    const TIPO_STRING = 0;
    const TIPO_INTEIRO = 1;
    const TIPO_DECIMAL = 2;
    const TIPO_EMAIL = 3;
    const TIPO_TELEFONE = 4;
    const TIPO_REGEX = 5;
    const EAN = 6;
    
    const TIPO_IGUAL = 7;
    const TIPO_CALLBACK = 8;
    
    const REGEX_EMAIL = '/^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/';
    const REGEX_TELEFONE = '^\([1-9]{2}\) [2-9][0-9]{3,4}\-[0-9]{4}$';
    const REGEX_CEP = '/\d{2}\.\d{3}\-\d{3}/';
    const REGEX_ = '';
    
    const TRIGGER_TODOS = 'keyup focus change';
    const TRIGGER_SAIR =  'blur';
    const TRIGGER_FOCO =  'focus';
    const TRIGGER_CHANGE = 'change';
    const TRIGGER_KEYUP = 'keyup';
    const TRIGER_KEYDOWN = 'keydown';
    const TRIGGER_CLICK = 'click';

    /**
     * 
     * @param type $Id
     * @param type $Row
     * @param type $sNomeCampo
     * @param type $sDescricaoCampo
     * @param type $bCampoVazio
     * @param type $TipoValidacao
     * @param type $StringMin
     * @param type $StringMax
     * @param type $sCampoIgual
     * @param type $RegEx
     * @param type $sCallback
     * @param type $sTrigger
     */
    function __construct($Id, $Row, $sNomeCampo, $sDescricaoCampo, $bCampoVazio = false, $TipoValidacao = self::SEM_VALIDACAO, $StringMin = '0', $StringMax = '250', $sCampoIgual = '', $RegEx = '', $sCallback = '', $sTrigger = self::TRIGGER_TODOS){
        $this->setId($Id);
        $this->setRow($Row);
        $this->setNome($this->validaNome($sNomeCampo));
        $this->setDescricao($sDescricaoCampo);
        $this->setTipo($TipoValidacao);
        $this->setCampoVazio($bCampoVazio);
        $this->setRegEx($RegEx);
        $this->setStringMax($StringMax);
        $this->setStringMin($StringMin);
        $this->setCampoIgual($sCampoIgual);
        $this->setCallback($sCallback);
        $this->setTrigger($sTrigger);
    }
    
    function getId() {
        return $this->Id;
    }

    function setId($Id) {
        $this->Id = $Id;
    }

        function getNome() {
        return $this->Nome;
    }

    function getDescricao() {
        return $this->Descricao;
    }

    function getTipo() {
        return $this->Tipo;
    }

    function getRegEx() {
        return $this->RegEx;
    }

    function getMensagem() {
        return $this->Mensagem;
    }

    function getStringMin() {
        return $this->StringMin;
    }

    function getStringMax() {
        return $this->StringMax;
    }

    function getCampoVazio() {
        return $this->CampoVazio;
    }

    function setNome($Nome) {
        $this->Nome = $Nome;
    }

    function setDescricao($Descricao) {
        $this->Descricao = $Descricao;
    }

    function setTipo($Tipo) {
        $this->Tipo = $Tipo;
    }

    function setRegEx($RegEx) {
        $this->RegEx = $RegEx;
    }

    function setMensagem($Mensagem) {
        $this->Mensagem = $Mensagem;
    }

    function setStringMin($StringMin) {
        $this->StringMin = $StringMin;
    }

    function setStringMax($StringMax) {
        $this->StringMax = $StringMax;
    }

    function setCampoVazio($CampoVazio) {
        $this->CampoVazio = $CampoVazio;
    }    
    function getRow() {
        return $this->Row;
    }

    function setRow($Row) {
        $this->Row = $Row;
    }
    function getCampoIgual() {
        return $this->CampoIgual;
    }

    function setCampoIgual($CampoIgual) {
        $this->CampoIgual = $CampoIgual;
    }
    function getCallback() {
        return $this->Callback;
    }

    function setCallback($Callback) {
        $this->Callback = $Callback;
    }
    function getTrigger() {
        return $this->Trigger;
    }

    function setTrigger($Trigger) {
        $this->Trigger = $Trigger;
    }

                    
    /**
     * Método responsável por retornar string se campo é permitido em branco
     * @param type $bVal
     * @param type $sCampoDescricao
     * @return string
     */
    function getNotEmpty(){
        if(!$this->getCampoVazio()){
            $sNotEmpty = 'notEmpty: {'
                            .'message: "Este campo é obrigatório!"'
                        .'}, ';
            
            return $sNotEmpty;  
        }
           
    }
    
    function validaNome($sNome){
        $nomeReplace = str_replace('.', '',$sNome);
        
        return $nomeReplace;
    }


    /**
     * Método responsável por renderizar string de validação
     */
    public function getRender(){
            switch ($this->Tipo){
                case self::TIPO_INTEIRO:
                $sValidation = $this->getNome().' : {'
                                
                                .'selector : "#'.$this->getId().'", '
                                .'row : ".col-xs-'.$this->getRow().'", '
                                .'trigger : "'.$this->getTrigger().'",'
                                .'validators : {'
                                    .$this->getNotEmpty()
                                    .'integer : {'
                                       .'message : "'.$this->getMensagem().'"'
                                    .'},'
                                    .'stringLength : {'
                                        .'max : '.$this->getStringMax().', '
                                        .'min : '.$this->getStringMin().', '
                                        //.'message : "O tamanho mínimo deste campo é de '.$this->getStringMin().' e no máximo '.$this->getStringMax().'."'
                                    .'}'
                                .'}'
                            .'}';
                  break;
              
              case self::TIPO_DECIMAL:
                $sValidation = $this->getNome().' : {'
                                
                                .'selector : "#'.$this->getId().'", '
                                .'row : ".col-xs-'.$this->getRow().'", '
                                .'trigger : "'.$this->getTrigger().'",'
                                .'validators : {'
                                    .$this->getNotEmpty()
                                    .'decimal : {'
                                       .'message : "'.$this->getMensagem().'"'
                                    .'},'
                                    .'stringLength : {'
                                        .'max : '.$this->getStringMax().', '
                                        .'min : '.$this->getStringMin().', '
                                        //.'message : "O tamanho mínimo deste campo é de '.$this->getStringMin().' e no máximo '.$this->getStringMax().'."'
                                    .'}'
                                .'}'
                            .'}';
                  break;
              
                case self::TIPO_STRING:

                        $sValidation = $this->getNome().' : {'
                                
                                .'selector : "#'.$this->getId().'", '
                                .'row : ".col-xs-'.$this->getRow().'",'
                                .'trigger : "'.$this->getTrigger().'",'
                                 .'validators : {'
                                    .$this->getNotEmpty()
                                    .'stringLength : {'
                                        .'max : '.$this->getStringMax().', '
                                        .'min : '.$this->getStringMin().', '
                                        .'message : "O tamanho mínimo deste campo é de '.$this->getStringMin().' e no máximo '.$this->getStringMax().'."'
                                    .'}'
                                .'}'
                            .'}';
                break;

                case self::TIPO_TELEFONE:
                    $sValidation = $this->getNome().' : {'
                               
                                .'selector : "#'.$this->getId().'", '
                                .'row : ".col-xs-'.$this->getRow().'",'
                                .'trigger : "'.$this->getTrigger().'",'
                                .'validators:{'
                                    .$this->getNotEmpty()
                                    .'stringLength : {'
                                            .'max : '.$this->getStringMax().','
                                            .'min : '.$this->getStringMin().','
                                            .'message: "O tamanho mínimo deste campo é de '.$this->getStringMin().' e no máximo '.$this->getStringMax().'."'
                                        .'},'
                                    .'regexp : {'
                                        .'message: "'.$this->getMensagem().'",'
                                        .'regexp: '.self::REGEX_TELEFONE
                                    .'}'
                                .'}'
                            .'}';
                break;
                case self::TIPO_EMAIL:
                    $sValidation = $this->getNome().' : {'
                                
                                .'selector : "#'.$this->getId().'", '
                                .'row : ".col-xs-'.$this->getRow().'",'
                                 .'trigger : "'.$this->getTrigger().'",'
                                .'validators : {'
                                    .$this->getNotEmpty()
                                    .'stringLength: {'
                                            .'max : '.$this->getStringMax().','
                                            .'min : '.$this->getStringMin().','
                                            .'message : "O tamanho mínimo deste campo é de '.$this->getStringMin().' e no máximo '.$this->getStringMax().'."'
                                    .'},'
                                    .'emailAddress : {'
                                        .'message : "'.$this->getMensagem().'",'
                                    .'}'
                                .'}'
                            .'}';            
                break;


                case self::TIPO_REGEX:
                    $sValidation = $this->getNome().' : {'
                                
                                .'selector: "#'.$this->getId().'", '
                                .'row : ".col-xs-'.$this->getRow().'",'
                                 .'trigger : "'.$this->getTrigger().'",'
                                .'validators : {'
                                    .$this->getNotEmpty()
                                    .'stringLength : {'
                                        .'max : '.$this->getStringMax().','
                                        .'min : '.$this->getStringMin().','
                                        .'message: "O tamanho mínimo deste campo é de '.$this->getStringMin().' e no máximo '.$this->getStringMax().'."'
                                    .'},'
                                    .'regexp : {'
                                        .'message : "'.$this->getMensagem().'",'
                                        .'regexp : '.$this->getRegEx()
                                    .'}'
                                .'}'
                            .'}';
                break;
                case self::TIPO_IGUAL:
                    $sValidation = $this->getNome().' : {'

                                    .'selector : "#'.$this->getId().'", '
                                    .'row : ".col-xs-'.$this->getRow().'",'
                                     .'trigger : "'.$this->getTrigger().'",'
                                    .'validators : {'
                                            .$this->getNotEmpty()
                                            .'identical: {'
                                            .'    field: "'.  $this->getCampoIgual().'",'
                                            .'    message: "A senha e a sua confirmação não são iguais"'
                                            .'},'
                                            .'stringLength : {'
                                                .'max : '.$this->getStringMax().', '
                                                .'min : '.$this->getStringMin().', '
                                                .'message : "O tamanho mínimo deste campo é de '.$this->getStringMin().' e no máximo '.$this->getStringMax().'."'
                                            .'}'
                                    .'}'
                                .'}';
                      break;
                   case self::TIPO_CALLBACK:
                    $sValidation = $this->getNome().' : {'
                                
                                .'selector : "#'.$this->getId().'", '
                                .'row : ".col-xs-'.$this->getRow().'",'
                                .'trigger : "'.$this->getTrigger().'",'
                                .'validators : {'
                                    .$this->getNotEmpty()
                                    .'stringLength: {'
                                            .'max : '.$this->getStringMax().','
                                            .'min : '.$this->getStringMin().','
                                            .'message : "O tamanho mínimo deste campo é de '.$this->getStringMin().' e no máximo '.$this->getStringMax().'."'
                                    .'},'
                                    .' callback: {'
                                            .'message: "'.$this->getMensagem().'",'
                                            .'callback: function(value, validator, $field) {'
                                                 .$this->getCallback()
                                            .'}'
                                    .'}'
                                .'}'
                            .'}';            
                break;
                
                case self::TIPO_REMOTO:
                    $sValidation = $this->getNome().' : {'
                                
                                .'selector : "#'.$this->getId().'", '
                                .'row : ".col-xs-'.$this->getRow().'",'
                                .'validators : {'
                                    .$this->getNotEmpty()
                                    .'stringLength: {'
                                            .'max : '.$this->getStringMax().','
                                            .'min : '.$this->getStringMin().','
                                            .'message : "O tamanho mínimo deste campo é de '.$this->getStringMin().' e no máximo '.$this->getStringMax().'."'
                                    .'},'
                                    .'remote : {'
                                            .'url : "index.php",'
                                            .'type: "POST",'
                                            .'data : {'
                                                .'classe: "",'
                                                .'metodo: "",'
                                                .''
                                            .'}'
                                    .'}'
                                .'}'
                            .'}';            
                break;
            }
    
            return $sValidation;
    }
}
