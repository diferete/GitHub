<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 10/09/2018
 */

class ControllerMET_ItensManPrev extends Controller {

    function __construct() {
        $this->carregaClassesMvc('MET_ItensManPrev');
    }

    /**
     * Cria tela 
     * @param type $sDados
     * @param type $sCampos
     */
    public function criaPainelItensManPrev($sDados, $sCampos) {
        $aDados = explode(',', $sDados);
        $aCampos = explode(',', $sCampos);
        $this->pkDetalhe($aCampos);
        $this->parametros = $sCampos;
        if ($aDados[7] != '') {
            $this->View->setSRotina($aDados[7]);
        }

        $this->View->setSIdHideEtapa($aDados[4]);
        $this->View->criaTela();
        $this->View->getTela()->setSRender($aDados[3]);
        //define o retorno somente do form
        $this->View->getTela()->setBSomanteForm(true);
        //seta o controler na view
        $this->View->setTelaController($this->View->getController());
        $this->View->adicionaBotoesEtapas($aDados[0], $aDados[1], $aDados[2], $aDados[3], $aDados[4], $aDados[5], $this->getControllerDetalhe(), $this->getSMetodoDetalhe(), $aDados[7]);
        $this->View->getTela()->getRender();
    }

    public function buscaMaqDes($sCodMaq) {

        $oMaqDes = $this->Persistencia->consultaMaqDes($sCodMaq);
        $sMaqDes = $oMaqDes->maquina;
        return $sMaqDes;
    }

    public function buscaDados($sDados) {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aDados = explode(',', $sDados);

        $oRow = $this->Persistencia->consultaDados($aCamposChave['codsit']);

        echo"$('#" . $aDados[0] . "').val('" . $oRow->ciclo . "');"
        . "$('#" . $aDados[1] . "').val('" . $oRow->resp . "');";
    }

    //Novo ------------------------------------------------------------------------------------------------------

    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        $aChave[3] = $this->buscaMaqDes($aChave[2]);
        $this->View->setAParametrosExtras($aChave);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        
        $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
       
        if (count($aparam) > 0) {
            $this->Persistencia->adicionaFiltro('filcgc', $aparam[0]);
            $this->Persistencia->adicionaFiltro('nr', $aparam[1]);
            $this->Persistencia->adicionaFiltro('codmaq', $aparam[2]);                  
            $this->Persistencia->setChaveIncremento(false);
            $this->adidicionaFiltroSet();
        } else {
            $this->Persistencia->adicionaFiltro('filcgc', $aparam1[0]);
            $this->Persistencia->adicionaFiltro('nr', $aparam1[1]);
            $this->Persistencia->adicionaFiltro('codmaq', $this->Model->getCodmaq()); 
            $this->Persistencia->setChaveIncremento(true);
            $this->adidicionaFiltroSet();
        }
    }

    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&', $aChave);
        unset($aCampos[2]);
        foreach ($aCampos as $key => $sCampoAtual) {
            $aCampoAtual = explode('=', $sCampoAtual);
            $aModel = explode('.', $aCampoAtual[0]);
            $this->Persistencia->adicionaFiltro($aModel[0], $aCampoAtual[1]);
        }

        $this->Persistencia->setChaveIncremento(false);
    }

    public function acaoLimpar($sForm, $sDados) {
        parent::acaoLimpar($sDados);
        $aParam = explode(',', $sDados);

        //verifica se está como 
        $sScript = '$("#' . $sForm . '").each (function(){ this.reset();});';
        echo $sScript;
    }

    //-----------------------------------------------------------------------------------------------------------

    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();

        $this->Persistencia->adicionaFiltro('seq', $this->Model->getSeq());
       // $this->Persistencia->adicionaFiltro('codmaq', $this->Model->getCodmaq());
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $iCodSit = $aCamposChave['codsit'];
        $iCodMaq = $aCamposChave['codmaq'];

        $iCont = $this->Persistencia->verificaServico($iCodMaq, $iCodSit);

        if ($iCont != 0) {
            $oModal = new Modal('Atenção', 'O Serviço já está aberto para a máquina!', Modal::TIPO_AVISO);
            echo $oModal->getRender();
            exit();
        }
        
        $this->verificaServicoMaquina();
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    /**
     * Verifica serviços por máquinas
     */
     public function verificaServicoMaquina(){
         
        $sDados = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sDados, $aCamposChave);
        
        $bBol = $this->Persistencia->verificaCampoValido($aCamposChave['codsit'], $aCamposChave['MET_ServicoMaquina_servico']);
        
        if (!$bBol||$aCamposChave['MET_ServicoMaquina_servico']=='') {
            $oModal = new Modal('Atenção', 'Serviço Incorreto! Selecione novamente o serviço!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }   
    }
    
    
    /*
     * Mensagem de finalização do serviço
     */
    public function msgFinalizaServ($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $this->Persistencia->adicionaFiltro('seq', $aCamposChave['seq']);
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $oSeqAtual = $this->Persistencia->consultarWhere();
        $this->getMetodoCriaTela();
        $var = $_GET['nome'];
        if ($oSeqAtual->getSitmp() !== 'ABERTO') {
            $oMensagem = new Modal('Atenção!', 'O serviço Nº' . $aCamposChave['seq'] . ' não pode ser finalizado, somente é possível finalizar serviços em aberto!', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem->getRender();
        } else {

            $oMensagem = new Modal('Atenção!', 'Deseja finalizar o serviço ' . $aCamposChave['seq'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("' . $aDados[3] . '-form","' . $sClasse . '","finalizaServ","' . $sDados . '");');
            echo $oMensagem->getRender();
        }
    }

    /*
     * Finaliza a o Serviço
     */
    public function finalizaServ($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $this->Persistencia->adicionaFiltro('seq', $aCamposChave['seq']);
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $oDados = $this->Persistencia->consultarWhere();

        //chama o método na persistencia
        $aRetorno = $this->Persistencia->finalizarServico($aCamposChave);

        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('Atenção!', 'O serviço ' . $aCamposChave['seq'] . ' foi finalizado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Mensagem('Erro!', 'O serviço ' . $aCamposChave['seq'] . ' não foi finalizado com sucesso! >>>>' . $aRetorno[1], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
        }

        $this->Persistencia->limpaFiltro();
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $this->Persistencia->adicionaFiltro('codmaq', $oDados->getCodmaq());
        $this->Persistencia->adicionaFiltro('sitmp', 'ABERTO');
        $this->adidicionaFiltroSet();
        $this->getDadosConsulta($aDados[1], TRUE, null);
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        //Adiciona filtro apenas no cria consulta da tela detalhe
        if (($_REQUEST['metodo'] == 'acaoTelaDetalhe') || ($_REQUEST['metodo'] == 'acaoDetalheIten')) {
            $this->Persistencia->adicionaFiltro('sitmp', 'ABERTO');
            $this->adidicionaFiltroSet();
        }
        $this->Persistencia->atualizaDataAntesdaConsulta();
    }
    
    public function antesCarregaDetalhe($aCampos) {
        parent::antesCarregaDetalhe($aCampos);
        
        //Habilita a inserção de dados nos campos dos IDs
         echo  "$('#" . $aCampos[8][1] . "').prop('readonly', true);";
         echo  "$('#" . $aCampos[9][1] . "').prop('readonly', true);";
         echo  "$('#" . $aCampos[8][1] . "-btn').prop('disabled', true);";
         
         return $aCampos;
    }
    
    public function beforeUpdate() {
        parent::beforeUpdate();
        
        $aIds = $_REQUEST['parametros'];
        $aIds2 = explode(',', $aIds['parametros[']);
        
        //Desabilita a inserção de dados nos campos dos IDs
        echo  "$('#" . $aIds2[4] . "').prop('readonly', false);";
        echo  "$('#" . $aIds2[3] . "').prop('readonly', false);";
        echo  "$('#" . $aIds2[3] . "-btn').attr('disabled', false);";
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }
    
    /**
     * Busca os dados do Serviço e o que fazer
     * @param type $sDados
     */
    public function camposGrid($sDados){
        $aDados = explode(',',$sDados);
        $aDad = explode('=', $aDados[1]);
        $aDad2 = explode('&', $aDad[2]);
        
        //busca a descrição do serviço passando seq/nr
        $sDes = $this->Persistencia->buscaDescricao($aDad[3],$aDad2[0]);
        $sOqf = $this->Persistencia->buscaOqueFazer($aDad[3],$aDad2[0]);
        echo '$("#'.$aDados[2].'").val("'.$sDes.'");';
        echo '$("#'.$aDados[3].'").val("'.$sOqf.'");';
    }
    
    /**
     * Adiciona filtro por responsável pela Manutenção Preventiva
     */
    public function adidicionaFiltroSet(){
         $sCodSet = $_SESSION['codsetor'];
            if($sCodSet=='2'){
            }else if($sCodSet=='12'){
                $this->Persistencia->adicionaFiltro('MET_ServicoMaquina.resp', 'MANUTENCAO');
            }else if($sCodSet=='29'){
                $this->Persistencia->adicionaFiltro('MET_ServicoMaquina.resp', 'MECANICA');                
            }else{
                $this->Persistencia->adicionaFiltro('MET_ServicoMaquina.resp', 'OPERADOR');
            }
    }
    
}
