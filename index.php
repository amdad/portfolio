<?php
require_once __DIR__.'/cockpit/bootstrap.php';
require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

error_reporting(-1);
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));
$app->get('/topnav', function () use ($app) {
    $nav = collection("Pages")->find(["navigation"=>true])->toArray();

    return $app['twig']->render('tmpl/topnav.twig', array(
        'nav' => $nav,
    ));
});

$app->get('/', function () use ($app) {
    $data = collection("Pages")->findOne(["title"=>"home"]);

    return $app['twig']->render('page.twig', array(
        'data' => $data,
    ));
});

$app->get('/{pageslug}', function ($pageslug) use ($app) {
    $data = collection("Pages")->findOne(["title"=>$pageslug]);

    return $app['twig']->render('page.twig', array(
        'data' => $data,
    ));
});

$app->get('/blog', function () use ($app) {
    $data = collection("blog")->toArray();

    return $app['twig']->render('page.twig', array(
        'data' => $data,
    ));
});

$app->get('/blog/{postslug}', function ($postslug) use ($app) {
    $data = collection("blog")->findOne(["title"=>$postslug]);

    return $app['twig']->render('page.twig', array(
        'data' => $data,
    ));
});

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // ... logic to handle the error and return a Response
});

$app->run();
?>
