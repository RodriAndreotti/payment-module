<?php

/*
 * Este módulo foi desenvolvido por EximiaWeb
 */

namespace Payment\Adapter\Payment;

/**
 * Adapter para integração com o Paypal
 *
 * @author Rodrigo Teixeira Andreotti <ro.andriotti@gmail.com>
 */
class Pagseguro implements PaymentAdapterInterface
{

    private $paymentClient;

    public function __construct($redirectUrl, $notificationUrl, $enviroment, $email, $token, $nome, $version)
    {
        $this->redirectUrl = $redirectUrl;
        $this->notificationUrl = $notificationUrl;


        //$this->client = new Sessi


        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName($nome)->setRelease($version);
        \PagSeguro\Library::moduleVersion()->setName("Payment")->setRelease(\Payment\Module::MODULE_VERSION);


        \PagSeguro\Configuration\Configure::setEnvironment($enviroment); //production or sandbox
        \PagSeguro\Configuration\Configure::setCharset('UTF-8'); // UTF-8 or ISO-8859-1
        \PagSeguro\Configuration\Configure::setLog(true, __DIR__ . '/../../Pagseguro.log');

        \PagSeguro\Configuration\Configure::setAccountCredentials(
                $email,
                $token
        );




        $this->paymentClient = new \PagSeguro\Domains\Requests\Payment();

        $this->paymentClient->setCurrency('BRL');

        // Set URL's
        $this->paymentClient->setRedirectUrl($redirectUrl);
        $this->paymentClient->setNotificationUrl($notificationUrl);
    }

    public function addProduct(\Payment\Generic\ProductInterface $product, $currency = 'BRL')
    {
        if ($currency != 'BRL') {
            throw new CurrencyNotSupported('O PagSeguro só aceita pagamento em Real Brasileiro');
        }
        $this->paymentClient->addItems()->withParameters(
                $product->getId(),
                $product->getDescription(),
                $product->getCount(),
                $product->getPrice()
        );

        return $this;
    }

    public function pay()
    {
        if (count($this->paymentClient->getItems()) == 0) {
            return false;
        }
        if (null == $this->paymentClient->getSender()) {
            return false;
        }

        try {

            $result = $this->paymentClient->register(
                    \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            return $result;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function setReference(string $codReference)
    {
        $this->paymentClient->setReference($codReference);
        return $this;
    }

    public function setPayer(\Payment\Generic\Payer $payer)
    {
        $this->paymentClient->setSender()->setName($payer->getName());
        $this->paymentClient->setSender()->setEmail($payer->getEmail());
        $this->paymentClient->setSender()->setPhone($payer->getPhone());
        $this->paymentClient->setSender()->setDocument($payer->getDocument());
        return $this;
    }

}
