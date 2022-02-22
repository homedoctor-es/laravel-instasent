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

namespace HomedoctorEs\Laravel\Instasent;

use Illuminate\Support\ServiceProvider;
use HomedoctorEs\Laravel\Instasent\Instasent;

/**
 * Class InstasentServiceProvider.
 * 
 * Register the provider in the app config file in order to use the Facade and 
 * the injection of the service container.
 *
 * You must add the configuration of your instasent account to the configuration 
 * file.
 * 
 * config/services.php
 * ```php
 * //other services
 * 'instasent' => [
 *     'api_token' => 'YOUR ACCOUNT API TOKEN',
 * ],
 * ```
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class InstasentServiceProvider extends ServiceProvider
{

    /**
     * @inheritdoc
     */
    protected $defer = true;

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->app->singleton('instasent', function ($app) {
            $config = $app['config']->get('services.instasent');
            return new Instasent($config['api_token']);
        });
        $this->app->alias('instasent', Instasent::class);
    }

    /**
     * {@inheritDoc}
     */
    public function provides()
    {
        return [
            'instasent'
            , Instasent::class
        ];
    }

}
