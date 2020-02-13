<?php

class ModelCurriculo {

    private $nr;
    private $filcgc;
    private $nome;
    private $nacional;
    private $natural;
    private $nasc;
    private $sexo;
    private $altura;
    private $peso;
    private $estciv;
    private $conjuge;
    private $nascconj;
    private $nfilhos;
    private $menor;
    private $contato;
    private $rua;
    private $numero;
    private $bairro;
    private $cidade;
    private $estado;
    private $moratempo;
    private $nomepai;
    private $nomemae;
    private $facebook;
    private $nrident;
    private $cpf;
    private $titeleit;
    private $nrctps;
    private $nrseriectps;
    private $nrpis;
    private $escolaridade;
    private $serie;
    private $grau;
    private $cursosup;
    private $tipocursosup;
    private $cursoprof;
    private $tipocursoprof;
    private $empresa1;
    private $cargoemp1;
    private $foneemp1;
    private $cidadeemp1;
    private $estadoemp1;
    private $inicioemp1;
    private $fimemp1;
    private $empresa2;
    private $cargoemp2;
    private $foneemp2;
    private $cidadeemp2;
    private $estadoemp2;
    private $inicioemp2;
    private $fimemp2;
    private $empresa3;
    private $cargoemp3;
    private $foneemp3;
    private $cidadeemp3;
    private $estadoemp3;
    private $inicioemp3;
    private $fimemp3;
    private $refer;
    private $email;

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getNr() {
        return $this->nr;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getNome() {
        return $this->nome;
    }

    function getNacional() {
        return $this->nacional;
    }

    function getNatural() {
        return $this->natural;
    }

    function getNasc() {
        return $this->nasc;
    }

    function getSexo() {
        return $this->sexo;
    }

    function getAltura() {
        return $this->altura;
    }

    function getPeso() {
        return $this->peso;
    }

    function getEstciv() {
        return $this->estciv;
    }

    function getConjuge() {
        return $this->conjuge;
    }

    function getNascconj() {
        return $this->nascconj;
    }

    function getNfilhos() {
        return $this->nfilhos;
    }

    function getMenor() {
        return $this->menor;
    }

    function getContato() {
        return $this->contato;
    }

    function getRua() {
        return $this->rua;
    }

    function getNumero() {
        return $this->numero;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getEstado() {
        return $this->estado;
    }

    function getMoratempo() {
        return $this->moratempo;
    }

    function getNomepai() {
        return $this->nomepai;
    }

    function getNomemae() {
        return $this->nomemae;
    }

    function getFacebook() {
        return $this->facebook;
    }

    function getNrident() {
        return $this->nrident;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getTiteleit() {
        return $this->titeleit;
    }

    function getNrctps() {
        return $this->nrctps;
    }

    function getNrseriectps() {
        return $this->nrseriectps;
    }

    function getNrpis() {
        return $this->nrpis;
    }

    function getEscolaridade() {
        return $this->escolaridade;
    }

    function getSerie() {
        return $this->serie;
    }

    function getGrau() {
        return $this->grau;
    }

    function getCursosup() {
        return $this->cursosup;
    }

    function getTipocursosup() {
        return $this->tipocursosup;
    }

    function getCursoprof() {
        return $this->cursoprof;
    }

    function getTipocursoprof() {
        return $this->tipocursoprof;
    }

    function getEmpresa1() {
        return $this->empresa1;
    }

    function getCargoemp1() {
        return $this->cargoemp1;
    }

    function getFoneemp1() {
        return $this->foneemp1;
    }

    function getCidadeemp1() {
        return $this->cidadeemp1;
    }

    function getEstadoemp1() {
        return $this->estadoemp1;
    }

    function getInicioemp1() {
        return $this->inicioemp1;
    }

    function getFimemp1() {
        return $this->fimemp1;
    }

    function getEmpresa2() {
        return $this->empresa2;
    }

    function getCargoemp2() {
        return $this->cargoemp2;
    }

    function getFoneemp2() {
        return $this->foneemp2;
    }

    function getCidadeemp2() {
        return $this->cidadeemp2;
    }

    function getEstadoemp2() {
        return $this->estadoemp2;
    }

    function getInicioemp2() {
        return $this->inicioemp2;
    }

    function getFimemp2() {
        return $this->fimemp2;
    }

    function getEmpresa3() {
        return $this->empresa3;
    }

    function getCargoemp3() {
        return $this->cargoemp3;
    }

    function getFoneemp3() {
        return $this->foneemp3;
    }

    function getCidadeemp3() {
        return $this->cidadeemp3;
    }

    function getEstadoemp3() {
        return $this->estadoemp3;
    }

    function getInicioemp3() {
        return $this->inicioemp3;
    }

    function getFimemp3() {
        return $this->fimemp3;
    }

    function getRefer() {
        return $this->refer;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setNacional($nacional) {
        $this->nacional = $nacional;
    }

    function setNatural($natural) {
        $this->natural = $natural;
    }

    function setNasc($nasc) {
        $this->nasc = $nasc;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    function setAltura($altura) {
        $this->altura = $altura;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }

    function setEstciv($estciv) {
        $this->estciv = $estciv;
    }

    function setConjuge($conjuge) {
        $this->conjuge = $conjuge;
    }

    function setNascconj($nascconj) {
        $this->nascconj = $nascconj;
    }

    function setNfilhos($nfilhos) {
        $this->nfilhos = $nfilhos;
    }

    function setMenor($menor) {
        $this->menor = $menor;
    }

    function setContato($contato) {
        $this->contato = $contato;
    }

    function setRua($rua) {
        $this->rua = $rua;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setMoratempo($moratempo) {
        $this->moratempo = $moratempo;
    }

    function setNomepai($nomepai) {
        $this->nomepai = $nomepai;
    }

    function setNomemae($nomemae) {
        $this->nomemae = $nomemae;
    }

    function setFacebook($facebook) {
        $this->facebook = $facebook;
    }

    function setNrident($nrident) {
        $this->nrident = $nrident;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setTiteleit($titeleit) {
        $this->titeleit = $titeleit;
    }

    function setNrctps($nrctps) {
        $this->nrctps = $nrctps;
    }

    function setNrseriectps($nrseriectps) {
        $this->nrseriectps = $nrseriectps;
    }

    function setNrpis($nrpis) {
        $this->nrpis = $nrpis;
    }

    function setEscolaridade($escolaridade) {
        $this->escolaridade = $escolaridade;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }

    function setGrau($grau) {
        $this->grau = $grau;
    }

    function setCursosup($cursosup) {
        $this->cursosup = $cursosup;
    }

    function setTipocursosup($tipocursosup) {
        $this->tipocursosup = $tipocursosup;
    }

    function setCursoprof($cursoprof) {
        $this->cursoprof = $cursoprof;
    }

    function setTipocursoprof($tipocursoprof) {
        $this->tipocursoprof = $tipocursoprof;
    }

    function setEmpresa1($empresa1) {
        $this->empresa1 = $empresa1;
    }

    function setCargoemp1($cargoemp1) {
        $this->cargoemp1 = $cargoemp1;
    }

    function setFoneemp1($foneemp1) {
        $this->foneemp1 = $foneemp1;
    }

    function setCidadeemp1($cidadeemp1) {
        $this->cidadeemp1 = $cidadeemp1;
    }

    function setEstadoemp1($estadoemp1) {
        $this->estadoemp1 = $estadoemp1;
    }

    function setInicioemp1($inicioemp1) {
        $this->inicioemp1 = $inicioemp1;
    }

    function setFimemp1($fimemp1) {
        $this->fimemp1 = $fimemp1;
    }

    function setEmpresa2($empresa2) {
        $this->empresa2 = $empresa2;
    }

    function setCargoemp2($cargoemp2) {
        $this->cargoemp2 = $cargoemp2;
    }

    function setFoneemp2($foneemp2) {
        $this->foneemp2 = $foneemp2;
    }

    function setCidadeemp2($cidadeemp2) {
        $this->cidadeemp2 = $cidadeemp2;
    }

    function setEstadoemp2($estadoemp2) {
        $this->estadoemp2 = $estadoemp2;
    }

    function setInicioemp2($inicioemp2) {
        $this->inicioemp2 = $inicioemp2;
    }

    function setFimemp2($fimemp2) {
        $this->fimemp2 = $fimemp2;
    }

    function setEmpresa3($empresa3) {
        $this->empresa3 = $empresa3;
    }

    function setCargoemp3($cargoemp3) {
        $this->cargoemp3 = $cargoemp3;
    }

    function setFoneemp3($foneemp3) {
        $this->foneemp3 = $foneemp3;
    }

    function setCidadeemp3($cidadeemp3) {
        $this->cidadeemp3 = $cidadeemp3;
    }

    function setEstadoemp3($estadoemp3) {
        $this->estadoemp3 = $estadoemp3;
    }

    function setInicioemp3($inicioemp3) {
        $this->inicioemp3 = $inicioemp3;
    }

    function setFimemp3($fimemp3) {
        $this->fimemp3 = $fimemp3;
    }

    function setRefer($refer) {
        $this->refer = $refer;
    }

}
