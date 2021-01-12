<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fábrica - Metalbo</title>
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
                 <h3 class="corPadrao">EXCELÊNCIA NA FABRICAÇÃO! </h3>
             <hr />
             <p style="text-align:justify">
                A Metalbo disponibiliza um amplo parque fabril, localizada na cidade de Trombudo Central no estado de Santa Catarina. Temos como segmento o ramo metal mecânico com foco principal na produção de elementos de fixação como parafusos, hastes, barras roscadas, porcas, arruelas e fixadores. Com mais de cinquenta anos de experiência a Metalbo se dedica na qualidade de seus produtos e satisfação de seus clientes.</p>
             <p style="text-align:justify">
             O processo de fabricação de elementos de fixação requer responsabilidade e qualidade pois nossos produtos são usados para os mais diversos objetivos, desde máquinas e construções etc. Tendo isso em mente a Metalbo mantém uma equipe de funcionários experiente e treinada para atender as expectativas de seus produtos e bem como rigoroso controle de qualidade, e claro usando matéria prima de fornecedores renomados no mercado mundial. </p>
             
             
             
             
             <hr />
               
             </p>
               <div id="foo1">
                
                <img src="images/imagensfab/img2.JPG" width="350" />
                <img src="images/imagensfab/img3.JPG" width="350" style="margin-left:20px"/>
                <img src="images/imagensfab/img4.JPG" width="350" style="margin-left:20px"/>
                <img src="images/imagensfab/img5.JPG" width="350" style="margin-left:20px"/>
                
                
               </div>
           </div>
        </div>
    </div>
<footer>
	<? include("estrutura/rodape.php"); ?>
</footer>
</body>
</html>