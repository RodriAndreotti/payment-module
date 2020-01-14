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
class Paypal implements PaymentAdapterInterface
{

    /**
     *
     * @var \PayPal\Rest\ApiContext 
     */
    private $context;

    /**
     *
     * @var PayPal\Api\Payment 
     */
    private $payment;

    /**
     *
     * @var \PayPal\Api\ItemList
     */
    private $itemList;
    
    /**
     *
     * @var string 
     */
    private $invoiceNumber;

    public function __construct($redirectUrl, $cancelUrl, $enviroment, $cliendID, $clientSecret, $invoiceNumber = null)
    {
        $this->invoiceNumber = $invoiceNumber;
        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls
                ->setReturnUrl($redirectUrl)
                ->setCancelUrl($cancelUrl);

        $context = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential($cliendID, $clientSecret));
        $context->setConfig(array(
            'mode'  =>  $enviroment,
            'log.LogEnabled' => true,
            'log.FileName' => __DIR__ . '/../../PayPal.log',
            'log.LogLevel' => 'DEBUG'
        ));


        $this->context = $context;
        $this->payment = new \PayPal\Api\Payment();
        $this->payment->setIntent('authorize');
        $this->payment->setRedirectUrls($redirectUrls);
        $this->itemList = new \PayPal\Api\ItemList();
    }

    public function addProduct(\Payment\Generic\ProductInterface $product, $currency = 'BRL')
    {
        $item = new \PayPal\Api\Item();
        $item
                ->setCurrency($currency)
                ->setName($product->getDescription())
                ->setDescription($product->getDescription())
                ->setQuantity($product->getCount())
                ->setPrice((float)$product->getPrice());

        $this->itemList->addItem($item);

        return $this;
    }

    public function pay()
    {
        $ammount = new \PayPal\Api\Amount();

        $total = 0;
        foreach ($this->itemList->getItems() as $item) {

            $total = bcadd($total, (bcmul($item->getQuantity(),$item->getPrice(),2)),2);
        }
        
        $detail = new \PayPal\Api\Details();
        $detail
                ->setShipping(0)
                ->setTax(0)
                ->setSubtotal($total);
        
        
        
        $ammount
                ->setCurrency('BRL')
                ->setDetails($detail)
                ->setTotal((float)$total);

        $transaction = new \PayPal\Api\Transaction();
        $transaction
                ->setAmount($ammount)
                ->setItemList($this->itemList)
                ->setInvoiceNumber($this->invoiceNumber ?: uniqid());
        
        

        $this->payment->setTransactions(array($transaction));

        try {
            $this->payment->create($this->context);

            return $this->payment->getApprovalLink();
        } catch (\Exception $ex) {

        }
    }

    public function setPayer(\Payment\Generic\Payer $payer)
    {
        $myPayer = new \PayPal\Api\Payer();
        $myPayer->setPaymentMethod('paypal');

        $nameParts = explode(' ', $payer->getName());


        $payerInfo = new \PayPal\Api\PayerInfo();
        $payerInfo->setEmail($payer->getEmail());
        
        $payerInfo->setFirstName($nameParts[0]);
        if (count($nameParts) > 1) {
            

            if (count($nameParts) > 2) {
                $middleName = '';
                $ctn = 0;
                foreach ($nameParts as $key => $part) {
                    if ($key > 0 && $key < count($nameParts)-1) {
                        if ($ctn > 0) {
                            $middleName .= ' ';
                        }
                        $middleName .= $part;
                        $ctn++;
                    }
                }
                $payerInfo->setLastName($middleName . ' ' . $nameParts[count($nameParts) - 1]);
            } else {
                $payerInfo->setLastName($nameParts[count($nameParts) - 1]);
            }
        }



        $myPayer->setPayerInfo($payerInfo);

        $this->payment->setPayer($myPayer);

        return $this;
    }

    public function setReference(string $codReference)
    {
        //$this->payment->
    }

}
