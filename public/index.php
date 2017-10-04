<?php
require_once '../vendor/autoload.php';
/**
 * Created by PhpStorm.
 * User: Сергій
 * Date: 02.10.2017
 * Time: 13:16
 */

$config = require('../config/database.php');
$application = new \app\Application($config);
$application->run();



