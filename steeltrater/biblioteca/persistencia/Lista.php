<?php
/**
 * Classe que implementa a estrutura de listas
 * 
 * @author Fernando Salla
 * @since 30/06/2013 
 */

class Lista{
    private $aItens = array();
    
    /**
     * Retorna o array de itens da lista
     * Pode ser retornada apenas a posi��o desejada ou todo o vetor
     * 
     * @param integer $iPosicao Posi��o do vetor a ser retornada (opcional)
     * 
     * @return Array
     */
    public function getArrayItem($iPosicao = -1){
        return $iPosicao === -1 ? $this->aItens : $this->aItens[$iPosicao];
    }
    
    /**
     * M�todo que adiciona itens a lista
     * 
     * @param $xValor Valor a ser armazenado no campo que ser� manipulado pelo sistema
     * @param $xDescricao Descri��o a ser apresentada ao usu�rio 
     */
    public function addItem($xValor, $xDescricao){
        $this->aItens[] = array($xValor,$xDescricao);
    }
}
?>