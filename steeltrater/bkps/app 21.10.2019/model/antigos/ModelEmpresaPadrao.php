<?php
/**
 * Classe que implementa o Model Empresa Padrão
 * Utilizado para todos os models que utilizam a coluna empresa
 * o sistema já irá carregar o valor com a session
 */
class ModelEmpresaPadrao {
    
    public function setCodigoEmpresa() {
        
    }

    public function getCodigoEmpresa() {
        return $_SESSION["empresa"];
    }
}
?>