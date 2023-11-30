/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

define([
    'jquery',
    'mage/utils/wrapper'
], function ($, wrapper) {
    'use strict';

    return function (placeOrderAction) {

        return function (paymentData, redirectOnSuccess) {

            $.ajax({
                url: '/advancedcheckout/index/checkincompleteorder',
                method: 'GET',
                success: function (response) {

                    if (response.showPopUp) {
                        $("#popup-modal-checkout").modal("openModal");
                        return false;
                    } else {
                        $("#popup-modal-checkout").modal("closeModal");
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
