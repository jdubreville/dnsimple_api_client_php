<?php

namespace jdubreville\dnsimple;

/**
* The ExtendedAttributes class exposes method for reading attributes of top level domain data (TLD)
*/
class ExtendedAttributes extends ClientAbstract
{
	const OBJ_NAME = "contact";
	
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
		$endPoint = "extended_attributes";
		if(isset($id))
		{
			$endPoint .= "/" . $id;
		}
		
		return $endPoint;
	}
	
	/**
	* Get a list of extened attributes for a top leve domain (TLD)
	* @param array $parameters 
	* 
	* @return array An array of objects representing a domain's records
	* 
	* @throws ResponseException
	*/
	public function getAll($parameters = array())
	{
		return $this->ensureArrayResponse(__METHOD__, $this->getEndpoint($this->ensureLastId(__METHOD__)), "GET", $parameters);
	}
}