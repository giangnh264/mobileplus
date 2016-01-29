<?php
//session_start();
include_once 'cons.php';
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');

defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

$config=_APP_PATH_.'/protected/config/web_dev.php';

require_once($yii);
Yii::createWebApplication($config)->run();
