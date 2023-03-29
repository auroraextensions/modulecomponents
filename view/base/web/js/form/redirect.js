/**
 * redirect.js
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
    'AuroraExtensions_ModuleComponents/js/model/messages'
], function ($, $t, messageContainer) {
    'use strict';

    return function () {
        $.ajaxSetup({
            /**
             * @param {Object} response
             * @return {void}
             */
            error: function (response) {
                if (response.error) {
                    /** @var {Array} messages */
                    let messages = Array.isArray(response.messages)
                        ? response.messages : [];

                    messages.forEach(function (message) {
                        messageContainer.addErrorMessage({message: $t(message)});
                    });
                }
            },
            /**
             * @param {Object} response
             * @return {void}
             */
            success: function (response) {
                if (response.success && response.isAjax) {
                    window.location.href = response.targetUrl;
                }

                if (response.error) {
                    /** @var {Array} messages */
                    let messages = Array.isArray(response.messages)
                        ? response.messages : [];

                    messages.forEach(function (message) {
                        messageContainer.addErrorMessage({message: $t(message)});
                    });
                }
            }
        });
    };
});
