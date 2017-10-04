<?php
/**
 * Created by PhpStorm.
 * User: Сергій
 * Date: 02.10.2017
 * Time: 16:11
 */

namespace app\models;
use app\Application;
/**
 * @package app\models
 */
abstract class Model implements ModelInterface
{
    //массив с полями, которые используются в базе
    public static $fields;
    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        foreach ($config as $property => $value){
            if(in_array($property, static::$fields)){
                $this->{$property} = $value;
                
            }
        }
    }
    /**
     * @param null $condition
     * @return array
     */
    public static function find($condition = null)
    {
        //запрос
        //вместо static будет подсталено имя класса-наследника, с которого вызвана эта функция
        $sql = 'SELECT * FROM `' . static::tableName() . '`';

        //если есть условие - добавляем его к запросу
        if ($condition) {
            $sql .= "WHERE $condition";
        }
        //получаем результат с помощью ПДО
        /** @var \PDO $PDOResult */
        $PDOResult = Application::$pdo->query($sql);
        echo'<br>Экземпляры класса модели созданы<br>';
        //создаем экземпляры класса модели и возвращаем из как результат поиска
        /** @var \PDO $PDOResult */
        return self::createModels($PDOResult->fetchAll(\PDO::FETCH_ASSOC));
    }
    /**
     * @param array $queryResults
     * @return array
     */
    public static function createModels(array $queryResults){
        $models = [];
        foreach ($queryResults as $record){
            $newModel = new static($record);
            $models[] = $newModel;
        }
        return $models;
    }
}