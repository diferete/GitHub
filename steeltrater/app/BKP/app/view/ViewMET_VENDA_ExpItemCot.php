<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_VENDA_ExpItemCot extends View {

    public function __construct() {
        parent::__construct();
        $this->setController('MET_VENDA_ExpItemCot');
        $this->setTitulo('Produtos');
    }

    function criaGridDetalhe() {
        parent::criaGridDetalhe();

        /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(300);
        $oNr = new CampoConsulta('Nrº', 'nr');
        $oCodigo = new CampoConsulta('Código', 'codigo');
        $oCodigo->setILargura(50);
        $oDesc = new CampoConsulta('Descrição', 'descricao');
        $oDesc->setILargura(500);
        $oSeq = new CampoConsulta('Seq', 'seq');
        $oSeq->setILargura(30);
        $oVlrUnit = new CampoConsulta('Vlr. Unit.', 'vlrunit', Campo::TIPO_MONEY);
        $oQuant = new CampoConsulta('Qt.', 'quant', CampoConsulta::TIPO_DECIMAL);
        $oVlrTot = new CampoConsulta('Vlr. Total.', 'vlrtot', Campo::TIPO_MONEY);
        $oDisp = new CampoConsulta('Disp.', 'pdfdisp');
        $oDisp->setILargura(30);
        $this->addCamposDetalhe($oSeq, $oCodigo, $oDesc, $oQuant, $oVlrUnit, $oVlrTot, $oDisp, $oNr);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaConsulta() {
        parent::criaConsulta();


        $oNr = new CampoConsulta('Nº', 'nr');
        $oCodigo = new CampoConsulta('Código', 'codigo');
        $oDesc = new CampoConsulta('Descrição', 'descricao');
        $oSeq = new CampoConsulta('Seq', 'seq');
        $oQuant = new CampoConsulta('Qt.', 'quant', CampoConsulta::TIPO_DECIMAL);
        $oVlrUnit = new CampoConsulta('Vlr. Unit.', 'vlrunit', Campo::TIPO_MONEY);
        $oVlrUnit->addComparacao('0', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oVlrUnit->setBComparacaoColuna(true);
        $oVlrTot = new CampoConsulta('Vlr. Total.', 'vlrtot', Campo::TIPO_MONEY);
        $oVlrTot->setSOperacao('soma');
        $oVlrTot->setSTituloOperacao('Total: R$');
        $oVlrTot->addComparacao('0', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA);
        $oVlrTot->setBComparacaoColuna(true);
        $oDisp = new CampoConsulta('Disp.', 'pdfdisp');
        $oDisp->setILargura(30);
        $this->addCampos($oSeq, $oCodigo, $oDesc, $oQuant, $oVlrUnit, $oVlrTot, $oDisp, $oNr);
    }

    public function criaTela() {
        parent::criaTela();

        //cria o grid de itens
        $this->criaGridDetalhe();
        //traz os valores de cnpj razão e número da solicitação
        $aValor = $this->getAParametrosExtras();

        //campo do número da solicitação, campo será oculto
        $oNr = new Campo('', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setITamanho(Campo::TAMANHO_PEQUENO);
        $oNr->setSValor($aValor[2]);
        $oNr->setBCampoBloqueado(true);
        $oNr->setBOculto(true);
        //carrega campos de empcod
        $oEmpCod = new Campo('', 'empcodIten', Campo::TIPO_TEXTO, 1);
        $oEmpCod->setBCampoBloqueado(true);
        $oEmpCod->setBOculto(true);
        $oEmpCod->setSValor($aValor[0]);

        //carrega campos de empcod
        $oEmpdes = new Campo('', 'empdesIten', Campo::TIPO_TEXTO, 1);
        $oEmpdes->setBCampoBloqueado(true);
        $oEmpdes->setBOculto(true);
        $oEmpdes->setSValor($aValor[1]);

        //campo sequencia onde o campo será oculto
        $oSeq = new Campo('', 'seq', Campo::TIPO_TEXTO, 1);
        $oSeq->setITamanho(Campo::TAMANHO_PEQUENO);
        $oSeq->setBCampoBloqueado(true);
        $oSeq->setSValor('0');
        $oSeq->setBOculto(true);

        //campo código do produto
        $oCodigo = new Campo('Codigo', 'codigo', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oCodigo->setSIdHideEtapa($this->getSIdHideEtapa());
        $oCodigo->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCodigo->setBFocus(true);
        $oCodigo->addValidacao(false, Validacao::TIPO_STRING);

        //campo descrição do produto adicionando o campo de busca
        $oProdes = new Campo('Produto', 'descricao', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oProdes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oProdes->setSIdPk($oCodigo->getId());
        $oProdes->setClasseBusca('Produto');
        $oProdes->addCampoBusca('procod', '', '');
        $oProdes->addCampoBusca('prodes', '', '');
        $oProdes->setSIdTela($this->getTela()->getid());

        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodigo->setClasseBusca('Produto');
        $oCodigo->setSCampoRetorno('procod', $this->getTela()->getId());
        $oCodigo->addCampoBusca('prodes', $oProdes->getId(), $this->getTela()->getId());

        //campo quantidade setanto o valor inicial como zero
        $oQuant = new Campo('Quant.', 'quant', Campo::TIPO_TEXTO, 1);
        $oQuant->setITamanho(Campo::TAMANHO_PEQUENO);
        $oQuant->setSValor('0');
        $oQuant->addValidacao(false, Validacao::TIPO_STRING);
        $oQuant->setSCorFundo(Campo::FUNDO_VERDE);

        //campo preço bruto
        $oPrcBruto = new Campo('Tabela', 'prcbruto', Campo::TIPO_TEXTO, 1);
        $oPrcBruto->setITamanho(Campo::TAMANHO_PEQUENO);
        $oPrcBruto->setBCampoBloqueado(true);
        $oPrcBruto->setSValor('0');

        //campo valor unitário
        $oVlrUnit = new Campo('Vlr. Unit', 'vlrunit', Campo::TIPO_TEXTO, 1);
        $oVlrUnit->setITamanho(true);
        $oVlrUnit->setBCampoBloqueado(TRUE);
        $oVlrUnit->setSValor('0');

        //campo desconto
        $oDesconto = new Campo('Desconto', 'desconto', Campo::TIPO_TEXTO, 1);
        $oDesconto->setITamanho(Campo::TAMANHO_PEQUENO);
        $oDesconto->setSValor('0');
        $oDesconto->setSCorFundo(Campo::FUNDO_AMARELO);

        //campo acréscimo do tratamento
        $oTratamento = new Campo('Tratamento', 'desctrat', Campo::TIPO_TEXTO, 1);
        $oTratamento->setITamanho(Campo::TAMANHO_PEQUENO);
        $oTratamento->setSValor('0');
        $oTratamento->setSCorFundo(Campo::FUNDO_AMARELO);

        //campo desconto extra que aplicará o desconto após os desconto inicial, sempre será cumulativo
        $oDescExtra1 = new Campo('Desc.1', 'descextra1', Campo::TIPO_TEXTO, 1);
        $oDescExtra1->setITamanho(Campo::TAMANHO_PEQUENO);
        $oDescExtra1->setSValor('0');
        $oDescExtra1->setSCorFundo(Campo::FUNDO_AMARELO);

        //campo desconto extra2 que aplicará o desconto após os desconto inicial, sempre será cumulativo
        $oDescExtra2 = new Campo('Desc.2', 'descextra2', Campo::TIPO_TEXTO, 1);
        $oDescExtra2->setITamanho(Campo::TAMANHO_PEQUENO);
        $oDescExtra2->setSValor('0');
        $oDescExtra2->setSCorFundo(Campo::FUNDO_AMARELO);

        //campo que gera a sequencia da ordem de compra
        $oSeqOd = new Campo('Seq.Od', 'seqod', Campo::TIPO_TEXTO, 1);
        $oSeqOd->setITamanho(Campo::TAMANHO_PEQUENO);
        $oSeqOd->setSValor('0');

        //campo observação do produto
        $oObsProd = new Campo('Obs. Produto', 'obsprod', Campo::TIPO_TEXTO, 3);
        $oObsProd->setITamanho(Campo::TAMANHO_PEQUENO);
        $oObsProd->setSCorFundo(Campo::FUNDO_MONEY);
        $oObsProd->setSValor(' ');

        //check para checar se não apaga a obs do produto após a inserção
        $oChkTodos = new Campo('Todos', 'chkTodosItens', Campo::TIPO_CHECK, 1);
        $oChkTodos->setBValorCheck(false);
        $oChkTodos->setApenasTela(true);

        //campo valor total com moeda em real
        $oVlrTot = new Campo('Total', 'vlrtot', Campo::TIPO_TEXTO, 2);
        $oVlrTot->setITamanho(Campo::TAMANHO_PEQUENO);
        // $oVlrTot->setSTipoMoeda('R$');
        $oVlrTot->setBCampoBloqueado(true);
        $oVlrTot->setSValor('0');

        //botão inserir os dados
        $oBtnInserir = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid
        $sGrid = $this->getOGridDetalhe()->getSId();


        //id form,id incremento,id do grid, id focus,    
        $sAcao = $sAcao = 'convItenSolRep($("#' . $oVlrUnit->getId() . '").val(),"' . $oVlrUnit->getId() . '",$("#' . $oVlrTot->getId() . '").val(),"' . $oVlrTot->getId() . '",$("#' . $oPrcBruto->getId() . '").val(),"' . $oPrcBruto->getId() . '");requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . ',' . $oCodigo->getId() . '","' . $oNr->getSValor() . ',' . $oChkTodos->getId() . ',' . $oObsProd->getId() . ',' . $oDesconto->getId() . '");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        //traz o preço por kg
        $oPrecoKg = new Campo('Preço Kg', '', Campo::TIPO_BADGE, 1);
        $oPrecoKg->setSEstiloBadge(Campo::BADGE_DANGER);
        //fieldset que contém o controle da embalagem
        $oFieldEmb = new FieldSet('Embalagem');

        //traz a quantidade da caixa master
        $oCaixaMaster = new Campo('Master', 'cxmaster', Campo::TIPO_TEXTO, 1);
        $oCaixaMaster->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCaixaMaster->setBCampoBloqueado(true);

        //badge que trará avisos de como está o arredondamento da embalagem
        $oAguardMaster = new Campo('Aguardando', '', Campo::TIPO_BADGE, 1);

        //campo que retorna a sugestão de quantidade para fechar a embalagem master
        $oQtSugMaster = new Campo('Qt. Sugerida', 'qtsug', Campo::TIPO_TEXTO, 1);
        $oQtSugMaster->setITamanho(Campo::TAMANHO_PEQUENO);
        $oQtSugMaster->setBCampoBloqueado(true);

        //campo que retorna a quantidade de caixas master
        $oQtCaixaMaster = new Campo('Qt. Caixas', 'qtcaixa', Campo::TIPO_TEXTO, 1);
        $oQtCaixaMaster->setITamanho(Campo::TAMANHO_PEQUENO);
        $oQtCaixaMaster->setBCampoBloqueado(true);

        $oDiver = new Campo('Divergência', 'diver', Campo::TIPO_TEXTO, 1);
        $oDiver->setITamanho(Campo::TAMANHO_PEQUENO);
        $oDiver->setBCampoBloqueado(true);

        //botão para aplicar a quantidade para arredondar a master
        $oBtnMaster = new Campo('Aplicar', 'btnMaster', Campo::TIPO_BOTAOSMALL, 1);
        $sQtSugMaster = 'aplicaQtMaster("' . $oQtSugMaster->getId() . '","' . $oQuant->getId() . '")';
        $oBtnMaster->getOBotao()->addAcao($sQtSugMaster);
        $oBtnMaster->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);

        //campo que retorna a caixa normal
        $oCaixaNormal = new Campo('Normal', 'cxnormal', Campo::TIPO_TEXTO, 1);
        $oCaixaNormal->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCaixaNormal->setBCampoBloqueado(true);

        //badge que mostra avisos de divergência
        $oAguardNormal = new Campo('Aguardando', '', Campo::TIPO_BADGE, 1);

        //campo que mostra a quantidade sugerida normal
        $oQtSugNormal = new Campo('Qt. Sugerida', 'qtsugnormal', Campo::TIPO_TEXTO, 1);
        $oQtSugNormal->setITamanho(Campo::TAMANHO_PEQUENO);
        $oQtSugNormal->setBCampoBloqueado(true);

        //campo para mostrar quantidade de caixas normais
        $oQtCaixaNormal = new Campo('Qt. Caixas', 'qtcaixanormal', Campo::TIPO_TEXTO, 1);
        $oQtCaixaNormal->setITamanho(Campo::TAMANHO_PEQUENO);
        $oQtCaixaNormal->setBCampoBloqueado(true);


        //botão que aplica a quantidade sugerida pelo sistema
        $oBtnNormal = new Campo('Aplicar', 'btnNormal', Campo::TIPO_BOTAOSMALL, 1);
        $sAcaoSugQt = 'aplicaQtNormal("' . $oQtSugNormal->getId() . '","' . $oQuant->getId() . '")';
        $oBtnNormal->getOBotao()->addAcao($sAcaoSugQt);
        $oBtnNormal->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);

        //carrega o fieldset como oculto
        $oFieldEmb->setOculto(true);

        //adiciona os campos no fieldset
        $oFieldEmb->addCampos(array($oCaixaMaster, $oAguardMaster, $oQtSugMaster,
            $oQtCaixaMaster, $oDiver, $oBtnMaster, $oCaixaNormal, $oAguardNormal, $oQtSugNormal, $oQtCaixaNormal, $oBtnNormal));

        //campo para informar 
        $oLiberadoEmbalagem = new Campo('Embalagem', 'emb', Campo::TIPO_TEXTO, 1);
        $oLiberadoEmbalagem->setApenasTela(true);
        $oLiberadoEmbalagem->setBCampoBloqueado(true);
        $oLiberadoEmbalagem->setITamanho(Campo::TAMANHO_PEQUENO);
        //se o valor é negado não libera as quantidades, se o valor é liberado deixa passar
        $oLiberadoEmbalagem->setSValor('Negado');
        //traz o peso para cálculos necessários
        $oPesoProduto = new Campo('', 'peso', Campo::TIPO_TEXTO, 1);
        $oPesoProduto->setITamanho(Campo::TAMANHO_PEQUENO);
        $oPesoProduto->setBCampoBloqueado(true);
        $oPesoProduto->setBOculto(true);
        $oLibPrcKg = new Campo('Regra de Liberação', 'prcKg', Campo::TIPO_TEXTO, 2);
        $oLibPrcKg->setBCampoBloqueado(true);
        $oLibPrcKg->setSValor('Negado');
        $oLibPrcKg->setITamanho(Campo::TAMANHO_PEQUENO);

        $oLoteMinimo = new campo('Lote mínimo', 'lotemin', Campo::TIPO_TEXTO, 2);
        $oLoteMinimo->setBCampoBloqueado(true);
        $oLoteMinimo->setSValor('0');

        $oSolLib = new Campo('Solicita Liberação', 'sollib', Campo::TIPO_BOTAOSMALL, 1);
        $oSolLib->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);
        $sAcaoLib = 'var difporc =retornaPorc ("' . $oVlrUnit->getId() . '","' . $oPrcBruto->getId() . '"); '
                . ' var solPreco = calcPrecoKg("' . $oQuant->getId() . '","' . $oPesoProduto->getId() . '","' . $oVlrTot->getId() . '","' . $oPrecoKg->getId() . '"); '
                . 'requestAjax("' . $this->getTela()->getId() . '-form","AutPrecoItem","insereLib","P"+","+$("#' . $oNr->getId() . '").val()+","+$("#' . $oCodigo->getId() . '").val()+","+$("#' . $oProdes->getId() . '").val()+","+'
                . 'moedaParaNumero($("#' . $oPrcBruto->getId() . '").val())+","+moedaParaNumero($("#' . $oVlrUnit->getId() . '").val())+","+difporc+","+moedaParaNumero(solPreco)+","+$("#' . $oEmpCod->getId() . '").val()+","+$("#' . $oEmpdes->getId() . '").val()+","+$("#' . $oQuant->getId() . '").val());';

        $oSolLib->getOBotao()->addAcao($sAcaoLib);

        //campos data 

        $oData = new Campo('Data', 'data', Campo::TIPO_TEXTO, 1);
        $oData->setITamanho(Campo::TAMANHO_PEQUENO);
        $oData->setBCampoBloqueado(true);
        $oData->setSValor(date('d/m/Y'));

        $oHora = new Campo('', 'hora', Campo::TIPO_TEXTO, 1);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);
        $oHora->setBOculto(true);

        $oProd = new Campo('', 'odprod', Campo::TIPO_TEXTO, 1);
        $oProd->setITamanho(Campo::TAMANHO_PEQUENO);
        $oProd->setBCampoBloqueado(true);
        $oProd->setSValor(' ');
        $oProd->setBOculto(true);

        $oFieldLib = new FieldSet('Liberações');
        $oFieldLib->addCampos(array($oLiberadoEmbalagem, $oLibPrcKg, $oLoteMinimo, $oSolLib, $oPesoProduto, $oHora, $oEmpCod, $oEmpdes, $oProd));
        $oFieldLib->setOculto(true);
        /* adiciona o evento sair do campo chamando função 
         * entradaCodigo no arquivo funções 
         * chama o método no php acaoExitCampo para trazer preço e embalagens
         * chma função do cálculo dos descontos
         */
        $oCodigo->addEvento(Campo::EVENTO_SAIR, 'entradaCodigo("' . $oVlrUnit->getId() . '"); var oProcod=$("#' . $oCodigo->getId() . '").val(); var prcTabela =$("#' . $oPrcBruto->getId() . '").val(); var prcUnit =$("#' . $oVlrUnit->getId() . '").val();'
                . 'var oNrSaida = $("#' . $oNr->getId() . '").val();'
                . 'var oEmpSaida = $("#' . $oEmpCod->getId() . '").val();'
                . 'if($("#' . $oCodigo->getId() . '").val()!==""){'
                . 'requestAjax("","SolPedIten","acaoExitCodigo","' . $oPrcBruto->getId() . ','
                . '' . $oVlrUnit->getId() . ',' . $oCaixaMaster->getId() . ',' . $oCaixaNormal->getId() . ',"+oProcod+",' . $oPesoProduto->getId() . ',' . $oLibPrcKg->getId() . ',P,"+oNrSaida+","+oEmpSaida+",' . $oLoteMinimo->getId() . '    ","");  $("#' . $oQuant->getId() . '").trigger("blur");}');

        /*
         * Define os eventos no exit dos campos de desconto
         * chama a função calcSolCot para gerar o cálculo do desconto 
         * e multiplicar o valor total
         * gerencia validação do campo vlrUnit
         */
        $sEventoDesc = 'if ($("#' . $oDesconto->getId() . '").val()==""){$("#' . $oDesconto->getId() . '").val("0")}'
                . 'if ($("#' . $oTratamento->getId() . '").val()==""){$("#' . $oTratamento->getId() . '").val("0")}'
                . 'if ($("#' . $oDescExtra1->getId() . '").val()==""){$("#' . $oDescExtra1->getId() . '").val("0")}'
                . 'if ($("#' . $oDescExtra2->getId() . '").val()==""){$("#' . $oDescExtra2->getId() . '").val("0")}'
                . 'calcSolCot($("#' . $oQuant->getId() . '").val(),$("#' . $oPrcBruto->getId() . '").val(),$("#' . $oVlrUnit->getId() . '").val(),$("#' . $oDesconto->getId() . '").val(),'
                . '$("#' . $oTratamento->getId() . '").val(),$("#' . $oDescExtra1->getId() . '").val(),$("#' . $oDescExtra2->getId() . '").val(),'
                . '"' . $oVlrUnit->getId() . '","' . $oVlrTot->getId() . '","' . $oQuant->getId() . '","' . $oDesconto->getId() . '","' . $oTratamento->getId() . '","' . $oDescExtra1->getId() . '","' . $oDescExtra2->getId() . '"); '
                . '$("#' . $this->getTela()->getId() . '-form").formValidation("revalidateField", "' . $oVlrUnit->getNome() . '"); '
                . ' calcEmbNormal("' . $oQuant->getId() . '","' . $oCaixaNormal->getId() . '","' . $oAguardNormal->getId() . '","' . $oFieldEmb->getSId() . '","' . $oQtSugNormal->getId() . '","' . $oQtCaixaNormal->getId() . '");'
                . ' calcEmbMaster("' . $oQuant->getId() . '","' . $oCaixaMaster->getId() . '","' . $oAguardMaster->getId() . '","' . $oFieldEmb->getSId() . '","' . $oQtSugMaster->getId() . '","' . $oQtCaixaMaster->getId() . '","' . $oDiver->getId() . '");'
                . ' calcPrecoKg("' . $oQuant->getId() . '","' . $oPesoProduto->getId() . '","' . $oVlrTot->getId() . '","' . $oPrecoKg->getId() . '")';

        /**
         * Eventos para liberar digitação quando item não tem preço na tabela
         */
        $sEventoPrecoBruto = 'semTabelaPreco($("#' . $oVlrUnit->getId() . '").val(),"' . $oVlrUnit->getId() . '","' . $oPrcBruto->getId() . '",$("#' . $oPrcBruto->getId() . '").val());';

        $oQuant->addEvento(Campo::EVENTO_SAIR, $sEventoDesc);
        $oPrcBruto->addEvento(Campo::EVENTO_SAIR, $sEventoDesc);
        $oDesconto->addEvento(Campo::EVENTO_SAIR, $sEventoDesc);
        $oTratamento->addEvento(Campo::EVENTO_SAIR, $sEventoDesc);
        $oDescExtra1->addEvento(Campo::EVENTO_SAIR, $sEventoDesc);
        $oDescExtra2->addEvento(Campo::EVENTO_SAIR, $sEventoDesc);
        $oVlrUnit->addEvento(Campo::EVENTO_SAIR, $sEventoPrecoBruto);



        /*
         * Valida as quantidades de caixa
         */

        $sCallBackQt = 'if($("#' . $oQuant->getId() . '").val()<="0") {'
                . 'return { valid: false, message: "Não pode ser zero!" };'
                . '} else {'
                . 'if(verifLoteMin("' . $oLoteMinimo->getId() . '","' . $oQuant->getId() . '")==false){'
                . ' return { valid: false, message: "Atenção esse item está abaixo do lote mínimo!" };}else{'
                . 'if($("#' . $oLiberadoEmbalagem->getId() . '").val()=="Negado") {'
                . 'if(calcMod("' . $oQuant->getId() . '","' . $oCaixaNormal->getId() . '")==true) {'
                . 'return { valid: false, message: "Embalagem aberta!" };'
                . '}else{return { valid: true };}'
                . '}else{return { valid: true };}'
                . '}'
                . '}';


        $oQuant->addValidacao(true, Validacao::TIPO_CALLBACK, '', '1', '1000', '', '', $sCallBackQt, Validacao::TRIGGER_SAIR);

        /*
         * Valida preço por kg
         */
        $sValidaPrcKg = 'if (bloqueaPrcKg("' . $oLibPrcKg->getId() . '","' . $oVlrUnit->getId() . '","' . $oPrcBruto->getId() . '","' . $oQuant->getId() . '","' . $oPesoProduto->getId() . '","' . $oVlrTot->getId() . '") == false){'
                . 'return { valid: false, message: "Valor unitário abaixo do permitido!" };'
                . '} else {'
                . 'return { valid: true };'
                . '}';

        /*
         * Ação para definir como inválido o vlr como 0
         */
        /*  $sCallbackUnit = 'if($("#'.$oVlrUnit->getId().'").val()=="0,00") {'
          .'return { valid: false, message: "Não pode ser zero!" };'
          .'} else {'
          .'return { valid: true };'
          .'}'; */
        $oVlrUnit->addValidacao(true, Validacao::TIPO_CALLBACK, '', '1', '100', '', '', $sValidaPrcKg, Validacao::TRIGGER_SAIR);



        //adiciona os campos na tela
        $this->addCampos(array($oCodigo, $oProdes), array($oQuant, $oPrcBruto, $oVlrUnit, $oDesconto, $oTratamento, $oDescExtra1, $oDescExtra2), array($oSeqOd, $oObsProd, $oChkTodos, $oVlrTot, $oBtnInserir, $oPrecoKg, $oNr, $oSeq), $oFieldEmb, $oFieldLib);

        //campos para serem filtros iniciais no grid

        $this->addCamposFiltroIni($oNr);


        //adiciona botões nos grid detalhe

        $sAcaoDisp = 'var contdel = 0; '
                . 'var chavedel = []; '
                . '$("#' . $this->getOGridDetalhe()->getSId() . 'div tbody .selected").each(function(){'
                . 'chavedel[contdel] = $(this).find(".chave").html();'
                . 'contdel++;'
                . '});'
                . 'requestAjax("","' . $this->getController() . '","acaoMsgDisp","' . $this->getOGridDetalhe()->getSId() . '",chavedel);';
        $oBotaoEnt = new Botao('Disponível', Botao::TIPO_DETALHE, $sAcaoDisp);
        $oBotaoEnt->setSStyleBotao(Botao::TIPO_PRIMARY);

        $sAcaoDesm = 'var contdel = 0; '
                . 'var chavedel = []; '
                . '$("#' . $this->getOGridDetalhe()->getSId() . 'div tbody .selected").each(function(){'
                . 'chavedel[contdel] = $(this).find(".chave").html();'
                . 'contdel++;'
                . '});'
                . 'requestAjax("","' . $this->getController() . '","LimparDisp","' . $this->getOGridDetalhe()->getSId() . '",chavedel);';
        $oBotaoDesm = new Botao('Limpar', Botao::TIPO_DETALHE, $sAcaoDesm);
        $oBotaoDesm->setSStyleBotao(Botao::TIPO_WARNING);

        $this->getTela()->addBotDet($oBotaoEnt);
        $this->getTela()->addBotDet($oBotaoDesm);
    }

    /*
      public function addeventoConc() {
      parent::addeventoConc();
      $aValor = $this->getAParametrosExtras();
      $sRequest = 'requestAjax("","MET_VENDA_ExpItemCont","geraRelPdf","'. $aValor[2].',cotacao");';

      return $sRequest;
      }
     * 
     */
}
