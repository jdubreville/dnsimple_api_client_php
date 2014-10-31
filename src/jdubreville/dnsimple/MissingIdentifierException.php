<?php

namespace jdubreville\dnsimple;

/**
 * MissingIdentifierException extends the Exception class with simplified messaging
 * @package jdubreville\dnsimple
 */
class MissingIdentifierException extends \Exception {
  
     /**
	* @param string     $method
	* @param string     $detail
	* @param int        $code
	* @param \Exception $previous
	*/
    public function __construct($method, $detail = '', $code = 0, \Exception $previous = null) 
	{
        parent::__construct('Missing identifier parameters: \'' . $detail . '\' must be supplied for '.$method);
    }

}
