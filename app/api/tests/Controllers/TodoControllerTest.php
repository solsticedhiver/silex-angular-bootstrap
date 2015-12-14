<?php
namespace Todo\Tests;

use Silex\WebTestCase;
use Silex\Application;

class TodoTest extends WebTestCase
{





	public function createApplication()
    {
        
		$app = require __DIR__.'/../../bootstrap.php';

		$app['debug'] = true;
		// Generate raw exceptions instead of HTML pages if errors occur
		$app['exception_handler']->disable();
		// Enable anonymous access to admin zone
		//$app['security.access_rules'] = array();

    	//overwrite default 
  //   	$app->register(new Silex\Provider\DoctrineServiceProvider(),
		// 	    array(
		// 	        'db.options' => array(
		// 	            'driver' => 'pdo_sqlite',
		// 	            'path'   => __DIR__ . '/../../db/app-test.db.sqlite',
		// 	        ),
		// 	    )
		// );

		// $app['db']->executeUpdate(file_get_contents(__DIR__ . '/../db/db.sql'));



		return $app;



	 //    return $app;
    }


	public function testGetAll()
	{
	    $client = $this->createClient();
	    $crawler = $client->request('GET', '/todos/');

	    //$payload = json_decode($client->getResponse()->getContent());
	    

	    $this->assertTrue($client->getResponse()->headers->contains(
        'Content-Type',
        'application/json'
    	));

	    $this->assertTrue($client->getResponse()->isOk());

    }

    

    public function testAddUpdateDelete(){


    	$client = $this->createClient();
    	$resp = $client->request('POST', '/todos/', array(),
        	array(),
        	array('CONTENT_TYPE' => 'application/json'),
        	'{"name":"kikou"}');

    	$this->assertEquals($client->getResponse()->getStatusCode(), 201);

    	$data = json_decode($client->getResponse()->getContent());


    	$this->assertEquals('kikou', $data->name);

    	$id = $data->id;

    	//update

    	$resp = $client->request('PUT', '/todos/'.$id, array(),
        	array(),
        	array('CONTENT_TYPE' => 'application/json'),
        	'{"name":"mijo"}');

    	$this->assertEquals($client->getResponse()->getStatusCode(), 200);

    	$data = json_decode($client->getResponse()->getContent());


    	$this->assertEquals('mijo', $data->name);

    	//delete
    	$client = $this->createClient();
   		$crawler = $client->request('DELETE', '/todos/'.$id);
   		$this->assertEquals($client->getResponse()->getStatusCode(), 200);





    }

   



}