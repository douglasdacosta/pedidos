
$(function () {

    calculaTempos()
    $('.toast').hide();

    function bloqueiaEP() {
        if ($('#table_composicao tbody tr').length > 0) {
            $('#ep').attr('readonly', true);
        } else {
            $('#ep').attr('readonly', false);
        }
    }

    function bloqueiaCampos($bloquear){
        if($bloquear){
            $('#tempo_usinagem, #blank, #medidax, #mediday, #tempo_acabamento, #tempo_montagem, #tempo_inspecao').prop('readonly', true);
        } else {
            $('#tempo_usinagem, #blank, #medidax, #mediday, #tempo_acabamento, #tempo_montagem, #tempo_inspecao').prop('readonly', false);
    
        }
    }
    

    $("#addComposicao").click(function () {
        if ($('#ep').val().trim() == '') {
            abreAlert('O campo EP' + texto);
            $('#ep').focus();
            return false;
        }
        if ($('#material_id').val() == '') {
            abreAlert('O campo  Material não selecionado');
            $('#material_id').focus();
            return false;
        }
        if ($('#qtde').val().trim() == '') {
            abreAlert('O campo  Qtde' + texto);
            $('#qtde').focus();
            return false;
        }
        if ($('#unid').val().trim() == '') {
            abreAlert('O campo  unid' + texto);
            $('#unid').focus();
            return false;
        }
        blank = $('#ep').val().toUpperCase().trim();
        $('#table_composicao tbody').append(
            '<tr class="ep_'+$('#material_id option:selected').val() + '">' +
                '<td data-name="ep" class="ep" scope="row">' + blank + '</td>' +
                '<td data-name="material_id" class="material_id" data-materialid="' + $('#material_id option:selected').val() + '" >' + $('#material_id option:selected').text() + '</td>' +
                '<td data-name="unid" class="qtde">' + $('#unid').val() + '</td>' +
                '<td data-name="qtd" class="qtd">' + $('#qtde').val() + '</td>' +
                '<td><button type="button" class="close" aria-label="Close" data-ep="' + $('#material_id option:selected').val() + '">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                '</td>' +
            '</tr>');
    });

    $(document).on('click', '#table_composicao .close', function () {
        id = $(this).data('ep');
        console.log(id);
        $('.ep_' + id).remove();
        calculaTempos();
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


    function calculaTempos() {
        somatempo_usinagem_total = somatempo_acabamento_total = somatempo_montagem_total = somamontagem_torre_total = somatempo_inspecao_total = '00:00:00';
        $('.tempo_usinagem').each(function (i, e) {
            if (e.textContent != '') {
                somatempo_usinagem_linha = multiplicaMinutos(i, e.textContent);
                somatempo_usinagem_total = somarHoras(somatempo_usinagem_total, somatempo_usinagem_linha);
            }
        });

        $('.tempo_acabamento').each(function (i, e) {
            if (e.textContent != '') {
                somatempo_acabamento_linha = multiplicaMinutos(i, e.textContent);
                somatempo_acabamento_total = somarHoras(somatempo_acabamento_total, somatempo_acabamento_linha);
            }
        });

        $('.tempo_montagem').each(function (i, e) {
            if (e.textContent != '') {
                somatempo_montagem_linha = multiplicaMinutos(i, e.textContent);
                somatempo_montagem_total = somarHoras(somatempo_montagem_total, somatempo_montagem_linha);
            }
        });

        $('.tempo_montagem_torre').each(function (i, e) {
            if (e.textContent != '') {
                somatempo_torre_linha = multiplicaMinutos(i, e.textContent);
                somamontagem_torre_total = somarHoras(somamontagem_torre_total, somatempo_torre_linha);
            }
        });

        $('.tempo_inspecao').each(function (i, e) {
            if (e.textContent != '') {
                somatempo_inspecao_linha = multiplicaMinutos(i, e.textContent);
                somatempo_inspecao_total = somarHoras(somatempo_inspecao_total, somatempo_inspecao_linha);
            }
        });


        $('#soma_tempo_acabamento').val(somatempo_acabamento_total.toString().replace('.', ','));
        $('#soma_tempo_montagem_torre').val(somamontagem_torre_total.toString().replace('.', ','));
        $('#soma_tempo_montagem').val(somatempo_montagem_total.toString().replace('.', ','));
        $('#soma_tempo_usinagem').val(somatempo_usinagem_total.toString().replace('.', ','));
        $('#soma_tempo_inspecao').val(somatempo_inspecao_total.toString().replace('.', ','));

        bloqueiaEP();
    }

    /**
     * Transforma um numero inteiro em formato de 00:00:00
     * @param {*} numeroString
     * @returns
     */
    function trataStringHora(numeroString) {
        const numerosEncontrados = numeroString.match(/[0-9]/g);

        numerosString2 = numerosEncontrados ? numerosEncontrados.join('') : '';

        while (numerosString2.length < 6) {
            numerosString2 = '0' + numerosString2;
        }
        return numerosString2.toString().substring(2, 0) + ':' + numerosString2.toString().substring(4, 2) + ':' + numerosString2.toString().substring(6, 4);
    }

    /**
     * multiplica um valor em horas por um inteiro
     * @param {*} index
     * @param {*} valor
     * @returns
     */
    function multiplicaMinutos(index, valor) {

        valor = trataStringHora(valor);
        qtde = $('.qtde').eq(index).text();
        valor = multiplicarHoras(valor, qtde);
        return valor;
    }

    /**
     *
     * @param {*} padraoHoras
     * @param {*} multiplicador
     * @returns
     */
    function multiplicarHoras(padraoHoras, multiplicador) {

        padraoHoras = trataStringHora(padraoHoras);

        // Dividir as horas, minutos e segundos
        const [horas, minutos, segundos] = padraoHoras.toString().split(':').map(Number);

        // Converter tudo para segundos e multiplicar pelo fator
        const totalSegundos = (horas * 3600 + minutos * 60 + segundos) * multiplicador;

        // Converter de volta para o formato de horas
        const novoHoras = Math.floor(totalSegundos / 3600);
        const novoMinutos = Math.floor((totalSegundos % 3600) / 60);
        const novoSegundos = totalSegundos % 60;

        // Formatar e retornar o resultado
        const resultado = novoHoras.toString().padStart(2, '0') + ':' + novoMinutos.toString().padStart(2, '0') + ':' + novoSegundos.toString().padStart(2, '0');

        return resultado;
    }

    /**
     * Soma dois valores de homas Ex: 00:00:10 + 00:00:10 = 00:00:20
     * @param {*} hora1
     * @param {*} hora2
     * @returns
     */
    function somarHoras(hora1, hora2) {

        hora1 = trataStringHora(hora1);
        hora2 = trataStringHora(hora2)
        // Dividir as horas, minutos e segundos
        const [h1, m1, s1] = hora1.toString().split(':').map(Number);
        const [h2, m2, s2] = hora2.toString().split(':').map(Number);

        // Somar as horas, minutos e segundos
        const totalSegundos = (h1 * 3600 + m1 * 60 + s1) + (h2 * 3600 + m2 * 60 + s2);

        // Converter de volta para o formato de horas
        const novoHoras = Math.floor(totalSegundos / 3600);
        const novoMinutos = Math.floor((totalSegundos % 3600) / 60);
        const novoSegundos = totalSegundos % 60;

        // Formatar e retornar o resultado
        const resultado = novoHoras.toString().padStart(2, '0') + ':' + novoMinutos.toString().padStart(2, '0') + ':' + novoSegundos.toString().padStart(2, '0');
        return resultado;
    }

    $("#salvar_ficha").click(function () {

        var composicaoep = new Array();

        $('#table_composicao tbody tr').each(function (i, e) {
            json = new Array();
            $(e).find('td').each(function (c, j) {

                if ($(j).data('name') == 'material_id') {
                    json.push('{"' + $(j).data('name') + '":"' + $(j).data('materialid') + '"}');
                } else {
                    json.push('{"' + $(j).data('name') + '":"' + $(j).text().trim() + '"}');
                }
            });
            composicaoep.push(json);
        })

        composicaoep = JSON.stringify(composicaoep);
        json_valores = {
            "composicaoep": composicaoep,
            "soma_tempo_acabamento": $('#soma_tempo_acabamento').val(),
            "soma_tempo_montagem_torre": $('#soma_tempo_montagem_torre').val(),
            "soma_tempo_montagem": $('#soma_tempo_montagem').val(),
            "soma_tempo_usinagem": $('#soma_tempo_usinagem').val(),
            "soma_tempo_inspecao": $('#soma_tempo_inspecao').val(),
        }

        $('#composicoes').val(JSON.stringify(json_valores));
        setTimeout(function () {
            $('.form_ficha').submit();
        }, 1000);
    });


}); //fim ready

