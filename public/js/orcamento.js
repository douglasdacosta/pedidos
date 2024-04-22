
$(function () {

    $('.toast').hide();

    function bloqueiaEP() {
        if ($('#table_composicao tbody tr').length > 0) {
            $('#ep').attr('readonly', true);
        } else {
            $('#ep').attr('readonly', false);
        }
    }



    $("#addTextoExclusao").click(function () {

        id = $('#textos_obs_exec option:selected').val();

        observacoes_exclusoes = $('#observacoes_exclusoes').val();

        $.ajax({
            type: "POST",
            url: '/ajax-orcamentos-texto_exclusao',
            data: {
                "id": id,
                "texto": observacoes_exclusoes,
                "_token": $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#observacoes_exclusoes').val('');

                $('#observacoes_exclusoes').val(data);

            },
            error: function (data, textStatus, errorThrown) {
                alert('Erro na consulta');
            },

        });

    })
    $("#addComposicao").click(function () {

        produto = $('#produto').val();
        qtde = $('#qtde').val();

        $.ajax({
            type: "POST",
            url: '/ajax-orcamentos-produtos',
            data: {
                "produto": produto,
                "_token": $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {

                id = data.id != null ? data.id : '';
                nome_categoria = data.nome_categoria!= null ? data.nome_categoria : '';
                nome = data.nome!= null ? data.nome : '';
                descricao = data.descricao!= null ? data.descricao : '';
                unidade_medida = data.unidade_medida != null ? data.unidade_medida : '';
                precounitario = data.precounitario != null ? data.precounitario.replace('.', ",") : '';
                $('#table_composicao tbody').append(
                    '<tr class="produto_id_'+data.id+'">' +
                        '<td data-name="produto_id" class="codigo" scope="row">'+ id + '</td>' +
                        '<td data-name="categoria" class="" scope="row">'+ nome_categoria + '</td>' +
                        '<td data-name="produto" class="" scope="row">'+ nome + '</td>' +
                        '<td data-name="descricao" class="" scope="row">'+ descricao +'</td>' +
                        '<td data-name="unidade" class="" scope="row">'+ unidade_medida + '</td>' +
                        '<td data-name="preco_unitario" class="" scope="row">'+ precounitario +'</td>' +
                        '<td data-name="quantidade" class="" scope="row">'+qtde+'</td>' +
                        '<td><button type="button" class="close" aria-label="Close" data-codigoproduto="produto_id_'+id+'">' +
                            '<span aria-hidden="true">&times;</span>' +
                            '</button>' +
                        '</td>' +
                    '</tr>');

            },
            error: function (data, textStatus, errorThrown) {
                alert('Erro na consulta');
            },

        });
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


    $

}); //fim ready

