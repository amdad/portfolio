<?php
use Silex\WebTestCase;

class HomeTest extends WebTestCase{
    
	public function createApplication(){
        @session_start();

    	$app = require __DIR__.'/../app/app.php';
    	
        $app['debug'] = true;
    	$app['exception_handler']->disable();

    	return $app;
	}
   
	public function testHomePage(){
    	$client = $this->createClient();
    	$crawler = $client->request('GET', '/');
    	$data = collection("Pages")->findOne(["Title_slug"=>"home"]);

        $this->assertNotEmpty($data);
    	$this->assertTrue($client->getResponse()->isOk());
    	$this->assertCount(1, $crawler->filter('h1:contains("'.$data['Title'].'")'));
	} 

    public function testNav(){
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $nav = collection("Pages")->find(["navigation"=>true])->toArray();

        //Test if nav exists
        $this->assertCount(1, $crawler->filter('nav.top-nav'));

        //Test Homepage 
        $homeurl = $crawler->filter('nav.navbar-lower')->selectLink('Home');
        $this->assertCount(1,$crawler->filter('nav.navbar-lower')->selectLink('Home'));
        $client->click($homeurl->link());
        $this->assertTrue($client->getResponse()->isOk());

        //Test all navigation urls
        foreach($nav as $item){
            if(!isset($item['Title_slug']) || $item['Title_slug'] !== 'home'){
                $url = $crawler->filter('nav.navbar-lower')->selectLink($item['Title'])->link();
                $client->click($url);
                $this->assertTrue($client->getResponse()->isOk());
            }
        }

    }
}