<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Metalbo</title>
<link rel="shortcut icon" href="images/metalb.ico" type="image/x-icon" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="css/jimgMenu.css" type="text/css" />
<script type="text/javascript" src="estrutura/js/cufon-yui.js"></script>
<script type="text/javascript" src="estrutura/js/droid_sans_400-droid_sans_700.font.js"></script>
<script type="text/javascript" src="estrutura/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="estrutura/js/script.js"></script>
<script type="text/javascript" src="estrutura/js/coin-slider.min.js"></script>
<script type="text/javascript" src="jquery/jquery-easing-1.3.pack.js"></script>
<script type="text/javascript" src="jquery/jquery-easing-compatibility.1.2.pack.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41409392-2', 'metalbo.com.br');
  ga('send', 'pageview');

</script>
<!--BANNER DO GRUPO --><script type="text/javascript">
$(document).ready(function () {

  // find the elements to be eased and hook the hover event
  $('div.jimgMenu ul li a').hover(function() {
    
    // if the element is currently being animated (to a easeOut)...
    if ($(this).is(':animated')) {
      $(this).stop().animate({width: "310px"}, {duration: 450, easing:"easeOutQuad"});
    } else {
      // ease in quickly
      $(this).stop().animate({width: "310px"}, {duration: 400, easing:"easeOutQuad"});
    }
  }, function () {
    // on hovering out, ease the element out
    if ($(this).is(':animated')) {
      $(this).stop().animate({width: "78px"}, {duration: 400, easing:"easeInOutQuad"})
    } else {
      // ease out slowly
      $(this).stop('animated:').animate({width: "78px"}, {duration: 450, easing:"easeInOutQuad"});
    }
  });
});
</script>

<!--FACEBOOK-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!--FACEBOOK-->
</head>


  <body>
<? include("estrutura/topo.php"); ?>
   
    <div class="container-fluid"><!--CONTAINER DO SITE *FECHADA-->
      <div class="row-fluid"><!-- LINHA INICIAL DO SITE *FECHADA-->
          <div class="span2"><!-- DIV DO MENU LATERAL  *FECHADA-->
            <? include("estrutura/menulat.php"); ?>
          </div><!-- FIM DA DIV DO MENU LATERAL-->
         
          <div class="span10 margemTop50"> <!-- DIV DO CORPO DO SITE *FECHADA-->
            <? include("estrutura/slider.php"); ?>
           <div class="row-fluid"> <!-- LINHA DA DIV DO CORPO DO SITE*FECHADA -->
            <div class="span4" >  <!-- DIV EXELENCIA FABRICAÇÃO *FECHADA -->
              <h2 class="corPadrao">EXCELENCIA EN LA FABRICACIÓN!</h2>
              <p class="paragrafo corPadrao"> Nuestros productos son de gran calidad con materia prima de proveedores reconocidos como Arcelor Mittal, Belgo Bekaert Arames, Gerdau Açominas, Gerdau Aços Longos, Gerdau Aços Especiais. </p>
              <p><a class="btn btn-success btn-large"  href="fabrica.php">CUMPLIR NUESTRA F�?BRICA!</a></p>
            </div><!--FIM DA DIV EXECELENCIA FABRICACAO-->
            <div class="span4"><!--INICIO DA DIV BRASIL E AMERICA LATINA *FECHADA-->  
              <h2 class="corPadrao">BRASIL Y AMÉRICA LATINA!</h2>
              <p class="paragrafo corPadrao">Metalbo tiene actuación fuerte en el mercado de Tuercas y Tornillos atendiendo a todo Brasil y Mercosur exportando desde 1996 haciendo de Metalbo una de los mayores fabricantes de elementos de fijación de Brasil.  </p><br/>
              <p><a class="btn btn-success btn-large" href="expedicao.php">CUMPLIR NUESTRA EXPEDICIÓN!</a></p>
            </div><!--FIM DA DIV BRASIL E AMERICA-->
            <div class="span4"><!--INICIO DA DIV CERTIFICADA *FECHADA-->
              <h2 class="corPadrao">CERTIFICADA <br />ISO 9001</h2>
              <p class="paragrafo corPadrao">En 11 de marzo de 2008, Rex Máquinas conquistó la certificación de su Sistema de Gestión de Calidad ISO 9001:2008 demostrando la calidad de los productos Metalbo. </p><br/>
              <p><a class="btn btn-success btn-large" href="iso.php">VER M�?S! &raquo;</a></p>
            </div><!--FIM DA DIV CERTIFICADA-->
          </div><!--FIM DA ROW DO CORPO-->
          <hr/>
          
          <hr/>
          <div class="row-fluid"> <!--PRÓXIMA ROW DO SITE SE NECESS�?RIO * FECHADA-->
           <div class="span4"> <!--DIV PARCEIROS-->  
             <ul class="thumbnails">
              <li>
                <div class="thumbnail">
                  <img src="images/metalbosp.jpg" alt="">
                  <div class="caption">
                    <h3 class="corPadrao">VENTAS SÃO PAULO</h3>
                    <p class="paragrafo corPadrao">Atendemos a todo el estado de São Paulo, Rio de Janeiro, Espírito Santo, Goiás, Tocantins, Maranhão, Rondônia, Para, Amapá, Roraima, Amazonas y Acre!</p>
                    <p><a href="http://www.metalbosp.com.br/" target="new" class="btn btn-success btn-large">VISITE NUESTRO SITIO!</a> </p>
                    </div>
                </div>
              </li>
              </ul>
             </div> <!--FIM DA DIV PARCEIROS-->    
              <div class="span4"> <!--DIV PARCEIROS-->  
             <ul class="thumbnails">
              <li>
                <div class="thumbnail">
                 <img src="images/Logo Handel.jpg">
                  <div class="caption">
                    <h3 class="corPadrao">AMÉRICA LATINA</h3>
                     <p class="paragrafo corPadrao">Handel S.A., es una empresa en Representaciones exclusivas de marcas reconocidas mundialmente!</p>
                    <p><a href="http://handel.com.ar/" target="new" class="btn btn-success btn-large">VISITE NUESTRO SITIO</a> </p>
                  </div>
                </div>
              </li>
              </ul>
             </div> <!--FIM DA DIV PARCEIROS--> 
              <div class="span4">
               <ul class="thumbnails">
              <li>
                <div class="thumbnail">
                 <img src="images/mendi.jpg">
                 <div class="caption">
                    <h3 class="corPadrao">REPRESENTANTES</h3>
                    <p class="paragrafo corPadrao">Representantes conozca a todos los representantes!</p>
                    <p><a href="representantes.php?link=4" class="btn btn-success btn-large">INFORMAR A SU REGIÓN!
                    </a> </p>
                  </div>
                </div>
              </li>
              </ul> 
             </div> <!--FIM DA DIV PARCEIROS--> 
               
          </div><!--FIM DA ROW SE NECESS�?RIO-->
       
          
         
          <div class="row-fluid"> <!--ROW DO GRUPO * FECHADA-->
           <div class="span12">
             <!--<div class="span8"> 
              <ul class="thumbnails">
              <li>
                 <h2 class="corPadrao">GRUPO REX M�QUINAS!</h2>
                        <div class="jimgMenu">
                         <ul>
                          <li class="landscapes"><a href="#nogo">Landscapes</a></li>
                          <li class="people"><a href="http://www.steeltrater.com.br/" target="new">SteelTrater</a></li>
                          <li class="nature"><a href="http://www.poliamidos.com.br/pt-br/" target="new">Poliamidos</a></li>
                          <li class="abstract"><a href="http://rexmaquinas.com.br/index_fornos.php" target="new">Rex Máquinas</a></li>
                          <li class="urban"><a href="">Metalbo</a></li>
                         </ul>
                        </div>
                  
              </li>
              </ul> 
              </div>-->
              
              <div class="span4">              
                <div class="fb-like-box" data-href="https://www.facebook.com/MetalboRexMaquinas" 
                    data-width="350" data-height="300" 
                    data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" 
                    data-show-border="true">
                </div>
              </div>
            </div>
           </div>   
         
        </div><!--FIM DO SPAN DO CORPO SPAN10-->
      </div><!--FIM DA ROW DO CORPO-->
<!-- RODAPÉ DO SISTEMA -->
          

      <footer>
        <? include("estrutura/rodape.php"); ?>
      </footer>

    </div><!--FIM DA DIV CONTAINER DO SITE-->

   

  </body>
</html>