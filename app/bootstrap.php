<?php
require_once __DIR__.'/../cockpit/bootstrap.php';
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/config.php';


$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), unserialize(TWIG_CONFIG));
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {$twig->addGlobal('globals', unserialize(TWIG_GLOBALS));return $twig;}));

return $app;