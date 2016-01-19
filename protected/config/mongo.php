<?php
return
    array(
        'import'=>array(
            'application.extensions.mongodb.*',
            'application.modules.gamification.models.*'
        ),
        // application components
        'components'=>array(
            'mongodb' => array(
                'class'            => 'EMongoDB',
//                'connectionString' => 'mongodb://localhost:27017',
                'connectionString' => 'mongodb://10.0.9.194:27017',
//                'connectionString' => 'mongodb://192.168.89.94:27017',
//                'connectionString' => 'mongodb://admin:Vega2010##@192.168.241.128:27017',
                'dbName'           => 'music_game_new',
                'fsyncFlag'        => true,
                'safeFlag'         => true,
                'useCursor'        => false
            ),
        ),
    );
