<?php

class ControllerModulo extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('Modulo');
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();


        $sDados = urldecode(func_get_arg(0));

        $aSerialFiltros = explode('&', $sDados); // transforma a string em array.

        $aFiltros = array();
        $aNovo = array();
        $teste = array();
        foreach ($aSerialFiltros as $item) {
            $valor = explode('=', $item); // quebra o elemento atual em um array com duas posições,onde o indice zero é a chave e o um o valor em $arrN
            if (array_key_exists($valor[0], $aFiltros)) {
                $aFiltros[$valor[0] . "-final"] = $valor[1];
                $aFiltros[$valor[0] . "-tipo"] = "entre";
            } else {
                $aFiltros[$valor[0]] = $valor[1];
            }


            $teste['nome'] = $valor[0];
            $teste['valor'] = $valor[1];
//                $teste['tipo'] = $aFiltros[$valor[0].'-tipo'];
//                $teste['valor2'] = '';
            $aNovo[] = $teste;
        }
        foreach ($aNovo as $itemteste) {
            if (key_exists($key, $search)) {
                
            }
        }
    }

//    public function teste() {
//        $this->Persistencia->teste();
//        $omsg = new Mensagem('Acabou', 'acabou', Mensagem::TIPO_SUCESSO);
//        echo $omsg->getRender();
//    }

    public function testaXmlEdita() {
        require 'app/relatorio/DANFE4.php';
    }

    public function TesteHora() {
        $this->Persistencia->testeHora();
    }

    public function populaFunc() {
        $this->Persistencia->populaFunc();
    }

}
