<?php

namespace jdubreville\dnsimple;

/**
 * The Contacts class exposes method for reading, creating, updating and deleting contact data.
 */
class Contacts extends ClientAbstract
{
    const OBJ_NAME = 'contact';

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
        $endPoint = 'contacts';
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
        return $this->callListEndpoint(__METHOD__);
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
     * @return \stdClass
     *
     * @throws ResponseException
     */
    public function create($parameters = array())
    {
        $this->ensureParameters(__METHOD__, $parameters, array('first_name', 'last_name', 'address1', 'city', 'state_province', 'postal_code', 'country', 'email_address', 'phone'));

        return $this->callCreateItemEndpoint(__METHOD__, array('record' => $parameters));
    }

    /**
     * Update a contact.
     *
     * @param array $parameters Key value pair of parameters to pass
     *
     * @return \stdClass
     *
     * @throws ResponseException
     */
    public function update($parameters = array())
    {
        return $this->callUpdateItemEndpoint(__METHOD__, array('record' => $parameters));
    }

    /**
     * Delete a contact.
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
