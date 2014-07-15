<?php
use Silex\WebTestCase;

class HomeTest extends WebTestCase{
    
	public function createApplication(){
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
}