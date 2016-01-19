<?php
include_once '../../../cons.php';

ini_set('session.name', 'MUSIC_API');

defined('YII_DEBUG') or define('YII_DEBUG',false);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

$config=_APP_PATH_.'/protected/config/api.php';
require_once($yii);
Yii::createWebApplication($config)->run();
