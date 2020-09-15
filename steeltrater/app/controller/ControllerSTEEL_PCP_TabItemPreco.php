<?php

/* 
 * Implementa a classe controler STEEL_PCP_TabItemPreco
 * 
 * @author Cleverton Hoffmann
 * @since 04/02/2018
 */


class ControllerSTEEL_PCP_TabItemPreco extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_TabItemPreco');
    }
    
     public function pkDetalhe($aChave) {
        parent::pkDetalhe();
        $this->View->setAParametrosExtras($aChave);
        }
        
      public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
        if(count($aparam)>0){
          $this->Persistencia->adicionaFiltro('nr',$aparam[0]);//emp_codigo
          }  else {
          $this->Persistencia->adicionaFiltro('nr',$aparam1[0]);//emp_codigo
          $this->Persistencia->setChaveIncremento(false); 
        }
        
        
    }
    
     public function acaoLimpar($sForm,$sDados) {
        parent::acaoLimpar($sDados);
        $sScript = '$("#'.$sForm.'").each (function(){ this.reset();});';
        echo $sScript;
       }
       
       public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&',$aChave);
        unset($aCampos[1]);
        foreach ($aCampos as $key => $sCampoAtual) {
           $aCampoAtual = explode('=',$sCampoAtual);
           $aModel = explode('.',$aCampoAtual[0] );
           $this->Persistencia->adicionaFiltro($aModel[0], $aCampoAtual[1]);
          
        }
        
        $this->Persistencia->setChaveIncremento(false);
        
    }
    
      public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
       
         $this->Persistencia->adicionaFiltro('seq',  $this->Model->getSeq());
    }
    
    public function antesCarregaDetalhe($aCampos) {
        parent::antesCarregaDetalhe($aCampos);
           $this->Model->setPreco(number_format($this->Model->getPreco(), 2, ',', '.'));
           return $aCampos;   
    }
    
    public function pesquisaGrupoServInsumo($sCampos){
        $aIds = explode(',', $sCampos);
         $sChave = htmlspecialchars_decode($_REQUEST['campos']);
         $aCamposChave = array();
         parse_str($sChave, $aCamposChave);
         
         $oProd = Fabrica::FabricarController('STEEL_PCP_Produtos');
         $oProd->Persistencia->adicionaFiltro('pro_codigo',$aCamposChave['prod']);
         $oProdDados = $oProd->Persistencia->consultarWhere();
         
         
         $sNcm = $oProdDados->getPro_ncm();
         $sRetorno='';
         if ($oProdDados->getPro_grupocodigo()=='100'){
             $sRetorno = 'SERVIÇO';
         }
          if ($oProdDados->getPro_grupocodigo()=='101'){
             $sRetorno = 'INSUMO';
         }
          if ($oProdDados->getPro_grupocodigo()=='105'){
             $sRetorno = 'ENERGIA';
         }
         
         echo'$("#' . $aIds[0] . '").val("'.$sRetorno.'");';
         echo'$("#' . $aIds[1] . '").val("'.$sNcm.'");';
         
    }
    
    /**
     * Faz validações antes de inserir nas items
     */
    
    public function beforeInsert() {
        parent::beforeInsert();
        
        //busca ncm do produto
      if($this->Model->getCod()== ''){
        $oProd = Fabrica::FabricarController('STEEL_PCP_Produtos');
        $oProd->Persistencia->adicionaFiltro('pro_codigo',$this->Model->getProd());
        $oProdDados = $oProd->Persistencia->consultarWhere();
        
        $oItems = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
        $oItems->Persistencia->adicionaFiltro('nr', $this->Model->getNr());
        $oItems->Persistencia->adicionaFiltro('receita',$this->Model->getReceita());
        $oItems->Persistencia->adicionaFiltro('tipo', $this->Model->getTipo());
        $oItems->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oProdDados->getPro_ncm());
        
        $iTotal = $oItems->Persistencia->getCount();
        //se o total > 0 para o insert
        if($iTotal >0){
            //$oModal = new Modal('Atenção','Está receita já tem um produto do tipo '.$this->Model->getTipo().' para este NCM, é permitido um insumo e um serviço por receita.', Modal::TIPO_AVISO, false, true, false);
            $oMensagem = new Mensagem('Atençao','Essa ncm já tem insumo cadastrado, verifique se não é necessário informar um tratamento caso a OP for de fio máquina!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        }else{
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }
      }else{
          $oProd = Fabrica::FabricarController('STEEL_PCP_Produtos');
        $oProd->Persistencia->adicionaFiltro('pro_codigo',$this->Model->getProd());
        $oProdDados = $oProd->Persistencia->consultarWhere();
        
        $oItems = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
        $oItems->Persistencia->adicionaFiltro('nr', $this->Model->getNr());
        $oItems->Persistencia->adicionaFiltro('receita',$this->Model->getReceita());
        $oItems->Persistencia->adicionaFiltro('tipo', $this->Model->getTipo());
        $oItems->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm', $oProdDados->getPro_ncm());
        $oItems->Persistencia->adicionaFiltro('cod', $this->Model->getCod());
        
        $iTotal = $oItems->Persistencia->getCount();
        //se o total > 0 para o insert
        if($iTotal >0){
            //$oModal = new Modal('Atenção','Está receita já tem um produto do tipo '.$this->Model->getTipo().' para este NCM, é permitido um insumo e um serviço por receita.', Modal::TIPO_AVISO, false, true, false);
            $oMensagem = new Mensagem('Atençao','Essa ncm já tem insumo cadastrado!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        }else{
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        } 
      }
    }
    
    /**
     * Valida se já ha um insumo, função callBack
     */
    public function callBackInsumos($sDados){
       $this->carregaModel();
       
       $oItems = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');
        $oItems->Persistencia->adicionaFiltro('nr', $this->Model->getNr());
        $oItems->Persistencia->adicionaFiltro('receita',$this->Model->getReceita());
        $oItems->Persistencia->adicionaFiltro('tipo', $this->Model->getTipo());
        
        $iTotal = $oItems->Persistencia->getCount();
        //se o total > 0 para o insert
        if($iTotal >0){
            $oModal = new Modal('Atenção','Está receita já tem um produto do tipo '.$this->Model->getTipo().' é permitido um insumo e um serviço por receita.', Modal::TIPO_AVISO, false, true, false);
            echo $oModal->getRender();
            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        }else{
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }
        
    
    }
    
    
    public function gravaPreco($sDados){
        $aDados = explode(',', $sDados);
        $this->carregaModelString($aDados[3]); 
        $aRetorno = $this->Persistencia->alteraPreco($aDados[2], $this->Model->getNr(),$this->Model->getSeq());
         if($aRetorno[0]){
            $oMensagem = new Mensagem('Sucesso!','Preço alterado.', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        }else{
            $oMensagem = new Mensagem('Atenção!','Preço não foi alterado '.$aRetorno[1], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
        }
    }


}

