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

        //Get Sku from request
        $productSku = $this->getRequest()->getParam('product_sku');

        //Get current product by sku and check if it is on cart
        $currentProduct = $this->productFactory->create()->loadByAttribute('sku', $productSku);
        $productOnCart = $this->cart->getQuote()->hasProductId($currentProduct->getId());

        //Get allow multi order attribute of current product
        $allowMultiOrder = $currentProduct->getCustomAttribute('allow_multi_order') ?
            $currentProduct->getCustomAttribute('allow_multi_order')->getValue() : 0;

        /**
         * Check allow multi order
         */
        if ($productOnCart && $allowMultiOrder != 1) {
            return $resultJson->setData([
                'showPopUp' => true,
                'message' => __('You can only purchase one item at a time.'),
            ]);
        } else {
            return $resultJson->setData([
                'showPopUp' => false,
                'message' => __(''),
            ]);
        }
    }
}
