<?php
/**
 * VirtualJsRedirectButton.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Ui\Component\Control\Button
 * @copyright   Copyright (C) 2023 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Ui\Component\Control\Button;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

use function __;

class VirtualJsRedirectButton implements ButtonProviderInterface
{
    /** @var string $htmlClass */
    private $htmlClass;

    /** @var string $label */
    private $label;

    /** @var array $paramList */
    private $paramList;

    /** @var RequestInterface $request */
    private $request;

    /** @var string $routePath */
    private $routePath;

    /** @var int $sortOrder */
    private $sortOrder;

    /** @var UrlInterface $urlBuilder */
    private $urlBuilder;

    /**
     * @param RequestInterface $request
     * @param UrlInterface $urlBuilder
     * @param string $label
     * @param string $htmlClass
     * @param string $routePath
     * @param array $paramList
     * @param int $sortOrder
     * @return void
     */
    public function __construct(
        RequestInterface $request,
        UrlInterface $urlBuilder,
        string $label = '',
        string $htmlClass = 'button',
        string $routePath = '*',
        array $paramList = [],
        int $sortOrder = 10
    ) {
        $this->request = $request;
        $this->urlBuilder = $urlBuilder;
        $this->label = $label;
        $this->htmlClass = $htmlClass;
        $this->routePath = $routePath;
        $this->paramList = $paramList;
        $this->sortOrder = $sortOrder;
    }

    /**
     * @inheritdoc
     */
    public function getButtonData()
    {
        return [
            'class' => $this->htmlClass,
            'label' => __($this->label),
            'on_click' => $this->getOnClickJs(),
            'sort_order' => $this->sortOrder,
        ];
    }

    /**
     * @return string
     */
    private function getOnClickJs(): string
    {
        /** @var array $params */
        $params = [];

        /** @var string $alias */
        /** @var string|null $param */
        foreach ($this->paramList as $alias => $param) {
            $param = $param ?? $alias;

            /** @var mixed $value */
            $value = $this->request->getParam($param);
            $params += [$alias => $value];
        }

        /** @var string $targetUrl */
        $targetUrl = $this->urlBuilder->getUrl($this->routePath, $params);
        return "(function(){window.location.href='{$targetUrl}';})();";
    }
}
