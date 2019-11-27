/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $("#estado").change(function () {
        var uf = $("#estado").val();
        $("#modalrep").empty();
        $.getJSON("https://sistema.metalbo.com.br/index.php?classe=BuscaRepSite&metodo=buscaRep" + "&uf=" + uf, function (result) {
            var html = '';
            result.forEach(function (dados) {
                html = html;
            });
            $("#divPf").append(html);
            $("#callbtn").trigger("click");
        });
    });
});
