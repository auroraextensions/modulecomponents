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
    'AuroraExtensions_ModuleComponents/js/view/messages'
], function ($, messageManager) {
    'use strict';

    /** @var {Function} addErrorMessages */
    var addErrorMessages = function (response) {
        /** @var {Array} messages */
        let messages = Array.isArray(response.messages)
            ? response.messages : [];

        if (response.message) {
            messages.push(response.message);
        }

        messages.forEach(function (message) {
            messageManager.addErrorMessage(message);
        });
    };

    return function () {
        $.ajaxSetup({
            /**
             * @param {Object} response
             * @return {void}
             */
            error: function (response) {
                if (response.error) {
                    addErrorMessages(response);
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
                    addErrorMessages(response);
                }
            }
        });
    };
});
