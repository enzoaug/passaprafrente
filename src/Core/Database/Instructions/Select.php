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

final class Select extends Instruction
{
    private $fields;

    public function setFields(Array $fields)
    {
        $this->fields = implode(", ", $fields);
        return $this;
    }

    public function setValues(Array $values)
    {
        throw new Exception("O método setValues não é usado em SELECT");
    }

    public function returnSql()
    {
        $this->fields = (empty($this->fields)) ? "*" : $this->fields;

        if (empty($this->entity))
            throw new Exception("Entidade não declarada");

        $sql = "SELECT " . $this->fields . " FROM " . $this->entity;
        if (!empty($this->filters))
            $sql .= $this->filters->returnSql();

        return $sql;
    }
}