<?php
/**
 * ContextAwareRequestParameterResolverInterface.php
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

interface ContextAwareRequestParameterResolverInterface
{
    /** @constant string ENTITY_KEY */
    public const ENTITY_KEY = 'id';

    /** @constant string SECRET_KEY */
    public const SECRET_KEY = 'token';

    /** @constant string WILDCARD */
    public const WILDCARD = '*';

    /**
     * @param string $paramType
     * @return string|null
     */
    public function resolve(string $paramType): ?string;
}
