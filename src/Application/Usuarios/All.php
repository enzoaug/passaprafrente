<?php
/**
 * Created by PhpStorm.
 * User: enzo
 * Date: 28/08/16
 * Time: 16:25
 */

namespace Application\Usuarios;

use Core\Database\Database;
use Core\Database\Instructions\Select;

class All extends Database
{
    public function getUser($idUser)
    {
        $select = new Select();
        $select->setEntity("usuarios u");
        $select->setFields([
            "u.nome",
            "u.sobrenome",
            "u.apelido",
            "u.foto",
            "u.descricao"
        ]);

        $query = $select->returnSql();
        $query .= " WHERE u.id = '{$idUser}'";

        return $query;
    }
}