<?php

namespace jdubreville\dnsimple;

/**
 * The DomainRecords class providers support for reading, creating, updating and deleting
 * domain records.
 */
class DomainRecords extends SubClientAbstract
{
    const OBJ_NAME = 'record';

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
     * Get the parent object name.
     *
     * @return string
     */
    protected function getParentObjectName()
    {
        return 'domains';
    }

    /**
     * Get the sub endpoint for the service.
     *
     * @param mixed $id
     *
     * @return string
     */
    public function getSubEndpoint($id = null)
    {
        $endPoint = 'records';
        if (isset($id)) {
            $endPoint .= '/'.$id;
        }

        return $endPoint;
    }

    /**
     * Get all domain records.
     *
     * @param array $parameters
     *
     * @return array An array of objects representing a domain's records
     *
     * @throws ResponseException
     */
    public function getAll($parameters = array())
    {
        return $this->callListEndpoint(__METHOD__, $parameters);
    }

    /**
     * Get all domain records.
     *
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
     * Create a domain record.
     *
     * @param array $parameters Key value pair of parameters to pass
     *
     * @return stdClass
     *
     * @throws ResponseException
     */
    public function create($parameters = array())
    {
        $this->ensureParameters(__METHOD__, $parameters, array('name', 'record_type', 'content'));

        return $this->callCreateItemEndpoint(__METHOD__, array('record' => $parameters));
    }

    /**
     * Update a domain record.
     *
     * @param array $parameters Key value pair of parameters to pass
     *
     * @return stdClass
     *
     * @throws ResponseException
     */
    public function update($parameters = array())
    {
        return $this->callUpdateItemEndpoint(__METHOD__, array('record' => $parameters));
    }

    /**
     * Delete a domain record.
     *
     * @param array $parameters Key value pair of parameters
     *
     * @throws ResponseException
     */
    public function delete($parameters = array())
    {
        $this->callDeleteItemEndpoint(__METHOD__, $parameters);
    }
}
