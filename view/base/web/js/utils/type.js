/**
 * type.js
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
     * @var {Function} fmt
     * @param {String} name
     * @param {String} type
     * @param {*} value
     * @return {String}
     */
    var fmt = function (name, type, value) {
        return '[' + name + '] must be type [' + type + '], [' + $.type(value) + '] given.';
    };

    return {
        /**
         * @param {String|Number} needle
         * @param {Array} haystack
         * @return {Boolean}
         */
        inArray: function (needle, haystack) {
            if (!this.isArray(haystack)) {
                throw new TypeError(fmt('haystack', 'Array', haystack));
            }

            return this.toBool(haystack.indexOf(needle) > -1);
        },
        /**
         * @param {*} value
         * @return {Boolean}
         */
        isArray: function (value) {
            return Array.isArray(value);
        },
        /**
         * @param {*} value
         * @return {Boolean}
         */
        isComposite: function (value) {
            return this.inArray($.type(value), ['object', 'symbol', 'undefined']);
        },
        /**
         * @param {*} value
         * @return {Boolean}
         */
        isFunction: function (value) {
            return ($.type(value) === 'function' && value instanceof Function);
        },
        /**
         * @param {*} value
         * @return {Boolean}
         */
        isHtmlElement: function (value) {
            return (value instanceof HTMLElement);
        },
        /**
         * @param {*} value
         * @return {Boolean}
         */
        isObject: function (value) {
            return (value instanceof Object);
        },
        /**
         * @param {*} value
         * @return {Boolean}
         */
        isScalar: function (value) {
            return this.inArray($.type(value), ['string', 'number', 'boolean']);
        },
        /**
         * @param {scalar} value
         * @param {String} delim
         * @return {Array}
         * @throws {TypeError}
         */
        toArray: function (value, delim) {
            delim = delim || '';

            if (!this.isScalar(value)) {
                throw new TypeError(fmt('value', 'boolean|number|string', value));
            }

            return this.toString(value).split(delim);
        },
        /**
         * @param {scalar} value
         * @return {Boolean}
         */
        toBool: function (value) {
            return !!(value);
        },
        /**
         * @param {scalar} value
         * @return {Number}
         */
        toNumber: function (value) {
            return +(value);
        },
        /**
         * @param {scalar} value
         * @return {String}
         */
        toString: function (value) {
            return ('' + value);
        }
    };
});
