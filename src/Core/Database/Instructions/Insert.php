<?php
/**
 * Created by PhpStorm.
 * User: enzo
 * Date: 15/04/16
 * Time: 15:14
 */

namespace Core\Database\Instructions;


use Core\Database\Instruction;
USE Exception;

final class Insert extends Instruction
{
    private $values;

    public function setValues(Array $values)
    {
        $keys = array_keys($values);
        $columns = implode(", ", $keys);
        $values = implode(", :", $keys);

        $this->values = "($columns) VALUES (:$values)";

        return $this;
    }

    public function returnSql()
    {
        if (empty($this->entity))
            throw new Exception("Entidade não declarada");

        $sql = "INSERT INTO $this->entity $this->values;";

        return $sql;
    }
}