<?php
/**
 * VirtualObjectPool.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Model\DataObject\Pool
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\DataObject\Pool;

use InvalidArgumentException;
use AuroraExtensions\ModuleComponents\Api\ObjectPoolInterface;

use function array_filter;
use function array_intersect;
use function class_implements;
use function gettype;
use function implode;
use function is_object;
use function sprintf;

class VirtualObjectPool implements ObjectPoolInterface
{
    /** @var object[] $objects */
    private $objects;

    /** @var string[] $implements */
    private $implements;

    /**
     * @param object[] $objects
     * @param string[] $implements
     * @return void
     */
    public function __construct(
        array $objects = [],
        array $implements = []
    ) {
        $this->objects = $objects;
        $this->implements = array_filter(
            $implements,
            'interface_exists'
        );
        $this->initialize();
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    private function initialize(): void
    {
        /** @var string $name */
        /** @var object $object */
        foreach ($this->objects as $name => $object) {
            if (!is_object($object)) {
                throw new InvalidArgumentException(
                    sprintf(
                        '[%s] must be an object, "%s" given',
                        $name,
                        gettype($object) // phpcs:ignore Magento2.Functions.DiscouragedFunction
                    )
                );
            }

            /** @var string[] $implements */
            $implements = array_intersect(
                $this->implements,
                class_implements($object)
            );

            if (!empty($this->implements) && $implements !== $this->implements) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Object [%s] must implement (%s)',
                        $name,
                        implode('&', $this->implements)
                    )
                );
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function getObject(string $name)
    {
        return $this->objects[$name] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function getObjects(): array
    {
        return $this->objects;
    }
}
