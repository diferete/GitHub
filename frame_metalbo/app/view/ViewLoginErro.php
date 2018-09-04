<?php

/* 
 * Classe que implementa o controle de usuários que logam no sistema com erro de senha
 * @author Avanei Martendal
 * @date 25/08/2017
 */

class ViewLoginErro extends View{
    
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        
        $oCodigo = new CampoConsulta('Código','codigo');
        $oData = new CampoConsulta('Data','data', CampoConsulta::TIPO_DATA);
        $oHora = new CampoConsulta('Hora','hora');
        $oIp = new CampoConsulta('ip','ip');
        $oNome = new CampoConsulta('Nome','nome');
        $oSenha = new CampoConsulta('Senha','senha');
        
        $this->addCampos($oCodigo,$oData,$oHora,$oIp,$oNome,$oSenha);
        
        $this->setBScrollInf(FALSE);
        $this->getTela()->setBUsaCarrGrid(true);
    }
    
    
}

