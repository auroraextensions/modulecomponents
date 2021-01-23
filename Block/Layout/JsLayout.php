<?php
/**
 * JsLayoutInterface.php
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
 * @copyright   Copyright (C) 2021 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Block\Layout;

use AuroraExtensions\ModuleComponents\Api\JsLayoutInterface;
use Magento\Framework\{
    Serialize\Serializer\Json,
    View\Element\Template,
    View\Element\Template\Context
};
use function is_array;

class JsLayout extends Template implements JsLayoutInterface
{
    /** @var array $jsLayout */
    private $jsLayout;

    /** @var Json $serializer */
    private $serializer;

    /**
     * @param Context $context
     * @param Json $serializer
     * @param array $data
     * @return void
     */
    public function __construct(
        Context $context,
        Json $serializer,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->serializer = $serializer;
        $this->jsLayout = is_array($data['jsLayout'] ?? null) ? $data['jsLayout'] : [];
    }

    /**
     * {@inheritdoc}
     */
    public function getJsLayout(): string
    {
        return $this->serializer->serialize($this->jsLayout);
    }
}
