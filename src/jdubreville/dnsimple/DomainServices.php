<?php

namespace jdubreville\dnsimple;

/**
 * The DomainRecords class providers support for reading, creating, updating and deleting
 * domain records.
 */
class DomainServices extends SubClientAbstract
{
    const OBJ_NAME = 'service';

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
        $endPoint = 'applied_services';
        if (isset($id)) {
            $endPoint .= '/'.$id;
        }

        return $endPoint;
    }

    /**
     * Get a list of services applied to the domain.
     *
     * @param array $parameters
     *
     * @return array
     *
     * @throws ResponseException
     */
    public function getApplied($parameters = array())
    {
        return $this->callListEndpoint(__METHOD__);
    }

    /**
     * Get a list of a available services.
     *
     * @param array $parameters
     *
     * @return array
     *
     * @throws ResponseException
     */
    public function getAvailable($parameters = array())
    {
        return $this->callEndpoint(__METHOD__, $this->ensureLastId(__METHOD__), $parameters, 'GET', 'available_services');
    }

    /**
     * Apply a service to a domain.
     *
     * @param array $parameters Key value pair of parameters to pass
     *
     * @return \stdClass
     *
     * @throws ResponseException
     */
    public function apply($parameters = array())
    {
        $this->ensureParameters(__METHOD__, $parameters, array('id'));

        return $this->callCreateItemEndpoint(__METHOD__, array('service' => $parameters));
    }

    /**
     * Unapply a service to a domain.
     *
     * @param array $parameters Key value pair of parameters
     *
     * @throws ResponseException
     */
    public function unapply($parameters = array())
    {
        $this->callDeleteItemEndpoint(__METHOD__, $parameters);
    }
}
