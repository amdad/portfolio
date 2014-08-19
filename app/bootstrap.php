<?php
require_once __DIR__.'/../cockpit/bootstrap.php';
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/functions.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), unserialize(TWIG_CONFIG));
$app['twig'] = $app->share($app->extend('twig', function(Twig_Environment $twig, Silex\Application $app) {
	
	$twig->addGlobal('globals', unserialize(TWIG_GLOBALS));

	$filter = new Twig_SimpleFilter('form', function ($string) {
    	return form($string);
	});
	$twig->addFilter($filter);

	$click = new Twig_SimpleFilter('clickable', function ($string) {
    	return Twitter::clickable($string);
	});
	$twig->addFilter($click);

	$markdown = new Twig_SimpleFilter('md', function ($string) {
    	return cockpit("cockpit")->markdown($string);
	});
	$twig->addFilter($markdown);

	$thumb = new Twig_SimpleFilter('thumb', function ($string) {
    	return cockpit("mediamanager")->thumbnail($string,"300","100");
	});
	$twig->addFilter($thumb);

	$sq = new Twig_SimpleFilter('sq', function ($string) {
    	return cockpit("mediamanager")->thumbnail($string,"1200","300");
	});
	$twig->addFilter($sq);

	return $twig;
}));



return $app;