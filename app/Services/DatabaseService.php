<?php

namespace SabaIdea\Services;

use PDO;

class DatabaseService
{
    private $db;
    private $stmt;
    private $host;
    private $DBName;
    private $username;
    private $password;

    public function __construct()
    {
        $this->host = getenv('MYSQL_ROOT_HOST');
        $this->DBName = getenv('MYSQL_ROOT_BD_NAME');
        $this->username = getenv('MYSQL_ROOT_USERNAME');
        $this->password = getenv('MYSQL_ROOT_PASSWORD');
        $dsn = "mysql:dbname={$this->DBName};host={$this->host}";
        $this->db = new PDO(
            $dsn,
            $this->username,
            $this->password
        );
    }

    public function beginTransaction()
    {
        $this->db->beginTransaction();
        return $this;
    }

    public function prepare($sql)
    {
        $this->stmt = $this->db->prepare($sql);
        return $this;
    }

    public function bindParams(array $params)
    {
        foreach ($params as $key => $param) {
            $this->stmt->bindParam($key, $param);
        }
        return $this;
    }

    public function execute()
    {
        $this->stmt->execute();
        return $this;
    }

    public function fetch()
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function rollback()
    {
        $this->db->rollback();
        return $this;
    }

    public function commit()
    {
        $this->db->commit();
        return $this;
    }
}
