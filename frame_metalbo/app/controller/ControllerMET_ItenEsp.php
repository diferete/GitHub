<?php 
 /*
 * Implementa a classe controler MET_ItenEsp
 * @author Cleverton Hoffmann
 * @since 10/07/2020
 */
 
class ControllerMET_ItenEsp extends Controller {
 
    public function __construct() {
        $this->carregaClassesMvc('MET_ItenEsp');
    } 
 
    /**
     * Mostra a imagem dos itens abaixo do grid 
     * @param type $sParametros
     * @return string
     */
    public function calculoPersonalizado($sParametros = null) {
        parent::calculoPersonalizado($sParametros);

        $sChave = htmlspecialchars_decode($sParametros);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aDados = explode(',', $aCamposChave['procod']);
        $iCod = $aDados[0];

        
        $this->Persistencia->adicionaFiltro('procod', $iCod);
        $this->Persistencia->consultarWhere();
        $sCamImg = $this->Persistencia->Model->getImagem();
        
        $sResulta = '<div id="teste">'
                . '<h1 class="panel-title" style="-webkit-text-stroke-width:thin; color:green; font-size:18px">Imagem do Produto Selecionado:</h1>';
        if($sCamImg!=null){
            $sResulta.= '<br><img src="uploads/'.$sCamImg.'" style="height: 200px;">';           
        }   
        $sResulta .= '</div>';
        echo '$("#teste").empty();';
        echo '$("#teste").append(\'' . $sResulta . '\');';
        
        return $sResulta;
    }
}