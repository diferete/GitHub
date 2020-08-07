<?php
/**
 * Classe responsável pelas operações de persistência do objeto
 * as operações do objeto Ação
 * 
 * @author Everton Porath
 * @since 02/12/2013
 */
class PersistenciaAcao extends Persistencia{
    const ACAO_PADRAO_CONSULTAR  = 1;
    const ACAO_PADRAO_INCLUIR    = 2;
    const ACAO_PADRAO_ALTERAR    = 3;
    const ACAO_PADRAO_EXCLUIR    = 4;
    const ACAO_PADRAO_VISUALIZAR = 5;
    
    public function __construct(){
        parent::__construct();

        $this->setTabela("tbacao");
        
        $this->adicionaRelacionamento('acacodigo','codigo',true,true,true);
        $this->adicionaRelacionamento('acadescricao','descricao',false);
        $this->adicionaRelacionamento('acametodo','metodo',false);
    }
}
?>