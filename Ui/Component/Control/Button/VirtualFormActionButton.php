<?php
/**
 * VirtualFormActionButton.php
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

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

use function __;
use function array_replace_recursive;

class VirtualFormActionButton implements ButtonProviderInterface
{
    /** @var mixed[] $components */
    private $components = [
        'button' => ['event' => 'save'],
    ];

    /** @var string $formRole */
    private $formRole;

    /** @var string $htmlClass */
    private $htmlClass;

    /** @var string $label */
    private $label;

    /** @var int $sortOrder */
    private $sortOrder;

    /**
     * @param string $label
     * @param string $htmlClass
     * @param string $formRole
     * @param mixed[] $components
     * @param int $sortOrder
     * @return void
     */
    public function __construct(
        string $label,
        string $htmlClass = 'action',
        string $formRole = 'save',
        array $components = [],
        int $sortOrder = 10
    ) {
        $this->label = $label;
        $this->htmlClass = $htmlClass;
        $this->formRole = $formRole;
        $this->components = array_replace_recursive(
            $this->components,
            $components
        );
        $this->sortOrder = $sortOrder;
    }

    /**
     * @inheritdoc
     */
    public function getButtonData()
    {
        return [
            'class' => $this->htmlClass,
            'data_attribute' => [
                'form-role' => $this->formRole,
                'mage-init' => $this->components,
            ],
            'label' => __($this->label),
            'on_click' => '',
            'sort_order' => $this->sortOrder,
        ];
    }
}
