<?php
/**
 * AbstractRepositoryTrait.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Component\Repository
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Component\Repository;

use AuroraExtensions\ModuleComponents\Api\AbstractCollectionInterface;
use AuroraExtensions\ModuleComponents\Api\AbstractCollectionInterfaceFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\DataObject;

trait AbstractRepositoryTrait
{
    /** @var AbstractCollectionInterfaceFactory $collectionFactory */
    private $collectionFactory;

    /** @var SearchResultsInterfaceFactory $searchResultsFactory */
    private $searchResultsFactory;

    /**
     * {@inheritdoc}
     */
    public function addFilterGroupToCollection(
        FilterGroup $filterGroup,
        AbstractCollectionInterface $collection
    ): void {
        /** @var array $fields */
        $fields = [];

        /** @var array $params */
        $params = [];

        /** @var Filter $filter */
        foreach ($filterGroup->getFilters() as $filter) {
            $fields[] = $filter->getField();

            /** @var string $param */
            $param = $filter->getConditionType() ?: 'eq';
            $params[] = [$param => $filter->getValue()];
        }

        $collection->addFieldToFilter($fields, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function getDirection(
        string $direction = SortOrder::SORT_DESC
    ): string {
        return $direction === SortOrder::SORT_ASC
            ? SortOrder::SORT_ASC : SortOrder::SORT_DESC;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResultsInterface
    {
        /** @var AbstractCollectionInterface $collection */
        $collection = $this->collectionFactory->create();

        /** @var FilterGroup[] $filterGroups */
        $filterGroups = $criteria->getFilterGroups();

        /** @var FilterGroup $filterGroup */
        foreach ($filterGroups as $filterGroup) {
            $this->addFilterGroupToCollection(
                $filterGroup,
                $collection
            );
        }

        /** @var SortOrder[] $sortOrders */
        $sortOrders = (array) $criteria->getSortOrders();

        /** @var SortOrder $sortOrder */
        foreach ($sortOrders as $sortOrder) {
            $collection->addOrder(
                $sortOrder->getField(),
                $this->getDirection($sortOrder->getDirection())
            );
        }

        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $collection->load();

        /** @var SearchResultsInterface $results */
        $results = $this->searchResultsFactory->create();
        $results->setSearchCriteria($criteria);

        /** @var array $items */
        $items = [];

        /** @var DataObject $item */
        foreach ($collection as $item) {
            $items[] = $item;
        }

        $results->setItems($items);
        $results->setTotalCount($collection->getSize());

        return $results;
    }
}
