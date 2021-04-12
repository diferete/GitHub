<?php

/*
 * Classe que retorna o faturamento para listar nos aplicativos
 */

class PersistenciaMET_TEC_MobileFat extends Persistencia {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Busca painéis da tela inicial do app
     */
    public function getPainelApp() {
        $sSql = "select MET_TEC_MobilePainelUser.usucodigo,
                MET_TEC_MobilePainelUser.painelcod,
                MET_TEC_MobilePainel.paineldesc 
                from MET_TEC_MobilePainelUser(nolock) left outer join MET_TEC_MobilePainel(nolock)
                on MET_TEC_MobilePainelUser.painelcod = MET_TEC_MobilePainel.painelcod
                where usucodigo ='" . $_SESSION['codUser'] . "' ";

        $result = $this->getObjetoSql($sSql);
        $aRetorno = array();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aRetorno[$row->painelcod] = $row->paineldesc;
        }
        return $aRetorno;
    }

    /**
     * Busca totalizadores de faturamento para alimentar o aplicativo
     */
    public function getTotalFat($sDataIni, $sDataFim) {

        $sSql = "select SUM(vlrLiquido - Exportacao - Sucata) as 'vlrliquido', 
            SUM(VlrLiquido+VlrIpi+Sucata)as 'vlrtotalapp', 
            SUM(metfat_metalbo.vlripi) as 'vlripi', 
            SUM(metfat_metalbo.exportacao) as 'exportacao', 
            SUM(metfat_metalbo.sucata) as 'sucata', 
            SUM(metfat_metalbo.devolucao) as 'devolucao', 
            SUM(metfat_metalbo.pesodev) as 'pesodev',
            SUM(Pesotudo - PesoSucata - pesodev) as 'PesoLiquido', 
            SUM((vlrliquido - sucata)/(Pesotudo - PesoSucata - pesodev))as 'mediaSipi', 
            SUM((vlrliquido - sucata + vlripi)/(Pesotudo - PesoSucata - pesodev))as 'mediaCipi' 
            from rex_maquinas.dbo.metfat_metalbo(nolock)  
            where DATA between '" . $sDataIni . "' and '" . $sDataFim . "' ";

        $result = $this->getObjetoSql($sSql);

        $aRetorno = array();

        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aRetorno['vlrliquido'] = $row->vlrliquido;
            $aRetorno['vlripi'] = $row->vlripi;
            $aRetorno['exportacao'] = $row->exportacao;
            $aRetorno['sucata'] = $row->sucata;
            $aRetorno['devolucao'] = $row->devolucao;
            $aRetorno['pesodev'] = $row->pesodev;
            $aRetorno['PesoLiquido'] = $row->pesoliquido;
            $aRetorno['mediaSipi'] = $row->mediasipi;
            $aRetorno['mediaCipi'] = $row->mediacipi;
        }

        return $aRetorno;
    }

    /**
     * Busca faturamento do mês 
     */
    public function getFatMensal($sDataIni, $sDataFim) {
        $sSql = "select  metfat_metalbo.data AS 'data',
            convert(varchar,metfat_metalbo.data,103) AS 'dataconv',
            (vlrLiquido - Exportacao - Sucata) as 'vlrliquido',
            metfat_metalbo.vlripi as 'vlripi',
            metfat_metalbo.exportacao as 'exportacao',
            metfat_metalbo.sucata as 'sucata',
            metfat_metalbo.devolucao as 'devolucao',
            metfat_metalbo.pesodev as 'pesodev',
            (Pesotudo - PesoSucata - pesodev) as 'PesoLiquido',
            (Pesotudo - PesoSucata - pesodev)/1000 as 'PesoTon',
            ((vlrliquido - sucata)/(Pesotudo - PesoSucata - pesodev))as 'mediaSipi',
            ((vlrliquido - sucata + vlripi)/(Pesotudo - PesoSucata - pesodev))as 'mediaCipi' 
            from rex_maquinas.dbo.metfat_metalbo(nolock) where DATA between '" . $sDataIni . "' and '" . $sDataFim . "' 
            order by data desc ";

        $result = $this->getObjetoSql($sSql);

        $aRetorno = array();
        $aDados = array();

        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados['dataconv'] = $row->dataconv;
            $aDados['vlrliquido'] = number_format($row->vlrliquido, 2, ',', '.');
            $aDados['vlripi'] = number_format($row->vlripi, 2, ',', '.');
            $aDados['exportacao'] = number_format($row->exportacao, 2, ',', '.');
            $aDados['sucata'] = number_format($row->sucata, 2, ',', '.');
            $aDados['pesodev'] = number_format($row->pesodev, 2, ',', '.');
            $aDados['PesoLiquido'] = number_format($row->pesoliquido, 2, ',', '.');
            $aDados['PesoTon'] = number_format($row->pesoton, 2, ',', '.');
            $aDados['mediaSipi'] = number_format($row->mediasipi, 2, ',', '.');
            $aDados['mediaCipi'] = number_format($row->mediacipi, 2, ',', '.');
            $aRetorno[] = $aDados;
        }

        return $aRetorno;
    }

    /**
     * Retorna pedidos
     */
    public function getPedidos($sDataIni, $sDataFim) {
        $sSql = "select metpedonlineShow.data as 'data', 
                convert(varchar,metpedonlineShow.data,103) as 'dataconv',
                metpedonlineShow.nr as 'nr',
                metpedonlineShow.peso as 'peso', 
                (select SUM(peso)from rex_maquinas.dbo.metpedonlineShow ped2 where metpedonlineShow.seq >= ped2.seq and DATA between '" . $sDataIni . "' and '" . $sDataFim . "' )as 'contpeso', 
                metpedonlineShow.vlr as 'vlr',
                metpedonlineShow.ipi as 'ipi',
                metpedonlineShow.vlrcompipi as 'vlrcomipi', 
                (select SUM(vlrcompipi)from rex_maquinas.dbo.metpedonlineShow ped2 
                where metpedonlineShow.seq >= ped2.seq and DATA between '" . $sDataIni . "' and '" . $sDataFim . "' )as 'contvlr',
                (vlr / peso) as 'mediaSipi',
                (vlrcompipi / peso) as 'mediaCipi',
                metpedonlineShow.datahora as 'datahora'
                from rex_maquinas.dbo.metpedonlineShow(nolock) where DATA between '" . $sDataIni . "' and '" . $sDataFim . "' order by data desc";

        $result = $this->getObjetoSql($sSql);
        $aRetorno = array();
        $aDados = array();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados['dataconv'] = $row->dataconv;
            $aDados['nr'] = $row->nr;
            $aDados['peso'] = number_format($row->peso, 2, ',', '.');
            $aDados['contpeso'] = number_format($row->contpeso, 2, ',', '.');
            $aDados['vlr'] = number_format($row->vlr, 2, ',', '.');
            $aDados['ipi'] = number_format($row->ipi, 2, ',', '.');
            $aDados['vlrcomipi'] = number_format($row->vlrcomipi, 2, ',', '.');
            $aDados['contvlr'] = number_format($row->contvlr, 2, ',', '.');

            $aDados['mediaSipi'] = number_format($row->mediasipi, 2, ',', '.');
            $aDados['mediaCipi'] = number_format($row->mediacipi, 2, ',', '.');

            $aRetorno[] = $aDados;
        }
        return $aRetorno;
    }

    /**
     * Busca pedidos mensal
     */
    public function getPedidosSoma($sDataIni, $sDataFim) {
        $sSql = "  select sum(metpedonlineShow.peso) as 'peso', 
                sum(metpedonlineShow.vlrcompipi) as 'vlrcomipi'
                from rex_maquinas.dbo.metpedonlineShow(nolock) 
                where DATA between '" . $sDataIni . "' and '" . $sDataFim . "' ";

        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);

        $aRetorno = array();
        $aRetorno['pesoMes'] = number_format($row->peso, 2, ',', '.');
        $aRetorno['vlrcomipi'] = number_format($row->vlrcomipi, 2, ',', '.');

        return $aRetorno;
    }

    /**
     * Busca produção
     */
    public function getProdMetalbo($sDataIni, $sDataFim, $sCnpj) {
        $PDOnew = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

        $sSql = ' begin try '
                . '  drop table #total '
                . '  end try '
                . '  begin catch '
                . '  end catch '
                . '  create table #total( '
                . '             data date, '
                . '    total money  )';
        $aRetorno = $PDOnew->exec($sSql);


        $sSql = "insert into #total 
        SELECT   convert(varchar,MetProd_Cab.data ,103)as data ,SUM (total) as total 
          FROM rex_maquinas.dbo.MetProd_Cab left OUTER JOIN 
          rex_maquinas.dbo.MetProd_ItensCab on  MetProd_Cab.id = MetProd_ItensCab.id  
          left outer join rex_maquinas.dbo.metmaq on  MetProd_ItensCab.codmaq = metmaq.cod 
          where MetProd_Cab.data  BETWEEN '" . $sDataIni . "'  AND '" . $sDataFim . "' 
          AND maqtip IN (select maqtip from rex_maquinas.dbo.metmaq where  maqtip IN('PO','PF','MQ') ) 
		  AND MetProd_ItensCab.empcnpj ='" . $sCnpj . "' 
		  group by MetProd_Cab.data order by MetProd_Cab.data";
        $aRetorno = $PDOnew->exec($sSql);

        $sSql = " begin try 
         drop table #po
          end try
          begin catch
          end catch   
          create table #po( 
                    data date, 
                    total money  )  ";
        $aRetorno = $PDOnew->exec($sSql);

        $sSql = "insert into #po 
        SELECT   convert(varchar,MetProd_Cab.data ,103)as data ,SUM (total) as total 
          FROM rex_maquinas.dbo.MetProd_Cab left OUTER JOIN 
          rex_maquinas.dbo.MetProd_ItensCab on  MetProd_Cab.id = MetProd_ItensCab.id  
          left outer join rex_maquinas.dbo.metmaq on  MetProd_ItensCab.codmaq = metmaq.cod 
          where MetProd_Cab.data  BETWEEN '" . $sDataIni . "'  AND '" . $sDataFim . "'  
          AND maqtip IN (select maqtip from rex_maquinas.dbo.metmaq where  maqtip IN('PO')and maquina <> 'rosq' )
          AND MetProd_ItensCab.empcnpj ='" . $sCnpj . "'
          group by MetProd_Cab.data 
		  order by MetProd_Cab.data ";
        $aRetorno = $PDOnew->exec($sSql);

        $sSql = "begin try 
         drop table #pf
         end try
		 begin catch
		 end catch
         create table #pf( 
                    data date, 
                    total money )";
        $aRetorno = $PDOnew->exec($sSql);

        $sSql = "insert into #pf 
         SELECT   convert(varchar,MetProd_Cab.data ,103)as data ,SUM (total) as total 
           FROM rex_maquinas.dbo.MetProd_Cab left OUTER JOIN 
           rex_maquinas.dbo.MetProd_ItensCab on  MetProd_Cab.id = MetProd_ItensCab.id 
           left outer join rex_maquinas.dbo.metmaq on  MetProd_ItensCab.codmaq = metmaq.cod 
           where rex_maquinas.dbo.MetProd_Cab.data  BETWEEN '" . $sDataIni . "'  AND '" . $sDataFim . "'  
		   AND maqtip = 'PF' AND MetProd_ItensCab.empcnpj ='" . $sCnpj . "'
           group by MetProd_Cab.data 
		   order by MetProd_Cab.data ";
        $aRetorno = $PDOnew->exec($sSql);

        $sSql = " begin try  
	     drop table #mq
         end try
		 begin catch
		 end catch
		 create table #mq( 
                    data date, 
                    total money  )";
        $aRetorno = $PDOnew->exec($sSql);

        $sSql = " insert into #mq 
        SELECT   convert(varchar,MetProd_Cab.data ,103)as data ,SUM (total) as total 
          FROM rex_maquinas.dbo.MetProd_Cab left OUTER JOIN 
          rex_maquinas.dbo.MetProd_ItensCab on  MetProd_Cab.id = MetProd_ItensCab.id  
          left outer join rex_maquinas.dbo.metmaq on  MetProd_ItensCab.codmaq = metmaq.cod 
          where MetProd_Cab.data  BETWEEN '" . $sDataIni . "'  AND '" . $sDataFim . "'  
          and maquina not in (select maquina from rex_maquinas.dbo.metmaq where maqtip = 'PRENSA') 
          and maquina not in (select maquina from rex_maquinas.dbo.metmaq where maquina  like '%cnc%') 
		  	AND maqtip = 'mq'  AND MetProd_ItensCab.empcnpj ='" . $sCnpj . "'
           group by MetProd_Cab.data 
		   order by MetProd_Cab.data ";
        $aRetorno = $PDOnew->exec($sSql);

        $sSql = "begin try
		 drop table #rq
         end try
         begin catch
         end catch
         create table #rq( 
                    data date, 
                    total money  )";
        $aRetorno = $PDOnew->exec($sSql);

        $sSql = "insert into #rq 
         SELECT   convert(varchar,MetProd_Cab.data ,103)as data ,SUM (total) as total 
          FROM rex_maquinas.dbo.MetProd_Cab left OUTER JOIN 
          rex_maquinas.dbo.MetProd_ItensCab on  MetProd_Cab.id = MetProd_ItensCab.id  
          left outer join rex_maquinas.dbo.metmaq on  MetProd_ItensCab.codmaq = metmaq.cod 
          where MetProd_Cab.data  BETWEEN '" . $sDataIni . "'  AND '" . $sDataFim . "'  
          and maquina not in (select maquina from rex_maquinas.dbo.metmaq where maqtip = 'PRENSA') 
          and maquina not in (select maquina from rex_maquinas.dbo.metmaq where maquina  like '%cnc%') 
		  AND maqtip = 'rosq' AND MetProd_ItensCab.empcnpj ='" . $sCnpj . "'
          group by MetProd_Cab.data 
		  order by MetProd_Cab.data ";
        $aRetorno = $PDOnew->exec($sSql);

        $sSql = " SELECT convert(varchar,#total.data ,103)as data ,
             #TOTAL.total as totalsemrosq,
             #pf.total as parafuso, 
             #po.total as porca,
             #mq.total as maqquente,
             #rq.total as rosq
             FROM #total LEFT OUTER JOIN #pf 
             ON #total.data = #pf.data left outer join #po on  
             #total.data = #po.data left outer join #mq on 
             #total.data = #mq.data left outer join #rq on 
             #total.data = #rq.data order by data desc ";

        $result = $PDOnew->query($sSql);
        $aDados = array();
        $aDadosGrid = array();
        $aDadosRet = array();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados['dataconv'] = $row->data;
            $aDados['totalsemrosq'] = number_format($row->totalsemrosq, 2, ',', '.');
            $aDados['parafuso'] = number_format($row->parafuso, 2, ',', '.');
            $aDados['porca'] = number_format($row->porca, 2, ',', '.');
            $aDados['maqquente'] = number_format($row->maqquente, 2, ',', '.');
            $aDados['rosq'] = number_format($row->rosq, 2, ',', '.');
            $aDadosRet['diario'][] = $aDados;
        }

        //totalizadores
        $sSql = "SELECT 
             sum(#TOTAL.total) as totalsemrosq,
             sum(#pf.total) as parafuso, 
             sum(#po.total) as porca,
             sum(#mq.total) as maqquente,
             sum(#rq.total) as rosq
             FROM #total LEFT OUTER JOIN #pf 
             ON #total.data = #pf.data left outer join #po on  
             #total.data = #po.data left outer join #mq on 
             #total.data = #mq.data left outer join #rq on 
             #total.data = #rq.data";
        $result = $PDOnew->query($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);

        $aDadosRet['total']['totalsemrosq'] = number_format($row->totalsemrosq, 2, ',', '.');
        $aDadosRet['total']['parafuso'] = number_format($row->parafuso, 2, ',', '.');
        $aDadosRet['total']['porca'] = number_format($row->porca, 2, ',', '.');
        $aDadosRet['total']['maqquente'] = number_format($row->maqquente, 2, ',', '.');
        $aDadosRet['total']['rosq'] = number_format($row->rosq, 2, ',', '.');

        return $aDadosRet;
    }

    /**
     * Busca faturamento do mês 
     */
    public function getListaEspera($sDataIni, $sDataFim) {
        $sSql = "select top(50) seq,CONVERT(varchar,datalista,103)as datalista,
                seqprio,codmt,descmat,nrbobina,pesobo,
                saldobob,setor,situacao,usucad,
                convert(varchar,datacad,103) as datacad,
                horacad,empresa,codigooi, descoi,pesonota,prisma
                from rex_maquinas.dbo.tblistafosft where situacao ='Liberado'  
                order by seqprio ";

        $result = $this->getObjetoSql($sSql);

        $aRetorno = array();
        $aDados = array();

        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados['seq'] = $row->seq;
            $aDados['datalista'] = $row->datalista;
            $aDados['seqprio'] = $row->seqprio;
            $aDados['codmt'] = $row->codmt;
            $aDados['descmat'] = $row->descmat;
            $aDados['nrbobina'] = $row->nrbobina;
            $aDados['pesobo'] = $row->pesobo;
            $aDados['saldobob'] = $row->saldobob;
            $aDados['setor'] = $row->setor;
            $aDados['situacao'] = $row->situacao;
            $aDados['usucad'] = $row->usucad;
            $aDados['datacad'] = $row->datacad;
            $aDados['horacad'] = $row->horacad;
            $aDados['empresa'] = $row->empresa;
            $aDados['codigooi'] = $row->codigooi;
            $aDados['descoi'] = $row->descoi;
            $aDados['pesonota'] = $row->pesonota;
            $aDados['prisma'] = $row->prisma;
            $aRetorno[] = $aDados;
        }

        return $aRetorno;
    }

    /**
     * Retorna a contagem dos liberados na lista
     */
    public function getCountLista() {
        $sSql = "select COUNT(*) as count
                from rex_maquinas.dbo.tblistafosft
                where situacao ='Liberado'  ";

        $result = $this->getObjetoSql($sSql);

        $aRetorno = array();
        $aDados = array();

        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados['count'] = $row->count;
        }

        $aRetorno = $aDados['count'];

        return $aRetorno;
    }

    /**
     * faz o update na tabela da lista da fosfatização
     */
    public function setListaLiberado($aDados) {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date("d/m/y");                     //função para pegar a data e hora local
        $hora = date("H:i");
        $useRel = $_SESSION['nome'];
        $sSql = "update rex_maquinas.dbo.tblistafosft set usulibempilhadeira ='" . $aDados['nome'] . "', datalibempilhadeira ='" . $data . "',"
                . " horalibempilhadeira ='" . $hora . "', situacao = 'Pátio' where seq ='" . $aDados['seq'] . "'   ";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

}
