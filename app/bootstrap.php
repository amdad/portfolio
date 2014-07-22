<?php
require_once __DIR__.'/../cockpit/bootstrap.php';
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/config.php';


$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), unserialize(TWIG_CONFIG));
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
	
	$twig->addGlobal('globals', unserialize(TWIG_GLOBALS));

	$filter = new Twig_SimpleFilter('form', function ($string) {
    	return form($string);
	});
	$twig->addFilter($filter);

	$click = new Twig_SimpleFilter('clickable', function ($string) {
    	return Twitter::clickable($string);
	});
	$twig->addFilter($click);

	return $twig;
}));



return $app;