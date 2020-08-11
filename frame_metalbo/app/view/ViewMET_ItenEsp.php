<?php 
 /*
 * Implementa a classe view MET_ItenEsp
 * @author Cleverton Hoffmann
 * @since 10/07/2020
 */
 
class ViewMET_ItenEsp extends View {
 
    public function __construct() {
        parent::__construct();
       }
 
    public function criaConsulta() { 
        parent::criaConsulta();
 
        $this->setUsaAcaoVisualizar(true);
        
 
        $oProcod = new CampoConsulta('Cod Produto', 'procod', CampoConsulta::TIPO_TEXTO);
        $oProcod->setSOperacao('personalizado');
        $oProDes = new CampoConsulta('Descrição', 'Produto.prodes', CampoConsulta::TIPO_TEXTO);
        $oTipoEsp = new CampoConsulta('Tipo Esp.', 'tipoEsp', CampoConsulta::TIPO_TEXTO);
 
        $this->addCampos($oProcod,$oProDes, $oTipoEsp);
        
        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("' . $this->getTela()->getSId() . '-form","MET_ItenEsp","calculoPersonalizado",chave+",qualaqtempo");');
        
        $oFiltroCod = new Filtro($oProcod, Filtro::CAMPO_TEXTO);
        
        $this->addFiltro($oFiltroCod);

        //$this->setBScrollInf(FALSE);
        $this->getTela()->setBUsaCarrGrid(true);

    }
 
    public function criaTela() { 
        parent::criaTela();
 
        $oTipoEsp = new Campo('Tipo Esp.', 'tipoEsp', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oImagem = new Campo('Imagem', 'imagem', Campo::TIPO_UPLOAD, 1, 1, 12, 12);
        
        //campo código do produto
        $oProcod = new Campo('Codigo', 'procod', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oProcod->setSIdHideEtapa($this->getSIdHideEtapa());
        $oProcod->setBFocus(true);
        $oProcod->addValidacao(false, Validacao::TIPO_STRING);

        //campo descrição do produto adicionando o campo de busca
        $oProdes = new Campo('Produto', 'Produto.prodes', Campo::TIPO_BUSCADOBANCO, 3);
        $oProdes->setSIdPk($oProcod->getId());
        $oProdes->setClasseBusca('Produto');
        $oProdes->addCampoBusca('procod', '', '');
        $oProdes->addCampoBusca('prodes', '', '');
        $oProdes->setSIdTela($this->getTela()->getid());
        $oProdes->setBCampoBloqueado(true);
                
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oProcod->setClasseBusca('Produto');
        $oProcod->setSCampoRetorno('procod', $this->getTela()->getId());
        $oProcod->addCampoBusca('prodes', $oProdes->getId(), $this->getTela()->getId());
 
        $this->addCampos(array($oProcod,$oProdes), $oTipoEsp, $oImagem);
    } 
}