<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerFinanRep extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('FinanRep');
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        $this->Persistencia->limpaFiltro();
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $this->Persistencia->adicionaFiltro('empcod', $aCampos['cnpj']);
    }

    public function somaTitulo($sEmpcod) {
        $aDados = explode(',', $sEmpcod);
        $aTotal = $this->Persistencia->somaTitulo($aDados[0]);
        $sTotal = '<tr>'
                . '<td>Em aberto</td><td>' . number_format($aTotal['total'], 2, ',', '.') . '</td>'
                . '</tr>'
                . '<tr>'
                . '<td>Em atraso</td><td>' . number_format($aTotal['atrasado'], 2, ',', '.') . '</td>'
                . '</tr> ';

        echo '$("#' . $aDados[1] . ' > tbody > tr").empty();';
        echo '$("#' . $aDados[1] . ' > tbody").append(\'' . $sTotal . '\');';
    }

    public function getDadosBoleto($sDados) {
        $aDados = explode(',', $sDados);

        $sChave = htmlspecialchars_decode($aDados[1]);
        $aDocto = array();
        parse_str($sChave, $aDocto);

        if (count($aDocto) > 0) {
            $aRetorno = $this->Persistencia->geraDadosBoleto($aDocto['recdocto'], $aDocto['recparnro'], $aDocto['recprnro']);
            echo '$("#' . $aDados[2] . '").val("' . $aRetorno['itau'] . '");';
            echo '$("#' . $aDados[3] . '").val("' . $aRetorno['empcod'] . '");';
            echo '$("#' . $aDados[4] . '").val("' . $aRetorno['nosso'] . '");';
        } else {
            echo '$("#' . $aDados[2] . '").val("");';
            echo '$("#' . $aDados[3] . '").val("");';
            echo '$("#' . $aDados[4] . '").val("");';
        }
    }

    //////////////////////////////////////////////////////////
    public function mostraTelaRelTituloAberto($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'RelRepTituloAberto');
    }

    /**
    *  Gera xls do relatorio de financeiro
    */
  
    public function relatorioExcelTituloAberto(){
        //Explode string parametros
        $sDados = $_REQUEST['campos'];
        
        $sCampos = htmlspecialchars_decode($sDados);
                
        $sCampos.= $this->getSget();
        
        $aRel = explode(',', $sRel);
       
        $sSistema ="app/relatorio";
        $sRelatorio = 'RelRepTituloAbertoExcel.php?';
        
        $sCampos.='&output=email';
        $oMensagem = new Mensagem("Aguarde","Seu excel está sendo processado", Mensagem::TIPO_INFO);
        echo $oMensagem->getRender();
        
        $oWindow =// 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "Relatório", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");'; 
                'var win = window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'","MsgWindow","width=500,height=100,left=375,top=330");'
                    .'setTimeout(function () { win.close();}, 30000);';
        echo $oWindow;
         
        $oMenSuccess = new Mensagem("Sucesso","Seu excel foi gerado com sucesso, acesse sua pasta de downloads!", Mensagem::TIPO_SUCESSO);
        echo $oMenSuccess->getRender();
       
    } 
    
}
