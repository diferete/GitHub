<?php

/*
 * Classe que gerencia a Controller da MET_GerenciaFrete
 * @author: Cleverton Hoffmann
 * @since: 14/10/2019
 */

class ControllerMET_GerenciaFrete extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_GerenciaFrete');
    }

    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);

        $oEmp = $this->Persistencia->buscaEmpresas();
        $this->View->setAParametrosExtras($oEmp);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
                
        $oEmp = $this->Persistencia->buscaEmpresas();
        $this->View->setAParametrosExtras($oEmp);
        
    }
    
    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);

        $oEmp = $this->Persistencia->buscaEmpresas();
        $this->View->setAParametrosExtras($oEmp);
    }

    public function buscaDados($sDados) {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aDados = explode(',', $sDados);

        $oRow = $this->Persistencia->consultaDados($aCamposChave);
        
        $this->Persistencia->adicionaFiltro('nr',$aCamposChave['nr']);
        $sVal = $this->Persistencia->consultarWhere();

    if($sVal->getNrnotaoc() == $aCamposChave['nrnotaoc']){
        if($oRow->nfsvlrtot!=0){
            echo"$('#" . $aDados[0] . "').val('" . $oRow->nfsvlrtot . "');";
        }
        if($oRow->pesonota!=0){
            echo "$('#" . $aDados[1] . "').val('" . $oRow->pesonota . "');";
        }
        if($oRow->fracaofrete!=0){
            echo "$('#" . $aDados[2] . "').val('" . $oRow->fracaofrete . "');";
        }
    }else{
            echo"$('#" . $aDados[0] . "').val('" . $oRow->nfsvlrtot . "');";
            echo "$('#" . $aDados[1] . "').val('" . $oRow->pesonota . "');";
            echo "$('#" . $aDados[2] . "').val('" . $oRow->fracaofrete . "');";
    }
    echo "$('#" . $aDados[1] . "').focus();";
    echo "$('#" . $aDados[0] . "').focus();";
    echo  '$("#gerenciafrete_valorserv").focus();';
    }

    public function calculoFracaoFrete($sDados) {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aDados = explode(',', $sDados);

        $iFracaoFrete = ceil($aCamposChave['totakg'] / 100);

        echo"$('#" . $aDados[0] . "').val(" . $iFracaoFrete . ");";
    }

    public function calculoFreteTotalFormulas($sDados) {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aDados = explode(',', $sDados);

        $aCodTip = $this->Persistencia->retornaCodTipo($aCamposChave);
        if ((($aCodTip[0]['codtipo'] == 1) && ($aCamposChave['codtipo'] == 1 )) || ((($aCodTip[1]['codtipo'] == 2) || ($aCodTip[0]['codtipo'] == 2)) && ($aCamposChave['codtipo'] == 2))) {
            
        } else {
            if (($aCamposChave['codtipo']) == 1) {
                $oModal = new Modal('Atenção', 'Selecione campo de Compras!', Modal::TIPO_ERRO);
                echo $oModal->getRender();
                exit();
            } else {
                $oModal = new Modal('Atenção', 'Selecione campo de Vendas!', Modal::TIPO_ERRO);
                echo $oModal->getRender();
                exit();
            }
        }

        //Validações campos vazios
        if (($aCamposChave['fracaofrete']) == 0) {
            $oModal = new Modal('Atenção', 'Digite o valor do peso!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }

        $oRow = $this->Persistencia->consultaDadosFormulas($aCamposChave);

        $this->carregaDadosConsulta($aDados[0], $aCamposChave, $oRow, $aDados[1]);

        /*  $htmlSelect = "";
          forEach ($oRow as $aA) {
          $htmlSelect = $htmlSelect . ' <option value="' . $aA['seq'] . '">' .
          'Seq ' . $aA['seq'] . 'Total frete ' . $aA['totalfrete'] . ' Frete Mínimo ' . $aA['freteminimo'] . '</option>';
          }

          echo '$("#' . $sDados . '").empty().append(\'' . $htmlSelect . '\');'; */
    }

    /**
     * Método que renderiza dados para o grid.
     * @param type $sIdGrid
     * @param type $sCampoConsulta
     * @param type $oRow
     * @param type $iIdSeq
     */
    public function carregaDadosConsulta($sIdGrid, $aCamposChave, $oRow, $iIdSeq) {

        $htmlSelectG = "";
        
        forEach ($oRow as $aA) {

            $sIdtr = Base::getId();
            
            if ((number_format($aA['totalfrete'], 0) == number_format(str_replace(',', '.', $aCamposChave['valorserv']), 0 ))||
                    number_format($aA['freteminimo'], 0) == number_format(str_replace(',', '.', $aCamposChave['valorserv']), 0 )) {
                $htmlSelectG .= '<tr id="' . $sIdtr . '"  tabindex="0" class= "tr-azul dbclick" style="font-size:small;">'; //abre a linha azul
            } else {
                $htmlSelectG .= '<tr id="' . $sIdtr . '" tabindex="0" role="row" class="odd dbclick" style="font-size:small;">'; //abre a linha
            }

            $htmlSelectG .= '<script>'
                    . '$("#' . $sIdtr . '").keydown(function(e) { '
                    . 'if(e.which == 40) {   '
                    . '     $(this).removeClass("selected"); '
                    . '     $(this).next().focus(); '
                    . '     $(this).next().addClass("selected");'
                    . '  } else if(e.which == 38) {  '
                    . '      $(this).removeClass("selected"); '
                    . '      $(this).prev().focus(); '
                    . '      $(this).prev().addClass("selected"); '
                    . '  } '
                    . '});'
                    . '</script>';

            $htmlSelectG .= '<td class="select-checkbox sorting_1 select-checkbox" style="width: 30px;"></td>'; //td do check  
            $htmlSelectG .= '<td id="' . $sIdtr . '-seq" class=" tr-font" style="">' . $aA['seq'] . '</td>';
            $htmlSelectG .= '<td class=" tr-font" style="">' . $aA['ref'] . '</td>';
            $htmlSelectG .= '<td class=" tr-font" style="">' . number_format($aA['totalfrete'], 4) . '</td>';
            $htmlSelectG .= '<td class=" tr-font" style="">' . number_format($aA['freteminimo'], 2) . '</td>';
            $htmlSelectG .= '<td class="hidden chave">' . $aA['seq'] . '</td>'; ///colocar valor chave

            //Script que passa o valor da sequencia e o id do campo oculto
            $htmlSelectG .= '<script>'
                    . '$("#' . $sIdtr . '").click(function(){'
                    . 'requestAjax("", "MET_GerenciaFrete","isereDadosModel","' . $aA['seq'] . ','.$iIdSeq.'");});'
                    . '</script>';
            $htmlSelectG .= '</tr>';
        }

        //pegar id da tr
        $sRender = 'var idTr="";$("#' . $sIdGrid . 'consulta tbody .selected").each(function(){'
                . ' idTr=$(this).attr("id");'
                . ' });';

        //scroll infinito
        $sRender .= '$("#' . $sIdGrid . ' > tbody > tr").remove();';

        //Coloca dados no grid
        $sRender .= '$("#' . $sIdGrid . '").append(\'' . $htmlSelectG . '\');';

        $sRender .= ' if (idTr!==""){$("#' . $sIdGrid . ' #"+idTr+"").focus();'
                . ' $("#' . $sIdGrid . ' #"+idTr+"").addClass("selected");}';

        echo $sRender;

        //mostra contator de registros 

        $sNrReg = 'var nrReg = $("#' . $sIdGrid . ' > tbody > tr").length ;'
                . ' $("#' . $sIdGrid . '-nrReg").text(nrReg+" registros listados do total de ' . count($oRow) . '. Clique para carregar!"); ';
        echo $sNrReg;
    }

    /**
     * Função que insere dados no campo oculto da tela, sequencia da regra
     * @param type $sDados
     */
    public function isereDadosModel($sDados) {
        $aDados = explode(',', $sDados);
        echo "$('#" . $aDados[1] . "').val(" . $aDados[0] . ");";
    }
    
    /**
     * Mostra tela relatório de Frete
     * @param type $renderTo
     * @param type $sMetodo
     */
    public function mostraTelaRelGerenciaFrete($renderTo, $sMetodo = '') {   
        $oEmp = $this->Persistencia->buscaEmpresas();
        $this->View->setAParametrosExtras($oEmp);
        parent::mostraTelaRelatorio($renderTo, 'relGerenciaFrete');              
    }  
    
    /**
     * Método que inicializa função botão contas a pagar
     * @param type $sDados
     */
    public function msgLibPag($sDados){
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $this->Persistencia->adicionaFiltro('nr',$aCamposChave['nr']);
        $sVal = $this->Persistencia->consultarWhere();
        if($sVal->getSit() == "E"){
            $oModal = new Modal('Atenção', 'Apenas conhecimentos aprovados podem ser pagos!', Modal::TIPO_AVISO);
            echo $oModal->getRender();
            exit();
        }
        
    }
    
    //Método que preenche os campos do form depois de dar o resetform
    public function afterResetForm($sDados) {
        parent::afterResetForm($sDados);
       
      echo  '$("#gerenciafrete_cnpj").val("' . $this->Model->getCnpj() . '").trigger("change");'; 
      echo  '$("#gerenciafrete_codtip").val("' . $this->Model->getCodtipo() . '").trigger("change");'; 
      echo  ' $("#gerenciafrete_nrfat").val("' . $this->Model->getNrfat() . '");';
      echo  ' $("#gerenciafrete_dataem").val("' . $this->Model->getDataem() . '");';
      echo  '$("#gerenciafrete_grid > tbody > tr").remove();';
      echo  '$("#gerenciafrete_nrconhe").focus();';
    }

    //Método antes de inserir verifica linha selecionada conforme a situação
    public function beforeInsert() {
       parent::beforeInsert();
       
       if($this->Model->getSeqregra()=="" && $this->Model->getSit()!="E"){
            $oModal = new Modal('Atenção', 'Selecione uma linha de resultado de cálculo!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
       }
       //Verifica se não existe conhecimento repetido
       $this->verificaConhecimento();
       $aRetorno = array();
       $aRetorno[0] = true;
       $aRetorno[1] = '';
       return $aRetorno;
       
    }
   
   //Verifica se não existe conhecimento repetido
   public function verificaConhecimento(){
       $sDados = $_REQUEST['campos'];
       $sChave = htmlspecialchars_decode($sDados);
       $aCamposChave = array();
       parse_str($sChave, $aCamposChave);
  
       if($this->Persistencia->verificaConhec($aCamposChave)>0){
            $oModal = new Mensagem('Atenção', 'Conhecimento digitado já foi inserido!', Mensagem::TIPO_ERROR);
            echo $oModal->getRender();
            exit();
       }
   }
   
   //Método antes de alterar verifica linha selecionada conforme a situação
   public function beforeUpdate() {
       parent::beforeUpdate();
       
       if($this->Model->getSeqregra()=="" && $this->Model->getSit()!="E"){
            $oModal = new Modal('Atenção', 'Selecione uma linha de resultado de cálculo!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
       }
       
       $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
   }
   
}
