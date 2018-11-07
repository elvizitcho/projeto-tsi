if (!logado()) {
    window.location = `${url}`;
}

$(document).ready(function() {
    carregaUsuarios();
});

function carregaUsuarios() {
    $.ajax({
        url: `${urlws}usuario/list`,
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

            $('#tabelaUsuarios tbody').html('');
            $.each(retorno.dados, function(key, value) {
                $('#tabelaUsuarios tbody').append(`
                    <tr>
                        <td>${value.id}</td>
                        <td>${value.nome}</td>
                        <td>${value.usuario}</td>
                        <td><span class="text-primary cursor-pointer" onclick="editar(${value.id});">Editar</span> | <span class="text-danger cursor-pointer" onclick="deletar(${value.id})">Remover</span></td>
                    </tr>`);
            })
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para listar os usuários");
            console.error(e);
        }
    });
}

function editar(id) {
    $.ajax({
        url: `${urlws}usuario/detalhes`,
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
            $('#usuario').val(retorno.dados.usuario);
            $('#senha').val();

            $('#modalCadastroUsuario').modal('show');
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para obter detalhes do usuário");
            console.error(e);
        }
    });
}

function deletar(id) {
    if (!confirm('Você tem certeza que deseja remover o usuário?')) return;

    $.ajax({
        url: `${urlws}usuario/deletar`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
            id: id
        }
    }).done(retorno => {
        try {
            retorno = JSON.parse(retorno);

            if (retorno.sucesso) {
                toastr.success('Usuário removido com sucesso');
                carregaUsuarios();
            } else {
                toastr.danger(retorno.mensagem);
            }
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor para obter detalhes do usuário");
            console.error(e);
        }
    });
}

$('#modalCadastroUsuario-form').on('submit', function(event) {
    event.preventDefault();

    let metodo = $('#id').val() == '' ? 'create' : 'update';

    $.ajax({
        url: `${urlws}usuario/${metodo}`,
        type: 'POST',
        data: {
            permissao: sessionStorage.getItem("permissao"),
            id: $("#id").val(),
            nome: $("#nome").val(),
            usuario: $("#usuario").val(),
            senha: $("#senha").val()
        }
    }).done(retorno => {
        try {
            retorno = JSON.parse(retorno);

            if (retorno.sucesso) {
                toastr.success('Usuário cadastrado com sucesso');
                $('#modalCadastroUsuario').modal('hide');
                $('#modalCadastroUsuario-form')[0].reset();
                $("#id").val('');
                carregaUsuarios();
            } else {
                toastr.danger(retorno.mensagem);
            }
        } catch (e) {
            toastr.danger("Falha ao se comunicar com o servidor");
            console.error(e);
        }
    });
});

$('#modalCadastroUsuario').on('hide.bs.modal', function() {
    $('#modalCadastroUsuario-form')[0].reset();
    $('#id').val('');
});