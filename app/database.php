<?php
// malvishop/app/Database.php

class Database {
    public $connection;

    public function __construct($config, $username = 'root', $password = '') {
        $dsn = 'mysql:' . http_build_query($config, '', ';');

        try {
            $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die("No se pudo conectar a la base de datos: " . $e->getMessage());
        }
    }

    //  FUNCIÓN QUERY MEJORADAA UWU 
    public function query($query, $params = []) {
        $statement = $this->connection->prepare($query);

        // Recorremos los parámetros para asignarlos con el tipo de dato correcto
        foreach ($params as $key => $value) {
            $type = PDO::PARAM_STR; // Por defecto, tratamos todo como texto
            if (is_int($value)) {
                $type = PDO::PARAM_INT; // Si es un entero, lo tratamos como número
            } elseif (is_bool($value)) {
                $type = PDO::PARAM_BOOL; // Si es booleano
            } elseif (is_null($value)) {
                $type = PDO::PARAM_NULL; // Si es nulo
            }
            $statement->bindValue($key, $value, $type);
        }

        $statement->execute();
        return $statement;
    }
}