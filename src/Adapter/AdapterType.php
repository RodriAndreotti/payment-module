<?php

/*
 * Este módulo foi desenvolvido por EximiaWeb
 */

namespace Payment\Adapter;

/**
 * Interface com os enums para os typos de pagamento
 * @author Rodrigo Teixeira Andreotti <ro.andriotti@gmail.com>
 */
interface AdapterType
{
    const PAYPAL = 'paypal', PAGSEGURO = 'pagseguro';
}
