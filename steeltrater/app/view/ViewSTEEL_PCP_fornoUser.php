<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_fornoUser extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oFornoCod = new CampoConsulta('Código Forno', 'fornocod');
        $oFornoCod->setILargura(100);
        $oUsercod = new CampoConsulta('User Cod', 'Usercod');
        $oFiltro1 = new Filtro($oFornoCod, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12, false);
        $oFiltro2 = new Filtro($oUsercod, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12, false);
        $this->addFiltro($oFiltro1, $oFiltro2);

        $this->setUsaAcaoAlterar(false);

        $this->addCampos($oFornoCod, $oUsercod);
    }

    public function criaTela() {
        parent::criaTela();

        $oFornoCod = new Campo('Código do forno', 'fornocod', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oFornoCod->addValidacao(false, Validacao::TIPO_STRING);
        $oFornoCod->setClasseBusca('STEEL_PCP_Forno');
        $oFornoCod->setSCampoRetorno('fornocod', $this->getTela()->getId());
        $oUsercod = new Campo('Código Usuário', 'usercod', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oUsercod->addValidacao(false, Validacao::TIPO_STRING);
        $oUsercod->setClasseBusca('MET_TEC_Usuario');
        $oUsercod->setSCampoRetorno('usucodigo', $this->getTela()->getId());

        $this->addCampos($oFornoCod, $oUsercod);

        /* $oCod = new Campo('Código', 'pro_codigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
          $oCod->addValidacao(false, Validacao::TIPO_STRING);
          $oCod->setClasseBusca('DELX_PRO_Produtos');
          $oCod->setSCampoRetorno('pro_codigo',$this->getTela()->getId());

          $oRes = new Campo('Receita', 'cod_receita', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
          $oRes->addValidacao(false, Validacao::TIPO_STRING);
          $oRes->setClasseBusca('STEEL_PCP_receitas');
          $oRes->setSCampoRetorno('cod',$this->getTela()->getId());
         */
    }

}
