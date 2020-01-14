<?php

/*
 * Este módulo foi desenvolvido por EximiaWeb
 */

namespace Payment\Wrapper;

/**
 * Wrapper to receive notifications from payment gateway
 *
 * @author Rodrigo Teixeira Andreotti <ro.andriotti@gmail.com>
 */
class NotificationWrapper implements \Payment\Adapter\Notification\NotificationAdapterInterface
{
    private $adapter;
    
    public function __construct(\Payment\Adapter\Notification\NotificationAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    
    public function receive()
    {
        return $this->adapter->receive();
    }

}
