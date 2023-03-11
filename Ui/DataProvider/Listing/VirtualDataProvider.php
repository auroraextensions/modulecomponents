<?php
/**
 * VirtualDataProvider.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Ui\DataProvider\Listing
 * @copyright   Copyright (C) 2023 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Ui\DataProvider\Listing;

use ArrayIteratorFactory;
use AuroraExtensions\ModuleComponents\Api\ObjectProxyInterface;
use Magento\Framework\Api\Filter;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Ui\DataProvider\AddFieldToCollectionInterface;
use Magento\Ui\DataProvider\AddFilterToCollectionInterface;
use IteratorAggregate;
use Traversable;

class VirtualDataProvider extends AbstractDataProvider implements IteratorAggregate
{
    /** @var AddFieldToCollectionInterface[] $addFieldStrategies */
    private $addFieldStrategies;

    /** @var AddFilterToCollectionInterface[] $addFilterStrategies */
    private $addFilterStrategies;

    /** @var ArrayIteratorFactory $iteratorFactory */
    private $iteratorFactory;

    /** @var int $iteratorFlags */
    private $iteratorFlags;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ObjectProxyInterface $collectionFactory
     * @param ArrayIteratorFactory $iteratorFactory
     * @param int $iteratorFlags
     * @param AddFieldToCollectionInterface[] $addFieldStrategies
     * @param AddFilterToCollectionInterface[] $addFilterStrategies
     * @param array $meta
     * @param array $data
     * @return void
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ObjectProxyInterface $collectionFactory,
        ArrayIteratorFactory $iteratorFactory,
        int $iteratorFlags = 0,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
        $this->collection = $collectionFactory->create();
        $this->iteratorFactory = $iteratorFactory;
        $this->iteratorFlags = $iteratorFlags;
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
    }

    /**
     * @inheritdoc
     */
    public function addField($field, $alias = null)
    {
        if (!empty($this->addFieldStrategies[$field])) {
            $this->addFieldStrategies[$field]
                 ->addField(
                     $this->getCollection(),
                     $field,
                     $alias
                 );
        } else {
            parent::addField($field, $alias);
        }
    }

    /**
     * @inheritdoc
     */
    public function addFilter(Filter $filter)
    {
        /** @var string $field */
        $field = $filter->getField();

        if (!empty($this->addFilterStrategies[$field])) {
            $this->addFilterStrategies[$field]
                 ->addFilter(
                     $this->getCollection(),
                     $field,
                     [$filter->getConditionType() => $filter->getValue()]
                 );
        }else {
            parent::addFilter($filter);
        }
    }

    /**
     * @inheritdoc
     */
    public function getIterator(): Traversable
    {
        return $this->iteratorFactory->create([
            'array' => $this->getData(),
            'flags' => $this->iteratorFlags,
        ]);
    }
}
