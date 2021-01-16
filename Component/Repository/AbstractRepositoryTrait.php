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
 * @copyright   Copyright (C) 2021 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Component\Repository;

use Magento\Framework\{
    Api\Filter,
    Api\SearchCriteriaInterface,
    Api\SearchResultsInterface,
    Api\SearchResultsInterfaceFactory,
    Api\Search\FilterGroup,
    Api\SortOrder,
    DataObject,
    Data\Collection,
    Data\CollectionFactory
};

trait AbstractRepositoryTrait
{
    /** @var CollectionFactory $collectionFactory */
    private $collectionFactory;

    /** @var SearchResultsInterfaceFactory $searchResultsFactory */
    private $searchResultsFactory;

    /**
     * @param \Magento\Framework\Api\Search\FilterGroup $group
     * @param \Magento\Framework\Data\Collection $collection
     * @return void
     */
    public function addFilterGroupToCollection(
        FilterGroup $group,
        Collection $collection
    ): void {
        /** @var array $fields */
        $fields = [];

        /** @var array $params */
        $params = [];

        /** @var Filter $filter */
        foreach ($group->getFilters() as $filter) {
            /** @var string $param */
            $param = $filter->getConditionType() ?: 'eq';

            /** @var string $field */
            $field = $filter->getField();

            /** @var mixed $value */
            $value = $filter->getValue();

            $fields[] = $field;
            $params[] = [
                $param => $value,
            ];
        }

        $collection->addFieldToFilter($fields, $params);
    }

    /**
     * @param string $direction
     * @return string
     */
    public function getDirection(
        string $direction = SortOrder::SORT_DESC
    ): string {
        return $direction === SortOrder::SORT_ASC
            ? SortOrder::SORT_ASC
            : SortOrder::SORT_DESC;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResultsInterface
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        /** @var FilterGroup[] $groups */
        $groups = $criteria->getFilterGroups();

        /** @var FilterGroup $group */
        foreach ($groups as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }

        /** @var SortOrder[] $sortOrders */
        $sortOrders = (array) $criteria->getSortOrders();

        /** @var SortOrder $sortOrder */
        foreach ($sortOrders as $sortOrder) {
            /** @var string $field */
            $field = $sortOrder->getField();

            $collection->addOrder(
                $field,
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
