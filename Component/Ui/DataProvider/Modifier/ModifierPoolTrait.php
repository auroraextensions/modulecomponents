<?php
/**
 * ModifierPoolTrait.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package       AuroraExtensions\ModuleComponents\Component\Ui\DataProvider\Modifier
 * @copyright     Copyright (C) 2020 Aurora Extensions <support@auroraextensions.com>
 * @license       MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Component\Ui\DataProvider\Modifier;

use Magento\Ui\DataProvider\Modifier\PoolInterface;

/**
 * @api
 * @since 100.0.0
 */
trait ModifierPoolTrait
{
    /** @var PoolInterface $modifierPool */
    private $modifierPool;

    /**
     * @return PoolInterface
     */
    private function getModifierPool(): PoolInterface
    {
        return $this->modifierPool;
    }

    /**
     * @return ModifierInterface[]
     */
    private function getModifiers(): array
    {
        return $this->modifierPool->getModifiersInstances();
    }
}
