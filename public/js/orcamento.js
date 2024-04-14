
$(function () {

    $('.toast').hide();

    function bloqueiaEP() {
        if ($('#table_composicao tbody tr').length > 0) {
            $('#ep').attr('readonly', true);
        } else {
            $('#ep').attr('readonly', false);
        }
    }



    $("#addComposicao").click(function () {

        if ($('#qtde').val().trim() == '') {
            abreAlert('O campo  Qtde' + texto);
            $('#qtde').focus();
            return false;
        }

        $('#table_composicao tbody').append(
            '<tr class="produto_id_'+$('#produto option:selected').val() + '">' +
                '<td data-name="produto_id" class="codigo" scope="row">'+$('#produto option:selected').val()+'</td>' +
                '<td data-name="categoria" class="" scope="row">Ar</td>' +
                '<td data-name="produto" class="" scope="row">'+$('#produto option:selected').text()+'</td>' +
                '<td data-name="descricao" class="" scope="row">Ventilação</td>' +
                '<td data-name="unidade" class="" scope="row">vb</td>' +
                '<td data-name="preco_unitario" class="" scope="row">1500,00</td>' +
                '<td data-name="quantidade" class="" scope="row">1</td>' +
                '<td><button type="button" class="close" aria-label="Close" data-codigoproduto="produto_id_'+$('#produto option:selected').val() + '">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                '</td>' +
            '</tr>');
        bloqueiaEP();
        });

    $(document).on('click', '#table_composicao .close', function () {
        id = $(this).data('codigoproduto');
        $('.' + id).remove();
    });

    $(document).on('click', 'button.close', function () {
        $('.toast').hide('slow');
    });

    function abreAlert(texto) {
        $('.textoAlerta').text(texto);
        $('.toast').show();
        setTimeout(function () {
            $('.toast').hide('slow');
        }, 7000);
    };


    $("#salvar_ficha").click(function () {

        var composicaoep = new Array();

        $('#table_composicao tbody tr').each(function (i, e) {
            json = new Array();
            $(e).find('td').each(function (c, j) {
                json.push('{"' + $(j).data('name') + '":"' + $(j).text().trim() + '"}');
            });
            composicaoep.push(json);
        })

        composicaoep = JSON.stringify(composicaoep);
        json_valores = {
            "composicaoep": composicaoep,
        }

        $('#composicoes').val(JSON.stringify(json_valores));
        setTimeout(function () {
            $('.form_ficha').submit();
        }, 1000);
    });


}); //fim ready

