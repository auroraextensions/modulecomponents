<?php
/**
 * AbstractEavSetup.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Model\Eav\Setup
 * @copyright   Copyright (C) 2023 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\Eav\Setup;

use AuroraExtensions\ModuleComponents\Api\EavSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Psr\Log\LoggerInterface;
use Throwable;

abstract class AbstractEavSetup implements EavSetupInterface
{
    /** @var EavSetup $eavSetup */
    private $eavSetup;

    /** @var LoggerInterface $logger */
    private $logger;

    /**
     * @param EavSetup $eavSetup
     * @param LoggerInterface $logger
     * @return void
     */
    public function __construct(
        EavSetup $eavSetup,
        LoggerInterface $logger
    ) {
        $this->eavSetup = $eavSetup;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function addAttribute(
        string $type,
        string $code,
        array $eavConfig = []
    ): EavSetupInterface {
        try {
            $this->eavSetup->addAttribute(
                $type,
                $code,
                $eavConfig
            );
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addEntityType(
        string $code,
        array $config = []
    ): EavSetupInterface {
        try {
            $this->eavSetup->addEntityType($code, $config);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAttribute(
        string $type,
        string $code
    ): EavSetupInterface {
        try {
            $this->eavSetup->removeAttribute($type, $code);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeEntityType(string $code): EavSetupInterface
    {
        try {
            $this->eavSetup->removeEntityType($code);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function updateAttribute(
        string $type,
        string $code,
        $field,
        $value = null,
        ?int $sortOrder = null
    ): EavSetupInterface {
        try {
            $this->eavSetup->updateAttribute(
                $type,
                $code,
                $field,
                $value,
                $sortOrder
            );
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function updateEntityType(
        string $code,
        $field,
        $value = null
    ): EavSetupInterface {
        try {
            $this->eavSetup->updateEntityType(
                $code,
                $field,
                $value
            );
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        return $this;
    }
}
