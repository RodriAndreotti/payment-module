<?php

/*
 * Este módulo foi desenvolvido por EximiaWeb
 */

namespace Payment\Generic;

/**
 * Interface genérica para o pagador
 * 
 * @author Rodrigo Teixeira Andreotti <ro.andriotti@gmail.com>
 */
interface Payer
{
    public function getName();
    
    public function getEmail();

    public function getPhone();

    public function getDocument();

}
