<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_TEC_Catalogo extends Persistencia {

    public function __construct() {
        parent::__construct();
    }

    function buscaDadosFiltro($aDados) {

        $PDOnew = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

        $aRet01 = $PDOnew->exec('drop table #MetTecCxNormal');
        $aRet02 = $PDOnew->exec('drop table #MetTecCxMaster');
        $aRet03 = $PDOnew->exec('drop table #MetTecSaco');

        $sSql = 'create table #MetTecCxNormal( '
                . 'procod integer not null, '
                . 'cxnormal money) ';
        $aRet04 = $PDOnew->exec($sSql);

        $sSql = 'create table #MetTecCxMaster( '
                . 'procod integer not null, '
                . 'cxmaster money) ';
        $aRet05 = $PDOnew->exec($sSql);

        $sSql = 'create table #MetTecSaco( '
                . 'procod integer not null, '
                . 'saco money) ';
        $aRet06 = $PDOnew->exec($sSql);


        $sSql = "iinsert into #MetTecCxNormal (procod,cxnormal) "
                . "select widl.prod01.procod,pcs "
                . "from widl.prod01 "
                . "left outer join pdftabvendas on widl.prod01.procod = pdftabvendas.codigo "
                . "left outer join metmat on widl.prod01.procod = metmat.procod "
                . "left outer join tbean on widl.prod01.procod = tbean.codigo "
                . "where widl.prod01.grucod =" . $aDados[0];
        //adiciona condicionais conforme filtro para Subgrpo, Familia e Subfamilia
        if ($aDados[1] != '' && $aDados[1] != 'null') {
            $sSql .= " and subcod = " . $aDados[1] . " ";
        }
        if ($aDados[2] != '' && $aDados[2] != 'null') {
            $sSql .= "and famcod in( " . $aDados[2] . ") ";
        }
        if ($aDados[3] != '' && $aDados[3] != 'null') {
            $sSql .= "and famsub in (" . $aDados[3] . ") ";
        }
        $sSql .= "and tbean.inativo <> 's' "
                . "and probloqpro <> 'S' "
                . "and promatcod <> '' "
                . "and pdftabvendas.preco is not null "
                . "and widl.prod01.subcod not in(2,9,116,128,201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,260,329,700,710,711) "
                . "and tbean.caixa = 'NORMAL'";
        $aRet07 = $PDOnew->exec($sSql);

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//        

        $sSql = "insert into #MetTecCxMaster (procod,cxmaster) "
                . "select widl.prod01.procod,pcs "
                . "from widl.prod01 "
                . "left outer join pdftabvendas on widl.prod01.procod = pdftabvendas.codigo "
                . "left outer join metmat on widl.prod01.procod = metmat.procod "
                . "left outer join tbean on widl.prod01.procod = tbean.codigo "
                . "where widl.prod01.grucod =" . $aDados[0];
        //adiciona condicionais conforme filtro para Subgrpo, Familia e Subfamilia
        if ($aDados[1] != '' && $aDados[1] != 'null') {
            $sSql .= " and subcod = " . $aDados[1] . " ";
        }
        if ($aDados[2] != '' && $aDados[2] != 'null') {
            $sSql .= "and famcod in( " . $aDados[2] . ") ";
        }
        if ($aDados[3] != '' && $aDados[3] != 'null') {
            $sSql .= "and famsub in (" . $aDados[3] . ") ";
        }
        $sSql .= "and tbean.inativo <> 's' "
                . "and probloqpro <> 'S' "
                . "and promatcod <> '' "
                . "and pdftabvendas.preco is not null "
                . "and widl.prod01.subcod not in(2,9,116,128,201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,260,329,700,710,711) "
                . "and tbean.caixa = 'MASTER'";
        $aRet08 = $PDOnew->exec($sSql);

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//        

        $sSql = "insert into #MetTecSaco (procod,saco) "
                . "select widl.prod01.procod,pcs "
                . "from widl.prod01 "
                . "left outer join pdftabvendas on widl.prod01.procod = pdftabvendas.codigo "
                . "left outer join metmat on widl.prod01.procod = metmat.procod "
                . "left outer join tbean on widl.prod01.procod = tbean.codigo "
                . "where widl.prod01.grucod =" . $aDados[0];
        //adiciona condicionais conforme filtro para Subgrpo, Familia e Subfamilia
        if ($aDados[1] != '' && $aDados[1] != 'null') {
            $sSql .= " and subcod = " . $aDados[1] . " ";
        }
        if ($aDados[2] != '' && $aDados[2] != 'null') {
            $sSql .= "and famcod in( " . $aDados[2] . ") ";
        }
        if ($aDados[3] != '' && $aDados[3] != 'null') {
            $sSql .= "and famsub in (" . $aDados[3] . ") ";
        }
        $sSql .= "and tbean.inativo <> 's' "
                . "and probloqpro <> 'S' "
                . "and promatcod <> '' "
                . "and pdftabvendas.preco is not null "
                . "and widl.prod01.subcod not in(2,9,116,128,201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,260,329,700,710,711) "
                . "and tbean.caixa = 'SACO'";
        $aRet09 = $PDOnew->exec($sSql);




//====================================== SELECT FINAL PARA TRAZER TODOS OS DADOS NECESSÁRIOS ============================================================//
        $sSql = "select cxnormal,cxmaster,saco,widl.prod01.procod,pdftabvendas.preco,prodes,pround,promatcod,ProClasseG,widl.prod05.media,metmat.material,"
                . "prodchamin,prodchamax,prodchamin,prodchamax,prodaltmin,prodaltmax,proddiamin,proddiamax,procommin,procommax,prodiapmin,prodiapmax,"
                . "prodiaemin,prodiaemax,procomrmin,procomrmax,comphastma,comphastmi,diamhastmi,diamhastma,pfcmin,pfcmax,proanghel "
                . "from widl.prod01 "
                . "left outer join pdftabvendas on widl.prod01.procod = pdftabvendas.codigo "
                . "left outer join widl.prod05 on widl.prod01.subcod = widl.prod05.subcod "
                . "left outer join metmat on widl.prod01.procod = metmat.procod "
                . "left outer join #MetTecCxNormal on widl.prod01.procod = #MetTecCxNormal.procod "
                . "left outer join #MetTecCxMaster on widl.prod01.procod = #MetTecCxMaster.procod "
                . "left outer join #MetTecSaco on widl.prod01.procod = #MetTecSaco.procod "
                . "where widl.prod01.grucod =" . $aDados[0];
//====================================================================================================================//
        //adiciona condicionais conforme filtro para Subgrpo, Familia e Subfamilia
        if ($aDados[1] != '' && $aDados[1] != 'null') {
            $sSql .= " and widl.prod01.subcod = " . $aDados[1] . " ";
        }
        if ($aDados[2] != '' && $aDados[2] != 'null') {
            $sSql .= "and famcod in( " . $aDados[2] . ") ";
        }
        if ($aDados[3] != '' && $aDados[3] != 'null') {
            $sSql .= "and famsub in (" . $aDados[3] . ") ";
        }
//====================================================================================================================//
        $sSql .= "and probloqpro <> 'S' "
                . "and promatcod <> '' "
                . "and pdftabvendas.preco is not null "
                . "and widl.prod01.subcod not in(2,9,116,128,201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,260,329,700,710,711)";

        $result = $PDOnew->query($sSql);
        $aRetorno = array();
        $aDadosRet = array();
        while ($oRowDB = $result->fetchObject()) {

            $aDadosRet['procod'] = trim($oRowDB->procod);
            $aDadosRet['prodes'] = trim($oRowDB->prodes);
            $aDadosRet['pround'] = trim($oRowDB->pround);
            $aDadosRet['promatcod'] = trim($oRowDB->promatcod);
            $aDadosRet['media'] = trim($oRowDB->media);
            $aDadosRet['material'] = trim($oRowDB->material);
            $aDadosRet['classe'] = trim($oRowDB->ProClasseG);
            $aDadosRet['preco'] = trim(number_format($oRowDB->preco, 2, ',', '.'));

            if ($oRowDB->cxnormal != 0 && $oRowDB->cxnormal != null) {
                $aDadosRet['cxnormal'] = number_format($oRowDB->cxnormal, 0, ',', '.');
            } else {
                $aDadosRet['cxnormal'] = 'N/A';
            }
            if ($oRowDB->cxmaster != 0 && $oRowDB->cxmaster != null) {
                $aDadosRet['cxmaster'] = number_format($oRowDB->cxmaster, 0, ',', '.');
            } else {
                $aDadosRet['cxmaster'] = 'N/A';
            }
            if ($oRowDB->saco != 0 && $oRowDB->saco != null) {
                $aDadosRet['saco'] = number_format($oRowDB->saco, 0, ',', '.');
            } else {
                $aDadosRet['saco'] = 'N/A';
            }
            if ($oRowDB->prodchamin != 0 && $oRowDB->prodchamin != null) {
                $aDadosRet['prodchamin'] = number_format($oRowDB->prodchamin, 2, ',', '.');
            } else {
                $aDadosRet['prodchamin'] = 'N/A';
            }
            if ($oRowDB->prodchamax != 0 && $oRowDB->prodchamax != null) {
                $aDadosRet['prodchamax'] = number_format($oRowDB->prodchamax, 2, ',', '.');
            } else {
                $aDadosRet['prodchamax'] = 'N/A';
            }
            if ($oRowDB->prodaltmin != 0 && $oRowDB->prodaltmin != null) {
                $aDadosRet['prodaltmin'] = number_format($oRowDB->prodaltmin, 2, ',', '.');
            } else {
                $aDadosRet['prodaltmin'] = 'N/A';
            }
            if ($oRowDB->prodaltmax != 0 && $oRowDB->prodaltmax != null) {
                $aDadosRet['prodaltmax'] = number_format($oRowDB->prodaltmax, 2, ',', '.');
            } else {
                $aDadosRet['prodaltmax'] = 'N/A';
            }
            if ($oRowDB->proddiamin != 0 && $oRowDB->proddiamin != null) {
                $aDadosRet['proddiamin'] = number_format($oRowDB->proddiamin, 2, ',', '.');
            } else {
                $aDadosRet['proddiamin'] = 'N/A';
            }
            if ($oRowDB->proddiamax != 0 && $oRowDB->proddiamax != null) {
                $aDadosRet['proddiamax'] = number_format($oRowDB->proddiamax, 2, ',', '.');
            } else {
                $aDadosRet['proddiamax'] = 'N/A';
            }
            if ($oRowDB->procommin != 0 && $oRowDB->procommin != null) {
                $aDadosRet['procommin'] = number_format($oRowDB->procommin, 2, ',', '.');
            } else {
                $aDadosRet['procommin'] = 'N/A';
            }
            if ($oRowDB->procommax != 0 && $oRowDB->procommax != null) {
                $aDadosRet['procommax'] = number_format($oRowDB->procommax, 2, ',', '.');
            } else {
                $aDadosRet['procommax'] = 'N/A';
            }
            if ($oRowDB->prodiapmin != 0 && $oRowDB->prodiapmin != null) {
                $aDadosRet['prodiapmin'] = number_format($oRowDB->prodiapmin, 2, ',', '.');
            } else {
                $aDadosRet['prodiapmin'] = 'N/A';
            }
            if ($oRowDB->prodiapmax != 0 && $oRowDB->prodiapmax != null) {
                $aDadosRet['prodiapmax'] = number_format($oRowDB->prodiapmax, 2, ',', '.');
            } else {
                $aDadosRet['prodiapmax'] = 'N/A';
            }
            if ($oRowDB->prodiaemin != 0 && $oRowDB->prodiaemin != null) {
                $aDadosRet['prodiaemin'] = number_format($oRowDB->prodiaemin, 2, ',', '.');
            } else {
                $aDadosRet['prodiaemin'] = 'N/A';
            }
            if ($oRowDB->prodiaemax != 0 && $oRowDB->prodiaemax != null) {
                $aDadosRet['prodiaemax'] = number_format($oRowDB->prodiaemax, 2, ',', '.');
            } else {
                $aDadosRet['prodiaemax'] = 'N/A';
            }
            if ($oRowDB->procomrmin != 0 && $oRowDB->procomrmin != null) {
                $aDadosRet['procomrmin'] = number_format($oRowDB->procomrmin, 2, ',', '.');
            } else {
                $aDadosRet['procomrmin'] = 'N/A';
            }
            if ($oRowDB->procomrmax != 0 && $oRowDB->procomrmax != null) {
                $aDadosRet['procomrmax'] = number_format($oRowDB->procomrmax, 2, ',', '.');
            } else {
                $aDadosRet['procomrmax'] = 'N/A';
            }
            if ($oRowDB->comphastma != 0 && $oRowDB->comphastma != null) {
                $aDadosRet['comphastma'] = number_format($oRowDB->comphastma, 2, ',', '.');
            } else {
                $aDadosRet['comphastma'] = 'N/A';
            }
            if ($oRowDB->comphastmi != 0 && $oRowDB->comphastmi != null) {
                $aDadosRet['comphastmi'] = number_format($oRowDB->comphastmi, 2, ',', '.');
            } else {
                $aDadosRet['comphastmi'] = 'N/A';
            }
            if ($oRowDB->diamhastmi != 0 && $oRowDB->diamhastmi != null) {
                $aDadosRet['diamhastmi'] = number_format($oRowDB->diamhastmi, 2, ',', '.');
            } else {
                $aDadosRet['diamhastmi'] = 'N/A';
            }
            if ($oRowDB->diamhastma != 0 && $oRowDB->diamhastma != null) {
                $aDadosRet['diamhastma'] = number_format($oRowDB->diamhastma, 2, ',', '.');
            } else {
                $aDadosRet['diamhastma'] = 'N/A';
            }
            if ($oRowDB->pfcmin != 0 && $oRowDB->pfcmin != null) {
                $aDadosRet['pfcmin'] = number_format($oRowDB->pfcmin, 2, ',', '.');
            } else {
                $aDadosRet['pfcmin'] = 'N/A';
            }
            if ($oRowDB->pfcmax != 0 && $oRowDB->pfcmax != null) {
                $aDadosRet['pfcmax'] = number_format($oRowDB->pfcmax, 2, ',', '.');
            } else {
                $aDadosRet['pfcmax'] = 'N/A';
            }
            if ($oRowDB->proanghel != 0 && $oRowDB->proanghel != null) {
                $aDadosRet['proanghel'] = number_format($oRowDB->proanghel, 2, ',', '.');
            } else {
                $aDadosRet['proanghel'] = 'N/A';
            }

            $aRetorno[] = $aDadosRet;
        }
        return $aRetorno;
    }

    function buscaSubG($sDados) {
        $sSql = 'select subcod, subdes from widl.prod05 where grucod = ' . $sDados . ' and subcod not in(9,128,150,151,152,153,401,404,409,410,419,512,513,542,543,544,545,546,547,549,550,551,552,554,555,800,802,803,804,805,807,808,809)';
        $result = $this->getObjetoSql($sSql);
        $aRetorno = array();
        $aDadosRet = array();
        while ($oRowDB = $result->fetch(PDO::FETCH_OBJ)) {
            $aDadosRet['cod'] = trim($oRowDB->subcod);
            $aDadosRet['desc'] = trim($oRowDB->subdes);
            $aRetorno[] = $aDadosRet;
        }
        return $aRetorno;
    }

    function buscaFam($aDados) {
        $sSql = 'select famcod, famdes from widl.PROD04A where grucod = ' . $aDados[0] . ' and subcod=' . $aDados[1];
        $result = $this->getObjetoSql($sSql);
        $aRetorno = array();
        $aDadosRet = array();
        while ($oRowDB = $result->fetch(PDO::FETCH_OBJ)) {
            $aDadosRet['cod'] = trim($oRowDB->famcod);
            $aDadosRet['desc'] = trim($oRowDB->famdes);
            $aRetorno[] = $aDadosRet;
        }
        return $aRetorno;
    }

    function buscaSubF($aDados) {
        $sSql = 'select famsub, famsdes from widl.PROD04A1 where grucod = ' . $aDados[0] . ' and subcod=' . $aDados[1] . ' and famcod = ' . $aDados[2];
        $result = $this->getObjetoSql($sSql);
        $aRetorno = array();
        $aDadosRet = array();
        while ($oRowDB = $result->fetch(PDO::FETCH_OBJ)) {
            $aDadosRet['cod'] = trim($oRowDB->famsub);
            $aDadosRet['desc'] = trim($oRowDB->famsdes);
            $aRetorno[] = $aDadosRet;
        }
        return $aRetorno;
    }


    function buscaCarrinho($aDados) {


        $PDOnew = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

        $aRet01 = $PDOnew->exec('drop table #MetTecCxNormal');
        $aRet02 = $PDOnew->exec('drop table #MetTecCxMaster');
        $aRet03 = $PDOnew->exec('drop table #MetTecSaco');

        $sSql = 'create table #MetTecCxNormal( '
                . 'procod integer not null, '
                . 'cxnormal money) ';
        $aRet04 = $PDOnew->exec($sSql);

        $sSql = 'create table #MetTecCxMaster( '
                . 'procod integer not null, '
                . 'cxmaster money) ';
        $aRet05 = $PDOnew->exec($sSql);

        $sSql = 'create table #MetTecSaco( '
                . 'procod integer not null, '
                . 'saco money) ';
        $aRet06 = $PDOnew->exec($sSql);

        $aRetorno = array();
        $aDadosRet = array();
        foreach ($aDados as $key => $value) {

            $aItem = explode('|', $value);

            $sSql = "insert into #MetTecCxNormal (procod,cxnormal) "
                    . "select widl.prod01.procod,pcs "
                    . "from widl.prod01 "
                    . "left outer join pdftabvendas on widl.prod01.procod = pdftabvendas.codigo "
                    . "left outer join metmat on widl.prod01.procod = metmat.procod "
                    . "left outer join tbean on widl.prod01.procod = tbean.codigo "
                    . "where widl.prod01.procod =" . $aItem[0] . " "
                    . "and tbean.inativo <> 's' "
                    . "and caixa = 'NORMAL'";
            $aRet07 = $PDOnew->exec($sSql);

            $sSql = "insert into #MetTecCxMaster (procod,cxmaster) "
                    . "select widl.prod01.procod,pcs "
                    . "from widl.prod01 "
                    . "left outer join pdftabvendas on widl.prod01.procod = pdftabvendas.codigo "
                    . "left outer join metmat on widl.prod01.procod = metmat.procod "
                    . "left outer join tbean on widl.prod01.procod = tbean.codigo "
                    . "where widl.prod01.procod =" . $aItem[0] . " "
                    . "and tbean.inativo <> 's' "
                    . "and caixa = 'MASTER'";
            $aRet08 = $PDOnew->exec($sSql);

            $sSql = "insert into #MetTecSaco (procod,saco) "
                    . "select widl.prod01.procod,pcs "
                    . "from widl.prod01 "
                    . "left outer join pdftabvendas on widl.prod01.procod = pdftabvendas.codigo "
                    . "left outer join metmat on widl.prod01.procod = metmat.procod "
                    . "left outer join tbean on widl.prod01.procod = tbean.codigo "
                    . "where widl.prod01.procod =" . $aItem[0] . " "
                    . "and tbean.inativo <> 's' "
                    . "and caixa = 'SACO'";
            $aRet09 = $PDOnew->exec($sSql);

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//   

            $sSql = "select cxnormal,cxmaster,saco,widl.prod01.procod,pdftabvendas.preco,prodes,pround,promatcod,ProClasseG,widl.prod05.media,"
                    . "metmat.material,prodchamin,prodchamax,prodchamin,prodchamax,prodaltmin,prodaltmax,proddiamin,proddiamax,procommin,procommax,"
                    . "prodiapmin,prodiapmax,prodiaemin,prodiaemax,procomrmin,procomrmax,comphastma,comphastmi,diamhastmi,diamhastma,pfcmin,pfcmax,proanghel "
                    . "from widl.prod01 "
                    . "left outer join pdftabvendas on widl.prod01.procod = pdftabvendas.codigo "
                    . "left outer join widl.prod05 on widl.prod01.subcod = widl.prod05.subcod "
                    . "left outer join metmat on widl.prod01.procod = metmat.procod "
                    . "left outer join #MetTecCxNormal on widl.prod01.procod = #MetTecCxNormal.procod "
                    . "left outer join #MetTecCxMaster on widl.prod01.procod = #MetTecCxMaster.procod "
                    . "left outer join #MetTecSaco on widl.prod01.procod = #MetTecSaco.procod "
                    . "where widl.prod01.procod =" . $aItem[0];

            $result = $PDOnew->query($sSql);

            $oRowDB = $result->fetchObject();

            $aDadosRet['procod'] = trim($oRowDB->procod);
            $aDadosRet['prodes'] = trim($oRowDB->prodes);
            $aDadosRet['pround'] = trim($oRowDB->pround);
            $aDadosRet['promatcod'] = trim($oRowDB->promatcod);
            $aDadosRet['media'] = trim($oRowDB->media);
            $aDadosRet['material'] = trim($oRowDB->material);
            $aDadosRet['classe'] = trim($oRowDB->ProClasseG);
            $aDadosRet['preco'] = trim(number_format($oRowDB->preco, 2, ',', '.'));
            $aDadosRet['quant'] = $aItem[1];
            $aDadosRet['precoItem'] = $aItem[2];

            if ($oRowDB->cxnormal != 0 && $oRowDB->cxnormal != null) {
                $aDadosRet['cxnormal'] = number_format($oRowDB->cxnormal, 0, ',', '.');
            } else {
                $aDadosRet['cxnormal'] = 'N/A';
            }
            if ($oRowDB->cxmaster != 0 && $oRowDB->cxmaster != null) {
                $aDadosRet['cxmaster'] = number_format($oRowDB->cxmaster, 0, ',', '.');
            } else {
                $aDadosRet['cxmaster'] = 'N/A';
            }
            if ($oRowDB->saco != 0 && $oRowDB->saco != null) {
                $aDadosRet['saco'] = number_format($oRowDB->saco, 0, ',', '.');
            } else {
                $aDadosRet['saco'] = 'N/A';
            }
            if ($oRowDB->prodchamin != 0 && $oRowDB->prodchamin != null) {
                $aDadosRet['prodchamin'] = number_format($oRowDB->prodchamin, 2, ',', '.');
            } else {
                $aDadosRet['prodchamin'] = 'N/A';
            }
            if ($oRowDB->prodchamax != 0 && $oRowDB->prodchamax != null) {
                $aDadosRet['prodchamax'] = number_format($oRowDB->prodchamax, 2, ',', '.');
            } else {
                $aDadosRet['prodchamax'] = 'N/A';
            }
            if ($oRowDB->prodaltmin != 0 && $oRowDB->prodaltmin != null) {
                $aDadosRet['prodaltmin'] = number_format($oRowDB->prodaltmin, 2, ',', '.');
            } else {
                $aDadosRet['prodaltmin'] = 'N/A';
            }
            if ($oRowDB->prodaltmax != 0 && $oRowDB->prodaltmax != null) {
                $aDadosRet['prodaltmax'] = number_format($oRowDB->prodaltmax, 2, ',', '.');
            } else {
                $aDadosRet['prodaltmax'] = 'N/A';
            }
            if ($oRowDB->proddiamin != 0 && $oRowDB->proddiamin != null) {
                $aDadosRet['proddiamin'] = number_format($oRowDB->proddiamin, 2, ',', '.');
            } else {
                $aDadosRet['proddiamin'] = 'N/A';
            }
            if ($oRowDB->proddiamax != 0 && $oRowDB->proddiamax != null) {
                $aDadosRet['proddiamax'] = number_format($oRowDB->proddiamax, 2, ',', '.');
            } else {
                $aDadosRet['proddiamax'] = 'N/A';
            }
            if ($oRowDB->procommin != 0 && $oRowDB->procommin != null) {
                $aDadosRet['procommin'] = number_format($oRowDB->procommin, 2, ',', '.');
            } else {
                $aDadosRet['procommin'] = 'N/A';
            }
            if ($oRowDB->procommax != 0 && $oRowDB->procommax != null) {
                $aDadosRet['procommax'] = number_format($oRowDB->procommax, 2, ',', '.');
            } else {
                $aDadosRet['procommax'] = 'N/A';
            }
            if ($oRowDB->prodiapmin != 0 && $oRowDB->prodiapmin != null) {
                $aDadosRet['prodiapmin'] = number_format($oRowDB->prodiapmin, 2, ',', '.');
            } else {
                $aDadosRet['prodiapmin'] = 'N/A';
            }
            if ($oRowDB->prodiapmax != 0 && $oRowDB->prodiapmax != null) {
                $aDadosRet['prodiapmax'] = number_format($oRowDB->prodiapmax, 2, ',', '.');
            } else {
                $aDadosRet['prodiapmax'] = 'N/A';
            }
            if ($oRowDB->prodiaemin != 0 && $oRowDB->prodiaemin != null) {
                $aDadosRet['prodiaemin'] = number_format($oRowDB->prodiaemin, 2, ',', '.');
            } else {
                $aDadosRet['prodiaemin'] = 'N/A';
            }
            if ($oRowDB->prodiaemax != 0 && $oRowDB->prodiaemax != null) {
                $aDadosRet['prodiaemax'] = number_format($oRowDB->prodiaemax, 2, ',', '.');
            } else {
                $aDadosRet['prodiaemax'] = 'N/A';
            }
            if ($oRowDB->procomrmin != 0 && $oRowDB->procomrmin != null) {
                $aDadosRet['procomrmin'] = number_format($oRowDB->procomrmin, 2, ',', '.');
            } else {
                $aDadosRet['procomrmin'] = 'N/A';
            }
            if ($oRowDB->procomrmax != 0 && $oRowDB->procomrmax != null) {
                $aDadosRet['procomrmax'] = number_format($oRowDB->procomrmax, 2, ',', '.');
            } else {
                $aDadosRet['procomrmax'] = 'N/A';
            }
            if ($oRowDB->comphastma != 0 && $oRowDB->comphastma != null) {
                $aDadosRet['comphastma'] = number_format($oRowDB->comphastma, 2, ',', '.');
            } else {
                $aDadosRet['comphastma'] = 'N/A';
            }
            if ($oRowDB->comphastmi != 0 && $oRowDB->comphastmi != null) {
                $aDadosRet['comphastmi'] = number_format($oRowDB->comphastmi, 2, ',', '.');
            } else {
                $aDadosRet['comphastmi'] = 'N/A';
            }
            if ($oRowDB->diamhastmi != 0 && $oRowDB->diamhastmi != null) {
                $aDadosRet['diamhastmi'] = number_format($oRowDB->diamhastmi, 2, ',', '.');
            } else {
                $aDadosRet['diamhastmi'] = 'N/A';
            }
            if ($oRowDB->diamhastma != 0 && $oRowDB->diamhastma != null) {
                $aDadosRet['diamhastma'] = number_format($oRowDB->diamhastma, 2, ',', '.');
            } else {
                $aDadosRet['diamhastma'] = 'N/A';
            }
            if ($oRowDB->pfcmin != 0 && $oRowDB->pfcmin != null) {
                $aDadosRet['pfcmin'] = number_format($oRowDB->pfcmin, 2, ',', '.');
            } else {
                $aDadosRet['pfcmin'] = 'N/A';
            }
            if ($oRowDB->pfcmax != 0 && $oRowDB->pfcmax != null) {
                $aDadosRet['pfcmax'] = number_format($oRowDB->pfcmax, 2, ',', '.');
            } else {
                $aDadosRet['pfcmax'] = 'N/A';
            }
            if ($oRowDB->proanghel != 0 && $oRowDB->proanghel != null) {
                $aDadosRet['proanghel'] = number_format($oRowDB->proanghel, 2, ',', '.');
            } else {
                $aDadosRet['proanghel'] = 'N/A';
            }

            $aRetorno[] = $aDadosRet;
        }
        return $aRetorno;
    }

}
