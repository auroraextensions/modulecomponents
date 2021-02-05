<?php
/**
 * LocalizedScopeRequestParametizer.php
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
    Api\LocalizedScopeRequestParametizerInterface,
    Model\Utils\PathUtils
};
use Magento\Framework\{
    App\RequestInterface,
    Stdlib\ArrayManager
};

class LocalizedScopeRequestParametizer implements LocalizedScopeRequestParametizerInterface
{
    /** @var ArrayManager $arrayManager */
    private $arrayManager;

    /** @var array $config */
    private $config;

    /** @var PathUtils $pathUtils */
    private $pathUtils;

    /** @var RequestInterface $request */
    private $request;

    /** @var string $identityKey */
    private $identityKey;

    /** @var string $secretKey */
    private $secretKey;

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

        /** @var string $identityKeyPath */
        $identityKeyPath = $this->pathUtils->build($route, $controller, $action, 'identityKey');

        /** @var string $secretKeyPath */
        $secretKeyPath = $this->pathUtils->build($route, $controller, $action, 'secretKey');

        $this->identityKey = $this->arrayManager->get($identityKeyPath, $this->config, self::IDENTITY_KEY);
        $this->secretKey = $this->arrayManager->get($secretKeyPath, $this->config, self::SECRET_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentityKey(): string
    {
        return $this->identityKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentity(): ?string
    {
        return $this->request->getParam($this->identityKey);
    }

    /**
     * {@inheritdoc}
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getSecret(): ?string
    {
        return $this->request->getParam($this->secretKey);
    }
}
