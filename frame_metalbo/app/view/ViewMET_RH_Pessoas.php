<?php
/*
 * Implementa a classe view
 * 
 * @author Cleverton Hoffmann
 * @since 16/03/2020
 */

class ViewMET_RH_Pessoas extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setSNomeGrid('GridMET_RH_Pessoas');
        
        $oBotaoFinalizar = new CampoConsulta('Finalizar', 'teste', CampoConsulta::TIPO_FINALIZAR);
        $oBotaoFinalizar->setSTitleAcao('Finalizar Ficha!');
        $oBotaoFinalizar->addAcao('MET_RH_Pessoas', 'msgFinalizaFicha', '', '');
        $oBotaoFinalizar->setBHideTelaAcao(true);
        $oBotaoFinalizar->setILargura(10);
        $oBotaoFinalizar->setSNomeGrid('GridMET_RH_Pessoas');
        
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oNum = new CampoConsulta('Crachá', 'numcad');
        $oDat = new CampoConsulta('Data Admissão', 'datadm');
        $oNom = new CampoConsulta('Nome', 'nome');
        $oSit = new CampoConsulta('Situação', 'sit');
        $oSit->addComparacao('AGUARDANDO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, null);
        $oFun = new CampoConsulta('Função', 'funcao');
        $oEsc = new CampoConsulta('Escala', 'escala');
        $oSet = new CampoConsulta('Setor', 'setor');
        $oCon = new CampoConsulta('Contr. Exp.', 'contexp');
        $oBan = new CampoConsulta('Banco', 'banco');
        $oAgb = new CampoConsulta('Agência', 'agb');
        $oCor = new CampoConsulta('Conta Corrente', 'contac');
        $oNomFiltro = new Filtro($oNom, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);

        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        
        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'FICHA COMPLETA', 'MET_RH_Pessoas', 'acaoMostraRelEspecifico', 'CURSOS', false, 'relFunFichaCursos', false, '', false, '', true, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'FICHA', 'MET_RH_Pessoas', 'acaoMostraRelEspecifico', 'FICHA', false, 'relFunFichaCursos', false, '', false, '', true, false);
       
        $this->addDropdown($oDrop1);
        $this->addFiltro($oNomFiltro);
        $this->setBScrollInf(TRUE);
        $this->addCampos($oBotaoFinalizar,$oSeq,$oNum,$oDat,$oNom,$oFun,$oEsc,$oSet,$oCon,$oBan,$oAgb,$oCor,$oSit);
    }

    public function criaTela() {
        parent::criaTela();

        $aDados = $this->getAParametrosExtras();
        $aDado1 = $aDados[1];
        $aDado2 = $aDados[2];
        $aDado3 = $aDados[3];
        
        $oSeq = new Campo('Seq', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);
        $oNum = new Campo('Crachá', 'numcad', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNum->setBFocus(true);
        $oDat = new Campo('Data Admissão', 'datadm', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oNom = new Campo('Nome Completo', 'nome', Campo::TIPO_TEXTO, 5, 5, 12, 12);
        $oSit = new Campo('Situação', 'sit', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSit->setBOculto(true);
        $oSit->setSValor('AGUARDANDO');
        
        //Função
        $oFun = new Campo('Função', 'funcao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        foreach ($aDado3 as $key1) {
            $oFun->addItemSelect(trim($key1['funcao']), trim($key1['funcao']));
        }
        //Escala
        $oEsc = new Campo('Escala', 'escala', Campo::TIPO_SELECT, 2, 2, 12, 12);
        foreach ($aDado2 as $key1) {
            $oEsc->addItemSelect(trim($key1['escala']), trim($key1['escala']));
        }   
        //Setor
        $oSetor = new Campo('Setor', 'setor', Campo::TIPO_SELECT, 2, 2, 12, 12);
        foreach ($aDado1 as $key1) {
            $oSetor->addItemSelect(trim($key1['setor']), trim($key1['setor']));
        }   
        
        $oCon = new Campo('Contr. Exp.', 'contexp', Campo::CAMPO_SELECT, 1, 1, 12, 12);
        $oCon->addItemSelect('30', '30 dias');
        $oCon->addItemSelect('60', '60 dias');
        $oCon->addItemSelect('90', '90 dias');
        
        $oSal = new Campo('Salário', 'salini', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCur = new Campo('Cursos', 'cursos', Campo::TIPO_TAGS, 12, 12, 12, 12);
        $oBan = new Campo('Banco', 'banco', Campo::CAMPO_SELECT, 2, 2, 12, 12);
        $oBan->addItemSelect('BANCO DO BRASIL','BANCO DO BRASIL');
        $oBan->addItemSelect('BRADESCO','BRADESCO');
        $oBan->addItemSelect('VIACREDI','VIACREDI');
        
        $oAgb = new Campo('Agência', 'agb', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCor = new Campo('Conta Corrente', 'contac', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAne = new Campo('Anexo', 'anexo', Campo::TIPO_UPLOAD, 4, 4, 12, 12);
        
        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $this->addCampos(array($oSeq,$oNum,$oDat,$oSit),$oLinha1,
                array($oNom),$oLinha1,
                array($oFun,$oSetor,$oEsc),$oLinha1, 
                array($oCon, $oSal,$oBan,$oAgb,$oCor),
                $oLinha1,$oCur,$oAne);
    }
}
