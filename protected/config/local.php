<?php
return array(
    'components'=>array(
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error',
				),
			),
		),
		'db' => array(
			/*'connectionString' => 'mysql:host=localhost;dbname=ho48644_mobile_plus',
			'emulatePrepare' => true,
			'username' => 'ho48644_long',
			'password' => '14121517',*/
			'connectionString' => 'mysql:host=localhost;dbname=mobileplus',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'class'=>'CDbConnection',
			'enableProfiling'=>false,
			'enableParamLogging'=>false,
			'schemaCachingDuration' =>3600,
		),
		
    ),
    'params' => array (
    		'local_mode'=>1,
			'base_url'=>'http://amusic.lc/',
 			'storage'=>array(
                           'staticDir' => _APP_PATH_,
                            'newsEventUrl' => 'http://mobile.lc/images/slider/',
//                            'newsEventDir' => 'E:\Project\mobileplus\mobileplus/images/slider/',
                            'newsEventDir' => 'D:\Project\GITHUB\mobileplus\images\slider/',

                            'ProductUrl' => 'http://mobile.lc/images/product/',
//                            'ProductDir' => 'E:\Project\mobileplus\mobileplus/images/product/',
                            'ProductDir' => 'D:\Project\GITHUB\mobileplus\images\product/',
                    ),
        
            // solr search
            'solr.server.host'	=> '127.0.0.1',
            'solr.server.port'	=> 8983,
            'solr.server.path'	=> '/solr/',
        )
);
?>
