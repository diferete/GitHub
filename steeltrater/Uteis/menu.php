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
     Ext.create('Ext.container.Viewport', {
          layout: 'border',
          id: 'containerSistema',
          title:'menu norte',
          items: [
           //PARTE DO MENU DO SISTEMA 
            { region: 'north',
                height: 100, // give north and south regions a height
                collapsible: true,
                collapsed: true,
                items:[{
                    xtype:'splitbutton',
                    id: 'effecti-2748454380f27b6325',
                    iconCls: 'icon-areaUser',
                    scale: 'medium',
                    iconAlign: 'left',
                    text: 'avanei@rexmaquinas.com.br'
                        }]
                },
                 {region: 'west',
                     id: 'containerMenu',
                     padding: '0 0 4 4',
                     collapsible: true,
                    //collapsed: true,
                     border: true,
                     title: 'Menu',
                     iconCls: 'icon-menu',
                     split: true,
                     width: '20%',
                     minWidth: 200,
                     layout: 'accordion',
                     defaultType: 'treepanel',
                     layoutConfig: {animate: true},
                     defaults: {
                         border: false,
                         rootVisible: false,
                         listeners:{itemclick: function(view, record, item, index, e){var tabPanel = Ext.ComponentQuery.query('#containerTelas')[0];
                                 var aba = tabPanel.items.findBy(function(rec){return rec.title === record.raw.text;});
                                 if(!aba){var container = Ext.ComponentQuery.query('#containerSistema')[0];
                                     container.getEl().mask('Carregando '+record.raw.text+'...');
                                     id = Ext.id();
                                     alert(id);
                                     aba = tabPanel.add({iconCls: 'icon-tabs',title: record.raw.text,layout: 'card',closable: true,id: id});
                                     requestAjax('',record.raw.classe,record.raw.metodo,[id,record.raw.parametros]);}
                                     tabPanel.setActiveTab(aba.id);}}},
                         //ITENS DO MENU DO SISTEMA
                                      items: [
                                          { title: 'COMPRAS',
                                            iconCls: 'resources/img/',
                                            root: {children: [
                                                    { text: 'Teste',leaf: true,iconCls: 'resources/img/',classe: '31',metodo: '1',parametros: ''}
                                                ]
                                            }
                                          }
                                            ]
                               },
                         //PARTE CENTRAL DO SISTEMA               
                            {region: 'center',
                             padding: '0 4 4 0',
                             bodyStyle: {
                                 //backgroundImage: url(index.php?classe=Arquivo&metodo=getFileBD&empCodigo=1&codigo=4)',
                                 // backgroundRepeat: 'no-repeat',
                                 /*backgroundPosition: 'center'*/},
                                 xtype: 'tabpanel',
                                 bodyPadding: 3,
                                 frame: false,
                                 id: 'containerTelas',
                                 activeTab: 0,
                                 items: [],
                                 plugins: Ext.create('Ext.src.TabCloseMenu')
                             }
                         
        
        
        
                         ]});
     
     
     
     
     
     
     </script>  
    </body>
</html>
 