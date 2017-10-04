<?php
/**
 * Created by PhpStorm.
 * User: Сергій
 * Date: 02.10.2017
 * Time: 15:35
 */
/** @var array $posts */

/** @var \app\models\Post $post */
foreach ($posts as $post){
    echo "$post->id | $post->message | $post->time";
    echo "<hr>" ;
}