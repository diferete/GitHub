<?php

/* 
 * Classe que implementa a Persistencia da classe QualRnc
 * 
 * @author Avanei Martendal
 * @since 10/09/2017
 */

class PersistenciaQualRnc extends Persistencia{
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
        
         if(isset($_SESSION['repoffice'])){
            
              $this->adicionaFiltro('officecod',$_SESSION['repoffice']);
            
        }
        
        $this->adicionaOrderBy('nr',1);
    
        
    }
    
    public function consultaNf($sNfnro){
        $sSql = "select nfsnfnro,convert(varchar,nfsdtemiss,103)as data,nfspesolq,nfsvlrtot 
                from widl.nfc001 where nfsnfnro ='".$sNfnro."' and nfsnfser = 2";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        
        return $oRow;
    }
    
    public function liberaRc($aDados){
        $sSql = "update tbrncqual set situaca ='Liberado' where filcgc = '".$aDados['filcgc']."' and nr='".$aDados['nr']."'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }
    
     /**
     * busca e-mails representante
     * @param type $sCnpj
     * @param type $sNr
     * @return type
     */
    public function emailRep($sCnpj,$sNr){
        //busca códigos
        $sSql = "select resp_proj_cod,resp_venda_cod,repcod 
                from tbqualNovoProjeto 
                where filcgc ='".$sCnpj."' and nr ='".$sNr."'   ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $codProj=$oRow->resp_proj_cod;
        $codVenda = $oRow->resp_venda_cod;
        $repcod = $oRow->repcod;
        
        //busca email projetos
        
        $sSql = "select usuemail from tbusuario where usucodigo ='".$codProj."' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['proj'] = $oRow->usuemail;
        
        //busca email venda
        $sSql = "select usuemail from tbusuario where usucodigo ='".$codVenda."' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['venda'] = $oRow->usuemail;
        
         //busca email representante
        $sSql = "select usuemail from tbusuario where usucodigo ='".$repcod."' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['rep'] = $oRow->usuemail;
        
        return $aEmail['venda'];
    }
    
}