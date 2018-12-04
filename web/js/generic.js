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

function dataAtual() {
    let now = new Date();

    return now.getFullYear() + '-' + ("0" + (now.getMonth() + 1)).slice(-2) + '-' + ("0" + now.getDate()).slice(-2);
}