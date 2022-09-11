<?php
/**
 * VirtualConfigurableFactory.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Model\DataObject\Factory
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\DataObject\Factory;

use AuroraExtensions\ModuleComponents\Api\ConfigurableFactoryInterface;
use Laminas\Hydrator\HydrationInterface;
use Magento\Framework\ObjectManagerInterface;

class VirtualConfigurableFactory implements ConfigurableFactoryInterface
{
    /** @var ObjectManagerInterface $objectManager */
    private $objectManager;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param HydrationInterface|null $hydrator
     * @param array $data
     * @return void
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ?HydrationInterface $hydrator = null,
        array $data = []
    ) {
        $this->objectManager = $hydrator
            ? $hydrator->hydrate($data, $objectManager) : $objectManager;
    }

    /**
     * @inheritdoc
     */
    public function configure(array $config)
    {
        $this->objectManager->configure($config);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function create(
        $requestedType,
        array $arguments = []
    ) {
        return $this->objectManager->create(
            $requestedType,
            $arguments
        );
    }

    /**
     * @inheritdoc
     */
    public function setObjectManager(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }
}
