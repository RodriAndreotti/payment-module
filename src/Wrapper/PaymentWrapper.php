<?php

/*
 * Este módulo foi desenvolvido por EximiaWeb
 */

namespace Payment\Wrapper;

/**
 * Wrapper para pagamentos
 *
 * @author Rodrigo Teixeira Andreotti <ro.andriotti@gmail.com>
 */
class PaymentWrapper implements \Payment\Adapter\Payment\PaymentAdapterInterface
{
    private $adapter;
    
    public function __construct(\Payment\Adapter\Payment\PaymentAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function addProduct(\Payment\Generic\ProductInterface $product)
    {
        return $this->adapter->addProduct($product);
    }

    public function pay()
    {
        return $this->adapter->pay();
    }

    public function setPayer(\Payment\Generic\Payer $payer)
    {
        return $this->adapter->setPayer($payer);
    }

    public function setReference(string $codReferenc)
    {
        return $this->adapter->setReference($codReferenc);
    }

}
