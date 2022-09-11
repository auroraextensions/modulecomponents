<?php
/**
 * VirtualCompositeObject.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Model\DataObject
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\DataObject;

use AuroraExtensions\ModuleComponents\Api\CompositeObjectInterface;
use AuroraExtensions\ModuleComponents\Model\DataObject\Pool\VirtualObjectPool;

use function is_callable;

class VirtualCompositeObject extends VirtualObjectPool implements CompositeObjectInterface
{
    /** @var string[] $aliases */
    private $aliases;

    /** @var string[] $methods */
    private $methods;

    /**
     * @param object[] $objects
     * @param string[] $methods
     * @param string[] $aliases
     * @return void
     */
    public function __construct(
        array $objects = [],
        array $methods = [],
        array $aliases = []
    ) {
        parent::__construct($objects);
        $this->methods = $methods;
        $this->aliases = $aliases;
    }

    /**
     * @inheritdoc
     */
    public function resolve(string $method)
    {
        /** @var string $func */
        $func = $this->methods[$method] ?? $method;

        /** @var string|null $alias */
        $alias = $this->aliases[$method] ?? null;

        if (!empty($alias)) {
            /** @var object|null $callee */
            $callee = $this->getObject($alias);

            if ($callee !== null
                && is_callable([$callee, $func])
            ) {
                return $callee;
            }
        }

        /** @var object $object */
        foreach ($this->getObjects() as $object) {
            if (is_callable([$object, $func])) {
                return $object;
            }
        }

        return null;
    }

    /**
     * @param string $name
     * @param array $args
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function __call(string $name, array $args)
    {
        /** @var object|null $object */
        $object = $this->resolve($name);

        /** @var string $method */
        $method = $this->methods[$name] ?? $name;
        return $object !== null
            ? $object->{$method}(...$args) : null;
    }
}
