<?php

namespace DivixUtils\Zend\Paginator;

class Paginator extends \Zend\Paginator\Paginator
{   
    /**
     * Get the internal cache id
     * Depends on the adapter and the item count per page
     *
     * Used to tag that unique Paginator instance in cache
     *
     * @return string
     */
    protected function _getCacheInternalId()
    {
        return md5(
            json_encode(
                get_object_vars($this->getAdapter())
            ) . $this->getItemCountPerPage()
        );
    }
}