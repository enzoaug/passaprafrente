<?php
/**
 * Created by PhpStorm.
 * User: enzo
 * Date: 28/08/16
 * Time: 16:25
 */

namespace Application\Mensagens;

use Core\Database\Database;
use Core\Database\Instructions\Select;

class All extends Database
{
    public function getAll()
    {
        $select = new Select();
        $select->setEntity("mensagens m");
        $select->setFields([
            "m.id",
            "m.texto",
            "m.usuario_id_envio",
            "m.usuario_id_recebe",
            "u1.nome AS nome_usuario_recebe",
            "u1.sobrenome AS sobrenome_usuario_recebe",
            "u2.nome AS nome_usuario_envio",
            "u2.sobrenome AS sobrenome_usuario_envio"
        ]);

        $query = $select->returnSql();
        $query .= " INNER JOIN usuarios u1 ON u1.id = m.usuario_id_envio";
        $query .= " INNER JOIN usuarios u2 ON u2.id = m.usuario_id_recebe";
        $query .= " WHERE m.usuario_id_recebe = '{$_SESSION["usuario_id"]}'";
        $query .= " ORDER BY m.id DESC";
        $query .= " LIMIT 1";

        return $query;
    }

    public function ifVoce($user)
    {
        if ($user == $_SESSION["usuario_id"]) {
            return "Você";
        } else {
            return $user;
        }

        return false;
    }
}