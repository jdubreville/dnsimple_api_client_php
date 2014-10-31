<?php

namespace jdubreville\dnsimple;

class DomainNameServers extends SubClientAbstract
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
		$endPoint = "registry_name_servers";
		
		return $endPoint;
	}
	
	/**
	* Register a name server on a domain
	* @param array $parameters
	*
	* @return \stdClass
	*/
	public function register($parameters = array())
	{
		$this->ensureParameters(__METHOD__, $parameters, array( "name", "ip" ));
		return $this->callEndpoint(__METHOD__, null, array( "name_server" => $parameters ), "POST");
	}
	
	/**
	* De-Register a name server on a domain
	* @param array $parameters
	*
	* @return \stdClass
	*/
	public function deregister($parameters = array())
	{
		return $this->callEndpoint(__METHOD__, $this->ensureLastId(__METHOD__), $parameters, "DELETE");
	}
}