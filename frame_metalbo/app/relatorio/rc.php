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

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

//variares request
$nrHeader = $_REQUEST['nr'];
$FilcgcRex = $_REQUEST['filcgc'];



$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA


$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = "select tbrncqual.empcod,tbrncqual.empdes,
                convert(varchar,datains,103) as datains,
                empfone,celular,empend,empendbair,
                cidnome,convert(varchar,datains,103)as datains,email,
                case when ind = 'true' then 'x' else '' end as ind,
                case when comer = 'true' then 'x' else '' end as comer,widl.emp01.cidcep,
                nf,convert(varchar,datanf,103)as datanf,odcompra,pedido,valor,peso,lote,op,naoconf,procod,prodes,aplicacao,
                quant,quantnconf,usuaponta,apontamento,
                case when aceitocond = 'true' then 'x' else '' end as aceitocond,
                case when reprovar = 'true' then 'x' else '' end as reprovar,usunome
                from tbrncqual left outer join widl.EMP01
                on widl.emp01.empcod = tbrncqual.empcod left outer join widl.CID01 
                on widl.CID01.cidcep = widl.EMP01.cidcep where nr =" . $nrHeader;
$dadoscab = $PDO->query($sSql);
$row = $dadoscab->fetch(PDO::FETCH_ASSOC);
//cabeçalho
$pdf->SetMargins(3, 0, 3);
$pdf->Rect(2, 10, 38, 18);

$pdf->Rect(2, 32, 206, 25);
// Logo
$pdf->Image('../../biblioteca/assets/images/logopn.png', 4, 13, 26);
// Arial bold 15
$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(30);
// Title
$pdf->Cell(120, 18, '        Relatório de não conformidade nº   ' . $nrHeader, 1, 0, 'L');

$pdf->Rect(160, 10, 48, 18);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(45, 5, 'Emissão:' . $row['datains'] . '       Usuário:' . $row['usunome'] . '                        ', 0, 'J');

$pdf->Ln(10);
//cliente
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Cliente:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(28, 5, $row['empcod'], 0, 0, 'L');
$pdf->Cell(114, 5, $row['empdes'], 0, 0, 'L');
$pdf->Cell(19, 5, '(' . $row['ind'] . ') Indústria', 0, 0, 'L');
$pdf->Cell(19, 5, '(' . $row['comer'] . ') Comécio', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Fone:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(38, 5, $row['empfone'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Celular:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(48, 5, $row['celular'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Endereço:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(98, 5, $row['empend'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Bairro:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(78, 5, $row['empendbair'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Cidade:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(38, 5, $row['cidnome'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Cep:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(38, 5, $row['cidcep'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "E-mail:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(28, 5, $row['email'], 0, 1, 'L');

$pdf->Rect(2, 60, 206, 20);

$pdf->Ln(7);

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Nota Fiscal:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['nf'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(32, 5, "Data:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['datanf'], 0, 1, '1');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Ordem Compra:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['odcompra'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(32, 5, "Pedido de venda:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['pedido'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Valor:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, number_format($row['valor'], 2, ',', '.'), 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(32, 5, "Peso:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, number_format($row['peso'], 2, ',', '.'), 0, 1, 'L');

$pdf->Rect(2, 84, 206, 8);
$pdf->Ln(8);

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Lote:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['lote'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(40, 5, "Ordem de produção:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['op'], 0, 0, 'L');

$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Descrição da não conformidade:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->MultiCell(205, 5, $row['naoconf'], 1, 'L');

$pdf->Ln(5);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Dados produto:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);

$iAltura = $pdf->GetY();
$pdf->Rect(2, $iAltura, 206, 28);

$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Produto:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['prodes'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Código:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['procod'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Aplicação:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['aplicacao'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Quantidade:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, number_format($row['quant'], 2, ',', '.'), 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Quant. não conf:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, number_format($row['quantnconf'], 2, ',', '.'), 0, 1, 'L');


$pdf->Ln(5);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Análise da RC:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);

$iAltura = $pdf->GetY();
$pdf->Rect(2, $iAltura, 206, 35);

$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(45, 5, "Responsável pela análise:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['usuaponta'], 0, 1, 'L');

$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Análise da não conformidade:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->MultiCell(205, 5, $row['apontamento'], 0, 'L');

$pdf->Ln(30);
         
$iAltF = $pdf->GetY();


$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Disposição:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(50, 5, '(' . $row['aceitocond'] . ') Aceito condicionalmente', 0, 0, 'L');
$pdf->Cell(50, 5, '(' . $row['reprovar'] . ') Reprovar', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Responsável:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(50, 5, $row['usunome'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(10, 5, "Data:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(40, 5, $row['datains'], 0, 1, 'L');

$pdf->Cell(0, 5, "", "B", 1, 'C');



if ($_REQUEST['output'] == 'email') {
    $pdf->Output('F', 'rnc/Rnc' . $_REQUEST['nr'] . '_empresa_' . $FilcgcRex . '.pdf'); // GERA O PDF NA TELA
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
} else {
    $pdf->Output('I', 'solvenda' . $_REQUEST['nr'] . '.pdf');
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
}
