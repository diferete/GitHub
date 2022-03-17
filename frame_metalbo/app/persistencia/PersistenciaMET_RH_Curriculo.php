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
        $sSqlMax = "select MAX(nr) + 1 as nr  from MET_RH_Curriculo";
        $oMax = $this->consultaSql($sSqlMax);

        $aEstados = array();
        if ($oMax->nr == null) {
            $oDados->nr = 1;
        }

        foreach ($oDados as $key => $value) {
            if ($value == null) {
                $oDados->$key = null;
            }
        }

        $oDados->altura = Util::ValorSql($oDados->altura);
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
                . "75483040000211," . $oDados->nr . ",'" . $oDados->nomeCurr . "','" . $oDados->dataNasc . "', '" . $oDados->pais . "', '" . $aEstados[0] . "', "
                . "'" . $oDados->cidade . "', '" . $oDados->genero . "', " . $oDados->altura . ", " . $oDados->peso . ", '" . $oDados->estCivil . "', '" . $oDados->conjuge . "',"
                . "'" . $oDados->dateNascConj . "', " . $oDados->filhos . ", '" . $oDados->menor14 . "', '" . $oDados->mae . "', '" . $oDados->pai . "', '" . $oDados->pcd . "',"
                . "'" . $oDados->tipopcd . "', '" . $oDados->email . "', '" . $oDados->fone . "', '" . $oDados->rua . "', '" . $oDados->bairro . "', " . $oDados->numero . ", "
                . "" . $oDados->cep . ", '" . $aEstados[1] . "', '" . $oDados->cidadeMora . "', " . $oDados->tempoMora . ", '" . $aEstados[2] . "', '" . $oDados->cidadeAnt . "',"
                . "" . $oDados->rg . ", " . $oDados->cpf . ", " . $oDados->ctps . ", " . $oDados->seriectps . ", " . $oDados->titeleitor . ", " . $oDados->pis . ", "
                . "'" . $oDados->escolaridade . "', '" . $oDados->entidade . "', '" . $oDados->curso . "', '" . $oDados->Empresa1 . "', '" . $aEstados[3] . "',"
                . "'" . $oDados->cidadeEmpresa1 . "', '" . $oDados->foneEmpresa1 . "', '" . $oDados->date1Empresa1 . "',' " . $oDados->date2Empresa1 . "', '" . $oDados->Empresa2 . "',"
                . "'" . $aEstados[4] . "', '" . $oDados->cidadeEmpresa2 . "', '" . $oDados->foneEmpresa2 . "', '" . $oDados->date1Empresa2 . "', '" . $oDados->date2Empresa2 . "',"
                . "'" . $oDados->Empresa3 . "', '" . $aEstados[5] . "', '" . $oDados->cidadeEmpresa3 . "', '" . $oDados->foneEmpresa3 . "', '" . $oDados->date1Empresa3 . "',"
                . "'" . $oDados->date2Empresa3 . "')";
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
