<?php

declare(strict_types=1);

class Database
{
    private PDO $pdo;

    public function __construct(array $dbConfig)
    {
        try {
            $this->pdo = $this->connectWithDatabase($dbConfig);
        } catch (PDOException $exception) {
            if ($this->isUnknownDatabaseError($exception)) {
                $this->createDatabaseIfMissing($dbConfig);
                $this->pdo = $this->connectWithDatabase($dbConfig);
                return;
            }

            throw $exception;
        }
    }

    public function pdo(): PDO
    {
        return $this->pdo;
    }

    private function connectWithDatabase(array $dbConfig): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $dbConfig['host'],
            $dbConfig['port'],
            $dbConfig['database'],
            $dbConfig['charset']
        );

        return new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $this->options());
    }

    private function connectToServer(array $dbConfig): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;charset=%s',
            $dbConfig['host'],
            $dbConfig['port'],
            $dbConfig['charset']
        );

        return new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $this->options());
    }

    private function createDatabaseIfMissing(array $dbConfig): void
    {
        $serverConnection = $this->connectToServer($dbConfig);
        $databaseName = str_replace('`', '``', $dbConfig['database']);
        $serverConnection->exec(sprintf(
            'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET %s COLLATE %s_unicode_ci',
            $databaseName,
            $dbConfig['charset'],
            $dbConfig['charset']
        ));
    }

    private function isUnknownDatabaseError(PDOException $exception): bool
    {
        return $exception->getCode() === '1049'
            || str_contains($exception->getMessage(), 'Unknown database');
    }

    private function options(): array
    {
        return [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
    }
}
