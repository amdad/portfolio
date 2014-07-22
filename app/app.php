<?php
$app = require __DIR__.'/bootstrap.php';

$app->get('/', function () use ($app) {
    $data = collection("Pages")->findOne(["Title_slug"=>"home"]);
    $cfg = unserialize(TWITTER_CONFIG);

    $twitter = new Twitter($cfg['API_key'], $cfg['API_secret'], $cfg['token'], $cfg['secret']);
    $statuses = $twitter->load(Twitter::ME);

    return $app['twig']->render('page.twig', array(
        'data' => $data,
        'twitter' => $statuses,
    ));
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