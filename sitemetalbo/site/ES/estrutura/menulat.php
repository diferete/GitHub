<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
<link rel="stylesheet" href="../css/style.css" type="text/css" />
<link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="../css/jimgMenu.css" type="text/css" />
<script language="javascript">
$(document).ready(function(){
    var y_fixo = $("#menu").offset().top;
    $(window).scroll(function () {
        $("#menu").animate({
            top: y_fixo+$(document).scrollTop()+"px"
            },{duration:500,queue:false}
        );
    });
});
</script>

<style type="text/css">
#menu {
    left:0px;
    margin:0;
    padding:0;
    position:absolute;
    top:100px;
    width:150px;
}
#menu ul {
    list-style:none;
    margin:0;
    padding:0;
}
#menu ul li {
    margin-bottom:2px;
}
#menu ul li a {
    background-color:#030;
    border:1px solid #999;
    color:#FFF;
    display:block;
    padding:5px 5px 5px 15px;
    text-decoration:none;
}
#menu ul li a:hover {
    background-color:#F00;
    color:#FFF;
	
}
</style>
</head>

<body>
<div id="menu">
   <ul class="menu">
    <li><a href="precos.php" >LISTA DE PRECIO</a></li>
    <li><a href="noticias.php" >NOTICIAS</a></li>
    <li><a href="representantes.php?link=4" >REPRESENTANTES </a></li>
    <li><a href="fabrica.php" >PARQUE FABRIL</a></li>
    <li><a href="expedicao.php" >EXPEDICIÓN</a></li>
    <li><a href="iso.php" >ISO</a></li>
   </ul>
   
</div>
</body>
</html>