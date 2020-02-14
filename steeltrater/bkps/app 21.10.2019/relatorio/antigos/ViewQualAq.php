<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualAq extends View{
    public function __construct() {
        parent::__construct();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oTitulo = new CampoConsulta('Título','titulo');
        $oTitulo->setILargura(450);
        $oFilcgc = new CampoConsulta('Cnpj','EmpRex.filcgc');
        $oFilcgc->setILargura(50);
       // $oFildes = new CampoConsulta('Empresa','EmpRex.fildes');
       // $oFildes->setILargura(250);
        $oNr = new CampoConsulta('AQ','nr');
        $oNr->setILargura(30);
        $oNr->setSOperacao('personalizado');
        $oDataFim = new CampoConsulta('Data Final','datafim', CampoConsulta::TIPO_DATA);
        $oDataFim->setILargura(100);
        $oSit = new CampoConsulta('Situação','sit');
        $oSit->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);
        $oSit->addComparacao('Iniciada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA);
        
        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL,1);
       // $oFiltrodes = new Filtro($oFildes, Filtro::CAMPO_TEXTO,3);
        $oFilTit = new Filtro($oTitulo, Filtro::CAMPO_TEXTO,3);
        
         $oFilCnpj = new Filtro($oFilcgc, Filtro::CAMPO_BUSCADOBANCOPK,2);
         $oFilCnpj->setSClasseBusca('EmpRex');
         $oFilCnpj->setSCampoRetorno('filcgc',$this->getTela()->getSId());
         $oFilCnpj->setSIdTela($this->getTela()->getSId());
        
        $this->addFiltro($oFilNr,$oFilCnpj,$oFilTit);
        
        $this->setUsaAcaoExcluir(false);
        
         $this->setUsaDropdown(true);
         $oDrop1 = new Dropdown('Plano de ação e Eficácia', Dropdown::TIPO_SUCESSO);
         $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CALENDARIO).'Finalizar plano de ação', 'QualAqApont', 'acaoMostraTelaApontdiv', '', true, '');
         $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EDITAR).'Inserir avaliação da eficácia', 'QualAqEficaz', 'acaoMostraTelaApontdiv', '', true, '');
         $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CALENDARIO).'Apontar avaliação da eficácia', 'QualAqEficazApont', 'acaoMostraTelaApontdiv', '', true, '');
         
       
         $oDrop3 = new Dropdown('Movimentação', Dropdown::TIPO_DARK);
         $oDrop3->addItemDropdown($this->addIcone(Base::ICON_LAPIS).'Iniciar ação da qualidade', 'QualAq', 'startAq', '', false, '');
         $oDrop3->addItemDropdown($this->addIcone(Base::ICON_MARTELO).'Finalizar ação da qualidade', 'QualAq', 'msgFechaAq', '', false, '');//msgAbreAq
         $oDrop3->addItemDropdown($this->addIcone(Base::ICON_DESBLOQUEADO).'Reabrir ação da qualidade', 'QualAq', 'msgAbreAq', '', false, '');
         $oDrop3->addItemDropdown($this->addIcone(Base::ICON_FILE).'Ata de reunião', 'QualAta', 'acaoMostraTelaApontdiv', '', true, '');
         
         $oDrop4 = new Dropdown('Impressão e Emails', Dropdown::TIPO_PRIMARY);
         $oDrop4->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA).'Vizualizar ação da qualidade', 'QualAq', 'acaoMostraRelConsulta', '', false, 'AqImp');
         $oDrop4->addItemDropdown($this->addIcone(Base::ICON_EMAIL).'Enviar para meu email', 'QualAq', 'envMailGrid2','', false, 'AqImp,email,QualAq,envMailQual');
         //$oMensagem->setSBtnConfirmarFunction('requestAjax("","QualAq","envMailAll","'.$sDados.'");');
         $oDrop4->addItemDropdown($this->addIcone(Base::ICON_EMAIL).'Enviar para todos envolvidos', 'QualAq', 'envMailGrid','', false, 'AqImp,email,QualAq,envMailAll');
         $this->addDropdown($oDrop1,$oDrop3,$oDrop4);
        
        $this->addCampos($oNr,$oTitulo,$oDataFim,$oSit,$oFilcgc);
        
       // $this->setBScrollInf(true);
        
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oTitulo = new Campo('Título da ação da qualidade','titulo', Campo::TIPO_TEXTO,3,3,3,3);
        $oLinha1 = new Campo('','', Campo::TIPO_LINHA,12);
        $oLinha1->setApenasTela(true);
        $oTitulo->setSCorFundo(Campo::FUNDO_AMARELO);
        $oTitulo->setBFocus(true);
        
        $oSit = new Campo('Situação','sit', Campo::TIPO_TEXTO,2,2,2,2);
        $oSit->setSValor('Aberta');
        $oSit->setBCampoBloqueado(true);
        
       
        $oFilcgc = new Campo('Empresa','EmpRex.filcgc', Campo::TIPO_BUSCADOBANCOPK,2,2,2,2);
        $oFilcgc->setSValor('75483040000211');
        
        $oFilDes = new campo('Empresa','EmpRex.fildes', Campo::TIPO_BUSCADOBANCO,3,3,3,3);
        $oFilDes->setSIdPk($oFilcgc->getId());
        $oFilDes->setClasseBusca('EmpRex');
        $oFilDes->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oFilDes->addCampoBusca('filcgc', '','');
        $oFilDes->addCampoBusca('fildes', '','');
        $oFilDes->setSIdTela($this->getTela()->getid());
        $oFilDes->setSValor('REX MÁQUINAS E EQUIPAMENTOS LTDA');
        
        $oFilcgc->setClasseBusca('EmpRex');
        $oFilcgc->setSCampoRetorno('filcgc',$this->getTela()->getId());
        $oFilcgc->addCampoBusca('fildes',$oFilDes->getId(),  $this->getTela()->getId());
      
        
        $oDataImp = new campo('Implantação','dtimp', Campo::TIPO_TEXTO,1,2,2,2);
        $oDataImp->setSValor(date('d/m/Y'));
        $oDataImp->setBCampoBloqueado(true);
        
        $oHora = new Campo('Hora','horimp', Campo::TIPO_TEXTO,1,1,1,1);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);
        
        $oUserImplant = new campo('Usuário Implantação','userimp', Campo::TIPO_TEXTO,2,2,2,2);
        $oUserImplant->setSValor($_SESSION['nome']);
        $oUserImplant->setBCampoBloqueado(true);
        
      
        
        $oResp = new campo('Cód.','usucodigo', Campo::TIPO_BUSCADOBANCOPK,1,1,1,1);
        $oResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
       
        $oRespNome = new Campo('Responsável','usunome', Campo::TIPO_BUSCADOBANCO,3,3,3,3);
        $oRespNome->setSIdPk($oResp->getId());
        $oRespNome->setClasseBusca('User');
        $oRespNome->addCampoBusca('usucodigo', '','');
        $oRespNome->addCampoBusca('usunome', '','');
        $oRespNome->setSIdTela($this->getTela()->getid());
       
        
        $oResp->setClasseBusca('User');
        $oResp->setSCampoRetorno('usucodigo',$this->getTela()->getId());
        $oResp->addCampoBusca('usunome',$oRespNome->getId(),  $this->getTela()->getId());
       
     
        
        $oEquipe = new campo('Equipe envolvida','equipe', Campo::TIPO_TEXTAREA,4,4,4,4);
        $oEquipe->setICaracter(500);
        
        
        $oDataIni = new campo('Data Inicial','dataini', Campo::TIPO_DATA,2,2,2,2);
        $oDataIni->setSValor(date('d/m/Y'));
        $oDataFinal = new campo('Data Final','datafim', Campo::TIPO_DATA,2,2,2,2);
        $oDataFinal->setSValor(date('d/m/Y'));
        
        $oTipoAcao = new campo('Tipo da ação','tipoacao', Campo::TIPO_SELECT,2);
        $oTipoAcao->addItemSelect('Ação Corretiva', 'Ação Corretiva');
        $oTipoAcao->addItemSelect('Ação Preventiva', 'Ação Preventiva');
        
        $oOrigem = new campo('Origem da ação','origem', Campo::TIPO_SELECT,2);
        $oOrigem->addItemSelect('Sugestão de funcionário','Sugestão de funcionário');
        $oOrigem->addItemSelect('Análise crítica do SGQ','Análise crítica do SGQ');
        $oOrigem->addItemSelect('Análise dos Indicadores','Análise dos Indicadores');
        $oOrigem->addItemSelect('Reclamação de Cliente','Reclamação de Cliente');
        $oOrigem->addItemSelect('Auditoria Interna','Auditoria Interna');
        $oOrigem->addItemSelect('Auditoria Externa','Auditoria Externa');
        $oOrigem->addItemSelect('Produto não conforme','Produto não conforme');
        
        $oTipmel = new campo('Tipo de melhoria', 'tipmelhoria', Campo::TIPO_SELECT,2);
        $oTipmel->addItemSelect('Produto', 'Produto');
        $oTipmel->addItemSelect('Processo', 'Processo');
        $oTipmel->addItemSelect('Ambiente', 'Ambiente');
        
        $oAssunto = new Campo('Assunto / Problema','problema', Campo::TIPO_TEXTAREA,5);
        $oAssunto->setILinhasTextArea(5);
        $oAssunto->setICaracter(400);
        
        $oObjetivo = new Campo('Objetivo','objetivo', Campo::TIPO_TEXTAREA,5,5,5,5);
        $oObjetivo->setILinhasTextArea(5);
        $oObjetivo->setICaracter(400);
     
        
       // $oCausaProv = new Campo('Causa provável','causaprov', Campo::TIPO_TEXTAREA,8,8,8,8);
       // $oCausaProv->setSCorFundo(Campo::FUNDO_AMARELO);
        
        
       // $oFieldPq = new FieldSet('Análise dos porquês');
       // $oPq1 = new Campo('1º Porque','pq1', Campo::TIPO_TEXTO,5,5,5,5);
       // $oPq1->setSCorFundo(Campo::FUNDO_VERDE);
       // $oPq2 = new Campo('2º Porque','pq2', Campo::TIPO_TEXTO,5,5,5,5);
       // $oPq2->setSCorFundo(Campo::FUNDO_VERDE);
       // $oPq3 = new Campo('3º Porque','pq3', Campo::TIPO_TEXTO,5,5,5,5);
       // $oPq3->setSCorFundo(Campo::FUNDO_VERDE);
       // $oPq4 = new Campo('4º Porque','pq4', Campo::TIPO_TEXTO,5,5,5,5);
       // $oPq4->setSCorFundo(Campo::FUNDO_VERDE);
       // $oPq5 = new Campo('5º Porque','pq5', Campo::TIPO_TEXTO,5,5,5,5);
       // $oPq5->setSCorFundo(Campo::FUNDO_VERDE);
       // $oFieldPq->addCampos($oCausaProv,array($oPq1,$oPq2),array($oPq3,$oPq4),$oPq5);
       // $oFieldPq->setOculto(true);
        
        $oNr = new campo('','nr', Campo::TIPO_TEXTO,1);
        $oNr->setBOculto(true);
        
        $oEtapas = new FormEtapa(2,2,2,2);
        $oEtapas->addItemEtapas('Inserir Ação da qualidade',true, $this->addIcone(Base::ICON_CALENDARIO));
        $oEtapas->addItemEtapas('Causa raiz do problema',false, $this->addIcone(Base::ICON_INFO));
        $oEtapas->addItemEtapas('Plano de ação',false,  $this->addIcone(Base::ICON_CONFIRMAR));
        
        $this->addEtapa($oEtapas);
        
        $oCertificacao = new Campo('Classificação','certificacao', Campo::TIPO_SELECT);
        $oCertificacao->addItemSelect('Cliente, processos e produto','Cliente, processos e produto');
        $oCertificacao->addItemSelect('Segurança e saúde ocupacional','Segurança e saúde ocupacional');
        $oCertificacao->addItemSelect('Meio ambiente','Meio ambiente');
        
        $oAnexo1 = new Campo('Anexo 1', 'anexo1', Campo::TIPO_UPLOAD);
        
        
      
        
        $this->addCampos(array($oTitulo,$oSit,$oDataImp,$oHora,$oUserImplant),$oCertificacao,$oLinha1,array($oFilcgc,$oFilDes,$oResp,$oRespNome),$oEquipe,array($oDataIni,$oDataFinal),
                array($oTipoAcao,$oOrigem,$oTipmel),$oAnexo1,array($oAssunto,$oObjetivo),$oNr);
        
       
        
       
        
    }
}