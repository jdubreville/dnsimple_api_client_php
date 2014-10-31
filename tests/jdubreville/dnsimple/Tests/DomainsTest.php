<?php
namespace jdubreville\dnsimple\Tests;

use PHPUnit_Framework_TestCase as PHPUnit_Framework_TestCase;
use jdubreville\dnsimple\Client as Client;

class DomainsTest extends PHPUnit_Framework_TestCase
{
	protected $domain;
	protected $email;
	protected $token;
	
	protected $persistentDomain;
	protected $tempDomain;
	protected $domainToken;
	
    public function __construct() 
	{
		$this->domain = $GLOBALS['DOMAIN'];
        $this->email = $GLOBALS['EMAIL'];
        $this->token = $GLOBALS['TOKEN'];
		
		$this->persistentDomain = $GLOBALS['PERSISTENT_DOMAIN'];
		$this->tempDomain = $GLOBALS['TEMP_DOMAIN'];
		
        $this->client = new Client($this->email, $this->token, $this->domain);
    }
	
	public function testGetAll()
	{
		$items = $this->client->domains()->getAll();
		
		$this->assertEquals(is_array($items),true,"Should return and array of domains");
		$this->assertEquals((count($items) > 0), true, "Should return atleast 1 domain");
		$this->assertEquals(is_object($items[0]->domain), true, "Should return a list of objects with a 'domain' property");
		$this->assertEquals(isset($items[0]->domain->name), true, "The domain object should have a property called 'name'");
	}
	
	public function testGet()
	{
		$item = $this->client->domains($this->persistentDomain)->get();
		
		$this->assertEquals(is_object($item),true,"Should return and object");
		$this->assertEquals(is_object($item->domain),true, "Should return an object with an object property called 'domain'");
		$this->assertEquals($item->domain->name,$this->persistentDomain, "Should return a domain with the same name");
	}
	
	
	public function testCreate()
	{
		$item = $this->client->domains()->create(array(
			"name" => $this->tempDomain
		));
		
		$this->domainToken = $item->domain->token;
		
		$this->assertEquals(is_object($item),true,"Should return and object");
		$this->assertEquals(is_object($item->domain), true, "Should return an object with an object property called 'domain'");
		$this->assertEquals($this->tempDomain, $item->domain->name, "Should return a domain with the same name as the input");
	}
	
	/**
	* @depends testCreate
	*/
	public function testResetToken()
	{
		$item = $this->client->domains($this->tempDomain)->resetToken();
		
		$this->assertEquals(is_object($item),true,"Should return and object");
		$this->assertEquals(is_object($item->domain), true, "Should return an object with an object property called 'domain'");
		$this->assertNotEquals($this->domainToken, $item->domain->token, "Token should be reset and should no longer be equal");
	}
	
	/**
	* @depends testCreate
	*/
	public function testDelete()
	{
		$this->client->domains($this->tempDomain)->delete();
		
		$this->assertEquals(true,true,"Should not throw an exception");
	}
}
