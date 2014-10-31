<?php

namespace jdubreville\dnsimple;

class DomainMemberships extends SubClientAbstract
{
	const OBJ_NAME = "membership"; 
	
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
		$endPoint = "memberships";
		if(isset($id))
		{
			$endPoint .= "/" . $id;
		}
		
		return $endPoint;
	}
	
	/**
	* Get all domain records
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
	* Create a domain membership
	* @param array $parameters Key value pair of parameters to pass
	* 
	* @return stdClass 
	* @throws ResponseException
	*/
	public function add($parameters = array())
	{
		$this->ensureParameters(__METHOD__, $parameters, array( "email" ));
		return $this->callCreateItemEndpoint(__METHOD__,array( "membership" => $parameters));
	}
	
	/**
	* Delete a domain membership
	* @param array $parameters Key value pair of parameters
	*
	* @throws ResponseException
	*/
	public function delete($parameters = array())
	{	
		$this->callDeleteItemEndpoint(__METHOD__, $parameters);
	}
}