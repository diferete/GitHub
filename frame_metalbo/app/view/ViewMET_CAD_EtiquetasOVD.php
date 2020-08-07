<?php 
 /*
 * Implementa a classe view MET_CAD_EtiquetasOVD
 * @author Cleverton Hoffmann
 * @since 08/07/2020
 */
 
class ViewMET_CAD_EtiquetasOVD extends View {
 
    public function __construct() {
        parent::__construct();
       }
 
    public function criaConsulta() { 
        parent::criaConsulta();
 
        $this->setUsaAcaoVisualizar(true);
        $this->getTela()->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $oprocod = new CampoConsulta('Cod. Produto', 'procod', CampoConsulta::TIPO_TEXTO);
        $ocodovd = new CampoConsulta('Cod. OVD', 'codovd', CampoConsulta::TIPO_TEXTO);
        $odescovd = new CampoConsulta('Descrição OVD', 'descovd', CampoConsulta::TIPO_TEXTO);
        $odescricao = new CampoConsulta('Des. Tipo', 'descricao', CampoConsulta::TIPO_TEXTO);
        $odescricao2 = new CampoConsulta('Des. Especificação', 'descricao2', CampoConsulta::TIPO_TEXTO);
        $omedida = new CampoConsulta('Medida', 'medida', CampoConsulta::TIPO_TEXTO);
        $oean = new CampoConsulta('EAN', 'ean', CampoConsulta::TIPO_TEXTO);
        $opecas = new CampoConsulta('Peças/centos', 'pecas', CampoConsulta::TIPO_DECIMAL);
        $ocentosnormal = new CampoConsulta('Centos Normal', 'centosnormal', CampoConsulta::TIPO_DECIMAL);
        $ocentosmaster = new CampoConsulta('Centos Master', 'centosmaster', CampoConsulta::TIPO_DECIMAL);
        $odescesp = new CampoConsulta('Desc. Esp.', 'descesp', CampoConsulta::TIPO_TEXTO);
        $orosca = new CampoConsulta('Rosca', 'rosca', CampoConsulta::TIPO_TEXTO);
        $otipo = new CampoConsulta('Tipo Caixa', 'tipo', CampoConsulta::TIPO_TEXTO);
 
        $oFiltroCod = new Filtro($oprocod, Filtro::CAMPO_TEXTO);
        $oFiltroCodOvd = new Filtro($ocodovd, Filtro::CAMPO_TEXTO);
        
        $this->addFiltro($oFiltroCod, $oFiltroCodOvd);
        
        $this->addCampos($oprocod, $ocodovd, $odescovd, $odescricao, $odescricao2, $omedida, $oean, $opecas, $otipo, $ocentosnormal, $ocentosmaster, $odescesp, $orosca);
    }
 
    public function criaTela() { 
        parent::criaTela();
 

        $oprocod = new Campo('Cod. Produto', 'procod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ocodovd = new Campo('Cod. OVD', 'codovd', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odescovd = new Campo('Descrição OVD', 'descovd', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $odescricao = new Campo('Des. Tipo', 'descricao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $odescricao2 = new Campo('Des. Especificação', 'descricao2', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $omedida = new Campo('Medida', 'medida', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oean = new Campo('EAN', 'ean', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $opecas = new Campo('Peças/centos', 'pecas', Campo::TIPO_MONEY, 1, 1, 12, 12);
        $ocentosnormal = new Campo('Centos Normal', 'centosnormal', Campo::TIPO_MONEY, 1, 1, 12, 12);
        $ocentosmaster = new Campo('Centos Master', 'centosmaster', Campo::TIPO_MONEY, 1, 1, 12, 12);
        $ounmaster = new Campo('UN.Master', 'unmaster', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        //$ounmaster->setSValor('centos');
        $ounnormal = new Campo('UN.Normal', 'unnormal', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        //$ounnormal->setSValor('centos');
        $oimagem = new Campo('Imagem', 'imagem', Campo::TIPO_UPLOAD, 1, 1, 12, 12);
        $ounmed = new Campo('UN.Medida', 'unmed', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odescesp = new Campo('Des.Especial', 'descesp', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $orosca = new Campo('Rosca', 'rosca', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $otipo = new Campo('Tipo Caixa', 'tipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
 
        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);
        
        $this->addCampos(array($oprocod, $ocodovd, $odescovd, $odescricao, $odescricao2, $omedida),$oLinha1, array($oean, $opecas, $ocentosnormal, $ocentosmaster, $ounmaster, $ounnormal),$oLinha1, $oimagem, $oLinha1, array($ounmed, $odescesp, $orosca, $otipo));
    } 
}