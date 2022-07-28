<?php
/**
 * PathUtils.php
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

use function array_merge;
use function array_pop;
use function array_shift;

use const DIRECTORY_SEPARATOR;

class PathUtils extends StringUtils
{
    /** @var string $delimiter */
    private $delimiter;

    /**
     * @param string $delimiter
     * @return void
     */
    public function __construct(
        string $delimiter = DIRECTORY_SEPARATOR
    ) {
        $this->delimiter = $delimiter;
    }

    /**
     * @return string
     */
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * @param string[] $pieces
     * @return string
     */
    public function build(string ...$pieces): string
    {
        /** @var string $delimiter */
        $delimiter = $this->getDelimiter();

        /** @var string $basePath */
        $basePath = $this->trim(
            (string) array_shift($pieces),
            self::RTRIM
        );

        if (!empty($basePath) && $basePath[0] === $delimiter) {
            $basePath = $this->concat([
                null,
                $this->trim($basePath),
            ]);
        }

        /** @var string $basename */
        $basename = $this->trim(
            (string) array_pop($pieces)
        );

        if (!empty($basename)) {
            $basename = $this->concat(
                $this->split($basename, $delimiter, true)
            );
        }

        /** @var string[] $dirs */
        $dirs = $this->filter($pieces);

        /** @var int|string $key */
        /** @var string $value */
        foreach ($dirs as $key => $value) {
            /** @var string[] $paths */
            $paths = $this->split(
                $value,
                $delimiter,
                true
            );

            /** @var string $path */
            $path = $this->concat($paths);
            $dirs[$key] = $this->trim($path);
        }

        /** @var array $result */
        $result = array_merge(
            [$basePath],
            $dirs,
            [$basename]
        );
        return $this->concat($result);
    }
}
