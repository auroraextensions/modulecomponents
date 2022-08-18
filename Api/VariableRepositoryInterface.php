<?php
/**
 * VariableRepositoryInterface.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Api
 * @copyright   Copyright (C) 2022 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Api;

use Magento\Variable\Model\Variable;

interface VariableRepositoryInterface
{
    /**
     * @param string $code
     * @return \Magento\Variable\Model\Variable
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(string $code): Variable;

    /**
     * @param int $variableId
     * @return \Magento\Variable\Model\Variable
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $variableId): Variable;

    /**
     * @param \Magento\Variable\Model\Variable $variable
     * @return int
     */
    public function save(Variable $variable): int;

    /**
     * @param \Magento\Variable\Model\Variable $variable
     * @return bool
     */
    public function delete(Variable $variable): bool;

    /**
     * @param int $variableId
     * @return bool
     */
    public function deleteById(int $variableId): bool;
}
