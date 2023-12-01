<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\AdvancedCheckout\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Catalog\Model\ProductFactory;
use Magento\Checkout\Model\Cart;

class CheckAllowMultiOrder extends Action
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var Cart
     */
    protected $cart;


    /**
     * @param Cart $cart
     * @param ProductFactory $productFactory
     * @param JsonFactory $resultJsonFactory
     * @param Context $context
     */
    public function __construct(
        Cart           $cart,
        ProductFactory $productFactory,
        JsonFactory    $resultJsonFactory,
        Context        $context
    )
    {
        $this->cart = $cart;
        $this->productFactory = $productFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * @return Json
     */
    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $productId = $this->getRequest()->getParam('product_id');
        $productSku = $this->getRequest()->getParam('product_sku');

        $product = $this->productFactory->create()->load($productId);
        $allItemsInCart = $this->cart->getQuote()->getAllVisibleItems();

        $allowMultiOrder = $product->getCustomAttribute('allow_multi_order')
            ? $product->getCustomAttribute('allow_multi_order')->getValue() : 0;

        /**
         * Check allow multi order
         */
        if (count($allItemsInCart) > 0) {
            foreach ($allItemsInCart as $item) {
                if ($productSku == $item->getSku()) {
                    if ($allowMultiOrder !== 1) {
                        return $resultJson->setData([
                            'showPopUp' => true,
                            'message' => __('You can only purchase one item at a time.')
                        ]);

                    } else {
                        return $resultJson->setData([
                            'showPopUp' => false,
                            'message' => __('')
                        ]);
                    }
                }
            }
        }
        return $resultJson->setData([
            'showPopUp' => false,
            'message' => __('')
        ]);
    }
}
