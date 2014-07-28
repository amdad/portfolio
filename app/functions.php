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
}

