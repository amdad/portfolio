<?php
$app = require_once __DIR__.'/bootstrap.php';

error_reporting(-1);
$app['debug'] = true;

$app->get('/', function () use ($app) {
    $data = collection("Pages")->findOne(["Title_slug"=>"home"]);

    return $app['twig']->render('page.twig', array(
        'data' => $data,
    ));
});
$app->get('/cockpit/', function () use ($app) {
    return $app->redirect('/cockpit/index.php');
});

$app->get('/{pageslug}/', function ($pageslug) use ($app) {
    $data = collection("Pages")->findOne(["Title"=>$pageslug]);
    if ($data === null){
        $data = collection("Pages")->findOne(["Title_slug"=>$pageslug]);
    }
    return $app['twig']->render('page.twig', array(
        'data' => $data,
    ));
});

$app->get('/blog/', function () use ($app) {
    $data = collection("blog")->toArray();

    return $app['twig']->render('page.twig', array(
        'data' => $data,
    ));
});

$app->get('/blog/{postslug}/', function ($postslug) use ($app) {
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

return $app;