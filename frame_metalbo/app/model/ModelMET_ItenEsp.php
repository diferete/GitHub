<?php 
 /*
 * Implementa a classe model MET_ItenEsp
 * @author Cleverton Hoffmann
 * @since 10/07/2020
 */
 
class ModelMET_ItenEsp {

    private $Produto;
    private $procod;
    private $tipoesp;
    private $imagem;

    function getProduto() {
        if (!isset($this->Produto)) {
            $this->Produto = Fabrica::FabricarModel('Produto');
        }
        return $this->Produto;
    }

    function setProduto($Produto) {
        $this->Produto = $Produto;
    }    
    
    function getProcod(){
       return $this->procod;
    }
    function setProcod($procod){
       $this->procod = $procod;
    }
    function getTipoesp(){
       return $this->tipoesp;
    }
    function setTipoesp($tipoesp){
       $this->tipoesp = $tipoesp;
    }
    function getImagem(){
       return $this->imagem;
    }
    function setImagem($imagem){
       $this->imagem = $imagem;
    }
}