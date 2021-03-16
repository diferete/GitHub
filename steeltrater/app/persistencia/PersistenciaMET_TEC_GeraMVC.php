<?php

/*
 * Implementa a classe persistencia do gerador de classes
 * @author Cleverton Hoffmann
 * @since 07/05/2020
 */

class PersistenciaMET_TEC_GeraMVC extends Persistencia {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Método que verifica a existencia da classe
     * @param type $sNomeMVC
     * @param type $aCamposChave
     * @return boolean
     */
    public function verificaSeClasseExiste($sNomeMVC, $aCamposChave) {
        $sDir = 'C:\\wamp64\\www\\github\\' . $aCamposChave['frame'] . '\\app\\controller\\Controller' . $sNomeMVC . '.php';
        if (file_exists($sDir)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método que verifica a existencia da tabela
     * @param type $sNomeTabela
     * @return boolean
     */
    public function verificaTabelaExiste($sNomeTabela) {
        $sSql = "SELECT count (name) as qnt "
                . "FROM SYSOBJECTS WHERE XTYPE = 'U' "
                . "AND NAME = '" . $sNomeTabela . "'";
        $result = $this->getObjetoSql($sSql);
        $iQnt = $result->fetch(PDO::FETCH_OBJ);
        if ($iQnt->qnt == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método que busca o nome das colunas da tabela e retorna um array
     * @param type $sNomeTabela
     * @return array
     */
    public function buscaCampos($sNomeTabela) {

        $sSql = "SELECT COLUMN_NAME, DATA_TYPE "
                . "FROM INFORMATION_SCHEMA.COLUMNS "
                . "WHERE TABLE_NAME ='" . $sNomeTabela . "'";

        $result = $this->getObjetoSql($sSql);
        $aCampos = array();
        while ($aRow = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($aCampos, [$aRow['column_name'], $aRow['data_type']]);
        }
        return $aCampos;
    }

    /**
     * Cria o arquivo e salva a estrutura texto da controller
     * OBS: Caso algum conflito ou erro de criação seja gerado verificar caminho da pasta que salva o arquivo no computador
     * @param type $sTexto
     * @param type $aCamposChave
     * @return boolean
     */
    public function CriaArquivoController($sTexto, $aCamposChave) {

        try {
            $fp = fopen("c:\\wamp64\\www\\GitHub\\" . $aCamposChave['frame'] . "\\app\\controller\\Controller" . $aCamposChave['nomemvc'] . ".php", "a+");

            //Escreve no arquivo
            fwrite($fp, $sTexto);

            //Fecha o arquivo.
            fclose($fp);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Cria o arquivo e salva a estrutura texto da model
     * OBS: Caso algum conflito ou erro de criação seja gerado verificar caminho da pasta que salva o arquivo no computador
     * @param type $sTexto
     * @param type $aCamposChave
     * @return boolean
     */
    public function CriaArquivoModel($sTexto, $aCamposChave) {

        try {
            $fp = fopen("c:\\wamp64\\www\\GitHub\\" . $aCamposChave['frame'] . "\\app\\model\\Model" . $aCamposChave['nomemvc'] . ".php", "a+");

            //Escreve no arquivo
            fwrite($fp, $sTexto);

            //Fecha o arquivo.
            fclose($fp);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Cria o arquivo e salva a estrutura texto da Persistencia
     * OBS: Caso algum conflito ou erro de criação seja gerado verificar caminho da pasta que salva o arquivo no computador
     * @param type $sTexto
     * @param type $aCamposChave
     * @return boolean
     */
    public function CriaArquivoPersistencia($sTexto, $aCamposChave) {

        try {
            $fp = fopen("c:\\wamp64\\www\\GitHub\\" . $aCamposChave['frame'] . "\\app\\persistencia\\Persistencia" . $aCamposChave['nomemvc'] . ".php", "a+");

            //Escreve no arquivo
            fwrite($fp, $sTexto);

            //Fecha o arquivo.
            fclose($fp);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Cria o arquivo e salva a estrutura texto da view
     * OBS: Caso algum conflito ou erro de criação seja gerado verificar caminho da pasta que salva o arquivo no computador
     * @param type $sTexto
     * @param type $aCamposChave
     * @return boolean
     */
    public function CriaArquivoView($sTexto, $aCamposChave) {

        try {
            $fp = fopen("c:\\wamp64\\www\\GitHub\\" . $aCamposChave['frame'] . "\\app\\view\\View" . $aCamposChave['nomemvc'] . ".php", "a+");

            //Escreve no arquivo
            fwrite($fp, $sTexto);

            //Fecha o arquivo.
            fclose($fp);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
