<?php
/**
 * AreaConfigProviderInterface.php
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

use Magento\Framework\App\Area;

interface AreaConfigProviderInterface
{
    /**
     * @param string $areaCode
     * @return array|null
     */
    public function get(string $areaCode = Area::AREA_GLOBAL): ?array;
}
