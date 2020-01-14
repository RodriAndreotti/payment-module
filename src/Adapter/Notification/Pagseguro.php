<?php

/*
 * Este módulo foi desenvolvido por EximiaWeb
 */

namespace Payment\Adapter\Notification;

/**
 * Adapter to receive Pagseguro notifications
 *
 * @author Rodrigo Teixeira Andreotti <ro.andriotti@gmail.com>
 */
class Pagseguro implements NotificationAdapterInterface
{

    public function __construct($enviroment, $email, $token)
    {
        \PagSeguro\Configuration\Configure::setEnvironment($enviroment); //production or sandbox
        \PagSeguro\Configuration\Configure::setCharset('UTF-8'); // UTF-8 or ISO-8859-1
        \PagSeguro\Configuration\Configure::setLog(true, __DIR__ . '/../../Pagseguro.log');

        \PagSeguro\Configuration\Configure::setAccountCredentials(
                $email,
                $token
        );
    }

    public function receive()
    {
        try {
            if (\PagSeguro\Helpers\Xhr::hasPost()) {
                $response = \PagSeguro\Services\Transactions\Notification::check(
                                /** @var \PagSeguro\Domains\AccountCredentials | \PagSeguro\Domains\ApplicationCredentials $credential */
                                \PagSeguro\Configuration\Configure::getAccountCredentials()
                );

                return $response;
            } else {
                throw new \InvalidArgumentException($_POST);
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}
