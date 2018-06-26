<html xmlns=?http://www.w3.org/1999/xhtml? xml:lang=?pt-br? lang=?pt-br?>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
<meta http-equiv='Cache-Control' content='no-cache'>
<meta name='Copyright' content='© 2014 Metalbo - Metalbo' />
<base href='http://localhost:8081/dropbox/rg_construtora/index.php' />
<title>Metalbo - Metalbo</title>
<link rel='shortcut icon' href='resources/img/favicon.gif'/> 
<link rel='stylesheet' type='text/css' href='biblioteca/ext-4.2.1.883/resources/css/ext-all.css?1411503689' />
<link rel='stylesheet' type='text/css' href='biblioteca/ext-4.2.1.883/resources/css/ext-all-gray.css?1411503689' />
<link rel='stylesheet' type='text/css' href='biblioteca/ext-4.2.1.883/src/grid/filter/css/GridFilters.css?1411503689' />
<link rel='stylesheet' type='text/css' href='biblioteca/ext-4.2.1.883/src/grid/filter/css/RangeMenu.css?1411503689' />
<link rel='stylesheet' type='text/css' href='biblioteca/ext-4.2.1.883/src/calendar/resources/css/calendar.css?1411503689' />
<link rel='stylesheet' type='text/css' href='biblioteca/ext-4.2.1.883/src/colorpicker/resources/css/colorpicker.css?1411503689' />
<script type='text/javascript' src='biblioteca/ext-4.2.1.883/ext-all.js?1411503689'></script>
<script type='text/javascript' src='biblioteca/ext-4.2.1.883/locale/ext-lang-pt_BR.js?1411503689'></script>
<script type='text/javascript' src='resources/js/vTypes.js?1411503689'></script>
<script type='text/javascript' src='resources/js/app.js?1411503689'></script>
<link rel='stylesheet' href='resources/css/estilos.css?1411503689' type='text/css'>
</head>
    <body>
     <script type='text/javascript'> 
        var oRender = Ext.ComponentQuery.query('#ext-gen1186')[0];
        if(oRender){oRender.add(Ext.create('Ext.grid.Panel', {
                frame: false,
                iconCls: 'icon-grid',
                loadMask: true,
                id: 'effecti-726754543beaa48ca',
                title: 'Consulta de Teste do Sistema',
                closable: true,
                resizable: false,
                draggable: true,
                collapsible: false,
                height: 100,width: 100,
                store: Ext.create('Ext.data.Store', {
                    storeId: 'store-effecti-726754543beaa48ca',
                    remoteSort: true,
                    proxy: {type: 'ajax',
                        autoLoad: true,
                        api: {read:'index.php?classe=Teste&metodo=getDadosConsulta'},
                        reader: {type: 'json',
                            root: 'dados',
                            successProperty: 'success',
                            totalPropety:  'total'},
                        listeners: {exception: function(el, request, operation, eOpts)
                            {var msgBox = Ext.Msg.show({
                                    title: 'Erro - Proxy',
                                    msg: 'Erro ao processar requisição \nAção: '+operation.action.toUpperCase()+'',
                                    fn: function(){},buttons: Ext.Msg.OK,icon: Ext.Msg.ERROR
                                });
                                msgBox.itemId = 'effecti-2876854543beaa5870';
                            }}},
                    pageSize: 20,
                    fields: [{name: 'obs'},{name: 'chave',type: 'string'}],
                    autoLoad: {start: 0, limit: 20}}),
                columns: [{header: 'Obs',
                        width: 250,
                        align: 'left',
                        sortable: true,
                        dataIndex: 'obs',
                        filterable: true,
                        filter: { type:'string',
                            xtype:'textfield',
                            emptyText:'Obs...'},
                        hidden: false,
                        hideable: true},
                    {header: 'chave',
                        width: 250,
                        align: 'left',
                        sortable: true,
                        dataIndex: 'chave',
                        filterable: true,
                        filter: { type:'string',xtype:'textfield',emptyText:'chave...'},
                        hidden: true,
                        hideable: false,
                        renderer: function(value, metaData, record) {
                            metaData.tdAttr = 'data-qtip="'+Ext.String.htmlEncode(value)+'"';
                            if(value != null && value != '' && 0 > 0){value = Ext.util.Format.TextMask.setMask('').mask(value);}
                            return value;}}],
                viewConfig: {loadingText: 'Carregando consulta...', enableTextSelection: true},
                listeners: {beforeclose: function(){var oRender = Ext.ComponentQuery.query('#ext-gen1186')[0];
                    if(oRender){var layout = oRender.getLayout();
                        if(layout.type === 'card' && layout.getLayoutItems().length > 1)
                        {var bReloadPrevious = true;
                            if(layout.getActiveItem() instanceof Ext.form.Panel)
                            {bReloadPrevious = layout.getActiveItem().reloadPreviousOnClose;}
                            layout.setActiveItem(oRender.getLayout().getPrev());
                            oRender.remove(layout.getNext());
                            if(layout.getActiveItem() instanceof Ext.grid.Panel && bReloadPrevious)
                            {layout.getActiveItem().getStore().reload();}} else
                        {oRender.close();}} 
                        else{alert('Erro ao carregar objeto: Base->getAcaoFechar()');}}, 
                    celldblclick: function(el, td, cellIndex, record, tr, rowIndex, e, eOpts)
                    {requestAjax('','31','3',['ext-gen1186',record.getData(true).chave]);}, 
                    afterrender: function(grid){grid.filters.createFilters()}, 
                    render: function(){var obj = Ext.get('effecti-726754543beaa48ca');
                panelDrag = new Ext.dd.DD(obj,'uRequest_DDGroup');
                panelDrag.setHandleElId(obj.header);
                panelDrag.startDrag = function(){ this.constrainTo('ext-gen1186'); };}},
        dockedItems: [{xtype: 'toolbar',
                dock: 'top',
                items: [{xtype: 'button',
                        id: 'effecti-1871354543beaa8152',
                        iconCls: 'icon-add',
                        scale: 'small',
                        iconAlign: 'left',
                        text: 'Adicionar',
                        style: 'margin-left: 3px;',
                        handler: function(){ requestAjax('','31','2',['ext-gen1186',null,'']); },
                        validaForm: false,
                        multiSelecaoGrid: true}, 
                    {xtype: 'button',
                        id: 'effecti-710354543beaaa261',
                        iconCls: 'icon-edit',
                        scale: 'small',
                        iconAlign: 'left',
                        text: 'Alterar',
                        style: 'margin-left: 3px;',
                        handler: function(){ var telaConsulta = Ext.ComponentQuery.query('#effecti-726754543beaa48ca')[0];
                            if(telaConsulta.getSelectionModel().hasSelection())
                            {var telaConsulta = Ext.ComponentQuery.query('#effecti-726754543beaa48ca')[0];
                                var rows = telaConsulta.getSelectionModel().getSelection();
                                requestAjax('','31','3',['ext-gen1186',rows[0].getData(true).chave]);
                            } else{var msgBox = Ext.Msg.show({title: 'Alerta',msg: 'Selecione um ou mais registros para executar a ação',fn: function(){},
                                    buttons: Ext.Msg.OK,icon: Ext.Msg.WARNING});
                                msgBox.itemId = 'effecti-2812654543beaa8b42';
                                Ext.defer(function() {var msg = Ext.ComponentQuery.query('#effecti-2812654543beaa8b42')[0];
                                    if(msg && msg.itemId == 'effecti-2812654543beaa8b42' && msg.isVisible())
                                    {msg.close();}},2500);} },
                        validaForm: false,
                        multiSelecaoGrid: false}, 
                    {xtype: 'button',
                        id: 'effecti-253854543beaadc3c',
                        iconCls: 'icon-delete',
                        scale: 'small',
                        iconAlign: 'left',
                        text: 'Remover',
                        style: 'margin-left: 3px;',
                        handler: function(){ 
                            var telaConsulta = Ext.ComponentQuery.query('#effecti-726754543beaa48ca')[0];
                            if(telaConsulta.getSelectionModel().hasSelection()){
                                var msgBox = Ext.Msg.show({title: 'Pergunta',
                                    msg: 'Deseja realmente excluir o(s) registro(s) selecionado(s)?',
                                    fn: function(opc){ if(opc === 'no' || opc === 'cancel'){return;}var telaConsulta = Ext.ComponentQuery.query('#effecti-726754543beaa48ca')[0];
                                        var rows = telaConsulta.getSelectionModel().getSelection();
                                        telaConsulta.getEl().mask('Removendo registro(s)...');
                                        var chave = new Array();
                                        Ext.Array.each(rows, function(row) {chave.push(row.getData(true).chave);});
                                        requestAjax('','31','4',['effecti-726754543beaa48ca',chave]);},
                                    buttons: Ext.Msg.YESNO,
                                    icon: Ext.Msg.QUESTION});
                                msgBox.itemId = 'effecti-1294054543beaaab9f';} 
                            else{var msgBox = Ext.Msg.show({title: 'Alerta',msg: 'Selecione um ou mais registros para executar a ação',
                                    fn: function(){},
                                    buttons: Ext.Msg.OK,
                                    icon: Ext.Msg.WARNING});
                                msgBox.itemId = 'effecti-2402154543beaac060';
                                Ext.defer(function() {var msg = Ext.ComponentQuery.query('#effecti-2402154543beaac060')[0];if(msg && msg.itemId == 'effecti-2402154543beaac060' && msg.isVisible()){msg.close();}},2500);} },validaForm: false,multiSelecaoGrid: true}, {xtype: 'button',id: 'effecti-2751254543beab172d',iconCls: 'icon-view',scale: 'small',iconAlign: 'left',text: 'Visualizar',style: 'margin-left: 3px;',handler: function(){ var telaConsulta = Ext.ComponentQuery.query('#effecti-726754543beaa48ca')[0];if(telaConsulta.getSelectionModel().hasSelection()){var telaConsulta = Ext.ComponentQuery.query('#effecti-726754543beaa48ca')[0];var rows = telaConsulta.getSelectionModel().getSelection();requestAjax('','31','5',['ext-gen1186',rows[0].getData(true).chave]);} else{var msgBox = Ext.Msg.show({title: 'Alerta',msg: 'Selecione um ou mais registros para executar a ação',fn: function(){},buttons: Ext.Msg.OK,icon: Ext.Msg.WARNING});msgBox.itemId = 'effecti-1353154543beaaedcf';Ext.defer(function() {var msg = Ext.ComponentQuery.query('#effecti-1353154543beaaedcf')[0];if(msg && msg.itemId == 'effecti-1353154543beaaedcf' && msg.isVisible()){msg.close();}},2500);} },validaForm: false,multiSelecaoGrid: false}]},{xtype: 'pagingtoolbar',store: 'store-effecti-726754543beaa48ca',dock: 'bottom',displayInfo: true,displayMsg: 'Exibindo {0} - {1} de {2} registro(s)'}],features: [{ id: 'filters',ftype: 'filters',encode: true}],allowBlank: true,selModel: Ext.create('Ext.selection.CheckboxModel',{listeners: {select: function(){var grid = Ext.ComponentQuery.query('#effecti-726754543beaa48ca')[0];if(grid.getSelectionModel().hasSelection()){var linhas = grid.getView().getSelectionModel().getSelection();if(linhas.length > 1){var buttons = Ext.ComponentQuery.query('#effecti-726754543beaa48ca button[multiSelecaoGrid=false]');Ext.Array.each(buttons, function(btn) {btn.setDisabled(true);});}}},deselect: function(){var grid = Ext.ComponentQuery.query('#effecti-726754543beaa48ca')[0];var linhas = grid.getView().getSelectionModel().getSelection();if(linhas.length <= 1){var buttons = Ext.ComponentQuery.query('#effecti-726754543beaa48ca button[multiSelecaoGrid=false]');Ext.Array.each(buttons, function(btn) {btn.setDisabled(false);});}}}})}));var container = Ext.ComponentQuery.query('#containerSistema')[0];if(container){container.getEl().unmask();}var layout = oRender.getLayout();if(layout.type === 'card' && layout.getLayoutItems().length > 1){layout.setActiveItem(layout.getNext());}}


      </script>  
    </body>
</html>
 