<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMovFornoSteel extends Controller{
    public function __construct() {
        $this->carregaClassesMvc("MovFornoSteel");
    }
    
    public function getDadosSteel($sDados){
        $oMensagemPesq = new Mensagem('Pesquisanto API_STEEL', 'https://steelfornos.ddns.net:8080/api_steel', Mensagem::TIPO_INFO);
        echo $oMensagemPesq->getRender();
         date_default_timezone_set('America/Sao_Paulo');
         $sDataAnt =date('Y-m-d',strtotime('-7 days'));
         $sData =date('Y-m-d');
         
         $sDataTime =date("Y-m-d H:i:s");
        
        $json_file = file_get_contents("https://steelfornos.ddns.net:8080/api_steel");   //https://steelfornos.ddns.net:8080/api_steel 
        $json_str = json_decode($json_file, true);
        $iCont = count($json_str);
       if($iCont==0){
            $oMensagem = new Modal('Atenção, não foi possível acessar API_STEELTRATER!', 'Contate setor tecnologia da informação.', Modal::TIPO_ERRO);
            echo $oMensagem->getRender();
        }else{
        //deletar os registros de trinta dias
        $aRetorno = $this->Persistencia->deletaReg($sDataAnt,$sData);
        foreach ($json_str as $key => $value) {
            $iNr=$value['nr'];
            //verifica se já existe 
            $this->Persistencia->adicionaFiltro('nr',$iNr);
            $iCount = $this->Persistencia->getCount();
            //alimenta o model
             $this->Model->setNr($value['nr']);
             $this->Model->setOfsteel($value['ofsteel']);
             $this->Model->setProcodCod($value['procodCod']);
             $this->Model->setProdes($value['prodes']);
             $this->Model->setEmpcod($value['empcod']);
             $this->Model->setEmpdes($value['empdes']);
             $this->Model->setOfcliente($value['ofcliente']);
             $this->Model->setDtent($value['dtent']);
             $this->Model->setHoraent($value['horaent']);
             $this->Model->setForno($value['forno']);
             $this->Model->setSit($value['sit']);
             $this->Model->setDtsaida($value['dtsaida']);
             $this->Model->setHorasaida($value['horasaida']);
             $this->Model->setLastRefresch($sDataTime);
             
             //retira aspas da estring do item
              
	      $prodes = str_replace('"', "", $this->Model->getProdes());
              $prodes = str_replace("'", "", $prodes);
              $this->Model->setProdes($prodes);
             
              if ($iCount > 0) {
                  $this->Persistencia->excluir(); 
              }
             //vai inserir
             $aRetorno = $this->Persistencia->inserir();
             $this->Persistencia->limpaFiltro();
              
            
        }
    }
        
    }
    
     public function getSteel($renderTo, $sMetodo = '') {
         parent::criaTelaDiversa($renderTo,'telaGet');
    } 
    
    public function beforFiltroConsulta($sParametros = null) {
        parent::beforFiltroConsulta($sParametros);
       // $this->getDadosSteel('');
    }

    /**
     * Cria relatório
     */
    
     public function relatorioSteel($renderTo, $sMetodo = '') {
         parent::mostraTelaRelatorio($renderTo,'relSteel');
    } 
    
     public function calculoPersonalizado($sParametros = null) {
      parent::calculoPersonalizado($sParametros);
      $sdata = $this->Persistencia->ultimaAtualizacao();
      
      //$date = new DateTime($sdata);
     // $sData = date('d/m/Y H:i:s', strtotime($sdata));
      
      $sResulta='<div class="cor_azul">Útima atualização: '.$sdata.'</div>';
             // . '<div class="cor_azul">Total de ações iniciadas:'.$aTotal['Iniciada'].'</div>Total de ações finalizadas:'.$aTotal['Finalizada'].'';
      return $sResulta;
  }
}