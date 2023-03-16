<?php
/**
 * VirtualOptGroupSelect.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Model\Config\Source\Select\OptGroup
 * @copyright   Copyright (C) 2023 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\Config\Source\Select\OptGroup;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Magento\Framework\Data\OptionSourceInterface;
use Traversable;

use function __;
use function array_walk;
use function count;
use function is_array;

class VirtualOptGroupSelect implements OptionSourceInterface, IteratorAggregate, Countable
{
    /** @var array $options */
    private $options = [];

    /**
     * @param array $data
     * @return void
     */
    public function __construct(array $data = [])
    {
        array_walk($data, [
            $this,
            'setOption'
        ]);
    }

    /**
     * @param array $options
     * @return array
     */
    private function getOptGroup(array $options): array
    {
        /** @var array $optgroup */
        $optgroup = [];

        /** @var int|string $key */
        /** @var mixed $value */
        foreach ($options as $key => $value) {
            $optgroup[] = is_array($value)
                ? $this->getOptGroup($value)
                : [
                    'label' => __($value),
                    'value' => $key,
                ];
        }

        return $optgroup;
    }

    /**
     * @param int|string|null $value
     * @param int|string $key
     * @return void
     */
    private function setOption($value, $key): void
    {
        $this->options[] = [
            'label' => __($key),
            'value' => is_array($value)
                ? $this->getOptGroup($value) : $value,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->options);
    }
}
