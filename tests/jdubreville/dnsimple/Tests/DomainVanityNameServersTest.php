<?php

namespace jdubreville\dnsimple\Tests;

use PHPUnit_Framework_TestCase as PHPUnit_Framework_TestCase;
use jdubreville\dnsimple\Client as Client;

class DomainVanityNameServersTest extends PHPUnit_Framework_TestCase
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

    /*
    public function testEnable()
    {
        $this->client->domains($this->persistentDomain)->vanityNameServers()->enable(array(
            "server_source" => "external",
            "ns1" => "ns1.example.com",
            "ns2" => "ns2.example.com"
        ));
    }
    */

    /*
    * @depends testEnable
    */
    /*
    public function testDisable()
    {
        $this->client->domains($this->domain)->vanityNameServers()->delete();
    }
    */
}
