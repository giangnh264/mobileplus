<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
    require(dirname(__FILE__) . '/local.php'),
    array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'runtimePath' => dirname(_APP_PATH_) . DIRECTORY_SEPARATOR .'mobileplus'. DIRECTORY_SEPARATOR . "runtime",
        'sourceLanguage' => 'code',
        'language' => 'vi_vn',
        // preloading 'log' component
        'preload' => array('log'),
        // autoloading model and component classes
        'import' => array(
            'application.models.db._base.*',
            'application.models.db.*',
            'application.components.common.*',
            'application.vendors.utilities.*',
        ),
        // application components
        'components' => array(
            'user' => array(
                // enable cookie-based authentication
                'allowAutoLogin' => true,
                'class' => 'WebUser',
            ),
            "SEO"=>array(
                'class'=>'application.components.common.SEO'
            ),
            // enable URLs in path-format
            'urlManager' => array(
            ),
        ),
        // module config
        'modules' => array(
        ),
        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
        'params' => array(

            'cacheTime' => 600,
            // this is used to support multi lanuages
            'languages' => array('en_us' => 'English', 'vi_vn' => 'Tiếng Việt'),
            'defaultLanguage' => 'vi_vn',
        ),
    )
);
