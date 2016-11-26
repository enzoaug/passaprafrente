<?php
/**
 * Created by PhpStorm.
 * User: enzo
 * Date: 28/08/16
 * Time: 16:25
 */

namespace Application\Produtos;

use Core\Database\Database;
use Core\Database\Instructions\Select;

class All extends Database
{
    public function getAll($filter = null)
    {
        $select = new Select();
        $select->setEntity("produtos p");
        $select->setFields([
            "p.id",
            "p.titulo",
            "p.descricao",
            "p.imagem",
            "p.estado",
            "p.usuario_id",
            "p.data_publicacao",
            "TIMESTAMPDIFF(MINUTE, (p.data_publicacao), now()) AS postdate",
            "u.nome",
            "u.sobrenome",
            "u.foto"
        ]);

        $query = $select->returnSql();
        $query .= " LEFT JOIN usuarios u ON u.id = p.usuario_id";
        $query .= " WHERE p.usuario_id != '{$_SESSION["usuario_id"]}'";
        if (isset($filter) && !empty($filter))
            $query .= " AND p.titulo LIKE '%{$filter}%' OR p.descricao LIKE '%{$filter}%' OR u.nome LIKE '{$filter}%'";
        $query .= " ORDER BY p.data_publicacao DESC";

        return $query;
    }

    public function getMeusCompartilhamentos()
    {
        $select = new Select();
        $select->setEntity("produtos p");
        $select->setFields([
            "p.id",
            "p.titulo",
            "p.descricao",
            "p.imagem",
            "p.estado",
            "p.usuario_id",
            "p.data_publicacao",
            "TIMESTAMPDIFF(MINUTE, (p.data_publicacao), now()) AS postdate",
            "u.nome",
            "u.sobrenome",
            "u.foto"
        ]);

        $query = $select->returnSql();
        $query .= " LEFT JOIN usuarios u ON u.id = p.usuario_id";
        $query .= " WHERE p.usuario_id = '{$_SESSION["usuario_id"]}'";
        $query .= " ORDER BY p.data_publicacao DESC";
        $query .= " LIMIT 4";

        return $query;
    }

    public function parseMinute($minuto)
    {
        if ($minuto == 0) {
            return "Agora mesmo";
        } elseif ($minuto > 59 && $minuto < 1440) {
            $hora = $minuto / 60;

            return "Há " . ceil($hora) . " hora(s)";
        } elseif ($minuto > 1440) {
            $hora = $minuto / 60;

            if ($hora > 24) {
                $dia = $hora / 24;
            }

            if ($dia > 30) {
                $mes = $dia / 30;
                return "Há " . ceil($mes) . " mês(es)";
            }

            return "Há " . ceil($dia) . " dia(s)";
        } else {
            return "Há " . ceil($minuto) . " minuto(s)";
        }
    }
}