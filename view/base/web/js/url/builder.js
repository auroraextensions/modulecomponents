/**
 * builder.js
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
    'jquery',
    'AuroraExtensions_ModuleComponents/js/utils/string'
], function ($, stringUtils) {
    'use strict';

    return {
        /**
         * @param {String} url
         * @param {Object} params
         * @return {String}
         */
        bindParams: function (url, params) {
            var parts;

            /** @var {Array} parts */
            parts = stringUtils.filter(
                stringUtils.split(url, '/')
            );

            $.each(params, function (key, value) {
                parts.push(key, value);
            });

            return ('/' + parts.join('/') + '/');
        },
        /**
         * @param {String} url
         * @param {Object} params
         * @param {Boolean} abs
         * @return {String}
         */
        getUrl: function (url, params, abs) {
            var result;

            url = stringUtils.trim(url);
            abs = abs || false;

            /** @var {String} result */
            result = this.bindParams(url, params);

            if (abs) {
                result = document.location.origin + result;
            }

            return result;
        }
    };
});
