<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerUploadMulti extends Controller {

    /**
     *  Método responsável pelo gerenciamento do upload de arquivos
     */
    public function Upload() {
        if (isset($_FILES)) {
            $aParametros = explode(',', $_REQUEST['parametros']);

            $oArquivo['CAMPO'] = $_REQUEST['nome'];


            if ($aParametros[0]) {
                $sRetorno = $this->verificaDiretorio($aParametros);
                if ($sRetorno == 'criado' || $sRetorno == 'existe') {
                    $oArquivo['DIRETORIO'] = 'Uploads/' . $aParametros[0] . '/';
                }
            } else {
                //Captura raiz do servidor, concatenando pasta do projeto e url de upload
                // $oArquivo['DIRETORIO'] = $_SERVER['DOCUMENT_ROOT'].Config::PROJ_FOLDER . '/Uploads/';
                $oArquivo['DIRETORIO'] = 'Uploads/';
            }

            //Caputura nome do arquivo a ser feito upload
            $oArquivo['NOME'] = $_FILES['file']['name'];

            //Captura nome do arquivo temporario a ser movido para pasta escolhida
            $oArquivo['TEMP'] = $_FILES['file']['tmp_name'];

            //Captura extensão do arquivo
            $oArquivo['EXTENSAO'] = pathinfo($oArquivo['NOME'], PATHINFO_EXTENSION);

            if ($aParametros[0]) {
                //Cria novo nome, junto com a extensão
                $oArquivo['NOME_NOVO'] = date("d-m-Y_h-i ") . Util::removeAcentos($oArquivo['NOME']);
            } else {
                //Cria novo nome, junto com a extensão
                $oArquivo['NOME_NOVO'] = md5(date("d_m_y_h_i_s")) . '.' . $oArquivo['EXTENSAO'];
            }
            //Concatena pasta diretorio, juntamente com novo nome do arquivo   
            $oArquivo['DIR_NOME'] = $oArquivo['DIRETORIO'] . $oArquivo['NOME_NOVO'];


            //Move arquivo temporario para pasta escolhida juntamente com seu novo nome.
            $debug = move_uploaded_file($oArquivo['TEMP'], $oArquivo['DIR_NOME']);

            $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

            $sSql = ("SELECT count (name) as qnt "
                    . "FROM SYSOBJECTS WHERE XTYPE = 'U' "
                    . "AND NAME = '" . $aParametros[1] . "'");
            $result = $PDO->query($sSql);
            $aQnt = $result->fetch(PDO::FETCH_ASSOC);

            if ($aQnt['qnt'] == 1) {
                $sSqlSelect = "SELECT max(seq) as seq from " . $aParametros[1] . " where nr  = " . $aParametros[2] . " and filcgc = " . $aParametros[3] . "";
                $sth = $PDO->query($sSqlSelect);
                $aRow = $sth->fetch(PDO::FETCH_ASSOC);

                date_default_timezone_set('America/Sao_Paulo');

                $data = [
                    'filcgc' => intval($aParametros[3]),
                    'nr' => $aParametros[2],
                    'seq' => $aRow['seq'] + 1,
                    'arquivo' => $_FILES['file']['name'],
                ];

                $sql = "insert into " . $aParametros[1] . " (filcgc,nr,seq,arquivo)values(:filcgc,:nr,:seq,:arquivo)";
                $stmt = $PDO->prepare($sql);
                $debug = $stmt->execute($data);
            } else {
                $create = $PDO->prepare("create table " . $aParametros[1] . " (filcgc BIGINT, nr INT ,seq INT ,arquivo VARCHAR (200) PRIMARY KEY (filcgc,nr,seq))");
                $debug = $create->execute();

                date_default_timezone_set('America/Sao_Paulo');

                $data = [
                    'filcgc' => intval($aParametros[3]),
                    'nr' => $aParametros[2],
                    'seq' => '1',
                    'arquivo' => $_FILES['file']['name'],
                ];

                $sql = "insert into " . $aParametros[1] . " (filcgc,nr,seq,arquivo)values(:filcgc,:nr,:seq,:arquivo)";
                $stmt = $PDO->prepare($sql);
                $debug = $stmt->execute($data);
            }

            $sRetorno = json_encode(['uploaded' => 'true', 'nome' => $oArquivo['NOME_NOVO'], 'campo' => $oArquivo['CAMPO']]);
        } else {
            echo '0';
        }
    }

    function verificaDiretorio($aParametros) {
        if (!is_dir('Uploads/' . $aParametros[0])) {
            mkdir('Uploads/' . $aParametros[0], 0755);
            return 'criado';
        } else {
            return 'existe';
        }
    }

}
