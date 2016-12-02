<?php

namespace jdubreville\dnsimple;

/**
 * The SubClientAbstract class provides functions to call sub item services.
 */
abstract class SubClientAbstract extends ClientAbstract
{
    /**
     * Get the parent object name.
     *
     * @return string
     */
    abstract protected function getParentObjectName();

    /**
     * Get the endpoint for the service.
     *
     * @param mixed $id
     *
     * @return string
     */
    abstract public function getSubEndpoint($id = null);

    /**
     * Get the endpoint for the service.
     *
     * @param mixed $id
     *
     * @return string
     */
    public function getEndpoint($id = null)
    {
        $obj = $this->getParentObjectName();
        $parentId = $this->client->$obj()->getLastId();
        $this->client->$obj()->setLastId(null);

        return $this->client->$obj()->getEndpoint($parentId).'/'.$this->getSubEndpoint($id);
    }
}
