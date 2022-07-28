<?php
/**
 * ArrayTrait.php
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

use function array_merge;
use function is_array;

/**
 * @api
 * @since 100.0.0
 */
trait ArrayTrait
{
    /**
     * @param array $data
     * @return array
     * @deprecated Use {@see flatten()} instead.
     */
    public function flattenArray(array $data = []): array
    {
        return $this->flatten($data);
    }

    /**
     * @param array $data
     * @return array
     */
    private function flatten(array $data): array
    {
        /** @var array $result */
        $result = [];

        /** @var mixed $value */
        foreach ($data as $value) {
            if (is_array($value)) {
                // phpcs:ignore Magento2.Performance.ForeachArrayMerge
                $result = array_merge(
                    $result,
                    $this->flatten($value)
                );
            } else {
                $result[] = $value;
            }
        }

        return $result;
    }
}
