<?php
/**
 * Created by PhpStorm.
 * User: Сергій
 * Date: 02.10.2017
 * Time: 14:44
 *
 */

namespace app\http;

use app\models\Post;

class PostController extends Controller
{
    // экшен, который будем запускать
    public function all(){
//выстаскиваем данным с талицы

        $posts = Post::find();

//рендерит view файл, передавая туда массив [‘posts’ => $posts]
        return $this->render('post/all', compact('posts'));
    }
}