<?php

/* 
 *Classe que gerencia a persistencia da classe QualRncVenda
 * 
 * @author Avanei Martendal
 * @since 12/09/2017
 */

class PersistenciaQualRncVenda extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbrncqual');
        
        $this->adicionaRelacionamento('filcgc', 'filcgc',true,true);
        $this->adicionaRelacionamento('nr','nr',true,true,true);
        $this->adicionaRelacionamento('empcod', 'Pessoa.empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('celular', 'celular');
        $this->adicionaRelacionamento('email', 'email');
        $this->adicionaRelacionamento('contato','contato');
        $this->adicionaRelacionamento('ind', 'ind');
        $this->adicionaRelacionamento('comer', 'comer');
        
        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('datains', 'datains');
        $this->adicionaRelacionamento('horains', 'horains');
        
        $this->adicionaRelacionamento('nf','nf');
        $this->adicionaRelacionamento('datanf','datanf');
        $this->adicionaRelacionamento('odcompra','odcompra');
        $this->adicionaRelacionamento('pedido','pedido');
        $this->adicionaRelacionamento('valor','valor');
        $this->adicionaRelacionamento('peso','peso');
        
        $this->adicionaRelacionamento('lote', 'lote');
        $this->adicionaRelacionamento('op', 'op');
        $this->adicionaRelacionamento('naoconf', 'naoconf');
        
        $this->adicionaRelacionamento('procod', 'procod');
        $this->adicionaRelacionamento('prodes', 'prodes');
        $this->adicionaRelacionamento('aplicacao', 'aplicacao');
        $this->adicionaRelacionamento('quant', 'quant');
        
        $this->adicionaRelacionamento('quantnconf', 'quantnconf');
        $this->adicionaRelacionamento('aceitocond', 'aceitocond');
        $this->adicionaRelacionamento('reprovar', 'reprovar');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('nome', 'nome');
        
        $this->adicionaRelacionamento('anexo1','anexo1');
        $this->adicionaRelacionamento('anexo2','anexo2');
        $this->adicionaRelacionamento('anexo3','anexo3');
       
        
        
        
        $this->adicionaRelacionamento('officecod', 'officecod');
        $this->adicionaRelacionamento('officedes', 'officedes');
        
        $this->adicionaRelacionamento('situaca','situaca');
        
        $this->adicionaRelacionamento('obsSit','obsSit');
        
        $this->adicionaRelacionamento('resp_venda_cod','resp_venda_cod');
        $this->adicionaRelacionamento('resp_venda_nome','resp_venda_nome');
    

       
        $this->adicionaJoin('Pessoa');
        
        
        
        $this->adicionaOrderBy('nr',1);
    
        
    }
    
    public function verificaFim($aDados){
        $sSql = "select count(*)as total from tbrncqual 
                where  filcgc ='".$aDados['filcgc']."' 
                and nr = ".$aDados['nr']."
                and situaca = 'Finalizado'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aret = array();
        if($oRow->total > 0){
           $aret[] = false;
        }else{
           $aret[] = true;
        }
        return $aret; 
    }
    /**
     * Finaliza reclamação 
     */
    
    public function finalizaAcao($aDados){
         date_default_timezone_set('America/Sao_Paulo');
        $sHora =date('H:i');
        $sData = date('d/m/Y');
        
        $sSql = "update tbrncqual set situaca = 'Finalizado',
                obs_fim ='".$aDados['obs_fim']."',datafim='".$sData."',
                horafim = '".$sHora."',usucod_fim = '".$_SESSION['codUser']."',usunome_fim ='".$_SESSION['nome']."'
                where filcgc ='".$aDados['filcgc']."' and nr ='".$aDados['nr']."'"; 
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }
}
