<?php
/**
 * Classe que implementa a estrutura de um objeto Form juntamente
 * com um objeto Grid para resolver os cadastros mestre x detalhe
 * 
 * @author Fernando Salla
 * @since 29/11/2012
 */
class FormGrid{
    private $sId; //id
    private $sNome; //name
    private $oFieldSet;
    private $oGrid;
    private $aTotalizaCamposForm;
    private $bAddBotaoAdiciona;
    private $bAddBotaoEdit;
    private $aValidacao; //usado para fazer validações adicionais nas inclusões/alterações
    private $aChave;
    
    const MSG_ERRO_VALIDACAO = "O registro não pode ser efetuado. Existem validações pendentes.";
    
    /**
     * Construtor da classe FormGrid 
     * 
     * @param string $sTitulo Título do FieldSet
     * @param integer $iAltura Altura da tela
     * @param integer $iLargura Largura da tela
     */
    function __construct($sTitulo, $iAltura, $iLargura) {
        $this->sId = Base::getId();
        $this->aTotalizaCamposForm = array();
        $this->aValidacao = array();
        $this->aChave = array();
        
        $this->setAddBotaoAdiciona(true);
        $this->setAddBotaoEdit(true);
        
        $this->oFieldSet = new FieldSet($sTitulo);
        
        $this->oGrid = new Grid('Lista de '.$sTitulo);
        $this->oGrid->setIsItemForm(true);
        $this->oGrid->setPermiteArrastar(false);
        $this->oGrid->setPermiteFechar(false);
        $this->oGrid->setPermiteRecolher(false);
        $this->oGrid->setPermiteRedimensionar(false);
        $this->oGrid->setAdicionaPaginacao(false);
        $this->oGrid->setAdicionaTotalizador(true);
        $this->oGrid->setExibeTotalizador(false);
        $this->oGrid->setAdicionaFiltros(false);
        $this->oGrid->setAltura($iAltura);
        $this->oGrid->setLargura($iLargura);
        $this->oGrid->setStyle('margin-top: 10px');
        $this->oGrid->setExibeNumeroLinha(true);
        $this->oGrid->setPermiteVazio(false);
        
        $sAcao = "var row = Ext.ComponentQuery.query('#".$this->oGrid->getId()."')[0].getSelectionModel().getSelection()[0];"
                ."Ext.Array.each(row.fields.keys, function(nomeCampo) {"
                   ."var campo = Ext.ComponentQuery.query('#".$this->oFieldSet->getId()." [name=\''+nomeCampo.replace(/_/g,'.')+'\']');"
                   ."var valor = row.get(nomeCampo);"
                   ."if(campo != ''){"
                      ."campo[0].setValue(valor);"
                      ."campo[0].fireEvent('".Base::EVENTO_EXIT."');"
                   ."}"
                ."});"
                .$this->getTrocaBotao(1)
                ."var campoFoco = row.fields.keys[0];"
                ."Ext.ComponentQuery.query('#".$this->oFieldSet->getId()." [name=\''+campoFoco.replace(/_/g,'.')+'\']')[0].focus();";
        
        $this->oGrid->addListener(Base::EVENTO_ITEM_CLIQUE,$sAcao);
    }
    
    /**
     * Retorna o conteúdo do atributo sId
     * 
     * @return string
     */
    public function getId() {
        return $this->sId;
    }
    
    /**
     * Retorna o conteúdo do atributo oGrid
     * 
     * Return object
     */
    public function getGrid(){
        return $this->oGrid;
    }
    
    /**
     * Retorna o conteúdo do atributo sNome
     * 
     * @return string
     */    
    public function getNome() {
        return $this->sNome;
    }

    /**
     * Define o valor do atributo sNome
     * 
     * @param string sNome 
     */    
    public function setNome($sNome) {
        $this->sNome = $sNome;
    }
    
    /**
     * Retorna o conteúdo do atributo oFieldSet
     * 
     * @return object
     */
    public function getFieldSet(){
        return $this->oFieldSet;
    }
    
    /**
     * Adiciona os valores passados ao array que conterá a largura do
     * label de cada coluna a ser montada na tela
     */     
    public function addLarguraLabel() {
        $aLista = func_get_args();
        
        $this->getFieldSet()->addLarguraLabel($aLista);
    }

    /**
     * Método que adiciona os campos criados na tela
     */
    public function addCampos(){
        $aCampos = func_get_args();    
        
        foreach($aCampos as $campoAtual){
            if(is_array($campoAtual)){
                foreach ($campoAtual as $campo){
                    $this->criaCampoGrid($campo);
                }
            } else{
                $this->criaCampoGrid($campoAtual);    
            }
            //adição do campo no fielset
            $this->getFieldSet()->addCampos($campoAtual);
        }
    }
    
    /** 
     * Método que cria os campos do grid
     */     
    private function criaCampoGrid($oCampo) {
        //não adicona se o campo for apenas de tela
        if(!($oCampo->getApenasTela())){
            //cria a coluna para o grid
            $oCampoGrid = new CampoConsulta($oCampo->getLabel(),$oCampo->getNome());

            switch ($oCampo->getTipoVisualiza()){
                case Campo::VISUALIZA_FORM:
                    $oCampoGrid->setOculto(true);
                break;
                case Campo::VISUALIZA_GRID:
                    $oCampo->setOculto(true);
                break;
            }

            //se deve demonstrar a coluna no grid ajusta algumas configurações
            if($oCampo->getTipoVisualiza() === Campo::VISUALIZA_FORM_GRID || 
               $oCampo->getTipoVisualiza() === Campo:: VISUALIZA_GRID){
                
                //ajusta o tipo do campo do grid conforme tipo do campo do form
                switch ($oCampo->getValorTipo()){
                    case Campo::TIPO_NUMERICO:
                    case Campo::TIPO_MOEDA:
                        $oCampoGrid->setTipo(CampoConsulta::TIPO_NUMERICO);
                        $oCampoGrid->setDecimais($oCampo->getDecimais());
                        $oCampoGrid->setTipoTotaliza($oCampo->getTipoTotaliza());
                    break;
                    case Campo::TIPO_CALCULADO:
                        $oCampoGrid->setTipo(CampoConsulta::TIPO_NUMERICO);
                        $oCampoGrid->setDecimais($oCampo->getDecimais());
                        $oCampoGrid->setTipoTotaliza($oCampo->getTipoTotaliza());
                        $oCampoGrid->setTipoCalculo($oCampo->getTipoCalculo());
                        $oCampoGrid->setFormulaCalculo($oCampo->getFormulaCalculo());

                        foreach($oCampo->getCamposCalculo() as $oAtual){
                            $oCampoGrid->addCamposCalculo($oAtual);    
                        }
                    break;
                    case Campo::TIPO_DATA:
                        $oCampoGrid->setTipo(CampoConsulta::TIPO_DATA);
                    break;
                    default :
                        $oCampoGrid->setTipo(CampoConsulta::TIPO_TEXTO);
                    break;
                }
                $oCampoGrid->setPermiteFiltrar(false);
                $oCampoGrid->setLargura($oCampo->getLargura());
            }
            
            $oCampoGrid->setPermiteOcultar(false);
            
            //adição da coluna no grid
            $this->addCamposGrid($oCampoGrid);
            
            //se o campo for select cria uma coluna para a descrição e oculta a coluna do código
            if($oCampo->getValorTipo() === Campo::TIPO_SELECT){
                $oCampoGrid->setOculto(true);
                $oCampoGrid2 = new CampoConsulta($oCampo->getLabel(),$oCampo->getNome().Base::COMPLETA_NOME_COMBO_GRID);
                $oCampoGrid2->setLargura($oCampo->getLargura());
                $oCampoGrid2->setPermiteFiltrar(false);
                $oCampoGrid2->setPermiteOcultar(false);
                
                $this->addCamposGrid($oCampoGrid2);
            }
        }
        
        //Adiciona o controle do botão de gravar/alterar no campo
        if(!$oCampo->getOculto()){
            $sAcao = "var button = Ext.ComponentQuery.query('#".$this->getFieldSet()->getId()." button[hidden=false][text~=\'".Base::BUTTON_ADD."\'],#".$this->getFieldSet()->getId()." button[hidden=false][text~=\'".Base::BUTTON_EDIT."\']')[0];"
                    ."if(button){"
                       ."button.fireEvent('".Base::EVENTO_MONTAR."');"
                    ."}";
            $oCampo->addListener(Base::EVENTO_CHANGE,$sAcao);
        }
        
        //indica que o campo pertence a um objeto formGrid
        $oCampo->setChildFormGrid(true);
    }
    
    /**
     * Método que permite adicionar as colunas desejadas no grid
     */
    public function addCamposGrid($oCampoGrid){
        $this->getGrid()->addCampos($oCampoGrid);
    }
    
    /** 
     * Método que permite a adição de campos que servirão como chave no
     * grid impedindo que a combinação presente neste atributo seja
     * repetida nas linhas do grid
     */     
    public function addChave() {
        $aCamposChave = func_get_args();
    
        foreach ($aCamposChave as $oCampo) {
            $this->aChave[] = $oCampo;
        }
    }
    
    public function getChave() {
        return $this->aChave;
    }
    
    public function getAcaoValidaChave(){
        $sAcao = "";
        $sCondicional = "";
        foreach ($this->getChave() as $oAtual) {
            if($sCondicional != ""){
                $sCondicional .= "&& ";
            }
            $sCondicional .= "Ext.ComponentQuery.query('#".$oAtual->getId()."')[0].getValue() == row.get('".str_replace('.','_',$oAtual->getNome())."')";
        }
        
        if($sCondicional != ""){
            $oMsg = new Mensagem(Mensagem::$ALERTA, "Alerta", "Este item já foi adicionado. Verifique a lista de registros.", Mensagem::$OK, null);
            $sAcao = "var rows = Ext.ComponentQuery.query('#".$this->getGrid()->getId()."')[0].getStore().getRange();"
                    ."Ext.Array.each(rows, function(row) {"
                       ."if(".$sCondicional."){"
                          .$oMsg->getRender()
                          ."valida = false;"
                          ."return false;"
                       ."}"
                   ."});"
                   ."if(!valida){"
                      ."return false;"
                   ."}";
        }
        return $sAcao;
    }
    
    /**
     * Método que permite definir campos do formulário que devem ter o valor
     * atualizado a partir do totalizador de uma coluna no grid
     * 
     * @param Object Objeto referente ao campo do formulário que deve ser atualizado
     * @param String Nome da coluna do grid que serve de base para a atualização
     * 
     */
    public function addTotalizaCampoForm($oCampoForm, $sColunaGrid){
        $this->aTotalizaCamposForm[] = array($oCampoForm,$sColunaGrid);
    }
    
    /**
     * Método que retorna a string com as funções de atualização dos campos
     * a partir do conteúdo do atributo $aTotalizaCamposForm
     * 
     * @return Array
     */
    public function getTotalizaCampoForm(){
        $sReturn = "";
        
        if(sizeof($this->aTotalizaCamposForm) > 0){
            $sReturn .= "var gridTotal = Ext.ComponentQuery.query('#".$this->getGrid()->getId()."')[0];";
             
            foreach ($this->aTotalizaCamposForm as $value) {
                $sReturn .= "var valor = gridTotal.getStore().".CampoConsulta::$TIPO_TOTALIZA[$value[0]->getTipoTotaliza()]."('".$value[1]."',true);"
                           ."Ext.ComponentQuery.query('#".$value[0]->getId()."')[0].setValue(valor);"; 
            }
        }
        
        return $sReturn;
    }
    
    /**
     * Retorna o conteúdo do atributo bAddBotaoAdiciona
     * 
     * @return boolean
     */
    private function getAddBotaoAdiciona() {
        return $this->bAddBotaoAdiciona;
    }

    /**
     * Define o valor do atributo bAddBotaoAdiciona
     * 
     * @param boolean $bAddBotaoAdiciona
     */
    public function setAddBotaoAdiciona($bAddBotaoAdiciona) {
        $this->bAddBotaoAdiciona = $bAddBotaoAdiciona;
    }
    
    /**
     * Retorna o conteúdo do atributo bAddBotaoEdit
     * 
     * @return boolean
     */
    private function getAddBotaoEdit() {
        return $this->bAddBotaoEdit;
    }

    /**
     * Define o valor do atributo bAddBotaoEdit
     * 
     * @param boolean $bAddBotaoEdit
     */
    public function setAddBotaoEdit($bAddBotaoEdit) {
        $this->bAddBotaoEdit = $bAddBotaoEdit;
    }
    
    /**
     * Método que permite adicionar testes de validação adicionais. 
     * Os testes serão feitos com base na fórmula e valores passados por parâmetros
     * 
     * Supõe-se que as validações adicionadas por este método garantem a não 
     * continuação da execução do código caso as validações não sejam atendidas
     * 
     * Abaixo pode-se ver um exemplo de formatação da fórmula
     * ({0} * {1}) > {2}
     * 
     * Será realizado o cálculo de multiplicação entre os valores que estiverem
     * nos índices 0 e 1 do array $aValor e posteriomente a
     * comparação com o valor do valor que estiver no índice 2
     * 
     * Só serão substituídos os valores entre "{}" o restante da string será
     * mantida
     *
     * @param Object $aValor Objetos do tipo campo ou valores a serem utilizados 
     * @param string $sFormula Fórmula da comparação a ser realizada
     * @param string $sMsgErro Mensagem de erro a ser exibida caso a validação retorne false
     */
    public function addValidacao($aValor, $sFormula, $sMsgErro = self::MSG_ERRO_VALIDACAO){
        $this->aValidacao[] = array('valores' => $aValor,
                                    'formula' => $sFormula,
                                    'msgErro' => $sMsgErro);
    }
    
    /**
     * Retorna o array contendo as validacaoes a serem consideradas na função
     */
    public function getValidacao(){
        return $this->aValidacao;
    }
    
    /**
     * Retorna a string contendo o código com a ser executado considerando as
     * restrições existentes no atributo aValidacao
     * 
     * @return string Código contendo a função de validação
     */
    public function getStringValidacao(){
        $sAcao = "";
        
        foreach ($this->getValidacao() as $aAtual) {
            $sCondicional = $aAtual['formula'];
            foreach ($aAtual['valores'] as $key => $value) {
                $xValor = method_exists($value, 'getValor') ? " Ext.ComponentQuery.query('#".$value->getId()."')[0].getValue() " : $value;
                $sCondicional = str_replace("{".$key."}",$xValor,$sCondicional);
            }
            
            $oMsg = new Mensagem(Mensagem::$ALERTA, "Alerta", $aAtual['msgErro'], Mensagem::$OK, null);
            
            $sAcao .= "if(!(".$sCondicional.")){"
                        .$oMsg->getRender()
                        ."return false;"
                     ."}";
        }
        return $sAcao;
    }
    
    /**
     * Método que monta e retorna a string contendo a ação a ser executada ao 
     * clicar no botão de adição incluso após o último campo
     */
    private function getAcaoAdd(){
        $sRecord = "[[";
        
        foreach ($this->getFieldSet()->getCampos() as $key => $oAtual) {
            if($key > 0){
                $sRecord .= ",";
            }
            $sRecord .= "Ext.ComponentQuery.query('#".$oAtual->getId()."')[0].getValue()";
            if(method_exists($oAtual, 'getValorTipo')){
                if($oAtual->getValorTipo() === Campo::TIPO_SELECT){
                    $sRecord .= ", Ext.ComponentQuery.query('#".$oAtual->getId()."')[0].getDisplayValue()";
                }
            }
        }
        $sRecord .= "]]";
        
        $sAcao = "var valida = true;"
                .$this->getAcaoValidaChave()
                .$this->getStringValidacao()
                ."var store = Ext.ComponentQuery.query('#".$this->getGrid()->getId()."')[0].getStore();"
                ."store.add(".$sRecord.");"
                ."store.sync();"
                .$this->getLimpaCampos()
                .$this->getSetaFoco()
                .$this->getTotalizaCampoForm();
        
        return $sAcao;
    } 
    
    /**
     * Método que monta e retorna a string contendo a ação a ser executada ao 
     * clicar no botão de alteração incluso após o último campo
     */
    private function getAcaoEdit(){
        $sAcao = "var valida = true;"
                 .$this->getStringValidacao()
                ."if(valida){"
                   ."var row = Ext.ComponentQuery.query('#".$this->getGrid()->getId()."')[0].getSelectionModel().getSelection()[0];"
                   ."Ext.Array.each(row.fields.keys, function(nomeCampo) {"
                      ."var campo = Ext.ComponentQuery.query('#".$this->getFieldSet()->getId()." textfield[name=\''+nomeCampo.replace(/_/g,'.')+'\']')[0];"
                      ."if(campo){"
                         ."row.set(nomeCampo,campo.getValue());"
                         ."if(campo.xtype == 'combo'){"
                            ."row.set(nomeCampo+'".Base::COMPLETA_NOME_COMBO_GRID."',campo.getDisplayValue());"
                         ."}"
                      ."}"
                   ."});"
                   ."Ext.ComponentQuery.query('#".$this->oGrid->getId()."')[0].getStore().sync();"
                   .$this->getTrocaBotao()
                   .$this->getLimpaCampos()
                   .$this->getSetaFoco()
                   .$this->getTotalizaCampoForm()
                ."}" ;
        
        return $sAcao;
    }
    
    /**
     * Método que retorna a rotina de limpeza dos campos após inserir/alterar
     * um registro no grid
     * 
     * @return string String contendo a função a ser renderizada
     */
    private function getLimpaCampos(){
        $sRetorno = "var fields = Ext.ComponentQuery.query('#".$this->getFieldSet()->getId()." field');"
                   ."Ext.Array.each(fields, function(field) {"
                      ."if(field.xtype == 'combo'){"
                         ."if(field.getStore().getAt(0)){"
                            ."field.setValue(field.getStore().getAt(0).get('".Campo::SELECT_VALOR."'));"
                         ."} else{"
                            ."field.setValue('');"
                         ."}"
                      ."} else{"
                         ."field.setValue('');"
                      ."}"
                      ."field.clearInvalid();"
                   ."});";
                
        return $sRetorno;
    }
    
    /**
     * Método que retorna a rotina para setar o foco no primeiro campo do
     * fieldset após realizar a inclusão/altearção de um registro no grid
     * 
     * @return string String contendo a função a ser renderizada
     */
    private function getSetaFoco(){
        $sRetorno = "Ext.ComponentQuery.query('#".$this->getFieldSet()->getId()." field[hidden=false][readOnly=false]')[0].focus(true,true);";
                
        return $sRetorno;
    }
    
    /**
     * Método que retorna os procedimentos a serem executados nos botões do
     * fieldset após realizar a inclusão/alteração de um registro no grid
     * Tipos possíveis:
     * - 0 quando se deseja demonstrar o botão de adição
     * - 1 quando se deseja demonstrar o botão de alteração
     * 
     * @return string String contendo a função a ser renderizada
     */
    private function getTrocaBotao($iTipo = 0){
        $sBtnHabilita   = $iTipo == 0 ? Base::BUTTON_ADD : Base::BUTTON_EDIT;
        $sBtnDesabilita = $iTipo == 0 ? Base::BUTTON_EDIT : Base::BUTTON_ADD;
        $sRetorno = "var btnHabilita   = Ext.ComponentQuery.query('#".$this->getFieldSet()->getId()." button[text=\'".$sBtnHabilita."\']');"
                   ."var btnDesabilita = Ext.ComponentQuery.query('#".$this->getFieldSet()->getId()." button[text=\'".$sBtnDesabilita."\']');"
                      ."if(btnHabilita[0]){"
                         ."btnHabilita[0].setVisible(true);"
                      ."}"
                      ."if(btnDesabilita[0]){"
                         ."btnDesabilita[0].setVisible(false);"
                      ."}";
                
        return $sRetorno;
    }
    
    /**
     * Método que retorna a ação referente ao controle do botão que contêm
     * a ação de adicionar/alterar.
     * O botão só será habilitado caso todos os campos visíveis estiverem
     * preenchidos
     * 
     * @return string String contendo a função a ser renderizada
     */
    public function getControleBotao(){
        return "var bCtr = true;"
              ."var fields = Ext.ComponentQuery.query('#".$this->getFieldSet()->getId()." field[allowBlank=false][hidden=false]');"
              ."Ext.Array.each(fields, function(field) {"
                 ."if(!field.isValid() || (Ext.isEmpty(field.getValue()) && field.getName().indexOf('".Base::COMPLETA_NOME_BUSCA."',0) == -1)){"
                    ."field.clearInvalid();"
                    ."bCtr = false;"
                    ."return false;"
                 ."}"
              ."});"
              ."bCtr ? this.enable() : this.disable();";
    }
    
    /** 
     * Gera a string do objeto para que possa ser renderizado
     * pelo JSON
     * 
     * @return string String do objeto a ser renderizado 
     */
    public function getRender(){
        //controle do botão gravar conforme o manipulação dos registros do grid
        if(!$this->getGrid()->getPermiteVazio()){
            $sAcao = "var fieldSet = Ext.ComponentQuery.query('#".$this->getFieldSet()->getId()."')[0];"
                    ."if(fieldSet){"
                       ."var buttons = fieldSet.up('form').down('button[validaForm=true]');"
                       ."Ext.Array.each(buttons, function(btn) {"
                          ."btn.fireEvent('".Base::EVENTO_MONTAR."');"
                       ."});"
                    ."}";
            $this->getGrid()->getStore()->addListener(Base::EVENTO_DATA_CHANGE,$sAcao);
        }
        
        if($this->getAddBotaoAdiciona()){
            $oBtnAdd = new Botao(Base::BUTTON_ADD,$this->getAcaoAdd());
            $oBtnAdd->setIcone(Base::ICON_ADD);
            $oBtnAdd->setLargura(90);
            $oBtnAdd->setStyle('margin-left: 3px');
            $oBtnAdd->addListener(Base::EVENTO_MONTAR,$this->getControleBotao());
            
            $this->getFieldSet()->getLayout()->addItemsPosicao($oBtnAdd,count($this->getFieldSet()->getLayout()->getItems())-1);
        }
        
        if($this->getAddBotaoEdit()){
            $oBtnEdit = new Botao(Base::BUTTON_EDIT,$this->getAcaoEdit());
            $oBtnEdit->setIcone(Base::ICON_EDIT);
            $oBtnEdit->setLargura(90);
            $oBtnEdit->setStyle('margin-left: 3px');
            $oBtnEdit->setOculto(true);
            $oBtnEdit->addListener(Base::EVENTO_MONTAR,$this->getControleBotao());
            
            $this->getFieldSet()->getLayout()->addItemsPosicao($oBtnEdit,count($this->getFieldSet()->getLayout()->getItems())-1);
        }
        
        $oMsg = new Mensagem(Mensagem::$ALERTA, "Alerta", "Selecione uma linha para executar a ação.", Mensagem::$OK, null);
        
        //botão de ação para remover um registro
        $sAcaoDelete = "var grid = Ext.ComponentQuery.query('#".$this->getGrid()->getId()."')[0];"
                      ."if(grid.getSelectionModel().hasSelection()){"
                         ."var linhas = grid.getView().getSelectionModel().getSelection();"
                         ."Ext.Array.each(linhas, function(linha) {"
                            ."grid.getStore().remove(linha);"
                         ."});"
                         ."Ext.ComponentQuery.query('#".$this->getGrid()->getId()."')[0].getStore().sync();"
                         .$this->getTrocaBotao()
                         .$this->getLimpaCampos()
                         .$this->getSetaFoco()
                         .$this->getTotalizaCampoForm()
                      ."} else{"
                         .$oMsg->getRender()
                      ."}";
        
        $oBtnDelete = new Botao('Remover',$sAcaoDelete); 
        $oBtnDelete->setHabilitaFrmValidado(false);
        $oBtnDelete->setIcone(Base::ICON_DELETE);

        $this->getGrid()->addBotoes($oBtnDelete);
        $this->getGrid()->addListener(Base::EVENTO_LER_TELA,$this->getTotalizaCampoForm());
        
        $this->getFieldSet()->addCampos($this->getGrid());
                 
        $sRender = $this->getFieldSet()->getRender();
        
        return $sRender;
    }
}
?>                  