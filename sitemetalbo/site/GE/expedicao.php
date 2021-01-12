<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Versand - Metalbo</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" />
<link rel="shortcut icon" href="images/metalb.ico" type="image/x-icon" />
<script type="text/javascript" src="jquery/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="jquery/jquery.carouFredSel-6.2.1.js"></script>
<script type="text/javascript">
$(document).ready(function() {


    // Using default configuration

    $("#foo1").carouFredSel();

     

    // Using custom configuration

    $("#foo2").carouFredSel({

        items               : 4,

        direction           : "up",

        scroll : {

            items           : 2,

            easing          : "elastic",

            duration        : 1000,                        

            pauseOnHover    : true

        }                  
  });

});
</script>
</head>

<body>
<? include("estrutura/topo.php");?>
    <div class="container-fluid">
    	<div class="row-fluid">
	    	<div class="span2">
   				<? include("estrutura/menulat.php"); ?>
  			</div><!-- FIM DA DIV DO MENU LATERAL-->
            <div class="span8 margemTop50 corPadrao">
             <hr />
                 <h3 class="corPadrao">VERSAND! </h3>
             <hr />
             <img src="images/exp2.jpg" style="float:left; margin-right:15px" class="img-polaroid"/><div style="text-align:justify"><p> Metalbo verfügt über einen weitgehenden und flinken Versand um eine schnelle Lieferung der Bestellungen Ihrer Kunden zu garantieren, da Metalbo immer genug Artikel auf Lager hat.</p> 
             <p>Metalbo benutzt kodifizierte Verpackungen von “Master e Mínimas”  mit EAN13 Barcode, und vereinfacht somit die Lagerverwaltung ihrer Kunden. </p>
             <p> Ausgerüsstet mit einem integrierten System zwischen Vertretung, Handel und Versand, wird Ihre Bestellung in wenigen Minuten bearbeitet und der Versand beschleunigt.</p>
              
              <div class="row-fluid">
                  <div class="panel panel-default" style="margin-top:25px">
                <div class="panel-heading"><div class="corPadrao"><h4>VERPACKUNGSSTANDARD:</h4></div></div>
                 <div class="panel-body">
                   <div style="margin-left:30px"> <img src="images/caixa1.jpg" /><img src="images/caixa2.jpg" /> </div>
                       
                         
                          
                            <h4>DOWNLOAD DER VERPACKUNGSBROSCHÜRE!</h4>
                            <p>Format xls.</p>
                            <p><a href="#" class="btn btn-primary btn-success">DOWNLOAD</a></p>
                          
                   </div>
                  </div>
                 </div>
              </div>
            
            
             
              
            
                
            
           </div>
        </div>
    </div>
<footer>
	<? include("estrutura/rodape.php"); ?>
</footer>
</body>
</html>