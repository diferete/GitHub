<?php
//inclui config
include("../../includes/Config.php");
//pega as tabelas do representante
$sItenVenda = $_REQUEST['itencab'];
$sNr = $_REQUEST['nr'];
$PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql ="select nr,seq,codigo,descricao,quant,vlrunit,vlrtot,desconto, "
                    ."desctrat,descextra1,descextra2,vlrtot,convert (varchar,DATA,103)data2,hora,propesprat, "
                    ."(vlrtot + (vlrtot*10/100))as cipi,"
					          ."case when propesprat = '0.00' then '0' ELSE (VLRUNIT/propesprat) END AS media "
					          ."from ".$sItenVenda."(nolock),widl.prod01(nolock) "
                    ."where widl.prod01.procod = ".$sItenVenda.".CODIGO "
                    ."and NR =".$sNr." order by seq ";
$dadosDesc = $PDO->query($sSql);


$sTable = '        <table class="table table-striped"> '
.'                    <thead>'
.'                      <tr>'
.'                        <th>Código</th>'
.'                        <th>Descrição</th>'
.'                        <th>Quantidade</th>'
.'                        <th>Valor Unit.</th>'
.'                        <th>Total</th>'
.'                        <th>Desconto</th>'
.'                        <th>Trat.</th>'
.'                        <th>Extra1</th>'
.'                        <th>Extra2</th>'
.'                        <th>Peso Ct</th>'
.'                        <th>Media</th>'
.'                      </tr>'
.'                    </thead>'
.'                    <tbody>';
while($row = $dadosDesc->fetch(PDO::FETCH_OBJ)){
          $sTable.=  '                      <tr>'
                    .'                        <td class=" tr-font">'.$row->codigo.'</td>'//.'<span class="badge badge-dark">Credit Card</span>'
                    .'                        <td class=" tr-font">'.$row->descricao.'</td>'
                    .'                        <td class=" tr-font">'.number_format($row->quant,2,',','.').'</td>'//number_format($quant, 2, ',', '.')
                    .'                        <td class=" tr-font">'.number_format($row->vlrunit,2,',','.').'</td>'
                    .'                        <td class=" tr-font">'.number_format($row->vlrtot,2,',','.').'</td>'
                    .'                        <td class=" tr-font">'.number_format($row->desconto,2,',','.').'</td>'
                    .'                        <td class=" tr-font">'.number_format($row->desctrat,2,',','.').'</td>'
                    .'                        <td class=" tr-font">'.number_format($row->descextra1,2,',','.').'</td>'
                    .'                        <td class=" tr-font">'.number_format($row->descextra2,2,',','.').'</td>'
                    .'                        <td class=" tr-font">'.number_format($row->propesprat,2,',','.').'</td>'
                    .'                        <td class=" tr-font">'.number_format($row->media,2,',','.').'</td>'
                    .'                      </tr>';
      }
    $sTable.='</table>';
    
    
//monta o totalizador
$sSqlSoma = "select SUM(VLRTOT) AS sipi,sum(vlrtot + (vlrtot*10/100)) as cipi,SUM(QUANT*propesprat)as pesototal "
          ."from ".$sItenVenda."(nolock) left outer join widl.prod01 on ".$sItenVenda.".CODIGO = widl.prod01.procod "
          ."WHERE NR =".$sNr." ";
$oDadosSoma = $PDO->query($sSqlSoma);
while($rowsoma = $oDadosSoma->fetch(PDO::FETCH_OBJ)){
    $sSomaTotal = "          <div class='text-right clearfix'> "
."            <div class='pull-right'>"
."              <p>Total S/IPI:"
."                <span>".number_format($rowsoma->sipi,2,',','.')."</span>"
."              </p>"
."              <p>Total C/IPI:"
."                <span>".number_format($rowsoma->cipi,2,',','.')."</span>"
."              </p>"
."              <p class='page-invoice-amount'>Peso Total:"
."                <span>".number_format($rowsoma->pesototal,2,',','.')."</span>"
."              </p>"
."            </div>"
."          </div>";
}
         

$sHtml='<html class="no-js css-menubar" lang="en">'
  .'<head>'
  .'<meta charset="utf-8">'
  .'<meta http-equiv="X-UA-Compatible" content="IE=edge">'
  .'<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">'
  .'<meta name="description" content="bootstrap admin template">'
  .'<meta name="author" content="">'
  .'<title>Descontos</title>'
 .'<link rel="apple-touch-icon" href="../../biblioteca/assets/images/apple-touch-icon.png">'
 .'<link rel="shortcut icon" href="../../biblioteca/assets/images/favicon.ico">'
.'<!-- Stylesheets -->'
  .'<link rel="stylesheet" href="../../biblioteca/assets/css/bootstrap.min.css">'
  .'<link rel="stylesheet" href="../../biblioteca/assets/css/bootstrap-extend.min.css">'
  .'<link rel="stylesheet" href="../../biblioteca/assets/css/site.min.css">'
  .'<link rel="stylesheet" href="../../biblioteca/assets/css/estilo.css?'
            .time()    
            . '">' 
  .'<!-- Plugins -->'
  .'<link rel="stylesheet" href="../../biblioteca/assets/vendor/animsition/animsition.css">'
  .'<link rel="stylesheet" href="../../biblioteca/assets/vendor/asscrollable/asScrollable.css">'
  .'<link rel="stylesheet" href="../../biblioteca/assets/vendor/switchery/switchery.css">'
  .'<link rel="stylesheet" href="../../biblioteca/assets/vendor/intro-js/introjs.css">'
  .'<link rel="stylesheet" href="../../biblioteca/assets/vendor/slidepanel/slidePanel.css">'
  .'<link rel="stylesheet" href="../../biblioteca/assets/vendor/flag-icon-css/flag-icon.css">'
  .'<!-- Page -->'
  .'<link rel="stylesheet" href="../../biblioteca/assets/examples/css/pages/invoice.css">'
  .'<!-- Fonts -->'
  .'<link rel="stylesheet" href="../../biblioteca/assets/fonts/web-icons/web-icons.min.css">'
  .'<link rel="stylesheet" href="../../biblioteca/assets/fonts/brand-icons/brand-icons.min.css">'
  .'<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic">'
  .'<!-- Scripts -->'
  .'<script src="../../biblioteca/assets/vendor/modernizr/modernizr.js"></script>'
  .'<script src="../../biblioteca/assets/vendor/breakpoints/breakpoints.js"></script>'
 .' <script>'
 .'   Breakpoints();'
 .' </script>'
.'</head>'
.'<body class="page-invoice" style="padding-top: 5px;">'
.'<!-- Page -->'
.'  <div class="page animsition">'
.'      <div class="page-header" style="padding: 10px 10px">'
.'      <h1 class="page-title">Descontos</h1>'
.'    </div>'
.'    <div class="page-content">'
.'      <!-- Panel -->'
.'      <div class="panel">'
.'        <div class="panel-body container-fluid">'
.'            '
.'          <div class="col-md-12">'
.''

.$sTable
.'          </div>'
.'          '
.''
.'          '
.$sSomaTotal
.'       '
.'        '
.'          '
.'              <div class="row"> '
.'                  <div class="col-lg-2">'
.'                    <button type="button" class="btn btn-primary"'
.'                    onclick="javascript:window.print();">'
.'                      <span><i class="icon wb-print" aria-hidden="true"></i> Print</span>'
.'                    </button>'
.'                      '
.'              </div>'
.'         '
.'            '
.'        </div>'
.'      </div>'
.'      <!-- End Panel -->'
.'    </div>'
.'  </div>'
.'  <!-- End Page -->'
.''
.' ' 
.' '
.'  <!-- Core  -->'
.'  <script src="../../biblioteca/assets/vendor/jquery/jquery.js"></script> '
.'  <script src="../../biblioteca/assets/vendor/bootstrap/bootstrap.js"></script> '
.'  <script src="../../biblioteca/assets/vendor/animsition/jquery.animsition.js"></script>'
.'  <script src="../../biblioteca/assets/vendor/asscroll/jquery-asScroll.js"></script>'
.'  <script src="../../biblioteca/assets/vendor/mousewheel/jquery.mousewheel.js"></script>'
.'  <script src="../../biblioteca/assets/vendor/asscrollable/jquery.asScrollable.all.js"></script> '
.'  <script src="../../biblioteca/assets/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>  '
.''
.'  <!-- Plugins -->'
.'  <script src="../../biblioteca/assets/vendor/switchery/switchery.min.js"></script>'
.'  <script src="../../biblioteca/assets/vendor/intro-js/intro.js"></script>'
.'  <script src="../../biblioteca/assets/vendor/screenfull/screenfull.js"></script>'
.'  <script src="../../biblioteca/assets/vendor/slidepanel/jquery-slidePanel.js"></script>'
.''
.'  <!-- Scripts -->'
.'  <script src="../../biblioteca/assets/js/core.js"></script>'
.'  <script src="../../biblioteca/assets/js/site.js"></script>'
.''
.'  <script src="../../biblioteca/assets/js/sections/menu.js"></script>'
.'  <script src="../../biblioteca/assets/js/sections/menubar.js"></script>'
.'  <script src="../../biblioteca/assets/js/sections/gridmenu.js"></script>'
.'  <script src="../../biblioteca/assets/js/sections/sidebar.js"></script>'
.''
.'  <script src="../../biblioteca/assets/js/configs/config-colors.js"></script>'
.'  <script src="../../biblioteca/assets/js/configs/config-tour.js"></script>'
.''
.'  <script src="../../biblioteca/assets/js/components/asscrollable.js"></script>'
.'  <script src="../../biblioteca/assets/js/components/animsition.js"></script>'
.'  <script src="../../biblioteca/assets/js/components/slidepanel.js"></script>'
.'  <script src="../../biblioteca/assets/js/components/switchery.js"></script>'
.''
.'  <!-- Scripts For This Page -->'
.''
.''
.'  <script>'
.'    (function(document, window, $) {'
.'      "use strict";'
.''
.'      var Site = window.Site;'
.'      $(document).ready(function() {'
.'        Site.run();'
.'      });'
.'    })(document, window, jQuery);'
.'  </script>'
.''
.' '   
.'</body> '
.'</html>';

echo $sHtml;