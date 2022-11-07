<?php

namespace iutnc\deefy\db;

class ConnectionFactory {

    private static ?\PDO $db = null;
    private static ?array $config = null;

    public static function setConfig(string $file) : void {
        self::$config = parse_ini_file($file);
    }

    public static function makeConnection() : \PDO{
        if (self::$db == null) {
            $driver = self::$config['driver'] ?? "default";
            $user = self::$config['username'] ?? "default";
            $pass = self::$config['password'] ?? "default";
            $host = self::$config['host'] ?? "default";
            $database = self::$config['database'] ?? "default";

            if ($driver != "default" && $host != "default" && $database != "default"){
                $dsn = "$driver:host=$host; dbname=$database";
                if ($user != "default" && $pass != "default"){
                    try {
                        self::$db = new \PDO($dsn, $user, $pass);
                    } catch (\Exception $e){
                        print $e;
                    }
                }
            }
        }
        return self::$db;
    }
}