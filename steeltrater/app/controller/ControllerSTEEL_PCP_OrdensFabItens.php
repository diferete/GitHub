<?php

/* 
 *Controller da produção steel
 * 
 * @author Avanei Martendal
 * 
 * @since 25/06/2018
 */
class ControllerSTEEL_PCP_OrdensFabItens extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_OrdensFabItens');
    }
    
    //método para inserir os itens da ordem de produção
    public function itensOrdem($oModelFab){
        $sReceita = $oModelFab->getReceita();
        $this->Persistencia->adicionaFiltro('op',$oModelFab->getOp());
        $this->Persistencia->excluir();
        $this->Persistencia->limpaFiltro();
        
        //retorna a receita do item
        $oReceita = Fabrica::FabricarController('STEEL_PCP_ReceitasItens');
        $aReceitaItens = $oReceita->retornaReceita($sReceita);
        $key = 1;
        foreach ($aReceitaItens as $key => $oReceitaItens) {
            $key = $key +1;
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
            
            $this->Persistencia->inserir();
            
        }
        
        
        
    }
}

