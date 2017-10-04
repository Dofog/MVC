<?php
/**
 * Created by PhpStorm.
 * User: Сергій
 * Date: 02.10.2017
 * Time: 14:33
 */


namespace app\http;
use app\components\View;
abstract class Controller
{
    //тут будет записано имя экшена, который мы используем
    public $action;
    //при создании класса передаем в него название экшена, который нужно запустить
    public function __construct(string $action)
    {
        $this->action = $action;
    }
    /**
     * @return mixed
     * @throws \Exception
     */
    public function runAction(){
        
        //проверяем, существует метод, одноименный с именем экшена
        if(method_exists($this, $this->action)){
            
            return $this->{$this->action}();

        }
        //если метода не сущетвует - выводим ошибку о неправильном запрошеном УРЛ
        throw new \Exception('Requested URL was not found', 404);
    }
    /**
     * @param $viewID
     * @param array $variables
     * @return string
     * @throws \Exception
     */
    public function render($viewID, array $variables){

        $viewPath = $_SERVER['DOCUMENT_ROOT']."/resources/views/$viewID.php";
       
        //проверяем существует ли такой файл
        if(file_exists($viewPath)){

            $view = new View($viewPath);
            $view->setVariables($variables);
            return $view->render();
        }
        //если файл не существует - бросаем ошибку об этом
        throw new \Exception('View was not found');
    }
}
