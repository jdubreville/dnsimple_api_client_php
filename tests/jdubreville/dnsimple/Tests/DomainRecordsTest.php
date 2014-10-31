<?php
namespace dubreville\dnsimple\Tests;

use PHPUnit_Framework_TestCase as PHPUnit_Framework_TestCase;
use jdubreville\dnsimple\Client as Client;

class DomainRecordsTest extends PHPUnit_Framework_TestCase
{
	const TEST_IP = "1.2.3.4";
	const UPDATE_IP = "1.2.3.5";
	
	protected $domain;
	protected $email;
	protected $token;
	
	protected $persistentDomain;
	protected $persistentRecord;
	
    public function __construct() 
	{
		$this->domain = $GLOBALS['DOMAIN'];
        $this->email = $GLOBALS['EMAIL'];
        $this->token = $GLOBALS['TOKEN'];
		
		$this->persistentDomain = $GLOBALS['PERSISTENT_DOMAIN'];
		$this->persistentRecord = $GLOBALS['PERSISTENT_RECORD'];
		
        $this->client = new Client($this->email, $this->token, $this->domain);
    }
	
	public function testCreate()
	{
		$item = $this->t = $this->client->domains($this->persistentDomain)->records()->create(array(
			"name" => "",
			"record_type" => "A",
			"content" => self::TEST_IP
		));
		
		$this->assertEquals(is_object($item),true,"Should return and object");
		$this->assertEquals(is_object($item->record),true,"Should return an object with a property object called 'record'");
		$this->assertEquals(isset($item->record->id),true,"Should return a new 'id' for the record");		
		
		return $item->record->id;
	} 
	
	/**
	* @depends testCreate
	*/
	public function testGetAll()
	{
		$items = $this->client->domains($this->persistentDomain)->records()->getAll();
		
		$this->assertEquals(is_array($items),true,"Should return and array of domain records");
		$this->assertEquals((count($items) > 0), true, "Should return atleast one item");
		$this->assertEquals(is_object($items[0]->record), true, "Should return a list of objects with property 'record'");
		$this->assertEquals(isset($items[0]->record->id), true, "Record object should have an 'id' property");
	}
	
	/**
	* @depends testCreate
	*/
	public function testGet($id)
	{
		$item = $this->client->domains($this->persistentDomain)->records($id)->get();
		
		$this->assertEquals(is_object($item),true,"Should return an object");
		$this->assertEquals(is_object($item->record), true, "Should return an object with a property object called 'record'");
		$this->assertEquals($item->record->id, $id, "Id should match temp record id");
	}
	
	/**
	* @depends testCreate
	*/
	public function testUpdate($id)
	{
		$item = $this->client->domains($this->persistentDomain)->records($id)->update(array(
			"content" => self::UPDATE_IP
		));
		
		$this->assertEquals(is_object($item),true,"Should return an object");
		$this->assertEquals(is_object($item->record),true,"Should return an object with a property object called 'record'");
		$this->assertNotEquals($item->record->content,self::TEST_IP,"Should have updated the IP address");
	}
	
	/**
	* @depends testCreate
	*/
	public function testDelete($id) 
	{
		$this->client->domains($this->persistentDomain)->records($id)->delete();
		
		$this->assertEquals(true,true,"Should not throw an exception");
	}
}