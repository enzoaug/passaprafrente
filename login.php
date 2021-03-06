<?php
if (isset($_GET["alerta"]) && !empty($_GET["alerta"]) && $_GET["alerta"] == "invalido") {
    echo "<script>alert('Usuário ou senha inválidos!')</script>";
}

if (isset($_GET["registro"]) && !empty($_GET["registro"]) && $_GET["registro"] == "ok") {
    echo "<script>alert('Registrado com sucesso! Fala o login e Passa pra Frente!')</script>";
}

if (isset($_GET["logout"]) && !empty($_GET["logout"]) && $_GET["logout"] == "ok") {
    echo "<script>alert('Deslogado com sucesso!')</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projeto Passa pra frente</title>
    <link href="src/Assets/css/bootstrap.css" rel="stylesheet">
    <link href="src/Assets/css/font-awesome.css" rel="stylesheet">
    <link href="src/Assets/css/estilo.css" rel="stylesheet">
    <link href="src/Assets/css/estilo-div.css" rel="stylesheet"/>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans|Lobster|Bree+Serif' rel='stylesheet' type='text/css'>
</head>

<body class="splash">
<div class="cont-chamada total">
    <div class="shade total"></div>
    <h1>Passa pra Frente</h1>
    <p class="texto-chamada">Lorem ipsum dolor sit amet, eu duo numquam rationibus constituam, veri veritus quaestio eum
        ei, at sit iriure hendrerit. Per sint elit consequuntur ut, quodsi malorum interesset ius in. Alii posse aperiam
        quo at, pro ne delicata dignissim intellegebat, dictas fabulas no nam. Alia apeirian mediocrem et vim, regione
        feugiat ex his, eu erat referrentur has.</p>
    <div class="center-buttons">
        <a href="#" class="btn login-face">Acesse com o Facebook</a>
        <a href="#" class="btn login-cadastro" data-toggle="modal" data-target="#myLogin">Logar com seu cadastro</a>
    </div>
</div>
<footer class="footer">
    <div class="cont-footer">
        <ul>
            <li class="link-pai link01">
                <span class="link-filho title-dos-links">Lorem</span>
                <a href="#" class="link-filho link01">Lorem Ipsum</a>
                <a href="#" class="link-filho link02">Dolor Sit</a>
            </li>
            <li class="link-pai link02">
                <span class="link-filho title-dos-links">Ipsum</span>
                <a href="#" class="link-filho link03">Amet Lorem</a>
                <a href="#" class="link-filho link04">Ipsum Dolor</a>
            </li>
            <li class="link-pai link03">
                <span class="link-filho title-dos-links">Dolor</span>
                <a href="#" class="link-filho link05">Sit Amet</a>
                <a href="#" class="link-filho link06">Lorem Ipsum</a>
            </li>
            <li class="link-pai link04">
                <span class="link-filho title-dos-links">Sit</span>
                <a href="#" class="link-filho link07">Dolor Sit</a>
                <a href="#" class="link-filho ink08">Amet Lorem</a>
            </li>
        </ul>
    </div>
</footer>

<!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
<script src="src/Assets/js/bootstrap.js"></script>
<script src="src/Assets/js/scripts.js"></script>

<div class="modal fade" id="myLogin" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <form method="post" action="src/Application/Login.php">
                    <div class="form-group">
                        <label for="InputEmail1">Endereço de e-mail</label>
                        <input type="email" name="email" class="form-control" id="InputEmail1" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="InputPassword1">Senha</label>
                        <input type="password" name="senha" class="form-control" id="InputPassword1" placeholder="Senha">
                    </div>
                    <input type="submit" class="btn btn-default"/>&nbsp;
                    <a href="#" data-toggle="modal" data-target="#myRegister">Ainda não tem cadastro?</a>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <form method="post" action="src/Application/Register.php">
                    <div class="form-group">
                        <label for="InputName">Nome</label>
                        <input type="text" name="nome" class="form-control" id="InputName" placeholder="Nome">
                    </div>
                    <div class="form-group">
                        <label for="InputLastName">Sobrenome</label>
                        <input type="text" name="sobrenome" class="form-control" id="InputLastName" placeholder="Sobrenome">
                    </div>
                    <div class="form-group">
                        <label for="InputEmail1">Endereço de e-mail</label>
                        <input type="email" name="email" class="form-control" id="InputEmail1" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="InputPassword1">Senha</label>
                        <input type="password" name="senha" class="form-control" id="InputPassword1" placeholder="Senha">
                    </div>
                    <div class="form-group">
                        <label for="InputPassword2">Repita a Senha</label>
                        <input type="password" name="repitasenha" class="form-control" id="InputPassword2" placeholder="Repita a Senha">
                    </div>
                    <input type="submit" class="btn btn-default"/>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

