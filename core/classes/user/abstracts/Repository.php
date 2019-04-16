<?php

namespace Core\User\Abstracts;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Core\Models\ModelUser;

abstract class Repository extends ModelUser {

    const REGISTER_SUCCESS = 1;
    const REGISTER_ERR_EXISTS = -1;

    /**
     * Patikrinam are user'is su tokiu email'u egzistuoja
     * Jeigu ne, tada įtraukiam jį į duombazę ir
     * returniname REGISTER_SUCCESS
     * Jeigu egzistuoja, returniname REGISTER_ERR_EXISTS
     *
     * @param \Core\User\User $user
     * @return mixed
     */
    abstract public function register(\Core\User\User $user);

}