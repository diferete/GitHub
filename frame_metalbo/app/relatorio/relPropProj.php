<?php

// Diretórios
require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

$sUserRel = $_REQUEST['userRel'];
$sNr = $_REQUEST['nr'];
date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');
$FilcgcRex = $_REQUEST['EmpRex_filcgc'];

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

class PDF_AutoPrint extends PDF_JavaScript {

    function AutoPrint($printer = '') {
        // Open the print dialog
        if ($printer) {
            $printer = str_replace('\\', '\\\\', $printer);
            $script = "var pp = getPrintParams();";
            $script .= "pp.interactive = pp.constants.interactionLevel.full;";
            $script .= "pp.printerName = '$printer'";
            $script .= "print(pp);";
        } else {
            $script = 'print(true);';
            $this->IncludeJS($script);
        }
    }

}

$pdf = new PDF_AutoPrint('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE


$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);


$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(50);
// Title
$pdf->Cell(120, 10, 'Relatorio de Novos Projetos', 0, 1, 'L');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 9);
//$pdf->Cell(40, 5, 'Empresa:', 0, 1, 'L');
$pdf->Cell(40, 5, 'Usuário: ' . $sUserRel, 0, 1, 'L');
$pdf->Cell(30, 5, 'Data: ' . $sData, 0, 0, 'L');
$pdf->Cell(30, 5, 'Hora: ' . $sHora, 0, 1, 'L');
$pdf->Cell(0, 0, "", "B", 1, 'C');  //linha em branco 




$pdf->SetY(45);
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

$sql = "select nr,sitvendas,sitcliente,sitgeralproj,sitproj,desc_novo_prod,repnome,resp_venda_nome,respvalproj,tbqualNovoProjeto.empcod,empdes,
convert(varchar,dtimp,103) as dtimp,quant_pc,lotemin,prazoentregautil,precofinal,acabamento,replibobs,
equip_corresp,equip_corresp_evid,mat_prima,mat_prima_evid,estudo_proc,estudo_proc_evid,prod_sim,prod_sim_evid,desen_ferram,desen_ferram_evid,sol_viavel,sol_viavel_obs,
vlrDesenProj,vlrFerramen,vlrMatPrima,vlrAcabSuper,vlrTratTer,vlrCustProd,precofinal,prazoentregautil,sol_viavel_fin,fin_obs,resp_venda_nome,
procod,desc_novo_prod,procodsimilar,prodsimilar,tiprosca,normadimen,normarosca,normapropmec,ppap,vendaprev,reqcli,
SUM(vlrDesenProj+vlrFerramen+vlrMatPrima+vlrAcabSuper+vlrTratTer+vlrCustProd) as custotot
from tbqualNovoProjeto left outer join  widl.EMP01
on tbqualNovoProjeto.empcod  = widl.EMP01.empcod
where filcgc ='" . $FilcgcRex . "' and nr = '" . $sNr . "' 
group by nr,sitvendas,sitcliente,sitgeralproj,sitproj,desc_novo_prod,repnome,resp_venda_nome,respvalproj,
tbqualNovoProjeto.empcod,empdes,dtimp,quant_pc,lotemin,prazoentregautil,precofinal,acabamento,replibobs,
equip_corresp,equip_corresp_evid,mat_prima,mat_prima_evid,estudo_proc,estudo_proc_evid,prod_sim,
prod_sim_evid,desen_ferram,desen_ferram_evid,sol_viavel,sol_viavel_obs,
vlrDesenProj,vlrFerramen,vlrMatPrima,vlrAcabSuper,vlrTratTer,vlrCustProd,
precofinal,prazoentregautil,sol_viavel_fin,fin_obs,resp_venda_nome,
procod,desc_novo_prod,procodsimilar,prodsimilar,tiprosca,normadimen,normarosca,normapropmec,ppap,vendaprev,reqcli";
$sth = $PDO->query($sql);
$row = $sth->fetch(PDO::FETCH_ASSOC);

$iContaAltura = $pdf->GetY();


if ($iContaAltura >= 270) {    // 275 tamanho máximo da página
    $pdf->AddPage();   // nova pagina
    $iContaAltura = 10;

    $pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
    //seta as margens
    $pdf->SetMargins(2, 10, 2);

    $pdf->SetFont('Arial', 'B', 16);

    //cabeçalho
    $pdf->SetMargins(3, 0, 3);
    // Move to the right
    $pdf->Cell(50);
    // Title
    $pdf->Cell(120, 10, 'Relatorio de Novos Projetos', 0, 1, 'L');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 9);
    //$pdf->Cell(40, 5, 'Empresa:', 0, 1, 'L');
    $pdf->Cell(40, 5, 'Usuário: ' . $sUserRel, 0, 1, 'L');
    $pdf->Cell(30, 5, 'Data: ' . $sData, 0, 0, 'L');
    $pdf->Cell(30, 5, 'Hora: ' . $sHora, 0, 1, 'L');
    $pdf->Cell(0, 0, "", "B", 1, 'C');

    $pdf->SetFont('Arial', '', 9);

    //define a altura inicial dos dados
    $pdf->SetFont('arial', '', 8);
    $pdf->SetY(45);
}

$sProj = 'Projetos';
$sCusto = 'Custos';
$sVendas = 'Vendas';
$Rs = 'R$ ';
$sCadastro = 'Cadastro';

$sSitProj = $row['sitproj'];

if ($row['sitproj'] == 'Reprovado') {
    $sSitProj = 'Repr. por Projetos';
}
if ($row['sitvendas'] == 'Reprovado') {
    $sSitProj = 'Repr. por Vendas';
}
if ($row['sitcliente'] == 'Reprovado') {
    $sSitProj = 'Repr. pelo Cliente';
}
if ($row['sitgeralproj'] == 'Aprovado') {
    $sSitProj = 'Aprovado Geral';
}
if ($row['sitgeralproj'] == 'Finalizado') {
    $sSitProj = 'Finalizado';
}

$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(12, 5, 'Geral', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(16, 5, 'Situação:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(31, 5, $sSitProj, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(5, 5, 'Nr:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['nr'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(10, 5, 'CNPJ:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(27, 5, $row['empcod'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(13, 5, 'Cliente:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['empdes'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(16, 5, 'Data Imp.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(18, 5, $row['dtimp'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(10, 5, 'Prazo:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(18, 5, $row['prazoentregautil'], 0, 1); //quebra de linha

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(17, 5, 'Descrição:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(180, 5, $row['desc_novo_prod'], 0, 'J'); //quebra de linha

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(21, 5, 'Acabamento:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['acabamento'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(12, 5, 'Quant.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(18, 5, number_format($row['quant_pc'], 0, ',', '.'), 0, 0); //formata casas decimais

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(16, 5, 'Lote Min.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(18, 5, number_format($row['lotemin'], 0, ',', '.'), 0, 0); //formata casas decimais

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(11, 5, 'Preço:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, number_format($row['precofinal'], 2, ',', '.'), 0, 0); //formata casas decimais

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, 'Representante:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(35, 5, $row['repnome'], 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(10, 5, 'OBS:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(180, 5, $row['replibobs'], 0, 1);

$pdf->Cell(0, 5, "", "B", 1, 'C');  //linha em branco 
//PROJETOS
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(12, 10, $sProj, 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 5, 'Equipamento correspondente?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['equip_corresp'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(17, 5, 'Evidência:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['equip_corresp_evid'], 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 5, 'Matéria prima correspondente?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['mat_prima'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(17, 5, 'Evidência:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['mat_prima_evid'], 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 5, 'Estudo de processo?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['estudo_proc'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(17, 5, 'Evidência:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['estudo_proc_evid'], 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 5, 'Produto similar?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['prod_sim'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(17, 5, 'Evidência:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['prod_sim_evid'], 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 5, 'Desenvolver ferramental?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['desen_ferram'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(17, 5, 'Evidência:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(130, 5, $row['desen_ferram_evid'], 0, 'J');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 5, 'É viável?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['sol_viavel'], 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(10, 5, 'OBS:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(180, 5, $row['sol_viavel_obs'], 0, 1);

$pdf->Cell(0, 5, "", "B", 1, 'C');

//Custo
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(12, 10, $sCusto, 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(73, 5, 'Planejamento e desenvolvimento do projeto:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $Rs . number_format($row['vlrDesenProj'], 2, ',', '.'), 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(73, 5, 'Ferramental: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $Rs . number_format($row['vlrFerramen'], 2, ',', '.'), 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(73, 5, 'Matéria prima: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $Rs . number_format($row['vlrMatPrima'], 2, ',', '.'), 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(73, 5, 'Acabamento superficial: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $Rs . number_format($row['vlrAcabSuper'], 2, ',', '.'), 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(73, 5, 'Tratamento térmico: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $Rs . number_format($row['vlrTratTer'], 2, ',', '.'), 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(73, 5, 'Custo de produção: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $Rs . number_format($row['vlrCustProd'], 2, ',', '.'), 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(73, 5, 'Custo total: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $Rs . number_format($row['custotot'], 2, ',', '.'), 0, 1, 'L');

$pdf->Cell(0, 5, "", "B", 1, 'C');  //linha em branco 
//VENDAS
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(12, 10, $sVendas, 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(38, 5, 'Responsável de vendas:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['resp_venda_nome'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Preço final:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $Rs . number_format($row['precofinal'], 2, ',', '.'), 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(45, 5, 'Prazo de entrega(Dias úteis):', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(8, 5, $row['prazoentregautil'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(16, 5, 'É viável?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['sol_viavel_fin'], 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(10, 5, 'OBS:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(180, 5, $row['fin_obs'], 0, 1);


$pdf->Cell(0, 5, "", "B", 1, 'C');  //linha em branco 
//Cadastro
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(12, 10, $sCadastro, 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(8, 5, 'Cód:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(30, 5, $row['procod'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(23, 5, 'Novo produto:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(180, 5, $row['desc_novo_prod'], 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(20, 5, 'Cód. similar:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(18, 5, $row['procodsimilar'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(23, 5, 'Prod. similar:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(180, 5, $row['prodsimilar'], 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(11, 5, 'Rosca:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(12, 5, $row['tiprosca'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, 'N. Dimencional:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(55, 5, $row['normadimen'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(15, 5, 'N. rosca:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['normarosca'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(29, 5, 'N. prop. mecânica:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['normapropmec'], 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, 'Requer PPAP?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(13, 5, $row['ppap'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(41, 5, 'Volume de venda previsto:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(18, 5, $row['vendaprev'], 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(65, 5, 'Requisitos extras solicitados pelo cliente:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(180, 5, $row['reqcli'], 0, 'J');





$pdf->Cell(0, 5, "", "B", 1, 'C');  //linha em branco 


$pdf->Ln(2);
$iContaAltura = $pdf->GetY() + 10;




//number_format($quant, 2, ',', '.')
$pdf->AutoPrint();
$pdf->Output('I', 'relPropProj.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
