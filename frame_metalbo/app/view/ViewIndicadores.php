<?php

/*
 * Classe que implementa as views de Indicadores
 * 
 * @author Cleverton Hoffmann
 * @since 26/10/2018
 */

class ViewIndicadores extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        
    }

    public function criaTela() {
        parent::criaTela();

    } 

    public function relSaldosPedidos() {
        parent::criaTelaRelatorio();
                               
        $oTab = new TabPanel();
        $oAbaGeral = new AbaTabPanel('GERENCIAL');
        $oAbaGeral->setBActive(true);

        $this->addLayoutPadrao('Aba');
 
        $this->setTituloTela('Relatório de Saldo de Pedidos');
        $this->setBTela(true);
        date_default_timezone_set('America/Sao_Paulo');
        $sData = date('d/m/Y');
        $oDtEmInicial = new Campo('DATA EMISSÃO INICIAL', 'dtemiInic', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDtEmInicial->setSValor(date('d-m-Y', strtotime('-30 days')));
        $oDtEmFinal = new Campo('DATA EMISSÃO FINAL', 'dtemiFinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDtEmFinal->setSValor($sData);
        $oDtEntInicial = new Campo('DATA ENTREGA INICIAL', 'dteEntInic', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDtEntInicial->setSValor(date('d-m-Y', strtotime('-700 days')));
        $oDtEntFinal = new Campo('DATA ENTREGA FINAL', 'dtEntFinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDtEntFinal->setSValor(date('d-m-Y', strtotime('+700 days')));
        
        $oNr = new Campo('NR PEDIDO', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
                
        $oTipoEquipCod = new Campo('CLIENTE', 'empcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oTipoEquipCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');

        $oTipoEquipDes = new Campo('DESCRIÇÃO', 'pro_subgrupodescricao', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oTipoEquipDes->setSIdPk($oTipoEquipCod->getId());
        $oTipoEquipDes->setClasseBusca('CadCliRep');
        $oTipoEquipDes->addCampoBusca('empcod', '', '');
        $oTipoEquipDes->addCampoBusca('empdes', '', '');
        $oTipoEquipDes->setSIdTela($this->getTela()->getid());
        $oTipoEquipDes->setBCampoBloqueado(true);

        $oTipoEquipCod->setClasseBusca('CadCliRep');
        $oTipoEquipCod->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oTipoEquipCod->addCampoBusca('empdes', $oTipoEquipDes->getId(), $this->getTela()->getId());
        
        $oRepInicial = new Campo('Rep. Inicial', 'repInicial', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oRepInicial->setSValor(1);
        $oRepFinal = new Campo('Rep. Final', 'repFinal', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oRepFinal->setSValor(99999999999999);
                
        //GERENCIAL
        
        $oIncluirExporta = new Campo ('Incluir Exportação','incluiExport',Campo::TIPO_CHECK, 2, 2);
        
        //PEDIDOS SEM FATURAMENTO NO PERÍODO
        
        $oAbaPedidSemFat = new AbaTabPanel('PEDIDO SEM FATURAMENTO NO PERÍODO');
        
        $oSemBelenusPedSem = new Campo ('Não Incluir Belenus','naoIncluiBelenus',Campo::TIPO_CHECK, 2, 2);
        $oSomenteBelenusPedSem = new Campo ('Somente Belenus','incluiSomenteBelenus',Campo::TIPO_CHECK, 2, 2);
        
        $IncluirExpPedSem =  new Campo ('Incluir Exportação','incluiExport',Campo::TIPO_CHECK, 2, 2);
        
        $oDtPedSem = new Campo('Data posição', 'dtPedSem', Campo::TIPO_DATA, 2, 2, 12, 12);
        
        //PEDIDOS COM FATURAMENTO NO PERÍODO
        
        $oAbaPedidComFat = new AbaTabPanel('PEDIDO COM FATURAMENTO NO PERÍODO');
        
        $oSemBelenusPedCom = new Campo ('Não Incluir Belenus','naoIncluiBelenus',Campo::TIPO_CHECK, 2, 2);
        $oSomenteBelenusPedCom = new Campo ('Somente Belenus','incluiSomenteBelenus',Campo::TIPO_CHECK, 2, 2);
        
        $IncluirExpPedCom = new Campo ('Incluir Exportação','incluiExport',Campo::TIPO_CHECK, 2, 2);
        
        $oDtPedCom = new Campo('Data posição', 'dtPedCom', Campo::TIPO_DATA, 2, 2, 12, 12);
        
        //PEDIDOS EM ABERTO SOMENTE ITENS C/SALDOS
        
        $oAbaPedidAbertItens = new AbaTabPanel('PEDIDOS EM ABERTO SOMENTE ITENS C/SALDOS');
        
        $oSemBelenusAbertItens = new Campo ('Não Incluir Belenus','naoIncluiBelenus',Campo::TIPO_CHECK, 2, 2);
        $oSomenteBelenusAbertItens = new Campo ('Somente Belenus','incluiSomenteBelenus',Campo::TIPO_CHECK, 2, 2);
        
        $IncluirExpAbertItens = new Campo ('Incluir Exportação','incluiExport',Campo::TIPO_CHECK, 2, 2);
                
        $oDtPedAbertItens = new Campo('Data posição', 'dtPedAbertItens', Campo::TIPO_DATA, 2, 2, 12, 12);

        //Nº DE SALDOS POR ÍTEM
        $oAbaNumSalItem = new AbaTabPanel('Nº DE SALDOS POR ÍTEM');
        
        $oRegistros = new Campo('Registros', 'registros', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        
        $oOrdenacaoNrPedidos = new Campo ('Ordena nº pedidos','ordenacaoNrPedidos',Campo::TIPO_CHECK, 2, 2);
        $oOrdenacaoPorValor = new Campo ('Ordena por valor','ordenacaoPorValor',Campo::TIPO_CHECK, 2, 2);
        $oOrdenacaoQtSaldo = new Campo ('Qt. Saldo','ordenacaoQtSaldo',Campo::TIPO_CHECK, 2, 2);
        
        
        //////////////////////////////////////VERIFICAR BUSCA DAS CLASSES NÄAO TRAY DADOS
        $oAbaAdicional = new AbaTabPanel('ADICIONAL');
        //Grupo
        $oGrupoCodIni = new Campo('Grupo Inicial', 'grupocodigoIni', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oGrupoCodIni->setClasseBusca('GrupoProd');
        $oGrupoCodIni->setSCampoRetorno('grucod', $this->getTela()->getid());
        $oGrupoCodIni->setApenasTela(true);
        
        $oGrupoCodFin = new Campo('Grupo Final', 'grupocodigoFin', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oGrupoCodFin->setClasseBusca('GrupoProd');
        $oGrupoCodFin->setSCampoRetorno('grucod', $this->getTela()->getid());
        $oGrupoCodFin->setApenasTela(true);
        
        //Sub Grupo
        $oSubGrupoCodIni = new Campo('SubGrupo Inicial', 'subgrupocodigoIni', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSubGrupoCodIni->setClasseBusca('SubGrupoProd');
        $oSubGrupoCodIni->setSCampoRetorno('subcod', $this->getTela()->getid());
        $oSubGrupoCodIni->setApenasTela(true);
        
        $oSubGrupoCodFin = new Campo('SubGrupo Final', 'subgrupocodigoFin', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSubGrupoCodFin->setClasseBusca('SubGrupoProd');
        $oSubGrupoCodFin->setSCampoRetorno('subcod', $this->getTela()->getid());
        $oSubGrupoCodFin->setApenasTela(true);
              
        //Família
        $oFamiliaCodIni = new Campo('Familia Inicial', 'familiacodigoIni', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFamiliaCodIni->setClasseBusca('FamProd');
        $oFamiliaCodIni->setSCampoRetorno('famcod', $this->getTela()->getid());
        $oFamiliaCodIni->setApenasTela(true);
        
        $oFamiliaCodFin = new Campo('Familia Final', 'familiacodigoFin', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFamiliaCodFin->setClasseBusca('FamProd');
        $oFamiliaCodFin->setSCampoRetorno('famcod', $this->getTela()->getid());
        $oFamiliaCodFin->setApenasTela(true);
        
        //Sub Família
        $oSubFamiliaCodIni = new Campo('SubFamilia Inicial', 'subfamiliacodigoIni', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSubFamiliaCodIni->setClasseBusca('FamSub');
        $oSubFamiliaCodIni->setSCampoRetorno('famsub', $this->getTela()->getid());
        $oSubFamiliaCodIni->setApenasTela(true);
        
        $oSubFamiliaCodFin = new Campo('SubFamilia Final', 'subfamiliacodigoFin', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSubFamiliaCodFin->setClasseBusca('FamSub');
        $oSubFamiliaCodFin->setSCampoRetorno('famsub', $this->getTela()->getid());
        $oSubFamiliaCodFin->setApenasTela(true);
        
        $oSemBelenus = new Campo ('Não Incluir Belenus','naoIncluiBelenus',Campo::TIPO_CHECK, 2, 2);
        $oSomenteBelenus = new Campo ('Somente Belenus','incluiSomenteBelenus',Campo::TIPO_CHECK, 2, 2);
        
        $IncluirExp =  new Campo ('Incluir Exportação','incluiExport',Campo::TIPO_CHECK, 2, 2);
       
        $oDtPosicao = new Campo('Data posição', 'dtPosicao', Campo::TIPO_DATA, 2, 2, 12, 12);

        /////////////////////////////////////////////////////////////////////////////////////
        //SALDO PARA ENTREGA NO PERÍODO
        $oAbaSaldoEntrega = new AbaTabPanel('SALDO PARA ENTREGA NO PERÍODO');
        
        $oSemBelenusSald = new Campo ('Não Incluir Belenus','naoIncBelenus',Campo::TIPO_CHECK, 2, 2);
        $oSomenteBelenusSald = new Campo ('Somente Belenus','incluiSomBelenus',Campo::TIPO_CHECK, 2, 2);
        
        $IncluirExpSald =  new Campo ('Incluir Exportação','incluiExport',Campo::TIPO_CHECK, 2, 2);
        
        $oDtSaldo = new Campo('Data posição', 'dtSaldo', Campo::TIPO_DATA, 2, 2, 12, 12);

        /////////////////////////////////////////////////////////////////////////////////
        //ÁREA DE ALTERAÇÃO DOS BOTÕES
        
        $oBtnGerenc = new Campo('Gerar','btnGerenc', Campo::TIPO_BOTAOSMALL,1);
        $sAcaoGerenc='requestAjax("'.$this->getTela()->getId().'-form","Indicadores","saldoPedidosGerencial","");';
        $oBtnGerenc->getOBotao()->addAcao($sAcaoGerenc);
        
        $oBtnSemFat = new Campo('Gerar','btnSemFat', Campo::TIPO_BOTAOSMALL,1);
        $sAcaoSemFat='requestAjax("'.$this->getTela()->getId().'-form","Indicadores","saldoPedidosSemFaturamento","");';
        $oBtnSemFat->getOBotao()->addAcao($sAcaoSemFat);
        
        $oBtnComFat = new Campo('Gerar','btnComFat', Campo::TIPO_BOTAOSMALL,1);
        $sAcaoComFat='requestAjax("'.$this->getTela()->getId().'-form","Indicadores","SaldoPedComFaturamentoParcial","");';
        $oBtnComFat->getOBotao()->addAcao($sAcaoComFat);
        
        $oBtnPedAbe = new Campo('Gerar','btnPedAbe', Campo::TIPO_BOTAOSMALL,1);
        $sAcaoPedAbe='requestAjax("'.$this->getTela()->getId().'-form","Indicadores","SaldoPedAbertosItemComSaldo","");';
        $oBtnPedAbe->getOBotao()->addAcao($sAcaoPedAbe);
        
        $oBtnSaldItem = new Campo('Gerar','btnSaldItem', Campo::TIPO_BOTAOSMALL,1);
        $sAcaoSaldItem='requestAjax("'.$this->getTela()->getId().'-form","Indicadores","NrSaldosPorItem","");';
        $oBtnSaldItem->getOBotao()->addAcao($sAcaoSaldItem);
        
        $oBtnAdic = new Campo('Gerar','btnAdic', Campo::TIPO_BOTAOSMALL,1);
        $sAcaoAdic='requestAjax("'.$this->getTela()->getId().'-form","Indicadores","AdicionalSaldosIntervalos","");';
        $oBtnAdic->getOBotao()->addAcao($sAcaoAdic);
        
        $oBtnSaldo = new Campo('Gerar','btnSaldo', Campo::TIPO_BOTAOSMALL,1);
        $sAcaoSaldo='requestAjax("'.$this->getTela()->getId().'-form","Indicadores","SaldoEntregaNoPeriodo","");';
        $oBtnSaldo->getOBotao()->addAcao($sAcaoSaldo);
        
        
        $sL = new Campo('', '', Campo::TIPO_LINHABRANCO);

        $oAbaGeral->addCampos($oIncluirExporta,$oBtnGerenc);
        $oAbaPedidSemFat->addCampos($IncluirExpPedSem, $oSemBelenusPedSem,$oSomenteBelenusPedSem,$sL, array($oDtPedSem,$oBtnSemFat));
        $oAbaPedidComFat->addCampos($IncluirExpPedCom,$oSemBelenusPedCom,$oSomenteBelenusPedCom,$sL,array($oDtPedCom,$oBtnComFat));
        $oAbaPedidAbertItens->addCampos($IncluirExpAbertItens,$oSemBelenusAbertItens,$oSomenteBelenusAbertItens,$sL,array($oDtPedAbertItens,$oBtnPedAbe));
        $oAbaNumSalItem->addCampos($oRegistros,$oOrdenacaoNrPedidos,$oOrdenacaoPorValor,$oOrdenacaoQtSaldo,$oBtnSaldItem);
        $oAbaAdicional->addCampos(array($oGrupoCodIni,$oGrupoCodFin), array ($oSubGrupoCodIni,$oSubGrupoCodFin),array($oFamiliaCodIni,$oFamiliaCodFin),
                array($oSubFamiliaCodIni,$oSubFamiliaCodFin),$sL,
                array($oSemBelenus,$oSomenteBelenus,$IncluirExp),$sL,array($oDtPosicao,$oBtnAdic));
        $oAbaSaldoEntrega->addCampos($oSemBelenusSald,$oSomenteBelenusSald,$IncluirExpSald,$sL,array($oDtSaldo,$oBtnSaldo));
        
       
        $oTab->addItems($oAbaGeral,$oAbaPedidSemFat,$oAbaPedidComFat,
                $oAbaPedidAbertItens,$oAbaNumSalItem,$oAbaAdicional,$oAbaSaldoEntrega);
       
        $this->addCampos(array($oDtEmInicial,$oDtEmFinal,$oDtEntInicial,$oDtEntFinal),
                         $sL,array($oNr, $oTipoEquipCod,$oTipoEquipDes),$sL,array($oRepInicial,$oRepFinal),$sL,$oTab/* ,oSistema */);
    }
    
}
