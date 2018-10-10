<?php

/*
 * Classe que implementa a controller CadCliRep
 * @author Avanei Martendal
 * @since 18/09/2017
 */

class ControllerCadCliRepRec extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('CadCliRepRec');
    }

    /**
     * Mensagem para gerar cadastro 
     */
    public function msgCadastro($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $this->Persistencia->adicionafiltro('nr', $aCamposChave['nr']);
        $oRow = $this->Persistencia->consultarWhere();

        if ($oRow->getSituaca() !== 'Liberado') {
            $oMensagem = new Modal('Atenção', 'O cadastro nº' . $aCamposChave['nr'] . ' não está liberado para cadastro!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        } else {
            //verifica se há um cnpj já cadastrado no sistema
            $aRetono = $this->Persistencia->buscaVerificaCnpj($oRow->getEmpcod()); //$oRow->getEmpcod()
            if ($aRetono[0]) {
                $oMensagem = new Modal('Gerar cadastro', 'Deseja gerar cadastro nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","geraCadastro","' . $sDados . '");');
                echo $oMensagem->getRender();
            } else {
                $oMensagem = new Modal('Atenção', $aRetono[1], Modal::TIPO_ERRO, false, true, true);
                echo $oMensagem->getRender();
            }
        }
    }

    public function geraCadastro($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();



        $this->Persistencia->adicionafiltro('nr', $aCamposChave['nr']);
        $oRow = $this->Persistencia->consultarWhere();

        $aRetorno = $this->Persistencia->geraCadastro($oRow);

        if ($aRetorno[0]) {
            //insere email de nfe
            $aRetorno = $this->Persistencia->insereEmailNfe($oRow);
            //insere endereços

            $aRetorno = $this->Persistencia->insereEnderecos($oRow);
            if ($aRetorno[0]) {
                $this->Persistencia->sitCadastrado($oRow);
                $this->Persistencia->insereUsuCad($oRow);
                $oMensagem = new Modal('Sucesso!', 'Cadastro realizado com sucesso!', Modal::TIPO_SUCESSO, false, true);
                echo $oMensagem->getRender();
                echo"$('#" . $aDados[1] . "-pesq').click();";
            } else {
                $oMensagem = new Modal('Erro ao inserir cadastro', 'Relate o problema para o setor de Tecnologia da Informação!', Modal::TIPO_ERRO, false, true);
                echo $oMensagem->getRender();
            }
        } else {
            $oMensagem = new Modal('Erro ao inserir cadastro', 'Relate o problema para o setor de Tecnologia da Informação!', Modal::TIPO_ERRO, false, true);
            echo $oMensagem->getRender();
        }
    }

    
    public function msgRet($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oMensagem = new Modal('Retornar para o representante', 'Deseja retornar o cadastro para o representante?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","RetRep","' . $sDados . '");');
        echo $oMensagem->getRender();
    }

    /**
     * retorna para o representante
     */
    public function RetRep($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->retRep($aCamposChave);

        if ($aRetorno[0] == true) {
            $oMensagem = new Modal('Retornado com sucesso', '', Modal::TIPO_SUCESSO, false, true, true);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('Não foi possível retornar o cadastro', '', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

}
