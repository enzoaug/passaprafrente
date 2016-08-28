<?php

/**
 * Created by PhpStorm.
 * User: enzo
 * Date: 14/04/16
 * Time: 15:06
 */

namespace Core\Database;

use Application\Config\Database as AppDatabase;
use PDO;
use Exception;

/**
 * Class Database
 * @package Core\Database
 */
class Database
{
    private $pdo;

    /**
     * Database constructor.
     * @throws Exception
     * @internal param AppDatabase|array $config
     */
    public function __construct()
    {
        $this->connectionValidate();
    }

    public function connect()
    {
        try {
            $this->pdo = new PDO(
                'mysql: host=' . AppDatabase::$DB["server"] . '; dbname=' . AppDatabase::$DB["database"],
                AppDatabase::$DB["user"],
                AppDatabase::$DB["password"],
                AppDatabase::$DB["options"]
            );
        } catch (\PDOException $e) {
            throw new Exception("Erro na conexão. Código: " . $e->getCode() . "Mensagem: " . $e->getMessage());
        }

        return $this->pdo;
    }

    private function connectionValidate()
    {
        if ($this->connect()) {
            if (empty(AppDatabase::$DB["server"]))
                throw new Exception("Servidor não informado");
            if (empty(AppDatabase::$DB["database"]))
                throw new Exception("Banco de Dados não informado");
            if (empty(AppDatabase::$DB["user"]))
                throw new Exception("Usuário não informado");
            if (empty(AppDatabase::$DB["password"]))
                throw new Exception("Senha não informada");
            if (empty(AppDatabase::$DB["options"]) && !is_array(AppDatabase::$DB["options"]))
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