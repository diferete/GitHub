<?php
/**
 * Classe que implementa o controlador genérico do sistema
 * 
 * @author Fernando Salla
 * @since 15/05/2012 
 */
class Controller{
    const METODO_CRIA_TELA      = 'criaTela';
    const METODO_CRIA_CONSULTA  = 'criaConsulta';
    const METODO_ARRAY_DADOS    = 'getArrayModel';
    
    const NOME_METODO_CONSULTA_TELA  = 'metodoConsultaView';
    const NOME_METODO_CONSULTA_DADOS = 'metodoConsultaPersistencia';
    
    public $View;
    public $Model;
    public $Persistencia;
    
    public $aControllerDependente = array();
    public $ControllerDetalhe;
    public $sMetodoDetalhe;


    private $oJSON;
    private $bInsereMulti;
    
    private $parametros;
    private $codigoRotina;
    private $sMetodoCriaTela;
    private $sMetodoCriaConsulta;
    private $bProcessaDetalhe;
    private $sMsgErroBusca;
    private $bDesativaBotaoPadrao;
    private $paramaux;
    
    
    function getParamaux() {
        return $this->paramaux;
    }

    function setParamaux($paramaux) {
        $this->paramaux = $paramaux;
    }

        
    
   
    public function atualizaModel($oModel){
        $this->Model = $oModel;
        $this->Persistencia->setModel($oModel);
    }
        public function getCodigoRotina() {
        return $this->codigoRotina;
    }

    public function setCodigoRotina($codigoRotina) {
        if(isset($this->View)){
            $this->View->setCodigoRotina($codigoRotina);
        }
        $this->codigoRotina = $codigoRotina;
        return $this;
    }
    public function carregaClassesMvc($nomeClasse){
        $this->View = Fabrica::FabricarView($nomeClasse);
        
        $this->Model = Fabrica::FabricarModel($nomeClasse);
        $this->Persistencia = Fabrica::FabricarPersistencia($nomeClasse);
        $this->Persistencia->setModel($this->Model);
        $this->View->setController($nomeClasse);
    }
    
    public function getParametros() {
        return $this->parametros;
    }

    public function setParametros($parametros) {
        if(is_array($parametros)){
            $this->parametros = $parametros;
        }
        else {
            //Filtros extras
            $aParametros = explode(',',$parametros);
            $qtd = count($aParametros); 
            if($qtd>0){
               $parametros = $aParametros[0];
               $qtdCampos = ($qtd-1)/2;
               for($i=1;$i<=$qtdCampos;$i++){
                   $iInicial = $i;
                   $iFinal = $i+$qtdCampos;
                   $parametros .= "&".$aParametros[$iInicial]."=".$aParametros[$iFinal];
               }
            }
            //fim filtros extras
            
            $aRetorno = array();
            $aPametros = explode('&',$parametros);
            foreach ($aPametros as $sParametro){
                $aParts = explode('=',$sParametro);   
                $aParts[0] = str_replace(".", "_",$aParts[0]);
                $aRetorno[$aParts[0]]=$aParts[1];
            }
            $this->parametros = $aRetorno;
        }
    }
      
    /**
     * Retorna a mensagem de erro caso não encontre o registro nos campos de busca
     * (suggest)
     * 
     * @return string
     */
    public function getMsgErroBusca() {
        return $this->sMsgErroBusca == null ? 'Não existe registro para o código informado!' : $this->sMsgErroBusca;
    }

    /**
     * Define a mensagem de erro caso não encontre o registro nos campos de busca
     * (suggest)
     * 
     * @return string
     */
    public function setMsgErroBusca($sMsgErroBusca) {
        $this->sMsgErroBusca = $sMsgErroBusca;
        return $this;
    }

    /**
     * Indica o método da view que deverá ser chamado para a criação da tela
     * 
     * @return string
     */
    public function getMetodoCriaTela() {
        return isset($this->sMetodoCriaTela) ? $this->sMetodoCriaTela : self::METODO_CRIA_TELA;
    }

    /**
     * Define o método da view que deverá ser chamado para a criação da tela
     * 
     * @param string $sMetodoCriaTela
     */
    public function setMetodoCriaTela($sMetodoCriaTela) {
        $this->sMetodoCriaTela = $sMetodoCriaTela;
    }
    
    /**
     * Indica o método da view que deverá ser chamado para a criação da consulta
     * 
     * @return string
     */
    public function getMetodoCriaConsulta() {
        return isset($this->sMetodoCriaConsulta) ? $this->sMetodoCriaConsulta : self::METODO_CRIA_CONSULTA;
    }

    /**
     * Define o método da view que deverá ser chamado para a criação da consulta
     * 
     * @param string $sMetodoCriaConsulta
     */
    public function setMetodoCriaConsulta($sMetodoCriaConsulta) {
        $this->sMetodoCriaConsulta = $sMetodoCriaConsulta;
    }
    
    /**
     * Retorna o valor do atributo bProcessaDetalhe
     * @return boolean
     */
    public function getProcessaDetalhe() {
        return isset($this->bProcessaDetalhe) ? $this->bProcessaDetalhe : true;
    }

    /**
     * Indica o valor do atributo bProcessaDetalhe, caso negativo não irá
     * processar as rotinas de inclusão e alteração para os detalhamentos
     * Útil quando existe a necessidade de criar telas específicas para 
     * cadastrar/alterar partes de um registro
     * 
     * @param boolean $bProcessaDetalhe
     */
    public function setProcessaDetalhe($bProcessaDetalhe) {
        $this->bProcessaDetalhe = $bProcessaDetalhe;
    }
    

        /**
     * Método que adiciona os controladores que precisam existir para que
     * o controlador principal possa fazer inclusões/alterações
     * 
     * @param string $sClasse Nome da classe de dependência
     * @param string $sCampoModel Campo no model do controller principal, caso não seja informado assume o nome
     * indicado no parâmetro sClasse
     */
    public function addControllerDependente($sClasse,$sCampoModel = "") {
        $oController = Fabrica::FabricarController($sClasse);
        $sCampo = $sCampoModel === "" ? $sClasse : $sCampoModel;
        
        $this->aControllerDependente[] = array('controller' => $oController,
                                               'campoModelPrincipal' => $sCampo);
    }
    
    /**
     * Retorna o conteúdo do atributo aControllerDependente
     * 
     * @return array
     */    
    public function getControllerDependente() {
        return $this->aControllerDependente;
    }
    
    /**
     * Método que retorna o nome da classe atual
     */
    public function getNomeClasse(){
        return substr(get_class($this),10);
    }
    
    /**
     * Retorna o conteúdo do atributo bInsereMulti
     * 
     * @return boolean 
     */
    public function getInsereMulti() {
        return $this->bInsereMulti;
    }

    /**
     * Define o valor do atributo bInsereMulti
     * 
     * Serve de indicador para controlar se devem ser inseridos vários 
     * registros durante o mesmo processo
     * 
     * @param $bInsereMulti
     */
    public function setInsereMulti($bInsereMulti) {
        $this->bInsereMulti = $bInsereMulti;
    }
    
    /**
     * Preenche os campos do Model conforme valores
     * presentes no objeto $_REQUEST 
     */
    public function carregaModel($aCamposTela){
        foreach($this->Persistencia->getListaRelacionamento() as $oCampoBanco){
            if($oCampoBanco->getPersiste()){
                $this->setValorModel($this->Model,$oCampoBanco->getNomeModel(),null,$aCamposTela);
                
               }
        }
       
    }  

    /**
     * Preenche os campos do Model conforme valores
     * presentes no objeto $_REQUEST 
     */
    public function carregaModelCampos(){
        foreach($this->Persistencia->getListaRelacionamento() as $oCampoBanco){
            if($oCampoBanco->getPersiste()&&$oCampoBanco->getChave()){
                $oCampo = $this->View->getTela()->getCampoByName($oCampoBanco->getNomeModel());
                if(isset($oCampo)){
                    $this->setValorModel($this->Model,$oCampoBanco->getNomeModel(),$oCampo->getValor());
                }
            }
        }
    }  
      
    /**
     * Preenche o Model do controlador filtrando pelos
     * valores presentes no objeto $_REQUEST que possuirem o prefixo 
     * enviado por parâmetro
     * 
     * @param string $sCampoModel Prefixo (classe) para filtro nas chaves do array de valores
     */
    public function carregaCampoObjetoModel($sCampoModel){
        $iCamposValor = 0;
        
        //percorre o array de campos $_REQUEST filtrando apenas os que possuem o prefixo
        $aCampos = json_decode($_REQUEST['campos'],true);
        $aCamposModel = array();
        foreach ($aCampos as $key => $value) {
            if(strtolower($sCampoModel) === strtolower(substr($key,0,strlen($sCampoModel)))){
                $aCamposModel[$key] = iconv("utf-8","utf-8",$value); 
            }
        }
        
        foreach($this->Persistencia->getListaRelacionamento() as $oCampoBanco){
            if($oCampoBanco->getPersiste() && isset($aCamposModel[$sCampoModel.".".$oCampoBanco->getNomeModel()])){
                $xValor = $aCamposModel[$sCampoModel.".".$oCampoBanco->getNomeModel()];
                $this->setValorModel($this->Model,$oCampoBanco->getNomeModel(),$xValor);
                
                if($xValor !== null && $xValor !== "" && $xValor !== 0){
                    $iCamposValor++;
                }
            }
        }
        
        return $iCamposValor;
    }
    
    /**
     * Preenche os campos do Model do objeto conforme valores
     * presentes no objeto record ($_REQUEST) passado por parâmetro
     * 
     * @param Array $oRecord Array associativo contendo no formato [campo] => valor 
     * @param boolean $bControllerDetalhe Indica se o model a ser carregado pertence ao controlador principal ou ao detalhamento
     * @param boolean $bOrigemGrid Indica se a origem dos dados é do grid ou da tela
     */
    public function carregaModelArray($oRecord, $bControllerDetalhe = false, $bOrigemGrid = true){
        $oController = $bControllerDetalhe ? $this->ControllerDetalhe : $this;
        foreach($oController->Persistencia->getListaRelacionamento() as $oCampoBanco){
            if($oCampoBanco->getPersiste()){
                $aMetodos = self::extractMetodos($oCampoBanco->getNomeModel());
                $oModel = $oController->Model;
                
                $sNomeCampo = $bOrigemGrid ? str_replace(".", "_",$oCampoBanco->getNomeModel()) : $oCampoBanco->getNomeModel();
                
                $xValor = isset($oRecord[$sNomeCampo]) ? iconv("utf-8","iso8859-1",$oRecord[$sNomeCampo]) : null;
        
                if($xValor != null){
                    foreach($aMetodos as $key => $sMetodo){
                        $sMetodoSetter = Fabrica::montaSetter($sMetodo);
                        $sMetodoGetter = Fabrica::montaGetter($sMetodo);

                        if(count($aMetodos) > 1){
                            if($key != count($aMetodos) - 1){
                                $oModel = $oModel->$sMetodoGetter();
                            } else{
                                $oModel->$sMetodoSetter($xValor);
                            }    
                        } else{
                            $oController->Model->$sMetodoSetter($xValor);
                        }
                    }
                }
            }
        }
    }
     
    /**
     * Preenche os campos do Model conforme valores
     * presentes na string passada 
     * 
     * @param string $sCampos Conteúdo a ser carregado no model
     */
    public function carregaModelString($sCampos){
        $aCampos = explode('&',$sCampos);
        foreach($aCampos as $sCampoAtual){
            $aCampoAtual = explode('=',$sCampoAtual);
            $this->setValorModel($this->Model,$aCampoAtual[0],$aCampoAtual[1]);
        }
    }    
    
    /**
     * Define o valor de um atributo do model
     * 
     * @param Object $oModelOriginal
     * @param string $sNomeCampo
     * @param string $xValor
     * 
     * @return Objetct
     */
    public function setValorModel(&$oModelOriginal, $sNomeCampo, $xValor = null,$aCamposTela){
        $aMetodos = self::extractMetodos($sNomeCampo);
        
        $oModel = $oModelOriginal;
        
        
        
        if($xValor === null && $xValor !== "" && $xValor !== 0){
           // $aCampos = json_decode($_REQUEST['campos'],true);
            $aCampos = array();
            parse_str($_REQUEST['campos'],$aCampos);
            //troca underline por ponto
            $sNomeRequest = str_replace('.', '_', $sNomeCampo);
            
           $xValorCampo = $this->preparaString($aCampos[$sNomeRequest]);
            //checa se o campo é data
            if (Util::ValidaData($xValorCampo)){
              $xValorCampo = Util::dataMysql($xValorCampo);  
            }
            
            
            //analisa o tipo de campo para tratamentos especiais
             foreach ($aCamposTela as $oCampoTela) {
                        switch ($oCampoTela){
                            case  is_a($oCampoTela, 'Campo'):
                                    //seta valor so $xValorCampo
                                    if($sNomeCampo==$oCampoTela->getNome()){
                                        if($oCampoTela->getITipo()==29){
                                           $xValorCampo = $this->ValorSql($xValorCampo); 
                                        }
                                    }
                            break;
                            case  is_array($oCampoTela):
                                foreach($oCampoTela as $CampoArray){
                                    if($sNomeCampo==$CampoArray->getNome()){
                                            if($CampoArray->getITipo()==29){
                                               $xValorCampo = $this->ValorSql($xValorCampo); 
                                            }
                                        }
                                }

                            break;
                            case  is_a($oCampoTela, 'FieldSet'):
                                foreach($oCampoTela->getACampos() as $oFsCampo){
                                    if(is_array($oFsCampo)){
                                        foreach ($oFsCampo as $oFsCampo1) {
                                            if($sNomeCampo==$oFsCampo1->getNome()){
                                                if($oFsCampo1->getITipo()==29){
                                                   $xValorCampo = $this->ValorSql($xValorCampo); 
                                                }
                                            }
                                        }
                                    } else{    
                                    if($sNomeCampo==$oFsCampo->getNome()){
                                            if($oFsCampo->getITipo()==29){
                                               $xValorCampo = $this->ValorSql($xValorCampo); 
                                            }
                                        }
                                    }

                                }
                            break;
                            case  is_a($oCampoTela, 'TabPanel'):
                                foreach($oCampoTela->getItems() as $Aba){
                                    foreach($Aba->getACampos() as $AbaCampo){
                                        if(is_array($AbaCampo)){
                                            foreach ($AbaCampo as $AbaCampo1) {
                                                if($sNomeCampo==$AbaCampo1->getNome()){
                                                if($AbaCampo1->getITipo()==29){
                                                     $xValorCampo = $this->ValorSql($xValorCampo); 
                                                   }
                                                }
                                            }
                                        }
                                      //verifica se é campo dentro do tab
                                     if(is_a($AbaCampo, 'Campo')){
                                        if($sNomeCampo==$AbaCampo->getNome()){
                                            if($AbaCampo->getITipo()==29){
                                               $xValorCampo = $this->ValorSql($xValorCampo); 
                                            }
                                        }
                                     }
                                    //verifica se é fieldset
                               if(is_a($oCampoTela, 'FieldSet')){
                                foreach($oCampoTela->getACampos() as $oFsCampo){
                                    if(is_array($oFsCampo)){
                                        foreach ($oFsCampo as $oFsCampo1) {
                                            if($sNomeCampo==$oFsCampo1->getNome()){
                                                if($oFsCampo1->getITipo()==29){
                                                   $xValorCampo = $this->ValorSql($xValorCampo); 
                                                }
                                            }
                                        }
                                    } else{    
                                    if($sNomeCampo==$oFsCampo->getNome()){
                                            if($oFsCampo->getITipo()==29){
                                               $xValorCampo = $this->ValorSql($xValorCampo); 
                                            }
                                        }
                                    }

                                }
                              }         
                                        
                                        
                             }
                           }
                            break;
                        }
             }
            
            
            //data nascimento - cad. pessoas - pessoa jurídica, como o campo era oculto tentava gravar false
            if(/*isset($aCampos[$sNomeCampo]) &&*/ $aCampos[$sNomeCampo]!=="false"){
                $xValor = $xValorCampo;
            } else{
                $xValor = null;
            }
        }
 //if comentado por carlos      
//        if(($xValor !== null) || $xValor === "" || $xValor === 0){
            foreach($aMetodos as $key => $sMetodo){
                $sMetodoSetter = Fabrica::montaSetter($sMetodo);
                $sMetodoGetter = Fabrica::montaGetter($sMetodo);

                if(count($aMetodos) > 1){
                    if($key != count($aMetodos) - 1){
                        $oModel = $oModel->$sMetodoGetter();
                    } else{
                        $oModel->$sMetodoSetter($xValor);
                    }    
                } else{
                    $oModelOriginal->$sMetodoSetter($xValor);
                }
            }
//        }else{
//            $sMetodoSetter = Fabrica::montaSetter($sMetodo);
//            $sMetodoGetter = Fabrica::montaGetter($sMetodo);
//            
//            $oModelOriginal->$sMetodoSetter('NULL');
//        }
        return $oModelOriginal;
    } 
    
   
    /**
     * Retorna o valor de um atributo do model
     * 
     * @param type $oModelOriginal
     * @param type $sNomeCampo
     * @return type XXX
     */    
    public static function getValorModel($oModelOriginal, $sNomeCampo){
        $aMetodos = self::extractMetodos($sNomeCampo);
        
        $oModel = $oModelOriginal;
        
        foreach($aMetodos as $key => $sMetodo){
            $sMetodoGetter = Fabrica::montaGetter($sMetodo);
            
            if(count($aMetodos) > 1){
                if($key != count($aMetodos) - 1){
                   $oModel = $oModel->$sMetodoGetter();
                   } else{
                     $xValor = $oModel->$sMetodoGetter();
                    }    
            } else{
                $xValor = $oModelOriginal->$sMetodoGetter();
               }                    
        }
        return $xValor;
    }
    
    /**
     * Retorna o model de um determinado campo
     * 
     * @param type $oModelOriginal
     * @param string $sNomeCampo
     * 
     * @return type XXX
     */    
    public static function getModel($oModelOriginal, $sNomeCampo){
        $aMetodos = self::extractMetodos($sNomeCampo);
        
        $oModel = $oModelOriginal;
        
        for($i=0; $i<(count($aMetodos)-1); $i++){
            $sMetodoGetter = Fabrica::montaGetter($aMetodos[$i]);
            $oModel = $oModel->$sMetodoGetter();
        }
        return $oModel;
    }
    
    /**
     * Método que permite realizar o preenchimento individual de um campo da
     * tela a partir de um atributo do model
     * 
     * @param string $sNomeCampo Nome do campo na tela a ter o valor definido
     * @param string $sNomeModel Nome do atributo do model a ter o valor capturado
     * @param object $oController Objeto controller que possui o model a ser pesquisado
     */
    protected function setValorCampo($sNomeCampo, $sNomeModel, $oController = null){
        if($oController === null){
            $oController = $this;
        }
        $oCampo = $this->View->getTela()->getCampoByName($sNomeCampo);
        $oCampo->setValor($oController->getValorModel($oController->Model,$sNomeModel));
    }
    
    /**
     * Retorna um array contendo os métodos do atributo em questão
     * onde o atributo pode ser um objeto
     * 
     * @param string $sMetodo
     * @return array Array contendo os métodos  
     */
    public static function extractMetodos($sMetodo){
        $aMetodos = explode('.',$sMetodo);
        $aRetorno = array();
        
        foreach($aMetodos as $sMetodo){
            $aRetorno[] = $sMetodo;
        }
        
        return $aRetorno;
    }
    
    /**
     * Método responsável por adicionar as mensagens ao retorno json
     * 
     * @param string $sMsg 
     */
    protected function adicionaMensagem($sMsg){
        $this->adicionaJSON($sMsg,'render',false);
    }

    /**
     * Cria a mensagem padrão para as inserções realizadas com sucesso
     * 
     * @param string $sId ID do objeto
     * @param string $sCampoFoco Id do campo que receberá o foco após limpar
     * @param string $sAutoIncremento String contendo o id dos campos que devem
     *                                ter seu valor incrementado
     * @param string $sAcoesExtras Ações extras a serem executadas após a gravação
     *                             definidas na View no momento da criação da tela
     * @param string $sComplementoMsg String contendo a mensagem complementar
     */    
    public function mensagemInsereOk($sId, $sCampoFoco, $sAutoIncremento, $sAcoesExtras = "", $sComplementoMsg = ""){
        $sAcao = $sAcoesExtras; 
        
        if($sAutoIncremento != ""){
            $sAcao .= $this->View->getAutoIncremento($sAutoIncremento);
        }
        $sAcao .= Base::getAcaoLimpa($sId);
        
        $sAcao .= $this->View->campoFocus($sCampoFoco);

        $this->adicionaJSON($this->View->removeMascara($sId));
        $this->adicionaMensagem($this->View->mensagemInfo('Registro incluído com sucesso!<br><br>'.$sComplementoMsg,$sAcao));
    }

    /**
     * Cria a mensagem padrão para as inserções que apresetaram erro
     * 
     * @param string $sId ID do objeto
     * @param string $sCampoFoco Id do campo que receberá o foco após limpar 
     * @param string $sComplementoMsg String contendo a mensagem de erro complementar
     */      
    public function mensagemInsereErro($sId, $sCampoFoco, $sComplementoMsg){
        $sAcao = $this->View->campoFocus($sCampoFoco);
        
        $sMensagem = 'Erro ao processar a inclusão do registro!<br><br>'.$sComplementoMsg;
        
        $this->adicionaJSON($this->View->removeMascara($sId));
        $this->adicionaMensagem($this->View->mensagemErro($sMensagem,$sAcao));
    }
    
    /**
     * Cria a mensagem padrão para as alterações realizadas com sucesso
     *
     * @param string $sId ID do objeto
     * @param string $sComplementoMsg String contendo a mensagem complementar
     */    
    public function mensagemAlteraOk($sId,$sComplementoMsg, $sAcoesExtras = ""){
        $sAcao = $this->View->fechaTela($sId);
        if ($sAcoesExtras) {
            $sAcao.= $sAcoesExtras;
        }
        
        $this->adicionaJSON($this->View->removeMascara($sId));
        $this->adicionaMensagem($this->View->mensagemInfo('Registro alterado com sucesso!<br><br>'.$sComplementoMsg,$sAcao));
    }

    /**
     * Cria a mensagem padrão para as alterações que apresetaram erro
     * 
     * @param string $sId ID do objeto
     * @param string $sCampoFoco Id do campo que receberá o foco após limpar 
     * @param string $sComplementoMsg String contendo a mensagem de erro do banco de dados
     */      
    public function mensagemAlteraErro($sId,$sCampoFoco,$sComplementoMsg){
        $sAcao = $this->View->campoFocus($sCampoFoco);
        
        $sMensagem = 'Erro ao processar a alteração do registro!<br><br>'.$sComplementoMsg;
        
        $this->adicionaJSON($this->View->removeMascara($sId));
        $this->adicionaMensagem($this->View->mensagemErro($sMensagem,$sAcao));
    }    
   
    /**
     * Cria a mensagem padrão para as exclusões realizadas com sucesso
     *
     * @param string $sId ID do objeto
     * @param string $sComplementoMsg String contendo a mensagem complementar
     */    
    public function mensagemExcluiOk($sId, $sComplementoMsg){
        $this->adicionaJSON($this->View->removeMascara($sId));
        $this->adicionaMensagem($this->View->mensagemInfo('Registro(s) excluído(s) com sucesso!<br><br>'.$sComplementoMsg,$this->View->recarregaConsulta($sId)));
    }

    /**
     * Cria a mensagem padrão para as exclusões que apresetaram erro
     * 
     * @param string $sId ID do objeto
     * @param string $sComplementoMsg String contendo a mensagem de erro do banco de dados
     */      
    public function mensagemExcluiErro($sId, $sComplementoMsg){
        $this->adicionaJSON($this->View->removeMascara($sId));
        
        $sMensagem = 'Erro ao processar a exclusão do registro!<br><br>'.$sComplementoMsg;
        
        $this->adicionaMensagem($this->View->mensagemErro($sMensagem));
    }     
    
    /**
     * Cria uma mensagem personalizada
     * 
     * @param string $sMsg 
     */      
    public function mensagem($iTipo, $sTitulo, $sMsg, $iBotoes){
        $this->adicionaMensagem($this->View->mensagem($iTipo, $sTitulo, $sMsg, $iBotoes));
    }
    
    /**
     * Método de criação padrão para as telas, realiza a criação sem que 
     * a necessidade de criar estes métodos no controller específico
     */    
    protected function mostraTela(){
        $this->adicionaJSON($this->View->getRender());
        $this->confirmaJSON();
    }   
    
    /**
     * Método de criação padrão para as telas, realiza a criação sem que 
     * a necessidade de criar estes métodos no controller específico
     * 
     * Este método deve ser usado especificamente para as operações de 
     * abertura de telas em tabs quando selecionadas as opções do menu
     * 
     * @param string $renderTo Local onde a tela deve ser renderizada
     * @param string $sParametrosCriaTela String contendo os parâmetros utilizados
     *                                    no método criaTela dos objetos View
     *                                    devidamente separados por vírgula
     */    
    public function mostraTelaTab($renderTo, $sParametrosCriaTela = ""){
        $this->View->setRotina(View::ROTINA_INCLUIR);
        
        call_user_func_array(array($this->View,'criaTela'),explode(',',$sParametrosCriaTela));
        $this->View->setRetorno($renderTo);
        $this->View->getTela()->addListener(Base::EVENTO_CLOSE,Base::getAcaoFechar($renderTo));
        
        $this->mostraTela();
    }

    /**
     * Método de criação para as telas de manutenção que são chamadas pelas
     * ações das consultas. Ao serem fechadas realizam a remoção da máscara
     * de bloqueio sobre a consulta
     * Método chamado tanto para os cadastros como para as alterações
     * 
     * @param string $renderTo Local onde a tela deve ser renderizada
     */    
    public function acaoMostraTelaIncluir($renderTo){      
        $this->View->setSRotina(View::ACAO_INCLUIR);
        //monta um array, a primeira posição é da tab, o resto das consultas por ordem 
        $aRender = explode(',',$renderTo);
        //método antes de criar a tela
        $this->antesDeCriarTela($renderTo);
        //cria a tela
        $this->View->criaTela();
        //alimenta campos busca
        $this->antesIncluir();
        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aRender[0]);
        $this->View->getTela()->setAbaSel($aRender[0]);
        //adiciona tela que será dado um show 
        $this->View->getTela()->setSRenderHide($aRender[1]);
        //busca campo autoincremento para passar como parametro
        $sCampoIncremento =$this->retornaAutoInc();
        //adiciona botoes padrão 
       
         $this->View->addBotaoPadraoTela($sCampoIncremento);
        
        //função autoincremento
        $this->funcoesAutoIncremento();
        //seta o controler na view
        $this->View->setTelaController($this->View->getController());
        //renderiza a tela
        $this->View->getTela()->getRender();
        
        } 
    
    /**
     * Método de criação para as telas de manutenção que são chamadas pelas
     * ações de alterações
     * 
     * @param string $renderTo Local onde a tela deve ser renderizada
     */
        public function acaoMostraTelaAlterar($sDados){
      
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',',$sDados);
        $sChave =htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        //procedimentos antes de criar a tela
        $this->antesAlterar($aDados);
        //cria a tela
        $this->View->criaTela();
        
        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[1]);
        //adiciona tela que será dado um show 
        $this->View->getTela()->setSRenderHide($aDados[2]);
        //carregar campos tela
        $this->carregaCamposTela($sChave);
        //adiciona botoes padrão
        if(!$this->getBDesativaBotaoPadrao()){
            $this->View->addBotaoPadraoTela('');
            };
        //renderiza a tela
        $this->View->getTela()->getRender();
       }
     
       
     /**
     * Método responsável para abrir a tela de alteração no entanto ao selecionar item com 
       dropdow
     */
        public function acaoMostraTelaApontamentos($sDados){
       
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',',$sDados);
        $sChave =htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        //cria a tela
        $this->View->criaTela();
        
        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[0]);
        //adiciona tela que será dado um show 
        $this->View->getTela()->setSRenderHide($aDados[1]);
        //carregar campos tela
        $this->carregaCamposTela($sChave);
        //adiciona botoes padrão
        $this->View->addBotaoPadraoTela('');
        //renderiza a tela
        $this->View->getTela()->getRender();
       }
       
     /**
     * Método responsável para abrir a tela de alteração no entanto ao selecionar item com 
       dropdow
     */
        public function acaoMostraTelaApontdiv($sDados){
       
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',',$sDados);
        $sChave =htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        
        $this->View->setAParametrosExtras($aCamposChave);
        //cria a tela
        $this->View->criaTela();
        
        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[0]);
        //adiciona tela que será dado um show 
        $this->View->getTela()->setSRenderHide($aDados[1]);
        
        //adiciona botoes padrão
        $this->View->addBotaoApont();
        //renderiza a tela
        $this->View->getTela()->getRender();
       }
       
       /**
        * Método responsável para criar telas modais
        */
       public function acaoMostraTelaModal($sDados){
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',',$sDados);
        $sChave =htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        $aCamposChave['id'] = $aDados[1];
        $this->View->setAParametrosExtras($aCamposChave);
        
        $this->View->criaModal();
       
         //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[1].'-modal');
        
        $this->View->getTela()->setSRender($aDados[1].'-modal');
        $bSitProj = $this->Persistencia->verificaProj($aCamposChave['EmpRex_filcgc'],$aCamposChave['nr']);
        $bSitComercial = $this->Persistencia->verifInfCom($aCamposChave['EmpRex_filcgc'],$aCamposChave['nr']);
        
        if($sChave=='undefined' || $bSitProj == false || $bSitComercial ==false){
            $oMensagem = new Modal('Atenção', 'Verifique se o projeto está aprovado, também verifique se há apontamento de data e valor de venda!', Modal::TIPO_ERRO, true,true,true);
            echo $oMensagem->getRender();
            echo'$("#'.$aDados[1].'-btn").click();';
        }else{
       //renderiza a tela
        $this->View->getTela()->getRender();
        }
        
        
       }

       














       /**
     * Método de criação para as telas de manutenção que são chamadas pelas
     * ações de alterações
     * 
     * @param string $renderTo Local onde a tela deve ser renderizada
     */
        public function acaoMostraTelaEstoque($sDados){
       
        $aDados = explode(',',$sDados);
        
        //cria a tela
        $this->View->criaTela();
        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[0].'control');
        
        //renderiza a tela
        $this->View->getTela()->getRender();
       }
       
        public function acaoMostraTela($sDados){
            
                     
        $aDados = explode(',',$sDados);
        
        $this->View->setSIdAbaSelecionada($aDados[0]);
        
        $this->antesDeMostrarTela();
        
        //cria a tela
        $this->View->criaTela();
        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[0].'control');
        
        $this->View->getTela()->setAbaSel($aDados[0]);
        
        
        
         //função autoincremento
        $this->funcoesAutoIncremento();
        
        
        //renderiza a tela
        $this->View->getTela()->getRender();
       }
    /**
     * Método de criação para as telas de manutenção para simples visualização
     * dos dados. Exibe a tela com os campos preenchidos e devidamente
     * desabilitados. 
     * Também não inclui os botões de gravar e limpar
     * 
     * @param string $renderTo Local onde a tela deve ser renderizada
     * @param string $sChave Chave do registro a ser carregado
     */    
    public function acaoMostraTelaVisualiza($sDados){        
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',',$sDados);
        $sChave =htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        //cria a tela
        $this->View->criaTela();
        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[1]);
        //adiciona tela que será dado um show 
        $this->View->getTela()->setSRenderHide($aDados[2]);
        //carregar campos tela
        $this->carregaCamposTela($sChave);
        //renderiza a tela
        $this->View->getTela()->getRender();
    } 
    
    /**
     * Método que carrega os campos da tela a partir da chave
     * 
     * @param string $sChave Chave do registro a ser carregado
     * @param boolean $bDesabilita Indica se deve desabilitar os campos da tela
     */
    protected function carregaCamposTela($sChave,$bDesabilita = false){
        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();
        $this->depoisCarregarModelAlterar();

        foreach($this->View->getTela()->getCampos() as $oCampo){
            $this->verificaCarregarCampo($oCampo);

        }
    }
    
    /**
     * Método que carrega o valor do campo passado por parâmetro
     * Se o campo possuir itens (Tabpanel, Panel, etc.) irá percorrer todos os
     * elementos de maneira recursiva para realizar o prenchimento
     * 
     * @param object $oCampo Objeto a ter o valor carregado
     */
    
    //carlos rever
    protected function carregaCampo($oCampo){
        if(method_exists($oCampo, 'getCampos')){
            foreach($oCampo->getCampos() as $oCampo){
                $this->carregaCampo($oCampo);
            }
        }
        
        //carrega os registros do grid se for um objeto FormGrid
        if(is_a($oCampo, 'FormGrid')){
            $this->carregaDadosGridDetalhe($oCampo);
        } else{
        //carrega o valor do campo
          
            if(method_exists($oCampo, 'setSValor') && !($oCampo->getApenasTela())){
                $this->carregaValorCampo($oCampo);
            } else if(is_a($oCampo, 'FieldSet')){
                foreach ($oCampo->getACampos() as $oCampo){
                    $this->carregaValorCampo($oCampo);
                }
            }
        }
    }
    
    /**
     * Método pode ser sobrescrito por controladores filhos, criando comportamentos antes de mostrar a tela
     */
    public function antesDeMostrarTela($sParametros=null){
        
    }

    /**
     * Método pode ser sobrescrito por controladores filhos, criando comportamentos antes de mostrar a tela
     */
    public function antesDeCriarTela($sParametros=null){
        
    }
    
    /**
     * Método para ser sobscrito antes de criar a consulta
     */
    public function antesDeCriarConsulta($sParametros=null){
        
    }
    /**
     * Método para ser sobscrito antes de criar a consulta
     */
    public function beforFiltroConsulta($sParametros=null){
        
    }


    /**
     * Método responsável por carregar os valores dos campos que são 
     * preenchidos automaticamente conforme valor indicado no campo de busca
     * 
     * @param Campo $oCampo Objeto do tipo campo a ser verificado
     */
    public function carregaValorCamposBusca($oCampo){
        if(method_exists($oCampo, 'getBtnBusca') && $oCampo->getBtnBusca() != null && $oCampo->getValor() != null){
            $oController = Fabrica::FabricarController($oCampo->getClasseBusca());

            //montagem do filtro
            $sCampoBanco = $oController->Persistencia->getNomeBanco(substr($oCampo->getNome(),strpos($oCampo->getNome(),".")+1));
            $iTipoLigacao = Persistencia::LIGACAO_AND;
            $iTipoComparacao = Persistencia::IGUAL;
            $oController->Persistencia->adicionaFiltro($sCampoBanco,$oCampo->getValor(),$iTipoLigacao,$iTipoComparacao);

            //obtem o nome da classe atual para a realização de testes
            $sNomeClasse = $oController->getNomeClasse();
            
            $aFiltroBusca = $oCampo->getCampoFiltroBusca();
            foreach ($aFiltroBusca as $oCampoBusca) {
                /*
                 * se a classe do campo de filtro for igual a classe de busca ou não 
                 * estiver presente na lista de classes de ligação, faz o envio 
                 * apenas o nome do campo no model para capturar o nome do campo
                 * no banco, ou seja, envia sem a classe
                 */
                if(is_object($oCampoBusca)){
                $sNomeCampo = $oCampoBusca->getNome();
                $sClasseBusca = strtolower(substr($sNomeCampo,0,strpos($sNomeCampo,".")));
                if($sClasseBusca === strtolower($sNomeClasse) || !$this->Persistencia->pertenceListaJoin($sClasseBusca)){
                    $sNomeCampo = substr($sNomeCampo,strpos($sNomeCampo,".")+1);
                }

                $sCampoBanco = $this->Persistencia->getNomeBanco($sNomeCampo);

                $iTipoLigacao = Persistencia::LIGACAO_AND;
                $iTipoComparacao = Persistencia::IGUAL;
                $oController->Persistencia->adicionaFiltro($sCampoBanco,$oCampoBusca->getValor(),$iTipoLigacao,$iTipoComparacao);
            }
            }
            
            //inclui os filtros adicionais definidos no controller específico
            $oController->adicionaFiltrosExtras();
        
            $aModels = $oController->Persistencia->getArrayModel(); //carrega os dados 

            if(count($aModels) > 0){
                foreach ($oCampo->getCampoBusca() as $aAtual){
                    $sCampo = substr($aAtual[0],strpos($aAtual[0],".")+1);
                    $xValor = str_replace("\n", "",$this->getValorModel($aModels[0],$sCampo));
                    $sId = $aAtual[1] != null ? $aAtual[1]->getId() : $oCampo->getId().Base::COMPLETA_NOME_BUSCA;
                    $this->View->getTela()->addListener(Base::EVENTO_ANTES_MONTAR,$this->View->setValorCampo($sId,$xValor));
                    $this->View->getTela()->addListener(Base::EVENTO_ANTES_MONTAR,$this->View->setValorOriginalCampo($sId,$xValor));
                }
            }
            /*
             * desabilita o botão e o campo suggest se o campo fizer parte da chave 
             * ou se for somente leitura
             */
            $bDesabilita = false;
            foreach($this->Persistencia->getChaveArray() as $oAtualBanco){
                if($oCampo->getNome() == $oAtualBanco->getNomeModel()){
                    $bDesabilita = true;
        }
    }
    
            if($oCampo->getSomenteLeitura()){
                $bDesabilita = true;
            }
            
            if($bDesabilita){
                $oCampo->setSomenteLeitura(true);
                $sAcao = "Ext.ComponentQuery.query('#".$oCampo->getId().Base::COMPLETA_NOME_BTN_BUSCA."')[0].disable(true);"
                       . "Ext.ComponentQuery.query('#".$oCampo->getId().Base::COMPLETA_NOME_BUSCA."')[0].disable(true);";

                $this->View->getTela()->addListener(Base::EVENTO_MONTAR,$sAcao);
            }
        }
    }
    
    /**
     * Método que percorre o array de campos verificando aqueles que estão 
     * presentes no array de campos autoincremento e realiza os seguintes
     * procedimentos:
     * - desabilita os campos
     * - monta a string da função de incremento após a inserção
     */
public function funcoesAutoIncremento(){
        if(!isset($this->Persistencia)){
            return false;
        }
        //captura o vetor de campos da tela
        $aCampos = $this->View->getTela()->getCampos();
        
        //busca os campos do banco que são autoincremento
        $aAuto = $this->Persistencia->getAutoIncrementoArray();

        foreach($aCampos as $oAtualTela){
            //só deve executar para os objetos que forem instância da classe Campo
            if(get_class($oAtualTela) === 'Campo'){
                foreach($aAuto as $oAtualBanco){
                    if($oAtualTela->getNome() == $oAtualBanco->getNomeModel()){
                        //$oAtualTela->setSomenteLeitura(true);
                        if($oAtualTela->getSValor() == null){
                            $oAtualTela->setSValor($this->Persistencia->getIncremento($oAtualBanco->getNomeBanco(),true));
                        } 

                    }
                }
            }
            if(is_a($oAtualTela, 'FieldSet')){
               foreach($oAtualTela->getACampos() as $oFsCampos){
                  foreach($aAuto as $oAtualBanco){
                    if(is_array($oFsCampos)){
                        foreach ($oFsCampos as $oCampoFs){
                            if($oCampoFs->getNome() == $oAtualBanco->getNomeModel()){
                               //$oAtualTela->setSomenteLeitura(true);
                               if($oCampoFs->getSValor() == null){
                                   $oCampoFs->setSValor($this->Persistencia->getIncremento($oAtualBanco->getNomeBanco(),true));
                               } 
                            } 
                        }
                    } else{
                        if($oFsCampos->getNome() == $oAtualBanco->getNomeModel()){
                            //$oAtualTela->setSomenteLeitura(true);
                           if($oFsCampos->getSValor() == null){
                               $oFsCampos->setSValor($this->Persistencia->getIncremento($oAtualBanco->getNomeBanco(),true));
                           } 
                        } 
                    }
                   
                }
               } 
            }
            
             if(is_a($oAtualTela, 'TabPanel')){
               foreach($oAtualTela->getItems() as $oTabCampos){
                    foreach($oTabCampos->getACampos() as $oAbaCampos){
                        foreach($aAuto as $oAtualBanco){
                           if(is_array($oAbaCampos)){
                               foreach ($oAbaCampos as $oAbaCampos1) {
                                  if($oAbaCampos1->getNome() == $oAtualBanco->getNomeModel()){
                                    //$oAtualTela->setSomenteLeitura(true);
                                    if($oAbaCampos1->getSValor() == null){
                                        $oAbaCampos1->setSValor($this->Persistencia->getIncremento($oAtualBanco->getNomeBanco(),true));
                                    } 
                                   } 
                               }
                           }else{
                            if($oAbaCampos->getNome() == $oAtualBanco->getNomeModel()){
                               //$oAtualTela->setSomenteLeitura(true);
                               if($oAbaCampos->getSValor() == null){
                                   $oAbaCampos->setSValor($this->Persistencia->getIncremento($oAtualBanco->getNomeBanco(),true));
                               } 

                             }
                           }
                       }
                    }
               } 
            }
         }
    }
    
    /**
     * Método que percorre o array de campos verificando aqueles que estão 
     * presentes no array de campos autoincremento os inclui no array de 
     * retorno
     * 
     * @return Array Array contendo o id dos campos que precisam ter seu valor
     *               incrementado após a operação de inserção
     */
    public function getAutoIncremento(){
        if(!isset($this->Persistencia)){
            return false;
        }
        $aReturn = array();
        
        //captura o vetor de campos da tela
        $aCampos = $this->View->getTela()->getCampos();
        
        //busca os campos do banco que são autoincremento
        $aAuto = $this->Persistencia->getAutoIncrementoArray();

        foreach($aCampos as $oAtualTela){
            //só deve executar para os objetos que forem instância da classe Campo
            if(get_class($oAtualTela) === 'Campo'){
                foreach($aAuto as $oAtualBanco){
                    if($oAtualTela->getNome() == $oAtualBanco->getNomeModel()){
                        $aReturn[] = $oAtualTela->getId();
                    }
                }
            }
        }
        return $aReturn;
    }
    
    /**
     * Método de criação para os gráficos
     * 
     * @param string $sRenderTo Local onde a tela deve ser renderizada
     */    
    public function acaoMostraTelaGrafico($sRenderTo = 'Ext.getBody()'){
        $this->View->criaTelaGrafico();

        $this->View->getTela()->setClasse($this->View->getController());
        $this->View->getTela()->addListener(Base::EVENTO_CLOSE,Base::getAcaoFechar($sRenderTo));
        
        $this->View->setRetorno($sRenderTo);
        $this->adicionaJSON($this->View->getRender());       
        $this->confirmaJSON();
    }
    
    /**
     * Método de criação para as consultas gerenciais
     * 
     * @param string $sRenderTo Local onde a tela deve ser renderizada
     */    
    public function mostraCubo($sRenderTo = 'Ext.getBody()'){
        $this->View->criaCubo();
        $this->View->getTela()->setOrigemDados($this->View->getController(),'getDadosConsulta');
        $this->View->getTela()->addListener(Base::EVENTO_CLOSE,Base::getAcaoFechar($sRenderTo));
        $this->View->setRetorno($sRenderTo);
        $this->adicionaJSON($this->View->getRender());       
        $this->confirmaJSON();
    }
    /**
     * Método responsável para criar telas diversas no sistema
     */
    
    public function criaTelaDiversa($renderTo,$sMetodo){
        $this->View->$sMetodo();
        $this->View->getTela()->setSRender($renderTo.'control');
        echo $this->View->getTela()->getRender();
    }

    /**
     * Método de criação para as telas relatórios
     * 
     * @param string $renderTo Local onde a tela deve ser renderizada
     * @param string $sMetodo Método que contêm a tela com os filtros do relatório
     */    
    public function mostraTelaRelatorio($renderTo,$sMetodo){
        $this->View->$sMetodo();
        $sAcao = 'requestAjax("","'.$this->getNomeClasse().'","acaoMostraRelatorio", "'.$sMetodo.',"+ serializeForm("'.$this->View->getTela()->getId().'"));';
        $BtnRelatorio = new Botao('Vizualizar', Botao::TIPO_REL, '');
        $this->View->getTela()->setIdBtnConfirmar($BtnRelatorio->getId());
        $this->View->getTela()->setAcaoConfirmar($sAcao);
        $this->View->getTela()->addBotoes($BtnRelatorio);
        $this->View->getTela()->setSRender($renderTo.'control');
        echo $this->View->getTela()->getRender();
        
    }
    /**
     * Método para gerar telas que somente geram excel
     */
    public function mostraTelaRelatorioXls($renderTo,$sMetodo){
        $this->View->$sMetodo();
        $sAcao = 'requestAjax("","'.$this->getNomeClasse().'","acaoGeraRelXls", "'.$sMetodo.',"+ serializeForm("'.$this->View->getTela()->getId().'"));';
        $BtnRelatorio = new Botao('Gerar Excel', Botao::TIPO_REL, '');
        $this->View->getTela()->setIdBtnConfirmar($BtnRelatorio->getId());
        $this->View->getTela()->setAcaoConfirmar($sAcao);
        $this->View->getTela()->addBotoes($BtnRelatorio);
        $this->View->getTela()->setSRender($renderTo.'control');
        echo $this->View->getTela()->getRender();
        
    }
    /**
     * Método responsável pela exibição dos relatórios no formato PDF
     * 
     * @param string $sParametros String composta de método e parametros para emissão do relatório
     */
    public function acaoMostraRelConsulta($sParametros,$sRel){
        //Explode string parametros
        $aDados = explode(',', $sParametros);
        
        $sCampos = htmlspecialchars_decode($aDados[2]);
        
        $sCampos .='&dir='.$_SESSION['diroffice'];
        
        $aRel = explode(',', $sRel);
       
        $sSistema ="app/relatorio";
        $sRelatorio = $aRel[0].'.php?';
        
        $sCampos.= $this->getSget();
        
        $sCampos.=$this->beforeRel($sParametros);
        
        if($aRel[1]!='email'){
            //verifica se é sem logo
            if($aRel[1]=='slogo'){
                $sCampos.='&logo=semlogo';
            }
        $sCampos.='&output=tela';
        $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow;  
        }else
        {
             if($aRel[4]=='slogo'){
                $sCampos.='&logo=semlogo';
            }
         $sCampos.='&output=email';
         $oWindow = 'var win = window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "1366002941508","width=100,height=100,left=375,top=330");'
                    .'setTimeout(function () { win.close();}, 1000);';
         echo $oWindow;
         
         $oMensagem = new Mensagem("Aguarde","Seu e-mail está sendo processado", Mensagem::TIPO_INFO);
         echo $oMensagem->getRender();
         echo 'requestAjax("","'.$aRel[2].'","'.$aRel[3].'","'.$sParametros.'");';
   
        }
        
    }
    
    /**
     * Método responsável pela exibição dos relatórios no formato HTML
     * 
     * @param string $sParametros String composta de método e parametros para emissão do relatório
     */
    public function acaoMostraRelConsultaHTML($sParametros,$sRel){
        //Explode string parametros
        $aDados = explode(',', $sParametros);
        
        $sCampos = htmlspecialchars_decode($aDados[2]);
        
        $sCampos .='&dir='.$_SESSION['diroffice'];
        
        $aRel = explode(',', $sRel);
       
        $sSistema ="app/relatorio";
        $sRelatorio = $aRel[0].'.php?';
        
        $sCampos.= $this->getSget();
        
        $sCampos.=$this->beforeRel($sParametros);
        
        if($aRel[1]!='email'){
            //verifica se é sem logo
            if($aRel[1]=='slogo'){
                $sCampos.='&logo=semlogo';
            }
        $sCampos.='&output=tela';
        $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow;  
        }else
        {
             if($aRel[4]=='slogo'){
                $sCampos.='&logo=semlogo';
            }
         $sCampos.='&output=email';
         $oWindow = 'var win = window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "1366002941508","width=100,height=100,left=375,top=330");'
                    .'setTimeout(function () { win.close();}, 1000);';
         echo $oWindow;
         
         $oMensagem = new Mensagem("Aguarde","Seu e-mail está sendo processado", Mensagem::TIPO_INFO);
         echo $oMensagem->getRender();
         echo 'requestAjax("","'.$aRel[2].'","'.$aRel[3].'","'.$sParametros.'");';
   
        }
        
    }
    
    /**
     * Método responsável pela exibição dos relatórios no formato PDF
     * 
     * @param string $sParametros String composta de método e parametros para emissão do relatório
     */
    public function acaoMostraRelXls($sParametros,$sRel){
        //Explode string parametros
        $aDados = explode(',', $sParametros);
        
        $sCampos = htmlspecialchars_decode($aDados[2]);
        
        $sCampos .='&dir='.$_SESSION['diroffice'];
        
        $sCampos.= $this->getSget();
        
        $aRel = explode(',', $sRel);
       
        $sSistema ="app/relatorio";
        $sRelatorio = $aRel[0].'.php?';
        
        $sCampos.='&output=email';
        $oMensagem = new Mensagem("Aguarde","Seu excel está sendo processado", Mensagem::TIPO_INFO);
        echo $oMensagem->getRender();
       
        $oWindow =// 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "Relatório", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");'; 
                'var win = window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'","MsgWindow","width=500,height=100,left=375,top=330");'
                    .'setTimeout(function () { win.close();}, 10000);';
        echo $oWindow;
         
        
        
        $oMenSuccess = new Mensagem("Sucesso","Seu excel foi gerado com sucesso, acesse sua pasta de downloads!", Mensagem::TIPO_SUCESSO);
        echo $oMenSuccess->getRender();
        
    }
    public function acaoGeraRelXls($sParametros,$sRel){
        //Explode string parametros
        $aDados = explode(',', $sParametros);
        
        $sCampos = htmlspecialchars_decode($aDados[1]);
        
       // $sCampos .='&dir='.$_SESSION['diroffice'];
        
       // $sCampos.= $this->getSget();
        
        $sRel = $aDados[0];
       
        $sSistema ="app/relatorio";
        $sRelatorio = $sRel.'.php?';
        
       // $sCampos.='&output=email';
        $oMensagem = new Mensagem("Aguarde","Seu excel está sendo processado", Mensagem::TIPO_INFO);
        echo $oMensagem->getRender();
       
        $oWindow =// 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "Relatório", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");'; 
                'var win = window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'","MsgWindow","width=500,height=100,left=375,top=330");';
                 //   .'setTimeout(function () { win.close();}, 10000);';
        echo $oWindow;
         
        
        
        $oMenSuccess = new Mensagem("Sucesso","Seu excel foi gerado com sucesso, acesse sua pasta de downloads!", Mensagem::TIPO_SUCESSO);
        echo $oMenSuccess->getRender();
        
    }
    
    
    public function geraRelPdf($sDados){
         $aDados = explode(',', $sDados);
         $sSistema ="app/relatorio";
         $sRelatorio = $aDados[1].'.php?';
         $sCampos='nr='.$aDados[0];
         $sCampos.='&dir='.$_SESSION["diroffice"]; 
         $sCampos.= $this->getSget();
         $sCampos.='&output=email';
         
          $oWindow = 'var win = window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "1366002941508","width=100,height=100,left=375,top=330");'
                    .'setTimeout(function () { win.close();}, 1000);';
         echo $oWindow;
    }
    
    /**
     * Método para ser usado para gerar relatórios e ser sobescrido na classe filha
     */
    public function acaoMostraRelEspecifico($sDados){
        
    }

    


    /**
     * Método responsável pela exibição dos relatórios no formato PDF
     * 
     * @param string $sParametros String composta de método e parametros para emissão do relatório
     */
    public function acaoMostraRelatorio($sParametros){
        //abre mensagem que o relatório está sendo processado
        $oMensagem = new Mensagem('Geração de Relatório', 'Seu relatório está sendo processado!', Mensagem::TIPO_INFO);
        echo $oMensagem->getRender();
        
        //Explode string parametros
        $aDados = explode(',', $sParametros);
        $sMetodo = $aDados[0];
        $sCampos = htmlspecialchars_decode($aDados[1]);
        
        $aDocto = array();
        parse_str($sCampos,$aDocto);
        $sCampos.= $this->getSget();
        
        $sSistema ="app/relatorio";
        $sRelatorio = $sMetodo.'.php?';
        $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "Relatório", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow;  
    }
    
    /**
     * Método de criação padrão para as consultas, realiza a criação sem que 
     * a necessidade de criar estes métodos no controller específico
     * 
     * @param primeira posição é a tab inicial 
     * @param segunda se refere o id de retorno, se esta setado automaticamente a consulta se refere a pesquia
     */ 
    public function mostraConsulta($sParametros){
       
        $aDados = explode(',', $sParametros);
        $this->adicionaFiltrosExtras();
        
                 
        $this->View->criaConsulta();
        $this->View->getTela()->setAbaSel($aDados[0]);
        //se posição 0 esta setada define automaticamente como pesquisa
        if ($aDados[1]!==null && $aDados[1]!==''){
            $this->View->getTela()->setBConsulta(true);
            $this->View->getTela()->setSRenderHide($aDados[1]);
            $this->View->getTela()->setSCampoConsulta($aDados[2]);
            $this->View->getTela()->setSCampoRetorno($aDados[3]);
            $bDesativaAcao = $this->View->getBDesativaAcaoConsulta();
           if($bDesativaAcao){
              $this->View->setUsaAcaoAlterar(false);
              $this->View->setUsaAcaoExcluir(false);
              $this->View->setUsaAcaoIncluir(false);
           }  
            
         
        }
        $this->View->setRetorno($aDados[0]);
        $this->View->addBotoesConsulta($aDados[0]);
        $this->View->addFiltroConsulta($aDados[0]);
        $this->View->setTelaController($this->View->getController());
        $this->View->getRender();
    }
   
   /**
    * Método semelhante a mostra consulta com o objetivo de montar dois gris mestre e detalhe
    * ($sRenderTo = 'Ext.getBody()',
                                   $bConsultaBusca = false, 
                                   $sCampoRetorno = "",
                                   $sCampoForm = "",
                                   $bAdicionaAcoesPadrao=true,
                                   $sCamposFiltrosExtra="",
                                   $sValoresFiltrosExtra=""){
    */
   public function mostraConsultaDetail($sRenderTo = 'Ext.getBody()', 
                                   $bConsultaBusca = false,
                                   $sCampoRetorno = "",
                                   $sCampoForm = "",
                                   $bAdicionaAcoesPadrao=true,
                                   $sCamposFiltrosExtra="",
                                   $sValoresFiltrosExtra="" ){
       
       $this->setParametros($sCampoRetorno);
       $aParametrosG = $this->getParametros();
       //pega o índice como o método
       $aClasse = array_keys($aParametrosG);
       //pega o última posição do array q é o arquivo do relatório
       $ClasseDetail =$aClasse[count($aClasse)-1];
       
       
       
       
        $aGrids=array(1,2);
        
        foreach ($aGrids as $key => $value) {
            if($key == 0){
                $this->mostraConsulta($sRenderTo, 
                                   $bConsultaBusca,
                                   $sCampoRetorno,
                                   $sCampoForm,
                                   $bAdicionaAcoesPadrao,
                                   $sCamposFiltrosExtra,
                                   $sValoresFiltrosExtra,
                                   $bGridDetail=true);
             
             $gridDetalhe = $this->View->gridDetalhe();
             $this->View->getTela()->addListener(Base::EVENTO_CELL_CLIQUE,$this->View->getAcaoCliqueDetail($gridDetalhe));

             $gridMaster = $this->View->getRender(); 
             
                
            }
            //carrega classe detail e monta a string
            if ($key == 1){
                $this->carregaClassesMvc($ClasseDetail);
                $this->mostraConsulta($sRenderTo, 
                                   $bConsultaBusca,
                                   $sCampoRetorno,
                                   $sCampoForm,
                                   $bAdicionaAcoesPadrao,
                                   $sCamposFiltrosExtra,
                                   $sValoresFiltrosExtra,
                                   $bGridDetail=true);
                $gridDetail = $this->View->getRender();
            }
        }
        //adiciona a base
        $json = Base::addMasterDetail($gridMaster,$gridDetail,$sRenderTo);
        $this->adicionaJSON($json);       
        $this->confirmaJSON();            
                    
       
      
       
   }
   /**
     * Método que permite a adição de filtros adicionais na busca
     * dos dados das consultas
     * 
     * Quando necessário deve ser sobrescrito nos controladores específicos
     */
    public function adicionaFiltrosExtras(){
        
    }
    /**
     * Método que permite a adição de filtros adicionais na busca
     * dos dados das consultas
     * 
     * Quando necessário deve ser sobrescrito nos controladores específicos
     */
    public function adicionaFiltroDet(){
        
    }
    /**
     * Método que permite a adição de filtros adicionais na busca
     * dos dados das consultas
     * 
     * Quando necessário deve ser sobrescrito nos controladores específicos
     */
    public function adicionaFiltroDet2(){
        
    }
    /*
     * Adiciona filtros iniciais nas consultas
     */
    public function filtroInicial(){
        
    }
     /**
     * Scroll infinito
     */
    public function getDadosScrollCampo($sDadosReload,$bReload=false,$sCampoConsulta=null,$aColuna=null,$bGridCampo = false){
        $aGridMetodo = explode(',', $sDadosReload);
         $this->View->criaTela();
        
        $aCampos = $this->View->$aGridMetodo[1]();
        
        
        $this->getDadosConsulta($aGridMetodo[0],$bReload,$sCampoConsulta,$aCampos,true,true);
    }
    /**
     * Scroll infinito
     */
    public function getDadosScroll($sDadosReload,$bReload=false,$sCampoConsulta=null,$aColuna=null,$bGridCampo = false){
        $this->getDadosConsulta($sDadosReload,$bReload,$sCampoConsulta,$aColuna,$bGridCampo,true);
    }
    /**
     * método para chamar a o getdadosconsulta com o array de camposconsulta
     */
    public function getDadosGrid($sDadosReload,$nomeGrid){
        $this->View->criaTela();
        //explode nome grid
        $aDados = explode(',', $nomeGrid);
        $nomeGrid=$aDados[0];
        $aCampos = $this->View->$nomeGrid();
        $this->afterGetdadoGrid();
        $this->getDadosConsulta($sDadosReload,true,null,$aCampos, true);      
    }
    
    /**
     * gera dados de um segundo grid
     */
    public function getDadosGridDetalhe($sDados,$sChave){
        $aDados = explode(',',$sChave);
        $aParam = explode('=', $aDados[0]);
        $this->Persistencia->adicionaFiltro($aParam[0],$aParam[1]);
        $this->antesDetalhe($aParam[1]);
        $this->getDadosConsulta($sDados,true,null,null, null);
    }

    /**
     * Método de realiza a busca dos dados a serem listados na consulta
     * 
     * A busca é feita separadamente da montagem da consulta para podermos
     * buscar apenas a página atual, desta forma a busca ficará mais rápida
     * nos casos de vários registros
     * $sRenderTo onde será renderizados os dados
     * $bConsultaPorSql define se a consulta será manual = true ou false pela persistencia
     */  
     public function getDadosConsulta($sDadosReload,$bReload=false,$sCampoConsulta=null,$aColuna=null,$bGridCampo = false,$bScroll=false){
        //realiza a busca dos filtros
        $this->beforFiltroConsulta();
        //verifica se tem order by
        if(isset($_REQUEST['ordenacao'])){
            $aOrdena = $_REQUEST['ordenacao'];
            $this->Persistencia->limpaOrderBy();
            if($aOrdena['ordenacao']=='Asc'){
                $iOrdena = 0;
            }else{
                $iOrdena = 1; 
            }
            $this->Persistencia->adicionaOrderBy($aOrdena['campo'], $iOrdena);
        }
         
        if ($sDadosReload !== NULL){
         $aCampoConsulta = explode(',', $sDadosReload);
         $sCampoConsulta = $aCampoConsulta[1];
         if($_REQUEST['parametrosCampos']){
                    foreach ($_REQUEST['parametrosCampos'] as $sAtual){
                        $aFiltros[] =  explode(',',$sAtual) ;
                    }
        }
        if(isset($aFiltros)){
             $aEntre = array();
             $iCont = 0;
            foreach ($aFiltros as $key => $aFiltroGrid) {
                if ($aFiltroGrid[1] <> '' && $aFiltroGrid[1]<>'scroll'){
                    if($bReload!==TRUE){
                     //monta um array para as datas between
                       if($aFiltroGrid[2]=='entre'){
                           $aEntre[$iCont]['campo']=$aFiltroGrid[0];
                           if($aFiltroGrid[3]=='vlrini'){$aEntre[$iCont]['vlrini']=$aFiltroGrid[1];$aEntre[$iCont]['vlrfim']=null;};
                           if($aFiltroGrid[3]=='vlrfim'){$aEntre[$iCont]['vlrini']=null;$aEntre[$iCont]['vlrfim']=$aFiltroGrid[1];};
                         
                           $iCont++;
                    }else{
                            //verifica se deve conter a tabela
                         $aCampoTabela = explode('.',$aFiltroGrid[0]);
                         if(!isset($aCampoTabela[1])){
                           $this->Persistencia->adicionaFiltro($aFiltroGrid[0],$aFiltroGrid[1],Persistencia::LIGACAO_AND, $this->tipoFiltro($aFiltroGrid[2]));
                         }else{
                           $this->Persistencia->adicionaFiltro($aFiltroGrid[0],$aFiltroGrid[1],Persistencia::LIGACAO_AND, $this->tipoFiltro($aFiltroGrid[2]),"",$aCampoTabela[0]);    
                         }    
                                //adicionaFiltro($sCampo,$sValor,$iTipoLigacao = 0,$iTipoComparacao = 0,$sValorFim = "",$sTabelaCampo="", $sCampoType = "")
                        } 
                    }
                }
              //verifica se tem filtro scroll infinito
               if ($aFiltroGrid[1]=='scroll'){
                   //tratar qdo é chave composta
                    $aDados = explode(',', $aFiltroGrid[0]);
                    $sChave = htmlspecialchars_decode($aDados[0]);
                    $aCamposChave = array();
                    parse_str($sChave,$aCamposChave);
                    //filtro tem que vir na ordem chavePk e chavePK incremental
                   //pega o último valor do array e coloca como filtro menor que 
                    $aUlt = array_slice($aCamposChave, -1);
                    foreach ($aUlt as $key => $value) {
                      $this->Persistencia->adicionaFiltro($key,$value,Persistencia::LIGACAO_AND, $this->tipoFiltro($aFiltroGrid[1]));   
                       }
                    //tira o incremental
                    array_pop($aCamposChave);
                    foreach ($aCamposChave as $key => $value) {
                        //retorna campo do model
                        $aModel = explode('_', $key);
                        if(count($aModel)>1){
                           $sModelFiltro = $aModel[1]; 
                        }else{
                           $sModelFiltro = $aModel[0]; 
                        }
                        $this->Persistencia->adicionaFiltro($sModelFiltro,$value, Persistencia::LIGACAO_AND);
                    }

                }
            }
         //monta filtro between por enquanto um por grid   
            $sCampo = '';
            $sVlrInicial = '';
            $sVlrFinal = '';
         foreach ($aEntre as $aEntreFiltro){
            $sCampo = $aEntreFiltro['campo']; 
            if(isset($aEntreFiltro['vlrini'])){$sVlrInicial=$aEntreFiltro['vlrini'];};  
            if(isset($aEntreFiltro['vlrfim'])){$sVlrFinal =$aEntreFiltro['vlrfim'];};
           }  
          if (!empty($aEntre)){
            $this->Persistencia->adicionaFiltro($sCampo,$sVlrInicial, Persistencia::LIGACAO_AND, Persistencia::ENTRE,$sVlrFinal);  
          } 
          
          } 
        }
         
        //primeira posição campo no model, segunda valor, terceira tipo
        $this->antesDeCriarConsulta($sParametros);
        
        $aDadosAtualizar = explode(',', $sDadosReload);
        $this->View->criaConsulta();
        
        //verifica se há atributos de soma nos campos consulta
        
        
        
        if ($bGridCampo===true){
           $aCampos = $aColuna;
        }else{
          $aCampos = $this->View->getTela()->getArrayCampos();//captura os campos da tela
        }
        
       $aModels = $this->Persistencia->getArrayModel();//carrega os campos da consulta
       //pega o total de linhas na querys
       $iTotalReg = $this->Persistencia->getCount();
       
       $sDados ='';
       //verifica se foi informado posição do contador
      /* if(isset($_REQUEST['idPos'])){
           $sTr = $_REQUEST['idPos'];
           $sTr =substr($sTr,3);
           $iTr = $sTr+1;
       }else{
           $iTr = 1;
       }*/
       //grava primeiro id para dar o focus
       
      foreach($aModels as $oAtual){
            //verifica as comparaçoes da consulta
            foreach($aCampos as $campoAtual){
                 $sNomeCampo  = $campoAtual->getSNome();
                 //não pegar valor se for tipo botao
                 if($campoAtual->getBCampoIcone()==false){
                 $xValorCampo =  str_replace("'","\\'",$this->getValorModel($oAtual,$sNomeCampo));// $sConteudo = str_replace("<br>", "\\n",$sConteudo);
                 $sComparacao =  $campoAtual->getAComparacao();
                 if(!empty($sComparacao) && !$campoAtual->getBComparacaoColuna()){
                     $aRetornoFormat = $this->formatacaoCondicional($xValorCampo, $campoAtual->getAComparacao());
                 }
               }
            }
            if($aRetornoFormat[0]){
                 $sIdtr = Base::getId();
                 $bFocoCampo = $this->View->getTela()->getBFocoCampo();
                 $sDados .= '<tr id="'.$sIdtr.'"  tabindex="0" class="'.$aRetornoFormat[1].' dbclick" style="font-size:small;">';
                 if(!$bFocoCampo){$sDados .='<script>'
                         .'$("#'.$sIdtr.'").keydown(function(e) { '
                                  .'if(e.which == 40) {   '
                                  .'     $(this).removeClass("selected"); '
                                  .'     $(this).next().focus(); '
                                  .'     $(this).next().addClass("selected");'
                                  .'  } else if(e.which == 38) {  '
                                  .'      $(this).removeClass("selected"); '                                       
                                  .'      $(this).prev().focus(); '                                      
                                  .'      $(this).prev().addClass("selected"); ' 
                                  .'  } '
                                  .'});'
                       
                 .'</script>';}
            }else{
                 $sIdtr = Base::getId();
                 $bFocoCampo = $this->View->getTela()->getBFocoCampo();
                 $sDados .= '<tr id="'.$sIdtr.'" tabindex="0" role="row" class="odd dbclick" style="font-size:small;">';//abre a linha
                 if(!$bFocoCampo){$sDados .='<script>'
                         .'$("#'.$sIdtr.'").keydown(function(e) { '
                                  .'if(e.which == 40) {   '
                                  .'     $(this).removeClass("selected"); '
                                  .'     $(this).next().focus(); '
                                  .'     $(this).next().addClass("selected");'
                                  .'  } else if(e.which == 38) {  '
                                  .'      $(this).removeClass("selected"); '                                       
                                  .'      $(this).prev().focus(); '                                      
                                  .'      $(this).prev().addClass("selected"); ' 
                                  .'  } '
                                  .'});'
                       
                 .'</script>';}
            }
           
           
            $sDados.='<td class="select-checkbox sorting_1 select-checkbox" style="width: 30px;"></td>';//td do check
            $aLinha = array(); //inicializa o vetor que conterá a linha atual
            //carrega os campos que serão mostrados na consulta
            foreach($aCampos as $campoAtual){
                 $xValorCampo = '';
                 $sConsulta = '';
                 $sNomeCampo  = $campoAtual->getSNome();
                 if($campoAtual->getBCampoIcone()==true){
                     $sChave =$this->Persistencia->getChaveModel($oAtual);
                     $sDados.=$campoAtual->getRender($sConsulta,$sChave);
                 }else{
                 if($campoAtual->getTipo() == CampoConsulta::TIPO_DATA){
                     if($this->getValorModel($oAtual,$sNomeCampo)){
                      $xValorCampo = date('d/m/Y',  strtotime($this->getValorModel($oAtual,$sNomeCampo))) ;
                     }else{$xValorCampo = '';};
                 }else{
//                     $xValorCampo = str_replace("'","\\'",$this->getValorModel($oAtual,$sNomeCampo));
                     $xValorCampo = $this->getValorModel($oAtual,$sNomeCampo);
                     $xValorCampo = rtrim($xValorCampo);
                 }
                 if($campoAtual->getSNome()===$sCampoConsulta){
                     $sConsulta = ' consultaCampo';
                 } 
                 
                $sComparacao1 =  $campoAtual->getAComparacao();
                 if($campoAtual->getBComparacaoColuna() && !empty($sComparacao1)){
                        $aRetornoFormat = $this->formatacaoCondicional($xValorCampo, $campoAtual->getAComparacao());
                }
                
                if($aRetornoFormat[0]){
                   $sChave =$this->Persistencia->getChaveModel($oAtual);
                   $sDados .= $campoAtual->getRender($aRetornoFormat[1].$sConsulta,$xValorCampo,$sChave);
                   $aRetornoFormat[0] = false;
               }else{
                    
                    $sDados.=$campoAtual->getRender($sConsulta,$xValorCampo);
               }
              
              }
            }
                
                 
            //monta td das chaves primaria
            $sChave =$this->Persistencia->getChaveModel($oAtual);
            $sDados.='<td class="hidden chave">'.$sChave.'</td>';
            $sDados .= '</tr>';
            
          }
         //define se o $sDadosReload != null é atualização se não e nova tela
        if ($sDadosReload !== NULL){
             //pegar id da tr
                $sRender = 'var idTr="";$("#'.$aDadosAtualizar[0].'consulta tbody .selected").each(function(){'
                           .' idTr=$(this).attr("id");'
                           .' });';
             //verifica se é scroll infinito
            if($bScroll!==true){
               $sRender .='$("#'.$aDadosAtualizar[0].' > tbody > tr").remove();'; 
            }
            
            $sRender .='$("#'.$aDadosAtualizar[0].'").append(\''.$sDados.'\');';
            
            $sRender .=' if (idTr!==""){$("#'.$aDadosAtualizar[0].' #"+idTr+"").focus();'
                       .' $("#'.$aDadosAtualizar[0].' #"+idTr+"").addClass("selected");}';
            
            
          
                      
            echo $sRender;
            $sDadosSummary = $this->getDadosFoot();
            $sSummary = '$("#'.$aDadosAtualizar[0].'-summary > tbody > tr").empty();'
                        .'$("#'.$aDadosAtualizar[0].'-summary > tbody > tr").append(\''.$sDadosSummary.'\');';
            echo $sSummary;
        }else{
           //retorna os dados
           $aDados[0]=$sDados;
           $aDados[1]=$iTotalReg;
           return $aDados;//$sDados; 
        }
        
    }
  /**
   * Método para buscar dados do foot das tabelas
   *
   */  
     public function getDadosFoot($aCamposParam=null,$bGridCampo=null,$aParam=null){
        foreach ($aParam as $value) {
           $aFiltro[] = explode(',',$value);
        }
        
         
        if ($bGridCampo){ 
            $aCampos = $aCamposParam;
        }else{    
        $this->View->criaConsulta();
        //verifica se há atributos de soma nos campos consulta
        $aCampos = $this->View->getTela()->getArrayCampos();
        }
        
        
         foreach ($aCampos as $key => $oCampoAtual){
           
             switch ($oCampoAtual->getSOperacao()) {
                 case 'soma':
                  $sTot.='<td class="td-destaque">';
                  $xValor = $this->Persistencia->getSoma($oCampoAtual->getSNome());
                  $sTot.='<b>'.$oCampoAtual->getSTituloOperacao().' '.'</b>'.number_format($xValor, 2, ',', '.'); 
                  $sTot.='</td>';
                  break;
                 case 'personalizado':
                  $sTot.='<td class="td-destaque">';
                  $xValor = $this->calculoPersonalizado($oCampoAtual->getSNome(),$aFiltro);
                  $sTot.=$xValor; 
                  $sTot.='</td>'; 

                 default:
                     break;
             }
             
             
             
      
        }
        
    
            
            
         
        
        return $sTot;
    }
    
    
    /**
     * Método que monta um resumo abaixo do grid 
     */
    public function getDadosResumo(){
        
    }

    /*
     * Carrega os dados da consulta por sql e não por model e persistencia
     */
    public function getDadosConsultaPorSql($sMetodoSqlPersistencia,$sMetodoCriaConsultaView='criaConsulta'){
        $this->Persistencia->setConsultaPorSql(true);
        
        $this->View->$sMetodoCriaConsultaView();
        
        $aCampos = $this->View->getTela()->getArrayCampos(); //captura os campos da consulta
        
        $this->Persistencia->setLimit($_REQUEST['limit']);
        $this->Persistencia->setOffset($_REQUEST['start']);
        
        //montagem dos filtros 
        if(isset($_REQUEST['filter'])){
            $aFiltros = json_decode($_REQUEST['filter']);
            $iTipoLigacao = Persistencia::LIGACAO_AND;
            $iTipoComparacao = Persistencia::IGUAL;
            
            foreach ($aFiltros as $oAtual) {
                switch ($oAtual->type){
                    case 'numeric':
                    case 'date':
                        switch ($oAtual->comparison){
                            case 'lt':
                                $iTipoComparacao = Persistencia::MENOR;
                            break;
                            case 'gt':
                                $iTipoComparacao = Persistencia::MAIOR;
                            break;
                            default:
                                $iTipoComparacao = Persistencia::IGUAL;
                            break;
                        }
                    break;
                    case 'list': 
                        $iTipoComparacao = Persistencia::GRUPO;
                    break;
                    case 'string':
                        $iTipoComparacao = Persistencia::CONTEM;
                    break;
                }
                
                if($oAtual->type === 'list'){
                    foreach($aCampos as $campoAtual){
                        if(strtolower($campoAtual->getNome()) === strtolower(str_replace("_", ".",$oAtual->field))){
                            $oAtual->field = $campoAtual->getCampoModelLista();
                            break;
                        }
                    }
                }
                
                $sCampoModel = str_replace("_", ".",$oAtual->field);
                $sCampoBanco = $this->Persistencia->getNomeBanco($sCampoModel);
                $sNomeTabela = "";
                $aCamposModel = explode(".",$sCampoModel);
                for($i=0;$i<(count($aCamposModel)-1);$i++){
                    if($i>0){
                        $sNomeTabela .= ".";
                    }
                    $sNomeTabela .= $aCamposModel[$i];
                }
                if($sNomeTabela!=""){
                    $sNomeTabela = '"'.$sNomeTabela.'"';
                }
                
                if(is_string($oAtual->value)){
                    $aTexto = explode(" ",$oAtual->value);
                    foreach ($aTexto as $value) {
                        $this->Persistencia->adicionaFiltro($sCampoBanco,utf8_decode($value),$iTipoLigacao,$iTipoComparacao,"",$sNomeTabela);
                    }
                } else{
                    $this->Persistencia->adicionaFiltro($sCampoBanco,$oAtual->value,$iTipoLigacao,$iTipoComparacao,"",$sNomeTabela);
                }
            }
        }
        
        //inclui os filtros adicionais definidos no controller específico
        $this->adicionaFiltrosExtras();
        
        //monta a ordenação da consulta pela chave caso não tenha sido definida
        if(sizeof($this->View->getOrderBy()) == 0){
            foreach($this->Persistencia->getChaveArray() as $oAtual){
               $this->Persistencia->adicionaOrderBy($oAtual->getNomeBanco());
            }
        } else{
            foreach ($this->View->getOrderBy() as $aOrderBy) {
                $sCampoBanco = str_replace("_", ".",$aOrderBy[0]->getNome());
                $this->Persistencia->adicionaOrderBy($sCampoBanco, $aOrderBy[1]);
            }
        }
        
        //monta o agrupamento da consulta
        foreach ($this->View->getGroupBy() as $oGroupBy) {
            $sCampoBanco = str_replace("_", ".",$oGroupBy->getNome());
            $this->Persistencia->adicionaGroupBy($sCampoBanco);
        } 
        
        $aDadosQuery = $this->Persistencia->$sMetodoSqlPersistencia(); //carrega os dados da consulta
        
        $aDados = array(); //inicializa o vetor que conterá os dados
        foreach($aDadosQuery as $oAtual){
            $aLinha = array(); //inicializa o vetor que conterá a linha atual
            
            //carrega os campos que serão mostrados na consulta
            foreach($aCampos as $campoAtual){
                if($campoAtual->getCamposCalculo() == null){
                    $sCampo = $campoAtual->getNome();
                    $xValor = $oAtual->$sCampo;
                    $aLinha[str_replace('.','_',$campoAtual->getNome())] = utf8_encode(str_replace("\n", "",$xValor)); 
                }
            }
            //$aLinha['chave'] = $this->Persistencia->getChaveModel($oAtual);

            $aDados[] = $aLinha;
        }
        
        $sDados = '{ "success": true,'
                   .'"total": "'.$this->Persistencia->getCount().'",'
                   .'"'.Base::ROOT_STORE.'": '.json_encode($aDados).'}';
        echo $sDados;
    }

    /**
     * Método de realiza a busca dos dados para preenchimento das opções
     * de campos combobox em tempo de execução
     */     
    public function getDadosCombobox(){
        $sCampoValor = $_REQUEST['campoValor'];
        $sCampoDescricao = $_REQUEST['campoDescricao'];
        
        //montagem do filtro
        $sCampoFiltro = $_REQUEST['campoFiltro'];
        $sValorFiltro = $_REQUEST['valorFiltro'];
        $aCampos = json_decode($sCampoFiltro);
        $iTipoLigacao = Persistencia::LIGACAO_AND;
        $iTipoComparacao = Persistencia::IGUAL;
        if(count($aCampos)>1){
            $aValores = json_decode($sValorFiltro);
            foreach ($aCampos as $ind => $campo){
                $sCampoBanco = $this->Persistencia->getNomeBanco($campo);
        
        //montagem dos filtros 
                $aTexto = explode(" ",trim($aValores[$ind]));
                foreach ($aTexto as $value) {
                    $this->Persistencia->adicionaFiltro($sCampoBanco,$value,$iTipoLigacao,$iTipoComparacao);
                }
            }
            $this->Persistencia->adicionaOrderBy($sCampoBanco);
        }
        else { 
            $sCampoBanco = $this->Persistencia->getNomeBanco($sCampoFiltro);

            //montagem dos filtros 
        $aTexto = explode(" ",trim($sValorFiltro));
        foreach ($aTexto as $value) {
            $this->Persistencia->adicionaFiltro($sCampoBanco,$value,$iTipoLigacao,$iTipoComparacao);
        }

            //adiciona a ordenação da listagem
            $this->Persistencia->adicionaOrderBy($sCampoBanco);
        }
        //inclui os filtros adicionais definidos no controller específico
        $this->adicionaFiltrosExtras();
        
        $sMetodoPersistencia = self::METODO_ARRAY_DADOS;
        $aModels = $this->Persistencia->$sMetodoPersistencia(); //carrega os dados 
        
        $aDados = array(); //inicializa o vetor que conterá os dados
        
        $sNomeClasse = $this->getNomeClasse();
        
        foreach($aModels as $oAtual){
            $aLinha = array(); //inicializa o vetor que conterá a linha atual
            
            $sClasseBusca = strtolower(substr($sCampoValor,0,strpos($sCampoValor,".")));
            if($sClasseBusca === strtolower($sNomeClasse)){
                $sCampoValor = substr($sCampoValor,strpos($sCampoValor,".")+1);
            }                        
            $aLinha[Campo::SELECT_VALOR] = utf8_encode(str_replace("\n", "",$this->getValorModel($oAtual,$sCampoValor))); 

            $sClasseBusca = strtolower(substr($sCampoDescricao,0,strpos($sCampoDescricao,".")));
            if($sClasseBusca === strtolower($sNomeClasse)){
                $sCampoDescricao = substr($sCampoDescricao,strpos($sCampoDescricao,".")+1);
            }                        
            $aLinha[Campo::SELECT_CONTEUDO] = utf8_encode(str_replace("\n", "",$this->getValorModel($oAtual,$sCampoDescricao))); 
            $aDados[] = $aLinha;
        }
        
        $sDados = '{ "'.Base::ROOT_STORE.'": '.json_encode($aDados).','
                   .'"total": "'.$this->Persistencia->getCount().'"}';
        echo header('Content-Type: application/javascript').$sDados;
    }
    
     /**
     * Método de realiza a busca dos dados para os campos descritivos das buscas 
     * durante a digitação do usuário
     */     
    public function getDadosBuscaCampo($sDados){
        //$sDados1 = $_REQUEST['parametros'];
        $aDados = explode(',', $sDados);
        
        //obtem o nome da classe do campo de busca (suggest)
        $sClasseBusca = substr($aDados[2],0,strpos($aDados[2],"."));
        //obtem o nome da classe atual para a realização de testes
        $sNomeClasse = $this->getNomeClasse();
        
         /*
         * se a classe do campo de filtro for igual a classe de busca faz o envio 
         * apenas do nome do campo no model para capturar o nome do campo
         * no banco, ou seja, envia sem a classe
         */
        if(strtolower($sClasseBusca) === strtolower($sNomeClasse)){
            $sCampoPk = substr($aDados[1],strpos($aDados[1],".")+1);
            $sCampoDesc = substr($aDados[2],strpos($aDados[2],".")+1);            
        } else{
            $sCampoPk = $aDados[1];
            $sCampoDesc = $aDados[2];    
        }
        
         
          
          $sCampoBanco = $this->Persistencia->getNomeBanco($sCampoDesc);
        
          //montagem do filtro
          $sFiltro = utf8_encode($aDados[0]);
         
          $iTipoLigacao = Persistencia::LIGACAO_AND;
          $iTipoComparacao = Persistencia::CONTEM;

            $aValoresFiltro = explode(" ",trim($sFiltro));
            
            foreach ($aValoresFiltro as $value) {
                $this->Persistencia->adicionaFiltro($sCampoBanco,$value,$iTipoLigacao,$iTipoComparacao);
            }
        
          //adiciona a ordenação da listagem
        $this->Persistencia->adicionaOrderBy($sCampoBanco);
        
        $sMetodoPersistencia = self::METODO_ARRAY_DADOS;
        $aModels = $this->Persistencia->$sMetodoPersistencia(); //carrega os dados 
        
        $aDadosSelect = array(); //inicializa o vetor que conterá os dados
        foreach($aModels as $oAtual){
            $aLinha = array(); //inicializa o vetor que conterá a linha atual
            $aLinha[0] = str_replace("\n", "",$this->getValorModel($oAtual,$sCampoPk)); 
            $aLinha[1] = str_replace("\n", "",$this->getValorModel($oAtual,$sCampoDesc)); 
            $aDadosSelect[] = $aLinha;
        }
        //remove os options
        $sSelect = "$('#".$aDados[3]." > option').remove();";
        foreach ($aDadosSelect as $key => $value) {
           $sSelect.="$('#".$aDados[3]."').append($('<option>', { "
                  ."value: ".$value[0].","
                  ."text: '".$value[1]."'"
                  ."}));";
        }                
                 
        echo $sSelect;
       
    }
    
   /**
     * Método de realiza a busca dos dados para os campos descritivos das buscas 
     * durante a digitação do usuário
     */     
    public function getDadosBusca($sDados){
        $aDados = explode(',', $sDados);     
        
        //obtem o nome da classe atual para a realização de testes
        $sNomeClasse = $this->getNomeClasse();
        
        //obtem o nome da classe do campo de busca (suggest)
        $sClasseBusca = substr($aDados[2],0,strpos($aDados[2],"."));
        
        /*
         * se a classe do campo de filtro for igual a classe de busca faz o envio 
         * apenas do nome do campo no model para capturar o nome do campo
         * no banco, ou seja, envia sem a classe
         */
        if(strtolower($sClasseBusca) === strtolower($sNomeClasse)){
            $sCampoValor = substr($aDados[3],strpos($aDados[3],".")+1);
            $sCampoDescricao = substr($aDados[2],strpos($aDados[2],".")+1);            
        } else{
            $sCampoValor = $aDados[3];
            $sCampoDescricao = $aDados[2];    
        }
        
        $sCampoBanco = $this->Persistencia->getNomeBanco($sCampoDescricao);
        
        //montagem do filtro
        $sFiltro = $aDados[4];
        $iTipoLigacao = Persistencia::LIGACAO_AND;
        $iTipoComparacao = Persistencia::CONTEM;
        
        $aValoresFiltro = explode(" ",trim($sFiltro));
        foreach ($aValoresFiltro as $value) {
            $this->Persistencia->adicionaFiltro($sCampoBanco,utf8_decode($value),$iTipoLigacao,$iTipoComparacao);
        }
        
        //inclui os filtros adicionais definidos no controller específico
        $this->adicionaFiltrosExtras();
        
        //adiciona a ordenação da listagem
        $this->Persistencia->adicionaOrderBy($sCampoBanco);
        
        $sMetodoPersistencia = self::METODO_ARRAY_DADOS;
        $aModels = $this->Persistencia->$sMetodoPersistencia(); //carrega os dados 
        
        $aDadosSelect = array(); //inicializa o vetor que conterá os dados
        foreach($aModels as $oAtual){
            $aLinha = array(); //inicializa o vetor que conterá a linha atual
            $aLinha[0] = str_replace("\n", "",$this->getValorModel($oAtual,$sCampoValor)); 
            $aLinha[1] = str_replace("\n", "",$this->getValorModel($oAtual,$sCampoDescricao)); 
            $aDadosSelect[] = $aLinha;
        }
        //remove os options
        $sSelect = "$('#".$aDados[1]." > option').remove();";
       
       //pega a primeira posição do array e coloca no campo código e no valor do campo select
        $aDadosInicial = $aDadosSelect[0];
        //percorre para colocar o valor inicial
           if(count($aDadosSelect)==1){
              $sSelect  .= "$('#".$aDados[1]."')"
                        .".find('option')"
                        .".end()"
                       // .".append('<option value=\'$aDadosInicial[0]\'>$aDadosInicial[1]</option>')"
                        .".val('whatever');"
                        ."$('#select2-".$aDados[1]."-container')"
                        ."        .empty()"
                        ."        .html('$aDadosInicial[1]')"
                        ."        .attr({"
                        ."            title:'$aDadosInicial[1]'"
                        ."         });"
                        ."$('#".$aDados[0]."').val(". $aDadosInicial[0].");"; 
               //retira o primeiro elemento pois ja foi renderizado
               array_shift($aDadosSelect);
           }                 
            
      
        
       
        
        
        
        
        foreach ($aDadosSelect as $key => $value) {
           $sSelect.="$('#".$aDados[1]."').append($('<option>', { "
                  ."value: ".$value[0].","
                  ."text: '".$value[1]."'"
                  ."}));";
        }                
                 
        echo $sSelect;
    
    }
   /**
     * Método que realiza buscas livres nos campos
     *
     *
     * 
     */     
    public function getValorBuscaPk($sDados){
       $aDados = explode(',', $sDados);
       $sValorFiltro = $aDados[0];
       $sCampoRetCod = $aDados[1];
       $sCampoBusca = $aDados[2];
       $sCampoFiltro = $aDados[3];
       $sCampoRetorno = $aDados[4];
       $sNomeClasse = $this->getNomeClasse();
            /*
             * se a classe do campo de filtro for igual a classe de busca ou não 
             * estiver presente na lista de classes de ligação, faz o envio 
             * apenas o nome do campo no model para capturar o nome do campo
             * no banco, ou seja, envia sem a classe
             */
       $sClasseBusca = strtolower(substr($sCampoFiltro,0,strpos($sCampoFiltro,".")));
        if($sClasseBusca === strtolower($sNomeClasse) || !$this->Persistencia->pertenceListaJoin($sClasseBusca)){
                $sCampoFiltro = substr($sCampoFiltro,strpos($sCampoFiltro,".")+1);
            } 
       
            $sCampoBanco = $this->Persistencia->getNomeBanco($sCampoFiltro);
            
            $iTipoLigacao = Persistencia::LIGACAO_AND;
            $iTipoComparacao = Persistencia::IGUAL;
            $this->Persistencia->adicionaFiltro($sCampoBanco,$sValorFiltro,$iTipoLigacao,$iTipoComparacao);
            //adiciona filtro adicionais se for necessário
            $this->antesValorBuscaPk();
            
            
        
            $sMetodoPersistencia = self::METODO_ARRAY_DADOS;
            $aModels = $this->Persistencia->$sMetodoPersistencia(); //carrega os dados 
        
            if(count($aModels) > 0){
                $sCampoRet = substr($sCampoBusca,strpos($sCampoBusca,".")+1);
                $sRetorno = str_replace("\n", "",$this->getValorModel($aModels[0],$sCampoRet)); 
                
                //monta a renderização do componente
                $sRender ="$('#".$sCampoRetorno."').val('".$sRetorno."');";
                echo $sRender;
        } else{
            
            $sMsgErro = new Mensagem('Código Inexistente', 'O código informado não existe', Mensagem::TIPO_ERROR);
           // $sRender.=$sMsgErro->getRender();
           // echo $sRender;
            //limpa campo descriçao
            $sLimpa ="$('#".$sCampoRetorno."').val('');";
            echo $sLimpa;
        }
       
    }                         

    /**
     * Método de realiza a busca do valor para o campo descritivo da busca
     * quando o usuário preencher o campo que contêm a busca
     * Este método é executado no momento em que o campo perde o foco
     *
     *
     * 
     */     
    public function getValorBusca($sDados){
       $aDados = explode(',', $sDados);
       $sValorFiltro = $aDados[0];
       $sCampoRetCod = $aDados[1];
       $sCampoBusca = $aDados[2];
       $sCampoFiltro = $aDados[3];
       $sCampoRetorno = $aDados[4];
       $sNomeClasse = $this->getNomeClasse();
            /*
             * se a classe do campo de filtro for igual a classe de busca ou não 
             * estiver presente na lista de classes de ligação, faz o envio 
             * apenas o nome do campo no model para capturar o nome do campo
             * no banco, ou seja, envia sem a classe
             */
       $sClasseBusca = strtolower(substr($sCampoFiltro,0,strpos($sCampoFiltro,".")));
        if($sClasseBusca === strtolower($sNomeClasse) || !$this->Persistencia->pertenceListaJoin($sClasseBusca)){
                $sCampoFiltro = substr($sCampoFiltro,strpos($sCampoFiltro,".")+1);
            } 
       
            $sCampoBanco = $this->Persistencia->getNomeBanco($sCampoFiltro);
            
            $iTipoLigacao = Persistencia::LIGACAO_AND;
            $iTipoComparacao = Persistencia::IGUAL;
            $this->Persistencia->adicionaFiltro($sCampoBanco,$sValorFiltro,$iTipoLigacao,$iTipoComparacao);
            
              //inclui os filtros adicionais definidos no controller específico
            $this->adicionaFiltrosExtras();
        
            $sMetodoPersistencia = self::METODO_ARRAY_DADOS;
            $aModels = $this->Persistencia->$sMetodoPersistencia(); //carrega os dados 
        
            if(count($aModels) > 0){
                $sCampoRet = substr($sCampoBusca,strpos($sCampoBusca,".")+1);
                $sRetorno = str_replace("\n", "",$this->getValorModel($aModels[0],$sCampoRet)); 
                //monta a renderização do componente
                $sRender = "$('#".$sCampoRetorno."')"
                        .".find('option')"
                       // .".remove()"
                        .".end()"
                        .".append('<option value=\'$sValorFiltro\'>$sRetorno</option>')"
                        .".val('whatever');"
                        ."$('#select2-".$sCampoRetorno."-container')"
                        ."        .empty()"
                        ."        .html('$sRetorno')"
                        ."        .attr({"
                        ."            title:'$sRetorno'"
                        ."         });";
                echo $sRender;
        } else{
             $sRender = "$('#".$sCampoRetorno."')"
                        .".find('option')"
                       // .".remove()"
                        .".end()"
                        .".append('<option value=\'\'></option>')"
                        .".val('whatever');"
                        ."$('#select2-".$sCampoRetorno."-container')"
                        ."        .empty()"
                        ."        .html('')"
                        ."        .attr({"
                        ."            title:''"
                        ."         });";
                
            $sMsgErro = new Mensagem('Código Inexistente', 'O código informado não existe', Mensagem::TIPO_ERROR);
            $sRender.=$sMsgErro->getRender();
            echo $sRender;
            //$sRender = $sMsgErro->getRender();
        }
       
    }
    
    /**
     * Método de realiza a busca dos dados a serem listados no grid de 
     * detalhamento para telas que tiverem objetos do tipo FormGrid
     * 
     * @param object $oFormGrid Objeto do tipo FormGrid
     */    
    public function carregaDadosGridDetalhe($oFormGrid){
        //carrega a chave do objeto mestre
        $aChaveMestre = $this->Persistencia->getChaveArray();

        /*
         * obtem o nome da classe mestre para compor o nome do atributos
         * a string inicial "Controller" é ignorada neste caso
         */
        $sNomeClasse = $this->getNomeClasse();

        /*
         * carrega a chave do objeto mestre no objeto de detalhamento e
         * adiciona os campos na cláusula where para fazer filtros se existirem
         * buscas para campos de autoincremento
         */
        foreach ($aChaveMestre as $oCampoChave) {
            $sNomeModel = $oCampoChave->getNomeModel();
            $sNomeBanco = $oCampoChave->getNomeBanco();

            $xValor = $this->getValorModel($this->Model,$sNomeModel);

            $this->setValorModel($this->ControllerDetalhe->Model,$sNomeClasse.".".$sNomeModel,$xValor);
            $this->ControllerDetalhe->Persistencia->adicionaFiltro($sNomeBanco,$xValor);
        }
        
        //monta a ordenação da consulta
        foreach($this->ControllerDetalhe->Persistencia->getChaveArray() as $oAtual){
            $this->ControllerDetalhe->Persistencia->adicionaOrderBy($oAtual->getNomeBanco());
        }
        
        //caputura os campos do objeto
        $aCampos = $oFormGrid->getFieldSet()->getCampos();
        
        //carrega os dados do grid
        $sMetodoPersistencia = self::METODO_ARRAY_DADOS;
        $aModels = $this->ControllerDetalhe->Persistencia->$sMetodoPersistencia(); 
        
        //carrega o array que conterá os registros do grid
        $aDados = array(); 
        foreach($aModels as $oAtual){
            $aLinha = array(); //inicializa o vetor que conterá a linha atual
            
            //carrega os campos que serão mostrados na consulta
            foreach($aCampos as $campoAtual){
                if($campoAtual->getCamposCalculo() == null){
                    $aLinha[str_replace('.','_',$campoAtual->getNome())] = utf8_encode(str_replace("\n", "",$this->getValorModel($oAtual, $campoAtual->getNome()))); 

                    //carrega a descrição do campo tipo select quando definido o campo da descrição
                    if($campoAtual->getValorTipo() === Campo::TIPO_SELECT){
                        if($campoAtual->getCampoDescricao() != null){
                            $sCampoTextoCombo = $campoAtual->getCampoDescricao();
                            $sDescricao = $this->getValorModel($oAtual,$sCampoTextoCombo);
                        } else{
                            $aItems = $campoAtual->getItems();
                            $xValor = $aLinha[str_replace('.','_',$campoAtual->getNome())];
                            $sDescricao = $aItems[$xValor][0];
                        }
                        $aLinha[str_replace('.','_',$campoAtual->getNome()).Base::COMPLETA_NOME_COMBO_GRID] = utf8_encode(str_replace("\n", "",$sDescricao)); 
                    }
                }
            }
            $aDados[] = $aLinha;
        }
        $oFormGrid->getGrid()->addDados('{"'.Base::ROOT_STORE.'": '.json_encode($aDados).'}');
    }
    
    /**
     * Método que gera o arquivo pdf das consultas
     */
    public function getPdf(){
        $sTitulo = $_REQUEST['titulo'];
        $aColunas = $_REQUEST['colunas'];
        $aTotalizador = json_decode($_REQUEST['summary'],true);
        
        $aDados = $this->getDadosConsulta(true);
        
        $oPDF = new PDF($sTitulo);
        $oPDF->addColunas($aColunas);
        $oPDF->setDados($aDados);
        
        if(isset($_REQUEST['group'])){
            $oPDF->setAgrupamento($_REQUEST['group']); 
        }

        if($aTotalizador){
            $oPDF->setTotalizador($aTotalizador);
        }

        $oPDF->getPDF();
    }
    
    /**
     * Método responsável por retornar o objeto View (tela) solicitado
     * 
     * @param String Nome da classe que terá a tela retornada
     * @param string $sParametrosCriaTela String contendo os parâmetros utilizados
     *                                    no método criaTela dos objetos View
     *                                    devidamente separados por vírgula
     * 
     * @return Object Objeto View solicitado
     */
    public function getTelaExterna($sClasse, $sParametrosCriaTela = ""){
        $oView = Fabrica::FabricarView($sClasse);
        call_user_func_array(array($oView,'criaTela'),explode(',',$sParametrosCriaTela));
        
        return $oView->getTela();
    }

    /** aqui este método não faz nada, mas é sobrescrito pelas classes filhas
     *  para fazer outras ações dentro da mesma transação
     * @return boolean
     */
    public function beforeInsert(){
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    /** aqui este método não faz nada, mas é sobrescrito pelas classes filhas
     *  para fazer outras ações dentro da mesma transação
     * @return boolean
     */
    public function afterInsert(){
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    /** aqui este método não faz nada, mas é sobrescrito pelas classes filhas
     *  para fazer outras ações dentro da mesma transação
     * @return boolean
     */
    public function afterUpdate(){
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function beforeUpdate(){
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    /** aqui este método não faz nada, mas é sobrescrito pelas classes filhas
     *  para fazer outras ações dentro da mesma transação
     * @return boolean
     */
    public function afterDelete(){
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function beforeDelete(){
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    /**
     * aqui este método não faz nada, mas é sobrescrito pelas classes filhas
     * para fazer outras ações após o fechamento da transação
     * @return boolean
     */
    public function afterCommitInsert(){
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function afterCommitUpdate(){
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function afterCommitDelete(){
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
   /**
     * Método que define se vai chamar a inclusão ou alteração de um registro no banco
    * 0- formAnterior
    * 1- form de consulta
    * 2- id da etapa para seletor
    * 3- id da etapa para alterar a próxima
    * 4- id da body da tela
    * 5- id para fechar tela
     */ 
    public function acaoDetalhe($sDados){      
         $aDados = explode(',', $sDados); 
         //gera array
          $sChave = htmlspecialchars_decode($_REQUEST['campos']);
          $aCamposChave = array();
          parse_str($sChave,$aCamposChave);


        //carrega o model
         $this->carregaModel();
         
         
         $this->adicionaFiltrosExtras();
         
       
         if($aCamposChave['acao']=='incluir'){
            $this->acaoIncluir($sDados,true);
         }else
         {
             $this->acaoAlterar($sDados,true);
         }
        }
        /**
     * Método que define se vai chamar a inclusão ou alteração de um registro no banco
    * 0-form
    * 1-id do focus
     */ 
    public function acaoDetalheIten($sDados,$sCampos){      
        //adiciona filtro da chave primária
         $this->parametros = $sCampos;
         //carrega o model
         $this->carregaModel();
         
         $this->adicionaFiltrosExtras();
         //adiciona o filtro da sequencia do detalhe
         $this->adicionaFiltroDet();
         
         $iCont=  $this->Persistencia->getCount();
         //limpa os filtros
         $this->Persistencia->limpaFiltro();
         //verifica se há validacao no lado do servidor
         $this->getVal($sDados.','.$iCont);
          //limpa os filtros
         $this->Persistencia->limpaFiltro();
         //se cont = 0 segue ação incluir
         if($iCont==0){
            $this->acaoIncluirDet($sDados,$sCampos);
         }else
         {
          $this->acaoAlterarDet($sDados,$sCampos);
         }
        }
    /**
     * Método que chama a tela de detalhe renderizando somente o form e não a tela 
     * 
     */
    public function acaoTelaDetalhe($sDados,$sCampos){
        
        $aDados = explode(',',$sDados);
        $aCampos = explode(',',$sCampos);
        $this->parametros = $aCampos;
        //retorno model com os dados da consulta
        $this->pkDetalhe($aCampos);
        
        $this->View->setSIdHideEtapa($aDados[4]);
        
        $this->adicionaFiltrosExtras();
        
        $this->View->setSRotina(View::ACAO_INCLUIR);
        $this->antesDeCriarTela();
        $this->View->criaTela();
        $this->View->getTela()->setSRender($aDados[3]);
        //define o retorno somente do form
        $this->View->getTela()->setBSomanteForm(true);
         //função autoincremento
        $this->funcoesAutoIncremento();
        //adiciona botões na tela de detalhe
        $this->View->adicionaBotoesDet($aDados[2],$aDados[0],$aDados[4],$aDados[5],$aDados[1]);
       
         //seta o controler na view
        $this->View->setTelaController($this->View->getController());
        $this->View->getTela()->getRender();
       
    }
    /**
     * Método para cria a tela do painel financeiro
     */
    public function criaPainelFinanceiro($sDados,$sCampos){
     $aDados = explode(',', $sDados);
     $aCampos = explode(',', $sCampos);
     $this->pkDetalhe($aCampos);
     $this->parametros = $sCampos;
    
     $this->View->criaTela();
     $this->View->getTela()->setSRender($aDados[3]);
     //define o retorno somente do form
     $this->View->getTela()->setBSomanteForm(true);
     //seta o controler na view
     $this->View->setTelaController($this->View->getController());
     $this->View->adicionaBotoesEtapas($aDados[0],$aDados[1],$aDados[2],$aDados[3],$aDados[4],$aDados[5],$this->getControllerDetalhe());
     $this->View->getTela()->getRender();
    }

    /**
     * Método que realiza a inclusão das informações contidas no 
     * objeto no banco de dados
     * 
     * @param string $sId ID do objeto
     * @param string $sCampoFoco Id do campo que receberá o foco após limpar
     * @param string $sAutoIncremento String contendo o id dos campos que devem
     *                                ter seu valor incrementado
     * @param string $sAcoesExtras Ações extras a serem executadas após a gravação
     * @param boolean Define se origina de um boolean
     */    
    public function acaoIncluir($sId,$bDetalhe=null){
        $this->Persistencia->limpaFiltro();
        $aDados =  explode(',', $sId);
        $sForm = $aDados[0];
        $sGrid = $aDados[1].'consulta';
        $sCampoInc = $aDados[2];
        $this->Persistencia->iniciaTransacao();
       // $this->Persistencia->lim
        //array de controle de erros
        $aRetorno[0] = true;
        $this->antesDeCriarTela();
        $this->View->criaTela();
        $aCamposTela = $this->View->getTela()->getCampos();
        $this->carregaModel($aCamposTela);
        
       
        
        $aRetorno = $this->beforeInsert();
        
        if($aRetorno[0]){
              $aRetorno = $this->Persistencia->inserir();
        }
               
        if($aRetorno[0]){
              $aRetorno = $this->afterInsert();
              $this->Persistencia->commit();
         }
         //muda variável de controle para alterar
         $setAlt = "$('#".$aDados[6]."').val('alterar');";
         echo $setAlt;
         //instancia a classe mensagem
         if($aRetorno[0]){
          $oMsg = new Mensagem('Sucesso!', 'Registro inserido com sucesso...', Mensagem::TIPO_SUCESSO);
          echo $oMsg->getRender();
          //Atualiza o Grid
         //   $this->getDadosConsulta($aDados[1],false,null);
            echo"$('#".$aDados[1]."-pesq').click();";
          //chama o método para zerar os campos do form se não for detalhe
            if(!$bDetalhe){
              //limpa uploads se necessário
              $this->limpaUploads($aDados);
              $oLimpa = new Base();
              //retorna aut incremento
              $iAutoInc = $this->retornaValuInc();                
              //monta a mensagem
              $msg ="".$oLimpa->limpaForm($sForm).""
                ."".$this->View->getAutoIncremento($sCampoInc,$iAutoInc)."";
              echo $msg;
              //verifica se o campo precisa ser fechado após dar um confirma
              if($this->View->getTela()->getBFecharTelaIncluir()){
                //BASE PARA FECHAR
                $oBase = new Base();
                //provisório para fechar a tela
                 $msg.="$('#".$sForm."-msg').append('<script>".$oBase->fechaForm($sForm).''.$oBase->openGrid($sGrid)."</script>');";
                 echo $msg;
               } 
            }
            //se for detalhe muda posição da etapa
            if($bDetalhe){
              $oEtapa = new Base();
              $sNextEtapa = $oEtapa->nextEtapa($aDados[2],$aDados[3]);
              echo $sNextEtapa;
              //da um hide no form
              $sFormHide = $oEtapa->formhide($aDados[0]);
              echo $sFormHide;
              
            }   
         } else {
             $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
             echo $oMsg->getRender();
         }
         
         //se for detalhe vai renderizar a tela de detalhe
            if($bDetalhe){
              $sClasseDetalhe = $this->getControllerDetalhe();
              $sMetodoDetalhe = $this->getSMetodoDetalhe();
              //método para capturar campos para levar para outra etapa, geralmente pk e informativos
              $sCampos = implode(',', $this->montaProxEtapa());
              //passa id da etapa,id do processo,id do form,valor chavepk
              echo 'requestAjax("","'.$sClasseDetalhe.'","'.$sMetodoDetalhe.'","'.$aDados[2].','.$aDados[3].','.$aDados[0].','.$aDados[4].','.$aDados[5].','.$aDados[1].'","'.$sCampos.'");'; 
            }
        }
    
    /**
     * Método para incluir dados nas tabelas detalhe
     */
     public function acaoIncluirDet($sId,$sCampos){
        $aDados =  explode(',', $sId);
        $this->parametros = $sCampos;
        $sForm = $aDados[0];
        $sCampoInc = $aDados[1];
        //adiciona filtros extras
        $this->adicionaFiltrosExtras();
        //necessidade de colocar novos filtros mas limpa os anteriores
        $this->adicionaFiltroDet2();
        
        
        $this->Persistencia->iniciaTransacao();
        
        //array de controle de erros
        $aRetorno[0] = true;
        
        $this->carregaModel();
        
        $aRetorno = $this->beforeInsert();
        
        if($aRetorno[0]){
              $aRetorno = $this->Persistencia->inserir();
        }
               
        if($aRetorno[0]){
              $aRetorno = $this->afterInsert();
              $this->Persistencia->commit();
         }
         //instancia a classe mensagem
         if($aRetorno[0]){
          $oMsg = new Mensagem('INSERIDO COM SUCESSO', 'Seu registro foi inserido!', Mensagem::TIPO_SUCESSO);
          //chama o método para zerar os campos do form se não for detalhe
          //Limpar o form é tratado na controller filhos
            $this->acaoLimpar($sForm,$sCampos);
            //método que executa após limpar
            $this->afterResetForm($sDados);
            
            //retorna aut incremento
            $iAutoInc = $this->retornaValuInc();                
            //monta a mensagem
            
            $msg ="".$this->View->getAutoIncremento($sCampoInc,$iAutoInc)."";
            echo $msg;
            echo $oMsg->getRender();
            $this->getDadosConsulta($aDados[2],true,null);
            $oFocus = new Base();
            echo $oFocus->focus($aDados[3]);
            
            
            //monta os filtros
         } else {
             $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
             echo $oMsg->getRender();
         }
      
       
         
        }
        
        /**
         * Método para alterar detalhe
         */
         /**
     * Método para incluir dados nas tabelas detalhe
     */
     public function acaoAlterarDet($sId,$sCampos){
        $aDados =  explode(',', $sId);
        $this->parametros = $sCampos;
        $sForm = $aDados[0];
        $sCampoInc = $aDados[1];
        $aRetorno[0] = true;
         //adiciona filtros extras
        $this->adicionaFiltrosExtras();
        //necessidade de colocar novos filtros mas limpa os anteriores
        $this->adicionaFiltroDet2();
        
        $this->Persistencia->iniciaTransacao();

        $aChaveMestre = $this->Persistencia->getChaveArray();
        foreach($aChaveMestre as $oCampoBanco){
            if($oCampoBanco->getPersiste()){
                $this->setValorModel($this->Model,$oCampoBanco->getNomeModel());
            }
        }
        
        $this->Model = $this->Persistencia->consultar();
       
        $this->carregaModel();
        
         if($aRetorno[0]){
            $aRetorno = $this->beforeUpdate();
        }
        
        if($aRetorno[0]){
            $aRetorno = $this->Persistencia->alterar();
        }
        
        if($aRetorno[0]){
            $aRetorno = $this->afterUpdate();
        }
         if($aRetorno[0]){

            $this->Persistencia->commit();
            
            $aRetorno = $this->afterCommitUpdate();
         }
         
          //instancia a classe mensagem
         if($aRetorno[0]){
          $oMsg = new Mensagem('ALTERADO COM SUCESSO', 'Seu registro foi inserido!', Mensagem::TIPO_INFO);
          //chama o método para zerar os campos do form se não for detalhe
          
            $this->acaoLimpar($sForm, $sCampos);
            
            //funcao após limpar o form
            $this->afterResetForm($sId);
            
            //retorna aut incremento
            $iAutoInc = $this->retornaValuInc();                
            //monta a mensagem
            //$msg ="".$oLimpa->limpaFormDetail($sForm).""
            $msg = "".$this->View->getAutoIncremento($sCampoInc,$iAutoInc)."";
            echo $msg;
            echo $oMsg->getRender();
            $this->getDadosConsulta($aDados[2],TRUE,null);
            //gera a atualização do grid
            //monta os filtros
         } else {
             $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
         }
      
       
        //adiciona filtros extras
      /*  $this->adicionaFiltrosExtras();
        $this->Persistencia->iniciaTransacao();
        
        //array de controle de erros
        $aRetorno[0] = true;
        
        $this->carregaModel();
        
        $aRetorno = $this->beforeInsert();
        
        if($aRetorno[0]){
              $aRetorno = $this->Persistencia->inserir();
        }
               
        if($aRetorno[0]){
              $aRetorno = $this->afterInsert();
              $this->Persistencia->commit();
         }
         //instancia a classe mensagem
         if($aRetorno[0]){
          $oMsg = new Mensagem('INSERIDO COM SUCESSO', 'Seu registro foi inserido!', Mensagem::TIPO_SUCESSO);
          //chama o método para zerar os campos do form se não for detalhe
          
            $oLimpa = new Base();
            
            //retorna aut incremento
            $iAutoInc = $this->retornaValuInc();                
            //monta a mensagem
            $msg ="".$oLimpa->limpaFormDetail($sForm).""
              ."".$this->View->getAutoIncremento($sCampoInc,$iAutoInc)."";
            echo $msg;
            echo $oMsg->getRender();
            $this->getDadosConsulta($aDados[2],false,null);
            //gera a atualização do grid
            //monta os filtros
         } else {
             $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
         }
      
     */
         
        }
        
    /**
     * Método que inclui os registros necessários para que o controlador
     * principal possa executar a inclusão
     */
    public function acaoIncluirDependencias(){
        //array de controle de erros
        $aRetorno[0] = true;
        
        foreach ($this->getControllerDependente() as $oController) {
            $iCamposValor = $oController['controller']->carregaCampoObjetoModel($oController['campoModelPrincipal']);
            
            if($iCamposValor > 0){
                $aRetorno = $oController['controller']->beforeInsert();
                if(!$aRetorno[0]){
                    break;
                }

                //insere o registro no banco de dados
                $aRetorno = $oController['controller']->Persistencia->inserir();
                if(!$aRetorno[0]){
                    break;
                }

                //carrega o objeto no controlador principal
                $sMetodoSetter = Fabrica::montaSetter($oController['campoModelPrincipal']);
                $this->Model->$sMetodoSetter($oController['controller']->Model);

                $aRetorno = $oController['controller']->afterInsert();
                if(!$aRetorno[0]){
                    break;
                }
            }
        }
        return $aRetorno;
    }


    /**
     * Método que realiza a inclusão das informações contidas no 
     * objeto de detalhamento do registro principal (1 x N)
     * 
     * @param integer $iAcao Ação que está sendo executada
     *                       0 = Incluir
     *                       1 = Alterar
     * @return array Array contendo as informações sobre a execução das operações
     */    
    public function acaoIncluirDetalhe(){
        //carrega a chave do objeto mestre
        $aChaveMestre = $this->Persistencia->getChaveArray();
        
        if($this->View->getRotina() === View::ROTINA_INCLUIR){
            /* 
             * Cria um vetor contendo o nome dos campos chave do objeto mestre
             * para ser utilizado como parâmetro no WHERE do Sql
             */
            $aColunas = array();
            foreach ($aChaveMestre as $oCampo) {
                $aColunas[] = $oCampo->getNomeBanco();
                
                if(!$oCampo->getAutoIncremento()){
                    $this->Persistencia->adicionaFiltro($oCampo->getNomeBanco(),$this->getValorModel($this->Model,$oCampo->getNomeModel()));
                }
            }

            //busca o último registro inserido na tabela mestre 
            $oUltimo = $this->Persistencia->getUltimo($aColunas);
        }
        
        /*
         * obtem o nome da classe mestre para compor o nome do atributos
         * a string inicial "Controller" é ignorada neste caso
         */
        $sNomeClasse = $this->getNomeClasse();
        
        /*
         * carrega a chave do objeto mestre no objeto de detalhamento e
         * adiciona os campos na cláusula where para fazer filtros se existirem
         * buscas para campos de autoincremento
         */
        foreach ($aChaveMestre as $oCampoChave) {
            $sNomeModel = $oCampoChave->getNomeModel();
            $sNomeBanco = $oCampoChave->getNomeBanco();
            
            $xValor = $this->View->getRotina() === View::ROTINA_INCLUIR ? $oUltimo->$sNomeBanco : $this->getValorModel($this->Model,$sNomeModel);
            
            $this->setValorModel($this->ControllerDetalhe->Model,$sNomeClasse.".".$sNomeModel,$xValor);
            $this->ControllerDetalhe->Persistencia->adicionaFiltro($sNomeBanco,$xValor);
        }
            
        //carrega os registros de detalhamento
        $aRecords = json_decode($_REQUEST['records'],true);
        
        //array de controle de erros
        $aRetorno[0] = true;
        
        //loop de gravação dos registros secundários
        foreach ($aRecords as $oRecord) {
            //se necessario muda o $oRecord
            $oRecord = $this->manipulaDetalhe($oRecord);
            //carrega as informações do objeto de detalhamento
            $this->carregaModelArray($oRecord,true);
            
            $aRetorno = $this->ControllerDetalhe->Persistencia->inserir();
            
            //se ocorrer erro para a execução do laço
            if(!$aRetorno[0]){
                break;
            }
        }
        return $aRetorno;
    }

    /**
     * Método que realiza a atualização das informações contidas no 
     * objeto no banco de dados
     * 
     * @param string $sId ID do objeto
     * @param string $sCampoFoco Id do campo que receberá o foco após limpar
     */    
    public function acaoAlterar($sId,$bDetalhe=null){
       $aDados =  explode(',', $sId);
       $sForm = $aDados[0];
       $sGrid = $aDados[1].'consulta';
       $aRetorno[0] = true;
        
       $this->antesDeCriarTela();
       //cria a tela
        $this->View->criaTela();
        //traz lista campos
        $aCamposTela = $this->View->getTela()->getCampos();
        
        $this->Persistencia->iniciaTransacao();

        $aChaveMestre = $this->Persistencia->getChaveArray();
        foreach($aChaveMestre as $oCampoBanco){
            if($oCampoBanco->getPersiste()){
                $this->setValorModel($this->Model,$oCampoBanco->getNomeModel());
            }
        }
        $this->Model = $this->Persistencia->consultar();
        $this->antesCarregarModel();
        $this->carregaModel($aCamposTela);
        
        //alterar dependências
        $aRetorno = $this->acaoAlterarDependencias();
        
        if($aRetorno[0]){
            $aRetorno = $this->beforeUpdate();
        }
        
        if($aRetorno[0]){
            $aRetorno = $this->Persistencia->alterar();
        }
        
        if($aRetorno[0]){
            $aRetorno = $this->afterUpdate();
        }
        
        
        
         if($aRetorno[0]){

            $this->Persistencia->commit();
            
            $aRetorno = $this->afterCommitUpdate();
            if($aRetorno[0]){
                $sAcoesExtras = $aRetorno[2];
            }
            if(!$this->View->getBTela()){
            //BASE PARA FECHAR
            $oBase = new Base();
            //provisório para fechar a tela
             $msg.="$('#".$sForm."-msg').append('<script>".$oBase->fechaForm($sForm).''.$oBase->openGrid($sGrid)."</script>');";
             echo $msg;
            } 
            //MENSAGEM SUCESSO
             $oMsg = new Mensagem('Sucesso!', 'Seu registro foi alterado com sucesso...', Mensagem::TIPO_SUCESSO); 
             echo $oMsg->getRender();
             
            
            //Atualiza o Grid se não for detalhe
           // if(!$bDetalhe){
            // echo $oBase->sendFiltro($aDados[1],  $this->View->getController());
              echo"$('#".$aDados[1]."-pesq').click();";
          //  }
            
            
            if($bDetalhe){
                $oEtapa = new Base();
                $sNextEtapa = $oEtapa->nextEtapa($aDados[2],$aDados[3]);
                echo $sNextEtapa;
                //da um hide no form
                $sFormHide = $oEtapa->formhide($aDados[0]);
                echo $sFormHide;
                //chama o método para criar as outra tela
                $sClasseDetalhe = $this->getControllerDetalhe();
                $sMetodoDetalhe = $this->getSMetodoDetalhe();
           //método para capturar campos para levar para outra etapa, geralmente pk e informativos
           $sCampos = implode(',', $this->montaProxEtapa());
           //passa id da etapa,id do processo,id do form,valor chavepk
          //  echo 'requestAjax("","'.$sClasseDetalhe.'","acaoTelaDetalhe","'.$aDados[2].','.$aDados[3].','.$aDados[0].','.$aDados[4].','.$aDados[5].'","'.$sCampos.'");';
            echo 'requestAjax("","'.$sClasseDetalhe.'","'.$sMetodoDetalhe.'","'.$aDados[2].','.$aDados[3].','.$aDados[0].','.$aDados[4].','.$aDados[5].','.$aDados[1].'","'.$sCampos.'");'; 
          }   
        } else{        
            $this->Persistencia->rollback();
            $oMsg = new Mensagem('Erro!', 'Seu registro não foi alterado.', Mensagem::TIPO_ERROR); 
            echo $oMsg->getRender();
        }
      /*
       *  $msg ="$('#".$sId."-msg').append('".$oMsg->getRender()."');"
              ."".$oMsg->getSId()."();"
              ."".$oLimpa->limpaForm($sId)."";
       */
    }
    
    /**
     * Método que altera os registros de dependência relacionados ao controlador
     * principal
     */
    public function acaoAlterarDependencias(){
        //array de controle de erros
        $aRetorno[0] = true;
        
        foreach ($this->getControllerDependente() as $oController) {
            $iCamposValor = $oController['controller']->carregaCampoObjetoModel($oController['campoModelPrincipal']);
            
            if($iCamposValor > 0){
                $sMetodoGetter = Fabrica::montaGetter($oController['campoModelPrincipal']);
                $oModel = $this->Model->$sMetodoGetter();

                //carrega a chave do objeto do controlador principal
                $aChave = $oController['controller']->Persistencia->getChaveArray();

                $bExiste = true;
                foreach ($aChave as $oCampoBanco){
                    if($oCampoBanco->getPersiste()){
                        $sMetodoGetter = Fabrica::montaGetter($oCampoBanco->getNomeModel());
                        $sMetodoSetter = Fabrica::montaSetter($oCampoBanco->getNomeModel());
                        
                        $xValor = $oModel->$sMetodoGetter();
                
                        if(!$xValor){
                            $bExiste = false;
                            break;
                        }
                        
                        $oController['controller']->Model->$sMetodoSetter($xValor);
                    }
                }
                
                //checa se o registro já existe para alterar
                if($bExiste){
                    $aRetorno = $oController['controller']->beforeUpdate();
                    if(!$aRetorno[0]){
                        break;
                    }    

                    //atualiza o registro no banco de dados
                    $aRetorno = $oController['controller']->Persistencia->alterar();
                    if(!$aRetorno[0]){
                        break;
                    }

                    $aRetorno = $oController['controller']->afterUpdate();
                    if(!$aRetorno[0]){
                        break;
                    } 
                } else{ //o registro dependente pode não existir neste caso cria ao invés de alterar
                    $aRetorno = $oController['controller']->beforeInsert();
                    if(!$aRetorno[0]){
                        break;
                    }

                    //insere o registro no banco de dados
                    $aRetorno = $oController['controller']->Persistencia->inserir();
                    if(!$aRetorno[0]){
                        break;
                    }

                    //carrega o objeto no controlador principal
                    $sMetodoSetter = Fabrica::montaSetter($oController['campoModelPrincipal']);
                    $this->Model->$sMetodoSetter($oController['controller']->Model);

                    $aRetorno = $oController['controller']->afterInsert();
                    if(!$aRetorno[0]){
                        break;
                    }
                }
            }
        }
        return $aRetorno;
    }
    
    public function acaoExcluirDet($sDados){ // >>>ATENÇÃO<<< É NECESSÁRIO REESCREVER ESTE MÉTODO
        
       
        
        if(isset($_REQUEST['parametrosCampos'])){
            $aParam = $_REQUEST['parametrosCampos'];
            $aChaves = array();
            foreach ($aParam as $key => $value) {
              $aChaves[] = $value;  
              }
        }
        $sDados .= ','.implode(',', $aChaves);
        
        
        $oMensagem = new Modal('Deletar', 'Você tem certeza que deseja deletar este item (ou itens)?', Modal::TIPO_ERRO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$this->getNomeClasse().'","acaoExcluirRegDet","'.$sDados.'");');
        
        echo $oMensagem->getRender();
    } 
    
    public function acaoExcluirRegDet($sDados){
        
        $aDados = explode(',', $sDados);
        $idGrid = $aDados[0];
        array_shift($aDados);
        $aRetorno[0] = true;
       
        
        foreach ($aDados as $sChaveAtual) {
          $this->Persistencia->iniciaTransacao();
          $sChave = htmlspecialchars_decode($sChaveAtual);
          $this->parametros = $sChave;
          $this->carregaModelString($sChave);
          $this->Model = $this->Persistencia->consultar(); 
          $aRetorno = $this->beforeDelete();
            
            if ($aRetorno[0]) {
            $aRetorno = $this->Persistencia->excluir(true);
            }
            
            if ($aRetorno[0]) {
                $aRetorno = $this->afterDelete();
            }
            
            if($aRetorno[0]){
                //remove os registros de dependência
                $aRetorno = $this->acaoExcluirDependencias();
            }
            
            if(!$aRetorno[0]){
                break;
            }
            //se necessário adiciona filtro de reload
            $this->filtroReload($sChave);
            
            if($aRetorno[0]){
            $this->Persistencia->commit();
            
            $aRetorno = $this->afterCommitDelete();
            
             // Retorna Mensagem Informando o Sucesso da Exlusão do registro
            $oMensagemSucesso = new Mensagem('Sucesso!', 'Seu registro foi deletado...', Mensagem::TIPO_SUCESSO);
            echo $oMensagemSucesso->getRender();
            $this->getDadosConsulta($idGrid,false,null);
           } else {
                $oMensagemErro = new Mensagem('Falha', 'O registro não foi excluído!', Mensagem::TIPO_ERROR);
                echo $oMensagemErro->getRender();             
           }
       }
       
       
       }
    
    /**
     * Método que realiza a exclusão das informações do banco de dados
     * conforme informações presentes nos atributos "chave" do objeto 
     * 
     * @param string $sId ID do objeto
     * @param string $sChave String contendo as chaves dos registros a serem excluídos
     */    
    public function acaoExcluir($sDados){ // >>>ATENÇÃO<<< É NECESSÁRIO REESCREVER ESTE MÉTODO
        
        $aDados = explode(',',$sDados);
        $sChave = htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        $sClasse = $this->getNomeClasse();
        $this->antesExcluir($aCamposChave);
        
        
        $oMensagem = new Modal('Deletar', 'Você tem certeza que deseja deletar este item?', Modal::TIPO_ERRO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","acaoExcluirRegistro","'.$sDados.'");');
       
        echo $oMensagem->getRender();
    } 
    
    public function acaoExcluirRegistro($sDados){
        
        $aDados = explode(',', $sDados);
        $aRetorno[0] = true;
        $sChave = htmlspecialchars_decode($aDados[0]);
        $aChave = explode(',', $sChave);
        //armazena parametros no param para recuperá-los se necessários
        $this->parametros = $aChave;
        
        foreach ($aChave as $sChaveAtual) {
            $this->Persistencia->iniciaTransacao();
            $this->carregaModelString($sChaveAtual);
            $this->Model = $this->Persistencia->consultar();
            
            $aRetorno = $this->beforeDelete();
            
            if ($aRetorno[0]) {
            $aRetorno = $this->Persistencia->excluir(true);
            }
            
            if ($aRetorno[0]) {
                $aRetorno = $this->afterDelete();
            }
            
            if($aRetorno[0]){
                //remove os registros de dependência
                $aRetorno = $this->acaoExcluirDependencias();
            }
            
            if(!$aRetorno[0]){
                break;
            }
            //se necessário adiciona filtro de reload
            $this->filtroReload($aChave[0]);
        }
        
        if($aRetorno[0]){
            $this->Persistencia->commit();
            
            $aRetorno = $this->afterCommitDelete();
            
            // Retorna Mensagem Informando o Sucesso da Exlusão do registro
            $oMensagemSucesso = new Mensagem('Sucesso!', 'Seu registro foi deletado...', Mensagem::TIPO_SUCESSO);
            echo $oMensagemSucesso->getRender();
           
            //Atualiza o Grid
            $this->getDadosConsulta($aDados[1],false,null);
            // echo"$('#".$aDados[1]."-pesq').click();";
        } else{
            $oMensagemErro = new Mensagem('Falha', 'O registro não foi excluído!', Mensagem::TIPO_ERROR);
            echo $oMensagemErro->getRender();
          
        }
     
        
      
    }
    
    /**
     * Método que excluir os registros de dependência relacionados ao controlador
     * principal
     */
    public function acaoExcluirDependencias(){
        //array de controle de erros
        $aRetorno[0] = true;
        
        foreach ($this->getControllerDependente() as $oController) {
            $sMetodoGetter = Fabrica::montaGetter($oController['campoModelPrincipal']);
            $oController['controller']->Persistencia->Model = $this->Model->$sMetodoGetter();
           
            $aChave =  $oController['controller']->Persistencia->getChaveArray();
        
            /*
             * Verifica se todos os campos da chave estão setados
             * podem existir dependências não obrigatórias e nestes casos
             * o comando de exclusão não deve ser executado
             */
            $bChaveSetada = true;
            foreach ($aChave as $oCampoChave) {
                $xValor = $this->getValorModel($oController['controller']->Persistencia->Model,$oCampoChave->getNomeModel());
                
                if(is_null($xValor)){
                    $bChaveSetada = false;
                    break;
                }
            }
            
            if($bChaveSetada){
                //remove o registro no banco de dados
                $aRetorno = $oController['controller']->Persistencia->excluir(true);
                if(!$aRetorno[0]){
                    break;
                }
            }
        }
        return $aRetorno;
    }
    
    /**
     * Método que realiza a exclusão das informações contidas no 
     * objeto de detalhamento do registro principal (1 x N)
     * 
     * @return array Array contendo as informações sobre a execução das operações
     */    
    public function acaoExcluirDetalhe(){
        //carrega a chave do objeto mestre
        $aChaveMestre = $this->Persistencia->getChaveArray();
        
        /*
         * obtem o nome da classe mestre para compor o nome do atributos
         * a string inicial "Controller" é ignorada neste caso
         */
        $sNomeClasse = $this->getNomeClasse();
        
        /*
         * carrega a chave do objeto mestre no objeto de detalhamento e
         * adiciona os campos na cláusula where para fazer filtros se existirem
         * buscas para campos de autoincremento
         */
        foreach ($aChaveMestre as $oCampoChave) {
            $sNomeModel = $oCampoChave->getNomeModel();
            $sNomeBanco = $oCampoChave->getNomeBanco();
            
            $xValor = $this->getValorModel($this->Model,$sNomeModel);
            
            $this->setValorModel($this->ControllerDetalhe->Model,$sNomeClasse.".".$sNomeModel,$xValor);
            $this->ControllerDetalhe->Persistencia->adicionaFiltro($sNomeBanco,$xValor);
        }
            
        return $this->ControllerDetalhe->Persistencia->excluir(true);
    }
    
    /**
     * Método que adiciona as ações a serem executadas no momento
     * em que a requisição ajax for completada e a função de callback
     * for chamada
     * 
     * @param string $sConteudo
     * @param string $sTipo
     * @param boolean $sReplaceBr Indica se deve substituir a tag <br> por \n
     */
    public function adicionaJSON($sConteudo,$sTipo='render',$sReplaceBr=true){
            //remove possíveis quebras na string de renderização
            $sConteudo = str_replace("\n\r", "",$sConteudo);
            $sConteudo = str_replace("\n", "",$sConteudo);
            $sConteudo = str_replace("\r", "",$sConteudo);
            
            $fp = fopen("bloco1.txt", "w");
            fwrite($fp, $sConteudo);
            fclose($fp);
            //substitui os elementos <br> contidos nos valores dos campos por \n 
            if($sReplaceBr){
                $sConteudo = str_replace("<br>", "\\n",$sConteudo);
            }
           
            /*$fp = fopen("bloco1.txt", "w");
            $escreve = fwrite($fp, $sConteudo);
            fclose($fp);*/ 
            
            $this->oJSON[] = array('tipo'=> $sTipo, 
                                   'conteudo' => utf8_encode($sConteudo));
    }

    /**
     * Método que adiciona apenas uma ação a ser executada no momento
     * em que a requisição ajax for completada e a função de callback
     * for chamada
     * 
     * Também executa o método que codifica o array no formato JSON
     * 
     * @param string $sConteudo
     * @param string $sTipo
     */
    public function retornoJSON($sConteudo,$sTipo='render'){
            $this->adicionaJSON($sConteudo,$sTipo);
            $this->confirmaJSON();
    }
    
    /**
     * Método que codifica o array de ações no formato JSON
     * 
     */
    public function confirmaJSON(){
        echo json_encode($this->oJSON);
    } 
    
    /**
     * Retorna um array contendo uma lista de valores da classe indica, 
     * geralmente utilizado nos campos select.
     * Para o campo 'value' sempre será retornada a chave e para o campo da
     * descrição será armazenado o valor do atributo solicitado
     * 
     * @param string $sClasse Nome da classe desejada
     * @param string $sMetodo Indica o método que deve ser executado para gerar a listagem, caso não seja passado
     *                        valor para este parâmetro irá executar o método padrão definido no Controller
     * @para string $sCampoValor Indica o campo que terá o conteúdo armazenado no banco
     * @para string $sCampoDescricao Indica o campo que terá o conteúdo exibido para o usuário
     * @para boolean $bOrdena Indica se deve ordenar pelo campo de descrição
     * 
     * @return array Array contendo os valores   
     */
    public static function getListaFrom($sClasse, $sMetodo, $sCampoValor, $sCampoDescricao, $bOrdena = true,$sWhere=null){
        $oPersistencia = Fabrica::FabricarPersistencia($sClasse);
        
        /*
         * Quando o método não é passado cria a instância do controller e model
         * da classe para poder realizar o preenchimento dos campos e filtros
         * na pesquisa
         */
        if($sMetodo === null){
            $oController = Fabrica::FabricarController($sClasse);
            $oController->adicionaFiltrosExtras();
            
            $aListaWhere = $oController->Persistencia->getListaWhere();
            foreach ($aListaWhere as $aAtual) {
                $oPersistencia->adicionaFiltro($aAtual['campo'], 
                                               $aAtual['valor'], 
                                               $aAtual['ligacao'], 
                                               $aAtual['comparacao'], 
                                               $aAtual['valorFim']);
            }
            $oPersistencia->setModel(Fabrica::FabricarModel($sClasse));
            
        }
        if($sWhere!=null){
            $oPersistencia->setSqlWhere($sWhere);
        }
        
        $aModels = $sMetodo != null ? $oPersistencia->$sMetodo() : $oPersistencia->getArrayModel();
        
        $aDados = array(); 
        foreach($aModels as $oAtual){
            $xValor = $sMetodo != null ? $oAtual[0] : $oController->getValorModel($oAtual,$sCampoValor);
            $xConteudo = $sMetodo != null ? $oAtual[1] : $oController->getValorModel($oAtual,$sCampoDescricao);
            $aDados[] = array($xValor,$xConteudo);
        }
        
        //Obtem a lista da colunas de valores
        $aConteudo = array(); 
        foreach ($aDados as $key => $row) {
            $aConteudo[$key] = strtolower($row[1]);
        }
        
        //realiza a ordenação de forma crescente com base na coluna dos conteúdos
        if($bOrdena){
            array_multisort($aConteudo, SORT_ASC, $aDados);
        }
        
        return $aDados;
    }
    
    /*Método para ser sobescrita nas classe filhas para fazer validações
     * Retorn um boolean
     */
    public function  getValidacao($sChave){
       
    return true;
        
    }
     /*Método para ser sobescrita nas classe filhas para fazer validações
     * Retorn um boolean
     */
    public function getValidacaoEx($sId,$sChave){
        return true; 
    }
    /*
     * Método para ser sobecrito para adicionar filtro de grid datail
     */
    public function adicionaFiltroDatil(){
        
    }
    /**
     * Método para ser sobescrito para deletar tabelas com chave estrangeira
     */
    public function excluiDetalhe($sId,$sChave){
        return true;
    }
    /**
     * Método para ser sobescrito para mudar o arecords do detalhe
     */
    public function manipulaDetalhe($aRecords){
        return $aRecords;
    }
    /**
     * Método que retorna o id do campo autoincremento
     */
   public function retornaAutoInc(){
       $aCampos = $this->Persistencia->getChaveArray();
       $sId = '';
       foreach ($aCampos as $key => $oCampoBanco) {
        $oCampo = $this->View->getTela()->getCampoByName($oCampoBanco->getNomeModel());  
         if(isset($oCampo)){
             if ($oCampoBanco->getAutoIncremento()){
                $sId = $oCampo->getId();   
             }
            }
           }
       return $sId;
     }
   
   /**
    * Método que retorna o valor do campo autoincremento
    */
     public function retornaValuInc(){
         //busca os campos do banco que são autoincremento
        $aAuto = $this->Persistencia->getAutoIncrementoArray();
        foreach ($aAuto as $key => $oAuto) {
          $iValor = $this->Persistencia->getIncremento($oAuto->getNomeBanco(),true);  
        }
        
        return $iValor;
     }
     
     /**
      * Método responsável por realizar a comparação para adicionar a coloração de acordo
      * com cada sentença adicionada no método criaConsulta na View
      * @param string $Valor Valor atual
      * @param array $aComparativo Array de objetos, onde cada objeto contem seu próprío array de comparações
      * @return array [0] bolean [1] string classe da cor
      */
     public function formatacaoCondicional($Valor, $aComparativo){
        foreach ($aComparativo as $aCompAtual){
            // Comparação do tipo igual  
            if($aCompAtual['tipo'] == 0){
                if($Valor == $aCompAtual['valor']){
                    $aRetorno[0] = true;
                    $aRetorno[1] = $aCompAtual['cor'];
                }else if(!$aRetorno[0]){
                    $aRetorno[0] = false;
                }
            } 
            // Comparação do tipo maior
            if($aCompAtual['tipo'] == 1) {
                if($Valor > $aCompAtual['valor']){
                    $aRetorno[0] = true;
                    $aRetorno[1] = $aCompAtual['cor'];
                }else if(!$aRetorno[0]){
                    $aRetorno[0] = false;
                }
            }
            // Comparação do tipo menor
            if($aCompAtual['tipo'] == 2) {
                if($Valor < $aCompAtual['valor']){
                    $aRetorno[0] = true;
                    $aRetorno[1] = $aCompAtual['cor'];
                }else if(!$aRetorno[0]){
                    $aRetorno[0] = false;
                }
            } 
            // Comparação do tipo diferente
            if($aCompAtual['tipo'] == 3) {
                if($Valor <> $aCompAtual['valor']){
                    $aRetorno[0] = true;
                    $aRetorno[1] = $aCompAtual['cor'];
                }else if(!$aRetorno[0]){
                    $aRetorno[0] = false;
                }
            }
        }
         return $aRetorno;
    }
    
    function getControllerDetalhe() {
        return $this->ControllerDetalhe;
    }

    function setControllerDetalhe($ControllerDetalhe) {
        $this->ControllerDetalhe = $ControllerDetalhe;
        $this->View->setSControllerDetalhe($ControllerDetalhe);
    }
    
    function getSMetodoDetalhe() {
        return $this->sMetodoDetalhe;
    }

    function setSMetodoDetalhe($sMetodoDetalhe) {
        $this->sMetodoDetalhe = $sMetodoDetalhe;
    }

        /**
     * Método que é sobescrito para escolher campos para a próxima etapa
     */
    
    public function montaProxEtapa(){
        $aRetorno = array();
        return $aRetorno; 
    }

    public function carregaValorCampo($oCampo){
         $xValor = str_replace("\n", "<br>",$this->getValorModel($this->Model,$oCampo->getNome()));
         $xValor =  str_replace("'","\'",$xValor);
         //verifica se é decimal
         if($oCampo->getITipo()==29){
                       $xValor = number_format($xValor, 2, ',', '.');
                    }
         
         if($oCampo->getITipo() == 0){
             if ($xValor!==''){
             $oCampo->setSValor(date('d/m/Y', strtotime($xValor)));
             }else{$oCampo->setSValor($xValor);}
         }elseif($oCampo->getITipo() == 2){
             $oCampo->setSValor(number_format($xValor, 2, ',', '.'));
         }
         else{
             $oCampo->setSValor($xValor);
         }
            
            //setar o valor do campo busca
            
               if(($oCampo->getClasseBusca() != null)&&($oCampo->getITipo()!== Campo::TIPO_BUSCADOBANCOPK)&&($oCampo->getITipo()!== Campo::TIPO_BUSCADOBANCO)){
                   $aCampoBusca = $oCampo->getCampoBusca(0);
                   $sClasseBusca = $oCampo->getClasseBusca();
                   $xValorBusca = str_replace("\n", "<br>",$this->getValorModel($this->Model,$oCampo->getClasseBusca().'.'.$aCampoBusca[0]));
                   $oCampo->setSValorCampoBusca($xValorBusca);
                }
            //se o campo for do tipo arquivo, carrega as minuaturas
            if(method_exists($oCampo, 'getValorTipo') && $oCampo->getValorTipo() === Campo::TIPO_ARQUIVO){
                if($oCampo->getUploadMultiplo()){
                    //TODO
                } else{
                    $oArquivo = $this->getModel($this->Model,$oCampo->getNome());

                    if($oArquivo->getCodigo() != null){
                        $sUrlArq = 'index.php?classe='.Campo::CLASSE_UPLOAD.'&metodo=getFileBD&codigo='.$oArquivo->getCodigo().'&alt='.$oCampo->getAlturaThumb().'&lar='.$oCampo->getLarguraThumb().'&q=100';
                        $oCampo->setSrcThumb($sUrlArq);
                    }
                }
            }
                //$this->carregaValorCamposBusca($oCampo);// VERIFICAR MUITO IMPORTANTE
    }
    
     public function pkDetalhe($aChave){
        $oRetorno = '';
        return $oRetorno;
    }
    /**
     * 
     * @param type função para ser sobescrita 
     */
    public function filtroReload($aChave){
        
       
    }
    /**
     * 
     * @param type função para ser sobescrita 
     * caso necessite ação após limpar um filtro
     */
    public function acaoLimpar($sForm,$sDados){
        
       
    }
    /**
     * Método que monta o alterar de uma tela detalhe do grid
     */
    public function carregaDetalhe($sChave){
            $aCampos = array();
            $sCampos = htmlspecialchars_decode($sChave);
            $this->carregaModelString($sCampos);
            $this->Model = $this->Persistencia->consultar();
            parse_str($sCampos,$aCampos);
            
            if($_REQUEST['parametrosCampos']){
                    foreach ($_REQUEST['parametrosCampos'] as $sAtual){
                        $aCampo[] =  explode(',', utf8_decode($sAtual)) ;
                    }
            }
            $aCampos = $this->antesCarregaDetalhe($aCampo);
            
            foreach($aCampos as $Campo){
               if($Campo[0]!=''){
                   
               $aMetodos = Controller::extractMetodos($Campo[0]);
               if(count($aMetodos) > 1){
                        $sMetodoGetter = Fabrica::montaGetter($aMetodos[0]);
                       }else{
                        $sMetodoGetter = Fabrica::montaGetter($Campo[0]); 
                   }
                   
                   
              if(method_exists($this->Model, $sMetodoGetter)){
                 $sValor = $this->getValorModel($this->Model,$Campo[0]);
              }else{
                  $sValor = 'semModel';
              }
                
              
             if($sValor!== '0'){    
               if(empty($sValor)){
                   $sValor = '';
               }
             }
               if($sValor !== 'semModel'){
                    $sValor = str_replace("\n", " ",$sValor);
                    $sValor = str_replace("'","\'",$sValor);   
                    $sValor = str_replace("\r", "",$sValor);

                    $sRetorno = "$('#".$Campo[1]."').val('".$sValor."').trigger('change');";
                    echo $sRetorno;
               }
             
               }
            }
           
                   
    }
    
    /**
     * Função que retorna a o tipo do filtro
     */
    function tipoFiltro($sFiltro){
   if($sFiltro !=null){
     switch ($sFiltro){
      case $sFiltro=='igual':
          $sTipoFiltro = Persistencia::IGUAL;
          break;
      case $sFiltro=='contem':
          $sTipoFiltro = Persistencia::CONTEM;
          break;
      case $sFiltro =='comeca':
          $sTipoFiltro = Persistencia::INICIA_COM;
          break;
      case $sFiltro =='scroll':
          $sTipoFiltro = Persistencia::MENOR;
          break;    
      }
    }else
    {
        $sTipoFiltro = Persistencia::IGUAL;
    }
     
     return $sTipoFiltro;
    }
    
    /**
     * Método que irá verificar tipo do campo a ser carregado,
     * e se for do tipo "Campo" irá ser carregado, 
     * se não chamará novamente o método até que chegue no tipo campo.
     * 
     * @param objeto $oCampo
     * @author Carlos
     */
   function verificaCarregarCampo($oCampo){
        switch ($oCampo){
            case  is_a($oCampo, 'Campo'):
                 $this->carregaCampo($oCampo);
            break;
            case  is_array($oCampo):
                foreach($oCampo as $CampoArray){
                    $this->verificaCarregarCampo($CampoArray);
                }
                 
            break;
            case  is_a($oCampo, 'FieldSet'):
                foreach($oCampo->getACampos() as $oFsCampo){
                    $this->verificaCarregarCampo($oFsCampo);
                }
            break;
            case  is_a($oCampo, 'TabPanel'):
                foreach($oCampo->getItems() as $Aba){
                    foreach($Aba->getACampos() as $AbaCampo){
                        $this->verificaCarregarCampo($AbaCampo);
                    }
                }
            break;
        }
    }
    
    /**
     * Método responsável por preparar strings para que possam serem inseridas no MSSQL SERVER
     * e lidas no JQuery sem que ocorram problemas
     * 
     * @param string $str
     * @return string 
     * @author Carlos
     */
    public function preparaString($str){
        if(is_string($str)){
            
           if(Config::TIPO_BD== Config::BD_MYSQL){
             $sRetorno = str_replace("'", '"',$str);  
           }else{
             $sRetorno = str_replace( "'", "''", $str );  
             //$value = str_replace( '"', '""', $str );
           }
         }
        
        return $sRetorno;    
    }
   /**
    * Método que pode ser sobescrito antes da alteracao
    */
   public function antesAlterar($sParametros=null){
       
   }
   /**
    * Método antes de incluir
    */
   public function antesIncluir($sParametros=null){
       
   }
   /**
    * Método para ser sobescrito
    */
   public function antesExcluir($sParametros=null){
       
   }
   /**
    * Método para ser sobescrito
    */
   public function depoisCarregarModelAlterar($sParametros=null){
       
   }
   /**
    * Método qdo true não exibe os botões padrao do form
    */
   function getBDesativaBotaoPadrao() {
       return $this->bDesativaBotaoPadrao;
   }

   function setBDesativaBotaoPadrao($bDesativaBotaoPadrao) {
       $this->bDesativaBotaoPadrao = $bDesativaBotaoPadrao;
   }
   /**
    * Método para ser sobescrito para definir totalizadores personalizados
    */
   public function calculoPersonalizado($sParametros=null){
       
   }
 
   /**
    * executa antes de carregar o model
    */
   public function antesCarregarModel(){
       
   }
   /**
    * Método para ser sobescrito para fazer validações do lado do servidor
    */
   public function getVal($sDados){
       
   }
   /**
    * Faz calculos antes de exibir relatórios e retorna
    */
   public function beforeRel($sDados){
       
   }
   /**
    * Método para ser sobescrito para  retornar string para chamadas get
    */
   public function getSget(){
       $sCampo = '&rep='. $_SESSION['repsoffice']; 
       $sCampo .= '&userRel='.$_SESSION['nome'];
       return $sCampo;
   }
   /**
    * 
    * Antes chamar método detalhe
    */
   public function antesDetalhe($sDados){
      
   }
   /**
    * Método para excluir campo para alteração
    */
   public function antesCarregaDetalhe($aCampos){
       return $aCampos;
   }
   /**
    * arruma valores para salvar no banco
    */
   function ValorSql($valor) {
       $verificaPonto = ".";
       if(strpos("[".$valor."]", "$verificaPonto")):
           $valor = str_replace('.','', $valor);
           $valor = str_replace(',','.', $valor);
           else:
             $valor = str_replace(',','.', $valor);   
       endif;

       return $valor;
}
/**
 * Método responsável para gerar mensagem de registro nao selecionado
 */
    public function msgReg($sValor){
         $oMensagem = new Modal('Selecione um registro','Clique em um registro do grid para concluir sua operação!', Modal::TIPO_AVISO,false,true,true);
         echo $oMensagem->getRender(); 
    }
    
 /**
  * Método para ser sobescrito para limpar campos uploads
  */
 public function limpaUploads($aIds){
     
 }
 /**
  * Método que executar após limpar um form
  */
 public function afterResetForm($sDados){
     
 }
 
 /**
  * Método para ser sobescrito
  */
 public function afterGetdadoGrid(){
     
 }
 /**
  * Metodo subs antes de buscar valorPK
  */
 public function antesValorBuscaPk(){
     
 }
 
}
?>