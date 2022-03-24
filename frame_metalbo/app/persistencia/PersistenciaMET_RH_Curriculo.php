<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersistenciaMET_RH_Curriculo
 *
 * @author Alexandre
 */
class PersistenciaMET_RH_Curriculo extends Persistencia {

    public function __construct() {
        parent::__construct();
    }

    public function insereDadosCurriculo($oDados) {


        $oDados->altura = Util::ValorSql($oDados->altura);
        $aDadosInsert = array();
        foreach ($oDados as $key => $value) {
            if ($value == '' || $value == null) {
                $aDadosInsert[$key] = '';
            } else {
                $aDadosInsert[$key] = $value;
            }
        }

        if ($aDadosInsert['altura'] == '') {
            $aDadosInsert['altura'] = 'null';
        }
        if ($aDadosInsert['peso'] == '') {
            $aDadosInsert['peso'] = 'null';
        }
        if ($aDadosInsert['filhos'] == '') {
            $aDadosInsert['filhos'] = 'null';
        }
        if ($aDadosInsert['numero'] == '') {
            $aDadosInsert['numero'] = 'null';
        }
        if ($aDadosInsert['cep'] == '') {
            $aDadosInsert['cep'] = 'null';
        }
        if ($aDadosInsert['tempoMora'] == '') {
            $aDadosInsert['tempoMora'] = 'null';
        }


        $sSqlMax = "select MAX(nr) + 1 as nr  from MET_RH_Curriculo";
        $oMax = $this->consultaSql($sSqlMax);



        if ($oMax->nr == null) {
            $aDadosInsert['nr'] = 1;
        } else {
            $aDadosInsert['nr'] = $oMax->nr;
        }


        $aEstados = array();
        array_push($aEstados, $oDados->ufNaturalidade);
        array_push($aEstados, $oDados->ufMora);
        array_push($aEstados, $oDados->ufAnt);
        array_push($aEstados, $oDados->ufEmpresa1);
        array_push($aEstados, $oDados->ufEmpresa2);
        array_push($aEstados, $oDados->ufEmpresa3);

        $aEstados = $this->getEstado($aEstados);

        $sSqlInsert = "insert into MET_RH_Curriculo("
                . "filcgc,nr,nome, dataNasc, pais, ufNaturalidade, cidade, genero, altura, peso, estCivil, conjuge, dateNascConj, filhos, menor14, mae, pai, pcd, tipopcd, "
                . "email, fone, rua, bairro, numero, cep, ufMora, cidadeMora, tempoMora, ufAnt, cidadeAnt, rg, cpf, ctps, seriectps, titeleitor, pis, "
                . "escolaridade, entidade, curso, Empresa1, ufEmpresa1, cidadeEmpresa1, foneEmpresa1, date1Empresa1, date2Empresa1, Empresa2, ufEmpresa2, "
                . "cidadeEmpresa2, foneEmpresa2, date1Empresa2, date2Empresa2, Empresa3, ufEmpresa3, cidadeEmpresa3, foneEmpresa3, date1Empresa3, date2Empresa3)"
                . "values("
                . "75483040000211," . $aDadosInsert['nr'] . ",'" . $aDadosInsert['nomeCurr'] . "','" . $aDadosInsert['dataNasc'] . "', '" . $aDadosInsert['pais'] . "', '" . $aEstados[0] . "', "
                . "'" . $aDadosInsert['cidade'] . "', '" . $aDadosInsert['genero'] . "', " . $aDadosInsert['altura'] . ", " . $aDadosInsert['peso'] . ", '" . $aDadosInsert['estCivil'] . "', '" . $aDadosInsert['conjuge'] . "',"
                . "'" . $aDadosInsert['dateNascConj'] . "', " . $aDadosInsert['filhos'] . ", '" . $aDadosInsert['menor14'] . "', '" . $aDadosInsert['mae'] . "', '" . $aDadosInsert['pai'] . "', '" . $aDadosInsert['pcd'] . "',"
                . "'" . $aDadosInsert['tipopcd'] . "', '" . $aDadosInsert['email'] . "', '" . $aDadosInsert['fone'] . "', '" . $aDadosInsert['rua'] . "', '" . $aDadosInsert['bairro'] . "', " . $aDadosInsert['numero'] . ", "
                . "" . $aDadosInsert['cep'] . ", '" . $aEstados[1] . "', '" . $aDadosInsert['cidadeMora'] . "', " . $aDadosInsert['tempoMora'] . ", '" . $aEstados[2] . "', '" . $aDadosInsert['cidadeAnt'] . "',"
                . "" . $aDadosInsert['rg'] . ", " . $aDadosInsert['cpf'] . ", " . $aDadosInsert['ctps'] . ", " . $aDadosInsert['seriectps'] . ", " . $aDadosInsert['titeleitor'] . ", " . $aDadosInsert['pis'] . ", "
                . "'" . $aDadosInsert['escolaridade'] . "', '" . $aDadosInsert['entidade'] . "', '" . $aDadosInsert['curso'] . "', '" . $aDadosInsert['Empresa1'] . "', '" . $aEstados[3] . "',"
                . "'" . $aDadosInsert['cidadeEmpresa1'] . "', '" . $aDadosInsert['foneEmpresa1'] . "', '" . $aDadosInsert['date1Empresa1'] . "','" . $aDadosInsert['date2Empresa1'] . "', '" . $aDadosInsert['Empresa2'] . "',"
                . "'" . $aEstados[4] . "', '" . $aDadosInsert['cidadeEmpresa2'] . "', '" . $aDadosInsert['foneEmpresa2'] . "', '" . $aDadosInsert['date1Empresa2'] . "', '" . $aDadosInsert['date2Empresa2'] . "',"
                . "'" . $aDadosInsert['Empresa3'] . "', '" . $aEstados[5] . "', '" . $aDadosInsert['cidadeEmpresa3'] . "', '" . $aDadosInsert['foneEmpresa3'] . "', '" . $aDadosInsert['date1Empresa3'] . "',"
                . "'" . $aDadosInsert['date2Empresa3'] . "')";
        $aRetorno = $this->executaSql($sSqlInsert);

        return $aRetorno;
    }

    public function getEstado($aEstados) {

        foreach ($aEstados as $key => $value) {
            switch ($value) {
                case 12:
                    $aEstados[$key] = 'Acre';
                    break;
                case 27:
                    $aEstados[$key] = 'Alagoas';
                    break;
                case 16:
                    $aEstados[$key] = 'Amapá';
                    break;
                case 13:
                    $aEstados[$key] = 'Amazonas';
                    break;
                case 29:
                    $aEstados[$key] = 'Bahia';
                    break;
                case 23:
                    $aEstados[$key] = 'Ceará';
                    break;
                case 53:
                    $aEstados[$key] = 'Distrito Federal';
                    break;
                case 32:
                    $aEstados[$key] = 'Espírito Santo';
                    break;
                case 52:
                    $aEstados[$key] = 'Goiás';
                    break;
                case 21:
                    $aEstados[$key] = 'Maranhão';
                    break;
                case 51:
                    $aEstados[$key] = 'Mato Grosso';
                    break;
                case 50:
                    $aEstados[$key] = 'Mato Grosso do Sul';
                    break;
                case 31:
                    $aEstados[$key] = 'Minas Gerais';
                    break;
                case 41:
                    $aEstados[$key] = 'Paraná';
                    break;
                case 25:
                    $aEstados[$key] = 'Paraíba';
                    break;
                case 15:
                    $aEstados[$key] = 'Pará';
                    break;
                case 26:
                    $aEstados[$key] = 'Pernambuco';
                    break;
                case 22:
                    $aEstados[$key] = 'Piauí';
                    break;
                case 33:
                    $aEstados[$key] = 'Rio de Janeiro';
                    break;
                case 24:
                    $aEstados[$key] = 'Rio Grande do Norte';
                    break;
                case 43:
                    $aEstados[$key] = 'Rio Grande do Sul';
                    break;
                case 11:
                    $aEstados[$key] = 'Rondônia';
                    break;
                case 14:
                    $aEstados[$key] = 'Roraima';
                    break;
                case 42:
                    $aEstados[$key] = 'Santa Catarina';
                    break;
                case 28:
                    $aEstados[$key] = 'Sergipe';
                    break;
                case 35:
                    $aEstados[$key] = 'São Paulo';
                    break;
                case 17:
                    $aEstados[$key] = 'Tocantins';
                    break;
            }
        }
        return $aEstados;
    }

}
