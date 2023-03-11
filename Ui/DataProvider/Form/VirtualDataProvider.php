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
 * @package     AuroraExtensions\ModuleComponents\Ui\DataProvider\Form
 * @copyright   Copyright (C) 2023 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Ui\DataProvider\Form;

use ArrayIteratorFactory;
use AuroraExtensions\ModuleComponents\Api\ObjectProxyInterface;
use AuroraExtensions\ModuleComponents\Component\Ui\DataProvider\Modifier\ModifierPoolTrait;
use AuroraExtensions\ModuleComponents\Model\Utils\StringUtils;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\DataObject;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use IteratorAggregate;
use Traversable;

use function strtolower;

class VirtualDataProvider extends AbstractDataProvider implements IteratorAggregate
{
    /**
     * @var PoolInterface $modifierPool
     * @method PoolInterface getModifierPool()
     * @method ModifierInterface[] getModifiers()
     */
    use ModifierPoolTrait;

    private const ACTION_TMPL = '%s';
    private const SUBMIT_URL_TMPL = '%s/%s/%s';
    private const VAR_TMPL = '{{action}}';
    private const WILDCARD = '*';

    /** @var string $actionTmpl */
    private $actionTmpl;

    /** @var string $variableTmpl */
    private $variableTmpl;

    /** @var array $cache */
    private $cache = [];

    /** @var string[] $conditionTypes */
    private $conditionTypes;

    /** @var FilterBuilder $filterBuilder */
    private $filterBuilder;

    /** @var ArrayIteratorFactory $iteratorFactory */
    private $iteratorFactory;

    /** @var int $iteratorFlags */
    private $iteratorFlags;

    /** @var PoolInterface $modifierPool */
    private $modifierPool;

    /** @var RequestInterface $request */
    private $request;

    /** @var SearchCriteriaBuilder $searchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /** @var StringUtils $stringUtils */
    private $stringUtils;

    /** @var string $submitUrlTmpl */
    private $submitUrlTmpl;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ObjectProxyInterface $collectionFactory
     * @param FilterBuilder $filterBuilder
     * @param ArrayIteratorFactory $iteratorFactory
     * @param PoolInterface $modifierPool
     * @param RequestInterface $request
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param StringUtils $stringUtils
     * @param string $actionTmpl
     * @param string $submitUrlTmpl
     * @param string $variableTmpl
     * @param array $conditionTypes
     * @param int $iteratorFlags
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
        FilterBuilder $filterBuilder,
        ArrayIteratorFactory $iteratorFactory,
        PoolInterface $modifierPool,
        RequestInterface $request,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        StringUtils $stringUtils,
        string $actionTmpl = self::ACTION_TMPL,
        string $submitUrlTmpl = self::SUBMIT_URL_TMPL,
        string $variableTmpl = self::VAR_TMPL,
        array $conditionTypes = [],
        int $iteratorFlags = 0,
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
        $this->filterBuilder = $filterBuilder;
        $this->iteratorFactory = $iteratorFactory;
        $this->modifierPool = $modifierPool;
        $this->request = $request;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->stringUtils = $stringUtils;
        $this->actionTmpl = $actionTmpl;
        $this->variableTmpl = $variableTmpl;
        $this->submitUrlTmpl = $submitUrlTmpl;
        $this->conditionTypes = $conditionTypes;
        $this->iteratorFlags = $iteratorFlags;
        $this->buildSubmitUrl();
    }

    /**
     * @return void
     */
    private function buildSubmitUrl(): void
    {
        if (!empty($this->data['config']['submit_url'])) {
            $this->prepareSubmitUrl();
        }

        if (!empty($this->data['config']['filter_url_params'])) {
            /** @var string $param */
            /** @var mixed $value */
            foreach ($this->data['config']['filter_url_params'] as $param => $value) {
                /** @var mixed $paramValue */
                $paramValue = $value !== self::WILDCARD ? $value
                    : $this->request->getParam($param);

                if (!empty($paramValue)) {
                    $this->data['config']['submit_url'] = $this->stringUtils->sprintf(
                        $this->submitUrlTmpl,
                        $param,
                        $paramValue
                    );

                    $this->searchCriteriaBuilder->addFilters([
                        $this->filterBuilder
                            ->setField($param)
                            ->setValue($paramValue)
                            ->setConditionType($this->conditionTypes[$param] ?? 'eq')
                            ->create(),
                    ]);
                }
            }
        }
    }

    /**
     * @return void
     */
    private function prepareSubmitUrl(): void
    {
        /** @var string $actionName */
        $actionName = $this->stringUtils->sprintf(
            $this->actionTmpl,
            strtolower($this->request->getActionName())
        );

        /** @var string $submitUrl */
        $submitUrl = $this->stringUtils->trim(
            $this->data['config']['submit_url'],
            StringUtils::RTRIM,
            ' '
        );
        $this->data['config']['submit_url'] = $this->stringUtils->replace(
            $this->variableTmpl,
            $actionName,
            $submitUrl
        );
    }

    /**
     * @inheritdoc
     */
    public function getMeta()
    {
        /** @var array $meta */
        $meta = parent::getMeta();

        /** @var ModifierInterface $modifier */
        foreach ($this->getModifiers() as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }

        return $meta;
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        if (!empty($this->cache)) {
            return $this->cache;
        }

        /** @var DataObject[] $items */
        $items = $this->getCollection()->getItems();

        /** @var DataObject $item */
        foreach ($items as $item) {
            $this->cache[$item->getId()] = $item->getData();
        }

        /** @var ModifierInterface $modifier */
        foreach ($this->getModifiers() as $modifier) {
            $this->cache = $modifier->modifyData($this->cache);
        }

        return $this->cache;
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
