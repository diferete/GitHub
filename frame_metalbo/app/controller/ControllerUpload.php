<?php

/**
 * Classe responsável pelo Upload de arquivos
 *
 * @author Carlos
 * 
 */
class ControllerUpload extends Controller {

    /**
     *  Método responsável pelo gerenciamento do upload de arquivos
     */
    public function Upload() {
        if (isset($_FILES)) {
            foreach ($_FILES as $oAtual) {
                if (isset($oAtual)) {
                    $oArquivo['CAMPO'] = $_REQUEST['nome'];

                    //Captura raiz do servidor, concatenando pasta do projeto e url de upload
                    // $oArquivo['DIRETORIO'] = $_SERVER['DOCUMENT_ROOT'].Config::PROJ_FOLDER . '/Uploads/';
                    $oArquivo['DIRETORIO'] = 'Uploads/';

                    //Caputura nome do arquivo a ser feito upload
                    $oArquivo['NOME'] = $oAtual['name'];

                    //Captura nome do arquivo temporario a ser movido para pasta escolhida
                    $oArquivo['TEMP'] = $oAtual['tmp_name'];

                    //Captura extensão do arquivo
                    $oArquivo['EXTENSAO'] = pathinfo($oArquivo['NOME'], PATHINFO_EXTENSION);

                    //Cria novo nome, junto com a extensão
                    $oArquivo['NOME_NOVO'] = md5(date("d_m_y_h_i_s")) . '.' . $oArquivo['EXTENSAO'];

                    //Concatena pasta diretorio, juntamente com novo nome do arquivo   
                    $oArquivo['DIR_NOME'] = $oArquivo['DIRETORIO'] . $oArquivo['NOME_NOVO'];

                    $fp = fopen("bloco1.txt", "w");
                    $escreve = fwrite($fp, $oArquivo['NOME_NOVO']);
                    fclose($fp);


                    //Move arquivo temporario para pasta escolhida juntamente com seu novo nome.
                    move_uploaded_file($oArquivo['TEMP'], $oArquivo['DIR_NOME']);

                    $sRetorno = json_encode(['uploaded' => 'true', 'nome' => $oArquivo['NOME_NOVO'], 'campo' => $oArquivo['CAMPO']]);

                    echo $sRetorno;
                    
                } else {
                    echo '0';
                }
            }
        } else {
            echo '0';
        }
    }

}