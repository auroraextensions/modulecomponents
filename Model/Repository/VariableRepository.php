<?php
/**
 * VariableRepository.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Model\Repository
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\Repository;

use AuroraExtensions\ModuleComponents\Exception\ExceptionFactory;
use AuroraExtensions\ModuleComponents\Api\Data\VariableSearchResultsInterfaceFactory;
use AuroraExtensions\ModuleComponents\Api\VariableRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Variable\Model\Variable;
use Magento\Variable\Model\VariableFactory;
use Magento\Variable\Model\ResourceModel\Variable as VariableResource;
use Magento\Variable\Model\ResourceModel\Variable\Collection;
use Magento\Variable\Model\ResourceModel\Variable\CollectionFactory;

use function __;

class VariableRepository implements VariableRepositoryInterface
{
    /** @var CollectionFactory $collectionFactory */
    private $collectionFactory;

    /** @var ExceptionFactory $exceptionFactory */
    private $exceptionFactory;

    /** @var VariableFactory $variableFactory */
    private $variableFactory;

    /** @var VariableResource $variableResource */
    private $variableResource;

    /** @var VariableSearchResultsInterfaceFactory $searchResultsFactory */
    private $searchResultsFactory;

    /**
     * @param CollectionFactory $collectionFactory
     * @param ExceptionFactory $exceptionFactory
     * @param VariableFactory $variableFactory
     * @param VariableResource $variableResource
     * @param VariableSearchResultsInterfaceFactory $searchResultsFactory
     * @return void
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        ExceptionFactory $exceptionFactory,
        VariableFactory $variableFactory,
        VariableResource $variableResource,
        VariableSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->exceptionFactory = $exceptionFactory;
        $this->variableFactory = $variableFactory;
        $this->variableResource = $variableResource;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param string $code
     * @return Variable
     * @throws NoSuchEntityException
     */
    public function get(string $code): Variable
    {
        /** @var Variable $variable */
        $variable = $this->variableFactory->create();
        $this->variableResource->load(
            $variable,
            $code,
            'code'
        );

        if (!$variable->getId()) {
            /** @var NoSuchEntityException $exception */
            $exception = $this->exceptionFactory->create(
                NoSuchEntityException::class,
                __('Unable to locate matching variable information.')
            );
            throw $exception;
        }

        return $variable;
    }

    /**
     * @param int $variableId
     * @return Variable
     * @throws NoSuchEntityException
     */
    public function getById(int $variableId): Variable
    {
        /** @var Variable $variable */
        $variable = $this->variableFactory->create();
        $this->variableResource->load($variable, $variableId);

        if (!$variable->getId()) {
            /** @var NoSuchEntityException $exception */
            $exception = $this->exceptionFactory->create(
                NoSuchEntityException::class,
                __('Unable to locate matching variable information.')
            );
            throw $exception;
        }

        return $variable;
    }

    /**
     * @param Variable $variable
     * @return int
     */
    public function save(Variable $variable): int
    {
        $this->variableResource->save($variable);
        return (int) $variable->getId();
    }

    /**
     * @param Variable $variable
     * @return bool
     */
    public function delete(Variable $variable): bool
    {
        return $this->deleteById((int) $variable->getId());
    }

    /**
     * @param int $variableId
     * @return bool
     */
    public function deleteById(int $variableId): bool
    {
        /** @var Variable $variable */
        $variable = $this->variableFactory->create();
        $variable->setId($variableId);
        return (bool) $this->variableResource->delete($variable);
    }
}
