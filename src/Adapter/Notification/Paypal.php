<?php

/*
 * Este módulo foi desenvolvido por EximiaWeb
 */

namespace Payment\Adapter\Notification;

/**
 * Adapter to receive PayPay notifications
 *
 * @author Rodrigo Teixeira Andreotti <ro.andriotti@gmail.com>
 */
class Paypal implements NotificationAdapterInterface
{

    const IPN_URL = 'https://ipnpb.paypal.com/cgi-bin/webscr';
    const IPN_SANDBOX_URL = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';

    private $environment;
    
    private $wid;
    private $context;

    public function __construct( $enviroment, $cliendID, $clientSecret, $webhookId)
    {
        $this->environment = $environment;

        $context = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential($cliendID, $clientSecret));
        $context->setConfig(array(
            'mode' => $enviroment,
            'log.LogEnabled' => true,
            'log.FileName' => __DIR__ . '/../../PayPal.log',
            'log.LogLevel' => 'DEBUG'
        ));
        
        $this->wid = $webhookId;
        $this->context = $context;
    }

    public function receive()
    {
        $headers = array_change_key_case(getallheaders(), CASE_UPPER);
        $body = file_get_contents('php://input');

        $signatureVerification = new \PayPal\Api\VerifyWebhookSignature();

        $signatureVerification->setAuthAlgo($headers['PAYPAL-AUTH-ALGO']);
        $signatureVerification->setTransmissionId($headers['PAYPAL-TRANSMISSION-ID']);
        $signatureVerification->setCertUrl($headers['PAYPAL-CERT-URL']);
        $signatureVerification->setWebhookId($this->wid); // Note that the Webhook ID must be a currently valid Webhook that you created with your client ID/secret. 
        $signatureVerification->setTransmissionSig($headers['PAYPAL-TRANSMISSION-SIG']);
        $signatureVerification->setTransmissionTime($headers['PAYPAL-TRANSMISSION-TIME']);
        $signatureVerification->setRequestBody($body);

        try {
            /** @var \PayPal\Api\VerifyWebhookSignatureResponse $output */
            $response = $signatureVerification->post($this->context);

            return $response;
        } catch (Exception $ex) {
            
        }
    }

}
