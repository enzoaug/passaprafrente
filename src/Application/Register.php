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
use PDO;

define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
define("DS", DIRECTORY_SEPARATOR);

include ROOT . DS . "passaprafrente" . DS . "vendor" . DS . "autoload.php";

$conn = new Database();
$pdo = $conn->connect();

$nome = filter_input(INPUT_POST, "nome");
$sobrenome = filter_input(INPUT_POST, "sobrenome");
$email = filter_input(INPUT_POST, "email");
$senha = filter_input(INPUT_POST, "senha");

$insert = new Insert();

$insert->setEntity("usuarios");
$insert->setValues([
    "nome" => $nome,
    "sobrenome" => $sobrenome,
    "email" => $email,
    "senha" => $senha
]);

$query = $insert->returnSql();

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":sobrenome", $sobrenome);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":senha", $senha);
} catch (\PDOException $e) {
    echo "Não foi possível te registrar. Entre em contato com os administradores.";
} finally {
    if ($stmt->execute()) {
        header("Location: ../../login.php?registro=ok");
    } else {
        header("Location: ../../login.php?registro=nop");
    }
}

