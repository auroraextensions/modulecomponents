<?php
/**
 * VirtualAreaEmulator.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Model\State
 * @copyright   Copyright (C) 2023 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\State;

use AuroraExtensions\ModuleComponents\Api\AreaEmulatorInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Config\ScopeInterface;
use Throwable;

class VirtualAreaEmulator implements AreaEmulatorInterface
{
    /** @var string $areaCode */
    private $areaCode;

    /** @var ScopeInterface $scope */
    private $scope;

    /** @var State $state */
    private $state;

    /**
     * @param ScopeInterface $scope
     * @param State $state
     * @param string $areaCode
     * @return void
     */
    public function __construct(
        ScopeInterface $scope,
        State $state,
        string $areaCode = Area::AREA_GLOBAL
    ) {
        $this->scope = $scope;
        $this->state = $state;
        $this->areaCode = $areaCode;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(
        callable $callback,
        ...$params
    ) {
        /** @var string $scope */
        $scope = $this->scope->getCurrentScope();

        try {
            return $this->state->emulateAreaCode(
                $this->getAreaCode(),
                function () use ($callback, $params) {
                    $this->scope->setCurrentScope($this->getAreaCode());
                    return $callback(...$params);
                }
            );
        } catch (Throwable $e) {
            throw $e;
        } finally {
            $this->scope->setCurrentScope($scope);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAreaCode(): string
    {
        return $this->areaCode;
    }
}
