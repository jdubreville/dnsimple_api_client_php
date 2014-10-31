<?php

namespace jdubreville\dnsimple;

/**
* The Subscriptions class exposes method for reading and creating subscription data
*/
class Subscriptions extends ClientAbstract
{
	const OBJ_NAME = "subscription";
	
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
		$endPoint = "subscription";
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
	public function get($parameters = array())
	{
		return $this->callItemEndpoint(__METHOD__);
	}
	
	/**
	* Create a user
	* @param array $parameters Key value pair of parameters to pass
	* 
	* @return \stdClass 
	* @throws ResponseException
	*/
	public function create($parameters = array())
	{
		$this->ensureParameters(__METHOD__, $parameters, array( "plan", "credit_card" ));
		$this->ensureParameters(__METHOD__, $parameters["credit_card"], array( "number", "first_name", "last_name", "billing_address", "billing_zip", "month", "year", "cvv"));
		//return $this->callCreateItemEndpoint(__METHOD__,array( "user" => $parameters));
		return $this->callUpdateItemEndpoint(__METHOD__,array( "subscription" => $parameters));
	}
}