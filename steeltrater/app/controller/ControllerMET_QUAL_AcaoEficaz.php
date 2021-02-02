<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_QUAL_AcaoEficaz extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_QUAL_AcaoEficaz');
    }

    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        $this->View->setAParametrosExtras($aChave);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
        if (count($aparam) > 0) {
            $this->Persistencia->adicionaFiltro('filcgc', $aparam[0]);
            $this->Persistencia->adicionaFiltro('nr', $aparam[1]);
            $this->Persistencia->setChaveIncremento(false);
        } else {
            $this->Persistencia->adicionaFiltro('filcgc', $aparam1[0]);
            $this->Persistencia->adicionaFiltro('nr', $aparam1[1]);
            $this->Persistencia->setChaveIncremento(false);
        }
    }

    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
        $this->Persistencia->adicionaFiltro('seq', $this->Model->getSeq());
    }

    public function acaoLimpar($sForm, $sDados) {
        parent::acaoLimpar($sForm, $sDados);
        $aParam = explode(',', $sDados);
        // "$('#".$sId."').each (function(){ this.reset();});";
        //verifica se está como 
        $sScript = '$("#' . $sForm . '").each (function(){ this.reset();});';
        echo $sScript;
    }

    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&', $aChave);
        unset($aCampos[2]);
        foreach ($aCampos as $key => $sCampoAtual) {
            $aCampoAtual = explode('=', $sCampoAtual);
            $aModel = explode('.', $aCampoAtual[0]);
            $this->Persistencia->adicionaFiltro($aModel[0], $aCampoAtual[1]);
        }

        $this->Persistencia->setChaveIncremento(false);
    }

    public function apontEficaz($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $this->carregaModel($aCamposTela);

        $aRetorno = $this->Persistencia->inserir();
        //insere os filtros 
        $this->Persistencia->adicionafiltro('filcgc', $aCampos['filcgc']);
        $this->Persistencia->adicionafiltro('nr', $aCampos['nr']);
        $iCont = $this->Persistencia->getcount();
        $iCont ++;
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('Sucesso', 'Inserido com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            $sLimpa = '$("#' . $aDados[0] . '").each (function(){ this.reset();});';
            echo $sLimpa;
            echo '$("#' . $aDados[2] . '").val("' . $iCont . '");';
            echo 'requestAjax("' . $aDados[0] . '","MET_QUAL_AcaoEficaz","getDadosGrid","' . $aDados[1] . '","consultaEficaz");';
        } else {
            $oMensagem = new Modal('Problema', 'Problemas ao retorna plano de ação' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('filcgc', $aCampos['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aCampos['nr']);
        }
    }

    public function excluirEf($sDados) {

        $aDados = explode(',', $sDados);
        $aRetorno[0] = true;
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aChave = explode(',', $sChave);

        $this->Persistencia->iniciaTransacao();
        $this->carregaModelString($aChave[0]);
        $this->Model = $this->Persistencia->consultar();

        $aRetorno = $this->Persistencia->excluir(true);
        if ($aRetorno[0]) {
            $this->Persistencia->commit();
            $oMensagemSucesso = new Mensagem('Sucesso!', 'Seu registro foi deletado...', Mensagem::TIPO_SUCESSO);
            echo $oMensagemSucesso->getRender();
            echo 'requestAjax("' . $aDados[0] . '","MET_QUAL_AcaoEficaz","getDadosGrid","' . $aDados[1] . '","consultaEficaz");';
        } else {
            $oMensagemErro = new Mensagem('Falha', 'O registro não foi excluído!', Mensagem::TIPO_ERROR);
            echo $oMensagemErro->getRender();
        }
    }

    public function criaTelaModalApontaEficaz($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $aChave = explode('&', $aDados[2]);
        $aFilcgc = explode('=', $aChave[0]);
        $aNr = explode('=', $aChave[1]);
        $aSeq = explode('=', $aChave[2]);


        $aParam = array();
        $aParam[0] = $aFilcgc[1];
        $aParam[1] = $aNr[1];
        $aParam[2] = $aSeq[1];

        $this->Persistencia->adicionaFiltro('filcgc', $aParam[0]);
        $this->Persistencia->adicionaFiltro('nr', $aParam[1]);
        $this->Persistencia->adicionaFiltro('seq', $aParam[2]);
        $oDados = $this->Persistencia->consultarWhere();


        $this->View->setAParametrosExtras($oDados);

        $this->View->criaModalApontaEficaz();
        //busca lista pela op

        $this->View->getTela()->setSRender($aDados[0] . '-modal');

        //renderiza a tela
        $this->View->getTela()->getRender();
    }

    public function apontaEfi($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if ($aCampos['datareal'] != null && $aCampos['obs'] != null) {
            $aRet = $this->Persistencia->apontaEfi();
            if ($aRet[0]) {
                $oMensagem = new Mensagem('Sucesso', 'Apontamento realizado com sucesso!', Mensagem::TIPO_SUCESSO);
                echo $oMensagem->getRender();
                echo '$("#modalApontaEficaz-btn").click();';
                $iRet = $this->Persistencia->finalizaAcao($aCampos);
                switch ($iRet) {
                    case 0:
                        $oMensagem1 = new Mensagem('Sucesso', 'Sua AQ foi finalizada com sucesso! Não existem mais avaliações da eficácia em aberto.', Mensagem::TIPO_SUCESSO);
                        $sLimpa = '$("#' . $aDados[0] . '").each (function(){ this.reset();});';
                        echo $sLimpa;
                        echo $oMensagem1->getRender();
                        exit();
                    case 1:
                        $oMensagem1 = new Mensagem('Atenção', 'Problemas ao tentar Finalizar a AQ automaticamente, contate o Setor de TI.' . $aRet[1], Mensagem::TIPO_WARNING);
                        echo $oMensagem1->getRender();
                        exit();
                    case 2:
                        $oMensagem1 = new Mensagem('Atenção', 'Ainda existem avaliações de eficácia em aberto!' . $aRet[1], Mensagem::TIPO_WARNING);
                        echo $oMensagem1->getRender();
                        exit();
                }
            } else {
                $oMensagem = new Mensagem('Atenção', 'Problemas ao apontar eficácia!' . $aRet[1], Mensagem::TIPO_WARNING);
                echo $oMensagem->getRender();
            }
        } else {
            $oMensagem = new Mensagem('Atenção', 'Favor preencher todos os campos', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

    public function apontaRetEfi($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $aRet = $this->Persistencia->retEfi();
        if ($aRet[0]) {
            $this->Persistencia->reabreAq($aCampos);
            $oMensagem = new Mensagem('Sucesso', 'Retornado com sucesso!', Mensagem::TIPO_SUCESSO);
            $sLimpa = '$("#' . $aDados[0] . '").each (function(){ this.reset();});';
            echo $sLimpa;
            echo 'requestAjax("' . $aDados[0] . '","MET_QUAL_AcaoEficaz","getDadosGrid","' . $aDados[1] . '","consultaEficaz");';
        } else {
            $oMensagem = new Modal('Problema', 'Problemas ao retornar plano de ação' . $aRet[1], Modal::TIPO_ERRO, false, true, true);
        }
        echo $oMensagem->getRender();
    }

    public function envMailTodosMsg($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oMensagem = new Modal('Email', 'Deseja enviar e-mail para todos os envolvidos nessa ação da qualidade?', Modal::TIPO_INFO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_QUAL_AcaoEficaz","geraPdfQualAqTodos","' . $sDados . '");');

        echo $oMensagem->getRender();
    }

    public function geraPdfQualAqTodos($sDados) {
        $aDados = explode(',', $sDados);
        $sAq[] = $aDados[3];
        $sChave = htmlspecialchars_decode($sAq[0]);
        $aDadosAq = explode('&', $sChave);
        $sFilcgcDados = $aDadosAq[0];
        $sNrDados = $aDadosAq[1];

        $aFilcg = explode('=', $sFilcgcDados);
        $aNr = explode('=', $sNrDados);

        $_REQUEST['filcgcAq'] = $aFilcg[1];
        $_REQUEST['nrAq'] = $aNr[1];
        $_REQUEST['email'] = 'S';
        $_REQUEST['userRel'] = $_SESSION['nome'];
        $_REQUEST['todos'] = 'S';

        require 'app/relatorio/AqImp.php';
    }

}
