<?php 
 /*
 * Implementa a classe persistencia MET_MANUT_OSMaterial
 * @author Cleverton Hoffmann
 * @since 24/08/2021
 */
 
class PersistenciaMET_MANUT_OSMaterial extends Persistencia {
 
    public function __construct() {
        parent::__construct();
 
        $this->setTabela('MET_MANUT_OSMaterial');
        $this->adicionaRelacionamento('fil_codigo','fil_codigo');
        $this->adicionaRelacionamento('nr','nr');
        $this->adicionaRelacionamento('cod','cod');
        $this->adicionaRelacionamento('codmat','codmat', true, true);
        $this->adicionaRelacionamento('descricaomat','descricaomat');
        $this->adicionaRelacionamento('usermatcod','usermatcod');
        $this->adicionaRelacionamento('usermatdes','usermatdes');
        $this->adicionaRelacionamento('datamat','datamat');
        $this->adicionaRelacionamento('quantidade','quantidade');
        $this->adicionaRelacionamento('obsmat','obsmat');
                
        $this->adicionaOrderBy('codmat',1);
        $this->setSTop('30');
    } 
    
    
    public function inserirMat($aCamposChave){
        date_default_timezone_set('America/Sao_Paulo');
        $data = date("d/m/y");  
        $useRMatCod = $_SESSION['codUser'];  
        $useRMatDes = $_SESSION['nome'];  
        
        $sSql = "INSERT INTO MET_MANUT_OSMaterial (fil_codigo, nr, cod, codmat, descricaomat, usermatcod, usermatdes, datamat, quantidade, obsmat) "
                . "VALUES ('" . $aCamposChave['fil_codigo'] . "','" . $aCamposChave['nr'] . "','" . $aCamposChave['cod'] . "','" . $aCamposChave['DELX_PRO_Produtos_pro_codigo'] . "','" . $aCamposChave['matnecessario'] . "','" . $useRMatCod . "','" . $useRMatDes . "','" . $data . "','" 
                . $aCamposChave['quantidade'] . "','" . $aCamposChave['obsmat'] . "')";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }
    
    public function excluirMat($aCamposChave){
        $sSql = " DELETE MET_MANUT_OSMaterial "
                . "WHERE fil_codigo = " . $aCamposChave['fil_codigo'] 
                . " AND nr = " . $aCamposChave['nr'] 
                . " AND cod = " . $aCamposChave['cod'] 
                . " AND codmat = " . $aCamposChave['pro_codigo'] ;
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }
    
}