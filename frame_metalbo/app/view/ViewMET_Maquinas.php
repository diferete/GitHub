<?php

/* 
 * Implementa a classe view
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class ViewMET_Maquinas extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $aDados = $this->getAParametrosExtras();
        $aDado1 = $aDados[0]; //Células
        $aDado2 = $aDados[1]; //Setores cod e des
        $aCodSetor = $aDado2[0]; //Cod Setores
        $aDesSetor = $aDado2[1]; //Des Setores
        $aDado4 = $aDados[3]; //Tipo maquina PO, PF, MQ
        
        $oCodmaq = new CampoConsulta('Cod', 'cod');
        $oNr = new CampoConsulta('Maquina', 'maquina');
        $oMaqtip = new CampoConsulta('Tip.', 'maqtip');
        $oNomeclatura = new CampoConsulta('Nomeclatura','nomeclatura');
        $oSeq = new CampoConsulta('Célula', 'seq');
        $oSetor = new CampoConsulta('Setor', 'codsetor');
                
        $oMaquinaFiltro = new Filtro($oNr, Filtro::CAMPO_TEXTO,3);

        //Filtro de células
        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_SELECT, 1,1,1,1);
        $oFiltroSeq->addItemSelect('', 'Todas Células');
        foreach ($aDado1 as $key){
            $val =(int)$key['seq'];
            $oFiltroSeq->addItemSelect($val, $key['seq'].' - Célula');
        }
        $oFiltroSeq->setSLabel('');
      
        //Filtro de Setor
        $oFiltroSetor = new Filtro($oSetor, Filtro::CAMPO_SELECT, 3,3,3,3);
        $oFiltroSetor->addItemSelect('', 'Todos Setores');
        $iCont = 0;
        foreach ($aCodSetor as $key1){
            $oFiltroSetor->addItemSelect($key1, $key1.' - '.$aDesSetor[$iCont]);
            $iCont++;
        }
        $oFiltroSetor->setSLabel('');
        
        //Filtro tipo Categoria
        $oCategoriaFiltro= new Filtro($oMaqtip, Filtro::CAMPO_SELECT, 2,2,2,2);
        $oCategoriaFiltro->addItemSelect('', 'Todas Categorias');
        foreach ($aDado4 as $key3){
            $oCategoriaFiltro->addItemSelect($key3['maqtip'], $key3['maqtip']);
        }
        $oCategoriaFiltro->setSLabel('');
        
        $oFiltroCodMaq = new Filtro($oCodmaq, Filtro::CAMPO_TEXTO, 1,1,1,1);
        
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->addFiltro($oFiltroCodMaq, $oMaquinaFiltro,$oFiltroSeq,$oCategoriaFiltro,$oFiltroSetor);
        
        $this->getTela()->setBMostraFiltro(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->addCampos($oCodmaq, $oNr,$oMaqtip,$oNomeclatura,$oSeq, $oSetor);
    }

    public function criaTela() {
        parent::criaTela();
        
    }
}
