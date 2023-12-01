/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

define([
    'jquery',
    'jquery-ui-modules/widget',
    'Magento_Ui/js/modal/modal',
], function ($) {
    'use strict';

    return function (widget) {

        $.widget('mage.catalogAddToCart', widget, {

            submitForm: function (form) {

                var self = this;

                $.ajax({
                    url: '/advancedcheckout/index/checkallowmultiorder',
                    type: 'POST',
                    data: {
                        product_sku: form.attr('data-product-sku')
                    },
                    success: function (response) {
                        console.log(response);
                        if (!response.showPopUp) {
                            self.ajaxSubmit(form);
                        }

                        if (response.showPopUp) {
                            $("#popup-modal").html('<h3>' + response.message + '</h3>').modal("openModal");
                        }
                    }
                });
            },

            ajaxSubmit: function (form) {
                return this._super(form);
            }

        });

        return $.mage.catalogAddToCart;

    }
});

