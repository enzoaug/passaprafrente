<?php
/**
 * Created by PhpStorm.
 * User: enzo
 * Date: 04/09/16
 * Time: 21:54
 */

namespace Application;

use Core\Database\Database;
use Core\Database\Instructions\Insert;
use Core\Database\Instructions\Select;
use Core\Database\Instructions\Update;
use PDO;

session_start();

define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
define("DS", DIRECTORY_SEPARATOR);

include ROOT . DS . "passaprafrente" . DS . "vendor" . DS . "autoload.php";

$conn = new Database();
$pdo = $conn->connect();

$imagem = $_FILES["foto"];
$apelido = filter_input(INPUT_POST, "apelido");
$descricao = filter_input(INPUT_POST, "descricao");
$userId = $_SESSION["usuario_id"];

if (!empty($imagem["name"])) {

    // Largura máxima em pixels
    $largura = 2000;
    // Altura máxima em pixels
    $altura = 2500;
    // Tamanho máximo do arquivo em bytes
    $tamanho = 5000000;

    $error = [];

    // Verifica se o arquivo é uma imagem
    if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
        $error[1] = "Isso não é uma imagem.";
    }

    // Pega as dimensões da imagem
    $dimensoes = getimagesize($imagem["tmp_name"]);

    // Verifica se a largura da imagem é maior que a largura permitida
    if($dimensoes[0] > $largura) {
        $error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
    }

    // Verifica se a altura da imagem é maior que a altura permitida
    if($dimensoes[1] > $altura) {
        $error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
    }

    // Verifica se o tamanho da imagem é maior que o tamanho permitido
    if($imagem["size"] > $tamanho) {
        $error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
    }

    // Se não houver nenhum erro
    if (count($error) == 0) {

        // Pega extensão da imagem
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);

        // Gera um nome único para a imagem
        $nomeImagem = md5(uniqid(time())) . "." . $ext[1];

        // Caminho de onde ficará a imagem
        $caminhoImagem = "../../Assets/images/" . $nomeImagem;

        // Faz o upload da imagem para seu respectivo caminho
        move_uploaded_file($imagem["tmp_name"], $caminhoImagem);
    }

    // Se houver mensagens de erro, exibe-as
    if (count($error) != 0) {
        foreach ($error as $erro) {
            echo $erro . "<br />";
        }
    }
}

$update = new Update();

$update->setEntity("usuarios u");
$update->setValues([
    "foto" => ":foto",
    "apelido" => ":apelido",
    "descricao" => ":descricao"
]);

$query = $update->returnSql();
$query .= " WHERE u.id = '{$userId}'";

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":foto", $nomeImagem);
    $stmt->bindParam(":apelido", $apelido);
    $stmt->bindParam(":descricao", $descricao);
} catch (\PDOException $e) {
    echo "Não foi possível alterar o seu perfil. Entre em contato com os administradores.";
} finally {
    if ($stmt->execute()) {
        header("Location: ../../../index.php?alterarPerfil=ok");
    } else {
        header("Location: ../../../index.php?alterarPerfil=nop");
    }
}

