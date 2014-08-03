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

    $urls = "";
    $dates = [];
    foreach ($shares as $share){
        $urls .= $share['url'].",";
        array_push($dates, $share['created']);
    }
    $urls = trim($urls,",");
    //&maxwidth=:maxwidth&maxheight=:maxheight&format=:format&callback=:callback
    $shares = json_decode(file_get_contents("http://api.embed.ly/1/extract?key=".EMBEDLY_CONFIG."&urls=".$urls),true);
    foreach ($shares as $i=>$share){
        $shares[$i]['created'] = $dates[$i];
    }

    foreach ($posts as $i=>$post){
        $ct = cockpit("cockpit")->markdown($post['Content']);
        $posts[$i]['Content'] = split('</p>',$ct)[0];
    }

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
    $data = collection("posts")->findOne(["Title_slug"=>$postslug]);

    d($data);

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