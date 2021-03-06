<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>eNove</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script>
        var base_url = "<?= addslashes(base_url()) ?>";
    </script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m6 l4 offset-m3 offset-l4">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <form class="col s12" id="formulario-login">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">perm_identity</i>
                                        <input id="usuario" type="text" class="validate">
                                        <label for="usuario">Usuário</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">https</i>
                                        <input id="senha" type="password" class="validate">
                                        <label for="senha">Senha</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 right-align">
                                        <button type="submit" id="botaoSubmit" class="waves-effect waves-light btn">Acessar <i class="material-icons right">chevron_right</i></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12" id="errosValidacao"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="<?= base_url('assets/js/login/login.js') ?>"></script>
</body>

</html>