/**
 * messages.js
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
 * @copyright   Copyright (C) 2023 Aurora Extensions <support@auroraextensions.com>
 * @license     MIT
 */
define([
    'ko',
    'uiComponent'
], function (ko, Component) {
    'use strict';

    /** @var {Object} MessageManager */
    var MessageManager = Component.extend({
        /**
         * {@inheritdoc}
         */
        initObservable: function () {
            this._super();

            this.errorMessages = ko.observableArray([]);
            this.successMessages = ko.observableArray([]);
            this.warningMessages = ko.observableArray([]);
            this.noticeMessages = ko.observableArray([]);

            return this;
        },
        /**
         * @param {Object} data
         * @param {Object} type
         * @return {Boolean}
         */
        add: function (data, type) {
            var expr = /([%])\w+/g,
                message;

            if (!data.hasOwnProperty('parameters')) {
                this.clear();
                type.push(data.message);

                return true;
            }

            /** @var {*} message */
            message = data.message.replace(expr, function (field) {
                field = field.substr(1);

                if (!isNaN(field)) {
                    field--;
                }

                if (data.parameters.hasOwnProperty(field)) {
                    return data.parameters[field];
                }

                return data.parameters.shift();
            });

            this.clear();
            type.push(message);

            return true;
        },
        /**
         * @param {Object} message
         * @return {Boolean}
         */
        addErrorMessage: function (message) {
            return this.add(
                message,
                this.errorMessages
            );
        },
        /**
         * @param {Object} message
         * @return {Boolean}
         */
        addNoticeMessage: function (message) {
            return this.add(
                message,
                this.noticeMessages
            );
        },
        /**
         * @param {Object} message
         * @return {Boolean}
         */
        addSuccessMessage: function (message) {
            return this.add(
                message,
                this.successMessages
            );
        },
        /**
         * @param {Object} message
         * @return {Boolean}
         */
        addWarningMessage: function (message) {
            return this.add(
                message,
                this.warningMessages
            );
        },
        /**
         * @return {Array}
         */
        getErrorMessages: function () {
            return this.errorMessages;
        },
        /**
         * @return {Array}
         */
        getNoticeMessages: function () {
            return this.noticeMessages;
        },
        /**
         * @return {Array}
         */
        getSuccessMessages: function () {
            return this.successMessages;
        },
        /**
         * @return {Array}
         */
        getWarningMessages: function () {
            return this.warningMessages;
        }
    });
    return new MessageManager();
});
