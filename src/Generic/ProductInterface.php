<?php

/*
 * Este módulo foi desenvolvido por EximiaWeb
 */

namespace Payment\Generic;

/**
 * Inteface genérica para produtos / serviços
 * @author Rodrigo Teixeira Andreotti <ro.andriotti@gmail.com>
 */
interface ProductInterface
{
    public function getId();
    public function getPrice();
    public function getDescription();
    public function getCount();
    
}
