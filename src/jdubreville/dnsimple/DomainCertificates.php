<?php

namespace jdubreville\dnsimple;

/**
 * The DomainCertificates class providers support for reading, creating, updating and deleting
 * domain records.
 */
class DomainCertificates extends SubClientAbstract
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
        $endPoint = 'certificates';
        if (isset($id)) {
            $endPoint .= '/'.$id;
        }

        return $endPoint;
    }

    /**
     * Get all SSL certificates for a domain.
     *
     * @param array $parameters
     *
     * @return array An array of objects representing a domain's records
     *
     * @throws ResponseException
     */
    public function getAll($parameters = array())
    {
        return $this->callListEndpoint(__METHOD__);
    }

    /**
     * Get a specific SSL certificate of a domain.
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
     * Purchase a SSL certificate for a domain.
     *
     * @param array $parameters Key value pair of parameters to pass
     *
     * @return stdClass
     *
     * @throws ResponseException
     */
    public function purchase($parameters = array())
    {
        $this->ensureParameters(__METHOD__, $parameters, array('name', 'contact_id'));

        return $this->callCreateItemEndpoint(__METHOD__, array('certificate' => $parameters));
    }

    /**
     * Configured a domain's purchased certificate.
     *
     * @param array $parameters Key value pair of parameters to pass
     *
     * @return \stdClass
     *
     * @throws \ResponseException
     */
    public function configure($parameters = array())
    {
        return $this->callUpdateItemFieldEndpoint(__METHOD__, 'configure', $parameters);
    }

    /**
     * Submit a domain's configured certificate for signing by the certificate authority.
     *
     * @param array $parameters Key value pair of parameters to pass
     *
     * @return \stdClass
     *
     * @throws \ResponseException
     */
    public function submit($parameters = array())
    {
        $this->ensureParameters(__METHOD__, $parameters, array('approver_email'));

        return $this->callUpdateItemFieldEndpoint(__METHOD__, 'submit', array('certificate' => $parameters));
    }
}
