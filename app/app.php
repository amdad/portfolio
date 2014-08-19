<?php
$app = require __DIR__.'/bootstrap.php';

$app->get('/', function () use ($app) {
    $data = collection("Pages")->findOne(["Title_slug"=>"home"]);
    

    $data['content'] = Cms::smartTags($app, $data['content']);

    return $app['twig']->render('page.twig', array(
        'data' => $data,
    ));
});

$blog = function ($page) use ($app) {
    $limit = 4;
    $count = collection('posts')->count(function($p){
        return ($p["Personal"] != true && $p['Publish'] === true);
    });
    $pages = ceil($count/$limit);

    $posts = collection("posts")->find(function($p){
        return ($p["Personal"] != true && $p['Publish'] === true);
    })->limit($limit)->skip(($page-1) * $limit)->toArray();

    $posts = Cms::processPosts($posts);

    return $app['twig']->render('blog.twig', array(
        'data' => $posts,
        'page'=> $page, 
        'pages'=> $pages
    ));
};
$app->get('/blog/', $blog)->value('page', '1');
$app->get('/blog/page/{page}/', $blog);


$app->get('/blog/{postslug}/', function ($postslug) use ($app) {
    $data = collection("posts")->findOne(["Title_slug"=>$postslug]);

    if($data === null){
        $app->abort(404, "Post '$postslug' does not exist.");
    }

    return $app['twig']->render('post.twig', array(
        'data' => $data,
    ));
});

$app->get('/portfolio/', function() use ($app) {
    $data = gallery("Portfolio");

    d($data);

    return $app['twig']->render('gallery.twig', array(
        'data' => $data,
    ));
});

$app->get('/cv/', function() use ($app) {
    $content = Cms::curl_get_contents("http://registry.jsonresume.org/kristoffeys.md");
    $content = cockpit("cockpit")->markdown($content);
    $content = Cms::clean_html($content);

    $data = [ 
        "Title" => "Curriculum Vitae",
        "Subtitle" => "Lorem ipsum",
        "content" => "<section class='cv'>".$content."</section>"
        ];

    d($data);

    return $app['twig']->render('page.twig', array(
        'data' => $data,
    ));
});

$app->get('/{pageslug}/', function ($pageslug) use ($app) {
    $data = collection("Pages")->findOne(["Title"=>$pageslug]);
    if ($data === null){
        $data = collection("Pages")->findOne(["Title_slug"=>$pageslug]);
    }
    if($data === null){
        $app->abort(404, "Page '$pageslug' does not exist.");
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