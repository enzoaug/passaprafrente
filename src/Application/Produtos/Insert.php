<?php
/**
 * Created by PhpStorm.
 * User: enzo
 * Date: 03/09/16
 * Time: 22:47
 */

use Core\Database\Database;
use Core\Database\Instructions\Insert;

include "../../../vendor/autoload.php";

$conn = new Database();
$pdo = $conn->connect();

$titulo = filter_input(INPUT_POST, "titulo");
$descricao = filter_input(INPUT_POST, "descricao");
$imagem = $_FILES["imagem"];
$estado = filter_input(INPUT_POST, "estado");
$usuario_id = filter_input(INPUT_POST, "usuario_id");
$data_publicacao = filter_input(INPUT_POST, "data_publicacao");

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

$insert = new Insert();
$insert->setEntity("produtos");
$insert->setValues([
    "titulo" => ":titulo",
    "descricao" => ":descricao",
    "imagem" => ":imagem",
    "estado" => ":estado",
    "usuario_id" => ":usuario_id",
    "data_publicacao" => ":data_publicacao"
]);

$query = $insert->returnSql();

$imagem = $imagem["name"];

$stmt = $pdo->prepare($query);
$stmt->bindParam(":titulo", $titulo);
$stmt->bindParam(":descricao", $descricao);
$stmt->bindParam(":imagem", $nomeImagem);
$stmt->bindParam(":estado", $estado);
$stmt->bindParam(":usuario_id", $usuario_id);
$stmt->bindParam(":data_publicacao", $data_publicacao);
$stmt->execute();

echo "<pre>";
var_dump($stmt->errorInfo());