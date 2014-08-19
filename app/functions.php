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
        $urls = "";
        $keys = [];

        foreach ($posts as $i=>$post){
            if(array_key_exists('share',$post) && $post['share'] !== null && $post['share'] !== ""){
                $urls .= $post['share'].",";
                array_push($keys, $i);
            }else{
                $ct = cockpit("cockpit")->markdown($post['Content']);
                $posts[$i]['Content'] = explode('</p>',$ct)[0];
            }
        }

        $urls = trim($urls,",");
        if(strlen($urls) > 4){
            $shares = json_decode(file_get_contents("http://api.embed.ly/1/extract?key=".EMBEDLY_CONFIG."&urls=".$urls),true);
            foreach ($shares as $i=>$share){
                $posts[$keys[$i]]['embed'] = $shares[$i];
            }
        }
        usort($posts, function($a, $b) {
            return $b['created'] - $a['created'];
        });

        return $posts;
    }

    function curl_get_contents($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    function clean_html($html){
        $pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";
        $str = preg_replace($pattern, '', $html);

        return $str;
    }

}

