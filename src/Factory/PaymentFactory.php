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
                $adapter = new \Payment\Adapter\Payment\Pagseguro(
                        $this->config['redirectUrl'], 
                        $this->config['notificationUrl'], 
                        $this->config['pagseguro_environment'], 
                        $this->config['pagseguro_email'], 
                        $this->config['pagseguro_token'], 
                        $this->config['nome'], 
                        $this->config['version']
                        );
                break;
            case \Payment\Adapter\AdapterType::PAYPAL:
                $adapter = new \Payment\Adapter\Payment\Paypal(
                        $this->config['redirectUrl'], 
                        $this->config['paypal_cancelUrl'], 
                        $this->config['paypal_environment'], 
                        $this->config['paypal_CliendID'], 
                        $this->config['paypal_ClientSecret']
                        );
                break;
            default:
                throw new \Payment\Exception\PaymentMethodNotSupported('Payment Gateway not supported', 4557);
        }
        
        return new \Payment\Wrapper\PaymentWrapper($adapter);
    }

}
