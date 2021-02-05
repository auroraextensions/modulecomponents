<?php
/**
 * RedirectTrait.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents\Component\Http\Request
 * @copyright   Copyright (C) 2021 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Component\Http\Request;

use Magento\Framework\Controller\Result\Redirect;

/**
 * @api
 * @since 100.0.0
 */
trait RedirectTrait
{
    /**
     * @return Redirect
     */
    public function getRedirect(): Redirect
    {
        return $this->resultRedirectFactory->create();
    }

    /**
     * @param string $path
     * @param array $params
     * @return Redirect
     */
    public function getRedirectToPath(
        string $path = '*',
        array $params = []
    ): Redirect {
        /** @var Redirect $redirect */
        $redirect = $this->getRedirect();
        $redirect->setPath($path, $params);
        return $redirect;
    }

    /**
     * @param string $url
     * @return Redirect
     */
    public function getRedirectToUrl(string $url = '*'): Redirect
    {
        /** @var Redirect $redirect */
        $redirect = $this->getRedirect();
        $redirect->setUrl($url);
        return $redirect;
    }
}
