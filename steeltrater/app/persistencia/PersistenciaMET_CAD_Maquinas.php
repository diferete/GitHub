<?php

/*
 * Implementa a classe persistencia MET_CAD_Maquinas
 * @author Cleverton Hoffmann
 * @since 13/07/2021
 */

class PersistenciaMET_CAD_Maquinas extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_CAD_Maquinas');

        $this->adicionaRelacionamento('fil_codigo', 'fil_codigo', true, true);
        $this->adicionaRelacionamento('fil_codigo', 'DELX_FIL_Empresa.fil_codigo', false, false);
        $this->adicionaRelacionamento('cod', 'cod', true, true, true);
        $this->adicionaRelacionamento('maquina', 'maquina');
        $this->adicionaRelacionamento('codigoMaq', 'codigoMaq');
        $this->adicionaRelacionamento('bitola', 'bitola');
        $this->adicionaRelacionamento('seq', 'seq');
        $this->adicionaRelacionamento('maqtip', 'maqtip');
        $this->adicionaRelacionamento('cat', 'cat');
        $this->adicionaRelacionamento('nomeclatura', 'nomeclatura');
        $this->adicionaRelacionamento('fabricante', 'DELX_CAD_Pessoa.emp_codigo', false, false);
        $this->adicionaRelacionamento('fabricante', 'fabricante');
        $this->adicionaRelacionamento('modelo', 'modelo');
        $this->adicionaRelacionamento('anofab', 'anofab');
        $this->adicionaRelacionamento('capacidade', 'capacidade');
        $this->adicionaRelacionamento('produtividade', 'produtividade');
        $this->adicionaRelacionamento('tempoOpera', 'tempoOpera');
        $this->adicionaRelacionamento('operadores', 'operadores');
        $this->adicionaRelacionamento('adequadonr12', 'adequadonr12');
        $this->adicionaRelacionamento('codsetor', 'MET_CAD_setores.codsetor', false, false);
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('fornecedor', 'DELX_CAD_Pessoa2.emp_codigo', false, false);
        $this->adicionaRelacionamento('fornecedor', 'fornecedor');
        $this->adicionaRelacionamento('serie', 'serie');
        $this->adicionaRelacionamento('patrimonio', 'patrimonio');
        $this->adicionaRelacionamento('peso02', 'peso02');
        $this->adicionaRelacionamento('alimentacao', 'alimentacao');
        $this->adicionaRelacionamento('protfixa', 'protfixa');
        $this->adicionaRelacionamento('metalica', 'metalica');
        $this->adicionaRelacionamento('madeira', 'madeira');
        $this->adicionaRelacionamento('tela', 'tela');
        $this->adicionaRelacionamento('acrilico', 'acrilico');
        $this->adicionaRelacionamento('poli', 'poli');
        $this->adicionaRelacionamento('protmovel', 'protmovel');
        $this->adicionaRelacionamento('metalicamov', 'metalicamov');
        $this->adicionaRelacionamento('madeiramov', 'madeiramov');
        $this->adicionaRelacionamento('telamov', 'telamov');
        $this->adicionaRelacionamento('acrilicomov', 'acrilicomov');
        $this->adicionaRelacionamento('polimov', 'polimov');
        $this->adicionaRelacionamento('sisseg', 'sisseg');
        $this->adicionaRelacionamento('cortluz', 'cortluz');
        $this->adicionaRelacionamento('laser', 'laser');
        $this->adicionaRelacionamento('optica', 'optica');
        $this->adicionaRelacionamento('batente', 'batente');
        $this->adicionaRelacionamento('scanner', 'scanner');
        $this->adicionaRelacionamento('tapete', 'tapete');
        $this->adicionaRelacionamento('chaveseg', 'chaveseg');
        $this->adicionaRelacionamento('magnetica', 'magnetica');
        $this->adicionaRelacionamento('eletromec', 'eletromec');
        $this->adicionaRelacionamento('intseg', 'intseg');
        $this->adicionaRelacionamento('relesseg', 'relesseg');
        $this->adicionaRelacionamento('clp', 'clp');
        $this->adicionaRelacionamento('sitmaq', 'sitmaq');
        $this->adicionaRelacionamento('zonaprotfixa', 'zonaprotfixa');
        $this->adicionaRelacionamento('zonaprotmovel', 'zonaprotmovel');
        $this->adicionaRelacionamento('zonaprotseg', 'zonaprotseg');
        $this->adicionaRelacionamento('partida', 'partida');
        $this->adicionaRelacionamento('partidabaixatensao', 'partidabaixatensao');
        $this->adicionaRelacionamento('partidaisolacao', 'partidaisolacao');
        $this->adicionaRelacionamento('parada', 'parada');
        $this->adicionaRelacionamento('paradabaixatensao', 'paradabaixatensao');
        $this->adicionaRelacionamento('paradaisolacao', 'paradaisolacao');
        $this->adicionaRelacionamento('emergencia', 'emergencia');
        $this->adicionaRelacionamento('emergenciabaixatensao', 'emergenciabaixatensao');
        $this->adicionaRelacionamento('emeriso', 'emeriso');
        $this->adicionaRelacionamento('emercabo', 'emercabo');
        $this->adicionaRelacionamento('emercabobaixatensao', 'emercabobaixatensao');
        $this->adicionaRelacionamento('emercaboiso', 'emercaboiso');
        $this->adicionaRelacionamento('rearme', 'rearme');
        $this->adicionaRelacionamento('resetbaixatensao', 'resetbaixatensao');
        $this->adicionaRelacionamento('resetiso', 'resetiso');
        $this->adicionaRelacionamento('sportugues', 'sportugues');
        $this->adicionaRelacionamento('choque', 'choque');
        $this->adicionaRelacionamento('relpatrimonio', 'relpatrimonio');
        $this->adicionaRelacionamento('empcnpj', 'empcnpj');
        $this->adicionaRelacionamento('tipmanut', 'tipmanut');
        $this->adicionaRelacionamento('obs', 'obs');
        $this->adicionaRelacionamento('cct_codigo', 'cct_codigo');
        $this->adicionaRelacionamento('cct_codigo', 'STEEL_CCT_CentroCusto.cct_codigo', false, false, false);

        $this->adicionaOrderBy('cod', 1);

        $this->adicionaJoin('DELX_FIL_EMPRESA');
        
        $this->adicionaJoin('STEEL_CCT_CentroCusto');

        $this->adicionaJoin('DELX_CAD_Pessoa', null, 1, 'fabricante', 'emp_codigo');

        $this->adicionaJoin('DELX_CAD_Pessoa', 'DELX_CAD_Pessoa2', 1, 'fornecedor', 'emp_codigo');

        $this->adicionaJoin('MET_CAD_setores', null, 1, 'codsetor', 'codsetor');

        /**
         * Filtra por empresa para quando buscar pelo campo pesquisa máquina na tela de manutenção
         * E filtra conforme setor e célula inserida para inserção da manuteção
         */
        if (isset($_REQUEST['campos'])) {
            if ($_REQUEST['campos'] !== "" && $_REQUEST['campos'] !== null) {
                $sDados = $_REQUEST['campos'];
                $aDados = explode('&', $sDados);
                $sChave = htmlspecialchars_decode($aDados[1]);
                $aCamposChave = array();
                parse_str($sChave, $aCamposChave);
                if ($aCamposChave['fil_codigo'] !== null) {
                    $this->adicionaFiltro('fil_codigo', $aCamposChave['fil_codigo']);
                }
                $sChave = htmlspecialchars_decode($aDados[9]);
                $aCamposChave = array();
                parse_str($sChave, $aCamposChave);
                if ($aCamposChave['codsetor'] !== null && $aCamposChave['codsetor'] !== '') {
                    $this->adicionaFiltro('codsetor', $aCamposChave['codsetor']);
                }
                $sChave = htmlspecialchars_decode($aDados[10]);
                $aCamposChave = array();
                parse_str($sChave, $aCamposChave);
                if ($aCamposChave['seq'] !== null && $aCamposChave['seq'] !== '') {
                    $this->adicionaFiltro('seq', $aCamposChave['seq']);
                }
            }
        }

        $this->setSTop(25);
    }

    /**
     * Método que retorna a quantidade de máquinas cadastradas com o determinado código
     * @param type $aDados
     * @return type
     */
    public function buscaDadosMaq($aDados) {
        $sSql = "SELECT COUNT(cod) as cont FROM MET_CAD_Maquinas WHERE codigoMaq  = " . $aDados['codigoMaq'] . "  AND fil_codigo = " . $aDados['fil_codigo'] . " AND cod <> " . $aDados['cod'] . " AND sitmaq <> 'INATIVA'";
        $oObj = $this->consultaSql($sSql);
        return $oObj;
    }

}
