<?php

namespace jdubreville\dnsimple;

class DomainEmailForwards extends SubClientAbstract
{
	const OBJ_NAME = "emailForwards"; 
	
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
		$endPoint = "email_forwards";
		if(isset($id))
		{
			$endPoint .= "/" . $id;
		}
		
		return $endPoint;
	}
	
	/**
	* Get a list of all email forwards for a domain
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
	* Create an email forward for a domain
	* @param array $parameters Key value pair of parameters to pass
	* 
	* @return stdClass 
	* @throws ResponseException
	*/
	public function create($parameters = array())
	{
		$this->ensureParameters(__METHOD__, $parameters, array( "from", "to" ));
		return $this->callCreateItemEndpoint(__METHOD__,array( "email_forward" => $parameters));
	}
	
	/**
	* Delete an email forward for a domain
	* @param array $parameters Key value pair of parameters
	*
	* @throws ResponseException
	*/
	public function delete($parameters = array())
	{	
		$this->callDeleteItemEndpoint(__METHOD__, $parameters);
	}
}