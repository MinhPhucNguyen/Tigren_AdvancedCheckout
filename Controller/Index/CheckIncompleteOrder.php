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
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Checkout\Model\Session as CheckoutSession;

class CheckIncompleteOrder extends Action
{

    protected $resultJsonFactory;

    protected $customerSession;

    protected $orderCollectionFactory;

    protected $checkoutSession;


    public function __construct(
        CheckoutSession        $checkoutSession,
        CustomerSession        $customerSession,
        OrderCollectionFactory $orderCollectionFactory,
        JsonFactory            $resultJsonFactory,
        Context                $context
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function getRealOrderId()
    {
        $lastOrderId = $this->checkoutSession->getLastOrderId();
        return $lastOrderId;
    }

    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();

        $customerId = $this->customerSession->getCustomerId();

//        $abc = $this->checkoutSession->getData();

        $allOrderOfCustomer = $this->orderCollectionFactory->create()
            ->addFieldToFilter('customer_id', $customerId)
            ->addFieldToFilter('status', ['in' => ['pending', 'processing']])
            ->getData();

        foreach ($allOrderOfCustomer as $item) {
            if ($item['status'] == 'pending' || $item['status'] == 'processing') {
                return $resultJson->setData([
                    'status' => $item['increment_id'],
                    'showPopUp' => true,
                    'message' => 'You have an incomplete order. Please complete or cancel it before placing a new order.'
                ]);
            } else {
                return $resultJson->setData([
                    'showPopUp' => false,
                ]);
            }
        }
    }
}

