<?php
use Silex\WebTestCase;
require_once __DIR__.'/cockpit/bootstrap.php';

class homeTest extends WebTestCase
{

	public function createApplication(){
    	$app = require __DIR__.'/path/to/app.php';
    	$app['debug'] = true;
    	$app['exception_handler']->disable();

    	return $app;
	}
   
	public function testHomePage(){
    	$client = $this->createClient();
    	$crawler = $client->request('GET', '/');
    	$data = collection("Pages")->findOne(["Title_slug"=>"home"]);

    	$this->assertTrue($client->getResponse()->isOk());
    	$this->assertCount(1, $crawler->filter('h1:contains('.$data['Title'].')'));
	} 
}