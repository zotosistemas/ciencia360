<?php
namespace Ciencia360\Config;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                Config::get('DB_HOST', '127.0.0.1'),
                Config::get('DB_PORT', '3306'),
                Config::get('DB_DATABASE', 'ciencia360')
            );
            $user = Config::get('DB_USERNAME', 'root');
            $pass = Config::get('DB_PASSWORD', '');

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                if (Config::get('APP_DEBUG', 'false') === 'true') {
                    exit('Error de conexión: ' . $e->getMessage());
                }
                exit('Error de conexión a BD.');
            }
        }
        return self::$pdo;
    }
}
