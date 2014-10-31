<?php

namespace jdubreville\dnsimple;

/**
* The Contacts class exposes method for reading, creating, updating and deleting contact data
*/
class Services extends ClientAbstract
{
	const OBJ_NAME = "service";
	
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
		$endPoint = "services";
		if(isset($id))
		{
			$endPoint .= "/" . $id;
		}
		
		return $endPoint;
	}
	
	/**
	* Get a list of services
	* @param array $parameters 
	* 
	* @return array An array of objects representing a domain's records
	* 
	* @throws ResponseException
	*/
	public function getAll($parameters = array())
	{
		return $this->callListEndpoint(__METHOD__);
	}
	
	/**
	* Get a service
	* @param array $parameters 
	* 
	* @return \stdClass  
	* 
	* @throws ResponseException
	*/
	public function get($parameters = array())
	{
		return $this->callItemEndpoint(__METHOD__);
	}
}