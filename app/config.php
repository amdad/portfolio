<?php

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
