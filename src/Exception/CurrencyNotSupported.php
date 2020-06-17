<?php

/*
 * Este módulo foi desenvolvido por EximiaWeb
 */

namespace Payment\Exception;

/**
 * Exceção para forma de pagamento não suportada
 *
 * @author Rodrigo Teixeira Andreotti <ro.andriotti@gmail.com>
 */
class CurrencyNotSupported extends \RuntimeException
{
    public function __construct(string $message = "", int $code = 0)
    {
        return parent::__construct($message, $code);
    }

}
