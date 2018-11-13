if (!logado()) {
    window.location = `${url}`;
}

$(document).ready(function() {
    carregaComodos();
});

function carregaComodos() {
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

            $('#tabelaComodos tbody').html('');
            $.each(retorno.dados, function(key, value) {
                $('#tabelaComodos tbody').append(`
                    <tr>
                        <td>${value.id}</td>
                        <td>${value.nome}</td>
                        <td><span class="text-primary cursor-pointer" onclick="editar(${value.id});">Editar</span> | <span class="text-danger cursor-pointer" onclick="deletar(${value.id})">Remover</span></td>
                    </tr>`);
            })
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para listar os cômodos");
            console.error(e);
        }
    });
}

function editar(id) {
    $.ajax({
        url: `${urlws}comodo/detalhes`,
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

            $('#modalCadastroComodo').modal('show');
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para obter detalhes do cômodo");
            console.error(e);
        }
    });
}

function deletar(id) {
    if (!confirm('Você tem certeza que deseja remover o cômodo?')) return;

    $.ajax({
        url: `${urlws}comodo/deletar`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
            id: id
        }
    }).done(retorno => {
        try {
            retorno = JSON.parse(retorno);

            if (retorno.sucesso) {
                toastr.success('Cômodo removido com sucesso');

                if (id == sessionStorage.getItem("id")) {
                    sair();

                    return;
                }

                carregaComodos();
            } else {
                toastr.danger(retorno.mensagem);
            }
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para obter detalhes do cômodo");
            console.error(e);
        }
    });
}

$('#modalCadastroComodo-form').on('submit', function(event) {
    event.preventDefault();

    let metodo = $('#id').val() == '' ? 'create' : 'update';

    $.ajax({
        url: `${urlws}comodo/${metodo}`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
            id: $("#id").val(),
            nome: $("#nome").val(),
        }
    }).done(retorno => {
        try {
            retorno = JSON.parse(retorno);

            if (retorno.sucesso) {
                toastr.success('Cômodo cadastrado com sucesso');
                $('#modalCadastroComodo').modal('hide');
                $('#modalCadastroComodo-form')[0].reset();
                $("#id").val('');
                carregaComodos();
            } else {
                toastr.danger(retorno.mensagem);
            }
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor");
            console.error(e);
        }
    });
});

$('#modalCadastroComodo').on('hide.bs.modal', function() {
    $('#modalCadastroComodo-form')[0].reset();
    $('#id').val('');
});

$('#modalCadastroComodo').on('shown.bs.modal', function() {
    $("#nome").focus();
});