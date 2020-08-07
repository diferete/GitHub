<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 18/07/2018
 */

class ViewSTEEL_PCP_ordensFabApontEnt extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oOp = new CampoConsulta('OP', 'op');
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oCod = new CampoConsulta('Cod.', 'fornocod');
        $oDtent = new CampoConsulta('Data entrada', 'dataent_forno');
        $oHentr = new CampoConsulta('Hora entrada', 'horaent_forno');
        $oDtsaid = new CampoConsulta('Data saída', 'datasaida_forno');
        $oHsaida = new CampoConsulta('Hora saída', 'horasaida_forno');
        $oUserName = new campoconsulta('Usuário','username');
        $oDescricaoopfiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO, 5);
        

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaoopfiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oOp,$oSeq,$oCod,$oDtent,$oHentr,$oDtsaid,$oHsaida,$oUserName);
    }

    public function criaTela() {
        parent::criaTela();
        //captura os dados 
        $aDados = $this->getAParametrosExtras();
        $aFornosRadio = $aDados[1];
        
        $oOuser = Fabrica::FabricarController('MET_TEC_Usuario');
        $oOuser->Persistencia->adicionaFiltro('usucodigo',$_SESSION['codUser']);
        $oOuserDados = $oOuser->Persistencia->consultarWhere();
        
        $this->setBOcultaBotTela(true);
        $this->setBOcultaFechar(true);
        
        $this->setBTela(true);
        $oLinha = new campo('','linha1', Campo::TIPO_LINHA,12);
        
        $oOp = new Campo('OP', 'op', Campo::TIPO_BUSCADOBANCOPK, 3, 3, 6, 6);
        $oOp->setSCorFundo(Campo::FUNDO_AMARELO);
        $oOp->addValidacao(false, Validacao::TIPO_STRING,'','1','100');
        $oOp->setClasseBusca('STEEL_PCP_ordensFabListaPesq');
        $oOp->setSCampoRetorno('op', $this->getTela()->getId());
        $oOp->setBFocus(true);
        
       
        
        $oBtnPesqOp = new Campo('Pesquisar','btn1', Campo::TIPO_BOTAOSMALL);
        $oBtnPesqOp->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        
        $oSeq = new Campo('','seq', Campo::TIPO_TEXTO,1);
        $oSeq->setBOculto(true);
       
        $oCliente = new Campo('Cliente','cliente', Campo::TIPO_TEXTO,5);
        $oCliente->setBCampoBloqueado(true);
        $oCliente->setSFont(Campo::FONT_BOLD);
        
        $oOpCliente = new Campo('Op do cliente','opcli', Campo::TIPO_TEXTO,2);
        $oOpCliente->setBCampoBloqueado(true);
        $oOpCliente->setSFont(Campo::FONT_BOLD);
        
        $oProcod = new Campo('Código','procod', Campo::TIPO_TEXTO,2);
        $oProcod->setBCampoBloqueado(true);
        $oProcod->setSFont(Campo::FONT_BOLD);
       // $oProcod->addValidacao(false, Validacao::TIPO_STRING,'','1','100');
        $oProdes = new Campo('Descrição','prodes', Campo::TIPO_TEXTO,4);
        $oProdes->setBCampoBloqueado(true);
        $oProdes->setSFont(Campo::FONT_BOLD);
        
        
        $oFornoCod = new campo('','fornocod', Campo::TIPO_TEXTO,1);
        $oFornoCod->setBOculto(true);
        $oFornoDes=new Campo('','fornodes', Campo::TIPO_TEXTO,2);
        $oFornoDes->setBOculto(true);
        
        $oTurno = new campo('Turno','turnoSteel', Campo::CAMPO_SELECTSIMPLE,2,2,2,2);
        $oTurno->addItemSelect('Turno A','Turno A');
        $oTurno->addItemSelect('Turno B','Turno B');
        $oTurno->addItemSelect('Turno C','Turno C');
        $oTurno->addItemSelect('Turno D','Turno D');
        $oTurno->setSValor($oOuserDados->getTurnoSteel());
        //-----------------------combo dos fornos---------------------------
         $oFornoChoice = new campo('FORNO PARA APONTAMENTO ','fornoCombo', Campo::CAMPO_SELECTSIMPLE,3,3,3,3);
        foreach ($aFornosRadio as $keyForno => $oValueForno) {
            $oFornoChoice->addItemSelect($oValueForno->getFornocod(),$oValueForno->getFornodes());
        }
       $sCombo ='var textCombo = $("#'.$oFornoChoice->getId().' option:selected").text(); '
                . 'var valueCombo = $("#'.$oFornoChoice->getId().'").val(); '
                .'$("#'.$oFornoCod->getId().'").val(valueCombo); $("#'.$oFornoDes->getId().'").val(textCombo); ';
        $oFornoChoice->addEvento(Campo::EVENTO_CHANGE,$sCombo);
        //-----------------------------------------------------------------
        
        $oFornoCod->setSCorFundo(Campo::FUNDO_VERDE);
        $oFornoCod->setSFont(Campo::FONT_BOLD);
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
        $oFornoDes->addValidacao(false, Validacao::TIPO_STRING,'','3','100');
        
        $oCodUser = new campo('coduser','coduser', Campo::TIPO_TEXTO,1,1,1,1);
        $oCodUser->setSValor($_SESSION['codUser']);
        $oCodUser->setBCampoBloqueado(true);
        
        $oUserNome = new campo('user','usernome', Campo::TIPO_TEXTO,2,2,2,2);
        $oUserNome->setSValor($_SESSION['nome']);
        $oUserNome->setBCampoBloqueado(true);
        
         //botao inserir apontamento
        $oBtnInserir = new Campo('Inserir','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId()); 
        
        //adiciona os eventos ao sair do campo op e do botao pesquisar //
         $sEventoOp = 'var OpSteel =  $("#'.$oOp->getId().'").val();if(OpSteel !==""){$("#'.$oBtnInserir->getId().'").click();}'
                 . 'else{$("#'.$oCliente->getId().'").val(""); $("#'.$oOpCliente->getId().'").val(""); $("#'.$oProcod->getId().'").val("");$("#'.$oProdes->getId().'").val("");                                           };';
         $oBtnPesqOp->getOBotao()->addAcao($sEventoOp);
         $oOp->addEvento(Campo::EVENTO_SAIR,$sEventoOp);
             
         
       
        //##########################INSERÇÃO DO GRID DE CONTROLE###########################
         $oGridEnt = new campo('Entrada no forno', 'gridEntForno', Campo::TIPO_GRID, 12, 12, 12, 12, 150);
         $oGridEnt->getOGrid()->setAbaSel($this->getSIdAbaSelecionada());
         
        $oBotaoExcluir = new CampoConsulta('Excluir','excluir', CampoConsulta::TIPO_EXCLUIR);
        $oBotaoExcluir->setSTitleAcao('Excluir apontamento!');
        $oBotaoExcluir->addAcao('STEEL_PCP_ordensFabApontEnt','msgExcluirApontamento');
        $oBotaoExcluir->setBHideTelaAcao(false);
        $oBotaoExcluir->setILargura(30);
         
         
         $oOpGrid = new CampoConsulta('Op','op');
        // $oProcodGrid = new CampoConsulta('Código','procod');
         $oProcodDesGrid = new CampoConsulta('Produto','prodes');
         $oProcodDesGrid->setILargura(300);
         $oFornoDesGrid = new CampoConsulta('Forno','fornodes');
         $oSteelTurno = new CampoConsulta('Turno','turnoSteel');
         $oDataEntGrid = new CampoConsulta('Data Ent','dataent_forno', CampoConsulta::TIPO_DATA);
         $oHoraEntGrid = new CampoConsulta('Hora Ent','horaent_forno', CampoConsulta::TIPO_TIME);
         $oSituaca = new CampoConsulta('Situação','situacao');
         $oUserNameG = new campoconsulta('Usuário','usernome');
         $oSituaca->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
         $oSituaca->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO,CampoConsulta::MODO_COLUNA);
         $oSituaca->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
         
         
         $oGridEnt->addCampos($oBotaoExcluir,$oOpGrid,$oProcodDesGrid,$oFornoDesGrid,$oSteelTurno,$oDataEntGrid,$oHoraEntGrid,$oSituaca,$oUserNameG);
         $oGridEnt->setSController('STEEL_PCP_ordensFabApontEnt');
         $oGridEnt->addParam('op', '0');
         $oGridEnt->getOGrid()->setIAltura(500);
        
       
        $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_ordensFabApontEnt","inserirApont",'
                 . '"'.$this->getTela()->getId().','. $oGridEnt->getId().','.$oOp->getId().','
                . ''.$oFornoChoice->getId().','.$oFornoCod->getId().','.$oFornoDes->getId().','.$oTurno->getId().'");';
        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
         
        //busca ao abrir o campo
         $sAcaoBusca = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontEnt","getDadosGrid","' . $oGridEnt->getId() . '","consultaApontGrid");';
        $this->getTela()->setSAcaoShow($sAcaoBusca);
        
        //botao atualizar
        $sAcaoAtualizar = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontEnt","getDadosGrid","' . $oGridEnt->getId() . '","consultaApontGrid");';
        $oBtnAtualizar = new Campo('Atualizar','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $oBtnAtualizar->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);
        $oBtnAtualizar->getOBotao()->addAcao($sAcaoAtualizar);
        
        $this->addCampos(array($oFornoChoice,$oTurno,$oCodUser,$oUserNome),$oLinha,array($oOp,$oBtnPesqOp,$oSeq),
                array($oBtnInserir,$oBtnAtualizar,$oFornoDes,$oFornoCod),$oGridEnt);
     
        //$oCliente,$oOpCliente,$oProcod,$oProdes,
     }
    
     public function consultaApontGrid() {
        $oGridApont = new Grid("");
        
        $oBotaoExcluir = new CampoConsulta('Excluir','excluir', CampoConsulta::TIPO_EXCLUIR);
        $oBotaoExcluir->setSTitleAcao('Excluir apontamento!');
        $oBotaoExcluir->addAcao('STEEL_PCP_ordensFabApontEnt','msgExcluirApontamento');
        $oBotaoExcluir->setBHideTelaAcao(false);
        $oBotaoExcluir->setILargura(30);
        
        $oOp = new CampoConsulta('Op','op');
         //$oProcodGrid = new CampoConsulta('Código','procod');
         $oProcodDesGrid = new CampoConsulta('Produto','prodes');
         $oProcodDesGrid->setILargura(300);
         $oFornoDesGrid = new CampoConsulta('Forno','fornodes');
         $oSteelTurno = new CampoConsulta('Turno','turnoSteel');
         $oDataEntGrid = new CampoConsulta('Data Ent','dataent_forno', CampoConsulta::TIPO_DATA);
         $oHoraEntGrid = new CampoConsulta('Hora Ent','horaent_forno', CampoConsulta::TIPO_TIME);
         $oSituaca = new CampoConsulta('Situação','situacao');
         $oUserNameG = new campoconsulta('Usuário','usernome');
         $oSituaca->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
         $oSituaca->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO,CampoConsulta::MODO_COLUNA);
         $oSituaca->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
        
         $oGridApont->addCampos($oBotaoExcluir,$oOp,$oProcodDesGrid,$oFornoDesGrid,$oSteelTurno,$oDataEntGrid,$oHoraEntGrid,$oSituaca,$oUserNameG);

        $aCampos = $oGridApont->getArrayCampos();
        return $aCampos;
    }

}
