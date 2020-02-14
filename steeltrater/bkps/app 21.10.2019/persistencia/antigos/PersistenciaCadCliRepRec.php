<?php

/*
 * Classe que controla a persistencia da classe PersistenciaCadCliRep
 * @author Avanei Martendal
 * @since 18/09/2017
 */

class PersistenciaCadCliRepRec extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('pdfempcad');

        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('empcod', 'empcod', true, true);
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('empfj', 'empfj');
        $this->adicionaRelacionamento('empconfina', 'empconfina');
        $this->adicionaRelacionamento('pagast', 'pagast');
        $this->adicionaRelacionamento('simplesNacional', 'simplesNacional');
        $this->adicionaRelacionamento('empdtcad', 'empdtcad');
        $this->adicionaRelacionamento('empusucad', 'empusucad');
        $this->adicionaRelacionamento('empfant', 'empfant');
        $this->adicionaRelacionamento('empativo', 'empativo');
        $this->adicionaRelacionamento('empfone', 'empfone');
        $this->adicionaRelacionamento('empinterne', 'empinterne');
        $this->adicionaRelacionamento('empend', 'empend');
        $this->adicionaRelacionamento('cidcep', 'cidcep');
        $this->adicionaRelacionamento('empendbair', 'empendbair');
        $this->adicionaRelacionamento('empins', 'empins');
        $this->adicionaRelacionamento('empobs', 'empobs');
        $this->adicionaRelacionamento('repcod', 'repcod');

        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('empmunicipio', 'empmunicipio');
        $this->adicionaRelacionamento('uf', 'uf');
        $this->adicionaRelacionamento('officecod', 'officecod');
        $this->adicionaRelacionamento('officedes', 'officedes');

        $this->adicionaRelacionamento('emailNfe', 'emailNfe');

        $this->adicionaRelacionamento('situaca', 'situaca');
        $this->adicionaRelacionamento('dtlib', 'dtlib');
        $this->adicionaRelacionamento('horalib', 'horalib');
        $this->adicionaRelacionamento('resp_venda_cod', 'resp_venda_cod');
        $this->adicionaRelacionamento('resp_venda_nome', 'resp_venda_nome');

        $this->adicionaRelacionamento('empnr', 'empnr');

        $this->adicionaRelacionamento('empcobbco', 'empcobbco');
        $this->adicionaRelacionamento('empcobcar', 'empcobcar');
        $this->adicionaRelacionamento('certcli', 'certcli');


        $this->adicionaOrderBy('nr', 1);
    }

    //executa a liberação para projetos
    public function liberaMetalbo($aDados) {
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $sSql = " select * from pdfempcad where nr = '" . $aDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sSituaca = $oRow->situaca;
        //verificar se o campo situaca == liberado se for, nao dar update e rotorna array como false na posicao zero
        if ($sSituaca == 'Liberado') {
            $aRetorno[0] = false;
            $aRetorno[1] = 'Atenção este cadastro já está liberado!';
            return $aRetorno;
        } else {

            $sSql = "update pdfempcad set situaca ='Liberado',
                    dtlib ='" . $sData . "',
                    horalib ='" . $sHora . "'
                    where nr ='" . $aDados['nr'] . "'";
            $aRetorno = $this->executaSql($sSql);




            return $aRetorno;
        }
    }

    /* busca resp vendas */

    //busca e-mail de vendas
    public function buscaEmailVenda($sNr) {
        $sSql = "select resp_venda_cod 
                from pdfempcad 
                where nr ='" . $sNr . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $codVenda = $oRow->resp_venda_cod;

        //busca email venda
        $sSql = "select usuemail
                from tbusuario 
                where usucodigo ='" . $codVenda . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['venda'] = $oRow->usuemail;

        return $aEmail;
    }

    //verifica se há um cnpj cadastrado
    public function buscaVerificaCnpj($sCnpj) {
        $sSql = "select count(*) as cont 
                from widl.emp01
                where empcod ='" . $sCnpj . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iCont = $oRow->cont;

        if ($iCont > 0) {
            $aRetorno[0] = false;
            $aRetorno[1] = 'Atenção esse cnpj já tem cadastro no sistema!';
        } else {
            $aRetorno[0] = true;
            $aRetorno[1] = '';
        }
        return $aRetorno;
    }

    //gera o cadastro
    public function geraCadastro($oCliente) {
        date_default_timezone_set('America/Sao_Paulo');

        $sHora = date('H:i');
        $sData = date('d/m/Y');
        $sNomeDelsot = $_SESSION['nomedelsoft'];

        //verifica se paga realmente st
        if ($oCliente->getPagast() == 'Sim') {
            switch ($oCliente->getUf()) {
                case 'SC':
                    $sAtvCod = 14;
                    break;
                case 'RS':
                    $sAtvCod = 16;
                    break;
                case 'PR':
                    $sAtvCod = 17;
                    break;
                case 'ES':
                    $sAtvCod = 21;
                    break;
                case 'RJ':
                    $sAtvCod = 22;
                    break;
                case 'MG':
                    $sAtvCod = 13;
                    break;
                default:
                    break;
            }
        } else {
            $sAtvCod = 1;
        }

        //altera valor do campo CERTCLI para '' caso valor NÃO e S caso valor SIM + OBS
        if ($oCliente->getCertcli() == 'N') {
            $sCertCli = '';
        } else {
            $sObsCad = 'CLIENTE NECESSITA CERTIFICADO!!';
            $sCertCli = 'S';
        }



        $sSql = "insert into widl.emp01 (empcod,empdes,cidcep,empcnpj,empdtfda,empdtcad,empusucad,empfant,empend, empendbair,
            empfone,empfax,empinterne,empins,atvcod,ForLimCom,ForCpgCod,ForCpgDes,EmpTipFre,EmpForPag,
            ForTemRes,ForPedMin,empcxposta,empagropec,empsit,empmotdes,empobs,empativo,empfj,emptr,
            empfo,empcl,empat,empfu,empre,empatuexp,emptracod,EmpFatMes,EmpComMes,cclisoc1,
            cclicpf1,cclinac1,cclicot1,ccliide1,cclisoc2,cclicpf2,cclinac2,cclicot2,ccliide2,cclisoc3,
            cclicpf3,cclinac3,cclicot3,ccliide3,cclisoc4,cclicpf4,cclinac4,cclicot4,ccliide4,ccliregjco,
            cclidtreg,cclicpreg,repcod,ccliclassi,cclilimite,cclilimext,empserdias,empsernega,cclirfcom1,cclirfcfo1,
            cclirfcci1,cclirfcom2,cclirfcfo2,cclirfcci2,cclirfcom3,cclirfcfo3,cclirfcci3,cclirfcom4,cclirfcfo4,cclirfcci4,
            cclirfcom5,cclirfcfo5,cclirfcci5,empbanco,empagencia,empconta,empcobbco,empcobcar,empctacli,empsulfram,
            EmpForNeg,EmpExterio,EmpGerCta,EmpGer,EmpDiretor,T0001anp,T0002cod,T0010cod,bancod,catcod,
            empdias,T0008anp,empdesatv,empinsmun,empconreg,empMatCEI,emppr,empas,empforctb,empclictb,
            emptipo,empconult,emptabdes,empconpag,emptransp,empfrecom,empblocred,empicmpera,empicmprz,empipipera,
            empipiprz,emptxaimp,emptxaforn,emptxaclie,empfi,empmatricu,empconfina,empadmqual,empdirdoc,empprofre,
            empforcla,empredesco,empredespa,empausucad,empadtcad,emptprcod,EmpAntigo,EmpCob,grufcod,empnatcod,
            empcpgcod,emptlvtrac,EmpIseIPI,EmpIseICMS,EmpNecCer,empclictad,empctafor,empforctad,empctarep,emprepctad,
            empsite,EmpCreICM,EmpCreIPI,EmpDescont,empdtaaniv,empadmcart,empcodintr,empalifre,Empcomplet,EmpRecapad,
            Empalmcod,empPrazoEn,EmpCodCart,empTrading,empproduto,empPdvApro,repsupervi,empgrfcodi,empgrfdesc,empbdu,
            empFilcgc,empNucleo,empCI,empDtAdmis,empDtDemis,empDtNasCo,empCPFConj,empAposent,empSexo,empINSS,
            empClassif,FisEstCiv,FisNomCge,EmpDescPis,empmotoris,empatinfpa,empsitequ,empgaranti,empdtgaran,empatcontr,
            empdtcontr,empnrovisi,empmemoria,empultprev,empMvaZero,empPDVobs,empenv,empdescfor,emppisunid,empcofinsu,
            empendent,aracod,arscod,emptecper,emptecint,EmpUSeqPro,empAprEspe,empMrgCMin,empRecEmai,empatnroco,
            empdticont,empdtinsta,empultate,empatrespo,emplinpain,cclicod,cclinome,ccliimovel,cclivlrimo,catvcod,
            catvdes,ccliramo,cclidtalt,cclicpalt,cclivendas,ccliestoqu,ccliimovei,cclicarros,cclifuncio,cclifolha,
            cclidta,cclilimton,cclifiliai,ccliatraso,cclivercre,cclivlratr,cclivallim,cclisocimo,cclisocivl,clirfbco1,
            clirfbfo1,clirfbco2,clirfbfo2,clirfbco3,clirfbfo3,clictb,cliresp,empserveri,FisNomPai,FisNomMae,
            FisDepNom1,FisDepNas1,FisDepNom2,FisDepNas2,FisDepNom3,FisDepNas3,FisDepNom4,FisDepNas4,FisDepNom5,FisDepNas5,
            FisEmpAtu,FisEmpAdm,FisEmpAnt,FisRenMes,FisEmpCar,Empmoeda,emptipocli,empperctol,EmpUndPad,EmpPlaca,
            Lngcod,Ex06IncCod,rh47paisna,rh47estnas,rh47cidnas,rh22codigo,rh47sexo,empendnro,empendcomp,rh47orgemi,
            rh47estemi,rh47dtemis,rh47origem,rh47tipovi,rh47idente,rh47valide,rh47anoche,rh47cutis,rh47cabelo,rh47olhos,
            rh47altura,rh47peso,rh47manequ,rh47calcad,rh47defifi,rh47tpdefi,rh47tiposa,rh47fatorr,rh47doador,rh47miltip,
            rh47milnro,rh47milser,rh47milcir,rh47milreg,rh47elenro,rh47elezon,rh47elesec,rh47elecid,rh47eleest,rh47habnum,
            rh47habven,rh47habest,rh47tipope,rh47dgvcon,rh47tipcon,empclasse,empfuncao,emprenasem,empamostra,empcalcome,
            empusufat,CLU010Cod,CLU10TpSan,CLU10PrSan,CLU10Med,CLU10Cir,CLU10Aler,CLU10DoCro,CLU10DoAtu,Clu10DoAnt,
            CLU10TelCe,CLU10TelCo,CLU10Foto,Clu1Cod,Clu10Nat,Clu10Nac,emppre,empfator,emppredol,emplme,
            empsitcada,empimposto,empfunchrm,empfunchrd,emptercemp,empfunchex,empfuncvlh,empfuncter,empempterc,empIseFunr,
            empChaveOk,empChaveDi,empdesblo,empsimples,empRNTRC,emprntrcca,empmatDV,empDebAut,empDescSin,empasstatu,
            empDapAss,empVDapAss,empnegocia,empasQuebr,cclidesace,empdthomol,emptpped,Fisempes,fisorgexp,fislocalna,
            empgeraadi,empmulobs,empcomcli,empdescpra,empemiimed,CNAECod,rh47habcat,empfrtx,empfrvlmin,empGLN,
            empgoverno,empduv,empasegemp,empflout,EmpIENaoCO,empetiprod,rh47datach,rh47datana,rh47estran,rh47estfil,
            EmpDirDecS,EmpIcmST,emptdscod,emptdscons,emptdsindu,emptdsplas,rh47nrocar,empCIOT,empWSCIOT,cliinfbanc/*,
            cclidatlim,cclilimaut,empcar,rh47camisa*/
)values 
('" . $oCliente->getEmpcod() . "',/*cnpj*/
'" . $oCliente->getEmpdes() . "',/*empdes*/
'" . $oCliente->getCidcep() . "',/*cep*/
'" . $oCliente->getEmpcod() . "',/*cnpj novamente*/
'1753-01-01 00:00:00.000',/*data nula*/
'" . $sData . "',/*data do cadastro*/
'" . $sNomeDelsot . "',/*usuário*/
'" . $oCliente->getEmpfant() . "',/*nome fantasia*/
'" . $oCliente->getEmpend() . " " . $oCliente->getEmpnr() . "',/*campo endereço*/ 
'" . $oCliente->getEmpendbair() . "',/*bairro*/
'" . $oCliente->getEmpfone() . "',/*telefone*/
'',/*fax não mais usado*/
'" . $oCliente->getEmpinterne() . "',/*email geral da empresa*/
'" . $oCliente->getEmpins() . "',/*inscrição estadual*/
 '" . $sAtvCod . "',/*atv cod ATENÇÃO COM A SUBSTITUIÇÃO TRIBUTARIA NESTE CAMPO*/
'0',/*NAO USADO */
'0',/*NAO USADO */
'',/*NAO USADO */
'',/*NAO USADO */
'',/*NAO USADO */
'0',/*NAO USADO */
'0',/*NAO USADO */
'',/*NAO USADO */
'N',/*VERIFICA AGROPECUARIA*/
'',/*EMPSIT PARECE NAO USAR*/
'',/*NAO USADO*/
'" . $sObsCad . ' ' . $oCliente->getEmpobs() . "',/*OBSERVAÇÃO DO CLIENTE*/
'S',/*MARCA COMO O CLIENTE ATIVO*/
'" . $oCliente->getEmpfj() . "',/*MARCA COMO O CNPJ É JURIDICA OU FÍSIA, J OU F*/
'',/*MARCA SE É TRANSPORTADORA = T*/
'',/*MARCA SE É FORNECEDOR*/
'C',/*MARCA COMO CLIENTE*/
'',/*NAO USADO*/
'',/*MACA COMO FUNCIONÁRIO*/
'',/*MARCA COMO REPRESENTANTE*/
'1',/*DEIXAR VALOR PADRAO COMO 1*/
'0',/*NAO USADO*/
'0,00',/*NAO USADO*/
'0,00',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'0,00',/*NAO USADO*/
'" . $oCliente->getRepcod() . "',/**CÓDIGO DO REPRESENTANTE MUITO IMPORTANTE*/
'',/*NAO USADO*/
'0,00' , /*NAO USADO*/
'0,00',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'" . $oCliente->getEmpcobbco() . "',/*BANCO MUITO IMPORTANTE VERIFICAR*/
'" . $oCliente->getEmpcobcar() . "',/*CARTEIRA*/
'0',/*VERIFICAR O QUE PODE SER*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'N',/*ALGO COM EXTERIOR*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0,00',/*NAO USADO*/
'N',/*BLOQUEIO DO CRÉDITO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0,00',/*NAO USADO*/
'0,00',/*NAO USADO*/
'0,00',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'" . $oCliente->getEmpconfina() . "',/*VERIFICAR SE NÃO É O CLIENTE FINAL*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'NA',/*VERIFICAR*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'" . $sNomeDelsot . "',/*USUÁRIO DO CADASTRO*/
'" . $sData . "',/*DATA DO CADASTRP*/
'',/*VERIFICAR O QUE PODE SER*/
'0',/*CÓDIGO ANTIGO NÃO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'" . $sCertCli . "',/*SE NECESSITA CERTIFICADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0,00',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'0,00',/*NAO USADO*/
'',/*NAO USADO*/
'N',/*VERIFICAR O QUE É*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'N',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'0',/*NAO USADO*/	
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'N',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO EMPDTGARAN*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'1753-01-01 00:00:00.000',
'N',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0,00',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0,00',/*NAO USADO*/
'I',/*VERIFICAR ESSE CAMPO*/
'0',/*NAO USADO*/
'N',/*NAO USADO*/
'0,00',/*NAO USADO*/
'S',/*NAO USADO*/
'0',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0'	,/*VERIFICAR ESSE CAMPO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0,00',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'0,00',/*NAO USADO*/
'0,00',/*NAO USADO*/
'0,00',/*NAO USADO*/
'0,00',/*NAO USADO*/
'0,00',/*NAO USADO*/
0,/*NAO USADO*/
'0,00',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'0,00',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'',/*NAO USADO*/
'0,00',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'',/*NAO USADO*/
'0,00',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0,00',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0,00',/*NAO USADO*/
'0,00',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'1753-01-01 00:00:00.000',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
'0',/*NAO USADO*/
'',/*NAO USADO*/
'',/*NAO USADO*/
null,/*NAO USADO*/
null,/*NAO USADO*/
null,/*NAO USADO*/
null,/*NAO USADO*/
0,/*NAO USADO*/
null,/*NAO USADO*/
null,/*NAO USADO*/
null,/*NAO USADO*/
0,/*NAO USADO*/
NULL,	/*NAO USADO*/
'0,00',	
'N',
'N',	
NULL,	
NULL,	
NULL,
'0,00',
'" . $oCliente->getSimplesNacional() . "',/*SIMPLES NACIONAL*/
null,
null,
null,
'N',
'0,00',
NULL,
NULL,
'1753-01-01 00:00:00.000',
NULL,
'S',
NULL,
'1753-01-01 00:00:00.000',
null,
null,
null,
null,
null,
null,
'0,00',
'0,00',
'',
0,
null,
null,
null,
0,
'N',
null,
0,
0,
'N',
'',
null,
null,
null,
null,
null,
null,
'0',
null,
null,
null,
0,
'N',
'N',
null/*,null,null,null,null*/)
";

        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

    /**
     * Insere o e-mail de nfe
     */
    public function insereEmailNfe($oCliente) {
        $sSql = "insert into widl.EMP0103(empcod,empconseq,empcontip,empconemai)
            values('" . $oCliente->getEmpcod() . "','1','14','" . $oCliente->getEmailNfe() . "')";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    /**
     * Muda situação para cadastrado
     */
    public function sitCadastrado($oCliente) {
        $sSql = "update pdfempcad set situaca = 'Cadastrado' where nr ='" . $oCliente->getNr() . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    /**
     * retorna para o representante
     */
    public function retRep($aDados) {
        $sSql = "update pdfempcad set situaca ='',
                    dtlib =null,
                    horalib =null
                    where nr ='" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);




        return $aRetorno;
    }

    /**
     * Insere endereços 
     */
    public function insereEnderecos($oCliente) {

        $sSql = "select COUNT(*) as total 
                from pdfempcadEnd 
                where nr ='" . $oCliente->getNr() . "' and empcod ='" . $oCliente->getEmpcod() . "'";
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        if ($row->total > 0) {

            //busca os endereços
            $sSql = "select * 
                from pdfempcadEnd 
                where nr ='" . $oCliente->getNr() . "' and empcod ='" . $oCliente->getEmpcod() . "'";
            $result = $this->getObjetoSql($sSql);
            while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
                //verifica tipo de endereço 1 de cobranca 2 entrega
                if ($oRowBD->tipo == 'De cobranca') {
                    $sTipo = '1';
                }
                if ($oRowBD->tipo == 'De entrega') {
                    $sTipo = '2';
                }
                $sInsert = "insert into widl.EMP04 (empcod,empendtip,empedend,empedbai,empedcep,empedobs,empedemail,empedfone,empedie,empedcnpj,empativina)
                   values('" . $oRowBD->empcod . "','" . $sTipo . "','" . $oRowBD->ender . " " . $oRowBD->endnr . "','" . $oRowBD->endbairr . "','" . $oRowBD->endcep . "','" . $oRowBD->empendobs . "','" . $oRowBD->empendemail . "','" . $oRowBD->empendfone . "','" . $oRowBD->endinsc . "','" . $oRowBD->endcnpj . "','S')";
                $this->executaSql($sInsert);
            }
            $aRetorno[0] = true;
            return $aRetorno;
        } else {
            $aRetorno[0] = true;
            return $aRetorno;
        }
    }

}
