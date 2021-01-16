/**
 * params.js
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT license, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/modulecomponents/LICENSE.txt
 *
 * @package     AuroraExtensions\ModuleComponents
 * @copyright   Copyright (C) 2021 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
define([
    'AuroraExtensions_ModuleComponents/js/utils/string'
], function (stringUtils) {
    'use strict';

    return {
        /**
         * @param {String} key
         * @param {String} url
         * @return {Boolean}
         */
        hasParam: function (key, url) {
            var parts;

            /* Defaults `url` as current pathname. */
            url = url || document.location.pathname;

            /** @var {Array} parts */
            parts = stringUtils.filter(
                stringUtils.split(url, key)
            );
            return !!(parts.length - 1);
        },
        /**
         * @param {String} key
         * @param {String} url
         * @return {String|null}
         */
        getParam: function (key, url) {
            var index, parts, value;

            /* Defaults `url` as document pathname. */
            url = stringUtils.trim(url || document.location.pathname);

            if (!this.hasParam(key, url)) {
                return null;
            }

            /** @var {Array} parts */
            parts = stringUtils.filter(
                stringUtils.split(url, '/')
            );

            /** @var {Number} index */
            index = parts.indexOf(key);

            if (index !== -1) {
                /** @var {String} value */
                value = parts.slice(index)[1];
            }

            return value ? value : null;
        }
    };
});
