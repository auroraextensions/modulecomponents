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

use function gettype;
use function hash_algos;
use function hash_final;
use function hash_init;
use function hash_update;
use function hash_update_stream;
use function in_array;
use function is_resource;
use function is_string;
use function random_bytes;
use function sprintf;

final class HashContext
{
    public const HASH_ALGO = 'sha256';
    public const MIN_BYTES = 8;

    /** @var bool $closed */
    private $closed = false;

    /** @var \HashContext|resource $ctx */
    private $ctx;

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
        /** @var string[] $algos */
        $algos = hash_algos();

        if (!in_array($algo, $algos)) {
            throw new InvalidArgumentException('Invalid hashing algorithm.');
        }

        $this->ctx = hash_init($algo);
        $this->ingest(
            $data ?? random_bytes(self::MIN_BYTES)
        );
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
            throw new RuntimeException(
                'Unable to ingest additional data, hash context is closed.'
            );
        }

        if (!is_string($data)) {
            if (!is_resource($data)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Invalid argument type. Must be "string" or "resource", "%s" given.',
                        gettype($data)
                    )
                );
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
    #[\ReturnTypeWillChange]
    public function __toString()
    {
        return $this->digest();
    }
}
