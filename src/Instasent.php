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

use ReflectionClass;

/**
 * Class Instasent.
 *
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class Instasent
{

    /**
     * Instasent token.
     *
     * @var string
     */
    protected $token;

    /**
     * 
     * @param string $token
     */
    public function __construct($token)
    {
        $this->setToken($token);
    }

    /**
     * 
     * @param string $token
     * @return \static
     */
    public static function make($token)
    {
        return new static($token);
    }

    /**
     * Returns the token used in the api communication.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Sets the token used in the api communication.
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Dynamically handle missing methods.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return \HomedoctorEs\Appsflyer\Api\ApiInterface
     */
    public function __call($method, array $parameters)
    {
        return $this->getApiInstance($method, $parameters);
    }

    /**
     * Returns the Api class instance for the given method.
     *
     * @param  string  $method
     * @return mixed An essendex service
     * @throws \BadMethodCallException
     */
    protected function getApiInstance($method, array $parameters = null)
    {        
        $class = "\\Instasent\\" . ucwords($method);

        if (class_exists($class) && !(new ReflectionClass($class))->isAbstract()) {
            $r = new ReflectionClass($class);
            array_unshift($parameters, $this->token);

            return $r->newInstanceArgs($parameters);
        }
        throw new \BadMethodCallException("Undefined method [{$method}] called.");
    }

}
