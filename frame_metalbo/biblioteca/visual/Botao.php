<?php

/**
 * Classe que implementa a estrutura de botões do sistema
 *
 * @author Avanei Martendal
 * @since 06/11/2015
 */
class Botao {

    private $id;
    private $sTexto;
    private $iTipo;
    private $aAcao; //handler
    private $bDesativado; //se true o botão estará bloqueado para o click
    private $requestAjax; //Somente o request ajax deste "carinha", segundo o Avanei
    private $sStyleBotao;
    private $sNomeModal;
    private $iMarginTop;
    private $sTelaGrande; //Define o valor para tela grandes como note e pc
    private $sTelaMedia; //Define o valor para telas de tablets e notes pequenos
    private $sTelaPequena; //Define o valor para telas pequenas como tablets pequenos e celulares
    private $sTelaMuitoPequena; //Define o valor para telas muito pequenas como celulares pequenos

    const TIPO_PADRAO = 0;
    const TIPO_ADICIONAR = 1;
    const TIPO_REMOVER = 2;
    const TIPO_ALTERAR = 3;
    const TIPO_ATUALIZAR = 4;
    const TIPO_PESQUISAR = 5;
    const TIPO_CONFIRMAR = 6;
    const TIPO_LIMPAR = 7;
    const TIPO_FECHAR = 8;
    const TIPO_FILTRO = 9;
    const TIPO_PROXIMO = 10;
    const TIPO_SMALL = 11;
    const TIPO_VOLTAR = 12;
    const TIPO_DELDETALHE = 13;
    const TIPO_ALTERARDET = 14;
    const TIPO_CONCLUIRDET = 15;
    const TIPO_VIZUALIZAR = 16;
    const TIPO_SMALL_SUB = 17;
    const TIPO_REL = 18;
    const TIPO_DETALHE = 19;
    const TIPO_REMOVER_TELAGRID = 20;
    const TIPO_BOTAOSIMPLES = 21;
    //define o estilo do botão small
    const TIPO_DEFAULT = 'btn-default';
    const TIPO_WARNING = 'btn-warning';
    const TIPO_PRIMARY = 'btn-primary';
    const TIPO_SUCCESS = 'btn-success';
    const TIPO_DANGER = 'btn-danger';

    /**
     * 
     * @param type $sTexto
     * @param type $iTipo
     * @param type $sAcao
     */
    function __construct($sTexto, $iTipo = self::TIPO_PADRAO, $sAcao = "", $sTelaGrande = '2', $sTelaMedia = '2', $sTelaPequena = '12', $sTelaMuitoPequena = '12') {
        $this->id = Base::getId();
        $this->setSTexto($sTexto);
        $this->setITipo($iTipo);
        $this->addAcao($sAcao);
        $this->setRequestAjax($sAcao);
        $this->sStyleBotao = Botao::TIPO_SUCCESS;
        $this->setIMarginTop(0);

        $this->setSTelaGrande($sTelaGrande);
        $this->setSTelaMedia($sTelaMedia);
        $this->setSTelaPequena($sTelaPequena);
        $this->setSTelaMuitoPequena($sTelaMuitoPequena);
    }

    function getSTelaGrande() {
        return $this->sTelaGrande;
    }

    function getSTelaMedia() {
        return $this->sTelaMedia;
    }

    function getSTelaPequena() {
        return $this->sTelaPequena;
    }

    function getSTelaMuitoPequena() {
        return $this->sTelaMuitoPequena;
    }

    function setSTelaGrande($sTelaGrande) {
        $this->sTelaGrande = $sTelaGrande;
    }

    function setSTelaMedia($sTelaMedia) {
        $this->sTelaMedia = $sTelaMedia;
    }

    function setSTelaPequena($sTelaPequena) {
        $this->sTelaPequena = $sTelaPequena;
    }

    function setSTelaMuitoPequena($sTelaMuitoPequena) {
        $this->sTelaMuitoPequena = $sTelaMuitoPequena;
    }

    function getIMarginTop() {
        return $this->iMarginTop;
    }

    function setIMarginTop($iMarginTop) {
        $this->iMarginTop = $iMarginTop;
    }

    function getSNomeModal() {
        return $this->sNomeModal;
    }

    function setSNomeModal($sNomeModal) {
        $this->sNomeModal = $sNomeModal;
    }

    function getSStyleBotao() {
        return $this->sStyleBotao;
    }

    function setSStyleBotao($sStyleBotao) {
        $this->sStyleBotao = $sStyleBotao;
    }

    function getId() {
        return $this->id;
    }

    function getSTexto() {
        return $this->sTexto;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setSTexto($sTexto) {
        $this->sTexto = $sTexto;
    }

    function getITipo() {
        return $this->iTipo;
    }

    function setITipo($iTipo) {
        $this->iTipo = $iTipo;
    }

    /**
     * Recupera valor booleano se botão está desativado para click
     * @return boolean 
     */
    function getBDesativado() {
        return $this->bDesativado;
    }

    /**
     * define valor booleano se botão está desativado para click
     * @param boolean $bDesativado
     */
    function setBDesativado($bDesativado) {
        $this->bDesativado = $bDesativado;
    }

    function getRequestAjax() {
        return $this->requestAjax;
    }

    function setRequestAjax($requestAjax) {
        $this->requestAjax = $requestAjax;
    }

    /**
     * Define o valor do atributo aAcao
     * 
     * @param string sAcao 
     */
    public function addAcao($sAcao) {
        $this->aAcao[] = '$("#' . $this->getId() . '").click(function(){' . $sAcao . '});';
    }

    /**
     * 
     * Retorna o conteúdo do array ação
     *
     */
    function getAAcao() {
        $sAcao = "";
        foreach ($this->aAcao as $value) {
            $sAcao .= $value;
        }
        return $sAcao;
    }

    function setDesativado($bValor) {
        if ($bValor) {
            return 'disabled';
        }
    }

    public function getRender() {
        switch ($this->iTipo) {
            case self::TIPO_ADICIONAR:
                $sBotao = '<button title="Adicionar registro" type="button" class="btn btn-icon btn-default btn-outline" name ="' . $this->getId() . '"  id="' . $this->getId() . '" ' . $this->setDesativado($this->getBDesativado()) . '>'
                        . '<span><i class="icon wb-plus-circle" aria-hidden="true"></i>' . $this->sTexto . '</span>'
                        . '</button>'
                        . '<script>'
                        . '</script>';
                break;
            case self::TIPO_ALTERAR:
                $sBotao = '<button  title="Alterar registro" type="button" class="btn btn-icon btn-default btn-outline" id="' . $this->getId() . '" ' . $this->setDesativado($this->getBDesativado()) . '>'
                        . '<span><i class="icon wb-pencil" aria-hidden="true"></i>' . $this->sTexto . '</span>'
                        . '</button>'
                        . '<script>'
                        . '</script>';
                break;
            case self::TIPO_REMOVER:
                $sBotao = '<button  title="Remover registro" type="button" class="btn btn-icon btn-default btn-outline" id="' . $this->getId() . '"  ' . $this->setDesativado($this->getBDesativado()) . ' >'
                        . '<span><i class="icon wb-trash" aria-hidden="true"></i>' . $this->sTexto . '</span>'
                        . '</button>'
                        . '<script>'
                        . '</script>';
                break;
            case self::TIPO_VIZUALIZAR:
                $sBotao = '<button title="Visualizar registro" type="button" class="btn btn-icon btn-default btn-outline" name ="' . $this->getId() . '"  id="' . $this->getId() . '" ' . $this->setDesativado($this->getBDesativado()) . '>'
                        . '<span><i class="icon wb-desktop" aria-hidden="true"></i>' . $this->sTexto . '</span>'
                        . '</button>'
                        . '<script>'
                        . '</script>';
                break;
            case self::TIPO_FILTRO:
                $sBotao = '<button title="Habilita pesquisa" type="button" class="btn btn-icon btn-default btn-outline" id="' . $this->getId() . '" >'
                        . '<span><i class="icon wb-search" aria-hidden="true"></i></span>'
                        . '</div>';
                break;
            case self::TIPO_CONFIRMAR:
                $sBotao = '<div>'
                        . '<div class="btn-acao-grid" style="margin:10px 0px 30px 0px;float: right">'
                        . '<div class="btn-group" aria-label="Default button group" role="group">'
                        . '<button type="button" class="btn btn-outline btn-success" id="' . $this->getId() . '" ' . $this->setDesativado($this->getBDesativado()) . '>'
                        . '<span><i class="icon wb-check" title="Inserir" aria-hidden="true"></i>' . $this->sTexto . '</span>'
                        . '</button>'
                        . ' </div>'
                        . ' </div>'
                        . '</div>';

                break;
            case self::TIPO_FECHAR:
                $sBotao = '<div>'
                        . '<div class="btn-acao-grid" style="margin:10px 0px 30px 0px;float:right">'
                        . '<div class="btn-group" aria-label="Default button group" role="group">'
                        . '<button type="button" class="btn btn-outline btn-danger" id="' . $this->getId() . '" ' . $this->setDesativado($this->getBDesativado()) . '>'
                        . '<span><i class="icon wb-close" aria-hidden="true"></i>' . $this->sTexto . '</span>'
                        . '</button>'
                        . ' </div>'
                        . ' </div>'
                        . '</div>';

                break;
            case self::TIPO_LIMPAR:
                $sBotao = '<div>'
                        . '<div class="btn-acao-grid" style="margin:10px 0px 30px 0px;float: right">'
                        . '<div class="btn-group" aria-label="Default button group" role="group">'
                        . '<button type="button" class="btn btn-outline btn-default" id="' . $this->getId() . '" ' . $this->setDesativado($this->getBDesativado()) . '>'
                        . '<span><i class="icon wb-reply" aria-hidden="true"></i>' . $this->sTexto . '</span>'
                        . '</button>'
                        . ' </div>'
                        . ' </div>'
                        . '</div>';

                break;
            case self::TIPO_PROXIMO:
                $sBotao = '<div>'
                        . '<div class="btn-acao-grid" style="margin:10px 0px 30px 0px;float: right">'
                        . '<div class="btn-group" aria-label="Default button group" role="group">'
                        . '<button type="button" class="btn btn-outline btn-primary" id="' . $this->getId() . '" ' . $this->setDesativado($this->getBDesativado()) . '>'
                        . '<span>' . $this->sTexto . '<i class="icon wb-chevron-right" aria-hidden="true"></i></span>'
                        . '</button>'
                        . ' </div>'
                        . ' </div>'
                        . '</div>';

                break;
            case self::TIPO_VOLTAR:
                $sBotao = '<div>'
                        . '<div class="btn-acao-grid" style="margin:10px 0px 30px 0px;float: right">'
                        . '<div class="btn-group" aria-label="Default button group" role="group">'
                        . '<button type="button" class="btn btn-outline btn-warning" id="' . $this->getId() . '" ' . $this->setDesativado($this->getBDesativado()) . '>'
                        . '<span><i class="icon wb-chevron-left" aria-hidden="true"></i>' . $this->sTexto . '</span>'
                        . '</button>'
                        . ' </div>'
                        . ' </div>'
                        . '</div>';

                break;
            case self::TIPO_CONCLUIRDET:
                $sBotao = '<div>'
                        . '<div class="btn-acao-grid" style="margin:10px 0px 30px 0px;float: right">'
                        . '<div class="btn-group" aria-label="Default button group" role="group">'
                        . '<button type="button" class="btn btn-outline btn-primary" id="' . $this->getId() . '" ' . $this->setDesativado($this->getBDesativado()) . '>'
                        . '<span>' . $this->sTexto . '</span>'
                        . '</button>'
                        . ' </div>'
                        . ' </div>'
                        . '</div>';

                break;
            case self::TIPO_SMALL_SUB:
                $sBotao = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '  btn-acao-grid" style="margin-top:' . $this->getIMarginTop() . 'px;">'
                        . '<button type="button" class="btn ' . $this->getSStyleBotao() . ' btn-sm btn-form btn-outline " id="' . $this->getId() . '" data-target="#' . $this->getSNomeModal() . '" data-toggle="modal"' . $this->setDesativado($this->getBDesativado()) . '>'
                        . '<span><i class="icon wb-check" aria-hidden="true"></i>' . $this->sTexto . '</span>'
                        . '</button>'
                        . '</div>'
                        . '<script>'
                        . '' . $this->getAAcao() . ''
                        . '</script>';
                break;
            case self::TIPO_PESQUISAR:
                $sBotao = '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="margin-top: 22px; margin-rigth:0px;left:-8px;z-index:2" >'
                        . '<button title="Pesquisar" type="button" class="btn btn-icon btn-success" id="' . $this->getId() . '" ' . $this->setDesativado($this->getBDesativado()) . '>'
                        . '<i class="icon wb-search" aria-hidden="true"></i></button>'
                        . '</div>'
                        . '<script>'
                        . '' . $this->getAAcao() . ''
                        . '</script>';
                break;
            case self::TIPO_ATUALIZAR:
                $sBotao = '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-6 btn-acao-grid pesq-refresh" >'
                        . '<button title="Atualizar" type="button" class="btn  btn-dark btn-sm margin-btn" id="' . $this->getId() . '" >'
                        . '<span><i class="icon wb-reload" aria-hidden="true"></i> </span>'
                        . '</div>';
                break;
            case self::TIPO_SMALL:
                $sBotao = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '  btn-acao-grid" style="margin-top:' . $this->getIMarginTop() . 'px;">'
                        . '<a href="javascript:void(0)" class="btn ' . $this->getSStyleBotao() . ' btn-sm btn-form ladda-button" id="' . $this->getId() . '" ' . $this->setDesativado($this->getBDesativado()) . ' data-target="#' . $this->getSNomeModal() . '" data-toggle="modal">'
                        . '<i class="icon wb-check" aria-hidden="true"></i>' . $this->sTexto . '</a>'
                        . '</input>'
                        . '</div>'
                        . '<script>'
                        . '' . $this->getAAcao() . ''
                        . '</script>';
                break;
            case self::TIPO_DELDETALHE:
                $sBotao = '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-6  btn-acao-grid" style="float: left">'
                        . '  <button type="button" class="btn btn-danger btn-xs btn-outline ladda-button" id="' . $this->getId() . '"  >'
                        . '  <span><i class="" aria-hidden="true"></i>Deletar</span>'
                        . '  </button>'
                        . '</div>'
                        . '<script>'
                        . '' . $this->getAAcao() . ''
                        . '</script>';
                break;
            case self::TIPO_ALTERARDET:
                $sBotao = '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-6  btn-acao-grid" style="float: left">'
                        . '  <button type="button" class="btn btn-success btn-xs btn-outline ladda-button" id="' . $this->getId() . '"  >'
                        . '  <span><i class="" aria-hidden="true"></i>Alterar</span>'
                        . '  </button>'
                        . '</div>'
                        . '<script>'
                        . '' . $this->getAAcao() . ''
                        . '</script>';
                break;
            case self::TIPO_REL:
                $sBotao = '<div style="margin-top:35px;" class="col-lg-1 col-md-1 col-sm-1 col-xs-2 btn-acao-grid">'
                        . '<button type="button" class="btn btn-primary btn-sm margin-btn" name ="' . $this->getId() . '"  id="' . $this->getId() . '" ' . $this->setDesativado($this->getBDesativado()) . '>'
                        . '<span><i class="icon wb-desktop" aria-hidden="true"></i>' . $this->sTexto . '</span>'
                        . '</button>'
                        . '</div>'
                        . '<script>'
                        . '</script>';
                break;
            case self::TIPO_DETALHE:
                $sBotao = '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-6  btn-acao-grid" style="float: left">'
                        . '  <button type="button" class="btn ' . $this->getSStyleBotao() . ' btn-xs ladda-button" id="' . $this->getId() . '"  >'
                        . '  <span><i class="" aria-hidden="true"></i>' . $this->sTexto . '</span>'
                        . '  </button>'
                        . '</div>'
                        . '<script>'
                        . '' . $this->getAAcao() . ''
                        . '</script>';
                break;
            case self::TIPO_REMOVER_TELAGRID:
                $sBotao = '<div style="margin-top:10px;"class="col-lg-1 col-md-1 col-sm-1 col-xs-2 btn-acao-grid">'
                        . '<button  title="Remover registro" class="btn ' . $this->getSStyleBotao() . ' btn-xs ladda-button" id="' . $this->getId() . '"  ' . $this->setDesativado($this->getBDesativado()) . ' >'
                        . '<span><i class="icon wb-trash" aria-hidden="true"></i>' . $this->sTexto . '</span>'
                        . '</button>'
                        . '</div>';
                break;
            case self::TIPO_BOTAOSIMPLES:
                $sBotao = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '  btn-acao-grid" style="margin-top:' . $this->getIMarginTop() . 'px;">'
                        . '<button type="button" class="btn ' . $this->getSStyleBotao() . ' btn btn-block btn-success " id="' . $this->getId() . '" data-target="#' . $this->getSNomeModal() . '" data-toggle="modal"' . $this->setDesativado($this->getBDesativado()) . '>'
                        . '<span><i class="icon wb-check" aria-hidden="true"></i>' . $this->sTexto . '</span>'
                        . '</button>'
                        . '</div>'
                        . '<script>'
                        . '' . $this->getAAcao() . ''
                        . '</script>';
                break;
        }
        return $sBotao;
    }

}

?>
 