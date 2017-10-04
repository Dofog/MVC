<?php
/**
 * Created by PhpStorm.
 * User: Сергій
 * Date: 02.10.2017
 * Time: 16:13
 */

namespace app\models;
/**
 * Interface ModelInterface
 * @package app\models
 */
interface ModelInterface
{
    //каждая модель может назодить записи из своей таблицы
    public static function find($condition);
    //у кадой модели есть своя таблица в БД
    public static function tableName();
}