/**
 * string.js
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
define(['jquery'], function ($) {
    'use strict';

    /**
     * @var {Function} empty
     * @param {Array} pieces
     * @return {Array}
     */
    var empty = function (pieces) {
        return pieces.filter(Boolean);
    };

    return {
        /**
         * @param {Array} pieces
         * @param {Function} callback
         * @return {Array}
         */
        filter: function (pieces, callback) {
            callback = $.isFunction(callback) ? callback : empty;
            return callback(pieces);
        },
        /**
         * @param {String} value
         * @param {String} delim
         * @return {String}
         */
        trim: function (value, delim) {
            delim = delim || '/';

            if (value) {
                /* trim-left */
                while (value.charAt(0) === delim) {
                    value = value.slice(1);
                }

                /* trim-right */
                while (value.charAt(value.length - 1) === delim) {
                    value = value.slice(0, value.length - 1);
                }
            }

            return value;
        }
    };
});
