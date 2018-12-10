let configuracoesSwtichery = {
    color: '#28a745',
    secondaryColor: '#dc3545',
};

let garagemSwitch;

if (!logado()) {
    window.location = `${url}`;
}

$(document).ready(function() {
	var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

	elems.forEach(function(html) {
	  var switchery = new Switchery(html, configuracoesSwtichery);
	});

    garagemSwitch = new Switchery(document.querySelector('.garagem-switch'), configuracoesSwtichery);

	// carregaComodoList();
    carregaDispositivos();

    atualizaMedidas();
    setInterval(atualizaMedidas, 10000);
});

function carregaComodoList() {
    $.ajax({
        url: `${urlws}comodo/list`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao")
        }
    }).done(retorno => {
        try {
            retorno = JSON.parse(retorno);

            if (!retorno.sucesso) {
                toastr.danger(retorno.mensagem);
                return;
            }

            $('#comodo').html('');
            $.each(retorno.dados, function(key, value) {
                $('#comodo').append(`<option value="${value.id}">${value.nome}</option>`);
            });

            $('#comodo').change();
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para listar os cômodos");
            console.error(e);
        }
    });
}

function carregaDispositivos() {
    $.ajax({
        url: `${urlws}dispositivo/list`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
            // comodo_id: comodoId
        }
    }).done(retorno => {
        try {
            retorno = JSON.parse(retorno);

            if (!retorno.sucesso) {
                toastr.danger(retorno.mensagem);
                return;
            }

            $('#dispositivos').html('');
            $.each(retorno.dados, function(key, value) {
                $('#dispositivos').append(`
                    <div class="col-12 col-sm-6 col-md-3 pb-3 pt-3">
                        <input type="checkbox" class="js-switch" onchange="alteraStatusDispositivo(${value.id}, this.checked)" ${value.ligado == 1 ? 'checked' : ''} />
                        <b>${value.comodo_nome}</b> - ${value.nome}
                    </div>`);
            });

            if (retorno.dados.length == 0) {
            	$('#dispositivos').html('<div class="col-12"><p><i>Sem dispositivos cadastrados</i></p></div>');
            }

			var elems = Array.prototype.slice.call(document.querySelectorAll('#dispositivos .js-switch'));

			elems.forEach(function(html) {
			    var switchery = new Switchery(html, configuracoesSwtichery);
			});
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para listar os dispositivos");
            console.error(e);
        }
    });
}

function alteraStatusDispositivo(id, ativo) {
    $.ajax({
        url: `${urlws}dispositivo/${ativo ? 'ligar' : 'desligar'}`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
            id: id
        }
    }).done(retorno => {
        try {
            retorno = JSON.parse(retorno);

            if (retorno.sucesso) {
                toastr.success(`Dispositivo ${ativo ? 'ligado' : 'desligado'} com sucesso`);
            } else {
                toastr.danger(retorno.mensagem);
            }
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para listar os dispositivos");
            console.error(e);
        }
    });
}

function garagem() {
    $.ajax({
        url: `${urlws}dispositivo/garagem`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
        }
    });
}

function sistemaAlarme() {
    $.ajax({
        url: `${urlws}dispositivo/alarme`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
            status: $('#alarme-switch').is(':checked') ? 0 : 1
        }
    });
}

$('#garagem').on('change', () => {
    if ($('#garagem').is(':checked')) {
        garagemSwitch.disable();
        garagem();

        setTimeout(() => {
            garagemSwitch.enable();

            $('#garagem').siblings('.switchery').click();
        }, 9000);
    }
});

function atualizaMedidas() {
    $.ajax({
        url: `${urlws}dispositivo/getMedidas`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
            status: $('#alarme-switch').is(':checked') ? 1 : 0
        }
    }).done(retorno => {
        try {
            retorno = JSON.parse(retorno);

            $('#sensor-us').html(retorno.US);
            $('#sensor-uv').html(retorno.UV);

            $('#sensor-c').html(retorno.C == 1 ? 'Não' : 'Sim');
            $('#sensor-f').html(retorno.F == 1 ? 'Não' : 'Sim');
            $('#sensor-i').html(retorno.I == 1 ? 'Não' : 'Sim');
            $('#sensor-v').html(retorno.V == 1 ? 'Não' : 'Sim');

            let alarmeLigado = retorno.SA == 0;

            if ((alarmeLigado && !$('#alarme-switch').is(':checked')) ||
                (!alarmeLigado && $('#alarme-switch').is(':checked'))) {

                $('#alarme-switch').siblings('.switchery').click();
            }
        } catch (e) {
            console.error(e);
            toastr.danger("Falha ao se comunicar com o servidor para listar os dispositivos");
        }
    });
}