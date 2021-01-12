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
              <h2 class="corPadrao">EXCELLENCE IN MANUFACTURING!</h2>
              <p class="paragrafo corPadrao"> Our high quality products are made of raw material from renowned suppliers like Arcelor Mittal , Belgo Bekaert Arames, Gerdau Açominas, Gerdau Aços longos, Gerdau Aços especiais. </p>
              <p><a class="btn btn-success btn-large"  href="fabrica.php">GET TO KNOW OUR FACTORY!</a></p>
            </div><!--FIM DA DIV EXECELENCIA FABRICACAO-->
            <div class="span4"><!--INICIO DA DIV BRASIL E AMERICA LATINA *FECHADA-->  
              <h2 class="corPadrao">BRAZIL AND LATIN AMERICA!</h2>
              <p class="paragrafo corPadrao">Metalbo has a strong presence in the Market of nuts and bolts, supplying all over Brazil and Mercosul and exporting since 1996, making Metalbo one of the largest manufacturers of fasteners in Brazil.  </p><br/>
              <p><a class="btn btn-success btn-large" href="expedicao.php">GET TO KNOW OUR SHIPPING SYSTEM!</a></p>
            </div><!--FIM DA DIV BRASIL E AMERICA-->
            <div class="span4"><!--INICIO DA DIV CERTIFICADA *FECHADA-->
              <h2 class="corPadrao">CERTIFICADA ISO 9001</h2>
              <p class="paragrafo corPadrao">On March 11th 2008, Rex machines won an Award for its Quality Management System - ISO 9001:2008, demonstrating the quality of Metalbo products. </p><br/>
              <p><a class="btn btn-success btn-large" href="iso.php">SEE MORE! &raquo;</a></p>
            </div><!--FIM DA DIV CERTIFICADA-->
          </div><!--FIM DA ROW DO CORPO-->
          <hr/>
          
          <hr/>
          <div class="row-fluid"> <!--PRÓXIMA ROW DO SITE SE NECESSÁRIO * FECHADA-->
           <div class="span4"> <!--DIV PARCEIROS-->  
             <ul class="thumbnails">
              <li>
                <div class="thumbnail">
                  <img src="images/metalbosp.jpg" alt="">
                  <div class="caption">
                    <h3 class="corPadrao">SALES IN SAO PAULO</h3>
                    <p class="paragrafo corPadrao">We provide our service throughout the state of São Paulo, Rio de Janeiro , Espírito Santo , Goiás , Tocantins , Maranhão , Rondônia , Pará , Amapá , Roraima , Amazonas and Acre!</p>
                    <p><a href="http://www.metalbosp.com.br/" target="new" class="btn btn-success btn-large">VISITE NOSSO SITE!</a> </p>
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
                    <h3 class="corPadrao">LATIN AMERICA</h3>
                     <p class="paragrafo corPadrao">. Handel S.A.  is a company working in the sales representative business of world- renowned brands!</p>
                    <p><a href="http://handel.com.ar/" target="new" class="btn btn-success btn-large">VISITE NOSSO SITE</a> </p>
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
                    <h3 class="corPadrao">SALES REPS</h3>
                    <p class="paragrafo corPadrao">Meet all sales representatives!</p>
                    <p><a href="representantes.php?link=4" class="btn btn-success btn-large">INFORME SUA REGIÃO!
                    </a> </p>
                  </div>
                </div>
              </li>
              </ul> 
             </div> <!--FIM DA DIV PARCEIROS--> 
               
          </div><!--FIM DA ROW SE NECESSÁRIO-->
       
          
         
          <div class="row-fluid"> <!--ROW DO GRUPO * FECHADA-->
           <div class="span12">
             <div class="span8"> 
              <ul class="thumbnails">
              <li>
                 <h2 class="corPadrao">GRUPO REX MÁQUINAS!</h2>
                        <div class="jimgMenu">
                         <ul>
                          <!--<li class="landscapes"><a href="#nogo">Landscapes</a></li>-->
                          <li class="people"><a href="http://www.steeltrater.com.br/" target="new">SteelTrater</a></li>
                          <li class="nature"><a href="http://www.poliamidos.com.br/pt-br/" target="new">Poliamidos</a></li>
                          <li class="abstract"><a href="http://rexmaquinas.com.br/index_fornos.php" target="new">Rex Máquinas</a></li>
                          <li class="urban"><a href="">Metalbo</a></li>
                         </ul>
                        </div>
                  
              </li>
              </ul> 
              </div>
              
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