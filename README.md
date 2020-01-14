# payment-module
Módulo para pagamentos muiti-gateway que abstrai as particularidades de cada api proprietária em uma interface comum, simplificando a implementação de vários Gateways de pagamento


# Meios de pagamento suportados:
- PagSeguro
- PayPal

# Forma de uso Uso

### Implementando as interfaces
- Implemente a interface \Payment\Generic\ProductInterface nos produtos que poderão ser pagos através do módulo
- Implemente a interface \Payment\Generic\Payer em sua classe de cliente

### Configuração para o PagSeguro
$conf = array(
    'email' => 'seu_email',
    'token' => 'seu_token',
    'environment' => 'sandbox',
    'nome' => 'EximiaControl',
    'version' => '1.0'
);

### Configuração para o PayPal
$conf = array(
    'CliendID' => 'seu_client_ID',
    'ClientSecret' => 'seu_client_secret',
    'environment' => 'sandbox',
);

$paymentfactory = new \Payment\Factory\PaymentFactory($config);
$gateway = $paymentfactory->createPaymentWrapper(\Payment\Adapter\AdapterType::PAYPAL);


$gateway->addProduct();