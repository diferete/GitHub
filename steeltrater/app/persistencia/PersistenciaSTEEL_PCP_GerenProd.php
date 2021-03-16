<?php

/*
 * Classe que gerencia produção steeltrater
 * @author Avanei Martendal
 * @since 27/08/2019
 */

Class PersistenciaSTEEL_PCP_GerenProd extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_ordensFabApont');
    }

    public function geraProdEtapas($aDados) {
        $sSqlDados = ' select ';
        //campos listados
        if ($aDados['busca'] == 'ProdTotal') {
            $sSqlDados .= " tratdesrel,sum(STEEL_PCP_ordensFab.peso) as pesoTotal ";
        }
        if ($aDados['busca'] == 'ProdForno') {
            $sSqlDados .= " STEEL_PCP_ordensFabItens.fornodes,sum(STEEL_PCP_ordensFab.peso) as pesoTotal ";
        }
        //busca nas tabelas
        $sSqlDados .= "  from STEEL_PCP_ordensFabItens left outer join STEEL_PCP_ordensFab
         on STEEL_PCP_ordensFabItens.op = STEEL_PCP_ordensFab.op left outer join STEEL_PCP_tratamentos
         on STEEL_PCP_ordensFabItens.tratamento = STEEL_PCP_tratamentos.tratcod left outer join STEEL_PCP_receitasItens
         on STEEL_PCP_ordensFabItens.receita = STEEL_PCP_receitasItens.cod
         and STEEL_PCP_ordensFabItens.receita_seq = STEEL_PCP_receitasItens.seq ";

        //condições
        $sSqlDados .= "where dataent_forno between '" . $aDados['dataini'] . "' and '" . $aDados['datafin'] . "' 
					and STEEL_PCP_ordensFabItens.situacao in('Finalizado','Processo')
		                        and retrabalho<>'Retorno não Ind.' and STEEL_PCP_receitasItens.recApont = 'SIM' "; //<===SOMENTE ETAPAS MARCADAS COMO RECEBE APONT.
        if (isset($aDados['tipoOp'])) {
            $sSqlDados .= " and STEEL_PCP_ordensFab.tipoOrdem IN (" . $aDados['tipoOp'] . ") ";
        }
        if ($aDados['busca'] == 'ProdTotal') {
            $sSqlDados .= " group by tratamento,tratdesrel";
        }
        if ($aDados['busca'] == 'ProdForno') {
            $sSqlDados .= " group by STEEL_PCP_ordensFabItens.fornodes";
        }

        $result = $this->getObjetoSql($sSqlDados);
        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            if ($aDados['busca'] == 'ProdForno') {
                $aRetorno[$oRowBD->fornodes] = $oRowBD->pesototal;
            }
            if ($aDados['busca'] == 'ProdTotal') {
                $aRetorno[$oRowBD->tratdesrel] = $oRowBD->pesototal;
            }
        }
        //faz o retorno dos dados
        return $aRetorno;
    }

    public function geraGerenProd($aDados) {
        $sSqlDados = ' select ';
        //campos listados
        if ($aDados['busca'] == 'ProdTotal') {
            $sSqlDados .= " sum(STEEL_PCP_ordensFab.peso) as pesoTotal ";
        }
        //se busca por producao de forno
        if ($aDados['busca'] == 'ProdForno') {
            $sSqlDados .= " fornodes,sum(STEEL_PCP_ordensFab.peso) as pesoTotal ";
        }
        //busca nas tabelas
        $sSqlDados .= " from STEEL_PCP_ordensFabApont left outer join STEEL_PCP_ordensFab
               on STEEL_PCP_ordensFabApont.op = STEEL_PCP_ordensFab.op ";

        //condições
        $sSqlDados .= "where dataent_forno between '" . $aDados['dataini'] . "' and '" . $aDados['datafin'] . "' 
					and STEEL_PCP_ordensFabApont.situacao='Finalizado'  
					and retrabalho<>'Retorno não Ind.'";
        if (isset($aDados['tipoOp'])) {
            $sSqlDados .= " and STEEL_PCP_ordensFab.tipoOrdem IN (" . $aDados['tipoOp'] . ") ";
        }
        //agrupamentos necessário
        if ($aDados['busca'] == 'ProdForno') {
            $sSqlDados .= " 	group by fornodes,fornocod order by fornocod  ";
        }

        $result = $this->getObjetoSql($sSqlDados);

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            if ($aDados['busca'] == 'ProdTotal') {
                $aRetorno['pesoTotal'] = $oRowBD->pesototal;
            }
            if ($aDados['busca'] == 'ProdForno') {
                $aRetorno[$oRowBD->fornodes] = $oRowBD->pesototal;
            }
        }

        //faz o retorno dos dados
        return $aRetorno;
    }

    //pega produçao para o app
    public function getProdApp($dataInicial, $dataFinal) {

        $sSql = "select  dataent_forno,convert(varchar,dataent_forno,103) as dataconv,
                    sum(STEEL_PCP_ordensFab.peso)as pesototal  
                    from STEEL_PCP_ordensFabApont left outer join STEEL_PCP_ordensFab
                    on STEEL_PCP_ordensFabApont.op = STEEL_PCP_ordensFab.op 
                    where dataent_forno between '" . $dataInicial . "' and '" . $dataFinal . "' 
                    and STEEL_PCP_ordensFabApont.situacao='Finalizado'  
                    and retrabalho<>'Retorno não Ind.'
                    group by dataent_forno
                    order by dataent_forno desc";

        $result = $this->getObjetoSql($sSql);
        $aRetorno = array();
        $aDados = array();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados['data'] = $row->dataconv;
            $aDados['peso'] = number_format($row->pesototal, '2', ',', '.');
            $aRetorno[] = $aDados;
        }


        return $aRetorno;
    }

}
