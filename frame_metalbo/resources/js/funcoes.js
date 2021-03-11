var iContCamposReq = 0;

function sendFiltrosGrid(id, classe, idgrid, campoconsulta, bscroll, chavescroll, metodo) {

    var dadosPesq = [];
    var countPesq = 0;
    var nome, valor, idSel = '';
    var valSel = '';
    var dadosSend = '';

    $(id + " :text").each(function () {

        dadosSend = '';
        idSel = $(this).attr("id");
        nome = $(this).attr("name");
        valor = $(this).val();
        dadosSend = nome + ',' + valor;
        var classdata1 = $(this).hasClass("data1");
        if (classdata1 == true) {
            dadosSend = dadosSend + '|' + 'entre|vlrini';
        }
        ;
        var classdata2 = $(this).hasClass("data2");
        if (classdata2 == true) {
            dadosSend = dadosSend + '|' + 'entre|vlrfim';
        }
        ;
        $("#" + idSel + "-tipoFiltro :radio:checked").each(function () {
            valSel = $(this).val();
            dadosSend = dadosSend + '|' + valSel;
        });
        dadosPesq[countPesq] = dadosSend;
        countPesq++;
    });


    $('#' + idgrid + '-pesquisa').each(function () {
        $(this).find('select.selectfiltro').each(function () {
            idSel = $(this).attr("id");
            nome = $(this).attr("name");
            valor = $(this).val();
            if (valor !== 'Todos') {
                if (nome !== undefined) {

                    dadosSend = nome + '|' + valor;
                    dadosPesq[countPesq] = dadosSend;

                    countPesq++;
                }
            }
            ;
        });

    });


    if (bscroll == true) {
        //alert(metodo);  
        dadosPesq[countPesq] = chavescroll + '|' + 'scroll';
        if (metodo == "") {
            requestAjax('', classe, 'getDadosScroll', idgrid + ',' + campoconsulta, dadosPesq, false);
        } else {
            requestAjax('', classe, 'getDadosScrollCampo', idgrid + ',' + metodo, dadosPesq, false);
        }

    } else {
        requestAjax('', classe, 'getDadosConsulta', idgrid + ',' + campoconsulta, dadosPesq);
    }
}

function sendFiltros(id, classe, idgrid, campoconsulta, bscroll, chavescroll, metodo, idPos, ordenacao) {
    //console.log(ordenacao["ordenacao"]);
    var dadosPesq = [];
    var countPesq = 0;
    var nome, valor, idSel = '';
    var valSel = '';
    var dadosSend = '';

    $(id + " :text").each(function () {

        dadosSend = '';
        idSel = $(this).attr("id");
        nome = $(this).attr("name");
        valor = $(this).val();
        dadosSend = nome + '|' + valor;
        var classdata1 = $(this).hasClass("data1");
        if (classdata1 == true) {
            dadosSend = dadosSend + '|' + 'entre|vlrini';
        }
        ;
        var classdata2 = $(this).hasClass("data2");
        if (classdata2 == true) {
            dadosSend = dadosSend + '|' + 'entre|vlrfim';
        }
        ;
        $("#" + idSel + "-tipoFiltro :radio:checked").each(function () {
            valSel = $(this).val();
            dadosSend = dadosSend + '|' + valSel;
        });
        dadosPesq[countPesq] = dadosSend;
        countPesq++;
    });



    //teste para percorrer campos select

    $('#' + idgrid + '-pesquisa').each(function () {
        $(this).find('select.selectfiltro').each(function () {
            idSel = $(this).attr("id");
            nome = $(this).attr("name");
            valor = $(this).val();
            if (valor !== 'Todos') {
                if (nome !== undefined) {

                    dadosSend = nome + '|' + valor;
                    dadosPesq[countPesq] = dadosSend;

                    countPesq++;
                }
            }
            ;
        });

    });


    if (bscroll == true) {
        //alert(metodo);  
        dadosPesq[countPesq] = chavescroll + '|' + 'scroll';
        if (metodo == "") {
            requestAjax('', classe, 'getDadosScroll', idgrid + ',' + campoconsulta, dadosPesq, false, idPos);
            // requestAjax(idForm,classe,metodo,sparametros,aIdCampos,bDesativaCarrega)
        } else {
            requestAjax('', classe, 'getDadosScrollCampo', idgrid + ',' + metodo, dadosPesq, false, idPos);
            //requestAjax(idForm,classe,metodo,sparametros,aIdCampos,bDesativaCarrega)
        }

    } else {
        requestAjax('', classe, 'getDadosConsulta', idgrid + ',' + campoconsulta, dadosPesq, false, '', ordenacao);
    }
}

function serializeForm(id) {
    var serialize = $('#' + id + '-form').serialize();

    return serialize;
}

/*
 * Funções que Mostra e Oculta GIF de loading, no RequestAjax
 */
function MostraCarregando(aba) {
    var abaAtiva = $("#" + aba + "-carregando");

    //alert("Mostra: "+aba+"-carregando");
    abaAtiva.show();
}

function FechaCarregando(aba) {
    //var abaAtiva = $("#" + aba + "-carregando");
    var abaAtiva = $(".carregando");
    //  alert("Fecha: "+aba+"-carregando");
    abaAtiva.hide();
}

function mensagemErro(sTitulo, sMensagem) {
    sweetAlert(sTitulo, sMensagem, "error");
}

/**
 * Método responsável por carregar campos fícticios, como o upload
 
 * @param {string} Campo Nome do campo no model para carregar
 * @param {string} sValor  Valor do campo a ser carregado
 * @author Carlos Scheffer
 * @date 09/06/2016
 */
function carregaCamposReq(sCampo, sValor) {

    aCamposReq[iContCamposReq] = {
        campo: sCampo,
        valor: sValor
    };
    iContCamposReq++;


}
/**
 * Método que deleta campo ficticio caso seja encontrado no array aCamposReq
 * @param {string} sNome Nome do campo a ser deletado
 * @author Carlos Scheffer
 * @date 09/06/2016
 */
function deletaCampoReq(sNome) {
//     console.log('chegou delete');
    $.each(aCamposReq, function (i, val) {
//         console.log(i + '' + val.campo);
        if (sNome == val.campo) {
//             console.log('bateu');
            val.valor = '';
        }
    });
}

function getAbaAtiva() {
    var aba = abaSelecionada + 'control';
    return aba;
}

function fechaTab(sAba) {
    if (sAba == '' || sAba == undefined) {
        sAba = getAbaAtiva();
    }
    ativaPerfil();
    $("#" + sAba + "control").remove(); //remove respective tab content
    $("#" + sAba).remove(); //remove li of tab
}
/**
 * 
 * @param {type} file
 * @param {type} url
 * @param {type} editor
 * @param {type} welEditable
 * @returns nada
 */
function sendFile(file, url, editor, welEditable) {
    data = new FormData();
    data.append("file", file);
    // console.log('Chegou no sendfile');
    $.ajax({
        data: data,
        type: "POST",
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        success: function (img) {
            var link = JSON.parse(img);
            if (link.uploaded === "true") {
                var dir = '';
                dir = "Uploads/" + link.nome;
                //  console.log(dir);
                editor.insertImage(welEditable, dir);
            }

        },
        error: function (link) {
            // console.log('Erro');
            // console.log(link);
        }
    });
}

function convItenSolRep(vlrUnit, idVlrUnit, vlrTot, idVlrTot, prcBruto, idPrcBruto) {

    var valorUnitario = moedaParaNumero(vlrUnit);
    $('#' + idVlrUnit + '').val('' + valorUnitario + '');

    var valorTotal = moedaParaNumero(vlrTot);
    $('#' + idVlrTot + '').val('' + valorTotal + '');

    var valorBruto = moedaParaNumero(prcBruto);
    $('#' + idPrcBruto + '').val('' + valorBruto + '');

}



/**
 * Função para calcular descontos
 * @param {type} quant
 * @param {type} vlrBruto
 * @param {type} vlrUnit
 * @param {type} desconto
 * @param {type} tratamento
 * @param {type} desc1
 * @param {type} desc2
 * @param {type} idVlrUnit
 * @param {type} idTotal
 * @returns {undefined}
 */
function calcSolCot(quant, vlrBruto, vlrUnit, desconto, tratamento, desc1, desc2, idVlrUnit, idTotal, idQuant, idDesconto, idTratamento, idDesc1, idDesc2) {
    if (vlrBruto == '0,00' || vlrBruto == '0') {
        $("#" + idVlrUnit + "").prop("readonly", false);
    }


    var quantidade = moedaParaNumero(quant);

    if (isNaN(quantidade)) {
        quantidade = 0;
    }

    $('#' + idQuant + '').val('' + quantidade + '');

    var unitario = moedaParaNumero(vlrBruto);
    var desconto1 = moedaParaNumero(desconto);
    $('#' + idDesconto + '').val('' + desconto1 + '');

    var tot_desc1 = (desconto1 / 100) * unitario;
    unitario = unitario - tot_desc1;




    var desc_trat = moedaParaNumero(tratamento);
    $('#' + idTratamento + '').val('' + desc_trat + '');

    var tot_desc_trat = (desc_trat / 100) * unitario;
    unitario = unitario + tot_desc_trat;
    var desc_extra1 = moedaParaNumero(desc1);
    $('#' + idDesc1 + '').val('' + desc_extra1 + '');

    var tot_descextra1 = (desc_extra1 / 100) * unitario;
    unitario = unitario - tot_descextra1;
    var desc_extra2 = moedaParaNumero(desc2);
    $('#' + idDesc2 + '').val('' + desc_extra2 + '');

    var tot_descextra2 = (desc_extra2 / 100) * unitario;
    unitario = unitario - tot_descextra2;
    //Faz o arredondamento


    //arredonda unitario
    unitario = decimalAdjust('round', unitario, -2);
    ///console.log(unitario);
    /*Faz o cálculo do valor total*/
    var total = (quantidade * unitario);

    unitario = numeroParaMoeda(unitario);
    total = numeroParaMoeda(total);


    $('#' + idVlrUnit + '').val('' + unitario + '');
    $('#' + idTotal + '').val('' + total + '');
}

/**
 * Decimal adjustment of a number.
 *
 * @param	{String}	type	The type of adjustment.
 * @param	{Number}	value	The number.
 * @param	{Integer}	exp		The exponent (the 10 logarithm of the adjustment base).
 * @returns	{Number}			The adjusted value.
 */

function decimalAdjust(type, value, exp) {
    // If the exp is undefined or zero...
    if (typeof exp === 'undefined' || +exp === 0) {
        return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // If the value is not a number or the exp is not an integer...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
        return NaN;
    }
    // Shift
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
}

/**
 * Função para liberar digitação do valor unitário
 * @param {type} vlrUnit
 * @param {type} idVlrUnit
 * @param {type} idVlrBruto
 * @returns {undefined}
 */
function semTabelaPreco(vlrUnit, idVlrUnit, idVlrBruto, vlrBruto) {
    vlrUnit = moedaParaNumero(vlrUnit);
    $("#" + idVlrUnit + "").prop("readonly", true);
    vlrUnit = numeroParaMoeda(vlrUnit);
    if (vlrBruto == '0,00' || vlrBruto == '0') {
        $('#' + idVlrBruto + '').val('' + vlrUnit + '');
    }
}

/**
 * Função para ações na entrada do código
 * @param {type} idVlrUnit
 * @returns {undefined}
 */
function entradaCodigo(idVlrUnit) {
    $("#" + idVlrUnit + "").prop("readonly", true);
}
/**
 * Função para converter numero para moeda
 * @param {type} n
 * @param {type} c
 * @param {type} d
 * @param {type} t
 * @returns {@var;d|@var;t|s|String}
 */
function numeroParaMoeda(n, c, d, t) {
    c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

/**
 * Função para converte moeda para número
 * @param {type} valor
 * @returns {unresolved}
 */
function moedaParaNumero(valor) {
    //return isNaN(valor) == false ? parseFloat(valor) :   parseFloat(valor.replace("R$","").replace(".","").replace(",","."));
    return isNaN(valor) == false ? parseFloat(valor) : parseFloat(valor.replace("R$", "").replace(".", "").replace(",", "."));
}
/**
 * 
 * @param {type} idQuantidade
 * @param {type} idCaixaNormal
 * @param {type} idDiverNormal
 * @param {type} idFieldSet
 * @param {type} idQtSug
 * @param {type} idQtCaixaNormal
 * @returns {Boolean}
 */
function calcEmbNormal(idQuantidade, idCaixaNormal, idDiverNormal, idQtSug, idQtCaixaNormal) {
    var Quantidade = moedaParaNumero($('#' + idQuantidade + '').val());   //$('#'+idQuantidade+'').val();
    var CaixaNormal = moedaParaNumero($('#' + idCaixaNormal + '').val());

    var resultadoNormal = Quantidade / CaixaNormal;

    var resultadoNormalArr = Math.ceil(resultadoNormal);

    //vai listar como divergência e deve bloquear a inserção
    if (Quantidade > 0 && CaixaNormal > 0) {
        if (Quantidade != (resultadoNormalArr * CaixaNormal)) {
            $('#' + idDiverNormal + '').removeClass("label-warning");
            $('#' + idDiverNormal + '').removeClass("label-success");
            $('#' + idDiverNormal + '').addClass("label-danger");
            $('#' + idDiverNormal + '').text('Atenção!');
            $('#' + idQtSug + '').val(resultadoNormalArr * CaixaNormal);
            $('#' + idQtCaixaNormal + '').val(resultadoNormalArr);
            return false;

        } else {
            $('#' + idDiverNormal + '').removeClass("label-warning");
            $('#' + idDiverNormal + '').removeClass("label-danger");
            $('#' + idDiverNormal + '').addClass("label-success");
            $('#' + idDiverNormal + '').text('Embalagem OK!');
            $('#' + idQtSug + '').val(resultadoNormalArr * CaixaNormal);
            $('#' + idQtCaixaNormal + '').val(resultadoNormalArr);
        }
    }
}

/**
 * 
 * @param {type} idQuantidade
 * @param {type} idCaixaNormal
 * @param {type} idDiverNormal
 * @param {type} idFieldSet
 * @param {type} idQtSug
 * @param {type} idQtCaixaNormal
 * @returns {Boolean}
 */
function calcEmbMaster(idQuantidade, idCaixaMaster, idDiverMaster, idQtSugMaster, idQtCaixaMaster, idDiver) {

    var Quantidade = moedaParaNumero($('#' + idQuantidade + '').val());
    var CaixaMaster = moedaParaNumero($('#' + idCaixaMaster + '').val());

    var resultadoMaster = Quantidade / CaixaMaster;

    var resultadoMasterArr = Math.ceil(resultadoMaster);

    //calcula divergencia entre a quantidade solicitada e a quantidade mínima de uma caixa master.
    var qtsug = resultadoMasterArr * CaixaMaster;
    var diver = qtsug - Quantidade;
    $('#' + idDiver + '').val(diver);

    if (Quantidade > 0 && CaixaMaster > 0) {
        if (Quantidade != (resultadoMasterArr * CaixaMaster)) {
            $('#' + idDiverMaster + '').removeClass("label-warning");
            $('#' + idDiverMaster + '').removeClass("label-success");
            $('#' + idDiverMaster + '').addClass("label-danger");
            $('#' + idDiverMaster + '').text('Atenção!');
            $('#' + idQtSugMaster + '').val(resultadoMasterArr * CaixaMaster);
            $('#' + idQtCaixaMaster + '').val(resultadoMasterArr);
            return false;

        } else
        {
            $('#' + idDiverMaster + '').removeClass("label-warning");
            $('#' + idDiverMaster + '').removeClass("label-danger");
            $('#' + idDiverMaster + '').addClass("label-success");
            $('#' + idDiverMaster + '').text('Embalagem OK!');
            $('#' + idQtSugMaster + '').val(resultadoMasterArr * CaixaMaster);
            $('#' + idQtCaixaMaster + '').val(resultadoMasterArr);

        }
    } else {
        $('#' + idDiver + '').val('0');
    }
}

/**
 * Realiza o mod para bloquear a quantidade
 * 
 */
function calcMod(idQuant, idCxNormal) {

    var quantidade = moedaParaNumero($('#' + idQuant + '').val()); //   $('#'+idQuant+'').val();
    quantidade = quantidade * 100;

    var caixaNormal = moedaParaNumero($('#' + idCxNormal + '').val());//$('#'+idCxNormal+'').val();
    caixaNormal = caixaNormal * 100;

    var modulo = quantidade % caixaNormal;

    if (modulo > 0) {
        return true;
    } else {
        return false;
    }


}

/**
 * Realiza o cálculo de preço por kg
 */
function calcPrecoKg(idQuant, idPeso, idVlrTot, idBadge) {
    var Quantidade = $('#' + idQuant + '').val();
    //console.log(Quantidade);
    var Peso = moedaParaNumero($('#' + idPeso + '').val());
    //console.log(Peso);
    var vlrTot = moedaParaNumero($('#' + idVlrTot + '').val());
    //console.log(vlrTot);
    if (Peso !== 0) {
        var prcKg = vlrTot / (Quantidade * Peso);
    } else {
        var prcKg = 0;
    }

    //console.log(prcKg);

    prcKgArr = numeroParaMoeda(prcKg);
    $('#' + idBadge + '').text('Preço por Kg: R$ ' + prcKgArr + '');
    return prcKgArr;


}
/**
 * Aplica quantidade caixa normal
 */
function aplicaQtNormal(idQtSug, idQuant) {
    var sug = $('#' + idQtSug + '').val();
    $('#' + idQuant + '').val('' + sug + '');
    $('#' + idQuant + '').focus();
}
/**
 * Aplica quantidade caixa Master
 */
function aplicaQtMaster(idQtSug, idQuant) {
    var sug = $('#' + idQtSug + '').val();
    $('#' + idQuant + '').val('' + sug + '');
    $('#' + idQuant + '').focus();
}
/**
 * Valida preço por kg
 */
function bloqueaPrcKg(idSitLib, idVlrUnit, idBruto, quant, peso, vlrtot) {
    //idQuant,idPeso,idVlrTot,idBadge
    var VlrUnit = moedaParaNumero($('#' + idVlrUnit + '').val());
    var PrecoBruto = moedaParaNumero($('#' + idBruto + '').val());
    var regra = $('#' + idSitLib + '').val();


    var quantidade = moedaParaNumero($('#' + quant + '').val());

    var totalpeso = moedaParaNumero($('#' + peso + '').val());

    var valor = moedaParaNumero($('#' + vlrtot + '').val());



    if (regra == 'Desconto') {
        var resultado = (VlrUnit * 100) / PrecoBruto;
        var porcento = 100 - resultado;
        var porctotal = parseFloat(porcento.toFixed(2));
        if ((porctotal) > 74) {
            return false;
        }
    }
    if (regra == 'SemTabela') {
        if (totalpeso !== 0) {
            var prcKg = valor / (quantidade * totalpeso);
            var prcKgArr = parseFloat(prcKg.toFixed(2));
            if (prcKgArr < 5) {
                return false;
            }
        } else {
            return true;
        }
    }

    if (regra == 'EstojoB7') {
        if (totalpeso !== 0) {
            var prcKg = valor / (quantidade * totalpeso);
            var prcKgArr = parseFloat(prcKg.toFixed(2));
            if (prcKgArr < 8) {
                return false;
            }
        } else {
            return true;
        }
    }
    return true;
}

/**
 * Funcao que retorna a diferença em porcento de dois valores
 */
function retornaPorc(idvl1, idvlr2) {

    var valor1 = moedaParaNumero($('#' + idvl1 + '').val());
    var valor2 = moedaParaNumero($('#' + idvlr2 + '').val());

    var diferenca = (valor1 / valor2) * 100;

    var total = Math.ceil(100 - diferenca);

    return total;


}

/**
 * Funçao para verificar data atual
 */
function dataAtual(idData, dataAtual) {
    var dataEnt = $('#' + idData + '').val();



    var nova_data1 = parseInt(dataAtual.split("/")[2].toString() + dataAtual.split("/")[1].toString() + dataAtual.split("/")[0].toString());

    if (dataEnt != '') {
        var nova_data2 = parseInt(dataEnt.split("/")[2].toString() + dataEnt.split("/")[1].toString() + dataEnt.split("/")[0].toString());
    } else
    {
        var nova_data2 = 0;
    }
    //  alert(nova_data1);
    //  alert(nova_data2);

    if (nova_data1 > nova_data2) {

        return false;
    } else {
        return true;
    }





}

function testAspa() {
    var filhos4 = " João tem 2 filhos,\"pedrinho e zézinho, são meus filhos..Ext.getCmp('filhos4'); ";
    var $s = 'M\'ARTINI';
}

/**
 * funcao para zerar campos consulta estoque
 */

function zeraCampoEstoque(grupo1, grupo2, sub1, sub2, fam1, fam2, subfam1, subfam2, solcot) {
    $('#' + grupo1 + '').val('0');
    $('#' + grupo2 + '').val('999');
    $('#' + sub1 + '').val('0');
    $('#' + sub2 + '').val('999');
    $('#' + fam1 + '').val('0');
    $('#' + fam2 + '').val('999');
    $('#' + subfam1 + '').val('0');
    $('#' + subfam2 + '').val('999');
    $('#' + solcot + '').val('');
}
/**
 * funcao para calcular preco estimado na tela de cadastro de novos projetos 
 */
function calcNewproj(idPlan,
        idFerr,
        idMat,
        idAcab,
        idTrat,
        idCusto,
        idTotal,
        idQuant,
        idLote,
        idPeso,
        idPrecoFinal,
        idCCento) {

    var Quant = $('#' + idQuant + '').val();
    if (Quant == '') {
        $('#' + idQuant + '').val('0');
    }
    Quant = moedaParaNumero(Quant);
    $('#' + idQuant + '').val(numeroParaMoeda(Quant));

    var PrecoFinal = $('#' + idPrecoFinal + '').val();
    if (PrecoFinal == '') {
        $('#' + idPrecoFinal + '').val('0');
    }
    PrecoFinal = moedaParaNumero(PrecoFinal);
    $('#' + idPrecoFinal + '').val(numeroParaMoeda(PrecoFinal));

    var Lote = $('#' + idLote + '').val();
    if (Lote == '') {
        $('#' + idLote + '').val('0');
    }
    Lote = moedaParaNumero(Lote);
    $('#' + idLote + '').val(numeroParaMoeda(Lote));

    var Peso = $('#' + idPeso + '').val();
    if (Peso == '') {
        $('#' + idPeso + '').val('0');
    }
    Peso = moedaParaNumero(Peso);
    $('#' + idPeso + '').val(numeroParaMoeda(Peso));

    var Plan = $('#' + idPlan + '').val();
    if (Plan == '') {
        $('#' + idPlan + '').val('0');
    }
    Plan = moedaParaNumero(Plan);
    $('#' + idPlan + '').val(numeroParaMoeda(Plan));

    var Ferr = $('#' + idFerr + '').val();
    if (Ferr == '') {
        $('#' + idFerr + '').val('0');
    }
    Ferr = moedaParaNumero(Ferr);
    $('#' + idFerr + '').val(numeroParaMoeda(Ferr));

    var Mat = $('#' + idMat + '').val();
    if (Mat == '') {
        $('#' + idMat + '').val('0');
    }
    Mat = moedaParaNumero(Mat);
    $('#' + idMat + '').val(numeroParaMoeda(Mat));

    var Acab = $('#' + idAcab + '').val();
    if (Acab == '') {
        $('#' + idAcab + '').val('0');
    }
    Acab = moedaParaNumero(Acab);
    $('#' + idAcab + '').val(numeroParaMoeda(Acab));

    var Trat = $('#' + idTrat + '').val();
    if (Trat == '') {
        $('#' + idTrat + '').val('0');
    }
    Trat = moedaParaNumero(Trat);
    $('#' + idTrat + '').val(numeroParaMoeda(Trat));

    var Custo = $('#' + idCusto + '').val();
    if (Custo == '') {
        $('#' + idCusto + '').val('0');
    }
    Custo = moedaParaNumero(Custo);
    $('#' + idCusto + '').val(numeroParaMoeda(Custo));

    var CustoTotal = (Plan + Ferr + Mat + Acab + Trat + Custo);
    $('#' + idTotal + '').val(numeroParaMoeda(CustoTotal));

    if (Lote > Quant) {
        var CustoCento = (CustoTotal / Lote);
        $('#' + idCCento + '').val(numeroParaMoeda(CustoCento));
    } else {
        var CustoCento = (CustoTotal / Quant);
        $('#' + idCCento + '').val(numeroParaMoeda(CustoCento));
    }
}

/**
 * funcao para valores do dimensional da entrada de novos projetos
 */
function dimenNewProj(codProdSimilar, idChMin, idChMax, idAltMin, idAltMax, idDiamFmin, idDiamFmax, idCompMin, idCompMax, idDiamPmin, idDiamPmax,
        idDiamExMin, idDiamExMax, idCompPrMin, idCompPrMax, idCompHmin, idCompHmax, idDiamHmin, idDiamHmax, idCanecoMin, idCanecoMax, idAngHelice,
        idAcab, idMat, idClass, sClasse, codProCod, idDiamMat) {
    if (codProdSimilar == '') {
        return;
    } else {

        var campoValSim = codProdSimilar + ',' + idChMin + ',' + idChMax + ',' + idAltMin + ',' + idAltMax + ',' + idDiamFmin + ',' + idDiamFmax + ','
                + idCompMin + ',' + idCompMax + ',' + idDiamPmin + ',' + idDiamPmax + ',' + idDiamExMin + ',' + idDiamExMax + ',' + idCompPrMin + ','
                + idCompPrMax + ',' + idCompHmin + ',' + idCompHmax + ',' + idDiamHmin + ',' + idDiamHmax + ',' + idCanecoMin + ',' + idCanecoMax + ','
                + idAngHelice + ',' + idAcab + ',' + idMat + ',' + idClass + ',' + codProCod + ',' + idDiamMat;

        requestAjax("", sClasse, 'getDadosProdSimilar', campoValSim);
    }
}


/**
 * funcao para valores do dimensional da entraga de novos projetos
 */
function dimenProd(codProd, idChMin, idChMax, idAltMin, idAltMax, idDiamFmin, idDiamFmax, idCompMin, idCompMax, idDiamPmin, idDiamPmax,
        idDiamExMin, idDiamExMax, idCompPrMin, idCompPrMax, idCompHmin, idCompHmax, idDiamHmin, idDiamHmax, idCanecoMin, idCanecoMax, idAngHelice,
        idAcab, idMat, idClass, sClasse) {
    if (codProd == '') {
        return;
    } else {

        var campoVal = codProd + ',' + idChMin + ',' + idChMax + ',' + idAltMin + ',' + idAltMax + ',' + idDiamFmin + ',' + idDiamFmax + ','
                + idCompMin + ',' + idCompMax + ',' + idDiamPmin + ',' + idDiamPmax + ',' + idDiamExMin + ',' + idDiamExMax + ',' + idCompPrMin + ','
                + idCompPrMax + ',' + idCompHmin + ',' + idCompHmax + ',' + idDiamHmin + ',' + idDiamHmax + ',' + idCanecoMin + ',' + idCanecoMax + ','
                + idAngHelice + ',' + idAcab + ',' + idMat + ',' + idClass;
        requestAjax("", sClasse, 'buscaDadosProd', campoVal);
    }
}

function PDFDimen(campoVal, sClasse) {
    requestAjax("", sClasse, 'geraPDF', campoVal);
}

function NewProjRep(idQt) {


    var Qt = $('#' + idQt + '').val();
    if (Qt == '') {
        $('#' + idQt + '').val('0');
    }
    Qt = moedaParaNumero(Qt);
    $('#' + idQt + '').val(numeroParaMoeda(Qt));

}

/**
 * Função para verificar senha da força
 */
function strongPass() {

    var Pass1Val = $('#passwd1').val();
    var Pass2Val = $('#passwd2').val();



    var WeakPass = /(?=.{5,}).*/;
    var MediumPass = /^(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/;
    var StrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/;
    var VryStrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*?[^\w\*])\S{5,}$/;
    var forca = 's';
    var same = 's';



    if (VryStrongPass.test(Pass1Val)) {
        $('#input1').removeClass('has-success has-error');
        $('#input1').addClass('has-success');
        $('#span1').text('SENHA FORTE!');
        forca = 's';
    } else if (StrongPass.test(Pass1Val)) {
        $('#input1').removeClass('has-success has-error');
        $('#input1').addClass('has-success');
        $('#span1').text('FORTE MAS INSIRA CARACTERES ESPECIAIS!');
        forca = 's';
    } else if (MediumPass.test(Pass1Val)) {
        $('#input1').removeClass('has-success has-error');
        $('#input1').addClass('has-success');
        $('#span1').text('REGULAR INSIRA LETRAS MAIÚSCULAS!');
        forca = 's';
    } else if (WeakPass.test(Pass1Val)) {
        $('#input1').removeClass('has-success has-error');
        $('#input1').addClass('has-error');
        $('#span1').text('FRACA INSIRA NÚMEROS OU CARACTERES ESPECIAIS!');
        forca = 'n';
    } else {
        $('#input1').removeClass('has-success has-error');
        $('#input1').addClass('has-error');
        $('#span1').text('FRACA A SENHA DEVE TER NO MÍNIMO 5 OU MAIS CARACTERES!');
        forca = 'n';
    }


    if (Pass1Val !== Pass2Val) {
        $('#input2').removeClass('has-success has-error');
        $('#input2').addClass('has-error');
        $('#span2').text('SENHAS DIFERENTES DIGITE AS SENHA IGUAIS!');
        same = 'n';
    } else {
        $('#input2').removeClass('has-success has-error');
        $('#input2').addClass('has-success');
        $('#span2').text('SENHAS IGUAIS!');
        same = 's';
    }


    if (forca == 's' && same == 's') {
        $('#botao1').prop('disabled', false);

    } else {
        $('#botao1').prop('disabled', true);
    }


}

/**
 * Faz a chamada do request para redefinir nova senha
 */

function callRequestRedefine() {

    //chama classe para alterar a senha
    requestAjax('frm-redefini', 'User', 'redefinePasswdLogin');
}
/**
 * gera força de senha para redefinição da senha dentro do sistema
 */
function strongPassSistema(idPass1, idPass2, idBadge, idBadge2, idBotao) {


    var Pass1Val = $('#' + idPass1 + '').val();
    var Pass2Val = $('#' + idPass2 + '').val();

    var WeakPass = /(?=.{5,}).*/;
    var MediumPass = /^(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/;
    var StrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/;
    var VryStrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*?[^\w\*])\S{5,}$/;
    var forca = 's';
    var same = 's';



    if (VryStrongPass.test(Pass1Val)) {
        $('#' + idPass1 + '-group').removeClass('has-success has-error');
        $('#' + idBadge + '').removeClass('label-danger label-warning label-success');
        $('#' + idPass1 + '-group').addClass('has-success');
        $('#' + idBadge + '').addClass('label-success');
        $('#' + idBadge + '').text('Senha Forte!');
        forca = 's';
    } else if (StrongPass.test(Pass1Val)) {
        $('#' + idPass1 + '-group').removeClass('has-success has-error');
        $('#' + idBadge + '').removeClass('label-danger label-warning label-success');
        $('#' + idPass1 + '-group').addClass('has-success');
        $('#' + idBadge + '').addClass('label-success');
        $('#' + idBadge + '').text('Forte mas insira caracteres especiais!');
        forca = 's';
    } else if (MediumPass.test(Pass1Val)) {
        $('#' + idPass1 + '-group').removeClass('has-success has-error');
        $('#' + idBadge + '').removeClass('label-danger label-warning label-success');
        $('#' + idPass1 + '-group').addClass('has-success');
        $('#' + idBadge + '').addClass('label-success');
        $('#' + idBadge + '').text('Regular insira letras maísculas pelo menos!');
        forca = 's';
    } else if (WeakPass.test(Pass1Val)) {
        $('#' + idPass1 + '-group').removeClass('has-success has-error');
        $('#' + idBadge + '').removeClass('label-danger label-warning label-success');
        $('#' + idPass1 + '-group').addClass('has-error');
        $('#' + idBadge + '').addClass('label-danger');
        $('#' + idBadge + '').text('Fraca insira números ou caracteres especiais!');
        forca = 'n';
    } else {
        $('#' + idPass1 + '-group').removeClass('has-success has-error');
        $('#' + idBadge + '').removeClass('label-danger label-warning label-success');
        $('#' + idPass1 + '-group').addClass('has-error');
        $('#' + idBadge + '').addClass('label-danger');
        $('#' + idBadge + '').text('Fraca a senha deve ter no mínimo 5 ou mais caracteres!');

        forca = 'n';
    }

    //verifica se as senhas são iguais
    if (Pass1Val !== Pass2Val) {
        $('#' + idPass2 + '-group').removeClass('has-success has-error');
        $('#' + idBadge2 + '').removeClass('label-danger label-warning label-success');
        $('#' + idPass2 + '-group').addClass('has-error');
        $('#' + idBadge2 + '').addClass('label-danger');
        $('#' + idBadge2 + '').text('Senhas diferentes, digite senhas iguais!');


        same = 'n';
    } else {
        $('#' + idPass2 + '-group').removeClass('has-success has-error');
        $('#' + idBadge2 + '').removeClass('label-danger label-warning label-success');
        $('#' + idPass2 + '-group').addClass('has-success');
        $('#' + idBadge2 + '').addClass('label-success');
        $('#' + idBadge2 + '').text('Senhas conferem!');


        same = 's';
    }

    if (forca == 's' && same == 's') {


        $('#' + idBotao + '').prop('disabled', false);

    } else {

        $('#' + idBotao + '').prop('disabled', true);
    }
}



/**
 * verifica lote mínimo
 */

function verifLoteMin(sIdLote, sIdQt) {
    var loteqt = moedaParaNumero($('#' + sIdLote + '').val());
    var qt = moedaParaNumero($('#' + sIdQt + '').val());



    if (loteqt !== 0) {
        if (loteqt > qt) {
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }


}


/**
 * funçao para chamar json dos correios
 */
function cepBusca(sCep, sIdMunin, sIdEnd, sUf, sBairro) {

    if (sCep !== '') {
        mensagemSlide('info', 'Buscando Cep nos correios....', 'Busca de Cep');
        $.getJSON("https://viacep.com.br/ws/" + sCep + "/json/", function (data) {

            if (data.erro !== true) {
                $('#' + sIdMunin + '').val(data.localidade);
                $('#' + sIdEnd + '').val(data.logradouro);
                $('#' + sUf + '').val(data.uf);
                $('#' + sBairro + '').val(data.bairro);
                mensagemSlide('success', 'Busca de cep realizada com sucesso!', 'Busca de Cep');
            } else {
                $('#' + sIdMunin + '').val('');
                $('#' + sIdEnd + '').val('');
                $('#' + sUf + '').val('');
                $('#' + sBairro + '').val('');
                mensagemSlide('warning', 'Cep não encontrado nos correios!', 'Busca de Cep');
            }
        }).error(function () {
            $('#' + sIdMunin + '').val('');
            $('#' + sIdEnd + '').val('');
            $('#' + sUf + '').val('');
            $('#' + sBairro + '').val('');
            mensagemSlide('warning', 'Cep não encontrado nos correios!', 'Busca de Cep');


        });
    } else {
        $('#' + sIdMunin + '').val('');
        $('#' + sIdEnd + '').val('');
        $('#' + sUf + '').val('');
        $('#' + sBairro + '').val('');
        mensagemSlide('warning', 'Cep não encontrado nos correios!', 'Busca de Cep');
    }

}

/**
 * Mensagem pesquisa
 */
function mensagemSlide(tipo, msg, titulo, timeout) {
    if (timeout != '') {
        var time = timeout;
    } else {
        var time = "5000";
    }
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": time,
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    toastr[tipo](msg, titulo);
}

/**
 * Expande fieldset
 */
function expandeField(id) {
    $('#' + id + '').removeClass("expanded").addClass("collapsed");
    $('#' + id + ' >div').css("display", "none");
}

function buscaRespVenda(idCod, idVenda, nomeVenda, classe) {
    var idsCampos = idCod + ',' + idVenda + ',' + nomeVenda;
    requestAjax("", classe, 'getRespVenda', idsCampos);

}

function getUserEmail(codUser, idNome, idEmail, idCod, classe) {
    var dados = codUser + ',' + idNome + ',' + idEmail + ',' + idCod;
    requestAjax("", classe, 'getUserEmail', dados);
}

function insereProd(proCod, proDes, quant, quantNConf, idProdTag, idProCod, idProDes, idQuant, idQuantNConf, classe) {
    var dados = proCod + ';' + proDes + ';' + quant + ';' + quantNConf + ';' + idProdTag + ';' + idProCod + ';' + idProDes + ';' + idQuant + ';' + idQuantNConf;
    requestAjax("", classe, 'insereProd', dados);
}

function addColaborador(nome, idNome, idNomes, classe) {
    var dados = idNomes + ',' + nome + ',' + idNome;
    requestAjax("", classe, 'adicionaColaborador', dados);
}
/**
 * Máscaras em campo decimal
 */

function maskDecimal(idCampo, c) {

    var valor = $('#' + idCampo + '').val();

    if (valor == '') {
        $('#' + idCampo + '').val('');
    }
    valor = moedaParaNumero(valor);
    $('#' + idCampo + '').val(numeroParaMoeda(valor, c));
}

/**
 * 
 * @param {type} idQuant
 * @param {type} idUnit
 * @param {type} idTot
 * @returns {undefined}
 */
function precoNfEntradaSteel(idQuant, idUnit, idTot) {
    // console.log('chegamos');
    var Quant = moedaParaNumero($('#' + idQuant + '').val());
    //console.log(Quantidade);
    var Unit = moedaParaNumero($('#' + idUnit + '').val());

    var total = Quant * Unit;


    $('#' + idTot + '').val(numeroParaMoeda(total));

}


function precoMontagemCarta(idRetornoQt, idRetornoVlr, idRetornoTotal, idInsumoQt, idInsumoVlr, idInsumoTotal,
        idServicoQt, idServicoVlr, idServicoTotal) {
    //calculo do retorno
    var QtRet = moedaParaNumero($('#' + idRetornoQt + '').val());

    var VlrRet = moedaParaNumero($('#' + idRetornoVlr + '').val());

    var totalRetorno = QtRet * VlrRet;


    $('#' + idRetornoTotal + '').val(numeroParaMoeda(totalRetorno));


    //calculo do insumo
    var QtInsumo = moedaParaNumero($('#' + idInsumoQt + '').val());

    var VlrInsumo = moedaParaNumero($('#' + idInsumoVlr + '').val());

    var totalInsumo = QtInsumo * VlrInsumo;

    $('#' + idInsumoTotal + '').val(numeroParaMoeda(totalInsumo));
    //calculo do serviço

    var QtServico = moedaParaNumero($('#' + idServicoQt + '').val());

    var VlrServico = moedaParaNumero($('#' + idServicoVlr + '').val());

    var totalServico = QtServico * VlrServico;

    $('#' + idServicoTotal + '').val(numeroParaMoeda(totalServico));

}


function buscaCNPJ(sCNPJ, idEmpdes, idEmpfant, idEmpfone, idEmail, idCep, idMunicipio, idEndereco, idUf, idBairro, idComplemento, idNr, sClasse) {
    var campoVal = sCNPJ + ',' + idEmpdes + ',' + idEmpfant + ',' + idEmpfone + ',' + idEmail + ',' + idCep + ',' + idMunicipio + ',' + idEndereco + ',' + idUf + ',' + idBairro + ',' + idComplemento + ',' + idUf + ',' + idNr;

    requestAjax("", sClasse, 'getCNPJ', campoVal);
}



/**
 * funçao para chamar json com dados do CNPJ
 */
function cnpjBusca(sEmpcod, idCNPJ, idEmpdes, idEmpfant, idEmpfone, idEmail, idCep, idMunicipio, idEndereco, idUf, idBairro, idComplemento, idNr, idIBGE, sClasse, sNrSeq) {
    if (sEmpcod !== '') {
        $.ajax({
            type: 'REQUEST',
            url: "https://www.receitaws.com.br/v1/cnpj/" + sEmpcod,
            contentType: 'application/json',
            dataType: 'jsonp',
            success: function (data) {
                if (data.status == 'ERROR') {
                    mensagemSlide('warning', data.message, data.status);
                } else {
                    mensagemSlide('info', 'Buscando dados do CNPJ!', 'Aguarde!');

                    var fone = data.telefone.split('/');
                    var numero = data.numero;
                    if ($.isNumeric(numero)) {
                        numero = numero;
                    } else {
                        numero = '0';
                    }
                    var empdes = data.nome;
                    var empfant = data.fantasia;
                    var empfone = fone[0].replace(/[^\d]+/g, '');
                    var email = data.email;
                    var cep = data.cep.replace(/[^\d]+/g, '');
                    var municipio = data.municipio;
                    var endereco = data.logradouro;
                    var uf = data.uf;
                    var bairro = data.bairro;
                    var complemento = data.complemento;
                    var nr = numero;

                    var ids = idCNPJ + '|' + idEmpdes + '|' + idEmpfant + '|' + idEmpfone + '|' + idEmail + '|' + idCep + '|' + idMunicipio + '|' + idEndereco + '|' + idUf + '|' + idBairro + '|' + idComplemento + '|' + idNr + '|' + idIBGE;
                    var valores = sEmpcod + '|' + empdes + '|' + empfant + '|' + empfone + '|' + email + '|' + cep + '|' + municipio + '|' + endereco + '|' + uf + '|' + bairro + '|' + complemento + '|' + nr + '|' + sNrSeq;

                    console.log(valores);
                    requestAjax("", sClasse, 'getCNPJ', valores + '*' + ids);

                }
            },
            error: function (error) {
                mensagemSlide('error', 'Erro ao tentar buscar CNPJ!', 'Busca CNPJ');
            }
        });
    }
}


function buscaIBGE(sClasse, municipio, ufIBGE, idCampo, sNrSeq) {
    var municipioIBGE = municipio.replace(/\s/g, "-");
    var codIBGE = [];
    $.getJSON('https://servicodados.ibge.gov.br/api/v1/localidades/municipios/' + municipioIBGE + '', function (result) {
        if ($.isArray(result)) {
            result.forEach(function (e) {
                if (e.microrregiao.mesorregiao.UF.sigla === ufIBGE) {
                    codIBGE.push(e.id);
                }
            });
        } else {
            codIBGE.push(result.id);
        }

        if (codIBGE[0] === '' || codIBGE[0] === null) {
            codIBGE[0] = 'VAZIO';
        }
        requestAjax("", sClasse, 'codigoIBGE', codIBGE[0] + '|' + idCampo + '|' + sNrSeq);
    });
}


function testeMsg() {


    if /*funcção ao fechar*/ ($("#notificationList").hasClass("open")) {

    } else /*função ao abrir*/ {

    }
}

$(document).ready(function () {
    window.setTimeout(function () {
        var link = document.getElementById("link").href;
        var newTab = window.open(link, '_blank');
        window.focus();
    }, 5000);
});
