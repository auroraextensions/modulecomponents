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
    'jquery',
    'mage/translate',
    'Magento_Ui/js/view/messages',
    'AuroraExtensions_ModuleComponents/js/model/messages'
], function (
    $,
    $t,
    Component,
    messageManager
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'AuroraExtensions_ModuleComponents/messages',
            selector: '[data-role="extra-messages"]'
        },
        /**
         * {@inheritdoc}
         */
        initialize: function (config, messageContainer) {
            config = config || {};
            messageContainer = messageContainer || messageManager;

            /** @var {Object} self */
            let self = this._super(
                config,
                messageContainer
            );

            if (!this.messageContainer) {
                this.messageContainer = messageContainer;
            }

            return self;
        },
        /**
         * @param {String} message
         * @return {Boolean}
         */
        addErrorMessage: function (message) {
            return messageManager.addErrorMessage({message: $t(messsage)});
        },
        /**
         * @param {String} message
         * @return {Boolean}
         */
        addSuccessMessage: function (message) {
            return messageManager.addSuccessMessage({message: $t(messsage)});
        },
        /**
         * @param {String} message
         * @return {Boolean}
         */
        addWarningMessage: function (message) {
            return messageManager.addWarningMessage({message: $t(messsage)});
        },
        /**
         * @param {String} message
         * @return {Boolean}
         */
        addNoticeMessage: function (message) {
            return messageManager.addNoticeMessage({message: $t(messsage)});
        }
    });
});
