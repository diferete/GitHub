<?php

/*
 * Classe que implementa mostrar os dados do cadastro
 * 
 * @author Avanei Martendal
 * @since 15/12/2020
 */

class showDados {

   public function showCadastro(){
        
        $nome_completo = "Bart Simpson"; 
        $idade_ano = 12;
        $telefone_cel = "47-35286978"; 
        $cpf = "04477583908";
        $rg = "4118783";
        $endereco = "Rua...";
        $sexo = "M";   
        
        $aRetorno = array();
        
        $aRetorno['nome'] = $nome_completo;
        $aRetorno['idade'] = $idade_ano;
        $aRetorno['telefone'] = $telefone_cel;
        $aRetorno['cpf'] = $cpf;
        $aRetorno['rg'] = $rg;
        $aRetorno['endereco'] = $endereco;
        $aRetorno['sexo'] = $sexo;
        
        return $aRetorno; 
    }
    
}
