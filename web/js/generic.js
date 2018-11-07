const url = "http://127.0.0.1/web/";
const urlws = "http://127.0.0.1/webservice/";

$(document).ready(function() {
    $("#nomeUsuarioLogado").html(sessionStorage.getItem("nome"));
});

function logado() {
    return sessionStorage.getItem("id") !== null;
}

function sair() {
    sessionStorage.clear();

    location.reload();
}