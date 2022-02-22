<?php

/**
 * Part of the Instasent Laravel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Instasent Laravel
 * @version    1.0.0
 * @author     Jose Lorente
 * @license    BSD License (3-clause)
 * @copyright  (c) 2018, Jose Lorente
 */

namespace HomedoctorEs\Laravel\Instasent\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Instasent Facade.
 *
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class Instasent extends Facade
{

    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'instasent';
    }

}
