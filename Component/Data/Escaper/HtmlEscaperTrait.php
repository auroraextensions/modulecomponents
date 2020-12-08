<?php
/**
 * HtmlEscaperTrait.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package       AuroraExtensions\ModuleComponents\Component\Data\Escaper
 * @copyright     Copyright (C) 2020 Aurora Extensions <support@auroraextensions.com>
 * @license       MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Component\Data\Escaper;

/**
 * @see Magento\Framework\Escaper
 */
trait HtmlEscaperTrait
{
    /** @var Escaper $escaper */
    private $escaper;

    /**
     * @param mixed $data
     * @return mixed
     */
    private function escapeHtml($data)
    {
        return $this->escaper->escapeHtml($data);
    }
}
