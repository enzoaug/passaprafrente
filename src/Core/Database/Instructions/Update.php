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

final class Update extends Instruction
{
    private $values;

    public function setValues(Array $values)
    {
        $keys = array_keys($values);

        $sql = [];
        foreach ($keys as $key) :
            $sql[] = $key . "=:" . $key;
        endforeach;

        $this->values = implode(", ", $sql);
    }

    public function returnSql()
    {
        if (empty($this->entity))
            throw new Exception("Entidade não declarada");

        $sql = "UPDATE $this->entity SET $this->values";
        if (!empty($this->filters))
            $sql .= $this->filters->returnSql();

        return $sql;
    }
}