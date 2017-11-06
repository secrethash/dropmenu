<?php

namespace Secrethash\Dropmenu;

/**
 * This file is part of Dropmenu,
 * a simple Dynamic Dropdown Menu Generator
 *
 * @license MIT
 * @package Secrethash/Dropmenu
 */

use Illuminate\Support\Facades\Facade;

class DropmenuFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dropmenu';
    }
}
