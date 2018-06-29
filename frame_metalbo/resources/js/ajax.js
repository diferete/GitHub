  var sUploads ='';
  var aCamposReq = []; 
  function requestAjax(idForm,classe,metodo,sparametros,aIdCampos,bDesativaCarrega){
        
       console.log(sparametros);
        var aParametros ={};
        var aParametrosTela={};
        var aParametrosCampos={};
        
	aParametros['classe']= classe;
	aParametros['metodo']= metodo;
       
        if(idForm !== ''){
            var camposForm = '';
            var camposManuais = '';
          
           //  alert('idform');
            
            if(aCamposReq !== '' || aCamposReq !== undefined){
                iContCamposReq = 0;

                $.each(aCamposReq, function(i,obj){
                    
                    if(obj.valor == '' || obj.valor == undefined){

                    }else{
                         camposManuais += '&' + obj.campo + '=' + obj.valor ;
                    }
                    
                   
                });
            }
            
            camposForm = $('#'+idForm).serialize() + camposManuais;
            
          
        }
         //verifica se monta um array ou não dos campos
         if(sparametros !== undefined){
          var result = Array.isArray(sparametros);
            if(result === true){
                var cont = 0;
                for (var i in sparametros){
                  //navego pelas chaves do array como um for
                  aParametrosTela['parametros['+cont+']'] = sparametros[i];
                  cont ++;
                  }
            }else{
                aParametrosTela['parametros[]'] = sparametros;
            }
         }
          //verifica se foi definido o array aIdCampos
          if(aIdCampos !== undefined){
                var result2 = Array.isArray(aIdCampos);
                if(result2 === true){
                 var cont2 = 0;
                  for (var i2 in aIdCampos){
                      //navego pelas chaves do array como um for
                      aParametrosCampos['parametrosCampos['+cont2+']'] = aIdCampos[i2];
                      cont2 ++;
                  }
                 }else{
                aParametrosCampos['parametrosCampos[]'] = aIdCampos;
                }
          }
               
		$.ajax({
                 type: "POST",
                 url:"index.php",
                 beforeSend : function(){if(bDesativaCarrega !== true){MostraCarregando(getAbaAtiva());}},
                 complete: function(){FechaCarregando(getAbaAtiva());},
                    data:{
                        classe: aParametros['classe'],
                        metodo: aParametros['metodo'],
                        campos: camposForm,
                        parametros : aParametrosTela,
                        parametrosCampos : aParametrosCampos
                        
                      }
                   }).done(function(e){
                   //    alert(e);
                       eval(e);
                       //executa funções após retornar do php
                       afterEval();
                   }).fail(function(e){
                      
                       mensagemErro("Oops!", "Parece que aconteceu algum erro. \n\ Tente novamente!");
                       
                   });
                   
           
	}
 /**
  * 
  * @param {type} bCarregando
  * @param {type} sClasse
  * @param {type} sMetodo
  * @param {type} sCampos
  * @param {type} sParametros
  * @returns {jqXHR}
  */   
function requestJSON(bCarregando, sClasse, sMetodo, sCampos, sParametros ){
    $.ajax({
                type: "POST",
                dataType: "json",
                async: false,
                url: "index.php",
                  data:{
                   classe: sClasse,
                   metodo: sMetodo,
                   campos: sCampos,
                   parametros : sParametros
                },
                beforeSend : function(){
                   if(bCarregando){
                       MostraCarregando(getAbaAtiva());
                   }
                },
                complete: function(){
                    if(bCarregando){
                        FechaCarregando(getAbaAtiva());
                   }
                },
                success: function(data){
                    retorno = data;
                   // alert(retorno);
                    
                },
                error: function(){
                    mensagemErro("Oops!", "Parece que aconteceu algum erro. \n\ Tente novamente!");
                    retorno = false;
                }
    });

    return retorno;
}

/**
 * executa funçoes após retorna do php
 * @returns {undefined}
 */
 function afterEval(){
    
}







