<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\AdvancedCheckout\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session;
use Magento\Store\Model\StoreManagerInterface;

class CreateAccount implements ObserverInterface
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @param CustomerFactory $customerFactory
     * @param StoreManagerInterface $storeManager
     * @param Session $customerSession
     */
    public function __construct(
        CustomerFactory       $customerFactory,
        StoreManagerInterface $storeManager,
        Session               $customerSession,
    )
    {
        $this->storeManager = $storeManager;
        $this->customerFactory = $customerFactory;
        $this->customerSession = $customerSession;
    }

    public function execute(Observer $observer)
    {
        if (!$this->customerSession->isLoggedIn()) {
            $order = $observer->getData('order');

            $shippingAddress = $order->getShippingAddress();
            $firstName = $shippingAddress->getFirstname();
            $lastName = $shippingAddress->getLastname();
            $email = $shippingAddress->getEmail();

            // Get Website ID
            $websiteId = $this->storeManager->getWebsite()->getWebsiteId();

            $customer = $this->customerFactory->create();
            $customer->setWebsiteId($websiteId);

            $customer->setEmail($email);
            $customer->setFirstname($firstName);
            $customer->setLastname($lastName);
            $customer->setPassword("abc123");

            $customer->save();
        }

    }
}

