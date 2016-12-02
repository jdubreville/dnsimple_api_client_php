<?php

namespace jdubreville\dnsimple;

/**
 * The Users class exposes method for creating user data.
 */
class Users extends ClientAbstract
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
     * Create a user.
     *
     * @param array $parameters Key value pair of parameters to pass
     *
     * @return \stdClass
     *
     * @throws ResponseException
     */
    public function create($parameters = array())
    {
        $this->ensureParameters(__METHOD__, $parameters, array('email', 'password', 'password_confirmation'));
        //return $this->callCreateItemEndpoint(__METHOD__,array( "user" => $parameters));
        return $this->callUpdateItemEndpoint(__METHOD__, array('user' => $parameters));
    }

    /**
     * Update a contact.
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
