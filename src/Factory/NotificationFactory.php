<?php

/*
 * Este módulo foi desenvolvido por EximiaWeb
 */

namespace Payment\Factory;

/**
 * Description of NotificationFactory
 *
 * @author Rodrigo Teixeira Andreotti <ro.andriotti@gmail.com>
 */
class NotificationFactory
{
    private $config = null;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function createPaymentWrapper(string $method)
    {
        switch ($method) {
            case \Payment\Adapter\AdapterType::PAGSEGURO:
                $adapter = new \Payment\Adapter\Notification\Pagseguro($config);
                break;
            case \Payment\Adapter\AdapterType::PAYPAL:
                $adapter = new \Payment\Adapter\Notification\Paypal($config);
                break;
            default:
                throw new PaymentMethodNotSupported('Notification Gateway not supported', 4558);
        }
        
        return new \Payment\Wrapper\NotificationWrapper($adapter);
    }
}
