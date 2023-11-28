/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

require([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'Magento_Customer/js/customer-data'
], function ($, modal, customerData) {

    /**
     * Clear cart function
     */
    function clearCart() {
        $.ajax({
            type: "POST",
            url: "/advancedcheckout/index/clearcart",
            success: function (response) {
                var sections = ['cart'];
                customerData.invalidate(sections);
                customerData.reload(sections, true);
                if (response.success) {
                    $("#popup-modal").modal("closeModal");
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }


    var options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        buttons: [
            {
                text: $.mage.__('Proceed to Checkout'),
                class: 'proceed_to_checkout_btn',
                click: function () {
                    window.location.href = '/checkout';
                }
            },
            {
                text: $.mage.__('Clear Cart'),
                class: 'clear_cart_btn',
                click: function () {
                    clearCart()
                }
            }
        ]
    };

    var popup = modal(options, $('#popup-modal'));

    $("#product-addtocart-button").on('click', function () {
        const product_id = $("#product_addtocart_form input[name='product']").val();

        $.ajax({
            type: "POST",
            url: "/advancedcheckout/index/checkallowmultiorder",
            data: {
                product_id: product_id,
            },
            success: function (response) {
                if (response.showPopUp) {
                    $("#popup-modal").modal("openModal");
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
})
