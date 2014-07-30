<?php
$app = require __DIR__.'/bootstrap.php';

$app->get('/', function () use ($app) {
    $data = collection("Pages")->findOne(["Title_slug"=>"home"]);
    

    $data['content'] = Cms::smartTags($app, $data['content']);

    return $app['twig']->render('page.twig', array(
        'data' => $data,
    ));
});

$app->get('/blog/', function () use ($app) {
    $posts = collection("posts")->find(["Personal"=>FALSE])->toArray();
    $shares = collection("shares")->find(["Personal"=>FALSE])->toArray();

    $data = array_merge($posts, $shares);

    usort($data, function($a, $b) {
        return $b['created'] - $a['created'];
    });
    d($data);

    return $app['twig']->render('blog.twig', array(
        'data' => $data,
    ));
});

$app->get('/blog/{postslug}/', function ($postslug) use ($app) {
    $data = collection("blog")->findOne(["title"=>$postslug]);

    return $app['twig']->render('post.twig', array(
        'data' => $data,
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

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // ... logic to handle the error and return a Response
});

return $app;