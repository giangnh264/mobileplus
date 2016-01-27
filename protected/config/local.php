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
		
		/*'cache'=>array(
                'class'=>'system.caching.CMemCache',
                'servers'=>array(
                    array('host'=>'10.0.9.194', 'port'=>11211),
                ),
        ),*/
    ),
    'params' => array (
    		'local_mode'=>1,
			'base_url'=>'http://amusic.lc/',
 			'storage'=>array(
                           'staticDir' => _APP_PATH_,
                            'staticUrl' => 'http://static.amusic.v',
                            'baseStorage'=>'/u01/storage/amusic/',
                            'newsEventDir' => 'D:/Project/images/slider/',
                            'newsEventUrl' => 'http://koigiang.com/slider/',

                            'ProductDir' => 'D:/Project/images/product/',
                            'ProductUrl' => 'http://koigiang.com/product/',

                            'bannerDir'=>'/u01/storage/amusic/banner',
                            'bannerUrl'=>'http://static.amusic.vn/amusic/banner/' ,
							
                    ),
            
            // bm
            'bmConfig'=>array(
               # 'remote_wsdl'		=> 'http://192.1i68.241.31:8081',
		        'remote_wsdl'       => 'http://bm.amusic.lc',
                'remote_username'	=> 'amusic',
                'remote_password'	=> 'p5fatDVCvBAvwuO',
            ),
        
            // solr search
//            'solr.server.host'	=> '192.168.89.91',
            'solr.server.host'	=> '127.0.0.1',
            'solr.server.port'	=> 8983,
            'solr.server.path'	=> '/solr/',
        )
);
?>
