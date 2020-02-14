<?php

/* 
 * Classe responsável para alterar o profile do usuário
 */

class PersistenciaMET_TEC_Profile extends Persistencia {
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('MET_TEC_usuario');
        $this->adicionaRelacionamento('usucodigo','usucodigo',true,true,true);
        $this->adicionaRelacionamento('usunome','usunome');
        $this->adicionaRelacionamento('usulogin','usulogin');
        $this->adicionaRelacionamento('ususenha','ususenha');
        $this->adicionaRelacionamento('usucracha', 'usucracha');
        $this->adicionaRelacionamento('usuimagem', 'usuimagem');
    }
    
    
    public function validaSenha($Login, $Senha){
        $sSql ="SELECT usucodigo,
                        COUNT(*) as qtd,
                        usubloqueado,
                        usunome,usuimagem
                FROM MET_TEC_usuario
                WHERE usulogin = '".$Login."' 
                AND ususenha='".sha1($Senha)."' 
                group by usunome,usucodigo,usubloqueado,usuimagem";
        

        $result = $this->getObjetoSql($sSql);
        
        $Retorno = false;
        $row = $result->fetch(PDO::FETCH_OBJ);
        if($row->qtd > 0){
            $Retorno = true;
        }
        
        return $Retorno;
    }
   /**
     * Faz a alteraçao da senha
     */
    
    public function redefineSenha($sCodUser,$sSenha){
            $sSql = "update MET_TEC_usuario set ususenha ='".$sSenha."',senhaProvisoria ='false'
                     where usucodigo ='".$sCodUser."'";
            $aRetorno = $this->executaSql($sSql);
            
            return $aRetorno;
    }
    
    /**
     * altera a imagem padrao
     */
    public function alteraImagem($sCodUser,$sImagem){
        //usuimagem
        
        $sSql = "update MET_TEC_usuario set usuimagem ='".$sImagem."'
                     where usucodigo ='".$sCodUser."'";
            $aRetorno = $this->executaSql($sSql);
            
            return $aRetorno;
    }
}