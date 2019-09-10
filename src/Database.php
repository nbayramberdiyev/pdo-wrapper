<?php

declare(strict_types=1);

namespace NB;

use PDO;
use PDOStatement;

class Database extends PDO
{
    /**
     * Create a new Database instance.
     *
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @param array $options
     * @return void
     */
    public function __construct(string $dsn, string $username, string $password, array $options = [])
    {
        $default_options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

        $options = array_replace($default_options, $options);

        parent::__construct($dsn, $username, $password, $options);
    }

    /**
     * Shorthand for prepare() and execute() methods.
     *
     * @param string $sql
     * @param array $args
     * @return PDOStatement
     */
    public function run(string $sql, array $args = []): PDOStatement
    {
        if (!$args) {
            return $this->query($sql);
        }
        $stmt = $this->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}