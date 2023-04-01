<?php
/**
 * JsLayout.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Block\Layout
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Block\Layout;

use AuroraExtensions\ModuleComponents\Api\JsLayoutInterface;
use AuroraExtensions\ModuleComponents\Api\JsLayoutProcessorInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class JsLayout extends Template implements JsLayoutInterface
{
    public const AREA = 'data';
    public const TMPL = 'AuroraExtensions_ModuleComponents::section/component.phtml';

    /** @var string $displayArea */
    private $displayArea;

    /** @var JsLayoutProcessorInterface[] $layoutProcessors */
    private $layoutProcessors;

    /** @var Json $serializer */
    private $serializer;

    /**
     * @param Context $context
     * @param Json $serializer
     * @param string $displayArea
     * @param array $jsLayout
     * @param JsLayoutProcessorInterface[] $layoutProcessors
     * @param string $layoutName
     * @param string $template
     * @return void
     */
    public function __construct(
        Context $context,
        Json $serializer,
        string $displayArea = self::AREA,
        array $jsLayout = [],
        array $layoutProcessors = [],
        string $layoutName = '',
        string $template = self::TMPL
    ) {
        parent::__construct(
            $context,
            [
                'jsLayout' => $jsLayout,
                'template' => $template,
            ]
        );
        $this->serializer = $serializer;
        $this->displayArea = $displayArea;
        $this->layoutProcessors = $layoutProcessors;
        $this->setNameInLayout($layoutName);
        $this->initialize();
    }

    /**
     * @return void
     */
    private function initialize(): void
    {
        /** @var JsLayoutProcessorInterface $layoutProcessor */
        foreach ($this->layoutProcessors as $layoutProcessor) {
            $this->jsLayout = $layoutProcessor->process($this->jsLayout);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getJsLayout(): string
    {
        return $this->serializer->serialize($this->jsLayout);
    }

    /**
     * {@inheritdoc}
     */
    public function getRegion(): string
    {
        return $this->displayArea;
    }
}
