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

$texto = filter_input(INPUT_POST, "texto");
$usuarioIdEnvio = filter_input(INPUT_POST, "usuario_id_envio");
$usuarioIdRecebe = filter_input(INPUT_POST, "usuario_id_recebe");

$insert = new Insert();

$insert->setEntity("mensagens");
$insert->setValues([
    "texto" => $texto,
    "usuario_id_envio" => $usuarioIdEnvio,
    "usuario_id_recebe" => $usuarioIdRecebe
]);

$query = $insert->returnSql();

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":texto", $texto);
    $stmt->bindParam(":usuario_id_envio", $usuarioIdEnvio);
    $stmt->bindParam(":usuario_id_recebe", $usuarioIdRecebe);
} catch (\PDOException $e) {
    echo "Não foi possível fazer a solicitação. Entre em contato com os administradores.";
} finally {
    if ($stmt->execute()) {
        header("Location: ../../index.php?euquero=ok");
    } else {
        header("Location: ../../index.php?euquero=nop");
    }
}

