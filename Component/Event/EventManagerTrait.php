<?php
/**
 * EventManagerTrait.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Component\Event
 * @copyright   Copyright (C) 2021 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Component\Event;

use Magento\Framework\Event\ManagerInterface;

/**
 * @api
 * @since 100.0.0
 */
trait EventManagerTrait
{
    /** @var ManagerInterface $eventManager */
    private $eventManager;

    /**
     * @param string $event
     * @param array $data
     * @return void
     */
    private function dispatchEvent(string $event, array $data = []): void
    {
        $this->eventManager->dispatch($event, $data);
    }

    /**
     * @param array $events
     * @return void
     */
    private function dispatchEvents(array $events = []): void
    {
        /** @var string $event */
        /** @var array $data */
        foreach ($events as $event => $data) {
            $this->eventManager->dispatch($event, $data);
        }
    }
}
