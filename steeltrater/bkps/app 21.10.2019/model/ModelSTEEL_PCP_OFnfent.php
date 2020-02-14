<?php

/* 
 * Monta o models da classe de emissão de ofs steel
 * 
 * @author Avanei Martendal
 * 
 * @since 22/06/2018 
   
 */

class ModelSTEEL_PCP_OFnfent {
    
       private  $nfs_notafiscalfilial;
       private  $nfs_notafiscalseq;
       private  $nfs_notafiscalnumero;
       private  $nfs_notafiscalserie;
       private  $nfs_notafiscaldatachegada;
       private  $nfs_notafiscalnfechave;
       private  $nfs_notafiscalpessoanome;
       
       function getNfs_notafiscalfilial() {
           return $this->nfs_notafiscalfilial;
       }

       function getNfs_notafiscalseq() {
           return $this->nfs_notafiscalseq;
       }

       function getNfs_notafiscalnumero() {
           return $this->nfs_notafiscalnumero;
       }

       function getNfs_notafiscalserie() {
           return $this->nfs_notafiscalserie;
       }

       function getNfs_notafiscaldatachegada() {
           return $this->nfs_notafiscaldatachegada;
       }

       function getNfs_notafiscalnfechave() {
           return $this->nfs_notafiscalnfechave;
       }

       function getNfs_notafiscalpessoanome() {
           return $this->nfs_notafiscalpessoanome;
       }

       function setNfs_notafiscalfilial($nfs_notafiscalfilial) {
           $this->nfs_notafiscalfilial = $nfs_notafiscalfilial;
       }

       function setNfs_notafiscalseq($nfs_notafiscalseq) {
           $this->nfs_notafiscalseq = $nfs_notafiscalseq;
       }

       function setNfs_notafiscalnumero($nfs_notafiscalnumero) {
           $this->nfs_notafiscalnumero = $nfs_notafiscalnumero;
       }

       function setNfs_notafiscalserie($nfs_notafiscalserie) {
           $this->nfs_notafiscalserie = $nfs_notafiscalserie;
       }

       function setNfs_notafiscaldatachegada($nfs_notafiscaldatachegada) {
           $this->nfs_notafiscaldatachegada = $nfs_notafiscaldatachegada;
       }

       function setNfs_notafiscalnfechave($nfs_notafiscalnfechave) {
           $this->nfs_notafiscalnfechave = $nfs_notafiscalnfechave;
       }

       function setNfs_notafiscalpessoanome($nfs_notafiscalpessoanome) {
           $this->nfs_notafiscalpessoanome = $nfs_notafiscalpessoanome;
       }

              
               
    /*  $this->adicionaRelacionamento('nfs_notafiscalfilial', 'nfs_notafiscalfilial', true, true);
        $this->adicionaRelacionamento('nfs_notafiscalseq', 'nfs_notafiscalseq', true, true);
        $this->adicionaRelacionamento('nfs_notafiscalnumero', 'nfs_notafiscalnumero');
        $this->adicionaRelacionamento('nfs_notafiscalserie', 'nfs_notafiscalserie');
        $this->adicionaRelacionamento('nfs_notafiscaldatachegada', 'nfs_notafiscaldatachegada');
        $this->adicionaRelacionamento('nfs_notafiscalnfechave', 'nfs_notafiscalnfechave');
        $this->adicionaRelacionamento('nfs_notafiscalpessoanome', 'nfs_notafiscalpessoanome');*/
}
