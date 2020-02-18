<?php

/**
 * Classe que implementa a persistência genérica do sistema
 * 
 * @author Fernando Salla
 * @since 21/06/2012 
 */
//inclusão das bibliotecas de persistência
Fabrica::requireBibliotecaPersistencia('CampoBanco');
Fabrica::requireBibliotecaPersistencia('Lista');

class Persistencia {

    public $Model;
    protected $oConn;
    private $sSchema;
    private $sTabela;
    private $sLimit;
    private $sOffset;
    private $aListaCampos;
    private $aListaTotaliza;
    private $aListaCamposCalculo;
    private $aListaCampoVirtual;
    private $aListaJoin;
    private $aListaWhere;
    private $sSqlWhere;
    private $aGroupBy;
    private $aOrderBy;
    private $aGroupByConsulta;
    private $aOrderByConsulta;
    private $bChaveIncremento;
    private $bConsultaPorSql;
    private $bConsultaManual;
    private $sTop;
    private $sWhereManual;
    private $sCase;
    //tipos de junções (JOIN) entre as tabelas aceitos pelo sistema
    public static $TIPO_JOIN = array(" INNER JOIN ", " LEFT JOIN ", " RIGHT JOIN ");

    //constantes individuais de junções
    const INNER_JOIN = 0;
    const LEFT_JOIN = 1;
    const RIGHT_JOIN = 2;

    //tipos de ligações entre as comparações nas cláusulas WHERE e JOIN
    public static $TIPO_LIGACAO = array(" AND ", " OR ");

    //constantes individuais de ligações
    const LIGACAO_AND = 0;
    const LIGACAO_OR = 1;

    //tipos de comparação de campos nas cláusulas WHERE e JOIN
    public static $TIPO_COMPARACAO = array(" = ", " > ", " >= ", " < ", " <= ", " BETWEEN ", " LIKE ", " LIKE ", " LIKE ", " IN ", " <> ");

    //constantes individuais de comparação
    const IGUAL = 0;
    const MAIOR = 1;
    const MAIOR_IGUAL = 2;
    const MENOR = 3;
    const MENOR_IGUAL = 4;
    const ENTRE = 5;
    const CONTEM = 6;
    const INICIA_COM = 7;
    const TERMINA_COM = 8;
    const GRUPO = 9;
    const DIFERENTE = 10;

    //tipos de totalização de campos
    public static $TIPO_TOTALIZA = array("SUM", "AVG", "COUNT", "MIN", "MAX");

    //constantes individuais de totalizadores
    const TOTALIZA_SOMA = 0;
    const TOTALIZA_MEDIA = 1;
    const TOTALIZA_CONTA = 2;
    const TOTALIZA_MINIMO = 3;
    const TOTALIZA_MAXIMO = 4;
    //constantes individuais de ordenação
    const ASC = 0;
    const DESC = 1;
    //complementos do nome campo tipo lista
    const COMPLETA_NOME_LISTA = '_desc';
    const COMPLETA_NOME_CHAVE_LISTA = '_cod';

    /**
     * Construtor da classe Persistencia 
     */
    public function __construct() {
        $this->aListaCampos = array();
        $this->aListaTotaliza = array();
        $this->aListaCamposCalculo = array();
        $this->aListaCampoVirtual = array();
        $this->aListaJoin = array();
        $this->aListaWhere = array();
        $this->aGroupBy = array();
        $this->aOrderBy = array();
        $this->aGroupByConsulta = array();
        $this->aOrderByConsulta = array();
        $this->bChaveIncremento = true;
        $this->setConsultaPorSql(false);

        $this->oConn = Conexao::getConexao();
        $this->setBConsultaManual(false);
        $this->setSTop('500');
    }

    /**
     * Método que retorna o tipo de banco de dados que está conectado no momento
     * 
     * @return integer
     */
    public function getTipoBDConexao() {
        $sDriver = $this->oConn->getAttribute(PDO::ATTR_DRIVER_NAME);
        $iRetorno = 0;

        switch ($sDriver) {
            case "mysql":
                $iRetorno = Config::BD_MYSQL;
                break;
            case "pgsql":
                $iRetorno = Config::BD_POSTGRESQL;
                break;
            case "sqlsrv":
                $iRetorno = Config::BD_SQLSERVER;
                break;
        }
        return $iRetorno;
    }

    function getSCase() {
        return $this->sCase;
    }

    function setSCase($sCase) {
        $this->sCase = $sCase;
    }

    /**
     * Método que ativa a consulta por query manual
     */
    public function getBConsultaManual() {
        return $this->bConsultaManual;
    }

    public function setBConsultaManual($bConsultaManual) {
        $this->bConsultaManual = $bConsultaManual;
    }

    /**
     * 
     * Método que realiza a edição dos parâmetros responsáveis pelo cálculo sq
     * @param Nome do campo que será utilizado 
     * @param Tipo do cálculo a ser realizado
     * SOMA   = 0;
     * MEDIA  = 1;
     * CONTA  = 2;
     * MINIMO = 3;
     * MAXIMO = 4;
     */
    /*
     * Retorna o tipo de calculo por sql
     */
    public function getITipoCalSql() {
        return $this->iTipoCalSql;
    }

    public function setITipoCalSql($iTipoCalSql) {
        $this->iTipoCalSql = $iTipoCalSql;
    }

    /*
     * Retorna o número top
     */

    function getSTop() {
        if (Config::TIPO_BD != Config::BD_MYSQL) {
            $stop = "TOP " . $this->sTop . " ";
        } else {
            $stop = '';
        }
        return $stop;
    }

    function getITop() {
        return $this->sTop;
    }

    /*
     * Seta o número top
     */

    function setSTop($sTop) {
        $this->sTop = $sTop;
    }

    function getSWhereManual() {
        return $this->sWhereManual;
    }

    function setSWhereManual($sWhereManual) {
        $this->sWhereManual = $sWhereManual;
    }

    /**
     * Metodo que realiza a adição dos parâmetros para o somatorio por campo
     * 
     * @return string Description
     */
    public function isConsultaPorSql() {
        return $this->bConsultaPorSql;
    }

    public function setConsultaPorSql($bConsultaPorSql) {
        $this->bConsultaPorSql = $bConsultaPorSql;
    }

    /**
     * Retorna o conteúdo do atributo sSchema
     * 
     * @return string
     */
    public function getSchema() {
        return $this->sSchema;
    }

    /**
     * Define o valor do atributo sSchema
     * 
     * @param integer sSchema 
     */
    public function setSchema($sSchema) {
        $this->sSchema = $sSchema;
    }

    /**
     * Retorna o conteúdo do atributo sTabela, se o atributo sSchema estiver
     * preenchido retorna no formato SCHEMA.TABELA, senão retorna apenas o valor
     * do atributo sTabela
     * 
     * @return string
     */
    public function getTabela() {
        return $this->getSchema() == "" ? $this->sTabela : $this->getSchema() . "." . $this->sTabela;
    }

    /**
     * Define o valor do atributo sTabela
     * 
     * @param integer sTabela 
     */
    public function setTabela($sTabela) {
        $this->sTabela = strtolower($sTabela);
    }

    /**
     * Retorna o conteúdo do atributo sLimit
     * 
     * @return string
     */
    public function getLimit() {
        return $this->sLimit;
    }

    /**
     * Define o valor do atributo sLimit
     * 
     * @param integer sLimit 
     */
    public function setLimit($sLimit) {
        $this->sLimit = $sLimit;
    }

    /**
     * Retorna o conteúdo do atributo sOffset
     * 
     * @return string
     */
    public function getOffset() {
        return $this->sOffset;
    }

    /**
     * Define o valor do atributo sOffset
     * 
     * @param integer sOffset 
     */
    public function setOffset($sOffset) {
        $this->sOffset = $sOffset;
    }

    /**
     * Define o valor do atributo Model
     * 
     * @param object $oModel Model do objeto que se deseja realizar as operações 
     * de persistência
     */
    public function setModel($oModel) {
        $this->Model = $oModel;
    }

    /**
     * Retorna o conteúdo do atributo bChaveIncremento
     * 
     * @return boolean
     */
    public function getChaveIncremento() {
        return $this->bChaveIncremento;
    }

    /**
     * Define o valor do atributo bChaveIncremento
     * Indica ao sistema se deve utilizar os campos setados da chave para 
     * realizar a busca do incremento de outro campo da chave, utilizado
     * 
     * @param boolean bChaveIncremento 
     */
    public function setChaveIncremento($bChaveIncremento) {
        $this->bChaveIncremento = $bChaveIncremento;
    }

    /**
     * Método que cria uma nova instância da classe model, usado nas consultas
     * para retornar um array de objetos
     * 
     * @return object Instância do objeto model atual 
     */
    public function getNewModel() {
        $sModel = get_class($this->Model);

        return new $sModel();
    }

    /**
     * Método que cria e adiciona os campos de relacionamento entre os objetos
     * model e de persistência
     * 
     * @param string $sNomeBD Nome do campo no banco de dados
     * @param string $sNomeModel Nome do campo no objeto model
     * @param boolean $bChave Indica se o campo é chave na tabela
     * @param boolean $bPersiste Indica se o campo deve ser persistido
     * @param boolean $bAutoincremento Indica se o campo é autoincremento
     * @param integer $iTipoCampo Indica o tipo do campo
     */
    public function adicionaRelacionamento($sNomeBD, $sNomeModel, $bChave = false, $bPersiste = true, $bAutoincremento = false, $iTipoCampo = 1) {
        $oCampo = new CampoBanco($sNomeBD, $sNomeModel, $bChave, $bPersiste, $bAutoincremento, $iTipoCampo);
        $this->aListaCampos[] = $oCampo;
    }

    /**
     * Retorna o conteúdo do atributo aListaCampos que contêm o relacionamento
     * entre os campos do Model e do BD
     * 
     * @return array
     */
    public function getListaRelacionamento() {
        return $this->aListaCampos;
    }

    /**
     * Retorna um campo da lista de relacionamento a partir do nome do 
     * model do mesmo
     * 
     * @param String $sNomeModel Nome do campo no model a ser localizado
     * 
     * @return Object/null Retorna um objeto do tipo campoBanco  ou nulo caso não encontre
     */
    public function getCampoByNameModel($sNomeModel) {
        foreach ($this->getListaRelacionamento() as $oCampoBanco) {
            if (strtolower($oCampoBanco->getNomeModel()) === strtolower($sNomeModel)) {
                return $oCampoBanco;
            }
        }
        return null;
    }

    /**
     * Retorna um campo da lista de relacionamento a partir do nome do 
     * banco do mesmo
     * 
     * @param String $sNomeBanco Nome do campo no banco a ser localizado
     * 
     * @return Object/null Retorna um objeto do tipo campoBanco  ou nulo caso não encontre
     */
    public function getCampoByNameBanco($sNomeBanco) {
        foreach ($this->getListaRelacionamento() as $oCampoBanco) {
            if (strtolower($oCampoBanco->getNomeBanco()) === strtolower($sNomeBanco)) {
                return $oCampoBanco;
            }
        }
        return null;
    }

    /**
     * Retorna a lista de campos separando-os por vírgula para serem utilizados
     * nos comandos de consulta sql
     * 
     * @return string
     */
    function getListaCampos() {
        $aCamposSelect = array();

        //se existir agrupamento definido incluirá apenas os campos informados
        if (sizeof($this->getGroupBy()) > 0) {
            foreach ($this->getGroupBy() as $sCampo) {
                $aCamposSelect[] .= $this->getTabela() . '.' . $sCampo . ' AS "' . $this->getTabela() . '.' . $sCampo . '"';
            }
        } else {
            //campos da tabela principal
            foreach ($this->getListaRelacionamento() as $oCampoBanco) {
                if ($oCampoBanco->getPersiste()) {
                    if ($oCampoBanco->getTipoCampo() !== CampoBanco::TIPO_FORALISTA) {
                        $sNomeCampo = $this->getTabela() . '.' . $oCampoBanco->getNomeBanco();

                        $aCamposSelect[] .= $sNomeCampo . ' AS "' . $sNomeCampo . '"';
                        if (sizeof($oCampoBanco->getLista()) > 0) {
                            $aCamposSelect[] .= $this->getStringCase($sNomeCampo, $sNomeCampo . self::COMPLETA_NOME_LISTA, $oCampoBanco->getLista());
                        }
                    }
                }
            }

            //campos das tabelas de ligação (Join)
            foreach ($this->getListaJoin() as $aJoin) {
                $oPersJoin = Fabrica::FabricarPersistencia($aJoin['classe']);
                foreach ($oPersJoin->getListaRelacionamento() as $oCampoBanco) {
                    if ($oCampoBanco->getPersiste()) {
                        $sAlias = $aJoin['alias'] != null ? '"' . $aJoin['alias'] . '"' : $oPersJoin->getTabela();
                        $sAliasAs = $aJoin['alias'] != null ? $aJoin['alias'] : $oPersJoin->getTabela();
                        $sNomeCampo = $sAlias . '.' . $oCampoBanco->getNomeBanco();
                        $sNomeCampoAs = $sAliasAs . '.' . $oCampoBanco->getNomeBanco();

                        $aCamposSelect[] .= $sNomeCampo . ' AS "' . $sNomeCampoAs . '"';
                        if (sizeof($oCampoBanco->getLista()) > 0) {
                            $aCamposSelect[] .= $this->getStringCase($sNomeCampo, $sNomeCampoAs . self::COMPLETA_NOME_LISTA, $oCampoBanco->getLista());
                        }
                    }
                }
            }
        }
        return implode(',', $aCamposSelect);
    }

    /**
     * Método que retorna a string do comando CASE a ser usada nos campos
     * que possuirem lista de valores x descrição
     * 
     * @return string
     */
    public function getStringCase($sNomeCampo, $sNomeCampoAs, $aLista) {
        $sCase = "CASE ";
        foreach ($aLista as $valor => $descricao) {
            $sCase .= "WHEN " . $sNomeCampo . " = " . $valor . " THEN '" . $descricao . "' ";
        }
        $sCase .= "END AS \"" . $sNomeCampoAs . "\"";

        return $sCase;
    }

    /**
     * Método que adiciona campos de relacionamento virtuais, ou seja,
     * criados da junção de dois ou mais campos presentes na consulta
     * 
     * @param array $aCampos Array dos campos que farão parte do campo virtual, utilizar nome do model
     * Se o campo for da tabela de ligação utilizar o nome da classe seguido do nome do campo
     * @param string $sNomeModel Nome do campo do model que receberá o campo virtual
     * @param string $sAlias Alias a ser usado pela coluna virtual, quando não definido usará o mesmo nome do model
     */
    public function adicionaCampoVirtual($aCampos, $sNomeModel, $sAlias = null) {
        $sCampoAlias = $sAlias === null ? $sNomeModel : $sAlias;
        $this->aListaCampoVirtual[] = array('campos' => $aCampos,
            'campoModel' => $sNomeModel,
            'alias' => $sCampoAlias);

        //cria um relacionamento para o cálculo adicionado
        $this->adicionaRelacionamento($sCampoAlias, $sNomeModel, false, false);
    }

    /**
     * Retorna o conteúdo do atributo aListaCampoVirtual que contêm as informações
     * sobre as colunas virtuais que devem ser adicionadas as consultas
     * 
     * @return array
     */
    public function getListaCampoVirtual() {
        return $this->aListaCampoVirtual;
    }

    /**
     * Retorna a string de campos virtuais separando-os por vírgula 
     * para serem utilizados nos comandos de consulta sql
     * 
     * @return string
     */
    public function getCamposVirtuais() {
        $sCamposVirtuais = "";

        foreach ($this->getListaCampoVirtual() as $aVirtual) {
            $sCamposVirtuais .= ',' . $this->getStringCampoVirtual($aVirtual['campos']) . ' AS "' . $this->getTabela() . '.' . $aVirtual['alias'] . '"';
        }

        return $sCamposVirtuais;
    }

    /**
     * Método que retorna a string referente a uma coluna virtual
     * 
     * @param Array $aCampoVirtual Array contendo 1 elemento contido no atributo aListaCampoVirtual
     *
     * @return String
     */
    private function getStringCampoVirtual($aCampoVirtual) {
        $sCampoVirtual = "";
        foreach ($aCampoVirtual as $key => $sCampo) {
            $sNomeClasse = "";
            if (strpos($sCampo, ".") > 0) {
                $sNomeClasse = '"' . substr($sCampo, 0, strpos($sCampo, ".")) . '".';
            }
            if ($key > 0) {
                $sCampoVirtual .= "||' - '||";
            }
            $sCampoVirtual .= $sNomeClasse . $this->getNomeBanco($sCampo);
        }
        return $sCampoVirtual;
    }

    /**
     * Método que adiciona campos de relacionamento a partir de cálculos
     * realizados entre os campos resultantes das consultas
     * 
     * @param array $aCampos Array dos campos que farão parte do cálculo, utilizar nome do model
     * Se o campo for da tabela de ligação utilizar o nome da classe seguido do nome do campo
     *
     * @param string $sFormulaCalculo String contendo a fórmula do cálculo
     * Deve ser definida pelos identificadores dos campos e operadores matemáticos
     * 
     * Por exemplo:
     * ({0} * {1}) + {2}
     * 
     * Será realizado o cálculo de multiplicação entre os campos que estiverem
     * nos índices 0 e 1 do array do parâmetro $aCampos e posteriomente a
     * soma com o valor do campo que estiver no índice 2
     * 
     * Só serão substituídos os valores entre "{}" o restante da string será
     * mantida
     * 
     * @param string $sNomeModel Nome do campo do model que receberá o resultado do cálculo
     * @param string $sAlias Alias a ser usado pela coluna virtual, quando não definido usará o mesmo nome do model
     */
    public function adicionaCalculo($aCampos, $sFormulaCalculo, $sNomeModel, $sAlias = null) {
        $this->aListaCamposCalculo[] = array('campos' => $aCampos,
            'formula' => $sFormulaCalculo,
            'campoModel' => $sNomeModel,
            'alias' => $sAlias === null ? $sNomeModel : $sAlias,);
    }

    /**
     * Retorna o conteúdo do atributo aListaCamposCalculo que contêm as informações
     * sobre os cálculos (colunas virtuais) que devem ser adicionadas as consultas
     * 
     * @return array
     */
    public function getListaCamposCalculados() {
        return $this->aListaCamposCalculo;
    }

    /**
     * Retorna a string de campos virtuais calculados por fórmula 
     * separando-os por vírgula para serem utilizados nos 
     * comandos de consulta sql
     * 
     * @return string
     */
    public function getCamposCalculados() {
        $sCamposCalculo = "";

        foreach ($this->getListaCamposCalculados() as $aCalculo) {
            $sCampoCalculo = $this->getStringCampoCalculo($aCalculo);

            $sCamposCalculo .= ',(' . $sCampoCalculo . ') AS "' . $this->getTabela() . '.' . $aCalculo['alias'] . '"';

            //cria um relacionamento para o cálculo adicionado
            $this->adicionaRelacionamento($aCalculo['alias'], $aCalculo['campoModel'], false, false);
        }

        return $sCamposCalculo;
    }

    /**
     * Método que retorna a string referente a uma coluna virtual originada por
     * um cálculo
     * 
     * @param Array $aCampoCalculo Array contendo 1 elemento contido no atributo aListaCamposCalculo
     *
     * @return String
     */
    private function getStringCampoCalculo($aCampoCalculo) {
        $sCampoFormula = $aCampoCalculo['formula'];

        foreach ($aCampoCalculo['campos'] as $key => $sNomeCampo) {
            $sCampoReplace = "";

            //verifica se o campo do model é um totalizador na consulta
            $bTotalizador = false;
            foreach ($this->getListaTotaliza() as $aTotalizador) {
                if (strtolower($sNomeCampo) === strtolower($aTotalizador['campoModel'])) {
                    $oPersTotal = Fabrica::FabricarPersistencia($aTotalizador['classe']);

                    /*
                     * verifica se deve adicionar os filtros da persistência principal
                     * na consulta da totalização
                     */
                    if ($aTotalizador['addFiltro']) {
                        /*
                         * Adiciona a chave do objeto principal como filtro no objeto 
                         * de totalização
                         */
                        $aChave = $this->getChaveArray();

                        foreach ($aChave as $oAtual) {
                            $oPersTotal->adicionaFiltro($oAtual->getNomeBanco(), $this->getTabela() . '.' . $oAtual->getNomeBanco());
                        }
                    }

                    $sNomeCampoBD = $oPersTotal->getNomeBanco($aTotalizador['campoTotaliza']);
                    $sTipo = self::$TIPO_TOTALIZA[$aTotalizador['tipoTotaliza']];

                    $sCampoReplace .= $oPersTotal->getSqlTotaliza($sNomeCampoBD, $sTipo, $aTotalizador['addFiltro']);

                    $bTotalizador = true;
                    break;
                }
            }

            if (!$bTotalizador) {
                $sNomeClasse = "";
                if (strpos($sNomeCampo, ".") > 0) {
                    $sNomeClasse = '"' . substr($sNomeCampo, 0, strpos($sNomeCampo, ".")) . '".';
                }
                $sCampoReplace = $sNomeClasse . $this->getNomeBanco($sNomeCampo);
            }
            $sCampoFormula = str_replace("{" . $key . "}", $sCampoReplace, $sCampoFormula);
        }
        return $sCampoFormula;
    }

    /**
     * Método que adiciona campos de relacionamento a partir de totalizações
     * 
     * @param string $sClasse Nome da classe que persistência que será utilizada na totalização
     * @param string $sCampoTotaliza Nome do campo (Model) a ser totalizado na classe indicada
     * @param string $sCampoModelPrincipal Nome do campo do model principal que receberá a totalização
     * @param integer $iTipo Indica o tipo de totalização a ser realizada
     * @param boolean $bAdicionaFiltro Indica se a cláusula WHERE da persistência principal deve ser adicionada
     *                                 na consulta do totalizador (subsql)
     */
    public function adicionaTotaliza($sClasse, $sCampoTotaliza, $sCampoModelPrincipal, $iTipo = self::TOTALIZA_SOMA, $bAdicionaFiltro = true) {
        $this->aListaTotaliza[] = array('classe' => $sClasse,
            'campoTotaliza' => $sCampoTotaliza,
            'campoModel' => $sCampoModelPrincipal,
            'tipoTotaliza' => $iTipo,
            'addFiltro' => $bAdicionaFiltro);
    }

    /**
     * Retorna o conteúdo do atributo aListaTotaliza que contêm as informações
     * sobre as totalizações (subsql) que devem ser adicionadas as consultas
     * 
     * @return array
     */
    function getListaTotaliza() {
        return $this->aListaTotaliza;
    }

    /**
     * Retorna a lista de campos a serem totalizados separando-os por vírgula 
     * para serem utilizados nos comandos de consulta sql
     * 
     * @return string
     */
    function getCamposTotalizadores() {
        $sTotaliza = "";

        foreach ($this->getListaTotaliza() as $aTotalizador) {
            $sTotaliza .= ',' . $this->getStringCampoTotalizador($aTotalizador);
        }
        return $sTotaliza;
    }

    /**
     * Método que retorna a string referente a uma coluna virtual originada por
     * um totalizador
     * 
     * @param Array $aCampoTotaliza Array contendo 1 elemento contido no atributo aListaTotaliza
     *
     * @return String
     */
    private function getStringCampoTotalizador($aCampoTotaliza, $bAddAlias = true, $bAddRelacionamento = true) {
        $sTotaliza = "";
        $oPersTotal = Fabrica::FabricarPersistencia($aCampoTotaliza['classe']);

        /*
         * verifica se deve adicionar os filtros da persistência principal
         * na consulta da totalização
         */
        if ($aCampoTotaliza['addFiltro']) {

            /*
             * Adiciona a chave do objeto principal como filtro no objeto 
             * de totalização
             */
            $aChave = $this->getChaveArray();

            foreach ($aChave as $oAtual) {
                $oPersTotal->adicionaFiltro($oAtual->getNomeBanco(), $this->getTabela() . '.' . $oAtual->getNomeBanco());
            }
        }

        $sNomeCampoBD = $oPersTotal->getNomeBanco($aCampoTotaliza['campoTotaliza']);
        $sTipo = self::$TIPO_TOTALIZA[$aCampoTotaliza['tipoTotaliza']];

        $sTotaliza .= $oPersTotal->getSqlTotaliza($sNomeCampoBD, $sTipo, $aCampoTotaliza['addFiltro']);

        if ($bAddAlias) {
            $sTotaliza .= ' AS "' . $this->getTabela() . '.' . $sNomeCampoBD . $sTipo . '"';
        }

        if ($bAddRelacionamento) {
            //cria um relacionamento para a totalização adicionada
            $this->adicionaRelacionamento($sNomeCampoBD . $sTipo, $aCampoTotaliza['campoModel'], false, false);
        }
        return $sTotaliza;
    }

    /**
     * Método que retorna o comando sql que permite adicionar totalizações 
     * nas consultas sql
     * 
     * @param string Nome do campo do banco a ser totalizado
     * @param string Tipo da totalização
     * @param boolean Indica se a cláusula WHERE deve ser adicionada ao comando
     */
    private function getSqlTotaliza($sCampo, $sTipo, $bAdicionaFiltro = true) {
        $sWhere = $bAdicionaFiltro ? $this->getStringWhere() : '';

        $sSql = '(SELECT COALESCE(' . $sTipo . '(' . $sCampo . '),0) FROM ' . $this->getTabela() . $sWhere . ')';

        return $sSql;
    }

    /**
     * Retorna o conteúdo do atributo aListaJoin
     * 
     * @return array
     */
    public function getListaJoin() {
        return $this->aListaJoin;
    }

    /**
     * Método que realiza a adição dos relacionamentos entre as tabelas conforme
     * modelagem ER
     * 
     * @param string $sClasse Nome da classe que será adicionada ao relacionamento
     * @param string $sAlias String contendo o alias da tabela
     * @param integer $iTipo Tipo da ligação (JOIN) que será realizara
     *                0 ==> INNER JOIN
     *                1 ==> LEFT JOIN
     *                2 ==> RIGTH JOIN
     * @param string/array $xCampoOrigem String ou array contendo o campo da tabela de origem a ser relacionado
     * @param string/array $xCampoDestino String ou array contendo o campo da tabela de destino a ser relacionado
     * 
     * Caso não sejam informados os campos de origem e destino será feito um comparativo entre as
     * tabelas a partir dos campos chave da tabela principal
     * $sEnd coloca uma string para fazer clausulas nas ligaçoes
     */
    public function adicionaJoin($sClasse, $sAlias = null, $iTipo = self::LEFT_JOIN, $xCampoOrigem = null, $xCampoDestino = null, $sEnd = null) {
        $this->aListaJoin[] = array('classe' => $sClasse,
            'alias' => $sAlias === null ? $sClasse : $sAlias,
            'tipo' => self::$TIPO_JOIN[$iTipo],
            'campoOrigem' => $xCampoOrigem,
            'campoDestino' => $xCampoDestino,
            'listand' => $sEnd);
    }

    /**
     * Método que retorna a os campos presentes no atributo aListaJoin 
     * em formato de string para ser usado no comando sql
     * 
     * @return string
     */
    public function getStringJoin() {
        $sJoin = "";

        foreach ($this->getListaJoin() as $aJoin) {
            $oPersJoin = Fabrica::FabricarPersistencia($aJoin['classe']);

            $sJoin .= $aJoin['tipo'] . $oPersJoin->getTabela() . " \"" . $aJoin['alias'] . "\" ON ";

            //se os campos de ligação forem passados por parâmetro
            if ($aJoin['campoOrigem'] != null) {
                if (is_array($aJoin['campoOrigem'])) {
                    foreach ($aJoin['campoOrigem'] as $key => $value) {
                        if ($key > 0) {
                            $sJoin .= " AND ";
                        }
                        $sJoin .= '"' . $aJoin['alias'] . "\"." . $aJoin['campoDestino'][$key] . " = " . $this->getTabela() . "." . $aJoin['campoOrigem'][$key];
                    }
                } else {
                    $sJoin .= '"' . $aJoin['alias'] . "\"." . $aJoin['campoDestino'] . " = " . $this->getTabela() . "." . $aJoin['campoOrigem'];
                }
            } else {
                //realiza a ligação automaticamente pela chave da persistência de ligação
                foreach ($oPersJoin->getChaveArray() as $key => $oCampoBanco) {
                    if ($key > 0) {
                        $sJoin .= " AND ";
                    }
                    $sJoin .= '"' . $aJoin['alias'] . "\"." . $oCampoBanco->getNomeBanco() . " = " . $this->getTabela() . "." . $oCampoBanco->getNomeBanco();
                }
            }
            //adiciona clausulas and se houve
            $sJoin .= ' ' . $aJoin['listand'];
        }

        return $sJoin;
    }

    /**
     * Retorna o conteúdo do atributo aListaWhere
     * 
     * @return array
     */
    public function getListaWhere() {
        return $this->aListaWhere;
    }

    function setAListaWhere($aListaWhere) {
        $this->aListaWhere = $aListaWhere;
    }

    /**
     * Método que realiza a adição dos parâmetros responsáveis pela inclusão
     * de filtros (WHERE) das consultas (SELECT)
     * 
     * @param string $sCampo Nome do campo que será utilizado na ordenação
     * @param string $sValor Valor a ser filtrado para o campo
     * @param integer $iTipoLigacao Tipo de ligação AND ou OR
     * @param integer $iTipoComparacao Tipo de comparação a ser realizado
     * @param string $sValorFim Valor final caso a cláusula utilizada seja BETWEEN
     * @param string $sTabelaCampo envia a tabela ao qual o campo pertence, se ficar em branco o sistema tentará buscar
     */
    public function adicionaFiltro($sCampo, $sValor, $iTipoLigacao = 0, $iTipoComparacao = 0, $sValorFim = "", $sTabelaCampo = "", $sCampoType = "") {
        $this->aListaWhere[] = array('campo' => $sCampo,
            'valor' => $sValor,
            'ligacao' => $iTipoLigacao,
            'comparacao' => $iTipoComparacao,
            'valorFim' => $sValorFim,
            'tabelaCampo' => $sTabelaCampo,
            'type' => $sCampoType);
    }

    /**
     * Método que recria a lista de filtros (WHERE), utilizado nos casos que
     * precisa-se filtrar informações diferentes em cada passagem do laço de
     * repetição 
     */
    public function limpaFiltro() {
        $this->aListaWhere = array();
    }

    /**
     * Método que recria a lista de filtros (ORDER BY), utilizado nos casos que
     * precisa-se filtrar informações diferentes em cada passagem do laço de
     * repetição 
     */
    public function limpaOrderBy() {
        $this->aOrderBy = array();
    }

    /**
     * Retorna o conteúdo do atributo sSqlWhere
     * @return string
     */
    public function getSqlWhere() {
        return $this->sSqlWhere;
    }

    /**
     * Método que permite realizar a definição de filtros WHERE manualmente pelo
     * controlador
     * 
     * @param string $sSqlWhere Filtro a ser aplicado na consulta
     */
    public function setSqlWhere($sSqlWhere) {
        $this->sSqlWhere = $sSqlWhere;
    }

    /**
     * Método que retorna os campos presentes no atributo aListaWhere 
     * em formato de string para ser usado no filtro do comando sql
     * 
     * @return string
     */
    public function getStringWhere() {
        $sWhere = "";
        $aWhere = $this->getListaWhere();

        foreach ($aWhere as $aAtual) {
            //verifica se esta passando com o ponto
            $bPo = strpos($aAtual['campo'], '.');
            if ($bPo == true) {
                $aCampo = explode('.', $aAtual['campo']);
                $aAtual['campo'] = $aCampo[1];
            }


            $bIsDate = false;
            $sWhere .= $sWhere == "" ? " WHERE " : self::$TIPO_LIGACAO[$aAtual['ligacao']];

            //identificador para diferenciar campos virtuais de campos normais
            $iOrigemFiltro = 0;
            $sValor = $aAtual['valor'];

            foreach ($this->getListaTotaliza() as $aTotalizador) {
                $oPersTotal = Fabrica::FabricarPersistencia($aTotalizador['classe']);
                $sNomeCampoBD = $oPersTotal->getNomeBanco($aTotalizador['campoTotaliza']);
                $sTipo = self::$TIPO_TOTALIZA[$aTotalizador['tipoTotaliza']];

                if ($sNomeCampoBD . $sTipo == $aAtual['campo']) {
                    $iOrigemFiltro = 1; // filtro pelo totalizador
                    $sTabela = "(" . $this->getStringCampoTotalizador($aTotalizador, false, false) . ")";
                    break;
                }
            }

            //verificação de campo virtual por cálculo
            foreach ($this->getListaCamposCalculados() as $aCalculo) {
                if (strtolower($aCalculo['alias']) === strtolower($aAtual['campo'])) {
                    $iOrigemFiltro = 1; // filtro pelo campo virtual por cálculo

                    $sTabela = "(" . $this->getStringCampoCalculo($aCalculo) . ")";
                    break;
                }
            }

            //verificação de campo virtual por concatenação
            foreach ($this->getListaCampoVirtual() as $aVirtual) {
                if (strtolower($aVirtual['alias']) === strtolower($aAtual['campo'])) {
                    $iOrigemFiltro = 1; // filtro pelo campo virtual
                    /* $sTabela = "TO_ASCII(LOWER(".$this->getStringCampoVirtual($aVirtual['campos'])."))";
                      $sValor  = "TO_ASCII('%".strtolower($sValor)."%')"; */
                    $sTabela = "(" . $this->getStringCampoVirtual($aVirtual['campos']) . ")";
                    $sValor = "'%" . strtolower($sValor) . "%'";

                    break;
                }
            }

            if ($iOrigemFiltro === 0) {
                //captura o nome da tabela do campo atual
                if ($aAtual['tabelaCampo'] != "") {
                    $sTabelaCampo = $aAtual['tabelaCampo'];
                } else {
                    $sTabelaCampo = $this->getTabelaCampo($aAtual['campo']);
                }

                //verifica se o valor é do tipo data
                if (!is_array($aAtual['valor'])) {
                    if (Util::isValidDate($aAtual['valor']) || Util::isValidDate($aAtual['valorFim'])) {
                        $aAtual['valor'] = substr($aAtual['valor'], 0, 10);
                        $aAtual['valorFim'] = substr($aAtual['valorFim'], 0, 10);
                        $bIsDate = true;
                    }
                }

                //tratamento especial para alguns tipos de comparação
                switch ($aAtual['comparacao']) {
                    case self::ENTRE: //between
                        $sValor = "'" . $aAtual['valor'] . "' AND '" . $aAtual['valorFim'] . "'";
                        $sTabela = $this->isConsultaPorSql() ? $aAtual['campo'] : $sTabelaCampo . "." . $aAtual['campo'];
                        break;
                    case self::CONTEM: //like
                        //  $sValor  = "TO_ASCII('%".strtolower($aAtual['valor'])."%')";
                        $sValor = "'%" . strtolower($aAtual['valor']) . "%'";
                        $sTabela = $this->isConsultaPorSql() ? $aAtual['campo'] : $sTabelaCampo . "." . $aAtual['campo'];
                        //$sTabela = "TO_ASCII(LOWER(".$sTabela."))";
                        $sTabela = "LOWER(" . $sTabela . ")";
                        break;
                    case self::INICIA_COM: //like (inicia com...)
                        // $sValor  = "TO_ASCII('".strtolower($aAtual['valor'])."%')";
                        $sValor = "'" . strtolower($aAtual['valor']) . "%'";
                        $sTabela = $this->isConsultaPorSql() ? $aAtual['campo'] : $sTabelaCampo . "." . $aAtual['campo'];
                        //$sTabela = "TO_ASCII(LOWER(".$sTabela."))";
                        $sTabela = "LOWER(" . $sTabela . ")";
                        break;
                    case self::TERMINA_COM: //like (termina com...)
                        // $sValor  = "TO_ASCII('%".strtolower($aAtual['valor'])."')";
                        $sValor = "'%" . strtolower($aAtual['valor']) . "'";
                        $sTabela = $this->isConsultaPorSql() ? $aAtual['campo'] : $sTabelaCampo . "." . $aAtual['campo'];
                        //  $sTabela = "TO_ASCII(LOWER(".$sTabela."))";
                        $sTabela = "LOWER(" . $sTabela . ")";
                        break;
                    case self::GRUPO: //in
                        $sValor = "(";
                        foreach ($aAtual['valor'] as $key => $value) {
                            if ($key > 0) {
                                $sValor .= ",";
                            }
                            $sValor .= $value;
                        }
                        $sValor .= ")";
                        $sTabela = $this->isConsultaPorSql() ? $aAtual['campo'] : $sTabelaCampo . "." . $aAtual['campo'];
                        break;
                    default:
                        $aParts = explode(".", $aAtual['valor']);
                        if (count($aParts) == 1) {
                            if (isset($aAtual['valor'])) {
                                if (!is_numeric($aAtual['valor'])) {
                                    $aPartes = explode("'", $aAtual['valor']);
                                    if (count($aPartes) == 1) {
                                        $aAtual['valor'] = $aAtual['valor'];
                                    }
                                }
                            }
                        }
                        $aParts = explode(".", $aAtual['valorFim']);
                        if (count($aParts) == 1 && isset($aAtual['valorFim'])) {
                            if (isset($aAtual['valorFim'])) {
                                if (!is_numeric($aAtual['valorFim'])) {
                                    $aPartes = explode("'", $aAtual['valorFim']);
                                    if (count($aPartes) == 1) {
                                        $aAtual['valorFim'] = "'" . $aAtual['valorFim'] . "'";
                                    }
                                }
                            }
                        }

                        $sValor = "'" . $aAtual['valor'] . "'";
                        $sTabela = $this->isConsultaPorSql() ? $aAtual['campo'] : $sTabelaCampo . "." . $aAtual['campo'];
                        break;
                }
            }

            //se o valor for do tipo data faz o cast do campo timestamp para data
            if ($bIsDate) {
                $sTabela = "CAST(" . $sTabela . " AS DATE)";
            }

            $bIsNumeric = $this->numericSql($sValor);

            if ($bIsNumeric) {
                $sWhere .= $sTabela . self::$TIPO_COMPARACAO[$aAtual['comparacao']] . $sValor;
            } else {
                $sWhere .= $sTabela . self::$TIPO_COMPARACAO[$aAtual['comparacao']] . $sValor . ' COLLATE Latin1_General_CI_AI ';
            }
        }

        if ($this->getSqlWhere()) {
            $sWhere .= $sWhere == "" ? " WHERE " : " AND ";
            $sWhere .= $this->getSqlWhere();
        }

        return $sWhere;
    }

    public function numericSql($sValor) {
        $aValores = explode(',', $sValor);
        $bIsNumeric = true;
        foreach ($aValores as $key => $value) {
            $bIsNumeric = is_numeric(preg_replace('/[^0-9]/', '', $value));
        }
        return $bIsNumeric;
    }

    /**
     * Método que retorna os campos chave que estiverem setados
     * em formato de string para ser usado filtro do comando sql
     * 
     * @return string
     */
    public function getStringWhereByChave($bAutoIncremento = false) {
        $sWhere = "";
        $aChave = $this->getChaveArray();

        foreach ($aChave as $oAtual) {
            $xValor = Controller::getValorModel($this->Model, $oAtual->getNomeModel());
            if (!($bAutoIncremento && $oAtual->getAutoIncremento())) {
                if ($xValor != null) {
                    if ($sWhere == "") {
                        $sWhere = " WHERE ";
                    } else {
                        $sWhere .= self::$TIPO_LIGACAO[self::LIGACAO_AND];
                    }

                    $sWhere .= $this->getTabela() . "." . $oAtual->getNomeBanco() . self::$TIPO_COMPARACAO[self::IGUAL] . strtoupper("'" . $xValor . "'");
                }
            }
        }
        return $sWhere;
    }

    /**
     * Retorna o conteúdo do atributo aGroupBy
     * 
     * @return array
     */
    public function getGroupBy() {
        return $this->aGroupBy;
    }

    /**
     * Método que realiza a adição dos parâmetros responsáveis pelo 
     * agrupamento das consultas SQL
     * 
     * @param string $sCampo Nome do campo que será utilizado no agrupamento
     * @param string $sTabelaCampo envia a tabela, se ficar em branco o sistema vai procurar depois
     */
    public function adicionaGroupBy($sCampo) {
        $this->aGroupBy[] = $sCampo;
    }

    /**
     * Método que retorna a os campos presentes no atributo aGroupBy 
     * em formato de string para ser usado no comando sql
     * 
     * @return string
     */
    public function getStringGroupBy() {
        $sGroupBy = "";
        $aGroupBy = $this->getGroupBy();

        foreach ($aGroupBy as $sCampo) {
            $sCampoTabela = "";

            if ($sGroupBy == "") {
                $sGroupBy = " GROUP BY ";
            } else {
                $sGroupBy .= ", ";
            }

            if ($this->isConsultaPorSql()) {
                $sCampoTabela .= $sCampo;
            } else {
                //identificador para diferenciar campos virtuais de campos normais
                $iOrigemGroup = 0;

                //verificação de campo virtual por totalizador
                foreach ($this->getListaTotaliza() as $aTotalizador) {
                    $oPersTotal = Fabrica::FabricarPersistencia($aTotalizador['classe']);
                    $sNomeCampoBD = $oPersTotal->getNomeBanco($aTotalizador['campoTotaliza']);
                    $sTipo = self::$TIPO_TOTALIZA[$aTotalizador['tipoTotaliza']];

                    if ($sNomeCampoBD . $sTipo == $sCampo) {
                        $iOrigemGroup = 1; // agrupamento pelo totalizador
                        $sCampoTabela = "(" . $this->getStringCampoTotalizador($aTotalizador, false, false) . ")";
                        break;
                    }
                }

                //verificação de campo virtual por cálculo
                foreach ($this->getListaCamposCalculados() as $aCalculo) {
                    if (strtolower($aCalculo['alias']) === strtolower($sCampo)) {
                        $iOrigemGroup = 1; // agrupamento pelo campo virtual por cálculo
                        $sCampoTabela = "(" . $this->getStringCampoCalculo($aCalculo) . ")";
                        break;
                    }
                }

                //verificação de campo virtual por concatenação
                foreach ($this->getListaCampoVirtual() as $aVirtual) {
                    if (strtolower($aVirtual['alias']) === strtolower($aAtual['campo'])) {
                        $iOrigemGroup = 1; // agrupamento pelo campo virtual 

                        $sCampoTabela = "(" . $this->getStringCampoVirtual($aVirtual['campos']) . ")";
                        break;
                    }
                }

                if ($iOrigemGroup === 0) {
                    $sCampoTabela = $this->getTabelaCampo($sCampo) . "." . $sCampo;
                }
            }
            $sGroupBy .= $sCampoTabela;
        }
        return $sGroupBy;
    }

    /**
     * Retorna o conteúdo do atributo aGroupByConsulta
     * 
     * @return array
     */
    public function getGroupByConsulta() {
        return $this->aGroupByConsulta;
    }

    /**
     * Método que realiza a adição dos parâmetros responsáveis pelo 
     * agrupamento das telas de consulta
     */
    public function adicionaGroupByConsulta() {
        $aCampos = func_get_args();

        foreach ($aCampos as $sCampo) {
            $this->aGroupByConsulta[] = $sCampo;
        }
    }

    /**
     * Retorna o conteúdo do atributo aOrderBy
     * 
     * @return array
     */
    public function getOrderBy() {
        return $this->aOrderBy;
    }

    /**
     * Método que realiza a adição dos parâmetros responsáveis pela ordenação
     * das consultas que retornam mais que um resultado
     * 
     * @param string $sCampo Nome do campo que será utilizado na ordenação
     * @param integer $iTipo Tipo da ordenação
     *                0 ==> Crescente (ASC)
     *                1 ==> Decrescente (DESC)
     */
    public function adicionaOrderBy($sCampo, $iTipo = self::ASC) {
        $aTipo = array(" ASC ", " DESC ");
        $this->aOrderBy[] = array('campo' => $sCampo,
            'tipo' => $aTipo[$iTipo]);
    }

    /**
     * Método que retorna a os campos presentes no atributo aOrderBy 
     * em formato de string para ser usado no comando sql
     * 
     * @return string
     */
    public function getStringOrderBy() {
        $sOrderBy = "";
        $aOrderBy = $this->getOrderBy();

        foreach ($aOrderBy as $aAtual) {
            $sCampoTabela = "";

            if ($sOrderBy == "") {
                $sOrderBy = " ORDER BY ";
            } else {
                $sOrderBy .= ", ";
            }

            if ($this->isConsultaPorSql()) {
                $sCampoTabela = $aAtual['campo'];
            } else {
                //identificador para diferenciar campos virtuais de campos normais
                $iOrigemOrder = 0;

                //verificação de campo virtual por totalizador
                foreach ($this->getListaTotaliza() as $aTotalizador) {
                    $oPersTotal = Fabrica::FabricarPersistencia($aTotalizador['classe']);
                    $sNomeCampoBD = $oPersTotal->getNomeBanco($aTotalizador['campoTotaliza']);
                    $sTipo = self::$TIPO_TOTALIZA[$aTotalizador['tipoTotaliza']];

                    if ($sNomeCampoBD . $sTipo == $aAtual['campo']) {
                        $iOrigemOrder = 1; // ordenação pelo totalizador
                        $sCampoTabela = "(" . $this->getStringCampoTotalizador($aTotalizador, false, false) . ")";
                        break;
                    }
                }

                //verificação de campo virtual por cálculo
                foreach ($this->getListaCamposCalculados() as $aCalculo) {
                    if (strtolower($aCalculo['alias']) === strtolower($aAtual['campo'])) {
                        $iOrigemOrder = 1; // ordenação pelo campo virtual por cálculo
                        $sCampoTabela = "(" . $this->getStringCampoCalculo($aCalculo) . ")";
                        break;
                    }
                }

                //verificação de campo virtual por concatenação
                foreach ($this->getListaCampoVirtual() as $aVirtual) {
                    if (strtolower($aVirtual['alias']) === strtolower($aAtual['campo'])) {
                        $iOrigemOrder = 1; // ordenação pelo campo virtual 

                        $sCampoTabela = "(" . $this->getStringCampoVirtual($aVirtual['campos']) . ")";
                        break;
                    }
                }

                if ($iOrigemOrder === 0) {
                    $sCampoTabela = $this->getTabelaCampo($aAtual['campo']) . "." . $aAtual['campo'];
                }
            }
            $sOrderBy .= $sCampoTabela . " " . $aAtual['tipo'];
        }
        return $sOrderBy;
    }

    /**
     * Retorna o conteúdo do atributo aOrderByConsulta
     * 
     * @return array
     */
    public function getOrderByConsulta() {
        return $this->aOrderByConsulta;
    }

    /**
     * Método que realiza a adição dos parâmetros responsáveis pela 
     * ordenação das telas de consulta
     * 
     * @param string $sCampo Nome do campo que será utilizado na ordenação
     * @param integer $iTipo Tipo da ordenação
     *                0 ==> Crescente (ASC)
     *                1 ==> Decrescente (DESC)
     */
    public function adicionaOrderByConsulta($sCampo, $iTipo = 0) {
        $this->aOrderByConsulta[] = array($sCampo, $iTipo);
    }

    /**
     * Método que retorna o nome da tabela a qual pertence determinado campo
     * Utilizado principalmente na montagem dos filtros, ordenações e agrupamentos
     * 
     * @param string $sCampoBanco Nome do campo no banco a ser pesquisado
     * @return string Nome da tabela a qual o campo pertence
     */
    public function getTabelaCampo($sCampoBanco) {
        //caso vier composto
        $bPo = strpos($sCampoBanco, '.');
        if ($bPo == true) {
            $aCampo = explode('.', $sCampoBanco);
            $sCampoBanco = $aCampo[1];
        }

        $sTabelaCampo = "";
        //percorre os campos do relacionamento principal
        foreach ($this->getListaRelacionamento() as $oCampoBanco) {
            if ($oCampoBanco->getNomeBanco() == $sCampoBanco) {
                $sTabelaCampo = $this->getTabela();
                break;
            }
        }

        //se não encontrou o campo no model principal percorre as tabelas de ligação
        if ($sTabelaCampo === "") {
            $bAchou = false;
            foreach ($this->getListaJoin() as $aJoin) {
                $oPersJoin = Fabrica::FabricarPersistencia($aJoin['classe']);
                foreach ($oPersJoin->getListaRelacionamento() as $oCampoBanco) {
                    if ($oCampoBanco->getNomeBanco() == $sCampoBanco) {
                        $sTabelaCampo = '"' . ($aJoin['alias'] != null ? $aJoin['alias'] : $oPersJoin->getTabela()) . '"';
                        $bAchou = true;
                        break;
                    }
                }
                if ($bAchou) {
                    break;
                }
            }
        }
        return $sTabelaCampo;
    }

    /**
     * Método base para as consultas, obtêm o objeto de conexão e prepara a 
     * query para a execução
     * 
     * @param string $sSql String do comando sql a ser preparado para execução
     */
    private function preparaSql($sSql) {
        return $this->oConn->prepare($sSql);
    }

    /**
     * Método que realiza a execução de comandos Sql retornando se o comando
     * foi executado com sucesso ou não
     * Utilizado para inserções, alterações e remoções
     * 
     * @param string $sSql String do comando sql a ser executado
     * 
     * @return Array contendo o um boolean na primeira posição e a a string de 
     *               um possível erro na segunda
     */
    public function executaSql($sSql) {
        $statement = $this->preparaSql($sSql);

        $bExecuta = $statement->execute();
        $aErro = $statement->errorInfo();

        $fp = fopen("bloco1.txt", "w");
        fwrite($fp, $sSql);
        fclose($fp);

        return array($bExecuta, $aErro[2]);
    }

    /**
     * Método que realiza a execução de comandos sql retornando o resultado da
     * consulta no formado do objeto PDOStatement
     * Utilizado nas consultas
     * 
     * @param string $sSql String do comando sql a ser executado
     * 
     * @return object Array contendo o resultado da consulta sql
     */
    public function consultaSql($sSql) {
        $statement = $this->preparaSql($sSql);
        $statement->execute();
        $obj = $statement->fetch(PDO::FETCH_OBJ);
        $aErro = $statement->errorInfo();

        return $obj;
    }

    public function consultaSqlAssoc($sSql) {
        $statement = $this->preparaSql($sSql);
        $statement->execute();
        $array = $statement->fetch(PDO::FETCH_ASSOC);
        $aErro = $statement->errorInfo();

        return $array;
    }

    /**
     * Método que realiza a execução de comandos sql retornando o objeto PDOStatement
     * Utilizado quando se deseja realizar operações distintas com o resultado
     * da consulta, por exemplo, contar quantas linhas resultou
     * 
     * @param string $sSql String do comando sql a ser executado
     * 
     * @return object Objeto PDOStatement
     */
    public function getObjetoSql($sSql) {
        $statement = $this->preparaSql($sSql);
        $statement->execute();

        return $statement;
    }

    /**
     * Método que carrega o objeto model passado a partir do conteúdo presente
     * na linha da consulta sql enviada parâmetro
     * 
     * @param object $oModel Objeto do modelo a ser carregado
     * @param object $oRowBD Objeto PDOStatement contendo valores de uma linha de consulta sql
     */
    function carregaModelBanco($oModel, $oRowBD) {
        foreach ($this->getListaRelacionamento() as $oCampoBanco) {
            $oModelAux = $oModel;

            $aMetodos = Controller::extractMetodos($oCampoBanco->getNomeModel());

            foreach ($aMetodos as $key => $sMetodo) {
                if (count($aMetodos) > 1) {
                    if ($key != count($aMetodos) - 1) {
                        $sMetodo = Fabrica::montaGetter($sMetodo);
                        $oModelAux = $oModelAux->$sMetodo();
                    } else {
                        $sMetodo = Fabrica::montaSetter($sMetodo);
                    }
                } else {
                    $sMetodo = Fabrica::montaSetter($sMetodo);
                }
            }
            $sNomeBanco = $this->getTabela() . "." . $oCampoBanco->getNomeBanco();

            $oModelAux->$sMetodo($oRowBD->$sNomeBanco);

            if (count($oCampoBanco->getLista()) > 0) {
                $sNomeModel = $oCampoBanco->getNomeModel() . self::COMPLETA_NOME_LISTA;
                $sNomeBanco .= self::COMPLETA_NOME_LISTA;
                $oModelAux->$sNomeModel = $oRowBD->$sNomeBanco;
            }
        }

        foreach ($this->getListaJoin() as $aJoin) {
            $oPersJoin = Fabrica::FabricarPersistencia($aJoin['classe']);
            $oModelJoin = Fabrica::FabricarModel($aJoin['classe']);

            foreach ($oPersJoin->getListaRelacionamento() as $oCampoBanco) {
                $oModelAux = $oModelJoin;

                $aMetodos = Controller::extractMetodos($oCampoBanco->getNomeModel());

                foreach ($aMetodos as $key => $sMetodo) {
                    if (count($aMetodos) > 1) {
                        if ($key != count($aMetodos) - 1) {
                            $sMetodo = Fabrica::montaGetter($sMetodo);
                            $oModelAux = $oModelAux->$sMetodo();
                        } else {
                            $sMetodo = Fabrica::montaSetter($sMetodo);
                        }
                    } else {
                        $sMetodo = Fabrica::montaSetter($sMetodo);
                    }
                }
                $sAlias = $aJoin['alias'] != null ? $aJoin['alias'] : $oPersJoin->getTabela();
                $sNomeBanco = strtolower($sAlias) . "." . $oCampoBanco->getNomeBanco();
                $oModelAux->$sMetodo($oRowBD->$sNomeBanco);

                if (count($oCampoBanco->getLista()) > 0) {
                    $sNomeModel = $oCampoBanco->getNomeModel() . self::COMPLETA_NOME_LISTA;
                    $sNomeBanco .= self::COMPLETA_NOME_LISTA;
                    $oModelAux->$sNomeModel = $oRowBD->$sNomeBanco;
                }
            }
            $aAlias = explode(".", $aJoin['alias']);
            if (count($aAlias) > 1) {
                $sMetodoGet = Fabrica::montaGetter($aAlias[0]);
                $sMetodoSet = Fabrica::montaSetter($aAlias[1]);
                $oModel->$sMetodoGet()->$sMetodoSet($oModelJoin);
            } else {
                $sMetodo = Fabrica::montaSetter($aJoin['alias']);
                $oModel->$sMetodo($oModelJoin);
            }
        }

        return $oModel;
    }

    /**
     * Método que realiza a execução de comandos sql de deleção no BD com base
     * no tipo solicitado
     * 
     * Tipos:
     *  1 - Adiciona na cláusula WHERE todos os campos chave do objeto. Neste 
     *      caso todos os atributos que são chave devem conter valor
     *  2 - Adiciona na cláusula WHERE os filtros contido no atributo "aListaWhere"
     *      Utilizado quando deseja-se excluir registros múltiplos
     * 
     * @param integer $bFiltraByChave Identifica o tipo de montagem da cláusula WHERE
     * 
     * @return boolean Identifica o resultado da execução, se executado com sucesso TRUE, caso contrário FALSE
     */
    public function excluir($bFiltraByChave = false) {
        $sWhere = $bFiltraByChave ? $this->getStringWhereByChave() : $this->getStringWhere();
        if ($sWhere == null || $sWhere == false) {
            $aRetorno[0] = false;
            return $aRetorno;
        } else {
            $sSql = 'DELETE FROM ' . $this->getTabela() . $sWhere;
            return $this->executaSql($sSql);
        }
    }

    /**
     * DELETA PASSANDO 
     */
    public function excluirRegistro($bFiltraByChave = false) {
        $sWhere = $bFiltraByChave ? $this->getStringWhereByChave() : $this->getStringWhere();
        if ($sWhere == null || $sWhere == false) {
            $aRetorno[0] = false;
            return $aRetorno;
        } else {
            $sSql = 'DELETE FROM ' . $this->getTabela() . $sWhere;
            return $this->executaSql($sSql);
        }
    }

    /**
     * Método que realiza a execução de comandos sql de inserção no BD
     * 
     * @return boolean Identifica o resultado da execução, se executado com 
     *                 sucesso TRUE, caso contrário FALSE
     */
    public function inserir() {
        $aCamposValores = $this->getArrayCamposValores();

        $sSql = 'INSERT INTO ' . $this->getTabela() . ' (' . implode(',', array_keys($aCamposValores)) . ') VALUES (' . implode(',', $aCamposValores) . ')';

        //chama funcoes necessários após inserir diretamente na persistencia
        $this->afterInsert($aCamposValores);

        /* $fp = fopen("bloco1.txt", "w");
          fwrite($fp, $sSql);
          fclose($fp); */

        return $this->executaSql($sSql);
    }

    /**
     * Método responsável por iniciar uma transação no banco de dados
     * 
     * @return boolean Identifica o resultado da execução, se executado com 
     *                 sucesso TRUE, caso contrário FALSE
     */
    public function iniciaTransacao() {
        return $this->oConn->beginTransaction();
    }

    /**
     * Método que efetiva as operações da transação no banco de dados
     * 
     * @return boolean Identifica o resultado da execução, se executado com 
     *                 sucesso TRUE, caso contrário FALSE 
     */
    public function commit() {
        return $this->oConn->commit();
    }

    /**
     * Método que cancela as operações da transação no banco de dados
     * 
     * @return boolean Identifica o resultado da execução, se executado com 
     *                 sucesso TRUE, caso contrário FALSE
     */
    public function rollback() {
        return $this->oConn->rollBack();
    }

    /**
     * Método que realiza a execução de comandos sql de alteração de um
     * registro no BD
     * 
     * @return boolean Identifica o resultado da execução, se executado com 
     *                 sucesso TRUE, caso contrário FALSE
     */
    public function alterar() {
        $sChave = $this->getStringChave();

        $aCamposValores = $this->getArrayCamposValores(false, true);

        $sCampos = '';
        foreach ($aCamposValores as $key => $value) {
            if ($sCampos != '') {
                $sCampos .= ',';
            }
            if ($value == "''") {
                $value = 'null';
            }
            $sCampos .= $key . '=' . $value;
        }

        $sSql = 'UPDATE ' . $this->getTabela() . ' SET ' . $sCampos . ' WHERE ' . $sChave;

        /*  $fp = fopen("bloco1.txt", "w");
          fwrite($fp, $sSql);
          fclose($fp); */

        return $this->executaSql($sSql);
    }

    /**
     * Método que realiza a operação de incremento quando um campo for definido como autoincremento
     * Busca o valor máximo + 1
     * 
     * @param string $sNomeColuna Nome da coluna que irá realizar a busca
     * @return integer 
     */
    public function getIncremento($sNomeColuna, $bFiltraWhere = true) {

        $sWhere = "";
        if ($bFiltraWhere) {
            $sWhere = $this->getChaveIncremento() ? $this->getStringWhereByChave(true) : $this->getStringWhere();
        }
        $sSql = 'SELECT COALESCE(MAX(' . $sNomeColuna . '),0)+1 AS proximo FROM ' . $this->getTabela() . $sWhere;

        $obj = $this->consultaSql($sSql);

        return $obj->proximo;
    }

    /**
     * Método que retorna o último registro da coluna sem incremento
     * 
     * @param string $sNomeColuna Nome da coluna que irá realizar a busca
     * @return integer 
     */
    public function getMaxRegistro($sNomeColuna, $bFiltraWhere = true) {

        $sWhere = "";
        if ($bFiltraWhere) {
            $sWhere = $this->getChaveIncremento() ? $this->getStringWhereByChave(true) : $this->getStringWhere();
        }
        $sSql = 'SELECT COALESCE(MAX(' . $sNomeColuna . '),0) AS proximo FROM ' . $this->getTabela() . $sWhere;

        $obj = $this->consultaSql($sSql);

        return $obj->proximo;
    }

    /**
     * Método que realiza a operação de busca do maior registro de uma tabela
     * com base em um array de campos e o retorna     
     * 
     * @param $aColunas Opcional array contendo o nome das colunas que devem ser 
     *                  inseridas no Order By
     * @return object 
     */
    public function getUltimo($aColunas = null) {
        $this->setLimit(1);

        foreach ($aColunas as $sColuna) {
            $this->adicionaOrderBy($sColuna, 1);
        }

        $sSql = "SELECT * FROM " . $this->getTabela() . $this->getStringWhere() . $this->getStringOrderBy() . $this->getStringLimit();

        return $this->consultaSql($sSql);
    }

    /**
     * Método que realiza a contagem de registros da tabela
     * 
     * @return integer 
     */
    public function getCount() {
        $sSql = 'SELECT COUNT(*) AS total FROM ' . $this->getTabela() . $this->getStringJoin() . $this->getStringWhere();

        $obj = $this->consultaSql($sSql);

        return $obj->total;
    }

    /**
     * Método que realiza a soma de uma coluna conforme parâmetro passado
     * 
     * @param string $sNome Nome da coluna a ser totalizada
     * 
     * @return integer Resultado da totalização
     */
    public function getSoma($sNome) {
        $sSql = 'SELECT COALESCE(SUM(' . $sNome . '),0) AS total FROM ' . $this->getTabela() . $this->getStringJoin() . $this->getStringWhere();

        $obj = $this->consultaSql($sSql);

        return $obj->total;
    }

    /**
     * Método que realiza a consulta sql e carrega o model a partir dos
     * atributos setados que representam a chave da tabela
     * 
     * @return oModel Retorna o objeto Model com as informações carregadas
     * @throws Exception 
     */
    public function consultar($bWhere = null) {

        $sSql = $this->getSqlSelect() . $this->getStringWhereByChave();



        $result = $this->getObjetoSql($sSql);

        /* $fp = fopen("bloco1.txt", "w");
          fwrite($fp, $sSql);
          fclose($fp); */

        if (count($result) > 0) {
            $oModel = $this->getNewModel();

            $oRowBD = $result->fetch(PDO::FETCH_OBJ);

            $this->Model = $this->carregaModelBanco($oModel, $oRowBD);
        }
        return $this->Model;
    }

    /**
     * Método que realiza a consulta sql e carrega o model a partir dos
     * atributos setados que representam a chave da tabela
     * 
     * @return oModel Retorna o objeto Model com as informações carregadas
     * @throws Exception 
     */
    public function consultarWhere() {

        $sSql = $this->getSqlSelect() . $this->getStringWhere();

        $result = $this->getObjetoSql($sSql);

        if (count($result) > 0) {
            $oModel = $this->getNewModel();

            $oRowBD = $result->fetch(PDO::FETCH_OBJ);

            $this->Model = $this->carregaModelBanco($oModel, $oRowBD);
        }
        return $this->Model;
    }

    /**
     * Método que realiza a consulta sql e carrega o model a partir dos
     * requesitos para pesquisa em campos de consulta
     */
    public function consultarCampoBusca() {

        $sSql = $this->getSqlSelect();

        $result = $this->getObjetoSql($sSql);

        if ($result->rowCount() > 0) {
            $oModel = $this->getNewModel();

            $oRowBD = $result->fetch(PDO::FETCH_OBJ);

            $this->Model = $this->carregaModelBanco($oModel, $oRowBD);
        }
        return $this->Model;
    }

    /**
     * Retorna um vetor contendo a lista de campos com seus respectivos valores 
     * 
     * @param boolean $bIncluiChave Indica se os campos chave serão incluídos na listagem
     * @param boolean $bCamposSemValor Indica se deve incluir campos sem valor na listagem
     * 
     * @return Array Retorna um array com as informações carregadas
     */
    public function getArrayCamposValores($bIncluiChave = true, $bCamposSemValor = false) {
        $aCamposValores = array();

        //percorre a lista de campos e preenche os vetores correspondentes
        foreach ($this->getListaRelacionamento() as $oCampoBanco) {
            if ($oCampoBanco->getPersiste()) {  //verifica se o campo atual deve ser persistido
                /*
                 * inclui os campos que não são chave e os que são chave desde que o parâmetro 
                 * $bIncluiChave seja verdadeiro
                 */
                if ((!$oCampoBanco->getChave()) || ($oCampoBanco->getChave() && $bIncluiChave)) {
                    //se o campo atual for autoincremento busca o valor para gravação
                    if ($oCampoBanco->getAutoIncremento()) {
                        $sValor = $this->getIncremento($oCampoBanco->getNomeBanco());
                        Controller::setValorModel($this->Model, $oCampoBanco->getNomeModel(), $sValor, null);
                    } else {
                        $sValor = Controller::getValorModel($this->Model, $oCampoBanco->getNomeModel());
                    }
                    //se o campo for do tipo upload com detalhe definido na persistencia
                    if ($oCampoBanco->getTipoCampo() == 3 && $sValor == null) {
                        $bCamposSemValor = false;
                    }

                    if ((($sValor !== null && $sValor !== "" && $sValor !== false) || $sValor === 0) || $bCamposSemValor) {
                        $aCamposValores[$oCampoBanco->getNomeBanco()] = "'" . $sValor . "'";
                    }
                }
            }
        }
        return $aCamposValores;
    }

    /**
     * Método que retorna um array de objetos model com base em uma consulta
     * sql
     * 
     * @return array Array contendo objetos model 
     */
    public function getArrayModel($bFiltraByChave = false) {
        $aRetorno = array();

        $sSql = $this->getBConsultaManual() ? $this->consultaManual() : $this->getSqlSelect();
        $sSql .= $bFiltraByChave ? $this->getStringWhereByChave() : $this->getStringWhere();
        $sSql .= $this->getSWhereManual(); //define partes do where manualmente
        $sSql .= $this->getStringGroupBy() . $this->getStringOrderBy() . $this->getStringLimit();

        /*
          $fp = fopen("bloco1.txt", "w");
          fwrite($fp, $sSql);
          fclose($fp);
         * 
         */

        $result = $this->getObjetoSql($sSql);

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $oModel = $this->getNewModel();

            $this->carregaModelBanco($oModel, $oRowBD);

            //adiciona o objeto atual ao array de retorno
            $aRetorno[] = $oModel;
        }
        return $aRetorno;
    }

    /**
     * Gera consultar sql manuais no entando jogam para o model como o getArrayCampo
     */
    public function getArrayModelManual($bFiltraByChave = false) {
        $aRetorno = array();
        $sSql = $this->getConsultaSqlManual();

        $result = $this->getObjetoSql($sSql);

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $oModel = $this->getNewModel();

            $this->carregaModelBanco($oModel, $oRowBD);

            $aRetorno[] = $oModel;
        }
        return $aRetorno;
    }

    /**
     * Método que retorna uma string contendo os campos chave, utilizado
     * principalmente nas consultas para realizar alterações e exclusões
     * 
     * @param Object Objeto model a ser verificado
     * 
     * @return string
     * @throws Exception 
     */
    public function getChaveModel($oModel) {
        $sChave = "";
        foreach ($this->getListaRelacionamento() as $oCampoBanco) {
            if ($oCampoBanco->getChave()) {
                if ($sChave != "") {
                    $sChave .= "&";
                }

                $sValor = Controller::getValorModel($oModel, $oCampoBanco->getNomeModel());

                if (!$sValor) {
                    $sValor = '';
                } else {
                    $sChave .= $oCampoBanco->getNomeModel() . "=" . $sValor;
                }
            }
        }
        return $sChave;
    }

    /**
     * Método que retorna um array contendo os campos chave
     * 
     * @return array
     */
    public function getChaveArray() {
        $aChave = array();
        foreach ($this->getListaRelacionamento() as $oCampoBanco) {
            if ($oCampoBanco->getChave()) {
                $aChave[] = $oCampoBanco;
            }
        }
        return $aChave;
    }

    /**
     * Método que retorna um array contendo os campos autoincremento
     * 
     * @return array
     */
    public function getAutoIncrementoArray() {
        $aAuto = array();
        foreach ($this->getListaRelacionamento() as $oCampoBanco) {
            if ($oCampoBanco->getAutoIncremento()) {
                $aAuto[] = $oCampoBanco;
            }
        }
        return $aAuto;
    }

    /**
     * Método que retorna uma array contendo os campos do tipo CampoBanco
     * a partir de um array contendo o nome do campo no model que é passado
     * por parâmetro
     * 
     * @param $aCamposModel Array contendo os nomes do campo no model
     * 
     * @return array
     */
    public function getArrayCampos($aCamposModel) {
        $aCampos = array();
        foreach ($this->getListaRelacionamento() as $oCampoBanco) {
            if (in_array($oCampoBanco->getNomeModel(), $aCamposModel)) {
                $aCampos[] = $oCampoBanco;
            }
        }
        return $aCampos;
    }

    /**
     * Método que retorna o nome do campo no banco a partir do nome nos models
     * setados no relacionamento
     * 
     * @param $sNomeModel String contendo o nome do campo no model
     * 
     * @return string Nome do campo no BD
     */
    public function getNomeBanco($sNomeModel) {
        $sNomeBanco = "";

        //percorre os campos do relacionamento principal
        foreach ($this->getListaRelacionamento() as $oCampoBanco) {
            if ($oCampoBanco->getNomeModel() == $sNomeModel) {
                $sNomeBanco = $oCampoBanco->getNomeBanco();
                break;
            }
        }

        //percorre os campos de totalização
        foreach ($this->getListaTotaliza() as $aTotalizador) {
            if ($aTotalizador['campoModel'] == $sNomeModel) {
                $oPersTotal = Fabrica::FabricarPersistencia($aTotalizador['classe']);
                $sNomeCampoBD = $oPersTotal->getNomeBanco($aTotalizador['campoTotaliza']);
                $sTipo = self::$TIPO_TOTALIZA[$aTotalizador['tipoTotaliza']];

                $sNomeBanco = $sNomeCampoBD . $sTipo;
                break;
            }
        }

        //percorre os campos calculados
        foreach ($this->getListaCamposCalculados() as $aCalculo) {
            if ($aCalculo['campoModel'] == $sNomeModel) {
                $sNomeBanco = $aCalculo['alias'];
                break;
            }
        }

        //se não encontrou o campo no model principal percorre as tabelas de ligação
        if ($sNomeBanco === "") {
            $bAchou = false;
            $sNomeClasse = substr($sNomeModel, 0, strpos($sNomeModel, "."));
            $sNomeModel = substr($sNomeModel, strpos($sNomeModel, ".") + 1);
            foreach ($this->getListaJoin() as $aJoin) {
                if (strtolower($aJoin['alias']) === strtolower($sNomeClasse)) {
                    $oPersJoin = Fabrica::FabricarPersistencia($aJoin['classe']);
                    foreach ($oPersJoin->getListaRelacionamento() as $oCampoBanco) {
                        if ($oCampoBanco->getNomeModel() == $sNomeModel) {
                            $sNomeBanco = $oCampoBanco->getNomeBanco();
                            $bAchou = true;
                            break;
                        }
                    }
                }
                if ($bAchou) {
                    break;
                }
            }
        }
        /*
          //se ainda não encontrou o campo no model principal percorre as tabelas de ligação - mais um nível
          if($sNomeBanco === ""){
          $bAchou = false;
          $sNomeModel = substr($sNomeModel,strpos($sNomeModel,".")+1);
          foreach($this->getListaJoin() as $aJoin){
          $oPersJoin = Fabrica::FabricarPersistencia($aJoin['classe']);
          foreach($oPersJoin->getListaRelacionamento() as $oCampoBanco){
          if($oCampoBanco->getNomeModel() == $sNomeModel){
          $sNomeBanco = $oCampoBanco->getNomeBanco();
          $bAchou = true;
          break;
          }
          }
          if($bAchou){
          break;
          }
          }
          }
         * 
         */

        return $sNomeBanco;
    }

    /**
     * Método que verifica se determinada classe está presente na lista de 
     * ligações da tabela
     * 
     * @param string $sNomeClasse Nome da classe a ser buscada
     * @param boolean $bReturn
     */
    public function pertenceListaJoin($sNomeClasse) {
        $bReturn = false;
        foreach ($this->getListaJoin() as $aJoin) {
            if (strtolower($sNomeClasse) === strtolower($aJoin['classe'])) {
                $bReturn = true;
                break;
            }
        }
        return $bReturn;
    }

    /**
     * Método que retorna o nome do campo no model a partir do nome no banco
     * setados no relacionamento
     * 
     * @param $sNomeBanco String contendo o nome do campo no banco
     * 
     * @return string Nome do campo no model
     */
    public function getNomeModel($sNomeBanco) {
        $sNomemodel = "";

        //percorre os campos do relacionamento principal
        foreach ($this->getListaRelacionamento() as $oCampoBanco) {
            if ($oCampoBanco->getNomebanco() == $sNomeBanco) {
                $sNomemodel = $oCampoBanco->getNomeModel();
            }
        }
        return $sNomemodel;
    }

    /**
     * Método que monta e retorna a string da cláusula LIMIT, utilizado
     * principalmente nas consultas para paginação 
     * 
     * @return string
     */
    public function getStringLimit() {
        $sLimit = "";
        if ($this->getLimit() != null) {
            $sLimit = " LIMIT " . $this->getLimit();
            if ($this->getOffset() != null) {
                $sLimit .= " OFFSET " . $this->getOffset();
            }
        }
        return $sLimit;
    }

    /**
     * Método que monta e retorna a string da chave da tabela referente ao
     * model em questão para que possam ser realizadas operações de consultas e
     * exclusões
     * 
     * @return string String contendo a chave a ser usada na cláusula WHERE
     */
    public function getStringChave() {
        //monta os campos com respectivos valores para usar na cláusula WHERE
        $sChave = "";
        foreach ($this->getChaveArray() as $oCampoBanco) {
            if ($sChave != "") {
                $sChave .= " AND ";
            }

            $sValor = Controller::getValorModel($this->Model, $oCampoBanco->getNomeModel());

            if (!$sValor) {
                throw new Exception("Chave " . strtoupper($oCampoBanco->getNomeModel()) . " não setada");
            } else {
                $sChave .= $this->getTabela() . "." . $oCampoBanco->getNomeBanco() . " = '" . $sValor . "'";
            }
        }
        return $sChave;
    }

    /**
     * Método que cria o comando sql para realizar as consultas na base
     * 
     * @return string String contendo o comando a ser executado 
     */
    public function getSqlSelect() {
        $sSql = "SELECT  " . $this->getSTop()
                . $this->getListaCampos()
                . $this->getSCase()
                . $this->getCamposTotalizadores()
                . $this->getCamposCalculados()
                . $this->getCamposVirtuais()
                . " FROM " . $this->getTabela() . $this->getStringJoin();

        return $sSql;
    }

    /**
     * Método para sobscrever consultar manuais de sql
     */
    public function getConsultaSqlManual() {
        
    }

    /*
     * Método para reescrever
     */

    public function consultaManual() {
        
    }

    /**
     * Método responsável por preparar strings para que possam serem inseridas no MSSQL SERVER
     * e lidas no JQuery sem que ocorram problemas
     * 
     * @param string $str
     * @return string 
     * @author Carlos
     */
    public function preparaString($str) {
        if (is_string($str)) {

            if (Config::TIPO_BD == Config::BD_MYSQL) {
                $sRetorno = str_replace("'", '"', $str);
            } else {
                $sRetorno = str_replace("'", "''", $str);
                //$value = str_replace( '"', '""', $str );
            }
        }

        return $sRetorno;
    }

    /**
     * Método para ser substituido
     */

    /** aqui este método não faz nada, mas é sobrescrito pelas classes filhas
     *  para fazer outras ações dentro da mesma transação
     * @return boolean
     */
    public function afterInsert($aCampos) {
        
    }

    /**
     * arruma valores para salvar no banco
     */
    function ValorSql($valor) {
        $verificaPonto = ".";
        if (strpos("[" . $valor . "]", "$verificaPonto")):
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
        else:
            $valor = str_replace(',', '.', $valor);
        endif;

        return $valor;
    }

}

?>