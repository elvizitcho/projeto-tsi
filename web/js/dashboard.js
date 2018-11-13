if (!logado()) {
    window.location = `${url}`;
}

$(document).ready(function() {
	var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

	elems.forEach(function(html) {
	  var switchery = new Switchery(html);
	});

	carregaComodoList();
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

function carregaDispositivos(comodoId) {
    $.ajax({
        url: `${urlws}dispositivo/list`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
            comodo_id: comodoId
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
                    <div class="col-12 col-sm-6 col-md-3">
                        <input type="checkbox" class="js-switch" onchange="alteraStatusDispositivo(${value.id})" />
                        ${value.nome}
                    </div>`);
            });

            if (retorno.dados.length == 0) {
            	$('#dispositivos').html('<div class="col-12"><p><i>Sem dispositivos cadastrados</i></p></div>');
            }

			var elems = Array.prototype.slice.call(document.querySelectorAll('#dispositivos .js-switch'));

			elems.forEach(function(html) {
			    var switchery = new Switchery(html);
			});
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para listar os dispositivos");
            console.error(e);
        }
    });
}