<?php
/**
 * Created by PhpStorm.
 * User: Сергій
 * Date: 02.10.2017
 * Time: 16:18
 */
namespace app\models;
/**
 * Class Post
 * @package app\models
 */

class Post extends Model{
    public $id;
    public $message;
    public $time;


    public static $fields = [
        'id', 'message', 'time'
    ];
    public static function tableName()
    {
        return 'Post';
    }
}