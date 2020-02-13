<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerAutPrecoItem extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('AutPrecoItem');
        
        
    }
    
    /**
     * Verifica se item se encontra com preço liberado
     */
    public function libePorItem($aDados){
        return $this->Persistencia->verificaLibItem($_SESSION['codUser'],$aDados[7],$aDados[8],$aDados[4]);
        
    }
    /**
     * Função que insere uma liberação
     */
    public function insereLib($sDados){
         $aCampos = array();
         parse_str($_REQUEST['campos'],$aCampos);
         //troca underline por ponto
         if($aCampos['quant']=='0' || $aCampos['codigo']==''){
            $oMensagem = new Modal('Atenção', 'Quantidade e código são obrigatórios!', Modal::TIPO_AVISO, false, true, true);
            $oMensagem->setSBtnConfirmar('OK');
            echo $oMensagem->getRender();
         }else{
            $aDados = explode(',', $sDados);
            $aInsert['tipo'] = $aDados[0];
            $aInsert['nr']   =$aDados[1];
            $aInsert['codigo'] = $aDados[2];
            $aInsert['descricao'] = $aCampos['descricao'];
            $aInsert['preco'] = $aDados[4];
            $aInsert['unitario'] = $aDados[5];
            $aInsert['totaldesconto']=$aDados[6];
            $aInsert['precokg']=$aDados[7];
            $aInsert['empcod']=$aDados[8];
            $aInsert['empdes']=$aDados[9];

             $bValida = $this->Persistencia->verificaItenAut($_SESSION['codUser'],$aInsert['tipo'],$aInsert['nr'],$aInsert['codigo']); 

            if($bValida == true){
             $oMensagem = new Modal('Solicitação já inserida!', 'Solicite a remoção dela com vendas para inserir novamente!', Modal::TIPO_AVISO, false, true, true);
             $oMensagem->setSBtnConfirmar('OK');
             echo $oMensagem->getRender();   
            }else
            {
            $aRetorno = $this->Persistencia->insertAprov($aInsert);
            $oMensagem = new Modal('Inserido com sucesso', 'Aguarde aprovação da sua solicitação!', Modal::TIPO_INFO, false, true, true);
            $oMensagem->setSBtnConfirmar('OK');
            echo $oMensagem->getRender();
            }
         }
        
    }
}