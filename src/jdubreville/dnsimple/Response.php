<?php

namespace jdubreville\dnsimple;

/**
* The response class contains information about the data returning form a web service
*/
class Response 
{
	/**
	* @var int
	*/
	public $code;
	/*
	* @var string
	*/
	public $data;
	/**
	* @var mixed
	*/
	public $json;
	/**
	* @var string
	*/
	public $errors;
	
	/**
	* Determine if the response was successful
	*
	* @return bool True if successful and false otherwise
	*/
	public function isSuccessful()
	{
		return ($this->code >= 200 && $this->code <= 299);
	}
}