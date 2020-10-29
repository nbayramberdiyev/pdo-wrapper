<?php

declare(strict_types=1);

namespace NB;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    public PDO $pdo;

    /**
     * Create a new Database instance.
     *
     * @param string $database
     * @param string $username
     * @param string $password
     * @param string $host
     * @param int    $port
     * @param array  $options
     */
    public function __construct(
        string $database,
        string $username,
        string $password,
        string $host = '127.0.0.1',
        int $port = 3306,
        array $options = []
    ) {
        $defaultOptions = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        ];

        $options = array_replace($defaultOptions, $options);

        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $host, $port, $database);

        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Shorthand for `prepare` and `execute` methods.
     *
     * @param string $sql
     * @param array $args
     * @return PDOStatement
     */
    public function run(string $sql, array $args = []): PDOStatement
    {
        if (!$args) {
            return $this->pdo->query($sql);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);

        return $stmt;
    }
}
