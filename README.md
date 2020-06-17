
# payment-module
Módulo para pagamentos muiti-gateway que abstrai as particularidades de cada api proprietária em uma interface comum, simplificando a implementação de vários Gateways de pagamento


# Meios de pagamento suportados:
- PagSeguro
- PayPal

# Forma de uso Uso

### Implementando as interfaces
- Implemente a interface \Payment\Generic\ProductInterface nos produtos que poderão ser pagos através do módulo
- Implemente a interface \Payment\Generic\Payer em sua classe de cliente

### Configuração para o os meios de pagamento


    $config = array(
        // PagSeguro
        'pagseguro_email' => 'email_assigned_to_your_account',
        'pagseguro_token' => 'your_app_token',
        'pagseguro_environment' => 'sandbox', // or production


        // Paypal
        'paypal_cancelUrl'  =>  'url_to_redirect_on_cancel_button_clicked',
        'paypal_CliendID' => 'your_client_id',
        'paypal_ClientSecret' => 'your_client_secret',
        'paypal_environment' => 'sandbox', // or production

        // General
        'redirectUrl' => 'url_to_redirect_after_payment',
        'notificationUrl' => 'url_to_notify_payment_status_changes',
        'nome' => 'your_app_name',
        'version' => 'your_app_version',
    );

### Chamando o método de pagamento

    $paymentfactory = new \Payment\Factory\PaymentFactory($config);
    $gateway = $paymentfactory->createPaymentWrapper(\Payment\Adapter\AdapterType::PAYPAL);
    
    // repetir esta linha para todos os produtos
    $gateway->addProduct($produto, 'BRL');

    // Define o cliente
    $gateway->setPayer($cliente);
    
    // Chama o método de pagamento
    $paymentUrl = $gateway->pay();

O retorno do método pay() será a url de pagamento para a qual o usuário deverá ser redirecionado para realizar o pagamento.
