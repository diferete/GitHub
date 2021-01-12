<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/metalb.ico" type="image/x-icon" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="css/jimgMenu.css" type="text/css" />
<script type="text/javascript" src="estrutura/js/jquery-1.4.2.min.js"></script>

<title>Representantes - Metalbo</title>
</head>

<body>
<? include("estrutura/topo.php"); ?>
 <div class="container-fluid"><!--CONTAINER DO SITE *FECHADA-->
      <div class="row-fluid"><!-- LINHA INICIAL DO SITE *FECHADA-->
          <div class="span2"><!-- DIV DO MENU LATERAL  *FECHADA-->
            <? include("estrutura/menulat.php"); ?>
          </div><!-- FIM DA DIV DO MENU LATERAL-->
         
          <div class="span10 margemTop50"> <!-- DIV DO CORPO DO SITE *FECHADA-->
              <div class="span6">
                 <h3 class="corPadrao">ATENDEMOS EM TODO O BRASIL!</h3>
                 <hr />
              <h5 class="corPadrao">SELECIONE SEU ESTADO </h5>
              <img src="images/mapa.gif" usemap="#Map" border="0" />
                    <div> <?
                        $pag[1]="estados/rs.php";
                        $pag[2]="estados/sc.php";
						$pag[3]="estados/pr.php";
						$pag[4]="estados/sp.php";
						$pag[5]="estados/rj.php";
						$pag[6]="estados/es.php";
						$pag[7]="estados/mg.php";
						$pag[8]="estados/go.php";
						$pag[9]="estados/ms.php";
						$pag[10]="estados/mt.php";
						$pag[11]="estados/ro.php";
						$pag[12]="estados/ac.php";
						$pag[13]="estados/am.php";
						$pag[14]="estados/rr.php";
						$pag[15]="estados/ap.php";
						$pag[16]="estados/pa.php";	
						$pag[17]="estados/to.php";
						$pag[18]="estados/df.php";
						$pag[19]="estados/ba.php";
						$pag[20]="estados/ma.php";
						$pag[21]="estados/pi.php";
						$pag[22]="estados/ce.php";
						$pag[23]="estados/rn.php";
						$pag[24]="estados/pb.php";
						$pag[25]="estados/pe.php";
						$pag[26]="estados/al.php";	
						$pag[27]="estados/se.php";
                        $link = $_GET["link"];
                         
                    ?>    
              
            </div><!--FIM DA DIV MAPA -->
           </div>
            <div class="span5">
                <?
                if (!empty($link)){
                            if (file_exists($pag[$link])){
                                    require_once($pag[$link]);    
                                }
                                    else{
                                        echo "PAGINA NÃO ENCONTRADA!";    
                                    }
                        }
					?>
                    <map name="Map" id="Map">
                    <area shape="circle" coords="202,327,23" href="representantes.php?link=1" />
					<area shape="rect" coords="228,293,252,314" href="representantes.php?link=2" />
                    <area shape="circle" coords="216,277,15" href="representantes.php?link=3" />
                    <area shape="circle" coords="245,253,16" href="representantes.php?link=4" />
                    <area shape="circle" coords="312,266,20" href="representantes.php?link=5" />
                    <area shape="circle" coords="339,230,23" href="representantes.php?link=6" />
                    <area shape="poly" coords="263,202,312,203,296,245,247,233,275,253,257,227" href="representantes.php?link=7" />
                    <area shape="poly" coords="207,218,249,216,233,181" href="representantes.php?link=8" />
                    <area shape="poly" coords="175,214,217,231,194,261,163,234" href="representantes.php?link=9" />
                    <area shape="poly" coords="141,139,219,152,202,209,156,196" href="representantes.php?link=10" />
                    <area shape="poly" coords="135,176,100,161,98,140,122,137" href="representantes.php?link=11" />
                    <area shape="poly" coords="24,127,87,124,64,161,26,143" href="representantes.php?link=12" />
                    <area shape="poly" coords="38,112,155,112,169,84,70,50" href="representantes.php?link=13" />
                    <area shape="poly" coords="101,16,123,62,149,52,143,16" href="representantes.php?link=14" />
                    <area shape="poly" coords="181,34,221,9,242,44,213,65" href="representantes.php?link=15" />
                    <area shape="poly" coords="165,56,255,78,228,141,171,134" href="representantes.php?link=16" />
                    <area shape="poly" coords="224,170,273,156,244,110" href="representantes.php?link=17" />
                    <area shape="poly" coords="234,169,267,163,275,191,245,193" href="representantes.php?link=18" />
                    <area shape="poly" coords="277,157,327,139,330,189,288,181" href="representantes.php?link=19" />
                    <area shape="poly" coords="273,74,295,87,275,124,253,102" href="representantes.php?link=20" />
                    <area shape="poly" coords="271,136,304,145,317,121,298,101" href="representantes.php?link=21" />
                    <area shape="poly" coords="311,80,342,83,330,116,314,109" href="representantes.php?link=22" />
                    <area shape="poly" coords="351,72,347,110,379,103,384,77" href="representantes.php?link=23" />
                    <area shape="poly" coords="352,115,404,104,410,129,354,127" href="representantes.php?link=24" />
                    <area shape="poly" coords="334,129,423,132,425,146,345,142" href="representantes.php?link=25" />
                    <area shape="poly" coords="344,144,410,147,420,171,349,153" href="representantes.php?link=26" />
                    <area shape="poly" coords="335,150,377,166,364,190,336,176" href="representantes.php?link=27" />
                    </map>
                    
            </div>
          </div><!-- div span10-->
       </div><!-- div row-->
  <footer>
        <? include("estrutura/rodape.php"); ?>
      </footer>
 </div><!-- div container-->
</body>
</html>