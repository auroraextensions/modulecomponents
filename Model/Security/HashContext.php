<?php
/**
 * HashContext.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Model\Security
 * @copyright   Copyright (C) 2021 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\Security;

use InvalidArgumentException;
use function hash_algos;
use function hash_final;
use function hash_init;
use function hash_update;
use function in_array;
use function random_bytes;

class HashContext
{
    /** @constant string HASH_ALGO */
    public const HASH_ALGO = 'sha256';

    /** @constant int MIN_BYTES */
    public const MIN_BYTES = 16;

    /** @var string $algo */
    private $algo;

    /** @var string $data */
    private $data;

    /** @var string $digest */
    private $digest;

    /**
     * @param string $algo
     * @param string|null $data
     * @return void
     */
    public function __construct(
        string $algo = self::HASH_ALGO,
        string $data = null
    ) {
        $this->algo = $algo;
        $this->data = $data ?? random_bytes(self::MIN_BYTES);
        $this->initialize();
    }

    /**
     * @return void
     * @throws \InvalidArgumentException
     */
    private function initialize(): void
    {
        /** @var array $algos */
        $algos = hash_algos();

        if (!in_array($this->algo, $algos)) {
            throw new InvalidArgumentException('Invalid hashing algorithm.');
        }

        /** @var \HashContext $context */
        $context = hash_init($this->algo);
        hash_update($context, $this->data);
        $this->digest = hash_final($context);
    }

    /**
     * @return string
     */
    public function digest(): string
    {
        return $this->digest;
    }
}
