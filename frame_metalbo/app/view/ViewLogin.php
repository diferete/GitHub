<?php

class ViewLogin extends View {

    public function criaTela() {
        parent::criaTela();
        $this->addCampos();
    }

    function getTelaLogin() {
        //verifica se tem o cookie
        if (isset($_COOKIE['loginUser'])) {
            $sUser = $_COOKIE['loginUser'];
        } else {
            $sUser = '';
        };
        //verifica se tem o cookie de senha
        if (isset($_COOKIE['pass'])) {
            $sPass = $_COOKIE['pass'];
        } else {
            $sPass = '';
        }

        if (isset($_REQUEST['soluser'])) {
            $bSoluser = $_REQUEST['soluser'];
        }

        $sTelaIncial = '<!DOCTYPE html>'
                . '<html class="no-js" lang="en">'
                . '<head>'
                //.'<meta charset="utf-8">'
                . '<meta http-equiv="X-UA-Compatible" content="IE=edge">'
                . '<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">'
                . '<link rel="shortcut icon" href="biblioteca/assets/images/favicon.ico">'
                . '<!-- Stylesheets -->'
                . '<link rel="stylesheet" href="biblioteca/assets/css/bootstrap.min.css">'
                . '<link rel="stylesheet" href="biblioteca/assets/css/bootstrap-extend.min.css">'
                . '<link rel="stylesheet" href="biblioteca/assets/css/site.min.css">'
                . '<!-- Page -->'
                . '<link rel="stylesheet" href="biblioteca/assets/css/login.css?'
                . time()
                . '">'
                . '<link rel="stylesheet" href="biblioteca/assets/vendor/bootstrap-sweetalert/sweet-alert.css">'
                . '<title>Metalbo | Acesso ao Sistema</title>'
                . '</head>'
                . '<body class="page-login-v3 layout-full">'
                . '<div id="conteudo">'
                . '<div class="page animsition vertical-align text-center" data-animsition-in="fade-in"'
                . 'data-animsition-out="fade-out">'
                . '<div class="page-content vertical-align-middle">'
                . '<div class="panel">'
                . '<div class="panel-body">'
                . '<div class="brand">'
                //. '<img class="brand-img" src="biblioteca/assets/images/grupo-rex.jpg" alt="Metalbo: Uma empresa do grupo Rex Máquinas" style="max-width: 320px; width: 100%;">'
                . '<img class="brand-img" src="biblioteca/assets/images/logo.png" alt="Metalbo" style="max-width: 320px; width: 100%;">'
                . '</div>'
                . '<form method="post" id="frm-login">'
                . '<div class="form-group form-material floating" style="margin-left:0 !important">'
                . '<input type="email" class="form-control" style="font-size:14px;padding:5px" name="login" value="' . $sUser . '" />'
                . ' <label class="floating-label">E-mail</label>'
                . '</div>'
                . '<div class="form-group form-material floating" style="margin-left:0 !important"">'
                . ' <input type="password" class="form-control" name="loginsenha" style="font-size:14px;padding:5px" value="' . $sPass . '" id="psswd"/>'
                . ' <label class="floating-label">Senha</label>'
                . '</div>'
                . ' <input type="button" class="btn btn-block btn-success margin-top-40" id="12345" value="ENTRAR" onclick="requestAjax(\'frm-login\',\'Login\',\'logaSistema\',\'\')" />'
                . '</form>'
                . '<p><a href="#" data-target="#style2538359449931f24b2" data-toggle="modal" id="solicita">Clique aqui para solicitar um usuário.</a></p>'
                . '<a target="_blank" href="https://www.youtube.com/channel/UCO6rJtl4ePqsWRTztRFkE5w"><img src="biblioteca/assets/images/youtube.png" /></a>'
                . '       <a target="_blank" href="https://facebook.com/metalbo.oficial"><img src="biblioteca/assets/images/face.png" /></a>'
                . '</div>'
                . '</div>'
                . '<div id="resultado">'
                . '</div>'

                //gera modal de solicitação de usuário
                . '<form method="post" id="frm-sol">'
                . '<div class="modal fade" id="style2538359449931f24b2" aria-hidden="true" aria-labelledby="examplePositionCenter" '
                . 'role="dialog" tabindex="-1" container-fluid> '
                . '  <div class="modal-dialog modal-center"> '
                . '    <div class="modal-content"> '
                . '      <div class="modal-header"> '
                . '        <button type="button" class="close" id="closeSol" data-dismiss="modal" aria-label="Close"> '
                . '          <span aria-hidden="true">×</span> '
                . '        </button> '
                . '        <h5 class="modal-title">Preencha as dados para solicitar seu usuário!</h5> '
                . '      </div> '
                . '     <div class="modal-body" id="solUser-modal"> '
                . '<div class="form-group form-material floating"> '
                . '<label class="control-label" for="inputText"><h5>Nome</h5></label> '
                . '<input type="text" class="form-control" id="nomeSol" name="nomeSol" placeholder="Insira seu nome" require/> '
                . '</div>  '
                . '<div class="form-group form-material"> '
                . '<label class="control-label" for="inputText"><h5>Sobrenome</h5></label> '
                . '<input type="text" class="form-control" id="sobrenomeSol" name="sobrenomeSol" placeholder="Insira seu sobrenome" require/> '
                . '</div>  '
                . '<div class="form-group form-material"> '
                . '<label class="control-label" for="inputText"><h5>Login</h5></label> '
                . '<input type="text" class="form-control" id="loginSol" name="loginSol" placeholder="Insira um e-mail para servir como login" require/> '
                . '</div>  '
                . '<div class="form-group form-material"> '
                . '<label class="control-label" for="inputText"><h5>E-mail</h5></label> '
                . '<input type="text" class="form-control" id="emailSol" name="emailSol" placeholder="Insira seu e-mail para receber notificações do sistema" require/> '
                . '</div>  '
                . '<div class="form-group form-material"> '
                . '<label class="control-label" for="inputText"><h5>Observações</h5></label> '
                . '<textarea class="form-control" id="obsSol" name="obsSol" placeholder="Observação" rows="3"></textarea> '
                . '</div>  '
                /*

                 * 
                 *                          */
                . '      </div> '
                . '      <div class="modal-footer"> '
                . '         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> '
                . '        <button type="button" class="btn btn-success"  onclick="requestAjax(\'frm-sol\',\'SolCadUser\',\'insereSolCad\',\'solUser-modal\');">Confirmar</button> '
                . '      </div> '
                . '    </div> '
                . '  </div> '
                . '</div>'
                . '</form>'

                /* .'<footer class="page-copyright page-copyright-inverse">'
                  .'<p>SISTEMA METALBO</p>'
                  .'<p>© '.Util::getYear().' -  Todos os direitos reservados.</p>'
                  .'<div class="social">'
                  .'<a class="btn btn-icon btn-pure" href="javascript:void(0)">'
                  .' <i class="icon bd-twitter" aria-hidden="true"></i>'
                  .' </a>'
                  .'<a class="btn btn-icon btn-pure" href="javascript:void(0)">'
                  .' <i class="icon bd-facebook" aria-hidden="true"></i>'
                  .'</a>'
                  .'<a class="btn btn-icon btn-pure" href="javascript:void(0)">'
                  .' <i class="icon bd-google-plus" aria-hidden="true"></i>'
                  .'</a>'
                  .' </div>'
                  .'</footer>' */
                . '</div>'
                . '</div>'
                . '<!-- End Page -->'

                //apenas para iniciar
                . '<script> var abaSelecionada = "";</script>'
                . '<!-- Core  -->'
                . '<script src="biblioteca/assets/vendor/jquery/jquery.js"></script>'
                . '<script src="biblioteca/assets/vendor/bootstrap/bootstrap.js"></script>'
                . '<script src="biblioteca/assets/vendor/animsition/jquery.animsition.js"></script>'
                . '<script src="biblioteca/assets/vendor/asscroll/jquery-asScroll.js"></script>'
                . '<script src="biblioteca/assets/vendor/mousewheel/jquery.mousewheel.js"></script>'
                . '<script src="biblioteca/assets/vendor/asscrollable/jquery.asScrollable.all.js"></script>'
                . '<script src="biblioteca/assets/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>'
                . '<!-- Plugins -->'
                . '<script src="biblioteca/assets/vendor/switchery/switchery.min.js"></script>'
                . '<script src="biblioteca/assets/vendor/intro-js/intro.js"></script>'
                . '<script src="biblioteca/assets/vendor/screenfull/screenfull.js"></script>'
                . '<script src="biblioteca/assets/vendor/slidepanel/jquery-slidePanel.js"></script>'
                . '<!-- Plugins For This Page -->'
                . '<script src="biblioteca/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>'
                . ' <script src="biblioteca/assets/vendor/bootstrap-sweetalert/sweet-alert.js"></script>'
                . '<!-- Scripts -->'
                . '<script src="biblioteca/assets/js/core.js"></script>'
                . '<script src="biblioteca/assets/js/site.js"></script>'
                . '<script src="biblioteca/assets/js/sections/menu.js"></script>'
                . '<script src="biblioteca/assets/js/sections/menubar.js"></script>'
                . '<script src="biblioteca/assets/js/sections/gridmenu.js"></script>'
                . '<script src="biblioteca/assets/js/sections/sidebar.js"></script>'
                . '<script src="biblioteca/assets/js/configs/config-colors.js"></script>'
                . '<script src="biblioteca/assets/js/configs/config-tour.js"></script>'
                . ' <script src="biblioteca/assets/js/components/asscrollable.js"></script>'
                . '<script src="biblioteca/assets/js/components/animsition.js"></script>'
                . ' <script src="biblioteca/assets/js/components/slidepanel.js"></script>'
                . '<script src="biblioteca/assets/js/components/switchery.js"></script>'
                . '<!-- Scripts For This Page -->'
                . '<script src="biblioteca/assets/js/components/jquery-placeholder.js"></script>'
                . '<script src="biblioteca/assets/js/components/material.js"></script>'
                . '<script src="resources/js/ajax.js"></script>'
                . '   <script src="resources/js/funcoes.js?'
                . time()
                . ' "></script>'
                . '<script>'
                . '$(document).on("keydown", function(event) {'
                . 'if(event.keyCode === 13) {'
                . 'hasFocus = $("#psswd").is(":focus"); '
                . 'if(hasFocus){'
                . 'requestAjax(\'frm-login\',\'Login\',\'logaSistema\',\'\')'
                . '}'
                . '}'
                . '});'
                . '$("#psswd").focus();'
                . '</script>'
                . '</div>'
                . '</body>'
                . '</html>';


        if ($bSoluser) {
            $sTelaIncial .= '<script>'
                    . ' $(document).ready(function () { '
                    . ' $("#solicita").click();  '
                    . ' alert();'
                    . '}); '
                    . '</script>';
        }
        //verifica se tem a senha salva
        /*  if (isset($_COOKIE['pass'])) {
          $sTelaIncial.='<script>'
          .' $(document).ready(function () { '
          .' $("#btn_entrar").click();  '
          .'}); '
          .'</script>';
          } */


        return $sTelaIncial;
    }

    public function erroLogin($msg) {
        $sRetorno = '<!-- Modal -->'
                . '<div class="modal fade modal-danger" id="exampleModalDanger" aria-hidden="true"'
                . 'aria-labelledby="exampleModalDanger" role="dialog" tabindex="-1">'
                . '<div class="modal-dialog modal-sm">'
                . '<div class="modal-content">'
                . '<div class="modal-header">'
                . '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
                . '<span aria-hidden="true">×</span>'
                . ' </button>'
                . '<h4 class="modal-title">Credenciais Inválidas</h4>'
                . '</div>'
                . '<div class="modal-body">'
                . '<hr/><span class="glyphicon glyphicon-search" aria-hidden="true"></span><b>Verifique seus dados de acesso ou contate o setor de TI.</b><hr/>'
                . '</div>'
                . '<div class="modal-footer">'
                . ' <button type="button" class="btn btn-danger" data-dismiss="modal">FECHAR</button>'
                . '</div>'
                . '</div>'
                . ' </div>'
                . '</div>'
                . '<!-- End Modal -->';

        return""//$('#resultado').empty();
                . "$('#resultado').append('" . $sRetorno . "');"
                . "$('#exampleModalDanger').modal('toggle'); ";
    }

    /**
     * função para redefinir a senha
     */
    public function redfineSenha() {
        $sRetorno = '<!-- Modal -->'
                . '<div class="modal fade modal-success" id="exampleFormModal" aria-hidden="true"'
                . 'aria-labelledby="exampleFormModalLabel" role="dialog" tabindex="-1">'
                . '   <div class="modal-dialog"> '
                . '        <form method="post" id="frm-redefini" class="modal-content"> '
                . '          <div class="modal-header">'
                . '            <h4 class="modal-title" id="exampleFormModalLabel">Redefinição de senha - Digite uma nova senha e clique em confirmar!</h4>'
                . '            <h5 class="modal-info" id="exampleFormModalLabel">*Mínimo 5 caracteres</h5>'
                . '            <h5 class="modal-info" id="exampleFormModalLabel">*Torne sua senha forte com números e caracteres</h5>'
                . '           </div>'
                . '          <div class="modal-body">'
                . '            <div class="row">'
                . '              <div id="input1" class="col-lg-6 form-group">'//has-error  has-success
                . '                <input type="password" id="passwd1" class="form-control" name="Nova senha" placeholder="Nova senha" onBlur="strongPass();">'
                . '<small id ="span1" class="help-block" data-fv-validator="notEmpty" data-fv-for="standard_fullName" data-fv-result="INVALID" style="display: block;"><b>.....</b></small>'
                . '              </div>'
                . '              <div id="input2" class="col-lg-6 form-group">'
                . '                 <input type="password" id="passwd2" class="form-control" name="Confirme nova senha" placeholder="Confirme nova senha" onBlur="strongPass();">'
                . '<small id ="span2" class="help-block" data-fv-validator="notEmpty" data-fv-for="standard_fullName" data-fv-result="INVALID" style="display: block;"><b>.....</b></small>'
                . '              </div>'
                . '            </div>'
                . '<br/><hr/>'
                . '           <div class="row">'
                . '<br/><br/>'
                . '              <div class="col-sm-12 pull-right">'
                . '                 <button id="botao1" class="btn btn-success"  type="button" disabled="disabled" onclick="callRequestRedefine();">Confirmar</button>'
                . '              </div>'
                . '           </div>'
                . '          </div>'
                . '        </form>'
                . '     </div>'
                . '</div>'
                . '<!-- End Modal -->';

        return"$('#resultado').empty();"
                . "$('#resultado').append('" . $sRetorno . "');"
                . "$('#exampleFormModal').modal('toggle');$('#passwd1').focus();";









        /* <!-- Modal -->
          <div class="modal fade" id="exampleFormModal" aria-hidden="false" aria-labelledby="exampleFormModalLabel"
          role="dialog" tabindex="-1">
          <div class="modal-dialog">
          <form class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="exampleFormModalLabel">Set The Messages</h4>
          </div>
          <div class="modal-body">
          <div class="row">
          <div class="col-lg-4 form-group">
          <input type="text" class="form-control" name="firstName" placeholder="First Name">
          </div>
          <div class="col-lg-4 form-group">
          <input type="email" class="form-control" name="lastName" placeholder="Last Name">
          </div>
          <div class="col-lg-4 form-group">
          <input type="email" class="form-control" name="email" placeholder="Your Email">
          </div>
          <div class="col-lg-12 form-group">
          <textarea class="form-control" rows="5" placeholder="Type your message"></textarea>
          </div>
          <div class="col-sm-12 pull-right">
          <button class="btn btn-primary btn-outline" data-dismiss="modal" type="button">Add Comment</button>
          </div>
          </div>
          </div>
          </form>
          </div>
          </div> */
    }

}
