if (!logado()) {
    window.location = `${url}`;
}

$(document).ready(function() {
    carregaDispositivos();
    carregaComodoList();
});

function carregaDispositivos() {
    $.ajax({
        url: `${urlws}dispositivo/list`,
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

            $('#tabelaDispositivos tbody').html('');
            $.each(retorno.dados, function(key, value) {
                $('#tabelaDispositivos tbody').append(`
                    <tr>
                        <td>${value.id}</td>
                        <td>${value.nome}</td>
                        <td>${value.comodo_nome}</td>
                        <td><span class="text-primary cursor-pointer" onclick="editar(${value.id});">Editar</span> | <span class="text-danger cursor-pointer" onclick="deletar(${value.id})">Remover</span></td>
                    </tr>`);
            })
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para listar os dispositivos");
            console.error(e);
        }
    });
}

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
            })
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para listar os cômodos");
            console.error(e);
        }
    });
}

function editar(id) {
    $.ajax({
        url: `${urlws}dispositivo/detalhes`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
            id: id
        }
    }).done(retorno => {
        try {
            retorno = JSON.parse(retorno);

            if (!retorno.sucesso) {
                toastr.danger(retorno.mensagem);
                return;
            }

            $('#id').val(retorno.dados.id);
            $('#nome').val(retorno.dados.nome);
            $('#comodo').val(retorno.dados.comodo_id);
            $('#tipo').val(retorno.dados.tipo);
            $('#potencia').val(retorno.dados.potencia);
            $('#porta').val(retorno.dados.porta);

            $('#modalCadastroDispositivo').modal('show');
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para obter detalhes do dispositivo");
            console.error(e);
        }
    });
}

function deletar(id) {
    if (!confirm('Você tem certeza que deseja remover o dispositivo?')) return;

    $.ajax({
        url: `${urlws}dispositivo/deletar`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
            id: id
        }
    }).done(retorno => {
        try {
            retorno = JSON.parse(retorno);

            if (retorno.sucesso) {
                toastr.success('Dispositivo removido com sucesso');

                if (id == sessionStorage.getItem("id")) {
                    sair();

                    return;
                }

                carregaDispositivos();
            } else {
                toastr.danger(retorno.mensagem);
            }
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para obter detalhes do dispositivo");
            console.error(e);
        }
    });
}

$('#modalCadastroDispositivo-form').on('submit', function(event) {
    event.preventDefault();

    let metodo = $('#id').val() == '' ? 'create' : 'update';

    $.ajax({
        url: `${urlws}dispositivo/${metodo}`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
            id: $("#id").val(),
            nome: $("#nome").val(),
            comodo_id: $("#comodo").val(),
            tipo: $("#tipo").val(),
            potencia: $("#potencia").val(),
            porta: $("#porta").val()
        }
    }).done(retorno => {
        try {
            retorno = JSON.parse(retorno);

            if (retorno.sucesso) {
                toastr.success('Dispositivo cadastrado com sucesso');
                $('#modalCadastroDispositivo').modal('hide');
                $('#modalCadastroDispositivo-form')[0].reset();
                $("#id").val('');
                carregaDispositivos();
            } else {
                toastr.danger(retorno.mensagem);
            }
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor");
            console.error(e);
        }
    });
});

$('#modalCadastroDispositivo').on('hide.bs.modal', function() {
    $('#modalCadastroDispositivo-form')[0].reset();
    $('#id').val('');
});

$('#modalCadastroDispositivo').on('shown.bs.modal', function() {
    $("#nome").focus();
});