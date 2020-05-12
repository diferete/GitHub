<?php

/*
 * Implementa a classe view do gerador de classes
 * @author Cleverton Hoffmann
 * @since 07/05/2020
 */

class ViewMET_TEC_GeraMVC extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaTela() {
        parent::criaTela();

        $this->setBTela(true);

        $this->setTituloTela('GERADOR DE CLASSES PARA AS FRAMES METALBO E STEELTRATER');

        //Nome que os arquivos deverão ter bem como as classes
        $oNomeMVC = new Campo('Nome da MVC', 'nomemvc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNomeMVC->addValidacao(false, Validacao::TIPO_STRING);

        //Nome da tabela a ser criado as classes
        $oNomeTabela = new Campo('Nome da Tabela', 'nometabela', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNomeTabela->addValidacao(false, Validacao::TIPO_STRING);

        //Frame a ser salva e gerada a nomenclatura na frente das classes MET_NomeClasse ou STEEL_NomeClasse
        $oFrame = new Campo('Frame MVC', 'frame', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oFrame->addItemSelect('frame_metalbo', 'METALBO');
        $oFrame->addItemSelect('steeltrater', 'STEELTRATER');

        //Botão que chama o método na controler de verificar campos estão preenchidos e assim realizar a geração
        $oBotaoExecuta = new Campo('CRIAR MVC', 'mvc', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoExecuta = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","verificaCampos");';
        $oBotaoExecuta->getOBotao()->addAcao($sAcaoExecuta);

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $this->setBOcultaBotTela(true);
        $this->setBOcultaFechar(true);

        $this->addCampos($oNomeMVC, $oLinha1, $oNomeTabela, $oLinha1, $oFrame, $oLinha1, $oLinha1, $oBotaoExecuta);
    }

}
