<?php
$app['debug'] = true;

require_once __DIR__.'/cockpit/bootstrap.php';
require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));


$app->get('/', function () use ($app) {
    $data = collection("Pages")->findOne(["title"=>"home"]);
    $nav = collection("Pages")->find(["navigation"=>true])->toArray();

    return $app['twig']->render('page.twig', array(
        'data' => $data,
        'nav' => $nav,
    ));
});

$app->get('/{pageslug}', function ($pageslug) use ($app) {
    $data = collection("Pages")->findOne(["title"=>$pageslug]);
    $nav = collection("Pages")->find(["navigation"=>true])->toArray();

    return $app['twig']->render('page.twig', array(
        'data' => $data,
        'nav' => $nav,
    ));
});

$app->get('/blog', function () use ($app) {
    $data = collection("blog")->toArray();
    $nav = collection("Pages")->find(["navigation"=>true])->toArray();

    return $app['twig']->render('page.twig', array(
        'data' => $data,
        'nav' => $nav,
    ));
});

$app->get('/blog/{postslug}', function ($postslug) use ($app) {
    $data = collection("blog")->findOne(["title"=>$postslug]);
    $nav = collection("Pages")->find(["navigation"=>true])->toArray();

    return $app['twig']->render('page.twig', array(
        'data' => $data,
        'nav' => $nav,
    ));
});

$app->run();
?>
