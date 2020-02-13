<?php

class PersistenciaMobUsuModulos extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbmobusumodulos');
        
        
        
        $this->adicionaRelacionamento('id', 'id',true,true,true);
        $this->adicionaRelacionamento('mobmodordem', 'mobmodordem');
        $this->adicionaRelacionamento('usucodigo', 'User.usucodigo',true,true);
        $this->adicionaRelacionamento('mobmodcod ', 'MobModulos.mobmodcod',true,true);
        
        $this->adicionaJoin('User');
        $this->adicionaJoin('MobModulos');
    }
    
    
    public function getModulos($usuCodigo){

        if(!empty($usuCodigo)){
            $retorno[0] = true;        
            $sql =  "select tbmobmodulos.mobmodcod, mobmoddesc, mobmodrota, mobmodicon, usunome from tbmobusumodulos "
                    ."left outer join tbmobmodulos "
                    ."on tbmobusumodulos.mobmodcod = tbmobmodulos.mobmodcod "
                    ."left outer join tbusuario "
                    ."on tbusuario.usucodigo = tbmobusumodulos.usucodigo "
                    ."where tbmobusumodulos.usucodigo = ".$usuCodigo
                    ." order by mobmodordem";
            
            $result = $this->getObjetoSql($sql);
            while($row = $result->fetch(PDO::FETCH_OBJ)){
               
                $Modulo['mobmodcod'] = $row->mobmodcod ;
                $Modulo['mobmoddesc'] = $row->mobmoddesc;
                $Modulo['mobmodrota'] = $row->mobmodrota;
                $Modulo['mobmodicon'] = $row->mobmodicon;
                        
                $aModulos[] = $Modulo;
            }
            
            return $aModulos;
        }else{
            return $retorno = false;
        }
       
    }
}