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

    /**
     * Adiciona um produto ao adapter
     * @param \Payment\Generic\ProductInterface $product
     * @param string $currency
     * @return \Payment\Adapter\Payment\PaymentAdapterInterface
     */
    public function addProduct(\Payment\Generic\ProductInterface $product, $currency = 'BRL')
    {
        return $this->adapter->addProduct($product, $currency);
    }

    
    /**
     * Inicializa o processo de pagamento
     * @return string Link de pagamento
     */
    public function pay()
    {
        return $this->adapter->pay();
    }

    /**
     * Configura o cliente (pagador) da requisição de pagamento
     * @param \Payment\Generic\Payer $payer
     * @return \Payment\Adapter\Payment\PaymentAdapterInterface
     */
    public function setPayer(\Payment\Generic\Payer $payer)
    {
        return $this->adapter->setPayer($payer);
    }

    /**
     * Configura o código de referência do pagamento, para futura notificação de alteração de status
     * @param string $codReferenc
     * @return \Payment\Adapter\Payment\PaymentAdapterInterface
     */
    public function setReference(string $codReferenc)
    {
        return $this->adapter->setReference($codReferenc);
    }

}
