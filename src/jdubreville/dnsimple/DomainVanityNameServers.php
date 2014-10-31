<?php

namespace jdubreville\dnsimple;

class DomainVanityNameServers extends SubClientAbstract
{
	const OBJ_NAME = "";
	
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
	* Get the parent object name
	* 
	* @return string
	*/
	protected function getParentObjectName()
	{
		return "domains";
	}
	
	/**
	* Get the sub endpoint for the service
	* @param mixed $id
	* 
	* @return string
	*/
	public function getSubEndpoint($id =  null)
	{
		$endPoint = "vanity_name_servers";
		
		return $endPoint;
	}
	
	/**
	* Enable vanity name servers on a domain
	* @param array $parameters
	*
	* @return \stdClass
	*/
	public function enable($parameters = array())
	{
		$this->ensureParameters(__METHOD__, $parameters, array( "server_source" ));
		return $this->callEndpoint(__METHOD__, null, array( "vanity_nameserver_configuration" => $parameters ), "POST");
	}
	
	/**
	* Disable vanity name servers on a domain
	* @param array $parameters
	*
	* @return \stdClass
	*/
	public function disable($parameters = array())
	{
		return $this->callEndpoint(__METHOD__, null, $parameters, "DELETE");
	}
}