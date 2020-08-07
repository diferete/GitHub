<?php 
 /*
 * Implementa a classe view MET_SolEmbalagem
 * @author Cleverton Hoffmann
 * @since 24/07/2020
 */
 
class ViewMET_SolEmbalagem extends View {
 
    public function __construct() {
        parent::__construct();
       }
 
    public function criaConsulta() { 
        parent::criaConsulta();
 
        $this->setUsaAcaoVisualizar(true);
 

        $oid = new CampoConsulta('Id', 'id', CampoConsulta::TIPO_TEXTO);
        $onr = new CampoConsulta('Nr', 'nr', CampoConsulta::TIPO_TEXTO);
        $otipo = new CampoConsulta('Tipo', 'tipo', CampoConsulta::TIPO_TEXTO);
        $oempcod = new CampoConsulta('Emp.Cod.', 'empcod', CampoConsulta::TIPO_TEXTO);
 
        $this->addCampos($oid, $onr, $otipo, $oempcod);
    }
 
    public function criaTela() { 
        parent::criaTela();
 

        $oid = new Campo('Id', 'id', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $onr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $otipo = new Campo('Tipo', 'tipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oempcod = new Campo('Emp.Cod.', 'empcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
 
        //---Adiciona uma linha em branco---///
        $oLinha = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha->setApenasTela(true);
        
        $this->addCampos(array($oid, $onr, $otipo), $oLinha, $oempcod);
    } 
}