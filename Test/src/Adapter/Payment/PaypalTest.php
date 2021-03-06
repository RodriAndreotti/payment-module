<?php

namespace Payment\Adapter\Payment;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2019-03-04 at 21:28:19.
 */
class PaypalTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var Paypal
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $conf = require getcwd() . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'config_file.php';

        $this->object = new Paypal($conf['redirectUrl'], $conf['notificationUrl'], $conf['paypal_environment'], $conf['paypal_CliendID'], $conf['paypal_ClientSecret']);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function testIfCreate()
    {
        $this->assertInstanceOf(Paypal::class, $this->object);
    }

    public function testIfSetSender()
    {
        $payer = $this->prophesize(\Payment\Generic\Payer::class);
        $payer->getName()->willReturn('Rodrigo Teixeira Andreotti');
        $payer->getDocument()->willReturn('318.819.868-02');
        $payer->getEmail()->willReturn('ro.andriotti@gmail.com');
        $payer->getPhone()->willReturn('(11) 98224-5506');


        $this->assertInstanceOf(Paypal::class, $this->object->setPayer($payer->reveal()));
    }

    public function testIfAddProduct()
    {
        $product1 = $this->prophesize(\Payment\Generic\ProductInterface::class);
        $product1->getId()->willReturn(1);
        $product1->getPrice()->willReturn(15.30);
        $product1->getDescription()->willReturn('Hospedagem de sites');
        $product1->getCount()->willReturn(1);

        $product2 = $this->prophesize(\Payment\Generic\ProductInterface::class);
        $product2->getId()->willReturn(2);
        $product2->getPrice()->willReturn(120.00);
        $product2->getDescription()->willReturn('Memória DDR4');
        $product2->getCount()->willReturn(2);

        $this->assertInstanceOf(Paypal::class, $this->object->addProduct($product1->reveal()));
        $this->assertInstanceOf(Paypal::class, $this->object->addProduct($product2->reveal()));
    }

    public function testIfCallPay()
    {
        $payer = $this->prophesize(\Payment\Generic\Payer::class);
        $payer->getName()->willReturn('Rodrigo Teixeira Andreotti');
        $payer->getDocument()->willReturn('318.819.868-02');
        $payer->getEmail()->willReturn('ro.andriotti@gmail.com');
        $payer->getPhone()->willReturn('(11) 98224-5506');

        $this->assertInstanceOf(Paypal::class, $this->object->setPayer($payer->reveal()));

        $product1 = $this->prophesize(\Payment\Generic\ProductInterface::class);
        $product1->getId()->willReturn(1);
        $product1->getPrice()->willReturn(15.30);
        $product1->getDescription()->willReturn('Hospedagem de sites');
        $product1->getCount()->willReturn(1);

        $product2 = $this->prophesize(\Payment\Generic\ProductInterface::class);
        $product2->getId()->willReturn(2);
        $product2->getPrice()->willReturn(120.00);
        $product2->getDescription()->willReturn('Memória DDR4');
        $product2->getCount()->willReturn(2);
        
        $this->object->setReference(uniqid());


        $this->assertInstanceOf(Paypal::class, $this->object->addProduct($product1->reveal()));
        $this->assertInstanceOf(Paypal::class, $this->object->addProduct($product2->reveal()));

        $paymentUrl = $this->object->pay();

        $this->assertInternalType('string', $paymentUrl);
        $this->assertTrue(filter_var($paymentUrl, FILTER_VALIDATE_URL, array('flags' => array(
                FILTER_FLAG_PATH_REQUIRED,
                FILTER_FLAG_QUERY_REQUIRED
            )
        )) !== false);
    }

}
