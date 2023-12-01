<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\AdvancedCheckout\Model;

use Tigren\AdvancedCheckout\Api\AccountManagementInterface;
use Magento\Customer\Model\CustomerFactory;
use Tigren\AdvancedCheckout\Api\Data\AccountInterface;

class AccountManagement implements AccountManagementInterface
{

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @param CustomerFactory $customerFactory
     */
    public function __construct(CustomerFactory $customerFactory)
    {
        $this->customerFactory = $customerFactory;
    }

    /**
     * @return array|AccountInterface[]
     */
    public function getAllAccounts()
    {
        $customerFactory = $this->customerFactory->create();
        $collection = $customerFactory->getCollection();

        $result = [];
        foreach ($collection as $item) {
            $result[] = $item->getData();
        }
        return $result;
    }
}
