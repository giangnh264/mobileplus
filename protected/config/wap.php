<?php
return CMap::mergeArray(
                require(dirname(__FILE__) . '/main.php'), CMap::mergeArray(require(dirname(__FILE__) . '/sms_wap.php'), array(
                    'id' => 'wap',
                    'name' => 'wap',
                    'controllerPath' => _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "wap",
                    'viewPath' => _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "wap".DIRECTORY_SEPARATOR."default",
                    //'defaultController'=>'featured',
                    'theme' => 'default',
                    'components' => array(
                        'urlManager' => array(
                            'urlFormat' => 'path',
                            'rules' => array(
                               array(
                                    'class' => 'application.components.common.VUrlRule',
                                ),
                            	''=>'site/index',
                                'bai-hat'=>'/song',
                                'tin-tuc'=>'/news',
                                'tin-tuc/<url_key:[a-zA-Z0-9-]+>,<id:\d+>' => '/news/detail',
                                'nghe-si'=>'/artist',
                                'bang-xep-hang'=>'/bxh',
                                'am-nhac-12-ca-tinh' => 'horoscopes/index',
                                'video-playlist'=>'/videoplaylist/index',
                                'nhac-doc-quyen' => 'shell',
                                'bai-hat-doc-quyen' => 'shell/song',
                                'video-doc-quyen' => 'shell/video',
                                'album-doc-quyen' => 'shell/album',
                                'tim-kiem/' => '/search/index',
                                'tro-giup/<url_key:[a-zA-Z0-9-]+>' => '/html/index',
                                'bang-xep-hang/<s:[a-zA-Z0-9-]+>,<c:[a-zA-Z0-9-]+>' => 'bxh/index',
                                'tai-ung-dung'=>'site/appDownload',
                                'chu-de-am-nhac'=>'/topContent',
                                /*'a1'=>'sl/index/url_key/a1',
                                'a7'=>'sl/index/url_key/a7',*/
                                'a1'=>'/account/landing/id/1',
                                'a7'=>'/account/landing/id/2',
//                                'sl/<url_key:[a-zA-Z0-9-]+>' => 'sl/index',
                                'sl/<url_key>' => 'sl/index',
                                'ctkm'=>'promotion/about',
                                '<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>'=>'site/url',
                                '<action:[a-zA-Z0-9-]+>/<url_key:[a-zA-Z0-9-]+>-<gt:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>'=>'site/url2',
                                '<action:[a-zA-Z0-9-]+>/<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>'=>'site/url2',
                                '<action:[a-zA-Z0-9-]+>/<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>/<action_sub:[a-zA-Z0-9-]+>'=>'site/url3',

                                '<_c:\w+>s' => '<_c>/list',
                                '<_c:\w+>/<url_key:[a-zA-Z0-9-]+>,<id:\d+>.html' => '<_c>/view',
                                '<_c:\w+>/<url_key:[a-zA-Z0-9-]+>,<id:\d+>' => '<_c>/view',
                                '<_c:\w+>/<title:[a-zA-Z0-9-]+>,<id:\d+>.html' => '<_c>/view',
                                '<_c:\w+>/<_a:\w+>' => '<_c>/<_a>',
                                '<_c:(genre)>/<_a:(collection)>/<url_key:[a-zA-Z0-9-]+>,<id:\d+>.html' => '<_c>/<_a>',
                                
                            ),
                            'showScriptName' => false,
                        ),
                        'user' => array(
                            // enable cookie-based authentication
                            'allowAutoLogin' => true,
                            'loginUrl' => array('account/login'),
                        //'class' => 'MyWebUser',
                        ),
                        'log' => array(
                            'class' => 'CLogRouter',
                            'routes' => array(
                                array(
                                    'class' => 'application.components.wap.FileLogRouter',
                                    'levels' => 'error',
                                ),
                                array(
                                    'class' => 'application.components.wap.FileLogRouter',
                                    'levels' => 'detectMsisdn',
                                    'logFile' => 'detectMsisdn.' . date('Ymd') . '.log',
                                    'maxFileSize' => '50000',
                                ),
                                array(
                                    'class' => 'application.components.wap.FileLogRouter',
                                    'levels' => 'failDetect',
                                    'logFile' => 'failDetect_' . date('Ymd') . '.log',
                                    'maxFileSize' => '50000',
                                ),
								array(
                                    'class'=>'CFileLogRoute',
                                    'levels' => 'debug',
									'logFile' => 'debug.log',
                                ),
                            ),
                        ),
                        'errorHandler' => array (
                            'errorAction' => 'site/error'
                        ),
                    ),
                    //Module
                    //'modules'=>array(),
                    'modules' => array(
                        'event',
                    ),
                    // autoloading model and component classes
                    'import' => array(
                        'application.models.wap.*',
                        'application.components.wap.*',
                        "application.vendors.fundial.*",
                        'application.modules.contest.models.admin.*',
                        'application.modules.contest.models.db._base.*',
                        'application.modules.contest.models.db.*',
                    ),
                    'params' => array(
                        'defaultLanguage' => 'vi_vn',
                        'cacheTime' => 600,
                        "pager.max.button.count" => 4,

                        // limit items on page
                        'numberSongsPerPage' => 6,
                        'htmlMetadata' => array(
                            'title' => '',
                            'keywords' => '',
                            'description' => '',
                        ),     
                    	'SEARCH_SUGGEST_WAP'=>'Mỹ Tâm | Đàm Vĩnh Hưng | Quang Lê | Dương Ngọc Thái | Đan Trường',
                        'pageSize' => 10,
                        'pageSizeSmall' => 5,
                        'homePageSize' => 3,
                        'logRootDir' => _APP_PATH_ . "/protected/runtime/wap/",
                        'maxLogSize' => 10485760,
                        'numExpireDays' => 10,
                        'source.wap' => 1,
                        'source.web' => 2,

                        // Google analytics account
                        'GA_ACCOUNT' => "UA-27953546-16",
                        'GA_PIXEL' => "/ga.php",
                    ),
                ))
);
?>
