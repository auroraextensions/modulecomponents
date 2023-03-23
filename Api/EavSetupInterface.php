<?php
/**
 * EavSetupInterface.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Api
 * @copyright   Copyright (C) 2023 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Api;

interface EavSetupInterface
{
    /**
     * @param string $type
     * @param string $code
     * @param mixed[] $eavConfig
     * @return \AuroraExtensions\ModuleComponents\Api\EavSetupInterface
     */
    public function addAttribute(
        string $type,
        string $code,
        array $eavConfig = []
    ): EavSetupInterface;

    /**
     * @param string $code
     * @param mixed[] $config
     */
    public function addEntityType(
        string $code,
        array $config = []
    ): EavSetupInterface;

    /**
     * @param string $type
     * @param string $code
     * @return \AuroraExtensions\ModuleComponents\Api\EavSetupInterface
     */
    public function removeAttribute(
        string $type,
        string $code
    ): EavSetupInterface;

    /**
     * @param string $code
     * @return \AuroraExtensions\ModuleComponents\Api\EavSetupInterface
     */
    public function removeEntityType(string $code): EavSetupInterface;

    /**
     * @param string $type
     * @param string $code
     * @param mixed[]|string $field
     * @param mixed $value
     * @param int|null $sortOrder
     * @return \AuroraExtensions\ModuleComponents\Api\EavSetupInterface
     */
    public function updateAttribute(
        string $type,
        string $code,
        $field,
        $value = null,
        ?int $sortOrder = null
    ): EavSetupInterface;

    /**
     * @param string $code
     * @param mixed[]|string $field
     * @param mixed $value
     * @return \AuroraExtensions\ModuleComponents\Api\EavSetupInterface
     */
    public function updateEntityType(
        string $code,
        $field,
        $value = null
    ): EavSetupInterface;
}
