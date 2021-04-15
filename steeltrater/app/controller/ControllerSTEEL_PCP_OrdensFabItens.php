<?php

/*
 * Controller da produção steel
 * 
 * @author Avanei Martendal
 * 
 * @since 25/06/2018
 */

class ControllerSTEEL_PCP_OrdensFabItens extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_OrdensFabItens');
    }

    //método para inserir os itens da ordem de produção
    public function itensOrdem($oModelFab) {
        $aReceitaItens = array();
        $sReceita = $oModelFab->getReceita();
        $sReceitaZinc = $oModelFab->getReceita_zinc();
        $this->Persistencia->adicionaFiltro('op', $oModelFab->getOp());
        $this->Persistencia->excluir();
        $this->Persistencia->limpaFiltro();

        //retorna a receita do item
        $oReceita = Fabrica::FabricarController('STEEL_PCP_ReceitasItens');
        //verifica se op igual somente zincagem não carrega nas etapas 
        if($oModelFab->getTipoOrdem()!=='Z'){
            $aReceitaItens = $oReceita->retornaReceita($sReceita);
        }
        if($sReceitaZinc!=0){
            $oReceita1 = Fabrica::FabricarController('STEEL_PCP_ReceitasItens');
            $aReceitaItensZinc = $oReceita1->retornaReceita($sReceitaZinc);
            foreach ($aReceitaItensZinc as $key1){
                array_push($aReceitaItens,$key1);
            }
        }
        $key = 1;
        foreach ($aReceitaItens as $key => $oReceitaItens) {
            $key = $key + 1;
            $this->Model->setOp($oModelFab->getOp());
            $this->Model->setOpseq($key);
            $this->Model->setReceita($oReceitaItens->getCod());
            $this->Model->setReceita_seq($oReceitaItens->getSeq());
            $this->Model->setTratamento($oReceitaItens->getSTEEL_PCP_Tratamentos()->getTratcod());
            $this->Model->setCamada_min($oReceitaItens->getCamada_min());
            $this->Model->setCamada_max($oReceitaItens->getCamada_max());
            $this->Model->setTemperatura($oReceitaItens->getTemperatura());
            $this->Model->setTempo($oReceitaItens->getTempo());
            $this->Model->setResfriamento($oReceitaItens->getResfriamento());
            $this->Model->setCamadaEspessura($oReceitaItens->getCamadaEspessura());
            $this->Model->setTempoZinc($oReceitaItens->getTempoZinc());
            $this->Model->setPesoDoCesto($oModelFab->getPesoDoCesto());
                        
            $this->Persistencia->inserir();
        }
    }
    
     //método para inserir os itens da ordem de produção
    public function itensOrdemZincagem($oModelFab) {
        $aReceita = array();
        $this->Persistencia->adicionaFiltro('op', $oModelFab->getOp());
        $aArray = $this->Persistencia->getArrayModel();
        $oReceitas = Fabrica::FabricarController('STEEL_PCP_Receitas');
        foreach ($aArray as $key){
            
            $oReceitas->Persistencia->adicionaFiltro('cod', $key->getReceita());
            $aReceita = $oReceitas->Persistencia->getArrayModel();
            $oModelReceita = $aReceita[0];
            if($oModelReceita->getTipoReceita()=="Zincagem"){
                $this->Persistencia->adicionaFiltro('op', $oModelFab->getOp());
                $this->Persistencia->adicionaFiltro('receita', $oModelReceita->getCod());
                $this->Persistencia->excluir();
                $this->Persistencia->limpaFiltro();
            }
            $oReceitas->Persistencia->limpaFiltro();
        }
        
        $aReceitaItensZinc = array();
        $this->Persistencia->adicionaFiltro('op', $oModelFab->getOp());
        $aReceita = $this->Persistencia->getArrayModel();
        $key = count($aReceita);
        $sReceitaZinc = $oModelFab->getReceita_zinc();
        $oReceita1 = Fabrica::FabricarController('STEEL_PCP_ReceitasItens');
        $aReceitaItensZinc = $oReceita1->retornaReceita($sReceitaZinc);
        foreach ($aReceitaItensZinc as $oReceitaItens) {
            $key = $key + 1;
            $this->Model->setOp($oModelFab->getOp());
            $this->Model->setOpseq($key);
            $this->Model->setReceita($oReceitaItens->getCod());
            $this->Model->setReceita_seq($oReceitaItens->getSeq());
            $this->Model->setTratamento($oReceitaItens->getSTEEL_PCP_Tratamentos()->getTratcod());
            $this->Model->setCamada_min($oReceitaItens->getCamada_min());
            $this->Model->setCamada_max($oReceitaItens->getCamada_max());
            $this->Model->setTemperatura($oReceitaItens->getTemperatura());
            $this->Model->setTempo($oReceitaItens->getTempo());
            $this->Model->setResfriamento($oReceitaItens->getResfriamento());
            $this->Model->setCamadaEspessura($oReceitaItens->getCamadaEspessura());
            $this->Model->setTempoZinc($oReceitaItens->getTempoZinc());
            $this->Model->setPesoDoCesto($oModelFab->getPesoDoCesto());
            
            $this->Persistencia->inserir();
        }
    }
    

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        //$oDadosEnt = Fabrica::FabricarController('STEEL_PCP_ordensFabApontEnt');
        //busca o apontamento da ordem de producao
        $oDadosEnt = Fabrica::FabricarController('STEEL_PCP_ordensFab');
        $oDadosEnt->Persistencia->adicionaFiltro('op', $aCamposChave['op']);
        $oDadosOp = $oDadosEnt->Persistencia->consultarWhere();

        //verifica se há op apontada
        if ($oDadosOp->getOp() == null) {
            $oMensagem = new Mensagem('Ordem de produção não encontrada!', 'Não será listado as etapas do processo.', Mensagem::TIPO_WARNING, 5000);
            //echo $oMensagem->getRender();
            $this->Persistencia->adicionaFiltro('op', '0');
        } else {
            if (isset($aCamposChave['op'])) {
                if ($aCamposChave['op'] !== '') {
                    $this->Persistencia->adicionaFiltro('op', $aCamposChave['op']);
                }
            }
        }
        //busca as etapas que a flag recApont = SIM
        $oReceita = Fabrica::FabricarController('STEEL_PCP_ReceitasItens');
        $oReceita->Persistencia->adicionaFiltro('cod', $oDadosOp->getReceita());
        $oReceita->Persistencia->adicionaFiltro('recapont', 'SIM');
        $aDados = $oReceita->Persistencia->getArrayModel();
        foreach ($aDados as $key => $oValue) {
            $aDados[$key] = $oValue->getSeq();
        }


        $this->Persistencia->adicionaFiltro('receita_seq', $aDados, 0, 9);
    }

}
