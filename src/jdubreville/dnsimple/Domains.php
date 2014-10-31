<?php

namespace jdubreville\dnsimple;

/**
* The Domains class exposes method for reading, creating, updating and deleting domain data
*/
class Domains extends ClientAbstract
{
	const OBJ_NAME = "domain";
	
	/**
	* @var DomainMemberships
	*/
	protected $memberships;
	/**
	* @var DomainRecords
	*/
	protected $records;
	/**
	* @var DomainVanityNameServers
	*/
	protected $vanityNameServers;
	
	public function __construct($client) 
	{
        parent::__construct($client);
		$this->memberships = new DomainMemberships($client);
		$this->records = new DomainRecords($client);
		$this->vanityNameServers = new DomainVanityNameServers($client);
    }
	
	/**
	* Get the ID Field of the object
	*
	* @return string
	*/
	protected function getIdField()
	{
		return self::OBJ_NAME;
	}
	
	/**
	* Get the endpoint for the service
	* @param mixed $id
	* 
	* @return string
	*/
	public function getEndpoint($id =  null)
	{
		$endPoint = "domains";
		if(isset($id))
		{
			$endPoint .= "/" . $id;
		}
		
		return $endPoint;
	}

	/**
	* Get all domains 
	* @param array $parameters Currently no parameters are supported
	* 
	* @return array An array of objects representing a domain
	* 
	* @throws ResponseException
	*/
	public function getAll($parameters = array())
	{
		return $this->callListEndpoint(__METHOD__);
	}
	
	/**
	* Get a specific domain
	* @param array $parameters Currently no parameters are supported
	*
	* @return stdClass An object that represents a domain
	* @throws MissingParametersException
	* @throws ResponseException
	*/
	public function get($parameters = array())
	{
		return $this->callItemEndpoint(__METHOD__);
	}
	
	/**
	* Create a domain
	* @param array $parameters Key value pair of parameters to pass
	* 
	* @return stdClass 
	* @throws ResponseException
	*/
	public function create($parameters = array())
	{
		return $this->callCreateItemEndpoint(__METHOD__,array( "domain" => $parameters));
	}
	
	/**
	* Delete a domain
	* @param array $parameters Key value pair of parameters (currently not supported)
	*
	* @throws ResponseException
	*/
	public function delete($parameters = array())
	{	
		$this->callDeleteItemEndpoint(__METHOD__, $parameters);
	}
	
	/**
	* Reset a domain token
	* @param array $parameters Key value pair of parameters (currently not supported)
	*
	* @throws MissingParameterException 
	* @throws ResponseException
	*/
	public function resetToken($parameters = array())
	{
		return $this->callUpdateItemFieldEndpoint(__METHOD__, "token", $parameters);
	}
	
	/**
	* Transfer a domain to another account
	* @param array $parameters Key value pair of parameters 
	*
	* @return \stdClass
	* @throws MissingParameterException 
	* @throws ResponseException
	*/
	public function push($parameters = array())
	{
		return $this->callUpdateItemFieldEndpoint(__METHOD__, "push", array( "push" => $parameters ));
	}
	
	/** 
	* Check the availability status of a domain
	* @param array $parameters
	*
	* @return \stdClass
	* @throws ResponseException
	*/
	public function check($parameters = array())
	{
		$response = $this->send($this->getEndpoint($this->ensureLastId(__METHOD__)) . "/check", "GET",$parameters);
		
		return $response->json;
	}
	
	public function register($parameters = array())
	{
		$this->ensureParameters(__METHOD__, $parameters, array( "name", "registrant_id" ));
		$response = $this->send("domain_registrations", "POST", $parameters);
		
		if(!$reponse->isSuccessful())
		{
			throw new ResponseException(__METHOD__);
		}
		
		return $response->json;
	}
	
	public function transferIn($parameters = array())
	{
		$this->ensureParameters(__METHOD__, $parameters, array( "name", "registrant_id" ));
		$response = $this->send("domain_registrations", "POST", $parameters);
		
		if(!$reponse->isSuccessful())
		{
			throw new ResponseException(__METHOD__);
		}
		
		return $response->json;
	}
	
	public function transferOut($parameters = array())
	{
		$response = $this->send($this->getEndpoint($this->ensureLastId(__METHOD__)) . "/transfer_out", "POST", $parameters);
		
		if(!$reponse->isSuccessful())
		{
			throw new ResponseException(__METHOD__);
		}
		
		return $response->json;
	}
	
	public function renew($parameters = array())
	{
		$this->ensureParameters(__METHOD__, $parameters, array( "name"));
		$response = $this->send("domain_renewals", "POST", $parameters);
		
		return $response->json;
	}
	
	/**
	* Enable auto renewal of domain
	* @param array $parameters
	*
	* @return \stdClass
	*/
	public function enableAutoRenew($parameters = array())
	{
		return $this->callEndpoint(__METHOD__, $this->ensureLastId(__METHOD__), $parameters, "POST", "auto_renewal");
	}
	
	/**
	* Disable auto renewal of domain
	* @param array $parameters
	*
	* @return \stdClass
	*/
	public function disableAutoRenew($parameters = array())
	{
		return $this->callEndpoint(__METHOD__, $this->ensureLastId(__METHOD__), $parameters, "DELETE", "auto_renewal");
	}
	
	/*
	public function nameServers($parameters = array())
	{
		return $this->callEndpoint(__METHOD__, $this->ensureLastId(__METHOD__), array( "name_servers" => $parameters ), "POST", "name_servers");
	}
	*/
	
	public function enableWhoIsPrivacy($parameters = array())
	{
		return $this->callEndpoint(__METHOD__, $this->ensureLastId(__METHOD__), $parameters, "POST", "whois_privacy");
	}
	
	public function disableWhoIsPrivacy($parameters = array())
	{
		return $this->callEndpoint(__METHOD__, $this->ensureLastId(__METHOD__), $parameters, "DELETE", "whois_privacy");
	}
	
	public function importZone($parameters = array())
	{
		$this->ensureParameters($parameters, array( "zone_data" ));
		return $this->callEndpoint(__METHOD__, $this->ensureLastId(__METHOD__), array( "zone_import" => $parameters ), "POST", "zone_imports");
	}
	
	public function exportZone($parameters = array())
	{
		return $this->callEndpoint(__METHOD__, $this->ensureLastId(__METHOD__), $parameters, "GET", "zone");
	}
	
	/**
	* Generic method to call protected property functions
	* @param string $name The name of the method being called
	* @param array $arguments List of arguments passed to the method
	* 
	* @return mixed
	* @throws MethodNotFoundException
	*/
	public function __call($name, $arguments) 
	{
        if(isset($this->$name)) 
		{
			if(isset($arguments[0]) && ($arguments[0] != null)) 
			{
				$this->$name->lastId = $arguments[0];
			}
            return  $this->$name;
        }
		else 
		{
            throw new MethodNotFoundException("No method called $name available in ".__CLASS__);
        }
    }

}