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
			//'connectionString' => 'mysql:host=192.168.89.71;dbname=amusic',
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
            'price'=>array(
                            'songListen'=>'1000',
                            'songDownload'=>'2000',
                            'videoListen'=>'2000',
                            'videoDownload'=>'3000',
                            'rtDownload'=>'2000',
                            'albumListen' => '4000',
                            'songGiftListen'=>'600'
                        ),
            'smsClient'=>array(
				'smsWsdl'=>'http://192.168.89.194:8084/api/soap',
			   // 'smsWsdl'=>'http://192.168.89.94:8084/api/soap',
                            'username'=>'amusic',
                            'password'=>'amusic_2015@!',
                            'serviceName'=>'AMUSIC',
			    'serviceNumber'=>'9166',
                        ),  
			'charging_proxy'=>array(
                        'url'=>'http://192.168.89.194:9999/ws/chargingRequest?wsdl',
                        'username'=>'vega',
                        'password'=>'vega.123'
                    ), 
    		'crbt'=>array(
    				'url'		=>'http://113.187.31.231:8080/spservice/',
    				'sid'		=>'589002',
    				'seq'		=>'5890022015112133194300000000',
    				'sidpwd'	=>'38628bf16f30158a0dfdc34902e1febf',
    				'modulecode'=>'589002',
            ), 					
 			'storage'=>array(
                           'staticDir' => _APP_PATH_,
                            'staticUrl' => 'http://static.amusic.v',
                            'baseStorage'=>'/u01/storage/amusic/',



                            'newsEventDir' => 'D:/Project/images/img/',
                            'newsEventUrl' => 'http://koigiang.com/img/',
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
