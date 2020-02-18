<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 28/02/2019
 */

class ViewSTEEL_PCP_PesoCaixas extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oNr = new CampoConsulta('Nr', 'nr');
        $oEmpCod = new CampoConsulta('Empresa','empcodigo');
        $oTipoCaixa = new CampoConsulta ('Tipo Caixa','tipoCaixa');
        $oPadrao = new CampoConsulta('Padrao', 'padrao');
        $oPeso = new CampoConsulta('Peso','peso');
        
        $oDescricaofiltro = new Filtro($oTipoCaixa, Filtro::CAMPO_TEXTO,7);

        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oNr, $oEmpCod, $oTipoCaixa, $oPadrao,$oPeso);
    }

    public function criaTela() {
        parent::criaTela();

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNr->setBCampoBloqueado(true);
        
        $oEmp_codigo = new Campo('Cliente','empcodigo',Campo::TIPO_BUSCADOBANCOPK,2);
        $oEmp_codigo->addValidacao(false, Validacao::TIPO_STRING);
        
        //campo descrição do produto adicionando o campo de busca
        $oEmp_des = new Campo('Razão Social','teste',Campo::TIPO_BUSCADOBANCO, 4);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '','');
        $oEmp_des->addCampoBusca('emp_razaosocial', '','');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        $oEmp_des->addValidacao(false, Validacao::TIPO_STRING);
        $oEmp_des->setApenasTela(true);
        
        //declarar o campo descrição
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo',$this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial',$oEmp_des->getId(),  $this->getTela()->getId());
        
        $oTipoCaixa = new Campo('Tipo Caixa','tipoCaixa', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPadrao = new Campo('Padrao', 'padrao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPadrao->addItemSelect('Sim','Sim');
        $oPadrao->addItemSelect('Não','Não');
        
        $oPeso = new campo('Peso','peso', Campo::TIPO_DECIMAL,2,2,2,2);

        $this->addCampos($oNr, array($oEmp_codigo, $oEmp_des), $oTipoCaixa, $oPadrao,$oPeso);
    }

}