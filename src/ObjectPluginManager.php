<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Barcode;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception\InvalidServiceException;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * Plugin manager implementation for barcode parsers.
 *
 * Enforces that barcode parsers retrieved are instances of
 * Object\AbstractObject. Additionally, it registers a number of default
 * barcode parsers.
 */
class ObjectPluginManager extends AbstractPluginManager
{
    /**
     * @var bool Ensure services are not shared (v2 property)
     */
    protected $shareByDefault = false;

    /**
     * @var bool Ensure services are not shared (v3 property)
     */
    protected $sharedByDefault = false;

    /**
     * Default set of symmetric adapters
     *
     * @var array
     */
    protected $aliases = [
        'codabar'           => Object\Codabar::class,
        'code128'           => Object\Code128::class,
        'code25'            => Object\Code25::class,
        'code25interleaved' => Object\Code25interleaved::class,
        'code39'            => Object\Code39::class,
        'ean13'             => Object\Ean13::class,
        'ean2'              => Object\Ean2::class,
        'ean5'              => Object\Ean5::class,
        'ean8'              => Object\Ean8::class,
        'error'             => Object\Error::class,
        'identcode'         => Object\Identcode::class,
        'itf14'             => Object\Itf14::class,
        'leitcode'          => Object\Leitcode::class,
        'planet'            => Object\Planet::class,
        'postnet'           => Object\Postnet::class,
        'royalmail'         => Object\Royalmail::class,
        'upca'              => Object\Upca::class,
        'upce'              => Object\Upce::class,
    ];

    protected $factories = [
        Object\Codabar::class           => InvokableFactory::class,
        Object\Code128::class           => InvokableFactory::class,
        Object\Code25::class            => InvokableFactory::class,
        Object\Code25interleaved::class => InvokableFactory::class,
        Object\Code39::class            => InvokableFactory::class,
        Object\Ean13::class             => InvokableFactory::class,
        Object\Ean2::class              => InvokableFactory::class,
        Object\Ean5::class              => InvokableFactory::class,
        Object\Ean8::class              => InvokableFactory::class,
        Object\Error::class             => InvokableFactory::class,
        Object\Identcode::class         => InvokableFactory::class,
        Object\Itf14::class             => InvokableFactory::class,
        Object\Leitcode::class          => InvokableFactory::class,
        Object\Planet::class            => InvokableFactory::class,
        Object\Postnet::class           => InvokableFactory::class,
        Object\Royalmail::class         => InvokableFactory::class,
        Object\Upca::class              => InvokableFactory::class,
        Object\Upce::class              => InvokableFactory::class
    ];

    protected $instanceOf = Object\AbstractObject::class;

    /**
     * Validate the plugin is of the expected type (v3).
     *
     * Validates against `$instanceOf`.
     *
     * @param mixed $instance
     * @throws InvalidServiceException
     */
    public function validate($instance)
    {
        if (! $instance instanceof $this->instanceOf) {
            throw new InvalidServiceException(sprintf(
                '%s can only create instances of %s; %s is invalid',
                get_class($this),
                $this->instanceOf,
                (is_object($instance) ? get_class($instance) : gettype($instance))
            ));
        }
    }

    /**
     * Validate the plugin is of the expected type (v2).
     *
     * Proxies to `validate()`.
     *
     * @param mixed $instance
     * @throws InvalidServiceException
     */
    public function validatePlugin($instance)
    {
        $this->validate($instance);
    }
}
