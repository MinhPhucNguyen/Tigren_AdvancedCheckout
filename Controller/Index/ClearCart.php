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
use Magento\Checkout\Model\Cart;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Controller\Result\JsonFactory;

class ClearCart extends Action
{

    protected $cart;

    protected $checkoutSession;

    protected $resultJsonFactory;

    public function __construct(
        JsonFactory     $resultJsonFactory,
        CheckoutSession $checkoutSession,
        Cart            $cart,
        Context         $context
    )
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->checkoutSession = $checkoutSession;
        $this->cart = $cart;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $allItemsInCart = $this->cart->getQuote()->getItemsCollection();

        foreach ($allItemsInCart as $item) {
            $this->cart->removeItem($item->getId())->save();
        }

        $this->messageManager->addSuccessMessage(__('Your cart has been cleared.'));

        return $resultJson->setData([
            'success' => true,
        ]);
    }
}
