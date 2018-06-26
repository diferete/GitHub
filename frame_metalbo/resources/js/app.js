/**
 * Funções do sistema
 * 
 * Desenvolvido por Avanei Martendal
 * Data: 25/09/2015
 *
 */
Ext.Loader.setConfig({ 
    enabled: true,
    paths: {
        'Ext.src': 'biblioteca/ext-4.2.1.883/src',
        'Ext.calendar': 'biblioteca/ext-4.2.1.883/src/calendar/src'
    }
});

Ext.application({
    name: 'effecti',
    requires:[
        'Ext.src.SessionMonitor',
        'Ext.src.data.proxy.PagingMemoryProxy',
        'Ext.src.grid.filter.FiltersFeature',
        'Ext.src.grid.filterbutton.FilterButton',
        'Ext.src.TextMaskPlugin',
        'Ext.src.field.Money',
        'Ext.src.TabCloseMenu',
        'Ext.src.IFrame',
        'Ext.calendar.CalendarPanel',
        'Ext.colorpicker.src.ux.colorpicker.ColorPicker', 
        'Ext.colorpicker.src.ux.colorpicker.ColorPickerField',
        'Ext.src.view.DragSelector'
    ],
   launch: function(){
        Ext.get('loadingContainer').remove();
    },
    init: function() {
        Ext.setGlyphFontFamily('Pictos');
        Ext.tip.QuickTipManager.init();
    }
});

//função que remove todos os elementos do objeto passado
function removeEl(object){
    //captura o objeto a partir do nome passado
    var obj = Ext.DomQuery.selectNode(object);

    //remove os elementos do objeto
    while(obj.firstChild) {
        obj.removeChild(obj.firstChild);
    }                     
}

//realiza as requisições Ajax
function requestAjax(idForm,classe,metodo,parametros){
    //montagem da string JSON dos parâmetros
    var aParametros = {};
    aParametros['classe'] = classe;
    aParametros['metodo'] = metodo;
    
    if(idForm !== ''){
        //captura os campos do form que está sendo visualizado
        aParametros['campos'] = Ext.encode(Ext.ComponentQuery.query('#'+idForm)[0].getForm().getFieldValues());
        
        //verifica se existem grids na tela e captura seus dados
        var grids = Ext.ComponentQuery.query('#'+idForm+' gridpanel');
        if(grids.length > 0){
            var records = []; 

            grids[0].getStore().each(function(record){
                records.push(record.data);
            });
            aParametros['records'] = Ext.encode(records);
        }
    }
    
    //carrega os parametros do método caso existam
    if(parametros !== undefined){
        aParametros['parametros[]'] = parametros;
    }
    
    Ext.Ajax.request({
        method: 'POST',
        url: 'index.php',
        params: aParametros,
        success: function(response){
            try{
                var json = response.responseText !== '' ? Ext.decode(response.responseText) : new Array();
                if(json !== null){
                    for(var i=0;i<json.length;i++){
                        switch (json[i].tipo){
                            case 'render':
                                eval(json[i].conteudo);
                            break;
                        }
                    }
                }
            } catch(error){
                Ext.Msg.show({
                    title:'Erro',
                    msg: 'Erro: '+error,
                    buttons: Ext.Msg.OK,
                    icon: Ext.Msg.ERROR
                });
            }
        },
        failure: function(response){
            Ext.Msg.show({
                title:'Erro',
                msg: Ext.decode(response.responseText),
                buttons: Ext.Msg.OK,
                icon: Ext.Msg.ERROR
            });
        }     
    });
}