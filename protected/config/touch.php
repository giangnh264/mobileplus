<?php

return CMap::mergeArray(
                require(dirname(__FILE__) . '/wap.php'), array(
                    'id' => 'wap',
                    'name' => 'wap touch',
                    'controllerPath' => _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "touch",
                    'viewPath' => _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "touch",
                    'defaultController'=>'site',
//                    'theme' => 'grey',
                    'theme' => 'tet2016',
                    'components' => array(
                        'errorHandler' => array(
                            'errorAction' => 'site/error'
                        ),
                    ),
                    //Module
                    'modules' => array(
                    ),
                    // autoloading model and component classes
                    'import' => array(
                    ),
                    /*'errorHandler'=>array(
                	 	// use 'site/error' action to display errors
                	'errorAction'=>'site/error',
                    ),*/
                    'params' => array(
                        'defaultLanguage' => 'vi_vn',
                    	'domain'=>array(
                    	'main_site' => 'http://amusic.vn/',
                    	),
                    	'limit_substring'=>15,
                    	'limit_substring_title'=>20,
                    	'numberPerPage' => 10,
                    	'numberSongPerPage' => 10,
                    	'numberSongPerPageWap' => 5,
                    	'MSG_NO_DETECT' => Yii::t('wap','Vui lòng đăng nhập để thực hiện chức năng này'),
                    	'MSG_ERR_CHARG' => Yii::t('wap','Có lỗi trong quá trình thực hiện, vui lòng thử lại sau'),
                    ),
                )
);
?>
