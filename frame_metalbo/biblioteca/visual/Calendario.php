<?php
/**
 * Classe que implementa a estrutura do componente Calendar do ExtJs
 *
 * @author Fernando Salla
 * @since 14/11/2013
 */

//inclusуo da classe Proxy
Fabrica::requireBibliotecaVisual('Proxy');

class Calendario {
    //constantes referente р perspectivas de visualizaчуo do calendсrio de eventos
    const PERSPECTIVA_DIA    = 0;
    const PERSPECTIVA_SEMANA = 1;
    const PERSPECTIVA_MES    = 2;
    
    //constantes padrуo referentes a raэz dos objetos json para os stores
    const ROOT_STORE_TIPO_EVENTO = 'calendar';
    const ROOT_STORE_EVENTO = 'evts';
    
    //classes padrуo para montagem do calendсrio caso nуo seja informada outra
    const CLASSE_EVENTO_PADRAO = 'Agenda';
    const CLASSE_EVENTO_PADRAO_TIPO = 'TipoAgenda';
    
    //parтmetros possэveis de serem utilizados nos eventos do calendсrio
    const EVENTO_CODIGO     = 'id'; 
    const EVENTO_TIPO       = 'cid';
    const EVENTO_TITULO     = 'title';
    const EVENTO_PESSOA     = 'pid';
    const EVENTO_PESSOA_NOME= 'pname';
    const EVENTO_INICIO     = 'start';
    const EVENTO_FIM        = 'end';
    const EVENTO_LOCAL      = 'loc';
    const EVENTO_OBSERVACAO = 'notes';
    const EVENTO_URL        = 'url';
    const EVENTO_TODOS_DIAS = 'ad';
    const EVENTO_LEMBRAR    = 'rem';
    const CONFIGURACAO      = 'cfg';
    
    //parтmetros possэveis de serem utilizados nos tipos de eventos
    const TIPO_EVENTO_CODIGO    = 'id';
    const TIPO_EVENTO_TITULO    = 'title';
    const TIPO_EVENTO_DESCRICAO = 'desc';
    const TIPO_EVENTO_COR       = 'color';
    const TIPO_EVENTO_OCULTO    = 'hidden';
    
    //eventos (listeners)
    const EVENTO_CLICK  = 'eventclick';
    const EVENTO_OVER   = 'eventover';
    const EVENTO_OUT    = 'eventout';
    const EVENTO_ADD    = 'eventadd';
    const EVENTO_UPDATE = 'eventupdate';
    const EVENTO_CANCEL = 'eventcancel';
    const EVENTO_VIEW_CHANGE = 'viewchange';
    const EVENTO_DAY_CLICK = 'dayclick';
    const EVENTO_RANGE  = 'rangeselect';
    const EVENTO_MOVE   = 'eventmove';
    const EVENTO_RESIZE = 'eventresize';
    const EVENTO_DELETE = 'eventdelete';
    const EVENTO_DRAG   = 'initdrag';
    
    private $sId; //id
    private $iPerspectiva; //activeItem
    private $aListener; //listeners
    private $sRenderTo; //renderTo
    private $bMostraBarraPerspectivas; //showNavBar
    private $bMostraPerspectivaDia; //showDayView
    private $bMostraPerspectivaSemana; //showWeekView
    private $bMostraPerspectivaMes; //showMonthView
    private $bMostraHora; //showTime
    private $bMostraCabecalhoMes; //showHeader
    private $bMostraLinksSemana; //showWeekLinks
    private $bMostraNumerosSemana; //showWeekNumbers
    private $iDuracaoEvento; //hourIncrement
    private $iHoraInicial; //viewStartHour
    private $iMinutoInicial; //viewStartMinute
    private $iHoraFinal; //viewEndtHour
    private $iMinutoFinal; //viewEndMinute
    private $iConfigAgenda; //viewConfig
    private $sClasseEvento;
    private $sClasseTipoEvento;
    private $aAgenda;
    
    /**
     * Construtor da classe Calendario 
     */
    function __construct(){
        $this->sId = Base::getId();
        
        $this->setMostraBarraPerspectivas(true);
        $this->setMostraPerspectivaDia(true);
        $this->setMostraPerspectivaSemana(true);
        $this->setMostraPerspectivaMes(true);
        $this->setMostraHora(true);
        $this->setMostraCabecalhoMes(true);
        $this->setMostraLinksSemana(true);
        $this->setMostraNumerosSemana(false);
        
        $this->oStoreTipoEvento = new Store($this->getId().'-tipo-evento');
        $this->oStoreEvento = new Store($this->getId().'-evento');
        
        $this->aListener = array();
        $this->aAgenda = array();
    }
    
    /**
     * Retorna o conteњdo do atributo sId
     * 
     * @return string
     */
    public function getId() {
        return $this->sId;
    }
    
    /**
     * Define o valor do atributo sId
     * 
     * @return string
     */
    public function setId($sId) {
        $this->sId = $sId;
    }
    
    /**
     * Retorna o conteњdo do atributo sRenderTo
     * 
     * @return string
     */
    public function getRenderTo() {
        return $this->sRenderTo;
    }

    /**
     * Define o valor do atributo sRenderTo, referente ao ID do
     * objeto onde a tela deve ser renderizada
     * 
     * @param string $sRenderTo 
     */
    public function setRenderTo($sRenderTo) {
        $this->sRenderTo = $sRenderTo;
    } 
    
    /**
     * Retorna o conteњdo dos listeners (observadores) da tela
     * 
     * @return string
     */
    private function getListeners() {
        $sListeners = '';
        
        foreach($this->aListener as $key => $aAtual) {
            if($key > 0){
                $sListeners .= ', ';
            }
            $sListeners .= $aAtual[0].": function(".$aAtual[2]."){".$aAtual[1]."}";
        }
        
        return count($this->aListener) > 0 ? '{'.$sListeners.'}' : null;
    }    

    /**
     * Adiciona itens ao vetor de listener
     * 
     * @param string $sAcao Nome da aчуo
     * @param string $sFuncao Funчуo a ser executada 
     * @param string $sParam Parтmetros a serem adicionados na funчуo (string separada por vэrgulas)
     */     
    public function addListener($sAcao,$sFuncao,$sParams=null) {
        /*
         * Se a aчуo desejada jс existe na lista apenas adiciona a operaчуo,
         * senуo cria uma nova aчуo
         */
        $bExiste = false;
        foreach($this->aListener as $key => $aAtual) {
            if($aAtual[0] === $sAcao){
                $this->aListener[$key][1] .= $sFuncao; 
                $this->aListener[$key][2] .= $sParams; 
                $bExiste = true;
                break;
            }
        }
        
        if(!$bExiste){
            $this->aListener[] = array($sAcao,$sFuncao,$sParams);
        }
    } 
    
    /**
     * Retorna o conteњdo a ser renderizado do objeto responsсvel pelo
     * carregamento dos dados que indicam os tipos de eventos
     * 
     * @return string
     */          
    private function getRenderStoreTipoEvento(){
        $oProxy = new Proxy();
        $oProxy->setTipo(Proxy::AJAX);
        
        //configuraчѕes de leitura dos dados
        $oProxy->setUrlRead($this->getClasseTipoEvento(),'getDadosTipoEvento');
        $oProxy->setReader(Proxy::TIPO_JSON,self::ROOT_STORE_TIPO_EVENTO);
        
        $sStore = "Ext.create('Ext.calendar.data.MemoryCalendarStore', {"
                     ."proxy: ".$oProxy->getRender()
                  ."})";
       return $sStore;
    }
    
    /**
     * Retorna o conteњdo a ser renderizado do objeto responsсvel pelo
     * carregamento dos eventos
     * 
     * @return string
     */
    private function getRenderStoreEvento() {
        $oProxy = new Proxy();
        $oProxy->setTipo(Proxy::AJAX);
        
        //configuraчѕes de leitura dos dados
        $oProxy->setUrlRead($this->getClasseEvento(),'getDadosEvento');
        $oProxy->setReader(Proxy::TIPO_JSON,self::ROOT_STORE_EVENTO);
        
        //configuraчѕes de gravaчуo dos dados
        $oProxy->setUrlWrite($this->getClasseEvento(),'addEvento');
        $oProxy->setUrlUpdate($this->getClasseEvento(),'changeEvento');
        $oProxy->setUrlDelete($this->getClasseEvento(),'deleteEvento');
        $oProxy->setWriter(Proxy::TIPO_JSON,self::ROOT_STORE_EVENTO,true,'mapping');
        
        $oProxy->addExtraParam('ConfigAgenda',2);
        
        $sStore = "Ext.create('Ext.calendar.data.MemoryEventStore', {"
                     ."proxy: ".$oProxy->getRender()
                 ."})";
       return $sStore;
    }
    
    /**
     * Funчуo que cria a string com a listagem de agendas configuradas
     */
    public function getListaAgenda(){
        $sReturn = "xtype: 'treepanel',"
                  ."itemId: '".$this->getId()."-menu-agendas',"
                  ."title: 'Agendas',"
                  ."margin: '10 0 0 0',"
                  ."collapsible: true,"
                  ."style: 'border: 1px solid #fff; border-left: none; border-right: none;',"
                  ."listeners:{"
                  ."   itemclick: function(view, record, item, index, e){"
                          ."var dt = Ext.ComponentQuery.query('#".$this->getId()."-picker')[0].getValue();"
                          ."var calendar = Ext.ComponentQuery.query('#".$this->getId()."-calendar')[0];"
                          ."if(calendar){"
                             ."calendar.eventStore.removeAll();"
                             ."calendar.setViewConfig(record.raw.codigo);"
                             ."calendar.setViewStartHour(record.raw.inicio);"
                             ."calendar.setViewEndHour(record.raw.fim);"
                             ."calendar.setEventIncrement(record.raw.intervalo);"
                             ."calendar.reloadTemplate();"
                             ."calendar.setStartDate(dt);"
                             ."var evtWindow = Ext.ComponentQuery.query('#".$this->getId()."-eventWindow')[0];"
                             ."evtWindow.extraParam.viewConfig = record.raw.codigo;"
                             ."evtWindow.extraParam.timeIncrement = record.raw.intervalo;"
                             ."evtWindow.extraParam.timeStartHour = record.raw.inicio;"
                             ."evtWindow.extraParam.timeEndHour = record.raw.fim;"
                             ."evtWindow.reloadFieldsHour();"
                          ."}"        
                       ."}"
                   ."},"
                   ."rootVisible: false,"
                   ."root:{ children:[".$this->getAgenda()."]}";
        return $sReturn;
    }
    
    /**
     * Retorna o conteњdo da lista de agendas
     * 
     * @return string
     */
    private function getAgenda() {
        $sAgendas = '';
        
        foreach($this->aAgenda as $key => $aAtual) {
            if($key > 0){
                $sAgendas .= ', ';
            }
            $sAgendas .= "{ text:'".$aAtual['texto']."',"
                          ."leaf: true,"
                          ."codigo: ".$aAtual['codigo'].","
                          ."inicio: ".$aAtual['horaInicio'].","
                          ."fim: ".$aAtual['horaFim'].","
                          ."intervalo: ".$aAtual['intervalo']
                        ."}";
        }
        return $sAgendas;
    }

    /**
     * Adiciona itens ao vetor de agendas
     * 
     * @param integer $iCodigo Cѓdigo da agenda a ser exibida para filtro nos eventos
     * @param string $sTexto Descricуo da agenda a ser exibida no menu
     * @param integer $iHoraInicio Hora inicial da agenda
     * @param integer $iHoraFim Hora final da agenda
     * @param integer $iIntervalor Intervalor (em minutos) entre os eventos da agenda
     */     
    public function addAgenda($iCodigo,$sTexto,$iHoraInicio,$iHoraFim,$iIntervalo) {
        $this->aAgenda[] = array(
            'codigo' => $iCodigo,
            'texto' =>  $sTexto,
            'horaInicio' => $iHoraInicio,
            'horaFim' => $iHoraFim,
            'intervalo' => $iIntervalo
        );
    } 
    
    /**
     * Funчуo que cria a string da tela de manutenчуo da agenda
     */
    public function getTelaManutencao(){
        $sTela = "var calendarEventStore = Ext.ComponentQuery.query('#".$this->getId()."-calendar')[0].eventStore;"
                ."var eventWindow = "
                ."Ext.create('Ext.calendar.form.EventWindow', {"
                   ."itemId: '".$this->getId()."-eventWindow',"
                   ."calendarStore: ".$this->getRenderStoreTipoEvento().","
                   ."extraParam: {"
                      ."timeIncrement: ".$this->getDuracaoEvento().","
                      ."timeStartHour: ".$this->getHoraInicial().","
                      ."timeStartMinute: ".$this->getMinutoInicial().","
                      ."timeEndHour: ".$this->getHoraFinal().","
                      ."timeEndMinute: ".$this->getMinutoFinal().","
                      ."viewConfig: ".$this->getConfiguracao()
                   ."},"
                   ."listeners: {"
                      ."'eventadd': function(win, rec){"
                         ."win.hide();"
                         ."calendarEventStore.add(rec);"
                         ."calendarEventStore.sync({"
                            ."callback: function(batch, operation){"
                               ."var result = batch.operations[0].request.scope.reader.jsonData['success'];"
                               ."if(!result){"
                                  ."calendarEventStore.remove(rec);"
                               ."} else{"
                                  ."calendarEventStore.reload();"
                               ."}"
                            ."}"
                         ."});"
                      ."},"
                      ."'eventupdate': function(win, rec){"
                         ."win.hide();"
                         ."calendarEventStore.sync({"
                            ."callback: function(batch, operation){"
                               ."var result = batch.operations[0].request.scope.reader.jsonData['success'];"
                               ."if(!result){"
                                  ."calendarEventStore.rejectChanges();"
                               ."} else{"
                                  ."calendarEventStore.reload();"
                               ."}"
                            ."}"
                         ."});"
                      ."},"
                      ."'eventdelete': function(win, rec){"
                         ."win.hide();"
                         ."calendarEventStore.remove(rec);"
                         ."calendarEventStore.sync({"
                            ."callback: function(batch, operation){"
                               ."var result = batch.operations[0].request.scope.reader.jsonData['success'];"
                               ."if(!result){"
                                  ."calendarEventStore.rejectChanges();"
                               ."}"
                            ."}"
                         ."});"
                      ."},"
                      ."'render': function(){"
                         .Base::getFuncaoCentraliza()
                      ."}"
                    ."},"
                    ."renderTo: '".$this->getRenderTo()."'"
                 ."});";
        return $sTela;
    }
    
    /**
     * Retorna o conteњdo do atributo sClasseEvento
     * 
     * @return string
     */
    public function getClasseEvento() {
        return isset($this->sClasseEvento) ? $this->sClasseEvento : self::CLASSE_EVENTO_PADRAO;
    }
    
    /**
     * Define o valor do atributo sClasseEvento
     * 
     * @return string
     */
    public function setClasseEvento($sClasseEvento) {
        $this->sClasseEvento = $sClasseEvento;
    }
    
     /**
     * Retorna o conteњdo do atributo sClasseTipoEvento
     * 
     * @return string
     */
    public function getClasseTipoEvento() {
        return isset($this->sClasseTipoEvento) ? $this->sClasseTipoEvento : self::CLASSE_EVENTO_PADRAO_TIPO;
    }
    
    /**
     * Define o valor do atributo sClasseTipoEvento
     * 
     * @return string
     */
    public function setClasseTipoEvento($sClasseTipoEvento) {
        $this->sClasseTipoEvento = $sClasseTipoEvento;
    }
    
    /**
     * Retorna o conteњdo do atributo iPerspectiva
     * 
     * @return integer
     */
    public function getPerspectiva() {
        return isset($this->iPerspectiva) ? $this->iPerspectiva : self::PERSPECTIVA_DIA;
    }
    
    /**
     * Define o valor do atributo iPerspectiva
     * 
     * @return integer
     */
    public function setPerspectiva($iPerspectiva) {
        $this->iPerspectiva = $iPerspectiva;
    }
    
    /**
     * Retorna o conteњdo do atributo bMostraPerspectivaDia
     * 
     * @return boolean
     */
    private function getMostraPerspectivaDia() {
        return $this->bMostraPerspectivaDia;
    }

    /**
     * Define o valor do atributo bMostraPerspectivaDia
     * 
     * @param boolean bMostraPerspectivaDia
     */
    public function setMostraPerspectivaDia($bMostraPerspectivaDia) {
        $this->bMostraPerspectivaDia = $bMostraPerspectivaDia;
    }
    
    /**
     * Retorna o conteњdo do atributo bMostraPerspectivaSemana
     * 
     * @return boolean
     */
    private function getMostraPerspectivaSemana() {
        return $this->bMostraPerspectivaSemana;
    }

    /**
     * Define o valor do atributo bMostraPerspectivaSemana
     * 
     * @param boolean bMostraPerspectivaSemana
     */
    public function setMostraPerspectivaSemana($bMostraPerspectivaSemana) {
        $this->bMostraPerspectivaSemana = $bMostraPerspectivaSemana;
    }
    
    /**
     * Retorna o conteњdo do atributo bMostraPerspectivaMes
     * 
     * @return boolean
     */
    private function getMostraPerspectivaMes() {
        return $this->bMostraPerspectivaMes;
    }

    /**
     * Define o valor do atributo bMostraPerspectivaMes
     * 
     * @param boolean bMostraPerspectivaMes
     */
    public function setMostraPerspectivaMes($bMostraPerspectivaMes) {
        $this->bMostraPerspectivaMes = $bMostraPerspectivaMes;
    }
    
    /**
     * Retorna o conteњdo do atributo bMostraBarraPerspectivas
     * 
     * @return boolean
     */
    private function getMostraBarraPerspectivas() {
        return $this->bMostraBarraPerspectivas;
    }

    /**
     * Define o valor do atributo bMostraBarraPerspectivas
     * 
     * @param boolean bMostraBarraPerspectivas
     */
    public function setMostraBarraPerspectivas($bMostraBarraPerspectivas) {
        $this->bMostraBarraPerspectivas = $bMostraBarraPerspectivas;
    }

    /**
     * Define o valor do atributo bMostraHora
     * 
     * @param boolean bMostraHora
     */
    public function setMostraHora($bMostraHora) {
        $this->bMostraHora = $bMostraHora;
    }
    
    /**
     * Retorna o conteњdo do atributo bMostraHora
     * 
     * @return boolean
     */
    private function getMostraHora() {
        return $this->bMostraHora;
    }
    
    /**
     * Define o valor do atributo bMostraCabecalhoMes
     * 
     * @param boolean bMostraCabecalhoMes
     */
    public function setMostraCabecalhoMes($bMostraCabecalhoMes) {
        $this->bMostraCabecalhoMes = $bMostraCabecalhoMes;
    }
    
    /**
     * Retorna o conteњdo do atributo bMostraCabecalhoMes
     * 
     * @return boolean
     */
    private function getMostraCabecalhoMes() {
        return $this->bMostraCabecalhoMes;
    }
    
    /**
     * Define o valor do atributo bMostraLinksSemana
     * 
     * @param boolean bMostraLinksSemana
     */
    public function setMostraLinksSemana($bMostraLinksSemana) {
        $this->bMostraLinksSemana = $bMostraLinksSemana;
    }
    
    /**
     * Retorna o conteњdo do atributo bMostraLinksSemana
     * 
     * @return boolean
     */
    private function getMostraLinksSemana() {
        return $this->bMostraLinksSemana;
    }
    
    /**
     * Define o valor do atributo bMostraNumerosSemana
     * 
     * @param boolean bMostraNumerosSemana
     */
    public function setMostraNumerosSemana($bMostraNumerosSemana) {
        $this->bMostraNumerosSemana = $bMostraNumerosSemana;
    }
    
    /**
     * Retorna o conteњdo do atributo bMostraNumerosSemana
     * 
     * @return boolean
     */
    private function getMostraNumerosSenama() {
        return $this->bMostraNumerosSemana;
    }
    
    /**
     * Retorna o conteњdo do atributo sConfiguracaoMes
     * 
     * @return boolean
     */
    private function getConfiguracaoMes(){
        $sRetorno  = 'showHeader: '.($this->getMostraCabecalhoMes() ? 'true' : 'false').',';
        $sRetorno .= 'showWeekLinks: '.($this->getMostraLinksSemana() ? 'true' : 'false').',';
        $sRetorno .= 'showWeekNumbers: '.($this->getMostraNumerosSenama() ? 'true' : 'false');
        
        return '{'.$sRetorno.'}';
    }
    
    /**
     * Retorna o conteњdo do atributo iDuracaoEvento
     * 
     * @return integer
     */
    public function getDuracaoEvento() {
        return $this->iDuracaoEvento;
    }
    
    /**
     * Define o valor do atributo iDuracaoEvento, ou seja, qual serс o tempo,
     * em minutos, para cada evento no calendсrio
     * 
     * @return integer
     */
    public function setDuracaoEvento($iDuracaoEvento) {
        $this->iDuracaoEvento = $iDuracaoEvento;
    }
    
    /**
     * Retorna o conteњdo do atributo iHoraInicial
     * 
     * @return integer
     */
    public function getHoraInicial() {
        return isset($this->iHoraInicial) ? $this->iHoraInicial : 0;
    }
    
    /**
     * Define o valor do atributo iHoraInicial, ou seja, qual serс 
     * a primeira hora exibida no calendсrio
     * 
     * @return integer
     */
    public function setHoraInicial($iHoraInicial) {
        $this->iHoraInicial = $iHoraInicial;
    }
    
    /**
     * Retorna o conteњdo do atributo iMinutoInicial
     * 
     * @return integer
     */
    public function getMinutoInicial() {
        return isset($this->iMinutoInicial) ? $this->iMinutoInicial : 0;
    }
    
    /**
     * Define o valor do atributo iMinutoInicial, ou seja, qual serс 
     * o minuto inicial da primeira hora do calendсrio
     * 
     * @return integer
     */
    public function setMinutoInicial($iMinutoInicial) {
        $this->iMinutoInicial = $iMinutoInicial;
    }
    
    /**
     * Retorna o conteњdo do atributo iHoraFinal
     * 
     * @return integer
     */
    public function getHoraFinal() {
        return isset($this->iHoraFinal) ? $this->iHoraFinal : 23;
    }
    
    /**
     * Define o valor do atributo iHoraInicial, ou seja, qual serс 
     * a њltima hora exibida no calendсrio
     * 
     * @return integer
     */
    public function setHoraFinal($iHoraFinal) {
        $this->iHoraFinal = $iHoraFinal;
    }
    
    /**
     * Retorna o conteњdo do atributo iMinutoFinal
     * 
     * @return integer
     */
    public function getMinutoFinal() {
        return isset($this->iMinutoFinal) ? $this->iMinutoFinal : 0;
    }
    
    /**
     * Define o valor do atributo iMinutoFinal, ou seja, qual serс 
     * o minuto final da њltima hora do calendсrio
     * 
     * @return integer
     */
    public function setMinutoFinal($iMinutoFinal) {
        $this->iMinutoFinal = $iMinutoFinal;
    }
    
    /**
     * Retorna o conteњdo do atributo iConfigAgenda
     * 
     * @return integer
     */
    public function getConfiguracao() {
        return isset($this->iConfigAgenda) ? $this->iConfigAgenda : 0;
    }
    
    /**
     * Define o valor do atributo iConfigAgenda, ou seja, qual serс 
     * a configuraчуo de agenda inicial, caso existam mais configuraчѕes
     * as mesmas poderуo ser trocadas no menu exibido abaixo do calendсrio
     * 
     * @return integer
     */
    public function setConfiguracao($iConfigAgenda) {
        $this->iConfigAgenda = $iConfigAgenda;
    }
    
    /** 
     * Gera a string do objeto para que possa ser renderizado
     * pelo JSON
     * 
     * @return string String do objeto a ser renderizado 
     */
    public function getRender(){
        /*
         * adiciona os listeners de comportamento padrуo do componente
         */
        
        //aчуo que executa ao clicar sobre algum evento, abre a tela com as informaчѕes carregadas
        $sFuncao = "eventWindow.show(record, el);";
        $this->addListener(self::EVENTO_CLICK,$sFuncao,"view, record, el");
        
        //aчуo que ocorre ao clicar sobre os grids (dia, semana, mъs)
        $sFuncao = "eventWindow.show({"
                     ."StartDate: date,"
                     ."IsAllDay: allDay"
                  ."}, el);";
        $this->addListener(self::EVENTO_DAY_CLICK,$sFuncao,"view, date, allDay, el");
        
        //aчуo que ocorre ao redimensionar (aumentar ou reduzir) o tempo de um evento
        $sFuncaoUpdate = "var calendarEventStore = Ext.ComponentQuery.query('#".$this->getId()."-calendar')[0].eventStore;"
                        ."calendarEventStore.sync({"
                           ."callback: function(batch, operation){"
                              ."var result = batch.operations[0].request.scope.reader.jsonData['success'];"
                              ."if(!result){"
                                 ."calendarEventStore.rejectChanges();"
                              ."}"
                           ."}"
                        ."});";
        $this->addListener(self::EVENTO_RESIZE,$sFuncaoUpdate,"view, record");
        
        //aчуo que ocorre ao mover um evento na tela
        $this->addListener(self::EVENTO_MOVE,$sFuncaoUpdate,"view, record");
        
        //aчуo que ocorre ao iniciar a movimentaчуo dos elementos na tela
        $sFuncao = "if(eventWindow && eventWindow.isVisible()){"
                     ."eventWindow.hide();"
                   ."}";
        $this->addListener(self::EVENTO_DRAG,$sFuncao,"view");
        
        //aчуo que ocorre apѓs selecionar vсrias linhas no grid (permite criar novo eventos por intervalos)
        $sFuncao = "eventWindow.show(dates);"
                  ."eventWindow.on('hide', onComplete, this, {single:true});";
        $this->addListener(self::EVENTO_RANGE,$sFuncao,"window, dates, onComplete");
        
        /*
         * eventos que podem ser implementados no componente
         */
        //$this->addListener(self::EVENTO_OVER,"","view, record, el");
        //$this->addListener(self::EVENTO_OUT,"","view, record, el");
        //$this->addListener(self::EVENTO_ADD,$sFuncao,"form, record");
        //$this->addListener(self::EVENTO_UPDATE,$sFuncao,"form, record");
        //$this->addListener(self::EVENTO_DELETE,$sFuncao,"window, record");
        //$this->addListener(self::EVENTO_CANCEL,"","form, record");
        //$this->addListener(self::EVENTO_VIEW_CHANGE,$sFuncao,"panel, view, info");
        
        $aRender = array(
            "xtype" => 'calendarpanel',
            "itemId" => $this->getId()."-calendar",
            "calendarStore" => $this->getRenderStoreTipoEvento(),
            "eventStore" => $this->getRenderStoreEvento(),
            "activeItem" => $this->getPerspectiva(),
            "showNavBar" => $this->getMostraBarraPerspectivas(),
            "showDayView" => $this->getMostraPerspectivaDia(),
            "showWeekView" => $this->getMostraPerspectivaSemana(),
            "showMonthView" => $this->getMostraPerspectivaMes(),
            "showTime" => $this->getMostraHora(),
            "monthViewCfg" => $this->getConfiguracaoMes(),
            "eventIncrement" => $this->getDuracaoEvento(),
            "viewStartHour" => $this->getHoraInicial(),
            "viewStartMinute" => $this->getMinutoInicial(),
            "viewEndHour" => $this->getHoraFinal(),
            "viewEndMinute" => $this->getMinutoFinal(),
            "viewConfig" => $this->getConfiguracao(),
            "listeners" => $this->getListeners()
        );
        
        $sRender =  "Ext.create('Ext.panel.Panel', {"
                      ."layout: 'border',"
                      ."border: true,"
                      ."items: [{"
                         ."xtype: 'panel',"
                         ."itemId: '".$this->getId()."-region-west',"
                         ."region: 'west',"
                         ."title: 'Calendсrio',"
                         ."collapsible: true,"
                         ."split: true,"
                         ."width: 220,"
                         ."maxWidth: 220,"
                         ."layoutConfig: {"
                            ."fill: false,"
                            ."animate: true"
                         ."},"
                         ."padding: '3',"
                         ."bodyStyle:{"
                            ."backgroundColor: '#157fcc'"
                         ."},"
                         ."items: [{"
                            ."xtype: 'datepicker',"
                            ."itemId: '".$this->getId()."-picker',"
                            ."cls: 'ext-cal-nav-picker',"
                            ."listeners: {"
                               ."'select': {"
                                  ."fn: function(dp, dt){"
                                     ."Ext.ComponentQuery.query('#".$this->getId()."-calendar')[0].setStartDate(dt);"
                                  ."},"
                                  ."scope: this"
                               ."}"
                            ."}"
                         ."},{"
                            .$this->getListaAgenda()
                         ."}]"
                      ."},{"
                         ."region: 'center',"
                         ."itemId: '".$this->getId()."-region-center',"
                         ."style:{"
                            ."border: '3px solid #5A91D2',"
                            ."borderLeft: 'none'"
                         ."},"
                         .Base::getRender($aRender)
                      ."}]"
                   ."})";
        
        return Base::addObj($sRender,$this->getRenderTo()).$this->getTelaManutencao();
    }
}
?>