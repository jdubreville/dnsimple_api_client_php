<?php
namespace jdubreville\dnsimple;
 
/**
* The DomainTemplates class exposes methods for applying a template to a domain
* @package jdubreville\dnsimple
*/
class DomainTemplates extends SubClientAbstract
{
	const OBJ_NAME = "template";
	
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
		$endPoint = "templates";
		if(isset($id))
		{
			$endPoint .= "/" . $id;
		}
		
		return $endPoint;
	}
	
	/**
	* Apply a template to a domain
	* @param array $parameters
	* 
	* @return \stdClass 
	* @throws ResponseException
	*/
	public function apply($parameters = array())
	{
		return $this->callEndpoint(__METHOD__, $this->ensureLastId(__METHOD__), $parameters, "POST", "apply");
	}
	
	
}