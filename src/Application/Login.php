<?php
/**
 * Created by PhpStorm.
 * User: enzo
 * Date: 04/09/16
 * Time: 21:54
 */

namespace Application;

use Core\Database\Database;
use Core\Database\Instructions\Select;
use PDO;

define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
define("DS", DIRECTORY_SEPARATOR);

include ROOT . DS . "passaprafrente" . DS . "vendor" . DS . "autoload.php";

$conn = new Database();
$pdo = $conn->connect();

$user = filter_input(INPUT_POST, "email");
$pass = filter_input(INPUT_POST, "senha");

$select = new Select();
$select->setEntity("usuarios");
$select->setFields([
    "id",
    "nome",
    "sobrenome",
    "apelido",
    "email",
    "senha"
]);
$select->setFilters()->where("email", "=")->whereOperator("AND")->where("senha", "=");

$query = $select->returnSql();

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $user);
    $stmt->bindParam(":senha", $pass);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    echo "Não foi possível fazer login. Entre em contato com os administradores.";
} finally {
    if ($resultado["email"] == $user && $resultado["senha"] == $pass) {
        header("Location: ../../index.php");
        session_start();
        $_SESSION["usuario"] = $resultado["nome"] . " " . $resultado["sobrenome"];
        $_SESSION["apelido"] = $resultado["apelido"];
        $_SESSION["usuario_id"] = $resultado["id"];
    } else {
        header("Location: ../../login.php?alerta=invalido");
        session_destroy();
    }
}

