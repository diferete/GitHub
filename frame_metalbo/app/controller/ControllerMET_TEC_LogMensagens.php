<?php

/*
 * Implementa a classe controler MET_TEC_LogMensagens
 * @author Alexandre de Souza
 * @since 18/05/2020
 */

class ControllerMET_TEC_LogMensagens extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_LogMensagens');
    }

    public function gravaLog($sTitulo, $sMsg, $iTipo) {
        switch ($iTipo) {
            case 0:
                $sTipo = 'Sucesso';
                break;
            case 1:
                $sTipo = 'Aviso';
                break;
            case 2:
                $sTipo = 'Erro';
                break;
            case 3:
                $sTipo = 'Informativo';
                break;
        }


        $aDados = array();
        $aDados[0] = $sTitulo;
        $aDados[1] = $sMsg;
        $aDados[2] = $sTipo;
        $aDados[3] = date('d/m/Y');
        $aDados[4] = date('H:i:s');
        $aDados[5] = $_SESSION['codUser'];
        $aDados[6] = $_SESSION['nome'];

        $this->Persistencia->gravaLog($aDados);
    }

    public function montaListaNotificacoes() {

        $listaHead = ' <a data-toggle="dropdown" href="javascript:void(0)" title="Notifications" aria-expanded="false" data-animation="scale-up" role="button">'
                . '<i class="icon wb-bell" aria-hidden="true"></i>'
                . '<span class="badge badge-danger up">5</span>'
                . '</a>'
                . '<ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">'
                . '<li class="dropdown-menu-header" role="presentation">'
                . '<h5>NOTIFICATIONS</h5>'
                . '<span class="label label-round label-danger">New 5</span>'
                . '</li>';

        $listaBody = $listaHead . '<li class="list-group scrollable is-enabled scrollable-vertical" role="presentation" style="position: relative;">'
                . '<div data-role="container" class="scrollable-container" style="height: 270px; width: 375px;">'
                . '<div data-role="content" class="scrollable-content" style="width: 358px;">'
                . '<a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                . '<div class="media">'
                . '<div class="media-left padding-right-10">'
                . '<i class="icon wb-order bg-red-600 white icon-circle" aria-hidden="true"></i>'
                . '</div>'
                . '<div class="media-body">'
                . '<h6 class="media-heading">A new order has been placed</h6>'
                . '<time class="media-meta" datetime="2015-06-12T20:50:48+08:00">5 hours ago</time>'
                . '</div>'
                . '</div>'
                . '</a>'
                . '<a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                . '<div class="media">'
                . '<div class="media-left padding-right-10">'
                . '<i class="icon wb-user bg-green-600 white icon-circle" aria-hidden="true"></i>'
                . '</div>'
                . '<div class="media-body">'
                . '<h6 class="media-heading">Completed the task</h6>'
                . '<time class="media-meta" datetime="2015-06-11T18:29:20+08:00">2 days ago</time>'
                . '</div>'
                . '</div>'
                . '</a>'
                . '<a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                . '<div class="media">'
                . '<div class="media-left padding-right-10">'
                . '<i class="icon wb-settings bg-red-600 white icon-circle" aria-hidden="true"></i>'
                . '</div>'
                . '<div class="media-body">'
                . '<h6 class="media-heading">Settings updated</h6>'
                . '<time class="media-meta" datetime="2015-06-11T14:05:00+08:00">2 days ago</time>'
                . '</div>'
                . '</div>'
                . '</a>'
                . '<a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                . '<div class="media">'
                . '<div class="media-left padding-right-10">'
                . '<i class="icon wb-calendar bg-blue-600 white icon-circle" aria-hidden="true"></i>'
                . '</div>'
                . '<div class="media-body">'
                . '<h6 class="media-heading">Event started</h6>'
                . '<time class="media-meta" datetime="2015-06-10T13:50:18+08:00">3 days ago</time>'
                . '</div>'
                . '</div>'
                . ' </a>'
                . '<a class="list-group-item" role="menuitem">'
                . '<div class="media">'
                . '<div class="media-left padding-right-10">'
                . '<i class="icon wb-chat bg-orange-600 white icon-circle" aria-hidden="true"></i>'
                . '</div>'
                . '<div class="media-body">'
                . '<h6 class="media-heading">Message received</h6>'
                . '<time class="media-meta" datetime="2015-06-10T12:34:48+08:00">3 days ago</time>'
                . '</div>'
                . '</div>'
                . '</a>'
                . '</div>'
                . '</div>'
                . '<div class="scrollable-bar scrollable-bar-vertical scrollable-bar-hide" draggable="false"><div class="scrollable-bar-handle" style="height: 205.043px;"></div></div></li>'
                . '<li class="dropdown-menu-footer" role="presentation">'
                . '<a href="javascript:void(0)" role="menuitem">'
                . 'All notifications'
                . '</a>'
                . '</li>'
                . '</ul>';

        return;
    }

}
