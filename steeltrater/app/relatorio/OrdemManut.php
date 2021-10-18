<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação
    }

}

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(5, 5); // DEFINE O X E O Y NA PAGINA
//Caminho da logo
$sLogo = '../../biblioteca/assets/images/steelrel.png';
$pdf->SetMargins(5, 5, 5);

//Caminho do usuário, data e hora
date_default_timezone_set('America/Sao_Paulo');
$data = date("d/m/y");                     //função para pegar a data local
$hora = date("H:i");                       //para pegar a hora com a função date
$useRel = $_REQUEST['userRel'];

//Inserção do cabeçalho
$pdf->Cell(37, 10, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45), 0, 0, 'J');

$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(110, 10, "Ordem de manutenção nº " . $_REQUEST['nr'], '', 0, 'C', 0);

$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(52, 7, 'Data: ' . $data
        . '        Hora: ' . $hora
        . ' Usuário: ' . $useRel
        . ' ', '', 'L', 0); //'B,R,T'
$pdf->Cell(0, 5, '', 'T', 1, 'L');

/*
 * Conexão com banco de dados 
 */
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

//grupo=1&grupo1=2&subgrupo=1&subgrupo1=2&familia=1&familia1=2&subfamilia=1&subfamilia1=2&codigo=10110101
$sNr = $_REQUEST['nr'];
$sql = "select convert(varchar,datacad,103)as datacad,
	 convert(varchar,horacad,8)as horacad, 
	 MET_TEC_usuario.usunome AS usuariocadastro, 
	 MET_MANUT_OS.cod, 
	 MET_CAD_Maquinas.maquina, 
	 tipomanut, dias, 
	 MET_MANUT_OS.codsetor,
	 MET_MANUT_OS.obs, 
         problema, 
	 solucao, 
	 situacao, 
	 responsavel, 
	 consumo, 
         codserv,
         oqfazer,
         MET_TEC_usuario3.usunome AS usuarioinic, 
	 convert(varchar,datainic,103)as datainic, 
	 convert(varchar,horainic,8)as horainic, 
	 MET_TEC_usuario2.usunome AS usuariofinal, 
	 convert(varchar,dataenc,103)as dataenc, 
	 convert(varchar,horaenc,8)as horaenc, 
	 convert(varchar,previsao,103)as previsao, 
	 matnecessario
        from MET_MANUT_OS left outer join MET_CAD_Maquinas
        on MET_CAD_Maquinas.fil_codigo = MET_MANUT_OS.fil_codigo and
	MET_CAD_Maquinas.codigoMaq = MET_MANUT_OS.cod 
	left outer join MET_TEC_USUARIO
	ON MET_MANUT_OS.usuariocad = MET_TEC_usuario.usucodigo
	LEFT OUTER JOIN MET_TEC_usuario AS MET_TEC_usuario2
	ON MET_MANUT_OS.userenc = MET_TEC_usuario2.usucodigo
        LEFT OUTER JOIN MET_TEC_usuario AS MET_TEC_usuario3
	ON MET_MANUT_OS.userinic = MET_TEC_usuario3.usucodigo
	where nr = " . $sNr . "";
$sth = $PDO->query($sql);

while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

// ENQUANTO OS DADOS VÃO PASSANDO, O FPDF VAI INSERINDO OS DADOS NA PAGINA
    $codigo = $row["cod"];
    $data = $row["datacad"];
    $maquina = $row['maquina'];
    $hora = $row['horacad'];
    $usuario = $row['usuariocadastro'];
    $situaca = $row['situacao'];
    $problema = $row['problema'];
    $responsavel = $row['responsavel'];
    $previsao = $row['previsao'];
    $solucao = $row['solucao'];
    $consumo = $row['consumo'];
    $datainic = $row['datainic'];
    $horainic = $row['horainic'];
    $userinic = $row['usuarioinic'];
    $dataenc = $row['dataenc'];
    $horaenc = $row['horaenc'];
    $userenc = $row['usuariofinal'];
    $material = $row['matnecessario'];
    $codserv = $row['codserv'];
    $oqfazer = $row['oqfazer'];

//código máquina   
    $pdf->SetFont('arial', 'B', 12);
    $pdf->Cell(40, 6, "Cód. Máquina:", 0, 0, 'L');
    $pdf->setFont('arial', '', 12);
    $pdf->Cell(70, 6, $codigo, 0, 1, 'L');

//código máquina   
    $pdf->SetFont('arial', 'B', 12);
    $pdf->Cell(40, 6, "Máquina:", 0, 0, 'L');
    $pdf->setFont('arial', '', 12);
    $pdf->Cell(70, 6, $maquina, 0, 1, 'L');

    $pdf->Cell(199, 1, "", "B", 1, 'C');

    $pdf->SetFont('arial', 'B', 12);
    $pdf->Cell(40, 6, "Cadastro:", 0, 0, 'L');
    $pdf->setFont('arial', '', 12);
    $pdf->Cell(70, 6, $data, 0, 0, 'L');

    $pdf->SetFont('arial', 'B', 12);
    $pdf->Cell(25, 6, "Hora:", 0, 0, 'L');
    $pdf->setFont('arial', '', 12);
    $pdf->Cell(60, 6, $hora, 0, 1, 'L');

    $pdf->SetFont('arial', 'B', 12);
    $pdf->Cell(40, 6, "Usuário:", 0, 0, 'L');
    $pdf->setFont('arial', '', 12);
    $pdf->Cell(70, 6, $usuario, 0, 1, 'L');

    $pdf->Cell(199, 1, "", "T", 1, 'C');

    $pdf->SetFont('arial', 'B', 12);
    $pdf->Cell(40, 6, "Situação:", 0, 0, 'L');
    $pdf->setFont('arial', '', 12);
    $pdf->Cell(70, 6, $situaca, 0, 1, 'L');


    $pdf->SetFont('arial', 'B', 12);
    $pdf->Cell(40, 6, "Responsável:", 0, 0, 'L');
    $pdf->setFont('arial', '', 12);
    $pdf->Cell(70, 6, $responsavel, 0, 0, 'L');

    $pdf->SetFont('arial', 'B', 12);
    $pdf->Cell(25, 6, "Previsão:", 0, 0, 'L');
    $pdf->setFont('arial', '', 12);
    $pdf->Cell(50, 6, $previsao, 0, 1, 'L');
    $pdf->Ln(10);


    if ($codserv == null || $codserv == 0) {
        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(50, 8, "Problema apresentado", 0, 1, 'L');
        $pdf->Cell(199, 1, "", "B", 1, 'C');
        $pdf->Ln(2);
        $pdf->setFont('arial', '', 9);
        $pdf->MultiCell(199, 7, $problema, 0, 'J');
        $pdf->Ln(5);
    } else {

        $sql4 = "select codserv, servico, tipcod, ciclo, resp, sit, codsetor from MET_MANUT_OSServico where codserv = " . $codserv . "";
        $sth4 = $PDO->query($sql4);

        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(25, 6, "Serviços da manutenção preventiva", 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(199, 1, "", "B", 1, 'C');
        $pdf->SetFont('arial', 'B', 9);
        $pdf->Cell(15, 6, 'CÓDIGO', 0, 0, 'L');
        $pdf->Cell(40, 6, 'O QUE FAZER', 0, 0, 'L');
        $pdf->Cell(50, 6, 'SERVIÇO', 0, 0, 'L');
        $pdf->Cell(30, 6, 'CICLO', 0, 0, 'L');
        $pdf->Cell(35, 6, 'RESPONSÁVEL', 0, 0, 'L');
        $pdf->Cell(30, 6, 'SITUAÇÃO', 0, 1, 'L');
        $pdf->Cell(199, 1, "", "B", 1, 'C');

        if ($sth4 != false) {
            while ($row4 = $sth4->fetch(PDO::FETCH_ASSOC)) {

                $pdf->SetFont('arial', '', 9);
                $pdf->Cell(15, 6, $row4['codserv'], 0, 0, 'L');
                $pdf->Cell(40, 6, $oqfazer, 0, 0, 'L');
                $pdf->Cell(50, 6, $row4['servico'], 0, 0, 'L');
                $pdf->Cell(30, 6, $row4['ciclo'], 0, 0, 'L');
                $pdf->Cell(35, 6, $row4['resp'], 0, 0, 'L');
                $pdf->Cell(30, 6, $row4['sit'], 0, 1, 'L');
            }
        }
    }
        $pdf->Ln(5);

        $sql1 = "select convert(varchar,datamat,103)as datamat, codmat, descricaomat, quantidade, usermatdes, obsmat from MET_MANUT_OSMaterial where nr = " . $sNr . "";
        $sth1 = $PDO->query($sql1);

        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(25, 6, "Material necessário para compras", 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->Cell(199, 1, "", "B", 1, 'C');
        $pdf->SetFont('arial', 'B', 9);
        $pdf->Cell(20, 6, 'CÓDIGO', 0, 0, 'L');
        $pdf->Cell(100, 6, 'MATERIAL', 0, 0, 'L');
        $pdf->Cell(25, 6, 'QUANTIDADE', 0, 0, 'L');
        $pdf->Cell(35, 6, 'SOLICITANTE', 0, 0, 'L');
        $pdf->Cell(20, 6, 'DATA', 0, 1, 'L');
        $pdf->Cell(199, 1, "", "B", 1, 'C');

        if ($sth1 != false) {
            while ($row1 = $sth1->fetch(PDO::FETCH_ASSOC)) {

                $pdf->setFont('arial', '', 8);
                $pdf->Cell(20, 6, $row1['codmat'], 0, 0, 'L');
                $pdf->Cell(100, 6, $row1['descricaomat'], 0, 0, 'L');
                $pdf->Cell(25, 6, $row1['quantidade'], 0, 0, 'L');
                $pdf->Cell(35, 6, substr($row1['usermatdes'], 0, 18), 0, 0, 'L');
                $pdf->Cell(20, 6, $row1['datamat'], 0, 1, 'L');
                $pdf->Cell(199, 6, 'Observação:    ' . $row1['obsmat'], 0, 1, 'L');
                $pdf->Cell(199, 1, "", "B", 1, 'C');
            }
        }
        if ($material != '') {
            $pdf->Ln(2);
            $pdf->setFont('arial', '', 9);
            $pdf->Cell(199, 6, 'MATERIAL: ' . $material, 0, 0, 'L');
            $pdf->Ln(2);
        }

        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(50, 8, "Inicializou:", 0, 0, 'L');
        $pdf->setFont('arial', '', 12);
        $pdf->Cell(60, 8, $datainic, 0, 0, 'L');

        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(25, 8, "Hora:", 0, 0, 'L');
        $pdf->setFont('arial', '', 12);
        $pdf->Cell(60, 8, $horainic, 0, 1, 'L');

        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(50, 8, "Usuário:", 0, 0, 'L');
        $pdf->setFont('arial', '', 12);
        $pdf->Cell(60, 8, $userinic, 0, 1, 'L');

        $pdf->Cell(0, 2, "", "T", 1, 'C');

        $pdf->Ln(3);
        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(60, 8, "Solução", 0, 1, 'L');
        $pdf->Cell(199, 1, "", "B", 1, 'C');
        $pdf->Ln(2);
        $pdf->setFont('arial', '', 9);
//$pdf->SetXY(61,92);
        $pdf->MultiCell(199, 7, $solucao, 0, 'J');
        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(60, 8, "Consumo", 0, 1, 'L');
        $pdf->Cell(199, 1, "", "B", 1, 'C');
        $pdf->Ln(2);
        $pdf->setFont('arial', '', 9);
        $pdf->MultiCell(199, 7, $consumo, 0, 'J');

        $pdf->Cell(60, 7, "", 0, 1, 'L');
        $pdf->Cell(199, 1, "", "B", 1, 'C');

        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(50, 8, "Encerramento:", 0, 0, 'L');
        $pdf->setFont('arial', '', 12);
        $pdf->Cell(60, 8, $dataenc, 0, 0, 'L');

        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(25, 8, "Hora:", 0, 0, 'L');
        $pdf->setFont('arial', '', 12);
        $pdf->Cell(60, 8, $horaenc, 0, 1, 'L');

        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(50, 8, "Usuário:", 0, 0, 'L');
        $pdf->setFont('arial', '', 12);
        $pdf->Cell(60, 8, $userenc, 0, 1, 'L');

        $pdf->Cell(0, 2, "", "T", 1, 'C');
        $pdf->Cell(60, 8, "Assinatura", 0, 1, 'L');
        $pdf->Cell(0, 5, "", "B", 1, 'C');
    }



    $pdf->Output('', 'OrdemdeManutencao.pdf'); // GERA O PDF NA TELA
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
    