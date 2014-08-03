<?php
date_default_timezone_set('Europe/Brussels');

define('TWIG_CONFIG',serialize(
		array(
        	'twig.path' => __DIR__.'/../assets/views',
        	'twig.options' => array('strict_variables' => false ),
    	)
	)
);
define('TWITTER_CONFIG',serialize(
        array(
            "API_key" => get_registry('twitter_api_key', ""),
            "API_secret" => get_registry('twitter_api_secret', ""),
            "token" => get_registry('twitter_token', ""),
            "secret" => get_registry('twitter_secret', "")
        )
    )
);
define('EMBEDLY_CONFIG',get_registry('embedly_key',""));
define('TWIG_GLOBALS',serialize(
		array(
        	"telephone" => get_registry('Telephone', ""),
        	"email" => get_registry('Email', ""),
        	"nav" => collection("Pages")->find(["navigation"=>true])->toArray(),
            "embedly" => EMBEDLY_CONFIG,
    	)
	)
);