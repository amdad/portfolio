<?php
require_once __DIR__.'/cockpit/bootstrap.php';
require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

error_reporting(-1);
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $nav = collection("Pages")->find(["navigation"=>true])->toArray();

    $twig->addGlobal('nav', $nav);

    return $twig;
}));

$app->get('/', function () use ($app) {
    $data = collection("Pages")->findOne(["Title_slug"=>"home"]);

    return $app['twig']->render('page.twig', array(
        'data' => $data,
    ));
});
$app->get('/cockpit', function () use ($app) {
    return $app->redirect('/cockpit/index.php');
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
