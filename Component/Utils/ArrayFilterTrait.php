<?php
/**
 * ArrayFilterTrait.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package       AuroraExtensions\ModuleComponents\Component\Utils
 * @copyright     Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license       MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Component\Utils;

use function in_array;

/**
 * @api
 * @since 100.1.0
 */
trait ArrayFilterTrait
{
    /**
     * @param array $data
     * @param array $keys
     * @return array
     */
    private function filterKeys(
        array $data,
        array $keys = []
    ): array {
        /** @var array $result */
        $result = [];

        /** @var int|string $key */
        /** @var mixed $value */
        foreach ($data as $key => $value) {
            if (!in_array($key, $keys)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * @param array $data
     * @param array $values
     * @return array
     */
    private function filterValues(
        array $data,
        array $values = []
    ): array {
        /** @var array $result */
        $result = [];

        /** @var int|string $key */
        /** @var mixed $value */
        foreach ($data as $key => $value) {
            if (!in_array($value, $values)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
