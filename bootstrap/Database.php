<?php
// Hapus baris use jika tidak perlu namespace
// use PDO;
// use PDOException;

class Database {
    private $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=weather_app;charset=utf8';
        $username = 'root'; // Sesuaikan dengan kredensial database Anda
        $password = 'root';

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    public function query($sql)
    {
        return $this->pdo->query($sql);
    }
}

