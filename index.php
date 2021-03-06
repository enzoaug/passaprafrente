<?php
session_start();

define("ROOT", dirname(__FILE__));
define("DS", DIRECTORY_SEPARATOR);

include_once ROOT . DS . "vendor" . DS . "autoload.php";

if (!isset($_SESSION["usuario_id"]) && empty($_SESSION["usuario_id"])) {
    header("Location: login.php");
}

if (isset($_GET["euquero"]) && !empty($_GET["euquero"]) && $_GET["euquero"] == "ok") {
    echo "<script>alert('Solicitação enviada com sucesso! Agora é só aguardar uma resposta! =)')</script>";
}

if (isset($_GET["alterarPerfil"]) && !empty($_GET["alterarPerfil"]) && $_GET["alterarPerfil"] == "ok") {
    echo "<script>alert('Perfil alterado com sucesso!')</script>";
}

if (isset($_GET["produto"]) && !empty($_GET["produto"]) && $_GET["produto"] == "ok") {
    echo "<script>alert('Produto adicionado com sucesso!')</script>";
}

$conn = new \Core\Database\Database();
$pdo = $conn->connect();

$all = new \Application\Produtos\All();
$select = $pdo->prepare($all->getAll());
$select->execute();
$produtos = $select->fetchAll(PDO::FETCH_OBJ);

if (isset($_GET["buscar"]) && !empty($_GET["buscar"])) {
    $select = $pdo->prepare($all->getAll($_GET["buscar"]));
    $select->execute();
    $produtos = $select->fetchAll(PDO::FETCH_OBJ);
}

$allMensagens = new \Application\Mensagens\All();
$selectMensagens = $pdo->prepare($allMensagens->getAll());
$selectMensagens->execute();
$mensagens = $selectMensagens->fetchAll(PDO::FETCH_OBJ);

$allMeusCompartilhamentos = new \Application\Produtos\All();
$selectMeusCompartilhamentos = $pdo->prepare($allMeusCompartilhamentos->getMeusCompartilhamentos());
$selectMeusCompartilhamentos->execute();
$meusCompartilhamentos = $selectMeusCompartilhamentos->fetchAll(PDO::FETCH_OBJ);

$allUser = new \Application\Usuarios\All();
$selectUser = $pdo->prepare($allUser->getUser($_SESSION["usuario_id"]));
$selectUser->execute();
$user = $selectUser->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Passa pra Frente</title>

    <!-- Bootstrap -->

    <link href="src/Assets/css/bootstrap.css" rel="stylesheet">
    <link href="src/Assets/css/owl.carousel.css" rel="stylesheet">
    <link href="src/Assets/css/font-awesome.css" rel="stylesheet">
    <link href="src/Assets/css/estilo.css" rel="stylesheet">
    <!-- HTML5 shim e Respond.js para suporte no IE8 de elementos HTML5 e media queries -->
    <!-- ALERTA: Respond.js não funciona se você visualizar uma página file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header class="container-fluid header navbar-fixed-top">
    <div class="container">
        <div class="row">
            <form method="GET">
                <div class="busca-no-site">
                    <div class="input-group">
                        <input type="text" class="form-control" name="buscar" id="buscar" placeholder="Buscar">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </span>
                    </div><!-- /input-group -->
                </div>
            </form>
            <button type="button" class="btn btn-primary bt-passa-pra-frente" data-toggle="modal"
                    data-target="#compartilhandoThis">Passa pra frente!
            </button>
            <div class="btn-group grupo-bt">
                <button class="btn btn-default mensagem-bt" type="button" data-toggle="modal" data-target="#novidades">
                    <i class="fa fa-envelope" aria-hidden="true"></i><span class="badge">12</span></button>
                <button type="button" class="btn btn-default dropdown-toggle menu" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
                <ul class="dropdown-menu menu-user"><!-- Dropdown do menu do usuáio -->
                    <li class="coluna1">
                        <div class="img-me"><img src="src/Assets/images/<?= $user->foto ?>" alt="Imagem do Usuário"
                                                 class="img-circle"></div>
                        <h2 class="nome-me"><?= $_SESSION["usuario"] ?></h2>
                        <h3 class="apelido-me"><?= $user->apelido ?></h3>
                        <div class="seguidores-me"><span>Seguidores: </span><span class="numero">5</span></div>
                        <div class="seguindo-me"><span>Seguindo: </span><span class="numero">7</span></div>
                        <div class="itens-comp"><span>Itens compartilhados: </span><span class="numero">5</span></div>
                        <div class="itens-adq"><span>Itens adquiridos: </span><span class="numero">7</span></div>
                    </li>
                    <li class="coluna2">
                        <button type="button" class="btn btn-default minhasMsg" data-toggle="modal"
                                data-target="#minhasMsgModal">Minhas conversas
                        </button>
                        <button type="button" class="btn btn-default me-compartilhamentos" data-toggle="modal"
                                data-target="#me-compartilhamentosModal">Compartilhamentos
                        </button>
                        <button type="button" class="btn btn-default alt-perfil" data-toggle="modal"
                                data-target="#alt-perfilModal">Alterar perfil
                        </button>
                        <form action="src/Application/Logout.php">
                            <button type="submit" class="btn btn-default btn-warning logoff">Deslogar</button>
                        </form>
                    </li>
                </ul><!-- fim do Dropdown do menu do usuáio -->
            </div>
            <button type="button" class="btn btn-primary bt-passa-pra-frente-mobile">Passar pra frente!</button>

        </div><!-- /.row -->
        <!--button type="button" class="btn btn-primary col-xs-12 visible-xs-block">Passar pra frente!</button-->
    </div>
</header>
<div class="container-fluid conteudo">
    <div class="container">
        <ul class="lista">
            <?php foreach ($produtos as $produto) : ?>
                <li class="listagem">
                    <div class="ident-info">
                        <a href="#"><img src="src/Assets/images/<?= $produto->foto ?>" class="img-compart img-circle"></a>
                        <div class="info-name-date">
                            <a href="#"><h3 class="nome-compart"><?= $produto->nome ?> <?= $produto->sobrenome ?></h3>
                            </a>
                            <span class="time"><?= $all->parseMinute($produto->postdate) ?></span>
                        </div>
                    </div>
                    <!--a href="#" class="link-produto"-->
                    <a href="#void" class="link-produto" data-toggle="modal" data-target="#Produto<?= $produto->id ?>">
                        <img src="src/Assets/images/<?= $produto->imagem ?>" class="img-rounded">
                    </a>
                    <a href="#void" class="info-prod" data-toggle="modal" data-target="#Produto<?= $produto->id ?>">
                        <h2 class="nome-prod"><?= $produto->titulo ?></h2>
                        <h3 class="lil-desc"><?= $produto->descricao ?></h3>
                    </a>
                    <div class="cont-likes-comments">
                        <div class="likes text-danger">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                            <span class="like-count">3</span>
                        </div>
                        <div class="scraps text-info">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            <span class="scraps-count">5</span>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>

            <ul class="paginacao">
                <li class="paginacao-item primeiro"><a href="#" class="paginacao-link btn-link"><i
                            class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                <li class="paginacao-item voltar"><a href="#" class="paginacao-link btn-link"><i
                            class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                <li class="paginacao-item pagNumero"><a href="#" class="paginacao-link btn btn-link">1</a></li>
                <li class="paginacao-item pagNumero"><a href="#" class="paginacao-link btn btn-link">2</a></li>
                <li class="paginacao-item pagNumero"><span href="#" class="paginacao-link btn btn-link">...</span></li>
                <li class="paginacao-item pagNumero"><a href="#" class="paginacao-link btn btn-link">5</a></li>
                <li class="paginacao-item proximo"><a href="#" class="paginacao-link btn btn-link"><i
                            class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                <li class="paginacao-item ultimo"><a href="#" class="paginacao-link btn btn-link"><i
                            class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
            </ul>
        </ul>
        <aside class="novidades aside"></aside>
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

<!-- Modal Novidades para Mobile -->

<div class="novidades modal fade" id="novidades" tabindex="-1" role="dialog" aria-labelledby="Novidades">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Atualizações</h4>
            </div>
            <div class="modal-body">
                <ul class="novidade-lista">
                    <?php if (isset($mensagens) && !empty($mensagens)) : ?>
                        <?php foreach ($mensagens as $mensagem) : ?>
                            <li class="list-news-iten">
                                <a href="#" data-toggle="modal" data-target="#message<?= $mensagem->id ?>">
                                <span class="owner-image-cont receptor">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                </span>
                                    <p class="historia">
                                        <strong
                                            class="receptor-name">Você</strong>
                                        <span class="action">recebeu mensagem de</span>
                                        <strong
                                            class="doador-name"><?= $mensagem->nome_usuario_recebe ?> <?= $mensagem->sobrenome_usuario_recebe ?></strong>
                                    </p>
                                <span class="owner-image-cont doador">
                                <img src="src/Assets/images/owner02.jpg" alt="Nome do dono"
                                     class="owner-img img-circle">
                                </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li class="list-news-iten">
                            <p>Nenhuma mensagem por aqui!</p>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<?php foreach ($produtos as $produto) : ?>
    <div class="modal fade produto-page" id="Produto<?= $produto->id ?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <div class="ident-info">
                        <a href="#"><img src="src/Assets/images/owner01.jpg" class="img-compart img-circle"></a>
                        <div class="info-name-date">
                            <a href="#"><h3 class="nome-compart"><?= $produto->nome ?> <?= $produto->sobrenome ?></h3>
                            </a>
                            <span class="time"><?= $all->parseMinute($produto->postdate) ?></span>
                        </div>
                        <div class="title-produto">
                            <h2><?= $produto->titulo ?></h2>
                        </div>
                        <div class="cont-likes-comments">
                            <div class="likes text-danger">
                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                                <span class="like-count">3</span>
                            </div>
                            <div class="scraps text-info">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                <span class="scraps-count">5</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container produto-container">

                        <div class="imgProd-Cont col-md-6">
                            <div class="img-do-produto">
                                <img src="src/Assets/images/<?= $produto->imagem ?>" class="img-rounded">
                                <img src="src/Assets/images/sofa-801.jpg" class="img-rounded">
                                <img src="src/Assets/images/sofa-802.jpg" class="img-rounded">
                            </div>
                        </div>
                        <div class="conteudo-R">
                            <div class="title-produto">
                                <h2><?= $produto->titulo ?></h2>
                                <div class="cont-likes-comments">
                                    <div class="likes text-danger">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        <span class="like-count">3</span>
                                    </div>
                                    <div class="scraps text-info">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                        <span class="scraps-count">5</span>
                                    </div>
                                </div>
                            </div>
                            <div class="descricao-produto">
                                <h3>Descricão do produto</h3>
                                <p><?= $produto->descricao ?></p>
                            </div>
                            <a href="#" class="btn btn-success eu-quero btn-lg" data-toggle="modal"
                               data-target="#eu-queroModal<?= $produto->id ?>">Eu quero!</a>

                        </div>

                        <div class="opiniao-users">
                            <div class="opiniao-menu">
                                <a class="btn btn-default opnUsuario" href="#" role="button">Ver a opinião dos
                                    usuários</a>
                                <a class="btn btn-default postarOpiniao" href="#" role="button">Deixar sua opinião</a>
                            </div>
                            <div class="opiniao-users-texts">
                                <div class="opUsers-cont opUsers-cont-001">
                                    <a href="#" class="user-pic"><img src="src/Assets/images/owner02.jpg"
                                                                      class="owner-img img-circle"></a>
                                    <div class="info-name-opUsers">
                                        <a href="#"><h3 class="nome-compart">Nome do Usuário</h3></a>
                                        <p>disse a <span class="time">2 dias</span></p>
                                    </div>
                                    <p class="opUsers-text">
                                        Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                                        adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et
                                        dolore
                                        magnam aliquam quaerat voluptatem.
                                    </p>
                                </div>

                                <div class="opUsers-cont opUsers-cont-002">
                                    <a href="#" class="user-pic"><img src="src/Assets/images/owner02.jpg"
                                                                      class="owner-img img-circle"></a>
                                    <div class="info-name-opUsers">
                                        <a href="#"><h3 class="nome-compart">Nome do Usuário</h3></a>
                                        <p>disse a <span class="time">2 dias</span></p>
                                    </div>
                                    <p class="opUsers-text">
                                        Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                                        adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et
                                        dolore
                                        magnam aliquam quaerat voluptatem.
                                    </p>
                                </div>

                                <div class="opUsers-cont opUsers-cont-003">
                                    <a href="#" class="user-pic"><img src="src/Assets/images/owner02.jpg"
                                                                      class="owner-img img-circle"></a>
                                    <div class="info-name-opUsers">
                                        <a href="#"><h3 class="nome-compart">Nome do Usuário</h3></a>
                                        <p>disse a <span class="time">2 dias</span></p>
                                    </div>
                                    <p class="opUsers-text">
                                        Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                                        adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et
                                        dolore
                                        magnam aliquam quaerat voluptatem.
                                    </p>
                                </div>
                            </div>

                            <div class="minha-opiniao">
                                <form>
                                    <div class="form-group">
                                        <label for="minha-opiniao-text">Escreva no campo abaixo sua opoinião sobre o
                                            item.</label>
                                    <textarea class="form-control mOpiniao-tArea" rows="3"
                                              id="minha-opiniao-text"></textarea>
                                        <button type="submit" class="btn btn-default">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div><!-- fim de opiniao-users -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Lista de Minhas Mensagens-->
<div class="modal fade" id="minhasMsgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Minhas conversas</h4>
            </div>
            <div class="modal-body">
                <ul class="conversas-lista">
                    <!--li class="list-news-iten"><h3>Novidades</h3></li-->
                    <li class="list-news-iten">
                        <a href="#" data-toggle="modal" data-target="#message0001">
                  <span class="owner-image-cont doador pull-left">
                    <img src="src/Assets/images/owner02.jpg" alt="Nome do dono" class="owner-img img-circle">
                  </span>
                            <p class="info-msg pull-right">
                                <span class="action">Mensagens de</span>
                                <strong class="receptor-name">Joana da Silva</strong>
                                <small>Última mensagem: 01/08/2016</small>
                            </p>
                        </a>
                    </li>
                    <li class="list-news-iten">
                        <a href="#" data-toggle="modal" data-target="#message0001">
                  <span class="owner-image-cont doador pull-left">
                    <img src="src/Assets/images/owner02.jpg" alt="Nome do dono" class="owner-img img-circle">
                  </span>
                            <p class="info-msg pull-right">
                                <span class="action">Mensagens de</span>
                                <strong class="receptor-name">Joana da Silva</strong>
                                <small>Última mensagem: 01/08/2016</small>
                            </p>
                        </a>
                    </li>
                    <li class="list-news-iten">
                        <a href="#" data-toggle="modal" data-target="#message0001">
                  <span class="owner-image-cont doador pull-left">
                    <img src="src/Assets/images/owner02.jpg" alt="Nome do dono" class="owner-img img-circle">
                  </span>
                            <p class="info-msg pull-right">
                                <span class="action">Mensagens de</span>
                                <strong class="receptor-name">Joana da Silva</strong>
                                <small>Última mensagem: 01/08/2016</small>
                            </p>
                        </a>
                    </li>
                </ul>


            </div>
        </div>
    </div>
</div>

<!-- Sequencia de Compartilhamento -->
<form action="src/Application/Produtos/Insert.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="estado" value="disponivel">
    <input type="hidden" name="usuario_id" value="<?= $_SESSION["usuario_id"] ?>">
    <input type="hidden" name="data_publicacao" value="<?= date("Y-m-d H:i:s") ?>">
    <div class="modal fade" id="compartilhandoThis" tabindex="-1" role="dialog" aria-labelledby="primeiraVisitaLabel"
         data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="contTelas2">
                        <div class="telaPv telaPv1">
                            <h2>Obrigado por usar o<br/>Passa pra Frente</h2>
                            <p>Compartilhando um item que não usa mais você estará ajudando alguém!</p>
                            <h2>Vamos começar!</h2>
                            <div class="telaPvButtons">
                                <a href="javascript:void(0);" class="link-continuar2 btn btn-primary">Continuar</a>
                            </div>
                        </div>
                        <div class="telaPv telaPv2">
                            <h2>Por favor, insira até 3 imagens do item que deseja compartilhar</h2>
                            <div class="telaPvCont imgPlaces">

                            </div>
                            <div class="telaPvCont form-group">
                                <label for="exampleInputFile"></label>
                                <input type="file" id="exampleInputFile" name="imagem">
                                <p class="help-block">Clique em escolher para escolher uma imagem no seu computador.</p>
                            </div>
                            <div class="telaPvButtons">
                                <a href="javascript:void(0);" class="link-voltar2 btn btn-secondary">Voltar</a>
                                <a href="javascript:void(0);" class="link-continuar2 btn btn-primary">Continuar</a>
                            </div>
                        </div>
                        <div class="telaPv telaPv3">
                            <h2>Por favor, insira até 3 imagens do item que deseja compartilhar</h2>
                            <div class="telaPvCont imgPlaces">
                                <img src="src/Assets/images/sofa-800.jpg" alt="imagem 1" class="newImgs img-rounded">
                                <img src="src/Assets/images/sofa-801.jpg" alt="imagem 2" class="newImgs img-rounded">
                                <img src="src/Assets/images/sofa-802.jpg" alt="imagem 3" class="newImgs img-rounded">
                            </div>
                            <div class="telaPvButtons">
                                <a href="javascript:void(0);" class="link-voltar2 btn btn-secondary">Voltar</a>
                                <a href="javascript:void(0);" class="link-continuar2 btn btn-primary">Continuar</a>
                            </div>
                        </div>
                        <div class="telaPv telaPv4">
                            <h2>Qual o nome do item que você está compartilhando?</h2>
                            <div class="telaPvCont form-group">
                                <label for="nome-do-item"></label>
                                <input type="text" class="form-control" id="nome-do-item" name="titulo"
                                       placeholder="Nome do Item">
                            </div>
                            <div class="telaPvButtons">
                                <a href="javascript:void(0);" class="link-voltar2 btn btn-secondary">Voltar</a>
                                <a href="javascript:void(0);" class="link-continuar2 btn btn-primary">Continuar</a>
                            </div>
                        </div>
                        <div class="telaPv telaPv5">
                            <h2>Decreva o item que você está compartilhando</h2>
                            <div class="telaPvCont form-group">
                                <label for="descricao-do-item"></label>
                            <textarea class="form-control" id="descricao-do-item" name="descricao"
                                      placeholder="Descrição do Item"
                                      rows="3"></textarea>
                            </div>
                            <div class="telaPvButtons">
                                <a href="javascript:void(0);" class="link-voltar2 btn btn-secondary">Voltar</a>
                                <a href="javascript:void(0);" class="link-continuar2 btn btn-primary">Continuar</a>
                            </div>
                        </div>
                        <div class="telaPv telaPv6">
                            <h2>Obrigado!</h2>
                            <p>Agora é só aguardar uma mensagem de interesse e conversar com as pessoas que querem este
                                item
                                que você não usa mais.</p>
                            <div class="telaPvButtons">
                                <a href="javascript:void(0);" class="link-voltar2 btn btn-secondary">Voltar</a>
                                <button type="submit" class="btn btn-primary">Continuar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Lista de Meus compartilhamentos-->
<div class="modal fade" id="me-compartilhamentosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Meus compartilhamentos</h4>
            </div>
            <div class="modal-body">
                <div class="cont-itens-compertilhados">
                    <!--Item compartilhado por mim -->
                    <?php foreach ($meusCompartilhamentos as $meuCompartilhamento) : ?>
                        <div class="item-compartilhado">
                            <div class="imagem-item pull-left">
                                <img src="src/Assets/images/<?= $meuCompartilhamento->imagem ?>" class="img-rounded">
                            </div>
                            <div class="cont-infos-item pull-right">
                                <h4 class="nome-do-item pull-left"><?= $meuCompartilhamento->titulo ?></h4>
                                <small class="estado-troca bg-info">Em andamento</small>
                                <div class="cont-contrlStatus">
                                    <button type="button" class="btn btn-default dropdown-toggle btn-xs"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <li><strong>Escolha o estado do compartilhamento:</strong></li>
                                        <li role="separator" class="divider"></li>
                                        <li>
                                            <button type="button" class="btn btn-default btn-sm">Em andamento</button>
                                        </li>
                                        <li>
                                            <button type="button" class="btn btn-success btn-sm">Finalizado</button>
                                        </li>
                                        <li>
                                            <button type="button" class="btn btn-danger btn-sm">Cancelado</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- alterar perfil -->
<div class="modal fade" id="alt-perfilModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="src/Application/Usuarios/Profile.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <div class="contAltPerfil">
                        <div class="altFoto">
                            <div class="img-me"><img src="src/Assets/images/<?= $user->foto ?>" alt="Imagem do Usuário"
                                                     class="img-circle"></div>
                            <span>
                                <label for="foto">Alterar Foto</label>
                                <input type="file" id="foto" name="foto">
                            </span>
                        </div>
                    </div>
                    <div class="form-group altPerfForm">
                        <label for="esccreva-textoMsg">Apelido</label>
                        <input type="text" class="form-control" name="apelido" id="esccreva-textoMsg"
                               placeholder="<?= ($user->apelido) ? $user->apelido : "Escreva aqui seu apelido..." ?>">

                        <label for="esccreva-textoMsg">Descrição</label>
                        <textarea name="descricao" id="esccreva-textoMsg" class="form-control"
                                  placeholder="Escreva aqui sua descrição"><?= ($user->descricao) ? $user->descricao : "Escreva aqui sua descricao..." ?></textarea>
                  <span>
                    <button type="submit" class="btn btn-success">Enviar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancelar
                    </button>
                  </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Eu quero!-->
<?php foreach ($produtos as $produto) : ?>
    <div class="modal fade" id="eu-queroModal<?= $produto->id ?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form action="src/Application/EuQuero.php" method="post">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h2 class="center-block text-success">Opa! Estamos quase lá! :)</h2>
                        <h3 class="center-block text-info">Para finalizar, deixe uma mensagem ao compartilhador do item que tanto lhe interessa!</h3>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group escrver-msgForm">
                            <label for="esccreva-textoMsg">Digite sua mensagem</label>
                            <input type="hidden" name="usuario_id_envio" value="<?= $_SESSION["usuario_id"] ?>">
                            <input type="hidden" name="usuario_id_recebe" value="<?= $produto->usuario_id ?>">
                            <textarea name="texto" class="form-control" id="esccreva-textoMsg"
                                      placeholder="Mensagem..."></textarea>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<!--mensagem recebida-->
<?php foreach ($mensagens as $mensagem) : ?>
    <div class="modal fade" id="message<?= $mensagem->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Mensagens</h4>
                </div>
                <div class="modal-body">
                    <div class="mensagens-anteriores">
                        <a class="btn btn-link center-block" href="#" role="button">
                            <small><i class="fa fa-long-arrow-up" aria-hidden="true"></i> Mensagens anteriores</small>
                        </a>
                    </div>
                    <div class="cont-message mensagem-enviada">
                        <p class="mensagem-texto"><?= $mensagem->texto ?></p>
              <span class="owner-image-cont enviado">
                <img src="src/Assets/images/user.jpg" alt="Nome do dono" class="owner-img img-circle">
              </span>
                    </div>
                    <div class="cont-message mensagem-recebida">
              <span class="owner-image-cont recebido">
                <img src="src/Assets/images/owner02.jpg" alt="Nome do dono" class="owner-img img-circle">
              </span>
                        <p class="mensagem-texto">Demorou!</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group escrver-msgForm">
                        <label for="esccreva-textoMsg">Digite sua mensagem</label>
                        <input type="text" class="form-control" id="esccreva-textoMsg" placeholder="Mensagem...">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
<script src="src/Assets/js/bootstrap.js"></script>
<script src="src/Assets/js/owl.carousel.min.js"></script>
<script src="src/Assets/js/scripts.js"></script>
</body>
</html>