<?php

namespace jdubreville\dnsimple;

class Client
{
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $token;
    /**
     * @var domain
     */
    protected $domain;
    /**
     * @var string
     */
    protected $apiUrl;
    /**
     * @var string
     */
    protected $apiVersion = 'v1';
    /**
     * @var Ads
     */
    protected $domains;
    /**
     * @var Debug
     */
    public $debug;

    /**
     * @param string $profileID
     * @param string $apiKey
     */
    public function __construct($email, $token, $domain = 'https://api.dnsimple.com', $version = 'v1')
    {
        $this->email = $email;
        $this->token = $token;
        $this->domain = $domain;
        $this->apiVersion = $version;
        $this->apiUrl = $domain.'/'.$this->apiVersion.'/';

        $this->debug = new Debug();
        $this->domains = new Domains($this);
    }

    /**
     * Returns the domain the api is being called upon.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Returns the generated api URL.
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * Compiles an auth string with either token, password or OAuth credentials.
     *
     * @return string
     */
    public function getAuthText()
    {
        return $this->email.':'.$this->token;
    }

    public function __call($name, $arguments)
    {
        if (isset($this->$name)) {
            if (isset($arguments[0]) && ($arguments[0] != null)) {
                $this->$name->lastId = $arguments[0];
            }

            return  $this->$name;
        } else {
            throw new MethodNotFoundException("No method called $name available in ".__CLASS__);
        }
    }

    /**
     * Returns debug information in an object.
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * Set debug information as an object.
     */
    public function setDebug($lastRequestHeaders, $lastResponseCode, $lastResponseHeaders, $lastRequestData = null, $lastResponseData = null)
    {
        $this->debug->lastRequestHeaders = $lastRequestHeaders;
        $this->debug->lastResponseCode = $lastResponseCode;
        $this->debug->lastResponseHeaders = $lastResponseHeaders;

        /*
        if($this->mode == "DEBUG")
        {
            $this->debug->lastRequestData = $lastRequestData;
            $this->debug->lastResponseData = $lastResponseData;
        }
        */
    }
}
