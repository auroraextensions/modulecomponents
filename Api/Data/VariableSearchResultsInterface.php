<?php
/**
 * VariableSearchResultsInterface.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Api\Data
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface VariableSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Magento\Variable\Model\Variable[]
     */
    public function getItems();

    /**
     * @param \Magento\Variable\Model\Variable[] $items
     * @return \AuroraExtensions\ModuleComponents\Api\Data\VariableSearchResultsInterface
     */
    public function setItems(array $items);
}
