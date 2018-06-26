<?php
/**
 * Classe que implementa a estrutura Chart do ExtJs
 *
 * @author Everton Porath
 * @since 28/11/2013
 */

//inclusуo da classe Store
Fabrica::requireBibliotecaVisual('Store');

class Grafico {
    private $sId; //id
    private $Store;
    private $aOrigemDados;
    
    function __construct() {
        $this->sId = Base::getId();
        
    }
    public function getSId() {
        return $this->sId;
    }
    public function setSId($sId) {
        $this->sId = $sId;
    }
    public function getStore() {
        return $this->Store;
    }

    public function setStore($Store) {
        $this->Store = $Store;
    }
    /**
     * Define a origem de dados da consulta
     * Mѓdulo, classe e mщtodo
     * 
     * @param string $sClasse
     * @param string $sMetodo
     */
    public function setOrigemDados($sClasse,$sMetodo,$sParametros=null) {
        $this->aOrigemDados[0] = $sClasse;
        $this->aOrigemDados[1] = $sMetodo;
        $this->aOrigemDados[2] = $sParametros;
    }    
    
    /**
     * Retorna o conteњdo do vetor de colunas na estrutura que 
     * deverс ser renderizado
     * 
     * @return string
     */     
    private function getRenderStore() {
        $oProxy = $this->getStore()->getProxy();
        
        if($this->getIsItemForm()){
            $oProxy->setTipo(Proxy::MEMORY_PROXY);
            
            $this->oStore->setDados($this->getDados());
        } else{
            $oProxy->setTipo(Proxy::AJAX);
            $oProxy->setUrlRead($this->aOrigemDados[0],$this->aOrigemDados[1],$this->aOrigemDados[2]);
            
            $this->oStore->setAutoLoad(0,$this->getRegistrosPaginacao());
            $this->oStore->setLinhasPagina($this->getRegistrosPaginacao());
        }
        
        //verifica se existe agrupamento definido
        if($this->getAgrupamento() != null){
            $this->getStore()->setAgrupamento($this->getAgrupamento());
            
            //define a situaчуo inicial do agrupamento
            $this->getStore()->setIniciaFechada($this->getIniciaFechada());
        }
        
        $this->getStore()->setCampos($this->getArrayCampos());
        
        return $this->getStore()->getRender();
    }

        
    /** 
     * Gera a string do objeto para que possa ser renderizado
     * pelo JSON
     * 
     * @return string String do objeto a ser renderizado 
     */
    public function getRender(){
 /*
            var store = Ext.create('Ext.data.JsonStore', {
                fields: ['name', 'data1'],
                data: [
                    {'name':'Batata', 'data1':100},
                    {'name':'Aipim', 'data1':100},
                    {'name':'Chuchu', 'data1':100},
                    {'name':'Feijуo', 'data1':50},
                    {'name':'Arroz', 'data1':50},        
                    {'name':'Melтncia', 'data1':600}                                                
                ]
            });     */   
        $sRender = "{
                xtype: 'chart',
                id: 'grafico',
                width: 500,
                height: 300,
                animate: true,
                store: Ext.create('Ext.data.JsonStore', {
                        storeId: 'teste',
                        fields: ['name', 'data1'],
                        data: [
                            {'name':'Batata', 'data1':100},
                            {'name':'Aipim', 'data1':100},
                            {'name':'Chuchu', 'data1':100},
                            {'name':'Feijуo', 'data1':50},
                            {'name':'Arroz', 'data1':50},        
                            {'name':'Melтncia', 'data1':600}                                                
                        ]
                    }),
                theme: 'Base:gradients',
                series: [{
                    type: 'pie',
                    field: 'data1',
                    showInLegend: true,
                    tips: {
                      trackMouse: true,
                      width: 140,
                      height: 28,
                      renderer: function(storeItem, item) {
                        //calculate and display percentage on hover
                        var total = 0;
                        store.each(function(rec) {
                            total += rec.get('data1');
                        });
                        this.setTitle(storeItem.get('name') + ': ' + Math.round(storeItem.get('data1') / total * 100) + '%');
                      }
                    },
                    highlight: {
                      segment: {
                        margin: 20
                      }
                    },
                    label: {
                        field: 'name',
                        display: 'rotate',
                        contrast: true,
                        font: '18px Arial'
                    }
                }]    
            }";
        return $sRender;
    }
}

?>