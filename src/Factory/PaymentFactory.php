<?php

/*
 * Este módulo foi desenvolvido por EximiaWeb
 */

namespace Payment\Factory;

/**
 * Factory for Payment Wrapper
 * 
 * @author Rodrigo Teixeira Andreotti <ro.andriotti@gmail.com>
 */
class PaymentFactory
{

    private $config = null;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function createPaymentWrapper($method)
    {
        switch ($method) {
            case \Payment\Adapter\AdapterType::PAGSEGURO:
                $adapter = new \Payment\Adapter\Payment\Pagseguro($this->config);
                break;
            case \Payment\Adapter\AdapterType::PAYPAL:
                $adapter = new \Payment\Adapter\Payment\Paypal($this->config);
                break;
            default:
                throw new PaymentMethodNotSupported('Payment Gateway not supported', 4557);
        }
        
        return new \Payment\Wrapper\PaymentWrapper($adapter);
    }

}
