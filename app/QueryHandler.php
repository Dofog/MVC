<?php
/**
 * Created by PhpStorm.
 * User: Сергій
 * Date: 02.10.2017
 * Time: 14:36
 */

namespace app;
use app\http\Controller;
/**
 * Class QueryHandler
 * @package app
 */
class QueryHandler
{
    //Singleton - экземпляр текущего класса
    private static $handler;
    //namespace контроллеров, чтобы знать откуда их вызывать
    private $controllerNamespace = 'app\http';

    /**
     * @return QueryHandler
     */
    public static function getInstance(): QueryHandler
    {
        if (static::$handler === null) {
            static::$handler = new static();
        }
        return static::$handler;
    }

    //сюда прописываем по какой URL мы должны вызывать какой контроллер и экшен в нем
    public function routes()
    {
        return [
            // при http://mvc.loc/post/all вызвать app/http/PostController->all()
            'post/all' => 'PostController@all'
        ];
    }

    /**
     * Функция, которая обрабатывает запрос и вытаскивает нужные мена контроллера и экшена
     *
     * @param string $requestURI - тут получаем строку в виде '/post/all'
     * @return Controller
     * @throws \Exception
     */
    public function handle($requestURI): Controller
    {
        //разделяем полученную строку по слешам
        $URIComponents = explode('/', $requestURI);
        //имя контроллера будет лежать в первой ячейке
        $controllerID = $URIComponents[1];
        //проверяем не пусто ли там
        if (!empty($controllerID) && is_string($controllerID)) {
            //если экшен не пустой - устанавливаем полученное значение, если пусной - устанавливаем значение по-умолчанию - 'index'
            $actionID = !empty($URIComponents[2]) && is_string($URIComponents[2]) ? $URIComponents[2] : 'index';
            //получаем знаечение роутов, которые прописывали вручную в функции routes()
            $routes = $this->routes();
            //если запрошенный роут существует - продолжем, если нет - возвращаем ошибку
            if (array_key_exists("$controllerID/$actionID", $routes)) {
                //получаем имя контроллера и экшена(метода контроллера) и ложим названия в переменную, для удобства
                $route = $routes["$controllerID/$actionID"];
                //разделяем их по знаку @
                $routeParams = explode('@', $route);
                //название класса контроллера лежит в нулевой ячейке
                $controllerClassName = $routeParams[0];
                //название экшена (метода контроллера) лежит в нулевой ячейке
                $actionName = $routeParams[1];
                //получаем полный путь к классу контроллера, используя его namespace
                $controllerNamespace = $this->controllerNamespace . '\\' . $controllerClassName;
                //проверяем существует ли класс контроллера
                if (class_exists($controllerNamespace)) {
                    //если класс контроллера сущетсвует - создаем его экземпляр
                    $controllerClass = new $controllerNamespace($actionName);
                    //проверяем сущетвует ли в нем метод, одноименный з название экшена
                    if (method_exists($controllerClass, $actionName)) {
                        //если существует - возвращаем экземпляр контроллера
                        return $controllerClass;
                    }
                }
            }
        }
        //если на жтом этапе что-то где-то пошло не так - пользователь ввел неправильную URL
        throw new \Exception('Requested URL was not found', 404);
    }
}