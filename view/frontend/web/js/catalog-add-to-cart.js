/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

require([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
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
                    this.closeModal();
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
