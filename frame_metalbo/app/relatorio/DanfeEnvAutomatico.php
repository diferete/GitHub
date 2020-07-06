<?php

require 'biblioteca/NFE/vendor/autoload.php';

include("../../includes/Config.php");
include("../../includes/Fabrica.php");
include("../../biblioteca/Utilidades/Email.php");

use NFePHP\DA\NFe\Danfe;

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

$date = date_create(date("Y-m-d"));
date_sub($date, date_interval_create_from_date_string("15 days"));
$date = date_format($date, "d/m/Y");

$sSqlNF = "select nfsfilcgc,nfsnfnro,nfsnfser from widl.NFC001 where nfsdtemiss between '" . $date . "' and '" . date('d/m/Y') . "' and nfsnfesit = 'A' and nfsemailen <> 'S' and nfsfilcgc = '75483040000211'"; // and nfsnatcod1 <> 5151";
//$sSqlNF = "select nfsfilcgc,nfsnfnro,nfsnfser from widl.NFC001 where nfsdtemiss between '19/03/2020' and '19/03/2020' and nfsnfesit = 'A' and nfsemailen <> 'S' and nfsfilcgc = '75483040000211' and nfsnatcod1 <> 5151";
$sth = $PDO->query($sSqlNF);
while ($aRow = $sth->fetch(PDO::FETCH_ASSOC)) {

    $aDados[0] = $aRow['nfsfilcgc'];
    $aDados[1] = $aRow['nfsnfnro'];
    $aDados[2] = $aRow['nfsnfser'];

    $sSql = "select nfsnfechv, nfsnfesit, nfsdtemiss, nfsclicgc, nfsdtsaida, nfshrsaida, nfstrauf, nfscliuf, nfsclicod, nfsclinome "
            . "from widl.NFC001 "
            . "where nfsfilcgc = '" . $aDados[0] . "' "
            . "and nfsnfnro = '" . $aDados[1] . "' "
            . "and nfsnfser = '" . $aDados[2] . "' ";

    $dadosSql = $PDO->query($sSql);
    $aDadosNF = $dadosSql->fetch(PDO::FETCH_ASSOC);
    $DirXml = buscaDirXML($aDadosNF, $aDados);
    if (!$DirXml) {
        updateProc($aDadosNF, $aDados, $PDO);
    } else {
        $xml = file_get_contents($DirXml);

        $logo = 'data://text/plain;base64,' . base64_encode(file_get_contents('biblioteca/assets/images/logo.jpg'));

        $aDadosExtras = montaDadosExtras($aDadosNF, $aDados, $PDO);

        $danfe = new Danfe($xml);
        $danfe->debugMode(false);
        $danfe->monta($aDadosExtras, $logo);
        $pdf = $danfe->render();

        header('Content-Type: application/pdf');

        //Monta ou cria diretório onde vai salvar DANFE.pdf
        $sDirDanfe = montaDirDANFE($aDadosNF, $aDados[0]);

        //Concatena string com diretório e nome do arquivo para salvar DANFE.pdf
        $sDirSalvaDanfe = __dir__ . '/DANFES/' . $sDirDanfe . '/DANFE - ' . $aDados[1] . '.pdf';

        //Salva PDF no diretório criado
        output($sDirSalvaDanfe, $pdf);

        //Envia e-mail com XML e DANFE
        $aRetorno = enviaXMLDanfe($DirXml, $sDirSalvaDanfe, $aDados, $aDadosNF, $PDO);

        //altera situação da DANFE e XML para enviado
        //cria log com erro de envio
        //cria log caso enviado mas erro ao alterar situação de envio
        updates($aRetorno, $aDados, $aDadosNF, $PDO);
        sleep(2);
    }
}

///////////////////////////////////////////////// métodos adicionais////////////////////////////////////////////////////////
function buscaDirXML($aDadosNF, $aDados) {
    $sDir = '\\\sistema_metalbo\Delonei\Notas\\';
    if ($aDados[0] == '75483040000211') {
        $sDir = $sDir . '75483040000211-FILIAL';
    }
    if ($aDados[0] == '75483040000130') {
        $sDir = $sDir . '75483040000130-REX';
    }
    $sData = date('d/m/Y', strtotime($aDadosNF['nfsdtemiss']));
    $aPastasDir = explode('/', $sData);

    //Dir = Ano-mês/dia
    $sDir = $sDir . '\\' . $aPastasDir[2] . '-' . $aPastasDir[1] . '\\' . $aPastasDir[0] . '\\Proc';

    $sDir = $sDir . '\\' . trim($aDadosNF['nfsnfechv']) . '-nfeProc.xml';

    if (!file_exists($sDir)) {
        return false;
    } else {
        return $sDir;
    }
}

function montaDirDANFE($aDadosNF, $sDados) {
    $sDir = '';
    if ($sDados == '75483040000211') {
        $sDir = '75483040000211-FILIAL';
    }
    if ($sDados == '75483040000130') {
        $sDir = '75483040000130-REX';
    }
    return $sDir;
}

function output($name, $pdf) {
    if (file_exists($name)) {
        return;
    } else {
        $f = fopen($name, 'w');
        if (!$f) {
            $this->error('Unable to create output file: ' . $name);
            exit;
        }
        fwrite($f, $pdf);
        fclose($f);
    }
}

function enviaXMLDanfe($DirXml, $sDirSalvaDanfe, $aDados, $aDadosNF, $PDO) {
    $oEmail = new Email();
    $oEmail->setMailer();
    $oEmail->setEnvioSMTP();
    $oEmail->setServidor(Config::SERVER_SMTP);
    $oEmail->setPorta(Config::PORT_SMTP);
    $oEmail->setAutentica(true);
    $oEmail->setUsuario(Config::EMAIL_SENDER);
    $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
    $oEmail->setProtocoloSMTP(Config::PROTOCOLO_SMTP);
    $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('Envio de XML de DANFE'));

    $oEmail->setAssunto(utf8_decode('XML METALBO IND. FIXADORES METALICOS LTDA'));
    $oEmail->setMensagem(utf8_decode('<span>Seguem XML e DANFE referente a NF.: <b> ' . $aDados[1] . '</b></span>'
                    . '<br/><br/>'
                    . '<br/><span style="color:red;">E-mail enviado automaticamente, favor não responder!</span>'));
    $oEmail->limpaDestinatariosAll();

    if ($aDadosNF['nfscliuf'] == 'EX') {
        $sSqlContatos = "select empconemai from widl.EMP0103 where empcod = '" . $aDadosNF['nfsclicod'] . "' and empcontip = '14'";
    } else {
        $sSqlEMP = "select empcod from widl.emp01 where empcnpj = '" . $aDadosNF['nfsclicgc'] . "'";
        $query = $PDO->query($sSqlEMP);
        $aRow = $query->fetch(PDO::FETCH_ASSOC);

        if (($aDadosNF['nfsclicod'] == '75483040000130')) {
            $aRow['empcod'] = '75483040000130';
        }

        $sSqlContatos = "select empconemai from widl.EMP0103 where empcod = '" . $aRow['empcod'] . "' and empcontip = '14'";
    }
    $emailContatos = $PDO->query($sSqlContatos);


    while ($aRow = $emailContatos->fetch(PDO::FETCH_ASSOC)) {
        $oEmail->addDestinatario($aRow['empconemai']);
    }

    //$oEmail->limpaDestinatariosAll();
    //$oEmail->addDestinatario('alexandre@metalbo.com.br');
    //$oEmail->addDestinatario('avanei@metalbo.com.br');
    //$oEmail->addDestinatario('jose@metalbo.com.br');
    //$oEmail->addDestinatario('cleverton@metalbo.com.br');

    $aDadosXml = explode('\\', $DirXml);

    $oEmail->addAnexo($DirXml, utf8_decode($aDadosXml[9]));
    $oEmail->addAnexo($sDirSalvaDanfe, utf8_decode('METALBO DANFE - ' . $aDados[1] . '.pdf'));

    $aRetorno = $oEmail->sendEmail();
    $debug = unlink($sDirSalvaDanfe);
    return $aRetorno;
}

function updates($aRetorno, $aDados, $aDadosNF, $PDO) {
    if ($aDadosNF['nfscliuf'] == 'EX') {
        $emp = "and nfsclicod = " . $aDadosNF['nfsclicod'];
    } else {
        $emp = "and nfsclicgc = " . $aDadosNF['nfsclicgc'];
    }
    if ($aRetorno[0]) {
        $sSqlTagENV = "update Widl.NFC001 set NfsEmailEn = 'S' where nfsnfnro = " . $aDados[1] . " " . $emp;
        $logXml = $PDO->exec($sSqlTagENV);
        if ($logXml == false) {
            date_default_timezone_set('America/Sao_Paulo');
            $data = [
                'filcgc' => $aDados[0],
                'nf' => $aDados[1],
                'datalog' => date('d-m-Y'),
                'horalog' => date('H:i'),
                'logxml' => 'ERRO AO TENTAR ALTERAR SITUACAO DE ENVIO DE E-MAIL PARA ENVIADO',
                'tipolog' => 'SQL',
                'cliente' => $aDadosNF['nfsclinome'],
            ];
            $sql = "INSERT INTO MET_TEC_LogXml (filcgc, nf, datalog, horalog, logxml, tipolog, cliente) VALUES (:filcgc, :nf, :datalog, :horalog, :logxml, :tipolog, :cliente)";
            $stmt = $PDO->prepare($sql);
            $debug = $stmt->execute($data);
        }
    } else {
        date_default_timezone_set('America/Sao_Paulo');
        $data = [
            'filcgc' => $aDados[0],
            'nf' => $aDados[1],
            'datalog' => date('d-m-Y'),
            'horalog' => date('H:i'),
            'logxml' => 'ERRO ENVIO E-MAIL: ' . $aRetorno[1],
            'tipolog' => 'EMAIL',
            'cliente' => $aDadosNF['nfsclinome'],
        ];
        $sql = "INSERT INTO MET_TEC_LogXml (filcgc, nf, datalog, horalog, logxml, tipolog, cliente) VALUES (:filcgc, :nf, :datalog, :horalog, :logxml, :tipolog, :cliente)";
        $stmt = $PDO->prepare($sql);
        $debug = $stmt->execute($data);
    }
}

function updateProc($aDadosNF, $aDados, $PDO) {
    date_default_timezone_set('America/Sao_Paulo');
    $data = [
        'filcgc' => $aDados[0],
        'nf' => $aDados[1],
        'datalog' => date('d-m-Y'),
        'horalog' => date('H:i'),
        'logxml' => 'DANFE NAO ENVIADA POIS NAO TEVE XML PROCESSADO',
        'tipolog' => 'PROCESSAMENTO',
        'cliente' => $aDadosNF['nfsclinome'],
    ];
    $sql = "INSERT INTO MET_TEC_LogXml (filcgc, nf, datalog, horalog, logxml, tipolog, cliente) VALUES (:filcgc, :nf, :datalog, :horalog, :logxml, :tipolog, :cliente)";
    $stmt = $PDO->prepare($sql);
    $debug = $stmt->execute($data);
}

function montaDadosExtras($aDadosNF, $aDados, $PDO) {
    $aDadosExtras = array();

    $aDadosExtras['horaSaida'] = $aDadosNF['nfshrsaida'];
    $aDadosExtras['dataSaida'] = date('d/m/Y', strtotime($aDadosNF['nfsdtsaida']));
    $aDadosExtras['dataEmiss'] = date('d/m/Y', strtotime($aDadosNF['nfsdtemiss']));
    $aData = explode('/', $aDadosExtras['dataSaida']);
    if ($aData[2] == '1753') {
        $aDadosExtras['dataSaida'] = '';
    }
    if ($aDadosNF['nfstrauf'] == 'EX') {
        $sSqlExtras = 'select nfstrains, nfstranome, nfstraende, nfstrabair, nfstracep, nfstracid, nfspesobr, nfspesolq, nfsespecie, nfsmarca, nfsqtdvol '
                . "from widl.NFC001 "
                . "where nfsfilcgc = '" . $aDados[0] . "' "
                . "and nfsnfnro = '" . $aDados[1] . "' "
                . "and nfsnfser = '" . $aDados[2] . "' ";
        $dadosSqlExtras = $PDO->query($sSqlExtras);
        $aDadosSqlExtras = $dadosSqlExtras->fetch(PDO::FETCH_ASSOC);
        $aDadosExtras['nfstranome'] = $aDadosSqlExtras['nfstranome'];
        $aDadosExtras['nfstrains'] = $aDadosSqlExtras['nfstrains'];
        $aDadosExtras['nfstraende'] = $aDadosSqlExtras['nfstraende'];
        $aDadosExtras['nfstrabair'] = $aDadosSqlExtras['nfstrabair'];
        $aDadosExtras['nfstracep'] = $aDadosSqlExtras['nfstracep'];
        $aDadosExtras['nfstracid'] = $aDadosSqlExtras['nfstracid'];
        $aDadosExtras['nfspesobr'] = number_format($aDadosSqlExtras['nfspesobr'], '3', ',', '.');
        $aDadosExtras['nfspesolq'] = number_format($aDadosSqlExtras['nfspesolq'], '3', ',', '.');
        $aDadosExtras['nfsespecie'] = $aDadosSqlExtras['nfsespecie'];
        $aDadosExtras['nfsmarca'] = $aDadosSqlExtras['nfsmarca'];
        $aDadosExtras['nfsqtdvol'] = number_format($aDadosSqlExtras['nfsqtdvol'], '0');
        $aDadosExtras['nfstrauf'] = $aDadosNF['nfstrauf'];
    } else {
        $aDadosExtras['nfstranome'] = '';
        $aDadosExtras['nfstrains'] = '';
        $aDadosExtras['nfstraende'] = '';
        $aDadosExtras['nfstrabair'] = '';
        $aDadosExtras['nfstracep'] = '';
        $aDadosExtras['nfstracid'] = '';
        $aDadosExtras['nfspesobr'] = '';
        $aDadosExtras['nfspesolq'] = '';
        $aDadosExtras['nfsespecie'] = '';
        $aDadosExtras['nfsmarca'] = '';
        $aDadosExtras['nfsqtdvol'] = '';
        $aDadosExtras['nfstrauf'] = '';
    }
    return $aDadosExtras;
}
