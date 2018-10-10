<?php
/**
 * Classe que implementa o objeto referente aos campos do BD
 * 
 * @author Fernando Salla
 * @since 25/06/2012 
 */
class CampoBanco{
    private $bPersiste;
    private $bAutoIncremento;
    private $sNomeBanco;
    private $sNomeModel;
    private $bChave;
    private $iTipoCampo;
    private $aLista;
    
    const TIPO_NORMAL = 1;
    const TIPO_SENHA = 2;
    const TIPO_ARQUIVO = 3;
    const TIPO_FORALISTA = 4;

    /**
     * Construtor da classe CampoBanco
     * 
     * Criar objetos do tipo campo
     * 
     * @param string $sNomeBD Nome do campo no banco de dados
     * @param string $sNomeModel Nome do campo no objeto Model
     * @param boolean $bChave Indica se o campo é chave na tabela
     * @param boolean $bPersiste Indica se o campo deve ser persistido
     * @param boolean $bAutoIncremento Indica se o campo é auto-incremento
     * @param boolean $iTipoCampo Indica o tipo do campo
     */
    function __construct($sNomeBD, $sNomeModel, $bChave = false, $bPersiste = true, $bAutoIncremento = false, $iTipoCampo = 1){
        $this->setNomeBanco($sNomeBD);
        $this->setNomeModel($sNomeModel);
        $this->setChave($bChave);
        $this->setPersiste($bPersiste);
        $this->setAutoIncremento($bAutoIncremento);
        $this->setTipoCampo($iTipoCampo);
        
        $this->aLista = array();
    }
    
    /**
     * Retorna o conteúdo do atributo bPersiste
     * 
     * @return boolean
     */ 
    function getPersiste(){
        return $this->bPersiste;
    }

    /**
     * Define o valor do atributo bPersiste
     * 
     * @param boolean $bPersiste Define se o campo será persistido ou não
     */    
    function setPersiste($bPersiste){
        $this->bPersiste = $bPersiste;
    }
    
    /**
     * Retorna o conteúdo do atributo bAutoIncremento
     * 
     * @return boolean
     */
    function getAutoIncremento(){
        return $this->bAutoIncremento;
    }

    /**
     * Define o valor do atributo bAutoIncremento
     * 
     * @param boolen $bAutoIncremento Define se o campo é autoincremento ou não
     */    
    function setAutoIncremento($bAutoIncremento){
        $this->bAutoIncremento = $bAutoIncremento;
    }

    /**
     * Retorna o conteúdo do atributo sNomeBanco
     * 
     * @return string
     */    
    function getNomeBanco(){
        return $this->sNomeBanco;
    }

    /**
     * Define o valor do atributo sNomeBanco
     * 
     * @param string $sNomeBanco Define o nome do campo no banco de dados
     */     
    function setNomeBanco($sNomeBanco){
        $this->sNomeBanco = $sNomeBanco;
        $this->sNomeBanco = mb_strtolower($sNomeBanco,'UTF-8');
    }

    /**
     * Retorna o conteúdo do atributo sNomeModel
     * 
     * @return string
     */      
    function getNomeModel(){
        return $this->sNomeModel;
    }

    /**
     * Define o valor do atributo sNomeModel
     * 
     * @param string $sNomeModel Define o nome do campo no objeto Model
     */     
    function setNomeModel($sNomeModel){
        $this->sNomeModel = $sNomeModel;
    }
        
    /**
     * Retorna o conteúdo do atributo bChave
     * 
     * @return boolean
     */    
    function getChave(){
        return $this->bChave;
    }

    /**
     * Define o valor do atributo bChave
     * 
     * @param boolean $bChave Define se o campo é chave na tabela ou não
     */    
    function setChave($bChave){
        $this->bChave = $bChave;
    }
    
    /**
     * Retorna o conteúdo do atributo iTipoCampo
     * 
     * @return integer
     */   
    public function getTipoCampo() {
        return $this->iTipoCampo;
    }
    
    /**
     * Define o valor do atributo iTipoCampo
     * 
     * @param integer $iTipoCampo Define o tipo do campo
     */    
    public function setTipoCampo($iTipoCampo) {
        $this->iTipoCampo = $iTipoCampo;
    }
    
    /**
     * Adiciona os valores que irão substituir os valores originais da coluna
     * geralmente utilizado quando o valor é numérico referente ao tipo e deseja-se
     * demonstrar a sua descrição
     * 
     * @param string $sValue Valor do item que será utilizado para transações na persistência
     * @param string $sDescricao Texto que será demonstrado para o usuário
     */ 
    public function addLista($sValue, $sDescricao) {
        $this->aLista[$sValue] = $sDescricao;
    }
    
    /**
     * Adiciona um array com os pares de chave (valor, conteúdo) que irão 
     * substituir os valores originais da coluna
     * Geralmente utilizado quando o valor é numérico referente ao tipo e 
     * deseja-se demonstrar a sua descrição
     * 
     * @param array $aArray Array contendo os pares de chave aceitos na lista
     */ 
    public function addListaArray($aArray) {
        $this->aLista = $aArray;
    }
    
    /**
     * Adiciona itens ao vetor de valores com base em uma consulta no banco de dados
     * 
     * @param string $sClasse Indica a classe que será instanciada para ter seu valor retornado
     * @param string $sAtributo Indica o atributo que será usado na descrição
     * @param string $sMetodo Indica o método que deve ser executado para gerar a listagem, caso não seja passado
     *                        valor para este parâmetro irá executar o método padrão definido no Controller
     */     
    public function addListaFrom($sClasse, $sAtributo, $sMetodo = null) {
        $aLista = Controller::getListaFrom($sClasse, $sAtributo, $sMetodo);
        
        foreach ($aLista as $aAtual) {
            $this->addLista($aAtual[0],$aAtual[1]);
        }
    }
    
    /**
     * Retorna a lista de valores usados para substituir o valor original
     * da coluna
     * 
     * @return string
     */   
    public function getLista($iPosicao = -1) {
        return $iPosicao === -1 ? $this->aLista : $this->aLista[$iPosicao];
    } 
}
?>