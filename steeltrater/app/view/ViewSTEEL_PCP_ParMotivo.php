<?php 
 /*
 * Implementa a classe view STEEL_PCP_ParMotivo
 * @author Cleverton Hoffmann
 * @since 03/12/2020
 */
 
class ViewSTEEL_PCP_ParMotivo extends View {
 
    public function __construct() {
        parent::__construct();
       }
 
    public function criaConsulta() { 
        parent::criaConsulta();
 
        $this->setUsaAcaoVisualizar(true);
 
        $ocodmotivo = new CampoConsulta('Cod.Motivo', 'codmotivo', CampoConsulta::TIPO_TEXTO);
        $odescricao = new CampoConsulta('Descrição', 'descricao', CampoConsulta::TIPO_TEXTO);
 
        $oCodfiltro = new Filtro($ocodmotivo, Filtro::CAMPO_TEXTO_IGUAL, 2);
        $oDescricaoFiltro = new Filtro($odescricao, Filtro::CAMPO_TEXTO, 5);

        $this->setUsaAcaoExcluir(false);
        $this->addFiltro($oCodfiltro,$oDescricaoFiltro);
        $this->addCampos($ocodmotivo, $odescricao);
    }
 
    public function criaTela() { 
        parent::criaTela();
 
        $ocodmotivo = new Campo('Cod.Motivo', 'codmotivo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ocodmotivo->setBCampoBloqueado(true);
        $odescricao = new Campo('Descrição', 'descricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
 
        $this->addCampos(array($ocodmotivo, $odescricao));
    } 
}