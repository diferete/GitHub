<?php 
 /*
 * Implementa a classe view MET_MANUT_OSMaterial
 * @author Cleverton Hoffmann
 * @since 24/08/2021
 */
 
class ViewMET_MANUT_OSMaterial extends View {
 
    public function __construct() {
        parent::__construct();
       }
 
    public function criaConsulta() { 
        parent::criaConsulta();
 
        $this->setUsaAcaoVisualizar(true);
        $this->getTela()->setIAltura(300);
        $this->setBScrollInf(TRUE);
        $this->getTela()->setBUsaCarrGrid(true);

        $ofil_codigo = new CampoConsulta('Empresa', 'fil_codigo', CampoConsulta::TIPO_TEXTO);
        $onr = new CampoConsulta('OS', 'nr', CampoConsulta::TIPO_TEXTO);
        $ocod = new CampoConsulta('Cod. Maquina', 'cod', CampoConsulta::TIPO_TEXTO);
        $ocodmat = new CampoConsulta('Cod. Material', 'codmat', CampoConsulta::TIPO_TEXTO);
        $odescricaomat = new CampoConsulta('Descriação', 'descricaomat', CampoConsulta::TIPO_TEXTO);
        $ousermatcod = new CampoConsulta('Cod.Usuário', 'usermatcod', CampoConsulta::TIPO_TEXTO);
        $ousermatdes = new CampoConsulta('Descrição', 'usermatdes', CampoConsulta::TIPO_TEXTO);
        $odatamat = new CampoConsulta('Data', 'datamat', CampoConsulta::TIPO_DATA);
 
        $oFilnr = new Filtro($onr, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $this->addFiltro($oFilnr);
        
        $this->addCampos($ofil_codigo, $onr, $ocod, $ocodmat, $odescricaomat, $ousermatcod, $ousermatdes, $odatamat);
    }
 
    public function criaTela() { 
        parent::criaTela();
 
        $ofil_codigo = new Campo('fil_codigo', 'fil_codigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $onr = new Campo('nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ocod = new Campo('cod', 'cod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ocodmat = new Campo('codmat', 'codmat', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odescricaomat = new Campo('descricaomat', 'descricaomat', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ousermatcod = new Campo('usermatcod', 'usermatcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ousermatdes = new Campo('usermatdes', 'usermatdes', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odatamat = new Campo('datamat', 'datamat', Campo::TIPO_DATA, 1, 1, 12, 12);
 
        $this->addCampos($ofil_codigo, $onr, $ocod, $ocodmat, $odescricaomat, $ousermatcod, $ousermatdes, $odatamat);
    } 
    
     public function gridMaterialManutOS() {
        $oGridMatNeces = new Grid("gridMatOS");
        
        $oBotaoExcluir = new CampoConsulta('Excluir', 'teste', CampoConsulta::TIPO_EXCLUIR);
        $oBotaoExcluir->setILargura(5);
        $oBotaoExcluir->setSTitleAcao('Excluir item!');
        $oBotaoExcluir->addAcao('MET_MANUT_OSMaterial', 'msgExcluirMaterial', '', '');
        $oBotaoExcluir->setBHideTelaAcao(true);
        $oBotaoExcluir->setSNomeGrid('gridMaterialManutOS');
        
//        $ofil_cod3 = new CampoConsulta('Empresa', 'fil_codigo', CampoConsulta::TIPO_TEXTO);
//        $ofil_cod3->setILargura(8);
//        $ocodMaq3 = new CampoConsulta('Máquina', 'cod', CampoConsulta::TIPO_TEXTO);
//        $ocodMaq3->setILargura(8);
//        $ocodOS = new CampoConsulta('OS', 'nr', CampoConsulta::TIPO_TEXTO);
//        $ocodOS->setILargura(8);
        $oseqMat = new CampoConsulta('Seq', 'seq', CampoConsulta::TIPO_TEXTO);
        $oseqMat->setILargura(8);
        $ocodMat = new CampoConsulta('Código', 'codmat', CampoConsulta::TIPO_TEXTO);
        $ocodMat->setILargura(8);
        $odesMat = new CampoConsulta('Descrição', 'descricaomat', CampoConsulta::TIPO_TEXTO);
        $odesMat->setILargura(220);
        $odesMat->addComparacao('', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COL_VDCLARO, CampoConsulta::MODO_LINHA, false, '');
        $ocodUser = new CampoConsulta('Cod.', 'usermatcod', CampoConsulta::TIPO_TEXTO);
        $ocodUser->setILargura(8);
        $odesUser = new CampoConsulta('Usuário', 'usermatdes', CampoConsulta::TIPO_TEXTO);
        $odesUser->setILargura(10);
        $odata = new CampoConsulta('Data', 'datamat', CampoConsulta::TIPO_DATA);
        $odata->setILargura(8);
        $oquantidade = new CampoConsulta('Quantidade', 'quantidade', CampoConsulta::TIPO_TEXTO);
        $oquantidade->setILargura(5);
        $oobs1 = new CampoConsulta('Observação', 'obsmat', CampoConsulta::TIPO_TEXTO);
        $oobs1->setILargura(220);
               //, $ofil_cod3, $ocodMaq3, $ocodOS
        $oGridMatNeces->addCampos($oBotaoExcluir, $oseqMat, $ocodMat, $odesMat, $oquantidade, $odata, $oobs1, $odesUser);

        $aCampos = $oGridMatNeces->getArrayCampos();
        return $aCampos;
    }
}