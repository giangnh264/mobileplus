<?php

return CMap::mergeArray(require(dirname(__FILE__) . "/main.php"), array(
			"id"				=> "MobilePlus",
			"name"				=> "MobilePlus",
			"controllerPath"	=> _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "web",
			"viewPath"			=> _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "web",
			//'runtimePath'		=> _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "runtime",
			'theme' 			=> 'default',
			'defaultController' => 'index',

            "components" => array(
				'session' => array(
					'timeout' => 30*24*3600,
					'cookieParams' => array(
					   'lifetime' => 30*24*3600, // 30 ngày
					),
				 ),
				'user' => array(
					'authTimeout' => 30*24*3600, // 30 ngày
				),
				"errorHandler"=>array(
					"errorAction"=>"index/error",
				),
				"urlManager" => array(
					"urlFormat" => "path",
					"rules" => array(

						"sitemap/<t:(song|video|genre|artist|album|playlist|news)><p:\d+>" => array("sitemap/xml", 'urlSuffix'=>'.xml', 'caseSensitive'=>false) ,
						"sitemap.xml" => "sitemap/xml",
						"robots.txt" => "sitemap/robots",
						'/'=>'/index',
						'san-pham'=>'/product',
						'gioi-thieu'=>'/about',
						'lien-he'=>'/contact',
						'san-pham/<url_key:[a-zA-Z0-9-]+>,<id:\d+>' => 'product/view',
					),
					"showScriptName"=> false,
				),
				/*'clientScript' => array(
						'class'=>'ext.minScript.components.ExtMinScript',
				),*/
            ),
			'controllerMap'=>array(
				'min'=>array(
						'class'=>'ext.minScript.controllers.ExtMinScriptController',
						//'minScriptComponent'=>'clientScript',
				),
			),
			
            //Module
            "modules" => array(),
			
            // autoloading model and component classes
            "import" => array(
                "application.models.web.*",
                "application.components.web.*",
            	"application.vendors.utilities.*",   
                'application.widgets.web.common.CPagination'
            ),
            "params" => array(
            	'defaultLanguage' => 'vi_vn',
                'ringtunesHost' => '',
            	// cache limit time
				"cache_limit"	=> 1800, //30 minutes
                // limit items on page
            	"connector.providers"=>array("google","facebook"),
				"phpconf"=>array(
						"php.date.format"=>"d/m/Y",
						"javascript.date.format"=>"dd/mm/yy",
						'day.of.week'=>array(
								'1'=>Yii::t('web','Monday'),
								'2'=>Yii::t('web','Tuesday'),
								'3'=>Yii::t('web','Wednesday'),
								'4'=>Yii::t('web','Thursday'),
								'5'=>Yii::t('web','Friday'),
								'6'=>Yii::t('web','Saturday'),
								'7'=>Yii::t('web','Sunday'),
						)
            	),
				'limit_chart_home_number'=>5,
			),
		)
);
?>
