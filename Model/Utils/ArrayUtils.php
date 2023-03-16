<?php
/**
 * ArrayUtils.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Model\Utils
 * @copyright   Copyright (C) 2023 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\Utils;

use Closure;
use InvalidArgumentException;

use function array_diff_key;
use function array_filter;
use function array_flip;
use function array_intersect_key;
use function array_keys;
use function array_key_exists;
use function array_map;
use function array_pop;
use function array_slice;
use function array_values;
use function is_array;
use function is_callable;
use function ksort;
use function sort;

use const SORT_REGULAR;

class ArrayUtils
{
    /**
     * @param array $array
     * @param callable|null $callback
     * @param bool $preserveKeys
     * @return array
     */
    public function filter(
        array $array,
        ?callable $callback = null,
        bool $preserveKeys = false
    ): array {
        /** @var array $data */
        $data = $callback ? array_filter($array, $callback)
            : array_filter($array);
        return $preserveKeys ? $data : array_values($data);
    }

    /**
     * @param array $data
     * @param array $keys
     * @return array
     */
    public function kslice(
        array $data,
        array $keys = []
    ): array {
        /** @var array $idxs */
        $idxs = array_flip(
            array_values($keys)
        );
        return array_intersect_key($data, $idxs);
    }

    /**
     * @param array $data
     * @param int|string $offset
     * @param int|string|null $length
     * @param mixed $replacement
     * @return array
     */
    public function ksplice(
        array &$data,
        $offset,
        $length = null,
        $replacement = []
    ): array {
        if ($length === null) {
            $length = $offset;
        }

        if (!is_array($replacement)) {
            $replacement = (array) $replacement;
        }

        /** @var array $keys */
        $keys = array_keys($data);

        /** @var array $idxs */
        $idxs = array_flip($keys);

        if (array_key_exists($offset, $data)) {
            $offset = $idxs[$offset];
        } else {
            return [];
        }

        if (array_key_exists($length, $data)) {
            $length = ($idxs[$length] + 1) - $offset;
        } else {
            $length = 0;
        }

        /** @var array $tmp */
        $tmp = (array) $data;
        $data = array_slice($data, 0, $offset, true)
            + $replacement
            + array_slice($data, $offset + $length, null, true);

        return array_diff_key($tmp, $data);
    }

    /**
     * @param array $data
     * @param bool $getKey
     * @return mixed
     */
    public function pop(
        array &$data,
        bool $getKey = false
    ) {
        if (!empty($data)) {
            /** @var array $keys */
            $keys = array_keys($data);

            /** @var int|string|null $last */
            $last = array_pop($keys);

            if ($last !== null) {
                /** @var array $splice */
                $splice = $this->ksplice($data, $last);
                return $getKey ? $last : $splice[$last];
            }
        }

        return null;
    }

    /**
     * @param callable|callable[]|null $func
     * @param callable|callable[] $callback
     * @param array[] $arrays
     * @return array
     */
    public function uvmap(
        $func,
        $callback,
        array ...$arrays
    ): array {
        if (!empty($func) && !is_array($func)) {
            $func = [$func];
        }

        if (!is_array($callback)) {
            $callback = [$callback];
        }

        /** @var Closure $apply */
        $apply = function (...$entry) use ($callback) {
            /** @var callable $callable */
            foreach ($callback as $callable) {
                if (!is_callable($callable)) {
                    throw new InvalidArgumentException('Invalid callback given');
                }

                $entry = $callable(...$entry);
            }

            return $entry;
        };

        /** @var array $result */
        $result = array_map($apply, ...$arrays);

        /** @var callable $fn */
        foreach ($func ?? [] as $fn) {
            $result = $fn($result);
        }

        return $result;
    }

    /**
     * @param int|null $mode
     * @param array[] $arrays
     * @return bool
     */
    public function vksort(
        ?int $mode,
        array &...$arrays
    ): bool {
        /** @var array $array */
        foreach ($arrays as &$array) {
            ksort($array, $mode ?? SORT_REGULAR);
        }

        return true;
    }

    /**
     * @param int|null $mode
     * @param array[] $arrays
     * @return bool
     */
    public function vsort(
        ?int $mode,
        array &...$arrays
    ): bool {
        /** @var array $array */
        foreach ($arrays as &$array) {
            sort($array, $mode ?? SORT_REGULAR);
        }

        return true;
    }
}
