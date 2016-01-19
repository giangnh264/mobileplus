<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/admin.php'),
    array(
    	'defaultController' => 'customer',
        'components'=>array(               
                'user' => array(                    
                    'loginUrl' => '/admin/cskh',
                ),
        		
        		'urlManager'=>array(
        				"urlFormat" => "path",
        				"rules" => array(
        				),
        				'showScriptName'=>false,
        				
        		),
        ),
    )
)

?>

