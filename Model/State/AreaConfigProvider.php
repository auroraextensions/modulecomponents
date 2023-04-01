<?php
/**
 * AreaConfigProvider.php
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

use AuroraExtensions\ModuleComponents\Api\AreaConfigProviderInterface;
use Magento\Framework\App\Area;
use Magento\Framework\ObjectManager\ConfigLoaderInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class AreaConfigProvider implements AreaConfigProviderInterface
{
    /** @var array $cache */
    private $cache = [];

    /** @var ConfigLoaderInterface $configLoader */
    private $configLoader;

    /** @var LoggerInterface $logger */
    private $logger;

    /**
     * @param ConfigLoaderInterface $configLoader
     * @param LoggerInterface $logger
     * @return void
     */
    public function __construct(
        ConfigLoaderInterface $configLoader,
        LoggerInterface $logger
    ) {
        $this->configLoader = $configLoader;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function get(
        string $areaCode = Area::AREA_GLOBAL
    ): ?array {
        try {
            /** @var array|null $config */
            $config =& $this->cache[$areaCode];

            if (empty($config)) {
                $config = (array) $this->configLoader->load($areaCode);
            }

            return $config;
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            return null;
        }
    }
}
