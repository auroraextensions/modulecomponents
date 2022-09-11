<?php
/**
 * ConfigurableFactoryInterface.php
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
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Api;

use Magento\Framework\ObjectManager\FactoryInterface;

interface ConfigurableFactoryInterface extends FactoryInterface
{
    /**
     * @param array $config
     * @return mixed
     */
    public function configure(array $config);
}
