<?php

namespace jdubreville\dnsimple;

/**
* The ClientAbstract class providers a generic set of method and functions for processing
* client calls.
*
* @package jdubreville\dnsimple
*/
abstract class ClientAbstract
{
	/**
	* @var Client
	*/
    protected $client;
	
	/**
	* @var int
	*/
    public $lastId;
    
	/**
	* @param Client $client
	*/
	public function __construct(Client $client) 
	{
		$this->client = $client;
    }
	
	/**
	* Get the last id 
	* 
	* @return mixed
	*/
	public function getLastId()
	{
		return $this->lastId;
	}
	
	/**
	* Set the last id
	* @param mixed $lastId
	*/
	public function setLastId($lastId)
	{
		$this->lastId = $lastId;
	}
	
	/**
	* Check if a dictionary contains all the specified keys
	* @param array $table 
	* @param array $keys
	*
	* @return bool
	*/
	protected function hasKeys($table, $keys = array())
	{
		foreach($keys as $key)
		{
			if(!array_key_exists($key, $table))
			{
				return false;
			}
		}
		
		return true;
	}
	
	/**
	* Ensures the methods parameters contain the required fields
	* @param string $method
	* @param array $parameters
	* @param array $requiredParameters
	*
	* @throws MissingParametersException
	*/
	protected function ensureParameters($method, $parameters, $requiredParameters = array())
	{
		if(!$this->hasKeys($parameters, $requiredParameters))
		{
			throw new MissingParametersException($method, $requiredParameters);
		}
	}
	
	/**
	* Ensure the last id is set into the parameter list
	* @param string $function
	* 
	* @throws MissingIdentifierException
	*/
	protected function ensureLastId($function)
	{
		$id = null;
		if($this->lastId != null) 
		{
			$id = $this->lastId;
            $this->lastId = null;
		}
		else
		{
			throw new MissingIdentifierException($function, "Identifier for '" . $this->getIdField() . "' is required");
		}
		
		return $id;
	}
	
	/**
	* Send a request to the server for processing and cleanses the data to send.
	* @param string $endPoint
	* @param string $method
	* @param mixed $data
	* @param mixed $removeItems
	* 
	* @return Response
	*/
	protected function send($endPoint, $method = "GET", $data = null, $removeItems = null)
	{
		$endPoint = Request::prepare($endPoint);
		return Request::send($this->client, $endPoint, $data, $method);
	}
	
	/**
	* Ensure the response is valid and a 200 code was returned
	* @param string $function 
	* @param string $endPoint
	* @param string $method
	* @param array $data
	* @param mixed $removeItems
	*
	* @return Response
	* @throws ResponseException
	*/
	protected function ensureValidResponse($function, $endPoint, $method = "GET", $data = null, $removeItems = null)
	{
		$response = $this->send($endPoint,$method,$data,$removeItems);
		
		if(!$response->isSuccessful())
		{
			throw new ResponseException($function,$response->errors);
		}
		
		return $response;
	}
	
	/**
	* Ensure the response is valid and an object is returned
	* @param string $function 
	* @param string $endPoint
	* @param string $method
	* @param array $data
	* @param mixed $removeItems
	*
	* @return \stdClass
	* @throws ResponseException
	*/
	protected function ensureObjectResponse($function, $endPoint, $method = "GET", $data = null, $removeItems = null)
	{
		$response = $this->ensureValidResponse($function, $endPoint, $method, $data, $removeItems);
		
		if(!is_object($response->json))
		{
			throw new ResponseException($function);
		}
		
		return $response->json;
	}
	
	/**
	* Ensure the response is valid and an array is returned
	* @param string $function 
	* @param string $endPoint
	* @param string $method
	* @param array $data
	* @param mixed $removeItems
	*
	* @return array
	* @throws ResponseException
	*/
	protected function ensureArrayResponse($function, $endPoint, $method = "GET", $data = null, $removeItems = null)
	{
		$response = $this->ensureValidResponse($function, $endPoint, $method, $data, $removeItems);
		
		if(!is_array($response->json))
		{
			throw new ResponseException($function);
		}
		
		return $response->json;
	}
	
	/**
	* Call an endpoint
	* @param string $function
	* @param array $parameters
	* @param string $method
	*
	* @return \stdClass
	*/
	protected function callEndpoint($function, $id, $parameters = null, $method = "GET", $path = null)
	{
		return $this->ensureObjectResponse($function, $this->getEndpoint($id) . (isset($path) ? "/" . $path : ""), $method, $parameters); 
	}
	
	/**
	* Call a list endpoint 
	* @param string $function
	* @param array $parameters
	* 
	* @return array
	*/
	protected function callListEndpoint($function, $parameters = null)
	{
		return $this->ensureArrayResponse($function, $this->getEndpoint(),"GET", $parameters);
	}
	
	/**
	* Create an item
	* @param string function
	* @param array $parameters
	*/
	protected function callCreateItemEndpoint($function, $parameters = null)
	{
		return $this->ensureObjectResponse($function, $this->getEndpoint(), "POST", $parameters); 
	}
	
	/**
	* Call an item endpoint.  This will require the an item identifier is provided
	* @param sting $function
	* @param array $parameters
	* @param string $method
	*/
	protected function callItemEndpoint($function, $parameters = null, $method = "GET")
	{
		return $this->ensureObjectResponse($function, $this->getEndpoint($this->ensureLastId($function)), $method, $parameters); 
	}
	
	/**
	* Update an item
	* @param string function
	* @param array $parameters
	*/
	protected function callUpdateItemEndpoint($function, $parameters = null)
	{
		return $this->callItemEndpoint($function, $parameters, "PUT"); 
	}
	
	/**
	* Delete an item
	* @param string function
	* @param array $parameters
	*/
	protected function callDeleteItemEndpoint($function, $parameters = null)
	{
		return $this->ensureValidResponse($function, $this->getEndpoint($this->ensureLastId($function)), "DELETE", $parameters); 
	}
	
	/**
	* Update a piece of an item.
	* @param string function
	* @param string path
	* @param array $parameters
	*/
	protected function callUpdateItemFieldEndpoint($function, $path, $parameters = null)
	{
		return $this->ensureObjectResponse($function, $this->getEndpoint($this->ensureLastId($function)) . "/" .$path, "POST", $parameters); 
	}
	
	/**
	* Get the ID Field of the object
	*
	* @return string
	*/
	protected abstract function getIdField();
	
	/**
	* Get the endpoint for the service
	* @param mixed $id
	* 
	* @return string
	*/
	public abstract function getEndpoint($id =  null);
}