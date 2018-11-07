if (logado()) {
    window.location = `${url}dashboard.html`;
}

$('#form-login').on('submit', function(event) {
    event.preventDefault();

    $.ajax({
        url: `${urlws}login/validaLogin`,
        type: 'POST',
        data: {
            'usuario': $('#inputUsuario').val(),
            'senha': $('#inputSenha').val()
        },
        success: function(retorno) {
            try {
                retorno = JSON.parse(retorno);

                if (retorno.sucesso) {
                    $.each(retorno.dados_usuario, function(key, value) {
                        sessionStorage.setItem(key, value);
                    });

                    toastr.success('Você será redirecionado em poucos segundos', 'Sucesso');

                    setTimeout(function() {
                        window.location = `${url}dashboard.html`;
                    }, 3000);
                } else {
                    toastr.error(retorno.mensagem);
                }
            } catch (e) {
                toastr.error('Falha ao se comunicar com o servidor');
                console.error(retorno);
            }
        }
    });
});