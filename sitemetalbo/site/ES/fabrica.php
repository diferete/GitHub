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
                 <h3 class="corPadrao">EXELÊNCIA NA FABRICAÇÃO! </h3>
             <hr />
             <p style="text-align:justify">
                Metalbo dispone de un amplio parque fabril, Ubicada en la ciudad de Trombudo Central en el estado de Santa Catarina. Tenemos como segmento el ramo metal mecánico con foco principal en la producción de elementos de fijación como tornillos, astas, barras roscadas, tuercas, arandelas y fijadores. Con más de cincuenta años de experiencia Metalbo se dedica a la calidad de sus productos y satisfacción de sus clientes.</p>
             <p style="text-align:justify">
             El proceso de fabricación de elementos de fijación requiere responsabilidad y calidad pues nuestros productos son usados para los más diversos objetivos, desde máquinas y construcciones etc. Teniendo eso en mente Metalbo mantiene un equipo de trabajadores experientes y entrenados para atender a las expectativas de sus productos y bien como riguroso control de calidad, y claro usando materia prima de proveedores reconocidos en el mercado mundial. </p>
             
             
             
             
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