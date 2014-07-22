<?php
date_default_timezone_set('Europe/Brussels');

define('TWIG_CONFIG',serialize(
		array(
        	'twig.path' => __DIR__.'/../assets/views',
        	'twig.options' => array('strict_variables' => false ),
    	)
	)
);
define('TWIG_GLOBALS',serialize(
		array(
        	"telephone" => get_registry('Telephone', ""),
        	"email" => get_registry('Email', ""),
        	"nav" => collection("Pages")->find(["navigation"=>true])->toArray(),
    	)
	)
);
define('TWITTER_CONFIG',serialize(
        array(
            "API_key" => "RX87j8LHBeK2GrQildmqjrgT7",
            "API_secret" => "cusGBGGo5z3do4urC9qfUDjJioEMIY5PS3oe7zMacgA96h9JBk",
            "token" => "15457913-GcpOHgGWm5MswWgpJmSrbg537rF9FCEMI9zWSUM0O",
            "secret" => "LlFkVMfSx6v2zbN5zsbqHG9FqW9vM4LV3d0iOogYVEy1Y"
        )
    )
);
