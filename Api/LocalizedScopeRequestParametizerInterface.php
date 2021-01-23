<?php
/**
 * LocalizedScopeRequestParametizerInterface.php
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
 * @copyright   Copyright (C) 2021 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
declare(strict_types=1);

namespace AuroraExtensions\ModuleComponents\Api;

interface LocalizedScopeRequestParametizerInterface
{
    /** @constant string IDENTITY_KEY */
    public const IDENTITY_KEY = 'id';

    /** @constant string SECRET_KEY */
    public const SECRET_KEY = 'token';

    /** @constant string WILDCARD */
    public const WILDCARD = '*';

    /**
     * @return string
     */
    public function getIdentityKey(): string;

    /**
     * @return string|null
     */
    public function getIdentity(): ?string;

    /**
     * @return string
     */
    public function getSecretKey(): string;

    /**
     * @return string|null
     */
    public function getSecret(): ?string;
}
