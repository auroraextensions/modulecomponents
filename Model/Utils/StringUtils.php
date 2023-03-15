<?php
/**
 * StringUtils.php
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
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\Utils;

use InvalidArgumentException;
use Throwable;

use function array_filter;
use function array_map;
use function array_values;
use function count;
use function explode;
use function implode;
use function is_array;
use function is_iterable;
use function is_scalar;
use function is_string;
use function str_pad;
use function str_replace;
use function strlen;
use function vsprintf;

use const DIRECTORY_SEPARATOR;
use const STR_PAD_BOTH;

class StringUtils
{
    public const LTRIM = 1;
    public const RTRIM = 2;
    public const TRIM = self::LTRIM | self::RTRIM;
    public const FN_MAP = [
        self::LTRIM => 'ltrim',
        self::RTRIM => 'rtrim',
        self::TRIM => 'trim',
    ];

    /**
     * @param array $pieces
     * @param string $delimiter
     * @param bool $filter
     * @return string
     */
    public function concat(
        array $pieces,
        string $delimiter = '',
        bool $filter = false
    ): string {
        if ($filter) {
            $pieces = array_filter($pieces, 'strlen');
        }

        return implode($delimiter, $pieces);
    }

    /**
     * @param array $pieces
     * @param callable|null $callback
     * @param bool $preserveKeys
     * @return array
     */
    public function filter(
        array $pieces,
        ?callable $callback = null,
        bool $preserveKeys = false
    ): array {
        /* Defaults strlen for empty values. */
        $callback = $callback ?? 'strlen';

        /** @var array $result */
        $result = array_filter($pieces, $callback);
        return $preserveKeys ? $result : array_values($result);
    }

    /**
     * @param string|int|bool $value
     * @param int|null $length
     * @param string $padding
     * @param int $padType
     * @return string
     */
    public function pad(
        $value,
        ?int $length = null,
        string $padding = ' ',
        int $padType = STR_PAD_BOTH
    ): string {
        if (!is_string($value)) {
            $value = (string) $value;
        }

        if ($length === null) {
            $length = strlen($value) + ($padType ?: 1);
        }

        return str_pad(
            $value,
            $length,
            $padding,
            $padType
        );
    }

    /**
     * @param string|iterable $search
     * @param string|iterable $replace
     * @param mixed[] $subject
     * @return string|array
     * @throws \InvalidArgumentException
     */
    public function replace($search, $replace, ...$subject)
    {
        if ((!is_scalar($search) && !is_iterable($search))
            || (!is_scalar($replace) && !is_iterable($replace))) {
            throw new InvalidArgumentException('Search and replace parameters must be scalar or iterable type.');
        }

        /* Support search/replace as any iterable type (e.g. ArrayIterator, ArrayObject, etc.) */
        $search = !is_scalar($search) ? (array) $search : (string) $search;
        $replace = !is_scalar($replace) ? (array) $replace : (string) $replace;

        /** @var string[] $values */
        $values = array_map('strval', $subject);

        /** @var string|array $result */
        $result = str_replace($search, $replace, $values);

        if (is_array($result) && count($result) === 1) {
            return (string)($result[0] ?? null);
        }

        return $result;
    }

    /**
     * @param string $subject
     * @param string $delimiter
     * @param bool $filter
     * @return string[]
     */
    public function split(
        string $subject,
        string $delimiter = ' ',
        bool $filter = false
    ): array {
        /** @var string[] $pieces */
        $pieces = explode($delimiter, $subject);

        if ($filter) {
            $pieces = array_filter($pieces, 'strlen');
        }

        return array_values($pieces);
    }

    /**
     * @param string $tmpl
     * @param mixed[] $values
     * @return string|null
     */
    public function sprintf(string $tmpl, ...$values): ?string
    {
        try {
            return vsprintf($tmpl, $values);
        } catch (Throwable $e) {
            return null;
        }
    }

    /**
     * @param string $subject
     * @param int $context
     * @param string $delimiter
     * @return string
     */
    public function trim(
        string $subject,
        int $context = self::TRIM,
        string $delimiter = ' ',
    ): string {
        /** @var string|null $callback */
        $callback = self::FN_MAP[$context] ?? null;

        if ($callback === null) {
            return $subject;
        }

        /** @var array $result */
        $result = array_map(
            $callback,
            [$subject],
            [$delimiter]
        );
        return !empty($result) ? $result[0] : $subject;
    }
}
