if (!logado()) {
    window.location = `${url}`;
}

var backgroundColor = [];
var borderColor     = [];
var data            = [];

$(document).ready(function() {
    $('#inicio, #fim').val(dataAtual());

    relatorioList();
    gerarGrafico();
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

            backgroundColor = [];
            borderColor     = [];
            data            = [];
            labels          = [];
            let cor;

            $('#tabelaHistorico tbody').html('');
            $.each(retorno.dados, function(key, value) {
                $('#tabelaHistorico tbody').append(`
                    <tr>
                        <td>${value.dispositivo_nome}</td>
                        <td>${value.comodo_nome}</td>
                        <td>${value.consumo}</td>
                        <td>R$ ${parseFloat(value.valor).toFixed(2)}</td>
                    </tr>`);

                cor = randomColor();

                labels.push(`${value.dispositivo_nome} (${value.comodo_nome})`);
                data.push(parseFloat(value.consumo));
                backgroundColor.push(cor);
                borderColor.push(cor);
            });

            gerarGrafico();
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para listar os dispositivos");
            console.error(e);
        }
    });
}

function gerarGrafico() {
    var ctx = document.getElementById("myChart").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Consumo em Kw/h do dispositivo',
                data: data,
                backgroundColor: backgroundColor,
                borderColor: borderColor,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
}

function randomColor() {
    var o = Math.round, r = Math.random, s = 255;
    return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
}