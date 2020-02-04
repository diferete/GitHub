<?php
class PersistenciaModUsuario extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbmodusuario');
        
        $this->adicionaRelacionamento('usucodigo','User.usucodigo',true,true);
        $this->adicionaRelacionamento('modcod', 'Modulo.modcod',true,true);
        $this->adicionaRelacionamento('modordem', 'modordem');
        
        $this->adicionaJoin('Modulo');
        $this->adicionaJoin('User');
       
    }
    
   /*
    * Método que retorna o modulo inicial ou todos os módulos do usuário
    */
   public function modUserSistema($bInicial,$sModulo){
       if ($bInicial){
           $sSql = "select tbmodusuario.modcod,modescricao from tbmodusuario left outer join 
                    tbmodulo on tbmodusuario.modcod = tbmodulo.modcod
                    where usucodigo =".$_SESSION['codUser']." and modordem = 1";
           $result = $this->getObjetoSql($sSql);
           while($row = $result->fetch(PDO::FETCH_OBJ)){
           $aqt[] = $row->modescricao;
           $aqt[] = $row->modcod;
           }
           return $aqt;
           }else
       {
         $sSql= "select tbmodusuario.modcod,modescricao from tbmodusuario left outer join 
                    tbmodulo on tbmodusuario.modcod = tbmodulo.modcod
                    where usucodigo =".$_SESSION['codUser']."";
         if (isset($sModulo)){
             $sSql.=" and tbmodusuario.modcod =".$sModulo." ";
         }
         $sSql.=" order by tbmodusuario.modordem ";
         $result = $this->getObjetoSql($sSql);
         while ($row = $result->fetch(PDO::FETCH_OBJ)){
             $aqt = array();
             $aqt[] = $row->modescricao;
             $aqt[] = $row->modcod;
             $aRet[] = $aqt;
         }
         return $aRet;
       }
   }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

