<?php
/**
 * Created by PhpStorm.
 * User: enzo
 * Date: 15/04/16
 * Time: 15:14
 */

namespace Core\Database\Instructions;


use Core\Database\Instruction;
use Exception;

final class Delete extends Instruction
{
    public function setValues(Array $values)
    {
        throw new Exception("O método setValues não é usado em DELETE");
    }

    public function returnSql()
    {
        if (empty($this->entity))
            throw new Exception("Entidade não declarada");

        $sql = "DELETE FROM " . $this->entity;
        if (!empty($this->filters))
            $sql .= $this->filters->returnSql();

        return $sql;
    }
}