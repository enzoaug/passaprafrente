<?php

/**
 * Created by PhpStorm.
 * User: enzo
 * Date: 14/04/16
 * Time: 15:06
 */

namespace Core\Database;

use PDO;
use Exception;

class Database
{
    private $config;
    private $pdo;

    public function __construct(Array $config)
    {
        $this->config = $config;
        $this->conectionValidate();
    }

    public function conect()
    {
        try {
            $this->pdo = new PDO(
                'mysql: host=' . $this->config["server"] . '; dbname=' . $this->config["database"],
                $this->config['user'],
                $this->config['password'],
                $this->config['options']
            );
        } catch (\PDOException $e) {
            throw new Exception("Erro na conexão. Código: " . $e->getCode() . "Mensagem: " . $e->getMessage());
        }

        return $this->pdo;
    }

    private function conectionValidate()
    {
        if (is_array($this->config)) {
            if (empty($this->config["server"]))
                throw new Exception("Servidor não informado");
            if (empty($this->config["database"]))
                throw new Exception("Banco de Dados não informado");
            if (empty($this->config["user"]))
                throw new Exception("Usuário não informado");
            if (empty($this->config["password"]))
                throw new Exception("Senha não informada");
            if (empty($this->config["options"]) && !is_array($this->config["options"]))
                throw new Exception("Opções não informadas ou Opções não é um array");

            return true;
        }
        throw new Exception("Esta não é uma configuração válida");
    }

    public function actualize()
    {
        $select = $this->pdo->prepare("select * from usuarios where nome like :nome;");
        $select->bindValue(":nome", $_GET["nome"]);
        $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

}