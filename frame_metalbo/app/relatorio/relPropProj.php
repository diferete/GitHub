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
$pdf->Cell(90, 10, 'Relatorio de Proposta e Projeto', 0, 0, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(52, 7, 'Data: ' . $sData
        . '        Hora:' . $sHora
        . ' Usuário:' . $sUserRel
        . ' ', '', 'L', 0);
$pdf->Ln(1);
$pdf->Cell(0, 0, "", "B", 1, 'C');

$pdf->SetY(26);
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

$sql = "select nr,sitvendas,sitcliente,sitgeralproj,sitproj,desc_novo_prod,repnome,resp_venda_nome,respvalproj,tbqualNovoProjeto.empcod,empdes,
convert(varchar,dtimp,103) as dtimp,quant_pc,lotemin,prazoentregautil,precofinal,acabamento,replibobs,
equip_corresp,equip_corresp_evid,mat_prima,mat_prima_evid,estudo_proc,estudo_proc_evid,prod_sim,prod_sim_evid,desen_ferram,desen_ferram_evid,sol_viavel,sol_viavel_obs,
vlrDesenProj,vlrFerramen,vlrMatPrima,vlrAcabSuper,vlrTratTer,vlrCustProd,precofinal,prazoentregautil,sol_viavel_fin,fin_obs,resp_venda_nome,
acab, material, classe, anghelice, chavemin, chavemax, altmin, altmax, reqadval_obs, reqadval, 
convert(varchar,etapasfab_prev,103) as etapasfab_prev, convert(varchar,etapasfab_ter,103) as etapasfab_ter, etapas_resp,
diamfmin, diamfmax, compmin, compmax, diampmin, diampmax, diamexmin,reqproblem_obs, reqproblem, comem,convert(varchar,desenho_prev,103) as desenho_prev,
convert(varchar,desenho_ter,103) as desenho_ter, desenho_resp,
diamexmax, comprmin, comprmax, comphmin, comphmax, diamhmin, diamhmax,dadosent, dadosent_obs, reqlegal, reqlegal_obs, reqadicional, reqadicional_obs,
profcanecomin, profcanecomax,
convert(varchar,relFerr_prev,103) as relFerr_prev, convert(varchar,relFerr_ter,103) as relFerr_ter, relFerr_resp,
convert(varchar,relFerrDesen_prev,103) as relFerrDesen_prev,convert(varchar,relFerrDesen_ter,103) as relFerrDesen_ter,relFerrDesen_resp,
convert(varchar,relFerrDist_prev,103) as relFerrDist_prev,convert(varchar,relFerrDist_ter,103) as relFerrDist_ter, relFerrDist_resp,
procod,desc_novo_prod,procodsimilar,prodsimilar,tiprosca,normadimen,normarosca,normapropmec,ppap,vendaprev,reqcli,reqadverif_obs,reqadverif,
convert(varchar,relFerrConf_prev,103) as relFerrConf_prev,convert(varchar,relFerrConf_ter,103) as relFerrConf_ter,relFerrConf_resp,
ferrElaboradas,desenAcordo,comenCrit,
convert(varchar,verifDesenhoPrev,103) as verifDesenhoPrev, convert(varchar,verifDesenhoTer,103) as verifDesenhoTer,verifDesenhoResp,
convert(varchar,verifRelFerrPrev,103) as verifRelFerrPrev, convert(varchar,verifRelFerrter,103) as verifRelFerrter,verifRelFerrResp,
convert(varchar,verifDesenhoFerrPrev,103) as verifDesenhoFerrPrev,convert(varchar,verifDesenhoFerrTer,103) as verifDesenhoFerrTer,verifDesenhoFerrResp,
convert(varchar,dimenProdPrev,103) as dimenProdPrev, convert(varchar,dimenProdTer,103) as dimenProdTer,dimenProdResp,
convert(varchar,camadaZincoPrev,103) as camadaZincoPrev,convert(varchar,camadaZincoTer,103) as camadaZincoTer,camadaZincoResp,
convert(varchar,ensaioDurezaPrev,103) as ensaioDurezaPrev,convert(varchar,ensaioDurezaTer,103) as ensaioDurezaTer,ensaioDurezaResp,
convert(varchar,cargaprovaPrev,103) as cargaprovaPrev,convert(varchar,cargaprovaTer,103) as cargaprovaTer,cargaprovaResp,
convert(varchar,terceiroPrev,103) as terceiroPrev,convert(varchar,terceiroTer,103) as terceiroTer,terceiroResp,
ensReq,ensReqDef,ensReqLegal,ensPlan,ensComem,
valNf,convert(varchar,valNfPrev,103) as valNfPrev,convert(varchar,valNfTer,103) as valNfTer,valNfResp,
valOd,convert(varchar,valOdPrev,103) as valOdPrev,convert(varchar,valOdTer,103) as valOdTer,valODResp,
valPed,convert(varchar,valPedPrev,103) as valPedPrev,convert(varchar,valPedTer,103) as valPedTer,valPedResp,
valPapp,valPed,convert(varchar,valPappPrev,103) as valPappPrev,convert(varchar,valPappTer,103) as valPappTer,valPappResp,
etapProj,result,cliprov,valproj,comenvalproj,respvalproj,
SUM(vlrDesenProj+vlrFerramen+vlrMatPrima+vlrAcabSuper+vlrTratTer+vlrCustProd) as custotot,
convert(varchar,dtaprovaoperacional,103) as dtaprovaoperacional,
usuaprovaoperacional,usuaprovafinanceiro,respAnaliseCri,
convert(varchar,dtaprovafinanceiro,103) as  dtaprovafinanceiro,usuanaliseentrada,
convert(varchar,dtanaliseentrada,103) as dtanaliseentrada,
convert(varchar,dtanalisecritica,103) as dtanalisecritica, 
convert(varchar,dtanaliseens,103) as dtanaliseens, 
convert(varchar,dtanalisevalproj,103) as dtanalisevalproj,respAnaliseCri,respEns,
prazoentregautil,
precofinal,
sol_viavel_fin,
usuaprovafinanceiro,  
convert(varchar,dtaprovafinanceiro,103) as dtaprovafinanceiro,
fin_obs, 
obs_geral 
from tbqualNovoProjeto left outer join  widl.EMP01
on tbqualNovoProjeto.empcod  = widl.EMP01.empcod
where filcgc ='" . $FilcgcRex . "' and nr = '" . $sNr . "' 
group by nr,sitvendas,sitcliente,sitgeralproj,sitproj,desc_novo_prod,repnome,resp_venda_nome,respvalproj,
tbqualNovoProjeto.empcod,empdes,dtimp,quant_pc,lotemin,prazoentregautil,precofinal,acabamento,replibobs,
equip_corresp,equip_corresp_evid,mat_prima,mat_prima_evid,estudo_proc,estudo_proc_evid,prod_sim,
prod_sim_evid,desen_ferram,desen_ferram_evid,sol_viavel,sol_viavel_obs,
vlrDesenProj,vlrFerramen,vlrMatPrima,vlrAcabSuper,vlrTratTer,vlrCustProd,relFerrDist_prev,relFerrDist_ter, relFerrDist_resp,
precofinal,prazoentregautil,sol_viavel_fin,fin_obs,resp_venda_nome,relFerrDesen_prev,relFerrDesen_ter,relFerrDesen_resp,
procod,desc_novo_prod,procodsimilar,prodsimilar,tiprosca,normadimen,normarosca,normapropmec,ppap,vendaprev,reqcli,reqadverif_obs,reqadverif,
acab, material, classe, anghelice, chavemin, chavemax, altmin, altmax,reqadval_obs, reqadval, etapasfab_prev, etapasfab_ter, etapas_resp,
relFerrConf_prev,relFerrConf_ter,relFerrConf_resp,ferrElaboradas,desenAcordo,comenCrit,
diamfmin, diamfmax, compmin, compmax, diampmin, diampmax, diamexmin,reqproblem_obs, reqproblem,comem,desenho_prev, desenho_ter, desenho_resp,
diamexmax, comprmin, comprmax, comphmin, comphmax, diamhmin, diamhmax,dadosent,dadosent_obs, reqlegal, reqlegal_obs, reqadicional, reqadicional_obs,
profcanecomin, profcanecomax, 
relFerr_prev, relFerr_ter, relFerr_resp,
verifDesenhoPrev,verifDesenhoTer,verifDesenhoResp,verifRelFerrPrev,verifRelFerrter,
verifRelFerrResp,verifDesenhoFerrPrev,verifDesenhoFerrTer,verifDesenhoFerrResp,
dimenProdPrev,dimenProdTer,dimenProdResp,camadaZincoPrev,camadaZincoTer,
camadaZincoResp,ensaioDurezaPrev,ensaioDurezaTer,ensaioDurezaResp,cargaprovaPrev,
cargaprovaTer,cargaprovaResp,terceiroPrev,terceiroTer,terceiroResp,
ensReq,ensReqDef,ensReqLegal,ensPlan,ensComem,
valNf,valNfPrev,valNfTer,valNfResp,
valOd,valOdPrev,valOdTer,valODResp,
valPed,valPedPrev,valPedTer,valPedResp,
valPapp,valPappPrev,valPappTer,valPappResp,
etapProj,result,cliprov,valproj,comenvalproj,respvalproj,
usuaprovaoperacional,dtaprovaoperacional,usuaprovafinanceiro,
dtaprovafinanceiro,usuanaliseentrada,dtanaliseentrada,dtanalisecritica, dtanaliseens, dtanalisevalproj,respAnaliseCri,respEns,
prazoentregautil,
precofinal,
sol_viavel_fin,
usuaprovafinanceiro,  
dtaprovafinanceiro,
fin_obs, 
obs_geral";

$sth = $PDO->query($sql);
$row = $sth->fetch(PDO::FETCH_ASSOC);

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

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(12, 5, 'Geral', 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', '', 12);
$pdf->Cell(25, 5, 'Informações', 'B', 1, 'L');
$pdf->Cell(12, 2, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(8, 5, 'Nr:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(30, 5, $row['nr'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(16, 5, 'Situação:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(31, 5, $sSitProj, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(30, 5, 'Data Implantação:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['dtimp'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(46, 5, 'Prazo de entrega(Dias úteis):', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(18, 5, $row['prazoentregautil'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(12, 5, 'CNPJ:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(27, 5, $row['empcod'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(15, 5, 'Cliente:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['empdes'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(17, 5, 'Descrição:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(180, 5, $row['desc_novo_prod'], 0, 'J'); //quebra de linha

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(21, 5, 'Acabamento:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(30, 5, $row['acabamento'], 0, 0);

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

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(38, 5, 'Responsável de vendas:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(43, 5, $row['resp_venda_nome'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(40, 5, 'Responsável de projetos:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['respvalproj'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(10, 5, 'OBS:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(180, 5, $row['replibobs'], 0, 1);

$pdf->Cell(12, 5, '', 0, 1, 'L');
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
$pdf->SetFont('arial', '', 12);
$pdf->Cell(65, 5, 'Análise operacional da solicitação', 'B', 1, 'L');
$pdf->Cell(12, 2, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(60, 5, 'Temos quipamento correspondente?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['equip_corresp'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(17, 5, 'Evidência:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['equip_corresp_evid'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(60, 5, 'Temos matéria prima correspondente?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['mat_prima'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(17, 5, 'Evidência:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['mat_prima_evid'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(60, 5, 'Requer estudo de processo?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['estudo_proc'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(17, 5, 'Evidência:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['estudo_proc_evid'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(60, 5, 'Existe produto similar?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['prod_sim'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(17, 5, 'Evidência:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['prod_sim_evid'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(60, 5, 'Precisa desenvolver ferramental?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['desen_ferram'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(17, 5, 'Evidência:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(130, 5, $row['desen_ferram_evid'], 0, 'J');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(85, 5, 'A solicitação é considerada viável operacionalmente?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['sol_viavel'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(23, 5, 'Aprovado por:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(47, 5, $row['usuaprovaoperacional'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(30, 5, 'Data da aprovação:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['dtaprovaoperacional'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(10, 5, 'Observação:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(180, 5, $row['sol_viavel_obs'], 0, 1);


$pdf->Cell(12, 5, '', 0, 1, 'L');
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
$pdf->SetFont('arial', '', 12);
$pdf->Cell(38, 5, 'Análise econômica', 'B', 1, 'L');
$pdf->Cell(12, 2, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(73, 5, 'Planejamento e desenvolvimento do projeto:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $Rs . number_format($row['vlrDesenProj'], 2, ',', '.'), 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Ferramental: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $Rs . number_format($row['vlrFerramen'], 2, ',', '.'), 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(73, 5, 'Matéria prima: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $Rs . number_format($row['vlrMatPrima'], 2, ',', '.'), 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Acabamento superficial: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $Rs . number_format($row['vlrAcabSuper'], 2, ',', '.'), 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(73, 5, 'Tratamento térmico: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $Rs . number_format($row['vlrTratTer'], 2, ',', '.'), 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Custo de produção: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $Rs . number_format($row['vlrCustProd'], 2, ',', '.'), 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(73, 5, 'Custo total: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $Rs . number_format($row['custotot'], 2, ',', '.'), 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(26, 5, 'Custo por cento:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $Rs . number_format($row['precofinal'], 2, ',', '.'), 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(38, 5, 'Viável financeiramente?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(10, 5, $row['sol_viavel_fin'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(10, 5, 'OBS:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(180, 5, $row['obs_geral'], 0, 1);

$pdf->Cell(12, 5, '', 0, 1, 'L');
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
$pdf->SetFont('arial', '', 12);
$pdf->Cell(55, 5, 'Definições comerciais finais', 'B', 1, 'L');
$pdf->Cell(12, 2, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(62, 5, 'Prazo entrega/Dias úteis:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(40, 5, $row['prazoentregautil'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(62, 5, 'Preço Final:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(30, 5, $row['precofinal'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(62, 5, 'Viável financeiramente?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(15, 5, $row['sol_viavel_fin'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(23, 5, 'Aprovado por:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(47, 5, $row['usuaprovafinanceiro'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(30, 5, 'Data da aprovação:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(15, 5, $row['dtaprovafinanceiro'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(62, 5, 'Observação vendas/Motivo reprovação:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(180, 5, $row['fin_obs'], 0, 1);

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
$pdf->AddPage();
$pdf->SetY(5);
//Cadastro
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(12, 10, $sCadastro, 0, 1, 'L');

$pdf->SetFont('arial', '', 12);
$pdf->Cell(13, 5, 'Geral', 'B', 1, 'L');
$pdf->Cell(12, 2, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(8, 5, 'Cód:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(30, 5, $row['procod'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(23, 5, 'Novo produto:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(180, 5, $row['desc_novo_prod'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(20, 5, 'Cód. similar:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(18, 5, $row['procodsimilar'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(23, 5, 'Prod. similar:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(180, 5, $row['prodsimilar'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

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

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, 'Requer PPAP?:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(13, 5, $row['ppap'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(41, 5, 'Volume de venda previsto:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(18, 5, $row['vendaprev'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(65, 5, 'Requisitos extras solicitados pelo cliente:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(180, 5, $row['reqcli'], 0, 'J');

$pdf->Cell(12, 3, '', 0, 1, 'L');

$pdf->SetFont('arial', '', 12);
$pdf->Cell(56, 5, 'Especificações dimensionais', 'B', 1, 'L');
$pdf->Cell(12, 2, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 5, 'Acabamento:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, number_format($row['acab'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 5, 'Material:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['material'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 5, 'Classe:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['classe'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Âng. Helice:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['anghelice'], 2, ',', '.'), 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Chave Min.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['chavemin'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Chave Max.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['chavemax'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Alt. Minima:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['altmin'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Alt. Máxima:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['altmax'], 2, ',', '.'), 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Diâm. Furo Mín:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['diamfmin'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Diâm. Furo Max::', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['diamfmax'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Comp. Mín:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['compmin'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Comp .Máx:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['compmax'], 2, ',', '.'), 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Diâm. Prim. Mín:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['diampmin'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Diâm. Prim. Máx:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['diampmax'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Diâm. Ext. Mín:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['diamexmin'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Diâm. Ext. Máx:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['diamexmax'], 2, ',', '.'), 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Com. Hast. Mín:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['comprmin'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Com. Hast. Máx:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['comprmax'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Com. Rosc. Mín:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['comphmin'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Com. Rosc. Máx:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['comphmax'], 2, ',', '.'), 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Diâm. Haste. Mín:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['diamhmin'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Diâm. Haste. Máx:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['diamhmax'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Prof.Caneco Min.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['profcanecomin'], 2, ',', '.'), 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 4, 'Prof.Caneco Max.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, number_format($row['profcanecomax'], 2, ',', '.'), 0, 1);

$pdf->Cell(12, 5, '', 0, 1, 'L');
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
$pdf->SetFont('arial', '', 12);
$pdf->Cell(50, 5, 'Análise crítica de entrada', 'B', 1, 'L');
$pdf->Cell(12, 2, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 5, 'Os dados de entrada são adequados e suficientes?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['dadosent'] . '  -  ' . $row['dadosent_obs'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 5, 'Os requisitos legais aplicáveis foram levantados?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['reqlegal'] . '  -  ' . $row['reqlegal_obs'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 5, 'Algum requisito adicional de clientes?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['reqadicional'] . '  -  ' . $row['reqadicional_obs'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 5, 'Algum requisito adicional de verificação?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['reqadverif'] . '  -  ' . $row['reqadverif_obs'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 5, 'Algum requisito adicional de validação?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['reqadval'] . '  -  ' . $row['reqadval_obs'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 5, 'Consideramos que o produto não terá problemas com dimensional e montabilidade?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['reqproblem'] . '  -  ' . $row['reqproblem_obs'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(45, 5, 'Resp. análise crítica entrada:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(30, 5, $row['usuanaliseentrada'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(40, 5, 'Dt. análise crítica entrada:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['dtanaliseentrada'], 0, 1);

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(28, 5, 'Comentários:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['comem'], 0, 1);

$pdf->Cell(0, 3, "", "", 1, 'C');
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
$pdf->SetFont('arial', '', 12);
$pdf->Cell(48, 5, 'Detalhamento do projeto', 'B', 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Elaborar os desenhos do produto - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['desenho_prev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['desenho_ter'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['desenho_resp'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Definir etapas do processo de fabricação - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['etapasfab_prev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['etapasfab_ter'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['etapas_resp'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Elaborar relação de ferramentas do produto - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['relFerr_prev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['relFerr_ter'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['relFerr_resp'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Elaborar desenhos de ferramentas - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['relFerrDesen_prev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['relFerrDesen_ter'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['relFerrDesen_resp'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Distrubuição de desenhos na ferramentaria - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['relFerrDist_prev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['relFerrDist_ter'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['relFerrDist_resp'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Confeccionar ferramentas - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['relFerrConf_prev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['relFerrConf_ter'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['relFerrConf_resp'], 0, 1, 'L');

$pdf->Cell(12, 5, '', 0, 1, 'L');

$pdf->SetFont('arial', '', 12);
$pdf->Cell(80, 5, 'Análise crítica do detalhamento do projeto', 'B', 1, 'L');
$pdf->Cell(12, 3, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 5, 'Todas as ferramentas foram elaboradas?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['ferrElaboradas'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'O desenho do produto está de acordo conforme requisitos do cliente?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['desenAcordo'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(30, 5, $row['respAnaliseCri'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, 'Data da análise:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['dtanalisecritica'], 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(65, 5, 'Comentários:', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['comenCrit'], 0, 1, 'L');

$pdf->Cell(12, 10, '', 0, 1, 'L');
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
$pdf->SetFont('arial', '', 12);
$pdf->Cell(65, 5, 'Controle de verificação de projeto', 'B', 1, 'L');
$pdf->Cell(12, 3, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(79, 5, 'Verificação dos desenhos do produto - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['verifDesenhoPrev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['verifDesenhoTer'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['verifDesenhoResp'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(79, 5, 'Verificação da relação de ferramentas por produto - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['verifRelFerrPrev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['verifRelFerrter'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['verifRelFerrResp'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(79, 5, 'Análise dimensional e desenhos das ferramentas - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['verifDesenhoFerrPrev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['verifDesenhoFerrTer'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['verifDesenhoFerrResp'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(79, 5, 'Análise dimensional do produto - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['dimenProdPrev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['dimenProdTer'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['dimenProdResp'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(79, 5, 'Ensaio da camada de zinco - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['camadaZincoPrev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['camadaZincoTer'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['camadaZincoResp'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(79, 5, 'Ensaio de dureza - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['ensaioDurezaPrev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['ensaioDurezaTer'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['ensaioDurezaResp'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(79, 5, 'Ensaio de carga de prova - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['cargaprovaPrev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['cargaprovaTer'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['cargaprovaResp'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(79, 5, 'Processo realizado por terceiro - ', 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['terceiroPrev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $row['terceiroTer'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['terceiroResp'], 0, 1, 'L');

$pdf->Cell(12, 5, '', 0, 1, 'L');
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
$pdf->SetFont('arial', '', 12);
$pdf->Cell(75, 5, 'Análise crítica de verificação do projeto', 'B', 1, 'L');
$pdf->Cell(12, 3, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 5, 'Os ensaios requeridos foram realizados?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['ensReq'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Os resultados atenderam ao requisito definido pela empresa?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['ensReqDef'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 5, 'Os resultados atenderam ao requisitos legais aplicáveis?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['ensReqLegal'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'As etapas definidas no planejamento foram cumpridas conforme cronograma?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['ensPlan'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(30, 5, $row['respEns'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, 'Data da análise:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(100, 5, $row['dtanaliseens'], 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Comentário', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['ensComem'], 0, 1, 'L');

$pdf->Cell(12, 5, '', 0, 1, 'L');
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
$pdf->SetFont('arial', '', 12);
$pdf->Cell(63, 5, 'Controle de validação do projeto', 'B', 1, 'L');
$pdf->Cell(12, 3, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(40, 4, 'Nota fiscal nº: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 4, $row['valNf'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 4, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 4, $row['valNfPrev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 4, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 4, $row['valNfTer'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 4, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, $row['valNfResp'], 0, 1, 'L');

$pdf->Cell(12, 4, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(40, 4, 'Ordem de fabricação nº: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 4, $row['valOd'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 4, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 4, $row['valOdPrev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 4, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 4, $row['valOdTer'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 4, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, $row['valODResp'], 0, 1, 'L');

$pdf->Cell(12, 4, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(40, 4, 'Pedido nº: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 4, $row['valPed'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 4, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 4, $row['valPedPrev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 4, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 4, $row['valPedTer'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 4, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, $row['valPedResp'], 0, 1, 'L');

$pdf->Cell(12, 4, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(40, 4, 'PAPP nº: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 4, $row['valPapp'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 4, 'Previsão: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 4, $row['valPappPrev'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 4, 'Término: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 4, $row['valPappTer'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 4, 'Responsável: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 4, $row['valPappResp'], 0, 1, 'L');

$pdf->Cell(12, 5, '', 0, 1, 'L');
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

$pdf->SetFont('arial', '', 12);
$pdf->Cell(75, 5, 'Análise crítica de validação do projeto', 'B', 1, 'L');
$pdf->Cell(12, 3, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 5, 'As etapas do projeto foram realizadas conforme planejamento?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['etapProj'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Os resultados atenderam ao requisito definido pelo cliente?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['result'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 5, 'O cliente aprovou o produto?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['cliprov'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Consideramos o projeto validado?', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['valproj'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(70, 5, 'Comentários/ Alterações Propostas', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['comenvalproj'], 0, 1, 'L');

$pdf->Cell(12, 1, '', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(22, 5, 'Responsável:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['respvalproj'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, 'Data da análise:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $row['dtanalisevalproj'], 0, 1, 'L');

$pdf->Cell(12, 5, '', 0, 1, 'L');


//number_format($quant, 2, ',', '.')
$pdf->AutoPrint();
$pdf->Output('I', 'relPropProj.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
