<?php
return CMap::mergeArray(
        require(dirname(__FILE__) . '/main.php'), CMap::mergeArray(require(dirname(__FILE__) . '/sms_wap.php'), 
        array(
        'id'  => 'api',
        'name'=>'Api',
        'controllerPath'=>_APP_PATH_.DS."protected".DS."controllers".DS."api",
        'viewPath'=>_APP_PATH_.DS."protected".DS."views".DS."api",
        'defaultController'=>'default',

        'components'=>array(
                "urlManager" => array(
                    "urlFormat" => "path",
                    "rules" => array(
                        //Rewrite for Client API
                        "client/<_c:\w+>/<id:\d+>" => "client/<_c>/detail",
                        "client/<_c:\w+>/<id:\d+>/<act:\w+>" => "client/<_c>/detail",
                        "client/<_c:\w+>/<id:\d+>/<act:\w+>/<num:\d+>" => "client/<_c>/detail",
                        "client/<_c:(songs|videos|albums|artists|playlist)>/<type:\w+>" => "client/<_c>/index",
                        "client/<_c:\w+>/<_a:\w+>" => "client/<_c>/<_a>",
                        "client/<_c:\w+>/<_a:\w+>/<id:\d+>" => "client/<_c>/<_a>",
                        "client/<_c:\w+>/<_a:\w+>/<id:\d+>/*" => "client/<_c>/<_a>",
                    ),

                    "showScriptName" => false,                  
                ),
            'request' => array(
                'class' => 'application.components.common.HttpRequest',
                'enableCsrfValidation' => false,
            ),
            'errorHandler' => array(
            	'errorAction' => '/default/error',
            ),
        		        		
            ),
            //Module
            'modules' => array(),
            // autoloading model and component classes
            'import' => array(
                'application.models.api.*',
                'application.components.api.*',
                'application.vendors.fundial_vascmd.*',
            ),
            'params' => array(
            	'cacheTime' => 600,
                'defaultLanguage' => 'vi_vn',
                'cp_limit_content' => 49999,
                'secrect_key' => 'pOwErOvErwhElmIng',
            	'images_gif_notavailble'=>array('4.1.2'),
            ),
    )
        		)
);
?>