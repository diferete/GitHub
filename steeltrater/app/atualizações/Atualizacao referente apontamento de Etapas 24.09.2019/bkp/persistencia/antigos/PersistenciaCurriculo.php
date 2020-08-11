<?php

class PersistenciaCurriculo extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nome', 'nome');
        $this->adicionaRelacionamento('nacional', 'nacional');
        $this->adicionaRelacionamento('natural', 'natural');
        $this->adicionaRelacionamento('nasc', 'nasc');
        $this->adicionaRelacionamento('sexo', 'sexo');
        $this->adicionaRelacionamento('altura', 'altura');
        $this->adicionaRelacionamento('peso', 'peso');
        $this->adicionaRelacionamento('estciv', 'estciv');
        $this->adicionaRelacionamento('conjuge', 'conjuge');
        $this->adicionaRelacionamento('nascconj', 'nascconj');
        $this->adicionaRelacionamento('nfilhos', 'nfilhos');
        $this->adicionaRelacionamento('menor', 'menor');
        $this->adicionaRelacionamento('contato', 'contato');
        $this->adicionaRelacionamento('rua', 'rua');
        $this->adicionaRelacionamento('numero', 'numero');
        $this->adicionaRelacionamento('bairro', 'bairro');
        $this->adicionaRelacionamento('cidade', 'cidade');
        $this->adicionaRelacionamento('estado', 'estado');
        $this->adicionaRelacionamento('moratempo', 'moratempo');
        $this->adicionaRelacionamento('nomepai', 'nomepai');
        $this->adicionaRelacionamento('nomemae', 'nomemae');
        $this->adicionaRelacionamento('facebook', 'facebook');
        $this->adicionaRelacionamento('nrident', 'nrdident');
        $this->adicionaRelacionamento('cpf', 'cpf');
        $this->adicionaRelacionamento('titeleit', 'titeleit');
        $this->adicionaRelacionamento('nrctps', 'nrctps');
        $this->adicionaRelacionamento('nrseriectps', 'nrseriectps');
        $this->adicionaRelacionamento('nrpis', 'nrpis');
        $this->adicionaRelacionamento('escolaridade', 'escolaridade');
        $this->adicionaRelacionamento('serie', 'serie');
        $this->adicionaRelacionamento('grau', 'grau');
        $this->adicionaRelacionamento('cursosup', 'cursosup');
        $this->adicionaRelacionamento('tipocursosup', 'tipocursosup');
        $this->adicionaRelacionamento('cursoprof', 'cursoprof');
        $this->adicionaRelacionamento('tipocursoprof', 'tipocursoprof');
        $this->adicionaRelacionamento('empresa1', 'empresa1');
        $this->adicionaRelacionamento('cargoemp1', 'cargoemp1');
        $this->adicionaRelacionamento('foneemp1', 'foneemp1');
        $this->adicionaRelacionamento('cidadeemp1', 'cidadeemp1');
        $this->adicionaRelacionamento('estadoemp1', 'estadoemp1');
        $this->adicionaRelacionamento('inicioemp1', 'inicioemp1');
        $this->adicionaRelacionamento('fimemp1', 'fimemp1');
        $this->adicionaRelacionamento('empresa2', 'empresa2');
        $this->adicionaRelacionamento('cargoemp2', 'cargoemp2');
        $this->adicionaRelacionamento('foneemp2', 'foneemp2');
        $this->adicionaRelacionamento('cidadeemp2', 'cidadeemp2');
        $this->adicionaRelacionamento('estadoemp2', 'estadoemp2');
        $this->adicionaRelacionamento('inicioemp2', 'inicioemp2');
        $this->adicionaRelacionamento('fimemp2', 'fimemp2');
        $this->adicionaRelacionamento('empresa3', 'empresa3');
        $this->adicionaRelacionamento('cargoemp3', 'cargoemp3');
        $this->adicionaRelacionamento('foneemp3', 'foneemp3');
        $this->adicionaRelacionamento('cidadeemp3', 'cidadeemp3');
        $this->adicionaRelacionamento('estadoemp3', 'estadoemp3');
        $this->adicionaRelacionamento('inicioemp3', 'inicioemp3');
        $this->adicionaRelacionamento('fimemp3', 'fimemp');
        $this->adicionaRelacionamento('refer', 'refer');
        $this->adicionaRelacionamento('email', 'email');
    }

}
