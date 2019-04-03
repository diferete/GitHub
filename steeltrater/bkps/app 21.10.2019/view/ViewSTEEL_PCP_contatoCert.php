<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_contatoCert extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oEmpcod = new CampoConsulta('Cnpj','emp_codigo');
        $oEmpcod->setILargura(100);
        $oEmpdes = new CampoConsulta('Cliente','DELX_CAD_Pessoa.emp_razaosocial');
        $oEmpdes->setILargura(400);
        
        
       $oEmpCertContato = new CampoConsulta('Contato','empcertemail');
        
       $oFiltroCli = new Filtro($oEmpdes, Filtro::CAMPO_TEXTO,3);
       
       $this->addFiltro($oFiltroCli);
       
       $this->setUsaAcaoAlterar(false);
        
        $this->addCampos($oEmpcod,$oEmpdes,$oEmpCertContato);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        //$oEmpcod = new Campo('Cnpj','emp_codigo', Campo::TIPO_TEXTO,2);
        //$oEmpcod->addValidacao(false, Validacao::TIPO_STRING,'');
        
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
        
        //declarar o campo descrição
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo',$this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial',$oEmp_des->getId(),  $this->getTela()->getId());
        
        $oEmpCertContato = new Campo('E-mail','empcertemail', Campo::TIPO_TEXTO,3);
        $oEmpCertContato->addValidacao(false, Validacao::TIPO_EMAIL);
        
        $this->addCampos(array($oEmp_codigo,$oEmp_des),$oEmpCertContato);
        
    }
    
    
}