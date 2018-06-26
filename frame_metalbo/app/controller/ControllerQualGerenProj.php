<?php

class ControllerQualGerenProj extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualGerenProj');
    }

    /**
     * Monta Wizard linha do tempo OnClick para Gerenciar Projetos
     *      */
    public function calculoPersonalizado($sParametros = null) {
        parent::calculoPersonalizado($sParametros);


        $sResulta = '<div id="titulolinhatempo">'
                . '<h3 class="panel-title">Linha do Tempo dos Projetos</h3></br>'
                . '</div>'
                . '<div class="pearls row" id="qualgerenprojtempo">'
                . '</div>';

        return $sResulta;
    }

    /**
     * Gerencia estilo de cores do wizard conforme status do projeto
     *      */
    public function renderTempo($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oRetorno = $this->Persistencia->verifSitProj($aCamposChave);

        /* $scurrentGeral = '';
          if ($oRetorno->sitgeralproj == 'Aprovado') {
          $scurrentGeral = 'current';
          $sEstiloGeral = 'border-color:#2eb82e;color:#2eb82e;';
          }
          if ($oRetorno->sitgeralproj == 'Representante') {
          $scurrentGeral = 'current';
          $sEstiloGeral = 'border-color:#8B2252;color:#8B2252;';
          }
          if ($oRetorno->sitgeralproj == 'Finalizado') {
          $scurrentGeral = 'current';
          }
          if ($oRetorno->sitgeralproj == 'Lib.Projetos') {
          $scurrentGeral = 'current';
          }
         * 
         */

        if ($oRetorno->sitproj == 'Aprovado') {
            $scurrentProj = 'current';
            $sEstiloProj = 'border-color:#2eb82e;color:#2eb82e';
        }
        if ($oRetorno->sitproj == 'Reprovado') {
            $scurrentProj = 'current';
            $sEstiloProj = 'border-color:#F00;color:#F00;';
        }
        if ($oRetorno->sitproj == 'Lib.Projetos') {
            $scurrentProj = 'current';
            $sEstiloProj = 'border-color:#62a8ea;color:#62a8ea';
        }
        if ($oRetorno->sitvendas == 'Aprovado') {
            $scurrentVenda = 'current';
            $sEstiloVenda = 'border-color:#2eb82e;color:#2eb82e;';
        }
        if ($oRetorno->sitvendas == 'Reprovado') {
            $scurrentVenda = 'current';
            $sEstiloVenda = 'border-color:#f00;color:#f00;';
        }
        if ($oRetorno->sitvendas == 'Aguardando') {
            $scurrentVenda = 'current';
            $sEstiloVenda = 'border-color:#8B2252;color:#8B2252;';
        }
        if ($oRetorno->sitcliente == 'Aprovado') {
            $scurrentCli = 'current';
            $sEstiloCli = 'border-color:#2eb82e;color:#2eb82e;';
        }
        if ($oRetorno->sitcliente == 'Expirado') {
            $scurrentCli = 'current';
            $sEstiloCli = 'border-color:#E19D12;color:#E19D12;';
        }
        if ($oRetorno->sitcliente == 'Reprovado') {
            $scurrentCli = 'current';
            $sEstiloCli = 'border-color:#f00;color:#f00;';
        }
        if ($oRetorno->dataprod == true) {
            $scurrentCad = 'current';
            $sEstiloProd = 'border-color:#2eb82e;color:#2eb82e;';
            $ssitCad = 'Cadastrado';
        }
        if ($oRetorno->respvalproj == true) {
            $scurrentResp = 'current';
            $ssitProjProd = 'Iniciado';
        }




        $sLinha = /* '<div id="0" class="pearl ' . $scurrentGeral . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                  . '<div class="pearl-icon" style="' . $sEstiloGeral . '">'
                  . '<i class="icon wb-calendar" aria-hidden="true"></i>'
                  . '</div>'
                  . '<span class="pearl-title" style="font-size:12px">Geral: ' . $oRetorno->sitgeralproj . '</span>'
                  . '</div>' */
                '<div id="0" class="pearl ' . $scurrentProj . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                . '<div class="pearl-icon" style="' . $sEstiloProj . '">'
                . '<i class="icon wb-calendar" aria-hidden="true"></i>'
                . '</div>'
                . '<span class="pearl-title" style="font-size:12px">Projetos: ' . $oRetorno->sitproj . '</span>'
                . '</div>'
                . '<div id="1" class="pearl ' . $scurrentVenda . '  col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                . '<div class="pearl-icon" style="' . $sEstiloVenda . '">'
                . '<i class="icon wb-check" aria-hidden="true"></i>'
                . '</div>'
                . '<span class="pearl-title" style="font-size:12px">Vendas: ' . $oRetorno->sitvendas . '</span>'
                . '</div>'
                . '<div id="2" class="pearl ' . $scurrentCli . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                . '<div class="pearl-icon" style="' . $sEstiloCli . '">'
                . '<i class="icon wb-check" aria-hidden="true"></i>'
                . '</div>'
                . '<span class="pearl-title" style="font-size:12px">Cliente: ' . $oRetorno->sitcliente . '</span>'
                . '</div>'
                . '<div id="3" class="pearl ' . $scurrentCad . '  col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                . '<div class="pearl-icon" style="' . $sEstiloProd . '">'
                . '<i class="icon wb-check" aria-hidden="true"></i>'
                . '</div>'
                . '<span class="pearl-title" style="font-size:12px">Produto: ' . $ssitCad . '</span>'
                . '</div>'
                . '<div id="4" class="pearl ' . $scurrentResp . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                . '<div class="pearl-icon">'
                . '<i class="icon wb-check" aria-hidden="true"></i>'
                . '</div>'
                . '<span class="pearl-title" style="font-size:12px">Produção: ' . $ssitProjProd . '</span>'
                . '</div>';

        $sRender = '$("#qualgerenprojtempo").empty();';
        $sRender .= '$("#qualgerenprojtempo").append(\'' . $sLinha . '\');';
        echo $sRender;
        //coloca o titulo
        echo '$("#titulolinhatempo").empty();';
        $sTitulo = '<h3 class="panel-title">Linha do Tempo Projeto Nº ' . $aCamposChave['nr'] . '</h3></br>';
        echo '$("#titulolinhatempo").append(\'' . $sTitulo . '\');';
    }

    public function relNovoProjeto($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'relNovoProjeto');
    }
    
    public function relProjXls(){
        //Explode string parametros
        $sDados = $_REQUEST['campos'];
        
        $sCampos = htmlspecialchars_decode($sDados);
        
        $sCampos.= $this->getSget();
        
        $aRel = explode(',', $sRel);
       
        $sSistema ="app/relatorio";
        $sRelatorio = 'relNovoProjetoXls.php?';
        
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
