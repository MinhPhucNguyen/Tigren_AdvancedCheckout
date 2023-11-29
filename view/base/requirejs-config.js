/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

var config =
    {
        map:
            {
                '*':
                    {
                        'addtocart': 'Tigren_AdvancedCheckout/js/catalog-add-to-cart',
                    }
            },
        config: {
            mixins: {
                'Magento_Checkout/js/action/place-order': {
                    'Tigren_AdvancedCheckout/js/place-order': true
                }
            }
        }
    };
