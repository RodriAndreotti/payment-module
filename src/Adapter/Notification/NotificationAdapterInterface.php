<?php

/*
 * Este módulo foi desenvolvido por EximiaWeb
 */

namespace Payment\Adapter\Notification;

/**
 * Interface de pagamento com os adapters
 * @author Rodrigo Teixeira Andreotti <ro.andriotti@gmail.com>
 */
interface NotificationAdapterInterface
{
    public function receive();
}
