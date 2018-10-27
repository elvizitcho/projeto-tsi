$('#formulario-login').on('submit', function(event) {
    event.preventDefault();

    $('#errosValidacao').html('');

    $.ajax({
        url: `${base_url}login/validaLogin`,
        type: 'POST',
        data: {
            usuario: $('#usuario').val(),
            senha: $('#senha').val()
        },
        success: function(retorno) {
            try {
                retorno = JSON.parse(retorno);

                if (retorno.sucesso) {
                    location.reload();
                } else {
                    $('#errosValidacao').html(retorno.mensagem);
                }
            } catch (e) {
                alert('Falha ao se comunicar com o servidor.');
                console.error(e);
            }
        }
    });
});