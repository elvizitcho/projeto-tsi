if (!logado()) {
    window.location = `${url}`;
}

$(document).ready(function() {
    $('#inicio, #fim').val(dataAtual());

    relatorioList();
});

function relatorioList() {
    $.ajax({
        url: `${urlws}historico/list`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
            inicio:    $('#inicio').val(),
            fim:       $('#fim').val(),
            valor:     $('#valor').val()
        }
    }).done(retorno => {
        try {
            retorno = JSON.parse(retorno);

            if (!retorno.sucesso) {
                toastr.danger(retorno.mensagem);
                return;
            }

            $('#tabelaHistorico tbody').html('');
            $.each(retorno.dados, function(key, value) {
                $('#tabelaHistorico tbody').append(`
                    <tr>
                        <td>${value.dispositivo_nome}</td>
                        <td>${value.comodo_nome}</td>
                        <td>${value.consumo}</td>
                        <td>R$ ${parseFloat(value.valor).toFixed(2)}</td>
                    </tr>`);
            })
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para listar os dispositivos");
            console.error(e);
        }
    });
}