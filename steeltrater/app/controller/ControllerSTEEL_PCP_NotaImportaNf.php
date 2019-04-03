<?php

/* 
 * Classe que implementa o controller da importação
 * 
 * @author Avanei Martendal 
 * 
 * @since 02/07/2018
 */

class ControllerSTEEL_PCP_NotaImportaNf extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_NotaImportaNf');
    }
    
    public function buscaNota($aCampos){
        //adiciona os filtro
        foreach ($aCampos as $key => $value) {
          $this->Persistencia->adicionaFiltro($key,$value);  
        }
        $oModelImpNotas = $this->Persistencia->consultarWhere();
        
        return $oModelImpNotas;
        
        
    }
    
    public function atualizaOPnf($aCampos){
        $this->Persistencia->atualiaOPnf($aCampos);
        
    }
    
    public function beforFiltroConsulta($sParametros = null) {
       parent::beforFiltroConsulta($sParametros);
       
       if($_REQUEST['parametrosCampos']){
                    foreach ($_REQUEST['parametrosCampos'] as $sAtual){
                        $aFiltros[] =  explode('|',$sAtual) ;
                    }
        }
        
        //busca o filtro nr. da nota
        foreach ($aFiltros as $key => $aValor) {
            if($aValor[0]=='nfsnfnro'){
                 if($aValor[1]>0){
                  $aRetorno = $this->importRomaneioMetalbo($aValor);
                    if($aRetorno[0]==false){
                        $oModel = new Modal('Atenção!', 'Verifica se a nota fiscal é da Metalbo ou '
                                . 'se o número está digitado corretamente!', Modal::TIPO_AVISO);
                        echo $oModel->getRender();
                    }
                    if($aRetorno[0]==='existente'){
                        $oMensagem = new Mensagem('Atenção','Essa nota fiscal já está importada!', Mensagem::TIPO_INFO);
                        echo $oMensagem->getRender();
                    }
                 }
                }
        }
        
        
        
       
   }
   
   public function importRomaneioMetalbo($aFiltros){
       
       //verifica se já tem a nota importada
       $this->Persistencia->adicionaFiltro($aFiltros[0],$aFiltros[1]);  
       
       $iCont = $this->Persistencia->getCount();
       
       $this->Persistencia->limpaFiltro();
       
       
       if($iCont > 0){
           $aRetorno[0]='existente';
       }else{
           $aRetorno=$this->Persistencia->importaNfRomaneio($aFiltros); 
       }
       return $aRetorno;
   }
    
   
}