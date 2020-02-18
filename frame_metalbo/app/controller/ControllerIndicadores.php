<?php

/*
 * Classe que implementa a controller da classe Indicadores
 * 
 * @author Cleverton Hoffmann
 * @since 26/10/2018
 */


class ControllerIndicadores extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('Indicadores');
    }
    
    public function relSaldosPedidos($renderTo, $sMetodo = '') {
        parent::criaTelaDiversa($renderTo, 'relSaldosPedidos');
    }
    
    public function saldoPedidosGerencial($sDados) {
       
       parent::acaoMostraRelEspecifico($sDados);
       
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
       
        $sSistema ="app/relatorio";
        $sRelatorio = 'relSaldoGerencial.php?';
        
        $sCampos.= $this->getSget();
        $sCampos.='&incluiExp='.$aCamposChave['incluiExport'].'&dtemiInic='.$aCamposChave['dtemiInic'].
                  '&dtemiFinal='.$aCamposChave['dtemiFinal'].'&dteEntInic='.$aCamposChave['dteEntInic'].
                  '&dtEntFinal='.$aCamposChave['dtEntFinal'].'&nr='.$aCamposChave['nr'].
                  '&empcod='.$aCamposChave['empcod'].'&pro_subgrupodescricao='.$aCamposChave['pro_subgrupodescricao'].
                  '&repInicial='.$aCamposChave['repInicial'].'&repFinal='.$aCamposChave['repFinal'];
        
        $sCampos.='&output=tela';
        $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow; 
    }
    
    public function saldoPedidosSemFaturamento($sDados) {

         parent::acaoMostraRelEspecifico($sDados);

          $sChave = htmlspecialchars_decode($_REQUEST['campos']);
          $aCamposChave = array();
          parse_str($sChave, $aCamposChave);

          $sSistema ="app/relatorio";
          $sRelatorio = 'relSaldoPedSemFaturamento.php?';

          $sCampos.= $this->getSget();
          $sCampos.='&incluiExp='.$aCamposChave['incluiExport'].'&dtemiInic='.$aCamposChave['dtemiInic'].
                  '&dtemiFinal='.$aCamposChave['dtemiFinal'].'&dteEntInic='.$aCamposChave['dteEntInic'].
                  '&dtEntFinal='.$aCamposChave['dtEntFinal'].'&nr='.$aCamposChave['nr'].
                  '&empcod='.$aCamposChave['empcod'].'&pro_subgrupodescricao='.$aCamposChave['pro_subgrupodescricao'].
                  '&repInicial='.$aCamposChave['repInicial'].'&repFinal='.$aCamposChave['repFinal'].
                  '&naoIncluiBelenus='.$aCamposChave['naoIncluiBelenus'].'&incluiSomenteBelenus='.$aCamposChave['incluiSomenteBelenus'].
                  '&dtPedSem='.$aCamposChave['dtPedSem'];

          $sCampos.='&output=tela';
          $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
          echo $oWindow; 
    }
    
    public function SaldoPedComFaturamentoParcial($sDados) {

         parent::acaoMostraRelEspecifico($sDados);

          $sChave = htmlspecialchars_decode($_REQUEST['campos']);
          $aCamposChave = array();
          parse_str($sChave, $aCamposChave);

          $sSistema ="app/relatorio";
          $sRelatorio = 'relSaldoPedSemFaturamento.php?';

          $sCampos.= $this->getSget();
          $sCampos.='&incluiExp='.$aCamposChave['incluiExport'].'&dtemiInic='.$aCamposChave['dtemiInic'].
                  '&dtemiFinal='.$aCamposChave['dtemiFinal'].'&dteEntInic='.$aCamposChave['dteEntInic'].
                  '&dtEntFinal='.$aCamposChave['dtEntFinal'].'&nr='.$aCamposChave['nr'].
                  '&empcod='.$aCamposChave['empcod'].'&pro_subgrupodescricao='.$aCamposChave['pro_subgrupodescricao'].
                  '&repInicial='.$aCamposChave['repInicial'].'&repFinal='.$aCamposChave['repFinal'].
                  '&naoIncluiBelenus='.$aCamposChave['naoIncluiBelenus'].'&incluiSomenteBelenus='.$aCamposChave['incluiSomenteBelenus'].
                  '&dtPedCom='.$aCamposChave['dtPedCom'];

          $sCampos.='&output=tela';
          $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
          echo $oWindow; 
    }
    
    public function SaldoPedAbertosItemComSaldo($sDados) {

         parent::acaoMostraRelEspecifico($sDados);

          $sChave = htmlspecialchars_decode($_REQUEST['campos']);
          $aCamposChave = array();
          parse_str($sChave, $aCamposChave);

          $sSistema ="app/relatorio";
          $sRelatorio = 'relSaldoPedSemFaturamento.php?';

          $sCampos.= $this->getSget();
          $sCampos.='&incluiExp='.$aCamposChave['incluiExport'].'&dtemiInic='.$aCamposChave['dtemiInic'].
                  '&dtemiFinal='.$aCamposChave['dtemiFinal'].'&dteEntInic='.$aCamposChave['dteEntInic'].
                  '&dtEntFinal='.$aCamposChave['dtEntFinal'].'&nr='.$aCamposChave['nr'].
                  '&empcod='.$aCamposChave['empcod'].'&pro_subgrupodescricao='.$aCamposChave['pro_subgrupodescricao'].
                  '&repInicial='.$aCamposChave['repInicial'].'&repFinal='.$aCamposChave['repFinal'].
                  '&naoIncluiBelenus='.$aCamposChave['naoIncluiBelenus'].'&incluiSomenteBelenus='.$aCamposChave['incluiSomenteBelenus'].
                  '&dtPedCom='.$aCamposChave['dtPedAbertItens'];

          $sCampos.='&output=tela';
          $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
          echo $oWindow; 
    }
    
    public function NrSaldosPorItem($sDados) {

         parent::acaoMostraRelEspecifico($sDados);

          $sChave = htmlspecialchars_decode($_REQUEST['campos']);
          $aCamposChave = array();
          parse_str($sChave, $aCamposChave);

          $sSistema ="app/relatorio";
          $sRelatorio = 'relSaldoPedSemFaturamento.php?';

          $sCampos.= $this->getSget();
          $sCampos.='&dtemiInic='.$aCamposChave['dtemiInic'].
                  '&dtemiFinal='.$aCamposChave['dtemiFinal'].'&dteEntInic='.$aCamposChave['dteEntInic'].
                  '&dtEntFinal='.$aCamposChave['dtEntFinal'].'&nr='.$aCamposChave['nr'].
                  '&empcod='.$aCamposChave['empcod'].'&pro_subgrupodescricao='.$aCamposChave['pro_subgrupodescricao'].
                  '&repInicial='.$aCamposChave['repInicial'].'&repFinal='.$aCamposChave['repFinal'].
                  '&ordenacaoNrPedidos='.$aCamposChave['ordenacaoNrPedidos'].'&ordenacaoPorValor='.$aCamposChave['ordenacaoPorValor'].
                  '&ordenacaoQtSaldo='.$aCamposChave['ordenacaoQtSaldo'];

          $sCampos.='&output=tela';
          $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
          echo $oWindow; 
    }
    
    public function AdicionalSaldosIntervalos($sDados) {

         parent::acaoMostraRelEspecifico($sDados);

          $sChave = htmlspecialchars_decode($_REQUEST['campos']);
          $aCamposChave = array();
          parse_str($sChave, $aCamposChave);

          $sSistema ="app/relatorio";
          $sRelatorio = 'relAdicionalSaldosIntervalos.php?';

          $sCampos.= $this->getSget();
          $sCampos.='&incluiExp='.$aCamposChave['incluiExport'].'&dtemiInic='.$aCamposChave['dtemiInic'].
                  '&dtemiFinal='.$aCamposChave['dtemiFinal'].'&dteEntInic='.$aCamposChave['dteEntInic'].
                  '&dtEntFinal='.$aCamposChave['dtEntFinal'].'&nr='.$aCamposChave['nr'].
                  '&empcod='.$aCamposChave['empcod'].'&pro_subgrupodescricao='.$aCamposChave['pro_subgrupodescricao'].
                  '&repInicial='.$aCamposChave['repInicial'].'&repFinal='.$aCamposChave['repFinal'].
                  '&naoIncluiBelenus='.$aCamposChave['naoIncluiBelenus'].'&incluiSomenteBelenus='.$aCamposChave['incluiSomenteBelenus'].
                  '&dtPosicao='.$aCamposChave['dtPosicao'].'&grupocodigoIni='.$aCamposChave['grupocodigoIni'].
                  '&grupocodigoFin='.$aCamposChave['grupocodigoFin'].'&subgrupocodigoIni='.$aCamposChave['subgrupocodigoIni'].
                  '&subgrupocodigoFin='.$aCamposChave['subgrupocodigoFin'].'&familiacodigoIni='.$aCamposChave['familiacodigoIni'].
                  '&familiacodigoFin='.$aCamposChave['familiacodigoFin'].'&subfamiliacodigoIni='.$aCamposChave['subfamiliacodigoIni'].
                  '&subfamiliacodigoFin='.$aCamposChave['subfamiliacodigoFin'];

          $sCampos.='&output=tela';
          $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
          echo $oWindow; 
    }
    
    public function SaldoEntregaNoPeriodo($sDados) {

         parent::acaoMostraRelEspecifico($sDados);

          $sChave = htmlspecialchars_decode($_REQUEST['campos']);
          $aCamposChave = array();
          parse_str($sChave, $aCamposChave);

          $sSistema ="app/relatorio";
          $sRelatorio = 'relSaldoEntregaNoPeriodo.php?';

          $sCampos.= $this->getSget();
          $sCampos.='&incluiExp='.$aCamposChave['incluiExport'].'&dtemiInic='.$aCamposChave['dtemiInic'].
                  '&dtemiFinal='.$aCamposChave['dtemiFinal'].'&dteEntInic='.$aCamposChave['dteEntInic'].
                  '&dtEntFinal='.$aCamposChave['dtEntFinal'].'&nr='.$aCamposChave['nr'].
                  '&empcod='.$aCamposChave['empcod'].'&pro_subgrupodescricao='.$aCamposChave['pro_subgrupodescricao'].
                  '&repInicial='.$aCamposChave['repInicial'].'&repFinal='.$aCamposChave['repFinal'].
                  '&naoIncluiBelenus='.$aCamposChave['naoIncluiBelenus'].'&incluiSomenteBelenus='.$aCamposChave['incluiSomenteBelenus'].
                  '&dtSaldo='.$aCamposChave['dtSaldo'];

          $sCampos.='&output=tela';
          $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
          echo $oWindow; 
    }
}