<?php
/**
 * Classe responsável pelas operações de persistência do objeto
 * Estado
 * 
 * @author Fernando Salla
 * @since 28/11/2012 
 */
class PersistenciaEstado extends Persistencia{
    const ACRE             = 'AC';
    const ALAGOAS          = 'AL';
    const AMAPA            = 'AP';
    const AMAZONAS         = 'AM';
    const BAHIA            = 'BA';
    const CEARA            = 'CE';
    const DISTRITO_FEDERAL = 'DF';
    const ESPIRITO_SANTO   = 'ES';
    const GOIAS            = 'GO';
    const MARANHAO         = 'MA';
    const MATO_GROSSO      = 'MT';
    const MATO_GROSSO_SUL  = 'MS';
    const MINAS_GERAIS     = 'MG';
    const PARA             = 'PA';
    const PARAIBA          = 'PB';
    const PARANA           = 'PR';
    const PERNAMBUCO       = 'PE';
    const PIAUI            = 'PI';
    const RIO_JANEIRO      = 'RJ';
    const RIO_GRANDE_NORTE = 'RN';
    const RIO_GRANDE_SUL   = 'RS';
    const RONDONIA         = 'RO';
    const RORAIMA          = 'RR';
    const SANTA_CATARINA   = 'SC';
    const SAO_PAULO        = 'SP';
    const SERGIPE          = 'SE';
    const TOCANTINS        = 'TO';
    
    /**
     * Método que monta e retorna a listagem dos estados de maneira fixa
     * 
     * @return array Array contedo a listagem dos estados com o valor a ser 
     *               gravado no BD e os respectivos descritivos
     */
    public function getListaEstados(){
        $aListaEstado = new Lista();
        $aListaEstado->addItem(self::ACRE, 'Acre');
        $aListaEstado->addItem(self::ALAGOAS, 'Alagoas');
        $aListaEstado->addItem(self::AMAPA,'Amapá');
        $aListaEstado->addItem(self::AMAZONAS,'Amazonas');
        $aListaEstado->addItem(self::BAHIA,'Bahia');
        $aListaEstado->addItem(self::CEARA,'Ceará');
        $aListaEstado->addItem(self::DISTRITO_FEDERAL,'Distrito Federal');
        $aListaEstado->addItem(self::ESPIRITO_SANTO,'Espírito Santo');
        $aListaEstado->addItem(self::GOIAS,'Goiás');
        $aListaEstado->addItem(self::MARANHAO,'Maranhão');
        $aListaEstado->addItem(self::MATO_GROSSO,'Mato Grosso');
        $aListaEstado->addItem(self::MATO_GROSSO_SUL,'Mato Grosso do Sul');
        $aListaEstado->addItem(self::MINAS_GERAIS,'Minas Gerais');
        $aListaEstado->addItem(self::PARA,'Pará');
        $aListaEstado->addItem(self::PARAIBA,'Paraíba');
        $aListaEstado->addItem(self::PARANA,'Paraná');
        $aListaEstado->addItem(self::PERNAMBUCO,'Pernambuco');
        $aListaEstado->addItem(self::PIAUI,'Piauí');
        $aListaEstado->addItem(self::RIO_JANEIRO,'Rio de Janeiro');
        $aListaEstado->addItem(self::RIO_GRANDE_NORTE,'Rio Grande do Norte');
        $aListaEstado->addItem(self::RIO_GRANDE_SUL,'Rio Grande do Sul');
        $aListaEstado->addItem(self::RONDONIA,'Rondônia');
        $aListaEstado->addItem(self::RORAIMA,'Roraima');
        $aListaEstado->addItem(self::SANTA_CATARINA,'Santa Catarina');
        $aListaEstado->addItem(self::SAO_PAULO,'São Paulo');
        $aListaEstado->addItem(self::SERGIPE,'Sergipe');
        $aListaEstado->addItem(self::TOCANTINS,'Tocantins');
        
        return $aListaEstado->getArrayItem();
    }
}
?>