<?php
/**
 * EntityResourceInterface.php
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

use Magento\Framework\Model\AbstractModel;

interface EntityResourceInterface extends AbstractResourceInterface
{
    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getIdFieldName();

    /**
     * @return string
     */
    public function getMainTable();

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     * @param mixed $value
     * @param string|null $field
     * @return \AuroraExtensions\ModuleComponents\Api\EntityResourceInterface
     */
    public function load(
        AbstractModel $object,
        $value,
        $field = null
    );

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return \AuroraExtensions\ModuleComponents\Api\EntityResourceInterface
     */
    public function save(AbstractModel $object);

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return \AuroraExtensions\ModuleComponents\Api\EntityResourceInterface
     */
    public function delete(AbstractModel $object);
}
