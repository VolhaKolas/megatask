<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 30.06.17
 * Time: 15:19
 */

namespace Core;


use PDO;
use PDOException;

class Database
{
    private $config;

    private function connect()
    {
        if(!$this->config) {
            $this->config = require_once "config.php";
        }
        try {
            return new PDO('mysql:host=' . $this->config['host'] . '; dbname=' . $this->config['name'],
                $this->config['user'], $this->config['pwd']);
        }
        catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }

    private static function db() {
        static $database = null;
        if(is_null($database)) {
            $database = new Database();
        }
        return $database->connect();
    }

    public static function select($sql) {
        if(self::db()->query($sql) != false) {
            return self::db()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

    }

    public static function insert($table, array $values) {
        $keys = array_keys($values);
        $columns = implode(", ", $keys);
        $val = ":" . implode(", :", $keys);
        $sql = "INSERT INTO $table ($columns) VALUES ($val)";
        $result = self::db()->prepare($sql);
        $result->execute($values);
    }

    public static function update($table, array $values, array $where) {
        $keys = array_keys($values);
        foreach ($keys as $key) {
            $newKeys[] = $key . "=:" . $key;
        }
        $columns = implode(", ", $newKeys);

        //only one 'where' condition, that is why I wrote this without foreach
        $whereKey = array_keys($where);
        $conditionKey = implode("", $whereKey);
        $conditionVal = ":" . implode("", $whereKey);

        $sql = "UPDATE $table SET $columns WHERE $conditionKey = ($conditionVal)";
        $result = self::db()->prepare($sql);
        $values = array_merge($values, $where);
        $result->execute($values);
    }

    public static function delete($table,array $where) {
        $whereKey = array_keys($where);
        $conditionKey = implode("", $whereKey);
        $conditionVal = ":" . implode("", $whereKey);

        $sql = "DELETE FROM $table WHERE $conditionKey = ($conditionVal)";
        $result = self::db()->prepare($sql);
        $result->execute($where);
    }
}