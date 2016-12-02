<?php

namespace jdubreville\dnsimple;

/**
 * The Prices class exposes method for reading price data.
 */
class Prices extends ClientAbstract
{
    const OBJ_NAME = 'price';

    /**
     * Get the ID Field of the object.
     *
     * @return string
     */
    protected function getIdField()
    {
        return self::OBJ_NAME;
    }

    /**
     * Get the endpoint for the service.
     *
     * @param mixed $id
     *
     * @return string
     */
    public function getEndpoint($id = null)
    {
        $endPoint = 'prices';
        if (isset($id)) {
            $endPoint .= '/'.$id;
        }

        return $endPoint;
    }

    /**
     * Get a list of prices.
     *
     * @param array $parameters
     *
     * @return array
     *
     * @throws ResponseException
     */
    public function getAll($parameters = array())
    {
        return $this->callListEndpoint(__METHOD__);
    }
}
