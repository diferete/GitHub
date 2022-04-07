<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewMET_FRETE_FaturaXml
 *
 * @author Alexandre
 */
class ViewMET_FRETE_FaturaXml extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oFilcgc = new CampoConsulta('filcgc', 'filcgc');

        $oCnpj = new CampoConsulta('CNPJ', 'cnpj');

        $oEmpDes = new CampoConsulta('Empresa', 'Pessoa.empdes');

        $oData = new CampoConsulta('Data', 'dataUpload', CampoConsulta::TIPO_DATA);

        $oArquivo = new CampoConsulta('Arquivo', 'arquivo');

        $oExtraido = new CampoConsulta('Extraido', 'extraido');

        $this->setUsaFiltro(true);

        $oFilCNPJ = new Filtro($oCnpj, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);
        $oFilEmpDes = new Filtro($oEmpDes, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);

        $this->addFiltro($oFilCNPJ, $oFilEmpDes);
        $this->addCampos($oFilcgc, $oCnpj, $oEmpDes, $oData, $oArquivo, $oExtraido);
    }

    public function criaTela() {
        parent::criaTela();

        $aDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Filcgc', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setBCampoBloqueado(true);
        $oFilcgc->setSValor($_SESSION['filcgc']);

        $oUsuario = new Campo('usuario', 'usuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuario->setBCampoBloqueado(true);
        $oUsuario->setSValor($_SESSION['nome']);



        $oCnpj = new Campo('CNPJ', 'cnpj', Campo::CAMPO_SELECT, 4);
        foreach ($aDados as $key) {
            $val = (int) $key['cnpj'];
            $oCnpj->addItemSelect($val, $val . ' - ' . $key['empdes']);
        }
        $oCnpj->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório');


        $oArquivo = new Campo('Arquivo', 'arquivo', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        $oArquivo->setSDiretorio('xml-cte');
        $oArquivo->setBArquivoFrete(true);
        //$oArquivo->setBNomeArquivo(true);

        $oFatura = new Campo('fatura', 'fatura', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oDataEmit = new Campo('Dt. Emissão', 'dataEmit', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oDataVenc = new Campo('Dt. Vencimento', 'dataVenc', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oDataUpload = new Campo('dataUpload', 'dataUpload', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        date_default_timezone_set('America/Sao_Paulo');
        $oDataUpload->setSValor(date('d/m/Y'));
        $oDataUpload->setBOculto(true);

        $oHoraUpload = new Campo('horaUpload', 'horaUpload', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        date_default_timezone_set('America/Sao_Paulo');
        $oHoraUpload->setSValor(date('H:i:s'));
        $oHoraUpload->setBOculto(true);

        $oExtraido = new Campo('', 'extraido', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oExtraido->setSValor('N');
        $oExtraido->setBOculto(true);

        $this->addCampos(array($oFilcgc, $oUsuario), $oCnpj, array($oFatura, $oDataEmit, $oDataVenc), $oArquivo, $oDataUpload, $oHoraUpload, $oExtraido);
    }

}
