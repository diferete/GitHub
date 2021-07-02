<?php

/*
 * Classe que implementa o view da classe usuário
 * @author Avanei Martendal
 * @since 25/12/2015
 */

class ViewMET_TEC_Usuario extends View {

    function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setaTiluloConsulta('Pesquisa de Usuários');
        $this->getTela()->setILarguraGrid(1300);

        $oUsucodigo = new CampoConsulta('Código', 'usucodigo', CampoConsulta::TIPO_LARGURA, 5);
        $oUsucodigo->setILargura(10);

        $oUsunome = new CampoConsulta('Usuário', 'usunome', CampoConsulta::TIPO_LARGURA, 5);
        $oUsunome->setILargura(100);

        $UsuSobrenome = new CampoConsulta('Sobrenome', 'ususobrenome', CampoConsulta::TIPO_LARGURA, 5);
        $UsuSobrenome->setILargura(100);

        $oUsuSit = new CampoConsulta('Situação Cad.', 'ususit', CampoConsulta::TIPO_LARGURA, 5);
        $oUsuSit->addComparacao('Cadastro Completo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, '');
        $oUsuSit->addComparacao('Aguardando cadastro', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, false, '');
        $oUsuSit->setILargura(50);

        $oUsuLogin = new CampoConsulta('Login', 'usulogin', CampoConsulta::TIPO_LARGURA, 5);
        $oUsuLogin->setILargura(200);



        $FiltroCodigo = new Filtro($oUsucodigo, Filtro::CAMPO_TEXTO, 1);
        $FiltroUser = new Filtro($oUsunome, Filtro::CAMPO_TEXTO, 3);




        $this->addCampos($oUsucodigo, $oUsunome, $oUsuLogin, $UsuSobrenome, $oUsuSit);
        $this->addFiltro($FiltroCodigo, $FiltroUser);

        $this->setBDesativaAcaoConsulta(true);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('');

        $oUsucodigo = new Campo('Código', 'usucodigo', Campo::TIPO_TEXTO, 1);
        $oUsucodigo->setITamanho(Campo::TAMANHO_PEQUENO);
        $oUsucodigo->setBCampoBloqueado(TRUE);

        $oUsuCracha = new Campo('Crachá', 'usucracha', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUsuCracha->addValidacao(false, Validacao::TIPO_STRING);
        $oUsuCracha->setITamanho(Campo::TAMANHO_PEQUENO);

        $oUserNome = new Campo('Nome', 'usunome', Campo::TIPO_TEXTO, 4);
        $oUserNome->addValidacao(false, Validacao::TIPO_STRING);
        $oUserNome->setITamanho(Campo::TAMANHO_PEQUENO);

        $oSobrenome = new Campo('Sobrenome', 'ususobrenome', Campo::TIPO_TEXTO, 4);
        $oSobrenome->addValidacao(false, Validacao::TIPO_STRING);
        $oSobrenome->setITamanho(Campo::TAMANHO_PEQUENO);

        $oUsuFone = new Campo('Telefone', 'usufone', Campo::TIPO_TEXTO, 3);
//        $oUsuFone->addValidacao(FALSE, Validacao::TIPO_TELEFONE);

        $oUsuRamal = new Campo('Ramal', 'usuramal', Campo::TIPO_TEXTO, 1);
        $oUsuRamal->addValidacao(true, Validacao::TIPO_INTEIRO);

        $oUsuEmail = new Campo('Email', 'usuemail', Campo::TIPO_TEXTO, 4);
        $oUsuEmail->setITamanho(Campo::TAMANHO_PEQUENO);
        $oUsuEmail->addValidacao(false, Validacao::TIPO_EMAIL);

        $UsuLogin = new Campo('Login', 'usulogin', Campo::TIPO_TEXTO, 4);
        $UsuLogin->addValidacao(false, Validacao::TIPO_STRING);
        $UsuLogin->setITamanho(Campo::TAMANHO_PEQUENO);

        $Ususenha = new Campo('Senha', 'ususenha', Campo::TIPO_SENHA, 4);
        $Ususenha->setITamanho(Campo::TAMANHO_PEQUENO);
        $Ususenha->addValidacao(true, Validacao::TIPO_STRING);

        $UsuBloqueado = new Campo('Usuário bloqueado', 'usubloqueado', Campo::TIPO_CHECK, 4);

        $oUsoSalva = new Campo('Grava senha para acesso', 'ususalvasenha', Campo::TIPO_CHECK, 5);


        $oUsuimagem = new Campo('Imagem Perfil', 'usuimagem', Campo::TIPO_UPLOAD, 2, 2, 2, 2);
        $oUsuimagem->setExtensoesPermitidas('png', 'jpg', 'gif');

        $oNomeDelsoft = new campo('Nome Delsoft', 'usunomeDelsoft', Campo::TIPO_TEXTO, 4);
        $oNomeDelsoft->addValidacao(true, Validacao::TIPO_STRING, '...', '0', '50');


        $oFilcgc = new Campo('Empresa Padrão', 'filcgc', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oFilcgc->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');



        $oFilcgc->setClasseBusca('DELX_FIL_empresa');
        $oFilcgc->setSCampoRetorno('fil_codigo', $this->getTela()->getId());


        $oOfficeCod = new Campo('Escritório Rep.', 'officecod', Campo::TIPO_BUSCADOBANCOPK, 2);

        $oOfficeCod->setClasseBusca('MET_COM_repoffice');
        $oOfficeCod->setSCampoRetorno('officecod', $this->getTela()->getId());


        $oUsutipo = new Campo('Tipo', 'MET_TEC_UsuTipo.usutipo', Campo::TIPO_TEXTO, 1);
        $oUsutipo->setClasseBusca('MET_TEC_UsuTipo');
        $oUsutipo->addCampoBusca('usutipdescricao', null, $this->getTela()->getId()); //sempre setar o nome do modulo referente a pesquisa


        $oCodSetor = new Campo('Setor', 'MET_CAD_Setores.codsetor', Campo::TIPO_TEXTO, 1);
        $oCodSetor->setClasseBusca('MET_CAD_Setores');
        $oCodSetor->addCampoBusca('descsetor', null, $this->getTela()->getId()); //sempre setar o nome do modulo referente a pesquisa

        $oLabelDadosUsuarios = new Campo('Dados do Usuário:', '', Campo::TIPO_LABEL);
        $oLabelDadosLogin = new Campo('Dados de Login:', '', Campo::TIPO_LABEL);

        $oSit = new Campo('Situação do cadastro', 'ususit', Campo::TIPO_TEXTO, 2);
        $oSit->setSValor('Cadastro Completo');
        $oSit->setBCampoBloqueado(true);

        $oSenhaProv = new campo('Senha provisória', 'senhaProvisoria', Campo::TIPO_CHECK, 4);

        $oCodSisMetalbo = new campo('Cód.Metalbo', 'codsismetalbo', Campo::TIPO_TEXTO, 2);

        $oLinha = new Campo('', 'linha1', Campo::TIPO_LINHA, 12);
        $oLinha->setApenasTela(true);

        $oTurnoSteel = new campo('Turno SteelTrater', 'turnoSteel', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3);
        $oTurnoSteel->addItemSelect('Nenhum', 'Nenhum');
        $oTurnoSteel->addItemSelect('Turno A', 'Turno A');
        $oTurnoSteel->addItemSelect('Turno B', 'Turno B');
        $oTurnoSteel->addItemSelect('Turno C', 'Turno C');
        $oTurnoSteel->addItemSelect('Turno D', 'Turno D');
        $oTurnoSteel->addItemSelect('Geral', 'Geral');
        
        $this->addCampos($oLabelDadosUsuarios, array($oUsucodigo, $oSit), $oLinha, array($oUsuCracha, $oUserNome, $oSobrenome), $oLinha, array($oUsuFone, $oUsuRamal, $oUsuEmail), $oLinha, array($oCodSetor, $oFilcgc), $oLinha, array($oUsutipo, $oOfficeCod), $oLinha, array($oUsuimagem, $oNomeDelsoft), $oLinha, $oLinha, $oLabelDadosLogin, array($UsuLogin, $Ususenha), $UsuBloqueado, $oUsoSalva, $oSenhaProv, $oLinha, array($oCodSisMetalbo, $oTurnoSteel));
    }

}
