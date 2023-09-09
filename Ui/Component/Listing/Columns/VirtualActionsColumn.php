<?php
/**
 * VirtualActionsColumn.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Ui\Component\Listing\Columns
 * @copyright   Copyright (C) 2023 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

use function __;

class VirtualActionsColumn extends Column
{
    /** @var string $primaryField */
    private $primaryField;

    /** @var string $requestParam */
    private $requestParam;

    /** @var UrlInterface $urlBuilder */
    private $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory,
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $primaryField
     * @param string $requestParam
     * @return void
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        string $primaryField = 'entity_id',
        string $requestParam = 'id'
    ) {
        parent::__construct(
            $context,
            $uiComponentFactory,
            $components,
            $data
        );
        $this->urlBuilder = $urlBuilder;
        $this->primaryField = $primaryField;
        $this->requestParam = $requestParam;
    }

    /**
     * @inheritdoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            /** @var string $primaryField */
            $primaryField = $this->getData('config/primaryField') ?? $this->primaryField;

            /** @var array $item */
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item[$primaryField])) {
                    /** @var array $config */
                    $config = [];

                    /** @var string $requestParam */
                    $requestParam = $this->getData('config/requestParam') ?? $this->requestParam;

                    /** @var string|null $viewUrlPath */
                    $viewUrlPath = $this->getData('config/viewUrlPath') ?? null;

                    if (!empty($viewUrlPath)) {
                        $config += [
                            'view' => [
                                'href' => $this->urlBuilder->getUrl($viewUrlPath, [
                                    $requestParam => $item[$primaryField],
                                ]),
                                'hidden' => true,
                                'label' => __('View'),
                            ],
                        ];
                    }

                    /** @var string $editUrlPath */
                    $editUrlPath = $this->getData('config/editUrlPath') ?? null;

                    if (!empty($editUrlPath)) {
                        $config += [
                            'edit' => [
                                'href' => $this->urlBuilder->getUrl($editUrlPath, [
                                    $requestParam => $item[$primaryField],
                                ]),
                                'label' => __('Edit'),
                            ],
                        ];
                    }

                    $item[$this->getData('name')] = $config;
                }
            }
        }

        return $dataSource;
    }
}
