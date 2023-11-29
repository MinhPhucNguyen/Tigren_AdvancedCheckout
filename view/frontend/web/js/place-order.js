/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/utils/wrapper'
], function ($, modal, wrapper) {
    'use strict';

    return function (placeOrderAction) {

        return function (paymentData, redirectOnSuccess) {

            $.ajax({
                url: '/advancedcheckout/index/checkincompleteorder',
                method: 'GET',
                success: function (response) {
                    console.log(response)
                    var options = {
                        type: 'popup',
                        responsive: true,
                        innerScroll: true,
                        buttons: [
                            {
                                text: $.mage.__('Close'),
                                class: 'close_btn',
                                click: function () {
                                    $("#popup-modal").modal("closeModal");
                                }
                            },
                        ]
                    };

                    var popup = modal(options, $('#popup-modal'));

                    if (response.showPopUp) {
                        $("#popup-modal").modal("openModal");
                        // alert('You have an incomplete order. Please complete or cancel it before placing a new order.')

                    } else {
                        return placeOrderAction(paymentData, redirectOnSuccess);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });

            return this._super(paymentData, redirectOnSuccess);
        };
    };
});
