<?php
/**
 * Classe responsável pelas operações de persistência do objeto
 * Menu
 * 
 * @author Fernando Salla
 * @since 28/06/2012 
 */
class PersistenciaMenu extends Persistencia{
    public function __construct(){
        parent::__construct();

        $this->setTabela("tbmenu");
        
        $this->adicionaRelacionamento('modcod','Modulo.modcod',true);
        $this->adicionaRelacionamento('mencodigo','mencodigo',true,true,true);
        $this->adicionaRelacionamento('mendes','mendes');
        $this->adicionaRelacionamento('menordem', 'menordem');
        
        $this->adicionaJoin('Modulo');
        
       

    }   
    /*
     * Método que faz a consulta no banco e 
     * retorna os menus conforme o módulo do sistema
     * 
     */
    public function getMenuModulo($sModulo){
        $sSql = "SELECT modcod,mencodigo,mendes
                FROM tbmenu
                WHERE modcod =".$sModulo." order by menordem";
           $result = $this->getObjetoSql($sSql);
           while($row = $result->fetch(PDO::FETCH_OBJ)){
           $aMenu ='';
           $aMenu[] = $row->mendes;
           $aMenu[] = $row->mencodigo;
           $aRetorno[] = $aMenu;
           }
           return $aRetorno;
    }
}
?>