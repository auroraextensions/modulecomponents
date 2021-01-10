<?php
/**
 * JsonSerializerTrait.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Component\Data\Serializer
 * @copyright   Copyright (C) 2021 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Component\Data\Serializer;

use Exception;
use InvalidArgumentException;

/**
 * @see Magento\Framework\Serialize\Serializer\Json
 */
trait JsonSerializerTrait
{
    /** @var Json $serializer */
    private $serializer;

    /**
     * @param string $json
     * @return array|null
     */
    private function fromJson(string $json): ?array
    {
        try {
            return (array) $this->serializer->unserialize($json);
        } catch (InvalidArgumentException | Exception $e) {
            return null;
        }
    }

    /**
     * @param array $data
     * @return string|null
     */
    private function toJson(array $data = []): ?string
    {
        try {
            return $this->serializer->serialize($data);
        } catch (InvalidArgumentException | Exception $e) {
            return null;
        }
    }
}
