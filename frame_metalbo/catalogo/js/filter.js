/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function filtro() {
    alert('monta filtro');
    var gru = $('#gru').val();
    var subg = $('#subg').val();
    var fam = $('#fam').val();
    var subf = $('#subf').val();

    console.log(gru + '&' + subg + '&' + fam + '&' + subf);
}

function Reset() {
        var dropDown = document.getElementById("gru");
        dropDown.selectedIndex = -1;
    }

$(document).ready(function () {
    $("#gru").change(function () {
        if ($('#tipo').hasClass('opened')) {
            return;
        } else {
            $('#tipo').addClass('opened');
        }
    });
    $('#tipo').change(function () {
        if ($('#acab').hasClass('opened')) {
            return;
        } else {
            $('#acab').addClass('opened');
        }
    });
    $('#acab').change(function () {
        if ($('#bit').hasClass('opened')) {
            return;
        } else {
            $('#bit').addClass('opened');
        }

    });
});