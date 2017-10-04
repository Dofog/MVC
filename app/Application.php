<?php
/**
 * Created by PhpStorm.
 * User: Сергій
 * Date: 02.10.2017
 * Time: 13:15
 */
namespace app;

class Application
{
    private $queryHandler;
    public $controller;
    /** @var \PDO $pdo */
    public static $pdo;
    public $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->connectDatabase($this->config['host'],$this->config['username'],$this->config['password'],$this->config['database']);
        $this->queryHandler = QueryHandler::getInstance();
    }
    public function run(){
        echo 'Applic_create';

        $this->controller = $this->queryHandler->handle($_SERVER['REQUEST_URI']);
        echo $this->controller->runAction();

    }

    public function connectDatabase(
        string $host, string $user, string $password, string $database, $options = null){

        try{
//пытаемся подклчиться

            self::$pdo = new \PDO("mysql:host=$host;dbname=$database", $user, $password, $options);


        }catch (\PDOException $exception){
            //если подключение невозможно - выводим ошибку и останавливаем скрипт
            echo "Connection issue: ".$exception->getMessage();
            exit();
        }
    }


}