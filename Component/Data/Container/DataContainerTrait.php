<?php
/**
 * DataContainerTrait.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package       AuroraExtensions_ModuleComponents
 * @copyright     Copyright (C) 2020 Aurora Extensions <support@auroraextensions.com>
 * @license       MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Component\Data\Container;

use Magento\Framework\DataObject;

trait DataContainerTrait
{
    /** @property DataObject $container */
    private $container;

    /**
     * @return DataObject|null
     */
    private function getContainer(): ?DataObject
    {
        return $this->container;
    }

    /**
     * @param DataObject|null
     * @return $this
     */
    private function setContainer(?DataObject $container)
    {
        $this->container = $container;
        return $this;
    }
}
