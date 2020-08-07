<?php

/* 
 * @author Avanei Martendal
 * @Since 06/09/2019
 */

class ViewSTEEL_PCP_ordensFabApontEtapas extends View{
    public function criaTela() {
        parent::criaTela();
        //alimenta fornos para o início do processo
        
        $aDados = $this->getAParametrosExtras();
        $aFornosRadio = $aDados[1];
        
        //busca os dados do usuário
        $oOuser = Fabrica::FabricarController('MET_TEC_Usuario');
        $oOuser->Persistencia->adicionaFiltro('usucodigo',$_SESSION['codUser']);
        $oOuserDados = $oOuser->Persistencia->consultarWhere();
        
        //desativa botoes
        $this->setBTela(true);
        $this->setBOcultaBotTela(true);
        $this->setBOcultaFechar(true);
        
        $oTurno = new campo('Turno inicial','turnoSteel', Campo::CAMPO_SELECTSIMPLE,2,2,2,2);
        $oTurno->addItemSelect('Turno A','Turno A');
        $oTurno->addItemSelect('Turno B','Turno B');
        $oTurno->addItemSelect('Turno C','Turno C');
        $oTurno->addItemSelect('Turno D','Turno D');
        $oTurno->addItemSelect('Geral','Geral');
        $oTurno->setSValor($oOuserDados->getTurnoSteel());
        
        //campo dos fornos para somente carregar
        $oFornoCod = new campo('','fornocod', Campo::TIPO_TEXTO,1);
        $oFornoCod->setBOculto(true);
        $oFornoDes=new Campo('','fornodes', Campo::TIPO_TEXTO,2);
        $oFornoDes->setBOculto(true);
        
        //-----------------------combo dos fornos---------------------------
        $oFornoChoice = new campo('Forno / Trefila inicial','fornoCombo', Campo::CAMPO_SELECTSIMPLE,3,3,3,3);
        foreach ($aFornosRadio as $keyForno => $oValueForno) {
            $oFornoChoice->addItemSelect($oValueForno->getFornocod(),$oValueForno->getFornodes());
        }
       $sCombo ='var textCombo = $("#'.$oFornoChoice->getId().' option:selected").text(); '
                . 'var valueCombo = $("#'.$oFornoChoice->getId().'").val(); '
                .'$("#'.$oFornoCod->getId().'").val(valueCombo); $("#'.$oFornoDes->getId().'").val(textCombo); ';
        $oFornoChoice->addEvento(Campo::EVENTO_CHANGE,$sCombo);
        //-----------------------------------------------------------------
        //verifica primeiro se há cookie setado
         if(isset($_COOKIE['cookfornocod'])){
            $oFornoCod->setSValor($_COOKIE['cookfornocod']);
             //seta valor padrão
            $oFornoChoice->setSValor($_COOKIE['cookfornocod']);
        }else{
            $oFornoArr = $aDados[0];
            
            if (method_exists($oFornoArr,'getFornocod')){
                $oFornoCod->setSValor($oFornoArr->getFornocod());
                $oFornoChoice->setSValor($oFornoArr->getFornocod());
            }}
            
             $oFornoDes->setBCampoBloqueado(true);
        $oFornoDes->setSCorFundo(Campo::FUNDO_AMARELO);
        if(isset($_COOKIE['cookfornodes'])){
            $oFornoDes->setSValor($_COOKIE['cookfornodes']);
        }else{
            $oFornoArr = $aDados[0];
            if (method_exists($oFornoArr,'getFornodes')){
                $oFornoDes->setSValor($oFornoArr->getFornodes());
            }}
        //--------------------------------------------------------------------    
        
        $oCodUser = new campo('coduser','coduser', Campo::TIPO_TEXTO,1,1,1,1);
        $oCodUser->setSValor($_SESSION['codUser']);
        $oCodUser->setBCampoBloqueado(true);
        $oCodUser->setBOculto(true);
        
        $oUserNome = new campo('user','usernome', Campo::TIPO_TEXTO,2,2,2,2);
        $oUserNome->setSValor($_SESSION['nome']);
        $oUserNome->setBCampoBloqueado(true);
        $oUserNome->setBOculto(true);
        
        $oOp = new Campo('OP', 'op', Campo::TIPO_TEXTO, 3, 3, 6, 6);
        $oOp->setSCorFundo(Campo::FUNDO_AMARELO);
        $oOp->addValidacao(false, Validacao::TIPO_STRING,'','1','100');
        $oOp->setBFocus(true); 
        
        $oLinha = new Campo('','linha', Campo::TIPO_LINHA,12,12,12,12);
        $oLinha->setApenasTela(true);
        
         //botao inserir apontamento
        $oBtnInserir = new Campo('Iniciar','',  Campo::TIPO_BOTAOSMALL_SUB,1);
//----------------------------------------------------------------------------------------------------------
        //grid para carregar inicio do processo
         $oGridInicioProcesso = new Campo('Início do processo','apontInicio', Campo::TIPO_GRIDVIEW,12,12,12,12);
         $oGridInicioProcesso->setSTituloGridPainel('Início do processo');
         $oGridInicioProcesso->setSCorTituloGridPainel(Campo::TITULO_DANGER);
         $oGridInicioProcesso->addCabGridView('Excluir');
         $oGridInicioProcesso->addCabGridView('Op');
         $oGridInicioProcesso->addCabGridView('Produto');
         $oGridInicioProcesso->addCabGridView('Forno/Trefila');
         $oGridInicioProcesso->addCabGridView('Turno');
         $oGridInicioProcesso->addCabGridView('Data Ent');
         $oGridInicioProcesso->addCabGridView('Hora Ent');
         $oGridInicioProcesso->addCabGridView('Situação');
         $oGridInicioProcesso->addCabGridView('Usuário');
         
        
         
      /*   $oGridInicioProcesso->addLinhasGridView(1,'138574');
         $oGridInicioProcesso->addLinhasGridView(1, 'FIO MAQUINA SAE 10B22 - 18,30MM');
         $oGridInicioProcesso->addLinhasGridView(1, 'Forno Pote ');
         $oGridInicioProcesso->addLinhasGridView(1, 'Turno C ');
         $oGridInicioProcesso->addLinhasGridView(1, '09/09/2019');
         $oGridInicioProcesso->addLinhasGridView(1, '09:53');
         $oGridInicioProcesso->addLinhasGridView(1, 'Processo');
         $oGridInicioProcesso->addLinhasGridView(1, 'Avanei Martendal'); */
        
//----------------------------------------------------------------------------------------------------------
         $oGridEnt = new campo('Etapas do processo', 'gridEnt', Campo::TIPO_GRID, 12, 12, 12, 12, 150);
         $oGridEnt->getOGrid()->setAbaSel($this->getSIdAbaSelecionada());
         
         $oOpGrid = new CampoConsulta('Op','op');
         //botao que inicia um processo
         $oBotaoStart = new CampoConsulta('Inciar etapa', 'iniciarEtapa', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_BOTAOSUCCES);
         $oBotaoStart->setBHideTelaAcao(true);
         $oBotaoStart->setILargura(20);
         //$oBotaoStart->setILargura(15);
         $oBotaoStart->setSTitleAcao('Inicia etapa!');
         $oBotaoStart->addAcao('STEEL_PCP_OrdensFabApontEtapas', 'criaTelaModalApontaIniciar', 'modalApontaIniciar');
         $oBotaoStart->setSTituloBotaoModal('INICIAR');
         $oGridEnt->getOGrid()->addModal($oBotaoStart);
         
         //botao que finalizar um processo
         $oBotaoFinalizar = new CampoConsulta('Finalizar etapa', 'finalizarEtapa', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_BOTAOPRIMARY );
         $oBotaoFinalizar->setBHideTelaAcao(true);
         $oBotaoFinalizar->setILargura(20);
        // $oBotaoFinalizar->setILargura(15);
         $oBotaoFinalizar->setSTitleAcao('Finaliza etapa!');
         $oBotaoFinalizar->addAcao('STEEL_PCP_OrdensFabApontEtapas', 'criaTelaModalApontaFinalizar', 'modalApontaFinalizar');
         $oBotaoFinalizar->setSTituloBotaoModal('FINALIZAR');
         $oGridEnt->getOGrid()->addModal($oBotaoFinalizar);
         
         //botao que retorna um processo
         $oBotaoRetornar = new CampoConsulta('Retornar etapa', 'retornarEtapa', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_BOTAODANGER );
         $oBotaoRetornar->setBHideTelaAcao(true);
        // $oBotaoRetornar->setILargura(15);
         $oBotaoRetornar->setSTitleAcao('Retorna apontamento!');
         $oBotaoRetornar->addAcao('STEEL_PCP_OrdensFabApontEtapas', 'retornaApontamento', '');
         $oBotaoRetornar->setSTituloBotaoModal('RETORNAR');
         $oBotaoRetornar->setILargura(20);
         $oGridEnt->getOGrid()->addModal($oBotaoRetornar);
         
        
         
         $oReceitaSeq = new CampoConsulta('Etapa','receita_seq');
         $oTratamento = new CampoConsulta('Tratamento','STEEL_PCP_Tratamentos.tratdes');
         $oTratamento->setILargura(220);
         $oFornodesConsulta = new CampoConsulta('Forno/Trefila','fornodes');
         $oDataEntConsulta = new CampoConsulta('Data Ent.','dataent_forno', CampoConsulta::TIPO_DATA);
         $oHoraEntConsulta = new CampoConsulta('Hora Ent.','horaent_forno', CampoConsulta::TIPO_TIME);
         $oDataSaidaConsulta = new CampoConsulta('Data Saída','datasaida_forno', CampoConsulta::TIPO_DATA);
         $oHoraSaidaConsulta = new CampoConsulta('Hora Saída','horasaida_forno', CampoConsulta::TIPO_TIME);
         
         $oSituacaoConsulta = new CampoConsulta('Situação','situacao');
         $oSituacaoConsulta->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA);
         $oSituacaoConsulta->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
         $oSituacaoConsulta->setBComparacaoColuna(true);
         $oSituacaoConsulta->setILargura(11);
         
         $oUserEntConsulta = new campoconsulta('Usuário Ent.','usernome');
         $oUserSaidaConsulta = new campoconsulta('Usuário Saída','usernomesaida');
         
         $oGridEnt->addCampos($oBotaoStart,$oBotaoFinalizar,$oBotaoRetornar,$oOpGrid,$oReceitaSeq,$oTratamento,$oSituacaoConsulta,
                 $oFornodesConsulta,$oDataEntConsulta,$oHoraEntConsulta,$oUserEntConsulta,$oDataSaidaConsulta,
                 $oHoraSaidaConsulta,$oUserSaidaConsulta);
         $oGridEnt->setSController('STEEL_PCP_OrdensFabItens');
         $oGridEnt->addParam('op', '0');
         $oGridEnt->getOGrid()->setIAltura(220);
         $oGridEnt->getOGrid()->setBGridResponsivo(false);
         
         //atualizar
         //botao atualizar
        $oBtnAtualizar = new Campo('Atualizar','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $sAcaoAtualizar = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontEtapas",'
                . '"atualizaApontEnt","' . $oGridInicioProcesso->getId() . ','.$oBtnAtualizar->getId().'","consultaApontGrid");'
                . 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_OrdensFabItens",'
                . '"getDadosGrid","' . $oGridEnt->getId() . '","gridApontaEtapa");';
        $oBtnAtualizar->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);
        $oBtnAtualizar->getOBotao()->addAcao($sAcaoAtualizar);
        
        /**
         * Método para inserir apontamento
         */
         $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_ordensFabApontEnt","inserirApontEtapa",'
                 . '"'.$this->getTela()->getId().','. $oGridInicioProcesso->getId().','.$oOp->getId().','
                . ''.$oFornoChoice->getId().','.$oFornoCod->getId().','
                 . ''.$oFornoDes->getId().','.$oTurno->getId().','.$oBtnAtualizar->getId().'");';
        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
       
        $sAcaoFinalizar = 'requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_ordensFabApontEtapas","msgFinalizaOPgeral",'
                 . '"'.$this->getTela()->getId().','. $oGridInicioProcesso->getId().','.$oOp->getId().','
                . ''.$oFornoChoice->getId().','.$oFornoCod->getId().','
                 . ''.$oFornoDes->getId().','.$oTurno->getId().','.$oBtnAtualizar->getId().'");';
        $oBotaoFinalizarGeral = new Campo('Finalizar','btn_finalizargeralApontaEtapa', Campo::TIPO_BOTAOSIMPLES,3,3,3,3);
        $oBotaoFinalizarGeral->getOBotao()->setId('btn_finalizargeralApontaEtapa'); 
        $oBotaoFinalizarGeral->getOBotao()->addAcao($sAcaoFinalizar); 
        
        
        //msgRetornaApontSaida
        $sAcaoReabrirGeral = 'requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_ordensFabApontEtapas","msgRetornaApontSaida",'
                 . '"'.$this->getTela()->getId().','. $oGridInicioProcesso->getId().','.$oOp->getId().','
                . ''.$oFornoChoice->getId().','.$oFornoCod->getId().','
                 . ''.$oFornoDes->getId().','.$oTurno->getId().','.$oBtnAtualizar->getId().'");';
        $oBotaoReabrirGeral = new Campo('Reabrir OP','', Campo::TIPO_BOTAOSIMPLES,5,5,5,5);
        $oBotaoReabrirGeral->getOBotao()->setSStyleBotao(Botao::TIPO_WARNING);
        $oBotaoReabrirGeral->getOBotao()->addAcao($sAcaoReabrirGeral);
        
        
        $this->addCampos(array($oTurno,$oFornoChoice,$oOp,$oBtnInserir,$oBtnAtualizar),
                $oGridInicioProcesso,$oGridEnt,array($oBotaoFinalizarGeral),
                array($oCodUser,$oUserNome),array($oFornoCod,$oFornoDes));
     }
    
     public function criaModalApontaIniciar($aForno,$IdGrid) {
        parent::criaModal();
        
        $aFornosRadio = $aForno[1];

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();
        
         //busca os dados do usuário
        $oOuser = Fabrica::FabricarController('MET_TEC_Usuario');
        $oOuser->Persistencia->adicionaFiltro('usucodigo',$_SESSION['codUser']);
        $oOuserDados = $oOuser->Persistencia->consultarWhere();
        
        $oTurno = new campo('Turno inicial','turnoSteel', Campo::CAMPO_SELECTSIMPLE,2,2,2,2);
        $oTurno->addItemSelect('Turno A','Turno A');
        $oTurno->addItemSelect('Turno B','Turno B');
        $oTurno->addItemSelect('Turno C','Turno C');
        $oTurno->addItemSelect('Turno D','Turno D');
        $oTurno->addItemSelect('Geral','Geral');
        $oTurno->setSValor($oOuserDados->getTurnoSteel());

        $oOp = new Campo('OP', 'op', Campo::TIPO_TEXTO, 2,2,2,2);
        $oOp->setSValor($oDados->getOp());
        $oOp->setBCampoBloqueado(true);
        
        $oEtapa = new Campo('Etapa','opseq', Campo::TIPO_TEXTO,1,1,1,1);
        $oEtapa->setSValor($oDados->getOpseq());
        $oEtapa->setBCampoBloqueado(true);
        
        $oCodEtapa = new Campo('CódTrat','tratcod', Campo::TIPO_TEXTO,1,1,1,1);
        $oCodEtapa->setSValor($oDados->getSTEEL_PCP_Tratamentos()->getTratcod());
        $oCodEtapa->setBCampoBloqueado(true);
        
        $oTratDes = new campo('Tratamento','tratdes', Campo::TIPO_TEXTO,4,4,4,4);
        $oTratDes->setSValor($oDados->getSTEEL_PCP_Tratamentos()->getTratdes());
        $oTratDes->setBCampoBloqueado(true);
        
         //campo dos fornos para somente carregar
        $oFornoCod = new campo('','fornocod', Campo::TIPO_TEXTO,1);
        $oFornoCod->setBOculto(true);
       // $oFornoCod->setBOculto(true);
        $oFornoDes=new Campo('','fornodes', Campo::TIPO_TEXTO,2);
        $oFornoDes->setBOculto(true);
       // $oFornoDes->setBOculto(true);
        
        //-----------------------combo dos fornos---------------------------
        $oFornoChoice = new campo('Forno / Trefila inicial','fornoCombo', Campo::CAMPO_SELECTSIMPLE,3,3,3,3);
        foreach ($aFornosRadio as $keyForno => $oValueForno) {
            $oFornoChoice->addItemSelect($oValueForno->getFornocod(),$oValueForno->getFornodes());
        }
       $sCombo ='var textCombo = $("#'.$oFornoChoice->getId().' option:selected").text(); '
                . 'var valueCombo = $("#'.$oFornoChoice->getId().'").val(); '
                .'$("#'.$oFornoCod->getId().'").val(valueCombo); $("#'.$oFornoDes->getId().'").val(textCombo); ';
        $oFornoChoice->addEvento(Campo::EVENTO_CHANGE,$sCombo);
        //-----------------------------------------------------------------
        //verifica primeiro se há cookie setado
         if(isset($_COOKIE['cookfornocod'])){
            $oFornoCod->setSValor($_COOKIE['cookfornocod']);
             //seta valor padrão
            $oFornoChoice->setSValor($_COOKIE['cookfornocod']);
        }else{
            $oFornoArr = $aDados[0];
            
            if (method_exists($oFornoArr,'getFornocod')){
                $oFornoCod->setSValor($oFornoArr->getFornocod());
                $oFornoChoice->setSValor($oFornoArr->getFornocod());
            }}
            
             $oFornoDes->setBCampoBloqueado(true);
        $oFornoDes->setSCorFundo(Campo::FUNDO_AMARELO);
        if(isset($_COOKIE['cookfornodes'])){
            $oFornoDes->setSValor($_COOKIE['cookfornodes']);
        }else{
            $oFornoArr = aForno[0];
            if (method_exists($oFornoArr,'getFornodes')){
                $oFornoDes->setSValor($oFornoArr->getFornodes());
            }}
        //--------------------------------------------------------------------   
        
        $oCodUser = new campo('CodUser','coduser', Campo::TIPO_TEXTO,1,1,1,1);
        $oCodUser->setSValor($_SESSION['codUser']);
        $oCodUser->setBCampoBloqueado(true);
        $oCodUser->setBOculto(true);
        
        $oUserNome = new campo('Usuário','usernome', Campo::TIPO_TEXTO,2,2,2,2);
        $oUserNome->setSValor($_SESSION['nome']);
        $oUserNome->setBCampoBloqueado(true);
        
        $oLinha = new campo('','linha', Campo::TIPO_LINHA,12,12,12,12);
        
        //botao inserir apontamento
        $oBtnInserir = new Campo('Apontar Etapa','',  Campo::TIPO_BOTAOSMALL_SUB,5,5,5,5);
        
         $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_ordensFabApontEtapas","ApontEtapa",'
                 . '"'.$this->getTela()->getId().','.$IdGrid.',");';
         $oBtnInserir->getOBotao()->addAcao($sAcao);
        
        $this->addCampos(array($oOp,$oEtapa,$oCodEtapa,$oTratDes,$oUserNome),
                $oLinha,
                array($oFornoChoice,$oTurno),
                $oBtnInserir,
                array($oFornoCod,$oFornoDes,$oCodUser));
    }
    
    //criaTelaModalApontaFinalizar
    public function criaTelaModalApontaFinalizar($aForno,$IdGrid) {
        parent::criaModal();
        
        $aFornosRadio = $aForno[1];

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();
        
         //busca os dados do usuário
        $oOuser = Fabrica::FabricarController('MET_TEC_Usuario');
        $oOuser->Persistencia->adicionaFiltro('usucodigo',$_SESSION['codUser']);
        $oOuserDados = $oOuser->Persistencia->consultarWhere();
        
        $oTurno = new campo('Turno final','turnoSteel', Campo::CAMPO_SELECTSIMPLE,3,3,3,3);
        $oTurno->addItemSelect('Turno A','Turno A');
        $oTurno->addItemSelect('Turno B','Turno B');
        $oTurno->addItemSelect('Turno C','Turno C');
        $oTurno->addItemSelect('Turno D','Turno D');
        $oTurno->addItemSelect('Geral','Geral');
        $oTurno->setSValor($oOuserDados->getTurnoSteel());

        $oOp = new Campo('OP', 'op', Campo::TIPO_TEXTO, 2,2,2,2);
        $oOp->setSValor($oDados->getOp());
        $oOp->setBCampoBloqueado(true);
        
        $oEtapa = new Campo('Etapa','opseq', Campo::TIPO_TEXTO,1,1,1,1);
        $oEtapa->setSValor($oDados->getOpseq());
        $oEtapa->setBCampoBloqueado(true);
        
        $oCodEtapa = new Campo('CódTrat','tratcod', Campo::TIPO_TEXTO,1,1,1,1);
        $oCodEtapa->setSValor($oDados->getSTEEL_PCP_Tratamentos()->getTratcod());
        $oCodEtapa->setBCampoBloqueado(true);
        
        $oTratDes = new campo('Tratamento','tratdes', Campo::TIPO_TEXTO,4,4,4,4);
        $oTratDes->setSValor($oDados->getSTEEL_PCP_Tratamentos()->getTratdes());
        $oTratDes->setBCampoBloqueado(true);
        
         //campo dos fornos para somente carregar
        $oFornoCod = new campo('','fornocod', Campo::TIPO_TEXTO,1);
        $oFornoCod->setBOculto(true);
       // $oFornoCod->setBOculto(true);
        $oFornoDes=new Campo('','fornodes', Campo::TIPO_TEXTO,2);
        $oFornoDes->setBOculto(true);
       // $oFornoDes->setBOculto(true);
        
        //-----------------------combo dos fornos---------------------------
        $oFornoChoice = new campo('Forno / Trefila inicial','fornoCombo', Campo::CAMPO_SELECTSIMPLE,3,3,3,3);
        foreach ($aFornosRadio as $keyForno => $oValueForno) {
            $oFornoChoice->addItemSelect($oValueForno->getFornocod(),$oValueForno->getFornodes());
        }
       $sCombo ='var textCombo = $("#'.$oFornoChoice->getId().' option:selected").text(); '
                . 'var valueCombo = $("#'.$oFornoChoice->getId().'").val(); '
                .'$("#'.$oFornoCod->getId().'").val(valueCombo); $("#'.$oFornoDes->getId().'").val(textCombo); ';
        $oFornoChoice->addEvento(Campo::EVENTO_CHANGE,$sCombo);
        //-----------------------------------------------------------------
        //verifica primeiro se há cookie setado
         if(isset($_COOKIE['cookfornocod'])){
            $oFornoCod->setSValor($_COOKIE['cookfornocod']);
             //seta valor padrão
            $oFornoChoice->setSValor($_COOKIE['cookfornocod']);
        }else{
            $oFornoArr = $aDados[0];
            
            if (method_exists($oFornoArr,'getFornocod')){
                $oFornoCod->setSValor($oFornoArr->getFornocod());
                $oFornoChoice->setSValor($oFornoArr->getFornocod());
            }}
            
             $oFornoDes->setBCampoBloqueado(true);
        $oFornoDes->setSCorFundo(Campo::FUNDO_AMARELO);
        if(isset($_COOKIE['cookfornodes'])){
            $oFornoDes->setSValor($_COOKIE['cookfornodes']);
        }else{
            $oFornoArr = aForno[0];
            if (method_exists($oFornoArr,'getFornodes')){
                $oFornoDes->setSValor($oFornoArr->getFornodes());
            }}
        //--------------------------------------------------------------------   
        
        $oCodUser = new campo('CodUser','coduser', Campo::TIPO_TEXTO,1,1,1,1);
        $oCodUser->setSValor($_SESSION['codUser']);
        $oCodUser->setBCampoBloqueado(true);
        $oCodUser->setBOculto(true);
        
        $oUserNome = new campo('Usuário','usernome', Campo::TIPO_TEXTO,2,2,2,2);
        $oUserNome->setSValor($_SESSION['nome']);
        $oUserNome->setBCampoBloqueado(true);
        
        $oLinha = new campo('','linha', Campo::TIPO_LINHA,12,12,12,12);
        
        //botao inserir apontamento
        $oBtnInserir = new Campo('Finaliza etapa','',  Campo::TIPO_BOTAOSMALL_SUB,5,5,5,5);
        
         $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_ordensFabApontEtapas","FinalizaEtapa",'
                 . '"'.$this->getTela()->getId().','.$IdGrid.',");';
         $oBtnInserir->getOBotao()->addAcao($sAcao);
        
        $this->addCampos(array($oOp,$oEtapa,$oCodEtapa,$oTratDes,$oUserNome),
                $oLinha,
                //$oTurno,
                $oBtnInserir,
                array($oFornoCod,$oFornoDes,$oCodUser));
    }
    
}

