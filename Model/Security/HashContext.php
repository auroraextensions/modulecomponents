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
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\Security;

use InvalidArgumentException;
use RuntimeException;

use function hash_algos;
use function hash_final;
use function hash_init;
use function hash_update;
use function hash_update_stream;
use function in_array;
use function is_resource;
use function is_string;
use function random_bytes;

final class HashContext
{
    /** @constant string HASH_ALGO */
    public const HASH_ALGO = 'sha256';

    /** @constant int MIN_BYTES */
    public const MIN_BYTES = 8;

    /** @var string $algo */
    private $algo;

    /** @var bool $closed */
    private $closed = false;

    /** @var \HashContext|resource $ctx */
    private $ctx;

    /** @var string|resource $data */
    private $data;

    /** @var string $digest */
    private $digest;

    /**
     * @param string|resource|null $data
     * @param string $algo
     * @return void
     */
    public function __construct(
        $data = null,
        string $algo = self::HASH_ALGO
    ) {
        $this->data = $data ?: random_bytes(self::MIN_BYTES);
        $this->algo = $algo;
        $this->initialize();
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    private function initialize(): void
    {
        /** @var string[] $algos */
        $algos = hash_algos();

        if (!in_array($this->algo, $algos)) {
            throw new InvalidArgumentException('Invalid hashing algorithm.');
        }

        $this->ctx = hash_init($this->algo);
        $this->ingest($this->data);
    }

    /**
     * @param string|resource $data
     * @return HashContext
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function ingest($data): HashContext
    {
        if ($this->closed) {
            throw new RuntimeException('Unable to ingest data, hash context is closed.');
        }

        if (!is_string($data)) {
            if (!is_resource($data)) {
                throw new InvalidArgumentException('Invalid argument type, must be string or resource.');
            }

            hash_update_stream($this->ctx, $data);
        } else {
            hash_update($this->ctx, $data);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function digest(): string
    {
        if (!$this->closed) {
            $this->digest = hash_final($this->ctx);
            $this->closed = true;
        }

        return $this->digest;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->digest();
    }
}
