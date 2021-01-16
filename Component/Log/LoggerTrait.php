<?php
/**
 * LoggerTrait.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Component\Log
 * @copyright   Copyright (C) 2021 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Component\Log;

use Psr\Log\LoggerInterface;

trait LoggerTrait
{
    /** @var LoggerInterface $logger */
    private $logger;

    /**
     * @return LoggerInterface|null
     */
    private function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }
}
