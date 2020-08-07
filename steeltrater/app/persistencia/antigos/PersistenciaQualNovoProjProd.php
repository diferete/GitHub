<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaQualNovoProjProd extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbqualNovoProjeto');
        
        $this->adicionaRelacionamento('filcgc', 'EmpRex.filcgc',true,true);
        $this->adicionaRelacionamento('nr', 'nr',true,true,true);
        $this->adicionaRelacionamento('dtimp','dtimp');
        $this->adicionaRelacionamento('resp_proj_nome', 'resp_proj_nome');
        $this->adicionaRelacionamento('resp_venda_nome','resp_venda_nome');
        $this->adicionaRelacionamento('desc_novo_prod', 'desc_novo_prod');
        $this->adicionaRelacionamento('obsaprovcli','obsaprovcli');
        $this->adicionaRelacionamento('sitgeralproj','sitgeralproj');
        
        $this->adicionaRelacionamento('procod','procod');
        $this->adicionaRelacionamento('prodsimilar', 'prodsimilar');
        $this->adicionaRelacionamento('procodsimilar', 'procodsimilar');
        
        $this->adicionaRelacionamento('chavemin', 'chavemin');
        $this->adicionaRelacionamento('chavemax', 'chavemax');
        $this->adicionaRelacionamento('altmin', 'altmin');
        $this->adicionaRelacionamento('altmax', 'altmax');
        $this->adicionaRelacionamento('diamfmin', 'diamfmin');
        $this->adicionaRelacionamento('diamfmax', 'diamfmax');
        $this->adicionaRelacionamento('compmin', 'compmin');
        $this->adicionaRelacionamento('compmax', 'compmax');
        
        $this->adicionaRelacionamento('diampmin', 'diampmin');
        $this->adicionaRelacionamento('diampmax', 'diampmax');
        
        $this->adicionaRelacionamento('diamexmin', 'diamexmin');
        $this->adicionaRelacionamento('diamexmax', 'diamexmax');
        
        $this->adicionaRelacionamento('comprmin', 'comprmin');
        $this->adicionaRelacionamento('comprmax', 'comprmax');
        
        $this->adicionaRelacionamento('comphmin', 'comphmin');
        $this->adicionaRelacionamento('comphmax', 'comphmax');
        
        $this->adicionaRelacionamento('diamhmin', 'diamhmin');
        $this->adicionaRelacionamento('diamhmax', 'diamhmax');
        
        $this->adicionaRelacionamento('anghelice', 'anghelice');
        
        $this->adicionaRelacionamento('acab','acab');
        $this->adicionaRelacionamento('material', 'material');
        $this->adicionaRelacionamento('classe', 'classe');
        
        $this->adicionaRelacionamento('tiprosca', 'tiprosca');
        $this->adicionaRelacionamento('normadimen','normadimen');
        $this->adicionaRelacionamento('normarosca', 'normarosca');
        $this->adicionaRelacionamento('normapropmec', 'normapropmec');
        
        $this->adicionaRelacionamento('ppap', 'ppap');
        $this->adicionaRelacionamento('vendaprev', 'vendaprev');
        $this->adicionaRelacionamento('reqcli','reqcli');
        $this->adicionaRelacionamento('codresproj', 'codresproj');
        $this->adicionaRelacionamento('respproj', 'respproj');
        $this->adicionaRelacionamento('dataprod', 'dataprod');
        
        $this->adicionaRelacionamento('dadosent', 'dadosent');
        $this->adicionaRelacionamento('dadosent_obs', 'dadosent_obs');
        $this->adicionaRelacionamento('reqlegal', 'reqlegal');
        $this->adicionaRelacionamento('reqlegal_obs', 'reqlegal_obs');
        
        $this->adicionaRelacionamento('reqadicional', 'reqadicional');
        $this->adicionaRelacionamento('reqadicional_obs','reqadicional_obs');
        $this->adicionaRelacionamento('reqadverif','reqadverif');
        $this->adicionaRelacionamento('reqadverif_obs','reqadverif_obs');
        
        $this->adicionaRelacionamento('reqadval','reqadval');
        $this->adicionaRelacionamento('reqadval_obs', 'reqadval_obs');
        
        $this->adicionaRelacionamento('reqproblem', 'reqproblem');
        $this->adicionaRelacionamento('reqproblem_obs', 'reqproblem_obs');
        
        $this->adicionaRelacionamento('comem', 'comem');
        
       
        
  
     
     
        $this->adicionaJoin('EmpRex');
        $this->adicionaOrderBy('nr',1);
        $this->setSTop('50');
        
        //$this->adicionaFiltro('sitgeralproj', 'Lib.Cadastro');
    }
    
    /**
     * Finaliza pedido
     */
     public function finaProjeto($aDados){
        date_default_timezone_set('America/Sao_Paulo');
        $sHora =date('H:i');
        $sData = date('d/m/Y');
        $sSql = "update tbqualNovoProjeto set sitgeralproj = 'Finalizado',
                 dtafimProj = '".$sData."',
                horafimProj = '".$sHora."',
                userfimProj = '".$_SESSION['nome']."'
                 where filcgc = '".$aDados['EmpRex_filcgc']."' and nr = '".$aDados['nr']."'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
        
    /*    [dtafimProj] [date] NULL,
	[horafimProj] [time](7) NULL,
	[userfimProj] [varchar](80) NULL,*/
    }
}