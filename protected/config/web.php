<?php

return CMap::mergeArray(require(dirname(__FILE__) . "/main.php"),CMap::mergeArray( array(
			"id"				=> "Amusic",
			"name"				=> "Amusic",
			"controllerPath"	=> _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "web",
			"viewPath"			=> _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "web",
			//'runtimePath'		=> _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "runtime",
//			'theme' 			=> 'default',
			'theme' 			=> 'tet2016',
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
						array(
								'class' => 'application.components.common.VUrlRule',
						),
						"sitemap/<t:(song|video|genre|artist|album|playlist|news)><p:\d+>" => array("sitemap/xml", 'urlSuffix'=>'.xml', 'caseSensitive'=>false) ,
						"sitemap.xml" => "sitemap/xml",
						"robots.txt" => "sitemap/robots",
						'/'=>'/index',
						'bai-hat'=>'/song',
						'tin-tuc'=>'/news',
						'nghe-si'=>'/artist',
						'bang-xep-hang'=>'/chart',
						'am-nhac-12-ca-tinh' => 'horoscopes/index',
						'phat-tat-ca/<title:[a-zA-Z0-9-]+>,<id:\d+>'=>'/collection/view',
						'tro-giup/<url_key:[a-zA-Z0-9-]+>' => '/html/index',
						'tim-kiem/' => '/search/index',
						'video-playlist'=>'videoplaylist',
						'sl/<url_key>' => 'sl/index',
						'the-loai/<_c:\w+>/<id:\d+>-<title>'		=> '<_c>/index',
						'tin-tuc/<title:[a-zA-Z0-9-]+>,<id:\d+>' => 'news/view',
						'nghe-si/<title:[a-zA-Z0-9-]+>,<id:\d+>' => 'artist/view',
						'mv/<title:[a-zA-Z0-9-]+>,<id:\d+>' => 'video/view',
						'nhac-doc-quyen' => 'shell',
						'bai-hat-doc-quyen' => 'shell/song',
						'video-doc-quyen' => 'shell/video',
						'album-doc-quyen' => 'shell/album',
						'chu-de-am-nhac'=>'/topContent',
//						'account/package'=>'user/package',
						'playall/<_a:\w+>/<url_key:[a-zA-Z0-9-]+>,<type:\w+>,<page:\d+>'=>'playall/<_a>',
						'bang-xep-hang/<type:[a-zA-Z0-9-]+>,<genre:[a-zA-Z0-9-]+>' => 'chart/index',
						'<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>/tuan-<week:[\d]+>'=>'site/url',
						'<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>'=>'site/url',
						'<action:[a-zA-Z0-9-]+>/<url_key:[a-zA-Z0-9-]+>-<gt:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>'=>'site/url2',
						'<action:[a-zA-Z0-9-]+>/<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>'=>'site/url2',
						'<action:[a-zA-Z0-9-]+>/<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>/<action_sub:[a-zA-Z0-9-]+>'=>'site/url3',
						'<_c:\w+>/<title:[a-zA-Z0-9-]+>-<artist:[a-zA-Z0-9-]+>,<id:\d+>' => '<_c>/view',
						'<_c:\w+>/<_a:\w+>' => '<_c>/<_a>',
						 '<_c:\w+>/<_a:\w+>/<id:\d+>' => '<_c>/<_a>',
						'vip'=>'LandingPage/vip',
						'a1'=>'/user/landing/id/1',
						'a7'=>'/user/landing/id/2',
						'ctkm'=>'promotion/about',

					),
					"showScriptName"=> false,
//					"urlSuffix"=>".html",
				),
				/*'clientScript' => array(
						'class'=>'ext.minScript.components.ExtMinScript',
						//'minScriptRuntimePath'=>'protected/runtime/minScript',
						//'minScriptController'=>'min',
						//'minScriptDebug'=>false,
						//'minScriptBaseUrl'=>'',
						//'scriptMap'=>array(),
						
						'minScriptUrlMap'=>array(
							'/loadJs.html/'=>false,
						),
				),	*/
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
                'constLimit'=>array(
        			"profile.number.of.playlists"=>4,
		            	"profile.number.of.activities"=>10,
		                "profile.number.of.transactions"=>10,
		            	"inbox.number.of.events"=>10,
		            	"profile.max.friend.result"=>100,
		            	"profile.number.of.fans"=>8,
		            	"profile.number.of.idos"=>8,
		            	"transaction.number.of.activities"=>10,
                		"numberSongsPerPage" => 30,
                		"numberAlbumsPerPage" => 8,
						"numberVideosPerPage" => 8,
						"numberVideosPlaylistPerPage" => 16,
						"numberArtistsPerPage" => 10,
						"numberNewsPerPage"=>6,
						"numberSongsInArtistPage" => 10,
						"numberVideosInArtistPage" => 24,
						"numberAlbumsInArtistPage" => 24,
						"numberNewsInArtistPage" => 40,
                		"search.number.of.items" => 10,
                		"search.number.of.songs" => 20,
                		"search.number.of.videos" => 20,
                		"search.number.of.artists" => 20,
                		"search.number.of.albums" => 20,
                		"search.number.of.playlists" => 20,
                		"search.number.of.ringtones" => 20,
                		"search.number.of.rbts" => 20,
						"search.number.of.videoplaylists" => 20,
                		"web.number.of.videos"	=> 12,
                		"offsetPaging"		=> 10,
                		"limitPaging"		=> 10,
                		"pager.max.button.count" => 5,
                		"items_list_topcontent" => 12,
        		),
            	// Login config
            	'login'=>array(
            			'limit_block'=>5, // So lan login fail bi block
            			'time_block'=> 10, // Thoi gian block (phut)
            	),
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
		))
);
?>
