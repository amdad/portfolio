<?php
class Cms{
    public static function twSlider($app, $data){
        preg_match_all("/\[\[twitter\]\]/",$data,$res);

        $cfg = unserialize(TWITTER_CONFIG);

        try{
            $twitter = new Twitter($cfg['API_key'], $cfg['API_secret'], $cfg['token'], $cfg['secret']);
            $statuses = $twitter->load(Twitter::ME);
        }catch(Exception $e){
            $statuses = null;
        }

        foreach ($res[0] as $tw){
            $tw = $app['twig']->render('twitter.twig', array('twitter' => $statuses));
            $data = str_replace("[[twitter]]",$tw, $data);
        }
        return $data;
    }

    public static function smartTags($app,$data){
        $data = Cms::twSlider($app, $data);
        preg_match_all("/\[\[[a-zA-Z]*\]\]/",$data,$res);
        foreach ($res[0] as $tag){
            $stripped = str_replace(array("[","]"),"",$tag);
            $cnt = $app['twig']->render($stripped.'.twig');
            $data = str_replace($tag,$cnt, $data);
        }
        return $data;
    }

    public static function processPosts($posts){
        foreach ($posts as $i=>$post){
            $ct = cockpit("cockpit")->markdown($post['Content']);
            $posts[$i]['Content'] = explode('</p>',$ct)[0];
        }
        return $posts;
    }

    public static function processShares($shares){
        $urls = "";
        $dates = [];
        $tags = [];
    
        foreach ($shares as $share){
            $urls .= $share['url'].",";
            array_push($dates, $share['created']);
            array_push($tags, $share['tags']);
        }
        
        $urls = trim($urls,",");
        //&maxwidth=:maxwidth&maxheight=:maxheight&format=:format&callback=:callback
        $shares = json_decode(file_get_contents("http://api.embed.ly/1/extract?key=".EMBEDLY_CONFIG."&urls=".$urls),true);
        foreach ($shares as $i=>$share){
            $shares[$i]['created'] = $dates[$i];
            $shares[$i]['tags'] = $tags[$i];
        }

        return $shares;
    }
}

