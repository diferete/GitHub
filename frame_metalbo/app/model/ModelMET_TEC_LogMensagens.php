<?php 
 /*
 * Implementa a classe model MET_TEC_LogMensagens
 * @author Alexandre de Souza
 * @since 18/05/2020
 */ 
class ModelMET_TEC_LogMensagens {
    private $filcgc;
    private $seq;
    private $usucodigo;
    private $datalog;
    private $horalog;
    private $mensagem;
    private $lida;

    function getFilcgc(){
       return $this->filcgc;
    }
    function setFilcgc($filcgc){
       $this->filcgc = $filcgc;
    }
    function getSeq(){
       return $this->seq;
    }
    function setSeq($seq){
       $this->seq = $seq;
    }
    function getUsucodigo(){
       return $this->usucodigo;
    }
    function setUsucodigo($usucodigo){
       $this->usucodigo = $usucodigo;
    }
    function getDatalog(){
       return $this->datalog;
    }
    function setDatalog($datalog){
       $this->datalog = $datalog;
    }
    function getHoralog(){
       return $this->horalog;
    }
    function setHoralog($horalog){
       $this->horalog = $horalog;
    }
    function getMensagem(){
       return $this->mensagem;
    }
    function setMensagem($mensagem){
       $this->mensagem = $mensagem;
    }
    function getLida(){
       return $this->lida;
    }
    function setLida($lida){
       $this->lida = $lida;
    }
}