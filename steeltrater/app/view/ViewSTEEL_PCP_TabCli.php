<?php

/*
 * Classe que implementa as view STEEL_PCP_TabCli
 * 
 * @author Cleverton Hoffmann
 * @since 22/11/2018
 */

class ViewSTEEL_PCP_TabCli extends View {

    public function criaConsulta() {
        parent::criaConsulta();
        
        $oEmp_codigo = new CampoConsulta('Codigo', 'cod');
        $oEmpCod = new CampoConsulta('Empresa', 'emp_codigo');
        $oPrecoCod = new CampoConsulta('Cód.Preço', 'tab_preco');
               
        $oEmpfiltro = new Filtro($oEmp_codigo, Filtro::CAMPO_TEXTO_IGUAL, 5);
       
        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oEmpfiltro);

        $this->setBScrollInf(true);
        $this->addCampos($oEmp_codigo, $oEmpCod, $oPrecoCod); 
    }

    public function criaTela() {
        parent::criaTela();
       
        
        $oCod = new Campo('Codigo', 'cod', Campo::TIPO_TEXTO,2,2,2);
        $oCod->setBCampoBloqueado(true);

        //cliente
        $oEmp_codigo = new Campo('Cliente','emp_codigo',Campo::TIPO_BUSCADOBANCOPK,2);
        $oEmp_codigo->addValidacao(false, Validacao::TIPO_STRING);
        
        //campo descrição do produto adicionando o campo de busca
        $oEmp_des = new Campo('Razão Social','emp_razaosocial',Campo::TIPO_BUSCADOBANCO, 4);
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
        
       // $oPrecoCod = new Campo('Cód.Preço', 'CPG_Codigo', Campo::TIPO_BUSCADOBANCOPK,2,2,2);
        //cliente
        $oPrecoCod = new Campo('Cod.Preço','tab_preco',Campo::TIPO_BUSCADOBANCOPK,2);
        $oPrecoCod->setClasseBusca('STEEL_PCP_Preco');        
        $oPrecoCod->setSCampoRetorno('tpv_codigo', $this->getTela()->getId()); 
        $oPrecoCod->addValidacao(false, Validacao::TIPO_STRING);
       
        $this->addCampos(
                $oCod,array($oEmp_codigo,$oEmp_des),array($oPrecoCod));
    }

}