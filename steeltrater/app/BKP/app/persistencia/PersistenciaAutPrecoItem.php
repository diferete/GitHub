<?php

/* 
 *Persistenca para inseir autorização por item
 * Avanei Martendal
 * 28/07/2016
 */

class PersistenciaAutPrecoItem extends Persistencia{
    public function __construct() {
        parent::__construct();
        $this->setTabela('pdfaut');
        
        $this->adicionaRelacionamento('id', 'id',true);
        $this->adicionaRelacionamento('tipo', 'tipo');
        $this->adicionaRelacionamento('nr','nr');
        $this->adicionaRelacionamento('codigo','codigo');
        $this->adicionaRelacionamento('descricao','descricao');
        $this->adicionaRelacionamento('precotab','precotab');
        $this->adicionaRelacionamento('unitario','unitario');
        $this->adicionaRelacionamento('totaldesconto','totaldesconto');
        $this->adicionaRelacionamento('precoKg','precoKg');
        $this->adicionaRelacionamento('nome','nome');
        $this->adicionaRelacionamento('coduser','coduser');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('hora','hora');
        $this->adicionaRelacionamento('sit','sit');
        $this->adicionaRelacionamento('dataaut','dataaut');
        $this->adicionaRelacionamento('horaaut','horaaut');
        $this->adicionaRelacionamento('obs','obs');
        $this->adicionaRelacionamento('useraprov','useraprov');
        $this->adicionaRelacionamento('codrep','codrep');
        $this->adicionaRelacionamento('empcod','empcod');
        $this->adicionaRelacionamento('empdes','empdes');
        $this->adicionaRelacionamento('qt','qt');
        $this->adicionaRelacionamento('datarep','datarep');
        $this->adicionaRelacionamento('horarep','horarep');
        
        $this->adicionaOrderBy('id', 1);
        $this->setSTop('150');
    }
    /**
     * Gera o insert para aprovação
     */
    
    public function insertAprov($aDados){
        //pesquisa representante
        $oPessoa = Fabrica::FabricarController('Pessoa');
        $sRep = $oPessoa->buscaRep($aDados[empcod]);
        
        
        
        $sSql="insert into pdfaut(tipo,nr,codigo,descricao,precotab,unitario,totaldesconto,precoKg,"
        ."nome,coduser,nomesud,data,hora,sit,codrep,empcod,empdes,qt) "
       ." values ('".$aDados['tipo']."','".$aDados['nr']."','".$aDados['codigo']."',"
       ." '".$aDados['descricao']."','".$aDados['preco']."','".$aDados['unitario']."','".$aDados['totaldesconto']."', "
       . " '".$aDados['precokg']."','". $_SESSION['nome']."','". $_SESSION['codUser']."','WEB', "
       ." CONVERT (date, SYSDATETIME()),CONVERT (time, SYSDATETIME()),'AG','".$sRep."','".$aDados['empcod']."'"
       . ",'".$aDados['empdes']."','20');";
        
       $aRetorno = $this->executaSql($sSql);
       
       return $aRetorno;
       
       
    }
    /**
     * função que verifica se já tem item a ser solicitado
     * 
     */
    
    public function verificaItenAut($sCoduser,$sTipo,$sNr,$sCodigo){
        $sSql ="select COUNT(*) as qt from pdfaut "
        ."where coduser ='".$sCoduser."' "
        ."and tipo ='".$sTipo."'    "
        ."and nr ='".$sNr."'  "
        ."and codigo ='".$sCodigo."'";
        
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        if($row->qt > 0){
          return true;   
        }else{
          return false;
        }
        
        
        
    }
    /*
    * função que valida por item
     * se maior que zero mostra que o item foi liberado por
     * vendas
     * 
     */
    
    public function verificaLibItem($sCoduser,$sTipo,$sNr,$sCodigo){
        $sSql ="select COUNT(*) as qt from pdfaut "
        ."where coduser ='".$sCoduser."' "
        ."and tipo ='".$sTipo."'    "
        ."and nr ='".$sNr."'  "
        ."and codigo ='".$sCodigo."' and sit = 'AP'";
        
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        if($row->qt > 0){
          $sItem = 'Item';
          return $sItem;   
        }else{
          return NULL;
        }
        
        
        
    }
   
}
