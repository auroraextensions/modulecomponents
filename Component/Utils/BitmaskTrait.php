<?php
/**
 * BitmaskTrait.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Component\Utils
 * @copyright   Copyright (C) 2021 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Component\Utils;

/**
 * @since 100.0.6
 */
trait BitmaskTrait
{
    /** @var int $bitmask */
    private $bitmask;

    /**
     * @param int $bits
     * @return bool
     */
    private function hasBits(int $bits): bool
    {
        return ($this->bitmask & $bits) === $bits;
    }

    /**
     * @param int $bits
     * @param bool|int $value
     * @return void
     */
    private function setBits(int $bits, $value): void
    {
        if ($value) {
            $this->bitmask |= $bits;
        } else {
            $this->bitmask &= ~$bits;
        }
    }
}
