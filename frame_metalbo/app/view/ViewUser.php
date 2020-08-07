<?php

/*
 * Classe que implementa o view da classe usuário
 * 
 * @author Avanei Martendal
 * @since 25/12/2015
 */

class ViewUser extends View {

    function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setaTiluloConsulta('Pesquisa de Usuários');

        $oUsucodigo = new CampoConsulta('Código', 'usucodigo', CampoConsulta::TIPO_LARGURA, 5);
        $oUsucodigo->setILargura(10);

        $oUsunome = new CampoConsulta('Usuário', 'usunome', CampoConsulta::TIPO_LARGURA, 5);
        $oUsunome->setILargura(100);

        $UsuSobrenome = new CampoConsulta('Sobrenome', 'ususobrenome', CampoConsulta::TIPO_LARGURA, 5);
        $UsuSobrenome->setILargura(100);

        $oUsuSit = new CampoConsulta('Situação Cad.', 'ususit', CampoConsulta::TIPO_LARGURA, 5);
        $oUsuSit->addComparacao('Cadastro Completo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);
        $oUsuSit->addComparacao('Aguardando cadastro', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA);
        $oUsuSit->setILargura(50);

        $oUsuLogin = new CampoConsulta('Login', 'usulogin', CampoConsulta::TIPO_LARGURA, 5);
        $oUsuLogin->setILargura(200);

        $oUsuRep = new CampoConsulta('OfficeRep', 'RepOffice.officedes', CampoConsulta::TIPO_LARGURA, 5);
        $oUsuRep->setILargura(50);
        
        $FiltroCodigo = new Filtro($oUsucodigo, Filtro::CAMPO_TEXTO, 1);
        $FiltroUser = new Filtro($oUsunome, Filtro::CAMPO_TEXTO, 3);
        $oFiltroRep = new Filtro($oUsuRep, Filtro::CAMPO_TEXTO, 3);



        $this->addCampos($oUsucodigo, $oUsunome, $oUsuLogin, $UsuSobrenome, $oUsuRep, $oUsuSit);
        $this->addFiltro($FiltroCodigo, $FiltroUser, $oFiltroRep);

        $this->setBDesativaAcaoConsulta(true);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('');

        $oUsucodigo = new Campo('Código', 'usucodigo', Campo::TIPO_TEXTO, 1);
        $oUsucodigo->setITamanho(Campo::TAMANHO_PEQUENO);
        $oUsucodigo->setBCampoBloqueado(TRUE);

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
        
        $oUsuSenhaEmail = new Campo('Senha e-mail metalbo', 'senhaemail', Campo::TIPO_TEXTO,2);
        $oUsuSenhaEmail->setITamanho(Campo::TAMANHO_PEQUENO);

        $UsuLogin = new Campo('Login', 'usulogin', Campo::TIPO_TEXTO, 4);
        $UsuLogin->addValidacao(false, Validacao::TIPO_STRING);
        $UsuLogin->setITamanho(Campo::TAMANHO_PEQUENO);

        $Ususenha = new Campo('Senha', 'ususenha', Campo::TIPO_SENHA, 4);
        $Ususenha->setITamanho(Campo::TAMANHO_PEQUENO);
        $Ususenha->addValidacao(true, Validacao::TIPO_STRING);

        $UsuBloqueado = new Campo('Usuário bloqueado', 'usubloqueado', Campo::TIPO_CHECK, 4);

        $oUsoSalva = new Campo('Grava senha para acesso', 'ususalvasenha', Campo::TIPO_CHECK, 5);


        $oUsuimagem = new Campo('Imagem Perfil', 'usuimagem', Campo::TIPO_UPLOAD, 4, 4, 12, 12);
        $oUsuimagem->setExtensoesPermitidas('png', 'jpg', 'gif');

        $oNomeDelsoft = new campo('Nome Delsoft', 'usunomeDelsoft', Campo::TIPO_TEXTO, 4);
        $oNomeDelsoft->addValidacao(true, Validacao::TIPO_STRING, '...', '0', '10');

        $oFilcgc = new Campo('Empresa Padrão', 'filcgc', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oFilcgc->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');
        $oFilcgc->setClasseBusca('EmpRex');
        $oFilcgc->setSCampoRetorno('filcgc', $this->getTela()->getId());

        $oOfficeCod = new Campo('Escritório Rep.', 'RepOffice.officecod', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oOfficeCod->setClasseBusca('RepOffice');
        $oOfficeCod->setSCampoRetorno('officecod', $this->getTela()->getId());


        $oUsutipo = new Campo('Tipo', 'UsuTipo.usutipo', Campo::TIPO_TEXTO, 1);
        $oUsutipo->setClasseBusca('UsuTipo');
        $oUsutipo->addCampoBusca('usutipdescricao', null, $this->getTela()->getId()); //sempre setar o nome do modulo referente a pesquisa


        $oCodSetor = new Campo('Setor', 'Setor.codsetor', Campo::TIPO_TEXTO, 1);
        $oCodSetor->setClasseBusca('Setor');
        $oCodSetor->addCampoBusca('descsetor', null, $this->getTela()->getId()); //sempre setar o nome do modulo referente a pesquisa

        $oLabelDadosUsuarios = new Campo('Dados do Usuário:', '', Campo::TIPO_LABEL);
        $oLabelDadosLogin = new Campo('Dados de Login:', '', Campo::TIPO_LABEL);

        $oSit = new Campo('Situação do cadastro', 'ususit', Campo::TIPO_TEXTO, 2);
        $oSit->setSValor('Cadastro Completo');
        $oSit->setBCampoBloqueado(true);

        $oSenhaProv = new campo('Senha provisória', 'senhaProvisoria', Campo::TIPO_CHECK, 4);

        $this->addCampos($oLabelDadosUsuarios, array($oUsucodigo, $oSit), array($oUserNome, $oSobrenome), array($oUsuFone, $oUsuRamal), array($oUsuEmail,$oUsuSenhaEmail), array($oCodSetor, $oFilcgc), array($oUsutipo, $oOfficeCod), array($oUsuimagem, $oNomeDelsoft), $oLabelDadosLogin, array($UsuLogin, $Ususenha), $UsuBloqueado, $oUsoSalva, $oSenhaProv);
    }

}
