<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_TEC_Testes extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaTela() {
        parent::criaTela();

        $this->setBTela(true);

        /*         * ****************** NÃO MAIS UTILIZADO - SALVO PARA REFERENCIA ************************************************
         * Starta metodo simplexml_load_file para abrir arvore de tags de arquivo XML.
         */
        $oBotaoTesteEmail = new Campo('Testar e-mail', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoEmail = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","testarEmail");';
        $oBotaoTesteEmail->getOBotao()->addAcao($sAcaoEmail);

        /*         * ****************** NÃO MAIS UTILIZADO - SALVO PARA REFERENCIA ************************************************
         * Starta metodo simplexml_load_file para abrir arvore de tags de arquivo XML.
         */
        $oBotaoXML = new Campo('XML', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoXML = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","converteXML");';
        $oBotaoXML->getOBotao()->addAcao($sAcaoXML);

        /*         * ****************** NÃO MAIS UTILIZADO - SALVO PARA REFERENCIA ************************************************
         * Starta select/while de procod da MET_PORT_CadVeiculos(deleteda).
         * Usa foreach para dar MET_CAD_Placas com os dados para migração.
         */
        $oBotaoPlaca = new Campo('Migra Placa', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoPlaca = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","inserePlaca");';
        $oBotaoPlaca->getOBotao()->addAcao($sAcaoPlaca);


        /*         * ****************** NÃO MAIS UTILIZADO - SALVO PARA REFERENCIA ************************************************
         * Starta select/while de procod da tbqualNovoProjeto onde valores de grupo,subgrupo,família e subfamilia são null.
         * Usa foreach para dar update na tbqualNovoProjeto com dados da widl.PROD01 onde os valores de grupo,subgrupo,família e subfamilia estão cadastrados no procod da tbqualNovoProjeto.
         */
        $oBotaoGrupo = new Campo('Add Grupo', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoGrupo = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","insereGrupo");';
        $oBotaoGrupo->getOBotao()->addAcao($sAcaoGrupo);

        /*         * ****************** NÃO MAIS UTILIZADO - SALVO PARA REFERENCIA ************************************************
         * Starta select/while de desc_novo_prod,grucod da tbqualNovoProjeto onde desc_novo_prod LIKE '%FRANCES%'.
         * Usa foreach para dar update na tbqualNovoProjeto set grucod = 13.
         */
        $oBotaoGrupo2 = new Campo('Add Grupo 2', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoGrupo2 = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","insereGrupo2");';
        $oBotaoGrupo2->getOBotao()->addAcao($sAcaoGrupo2);


        /*         * ****************** NÃO MAIS UTILIZADO - SALVO PARA REFERENCIA ************************************************
         * Chama método na classe Agendamentos para expirar projetos abertos a mais de 60 sem aprovação do cliente.
         */
        $oBotaoExpiraEmail = new Campo('Expira Projeto c/email', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoExpiraEmail = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","expiraProj");';
        $oBotaoExpiraEmail->getOBotao()->addAcao($sAcaoExpiraEmail);

        /*         * ****************** NÃO MAIS UTILIZADO - SALVO PARA REFERENCIA ************************************************
         * Chama método na classe Agendamentos para expirar projetos abertos a mais de 60 sem aprovação do cliente.
         * Não envia e-mail de notificação para o representante
         * **************************USAR ESSE MÉTODO PARA TESTAR/EXPIRAR PROJETOS NA BASE DE TESTE.*******************************
         */
        $oBotaoExpira = new Campo('Expira Projeto s/email', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoExpira = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","atualizaEntProj");';
        $oBotaoExpira->getOBotao()->addAcao($sAcaoExpira);

        $this->addCampos(array($oBotaoTesteEmail, $oBotaoExpira, $oBotaoExpiraEmail));
    }

}
