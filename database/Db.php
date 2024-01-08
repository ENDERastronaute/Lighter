<?php
    namespace Database;
    use PDO;
    class Db
    {
        public static function connect() {
            $db_host = $_ENV['DB_HOST'];
            $db_name = $_ENV['DB_NAME'];
            $db_user = $_ENV['DB_USER'];
            $db_password = $_ENV['DB_PASSWORD'];
            $db_port = $_ENV['DB_PORT'];

            $dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name";

            $connection = new PDO(
                $dsn,
                $db_user,
                $db_password
            );

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connection;
        }
    }
?>