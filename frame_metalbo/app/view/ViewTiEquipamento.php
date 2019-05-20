<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * View da Classe que mantem os equipamentos do setor de Tecnologia da Informação da Metalbo
 * @author Carlos
 */
class ViewTiEquipamento extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oEquipCod = new CampoConsulta('Código', 'equipcod');
        $oEquipCod->setILargura(60);

        $oTipoEquip = new CampoConsulta('Tipo', 'TiEquipamentoTipo.eqtipdescricao');
        $oTipoEquip->setILargura(80);

        $oSetor = new CampoConsulta('Setor', 'Setor.descsetor');
        $oSetor->setILargura(120);

        $oFabricante = new CampoConsulta('Fabricante', 'equipfabricante');
        $oFabricante->setILargura(100);

        $oModelo = new CampoConsulta('Modelo', 'equipmodelo');
        $oModelo->setILargura(200);

        $oSistema = new CampoConsulta('Sistema', 'equipsistema');
        $oSistema->setILargura(200);

        $oHostname = new CampoConsulta('Hostname', 'equiphostname');
        $oHostname->setILargura(200);

        $oUsuario = new CampoConsulta('Usuario', 'equipusuario');
        $oUsuario->setILargura(200);

        $oIp = new CampoConsulta('Ip Fixo', 'ipfixo');

        $oSituaca = new CampoConsulta('Situação', 'situaca');
        $oSituaca->addComparacao('D', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, true, 'Desativado');
        $oSituaca->addComparacao('A', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ativado');

        $this->addCampos($oEquipCod, $oTipoEquip, $oSetor, $oFabricante, $oModelo, $oSistema, $oHostname, $oUsuario, $oIp, $oSituaca);

        $oFiltro1 = new Filtro($oSistema, Filtro::CAMPO_TEXTO, 3, 3, 12, 12);

        $oFilFab = new Filtro($oFabricante, Filtro::CAMPO_TEXTO, 4, 4, 12, 12);

        $oFilTipo = new Filtro($oTipoEquip, Filtro::CAMPO_BUSCADOBANCOPK, 3, 3, 12, 12);
        $oFilTipo->setSClasseBusca('TiEquipamentoTipo');
        $oFilTipo->setSCampoRetorno('eqtipdescricao', $this->getTela()->getSId());
        $oFilTipo->setSIdTela($this->getTela()->getSId());

        $oFilSetor = new Filtro($oSetor, Filtro::CAMPO_BUSCADOBANCOPK, 4, 4, 12, 12);
        $oFilSetor->setSClasseBusca('Setor');
        $oFilSetor->setSCampoRetorno('descsetor', $this->getTela()->getSId());
        $oFilSetor->setSIdTela($this->getTela()->getSId());

        $oFilHostName = new Filtro($oHostname, Filtro::CAMPO_TEXTO, 3, 4, 12, 12);
        $oFilUsuario = new Filtro($oUsuario, Filtro::CAMPO_TEXTO, 2, 4, 12, 12);
        $oFilIp = new Filtro($oIp, Filtro::CAMPO_TEXTO, 2, 4, 12, 12);

        $this->addFiltro($oFilTipo, $oFilSetor, $oFiltro1, $oFilFab, $oFilHostName, $oFilUsuario, $oFilIp);

        $this->setBScrollInf(FALSE);
        $this->setUsaAcaoExcluir(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setILarguraGrid(1800);
    }

    public function criaTela() {
        parent::criaTela();

        $oData = new Campo('Data', 'equipdatacad', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oData->setSValor(date('d/m/Y'));
        $oData->setBCampoBloqueado(true);
        $oData->setBOculto(true);

        $oHora = new Campo('Hora', 'equiphoracad', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);
        $oHora->setBOculto(true);

        $oNFE = new Campo('NFE', 'nfe', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        $oEquipCod = new Campo('Código', 'equipcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oEquipCod->setBCampoBloqueado(true);

        $oEquipTipo = new Campo('Tipo', 'TiEquipamentoTipo.eqtipcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oEquipTipo->setClasseBusca('TiEquipamentoTipo');
        $oEquipTipo->addCampoBusca('eqtipdescricao', null, $this->getTela()->getId(), Campo::TIPO_BUSCA, 5, 5, 12, 12);
        $oEquipTipo->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oFabricante = new Campo('Fabricante/Distribuidor', 'equipfabricante', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $oModelo = new Campo('Modelo', 'equipmodelo', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $oSistema = new Campo('Sistema Operacional', 'equipsistema', Campo::TIPO_SELECT, 4, 4, 12, 12);
        $oSistema->addItemSelect('N/A', 'N/A');
        $oSistema->addItemSelect('Windows Xp', 'Windows Xp');
        $oSistema->addItemSelect('Windows 7', 'Windows 7');
        $oSistema->addItemSelect('Windows 8', 'Windows 8');
        $oSistema->addItemSelect('Windows 8.1', 'Windows 8.1');
        $oSistema->addItemSelect('Windows 10', 'Windows 10');
        $oSistema->addItemSelect('Linux', 'Linux');
        $oSistema->addItemSelect('MacOS', 'MacOS');
        $oSistema->addItemSelect('Windows Server 2003', 'Windows Server 2003');
        $oSistema->addItemSelect('Windows Server 2008', 'Windows Server 2008');
        $oSistema->addItemSelect('Windows Server 2012', 'Windows Server 2012');
        $oSistema->addItemSelect('Windows Server 2016', 'Windows Server 2016');

        $oLicensa = new Campo('Licença Windows', 'equiplicenca', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oLicensa->addItemSelect('Ativado', 'Ativado');
        $oLicensa->addItemSelect('Aguardando', 'Aguardando');

        $oUsuario = new Campo('Crachá', 'cracha', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oUsuario->setApenasTela(true);
        $oUsuario->setBOculto(true);

        $oPessoa = new Campo('Usuário', 'equipusuario', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oPessoa->setSIdPk($oUsuario->getId());
        $oPessoa->setClasseBusca('MET_CAD_Funcionarios');
        $oPessoa->addCampoBusca('numcad', '', '');
        $oPessoa->addCampoBusca('nomfun', '', '');
        $oPessoa->setSIdTela($this->getTela()->getid());

        $oUsuario->setClasseBusca('MET_CAD_Funcionarios');
        $oUsuario->setSCampoRetorno('numcad', $this->getTela()->getId());
        $oUsuario->addCampoBusca('nomfun', $oPessoa->getId(), $this->getTela()->getId());


        $oCodSetor = new Campo('Setor', 'Setor.codsetor', Campo::TIPO_TEXTO, 1);
        $oCodSetor->setClasseBusca('Setor');
        $oCodSetor->addCampoBusca('descsetor', null, $this->getTela()->getId()); //sempre setar o nome do modulo referente a pesquisa

        $oFilcgc = new Campo('Empresa Padrão', 'filcgc', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oFilcgc->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');
        $oFilcgc->setSValor('75483040000211');

        $oFildes = new Campo('Empresa', 'fildes', Campo::TIPO_BUSCADOBANCO, 4);
        $oFildes->setSIdPk($oFilcgc->getId());
        $oFildes->setClasseBusca('PoliCadMaq');
        $oFildes->addCampoBusca('codmaq', '', '');
        $oFildes->addCampoBusca('maquina', '', '');
        $oFildes->setSIdTela($this->getTela()->getid());
        $oFildes->setApenasTela(true);

        $oFilcgc->setClasseBusca('EmpRex');
        $oFilcgc->setSCampoRetorno('filcgc', $this->getTela()->getId());
        $oFilcgc->addCampoBusca('fildes', $oFildes->getId(), $this->getTela()->getId());

        $oFieldHard = new FieldSet('Hardware');

        $oCpu = new Campo('Processador', 'equipcpu', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $oRam = new Campo('Memória Ram', 'equipmemoria', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oRam->addItemSelect('N/A', 'N/A');
        $oRam->addItemSelect('1GB', '1GB');
        $oRam->addItemSelect('2GB', '2GB');
        $oRam->addItemSelect('3GB', '3GB');
        $oRam->addItemSelect('4GB', '4GB');
        $oRam->addItemSelect('5GB', '5GB');
        $oRam->addItemSelect('6GB', '6GB');
        $oRam->addItemSelect('8GB', '8GB');
        $oRam->addItemSelect('16GB', '16GB');
        $oRam->addItemSelect('32GB', '32GB');
        $oRam->addItemSelect('64GB', '64GB');

        $oHd = new Campo('Hd', 'equiphd', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oHd->addItemSelect('500GB', '500GB');
        $oHd->addItemSelect('1TB', '1TB');
        $oHd->addItemSelect('2TB', '2TB');
        $oHd->addItemSelect('3TB', '3TB');
        $oHd->addItemSelect('4TB', '4TB');

        $oFieldHard->addCampos(array($oCpu, $oRam, $oHd,));

        $oFieldNetwork = new FieldSet('Network');

        $oHostName = new Campo('HostName', 'equiphostname', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oMac = new Campo('Mac Addres', 'equipmac', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oIp = new Campo('Ip Fixo', 'ipfixo', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oIp->setSValor('DHCP');

        $oFieldNetwork->addCampos(array($oHostName, $oMac, $oIp));

        $oObs = new Campo('Observações', 'obs', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObs->setSCorFundo(Campo::FUNDO_AMARELO);

        $oSituaca = new Campo('Situação', 'situaca', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oSituaca->addItemSelect('A', 'Ativado');
        $oSituaca->addItemSelect('D', 'Desativado');

        $oOffice = new Campo('Licença Office', 'office', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oOffice->addItemSelect('A', 'Ativado');
        $oOffice->addItemSelect('D', 'Desativado');

        $oLicOffice = new Campo('Número:', 'licoffice', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $oNumeroLicenca = new Campo('Número:', 'numlic', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $this->addCampos(array($oEquipCod, $oEquipTipo, $oHora, $oData, $oSituaca), array($oUsuario, $oPessoa), $oFilcgc, $oCodSetor, array($oFabricante, $oModelo), array($oSistema, $oNFE), array($oLicensa, $oNumeroLicenca), array($oOffice, $oLicOffice), $oFieldHard, $oFieldNetwork, $oObs);
    }

    public function relTiEquip() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de Equiupamentos de TI');
        $this->setBTela(true);

        $oTipoEquip = new Campo('Equipamento', 'TiEquipamentoTipo.eqtipcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTipoEquip->setClasseBusca('TiEquipamentoTipo');
        $oTipoEquip->addCampoBusca('eqtipdescricao', null, $this->getTela()->getId());

        $oSetorCod = new Campo('Setor', 'Setor.codsetor', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSetorCod->setClasseBusca('Setor');
        $oSetorCod->addCampoBusca('descsetor', null, $this->getTela()->getId());
        
        $oOffice = new Campo('Licença Office', 'office', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oOffice->addItemSelect('Todos', 'Todos');
        $oOffice->addItemSelect('A', 'Ativado');
        $oOffice->addItemSelect('D', 'Desativado');

        $oLicensa = new Campo('Licença Windows', 'equiplicenca', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oLicensa->addItemSelect('Todos', 'Todos');
        $oLicensa->addItemSelect('Ativado', 'Ativado');
        $oLicensa->addItemSelect('Aguardando', 'Aguardando');
        
        $oSistema = new Campo('Sistema Operacional', 'equipsistema', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSistema->addItemSelect('N/A', 'N/A');
        $oSistema->addItemSelect('Windows Xp', 'Windows Xp');
        $oSistema->addItemSelect('Windows 7', 'Windows 7');
        $oSistema->addItemSelect('Windows 8', 'Windows 8');
        $oSistema->addItemSelect('Windows 8.1', 'Windows 8.1');
        $oSistema->addItemSelect('Windows 10', 'Windows 10');
        $oSistema->addItemSelect('Linux', 'Linux');
        $oSistema->addItemSelect('MacOS', 'MacOS');
        $oSistema->addItemSelect('Windows Server 2003', 'Windows Server 2003');
        $oSistema->addItemSelect('Windows Server 2008', 'Windows Server 2008');
        $oSistema->addItemSelect('Windows Server 2012', 'Windows Server 2012');
        $oSistema->addItemSelect('Windows Server 2016', 'Windows Server 2016');
        
        $this->addCampos($oTipoEquip, $oSetorCod, $oSistema, $oLicensa, $oOffice);
    }

}
