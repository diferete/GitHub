<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manufactures - Metalbo</title>
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
                 <h3 class="corPadrao">EXCELLENCE IN MANUFACTURING! </h3>
             <hr />
             <p style="text-align:justify">
                The Metalbo offers a large industrial park, located in Central City in the state of Santa Catarina. We segment the branch as metal mechanic with main focus on the production of fasteners such as screws, rods, threaded rods, nuts, washers and fasteners. With over fifty years of experience Metalbo focuses on quality products and customer satisfaction.</p>
             <p style="text-align:justify">
             The process of manufacturing of fasteners requires responsibility and quality as our products are used for various purposes, from construction machinery and so on. Keeping this in mind Metalbo maintains an experienced staff and trained to meet the expectations of their products and as well as strict quality control, and of course using raw material from renowned suppliers in the world market. </p>
             
             
             
             
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