<?php

/**
 * Classe responsável pelo Upload de arquivos
 *
 * @author Carlos
 * 
 */
class ControllerUploadCurr extends Controller {

    /**
     *  Método responsável pelo gerenciamento do upload de arquivos
     */
    
    public function UploadCurr() {
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

                    $str_json = file_get_contents('php://input');
                    $aDados = json_decode($str_json, true);
                    
                } else {
                    echo '0';
                }
            }
        } else {
            echo '0';
        }
    }

    /*
      public function UploadCurr() {

      $str_json = file_get_contents('php://input');
      $aDados = json_decode($str_json, true);

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

      }


      $oEmail = new Email();
      $oEmail->setMailer();

      $oEmail->setEnvioSMTP();
      $oEmail->setServidor('smtp.terra.com.br');
      $oEmail->setPorta(587);
      $oEmail->setAutentica(true);
      $oEmail->setUsuario('metalboweb@metalbo.com.br');
      $oEmail->setSenha('filialwe');
      $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

      $oEmail->setAssunto(utf8_decode('Entrada de projeto nº'));
      $oEmail->setMensagem(utf8_decode('ENTRADA DE PROJETO Nº FOI <span style="color:#FF0000"><b>REPROVADO</b></span> PELO SETOR DE PROJETOS.<hr><br/>'
      . '<table border=1 cellspacing=0 cellpadding=2 width="100%">'
      . '<tr><td><b>Descrição:</b></td><td></td></tr>'
      . '<tr><td><b>Quantidade:</b></td><td></td></tr>'
      . '<tr><td><b>Empresa:</b></td><td></td></tr>'
      . '<tr><td><b>Observação final:</b></td><td></td></tr> </table>'
      . '<a href="sistema.metalbo.com.br">Clique aqui para acessar a entrada de projeto!</a>'
      . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));



      $oEmail->limpaDestinatariosAll();
      $oEmail->addAnexo($oArquivo['DIR_NOME']);
      $oEmail->addDestinatario('alexandre@metalbo.com.br');
      $oEmail->sendEmail();
      }
      }
      } */
}
