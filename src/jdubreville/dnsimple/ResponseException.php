<?php

namespace jdubreville\dnsimple;

/**
 * ResponseException extends the Exception class with simplified messaging.
 */
class ResponseException extends \Exception
{
    /**
     * @param string     $method
     * @param string     $detail
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct($method, $detail = '', $code = 0, \Exception $previous = null)
    {
        if (is_object($detail)) {
            $detail = json_encode($detail);
        } elseif (is_array($detail)) {
            $detail = implode($detail);
        }
        parent::__construct('Response to '.$method.' is not valid. '.$detail, $code, $previous);
    }
}
