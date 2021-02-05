<?php
/**
 * ContextAwareRequestParameterResolver.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Model\Http\Request
 * @copyright   Copyright (C) 2021 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Model\Http\Request;

use AuroraExtensions\ModuleComponents\{
    Api\ContextAwareRequestParameterResolverInterface,
    Model\Utils\PathUtils
};
use Magento\Framework\{
    App\RequestInterface,
    Stdlib\ArrayManager
};

class ContextAwareRequestParameterResolver implements ContextAwareRequestParameterResolverInterface
{
    /** @var ArrayManager $arrayManager */
    private $arrayManager;

    /** @var array $config */
    private $config;

    /** @var array $paramTypes */
    private $paramTypes = [];

    /** @var PathUtils $pathUtils */
    private $pathUtils;

    /** @var RequestInterface $request */
    private $request;

    /**
     * @param ArrayManager $arrayManager
     * @param PathUtils $pathUtils
     * @param RequestInterface $request
     * @param array $config
     * @return void
     */
    public function __construct(
        ArrayManager $arrayManager,
        PathUtils $pathUtils,
        RequestInterface $request,
        array $config = []
    ) {
        $this->arrayManager = $arrayManager;
        $this->pathUtils = $pathUtils;
        $this->request = $request;
        $this->config = $config;
        $this->initialize();
    }

    /**
     * @return void
     */
    private function initialize(): void
    {
        /** @var string $route */
        $route = $this->request->getRouteName() ?? self::WILDCARD;

        /** @var string $controller */
        $controller = $this->request->getControllerName() ?? self::WILDCARD;

        /** @var string $action */
        $action = $this->request->getActionName() ?? self::WILDCARD;

        /** @var string $configPath */
        $configPath = $this->pathUtils->build($route, $controller, $action);

        /** @var array $paramTypes */
        $paramTypes = $this->arrayManager->get($configPath, $this->config, []);

        /** @var string $paramType */
        /** @var string $paramName */
        foreach ($paramTypes as $paramType => $paramName) {
            $this->paramTypes[$paramType] = $paramName;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(string $paramType = self::ENTITY_TYPE_KEY): ?string
    {
        return $this->paramTypes[$paramType] ?? null;
    }
}
