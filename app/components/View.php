<?php
/**
 * Created by PhpStorm.
 * User: Сергій
 * Date: 02.10.2017
 * Time: 15:39
 */
namespace app\components;
/**
 * @package app\components
 */
class View
{
    protected $path;
    protected $variables;
    public function __construct(string $path)
    {
        $this->setPath($path);
    }
    public function setVariables(array $variables){
        $this->variables = $variables;
    }
    public function setPath($path)
    {
        if (file_exists($path)) {
            $this->path = $path;
        } else {
            throw new \Exception('View file was not found');
        }
    }

    public function getPath():string
    {
        return $this->path;
        /**
        *
        * @return string
        */
    }
    
    public function render(){
        ob_start();
        extract($this->variables);
        include($this->getPath());
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}