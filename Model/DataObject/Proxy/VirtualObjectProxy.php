<?php
/**
 * VirtualObjectProxy.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Model\DataObject\Proxy
 * @copyright   Copyright (C) 2023 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\DataObject\Proxy;

use AuroraExtensions\ModuleComponents\Api\ConfigurableFactoryInterface;
use AuroraExtensions\ModuleComponents\Api\ObjectProxyInterface;
use AuroraExtensions\ModuleComponents\Model\DataObject\VirtualCompositeObject;
use Magento\Framework\ObjectManager\NoninterceptableInterface;

class VirtualObjectProxy extends VirtualCompositeObject implements
    NoninterceptableInterface,
    ObjectProxyInterface
{
    /** @var ConfigurableFactoryInterface $factory */
    private $factory;

    /**
     * @param ConfigurableFactoryInterface $factory
     * @param array $classes
     * @param array $methods
     * @param array $aliases
     * @return void
     */
    public function __construct(
        ConfigurableFactoryInterface $factory,
        array $classes = [],
        array $methods = [],
        array $aliases = []
    ) {
        $this->factory = $factory;
        parent::__construct(
            $this->buildObjects($classes),
            $methods,
            $aliases
        );
    }

    /**
     * @param string[] $classes
     * @return object[]
     */
    private function buildObjects(array $classes): array
    {
        /** @var object[] $result */
        $result = [];

        /** @var string $name */
        /** @var string $type */
        foreach ($classes as $name => $type) {
            $result[$name] = $this->factory->create($type);
        }

        return $result;
    }
}
