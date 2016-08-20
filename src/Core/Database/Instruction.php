<?php
/**
 * Created by PhpStorm.
 * User: enzo
 * Date: 15/04/16
 * Time: 15:01
 */

namespace Core\Database;

use Exception;

abstract class Instruction
{
    protected $sql;
    protected $filters;
    protected $entity;

    // Maneira I = Agregação
    /*final public function setFilters(Filters $filters)
    {
        $this->filters = $filters->returnSql();
        return $this;
    }*/

    // Maneira II = Composição
    final public function setFilters()
    {
        $this->filters = new Filters();
        return $this->filters;
    }

    final public function setEntity($entity)
    {
        if (is_string($entity)) {
            $this->entity = $entity;
            return $this;
        } else {
            throw new Exception("A entidade deve ser uma string");
        }
    }

    abstract public function setValues(Array $values);

    abstract public function returnSql();

}