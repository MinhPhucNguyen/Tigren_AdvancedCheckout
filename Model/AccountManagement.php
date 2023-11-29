<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\AdvancedCheckout\Model;

use AccountManagementInterface;
use Magento\Customer\Model\CustomerFactory;

class AccountManagement implements AccountManagementInterface
{

    protected $customerFactory;

    public function __construct(CustomerFactory $customerFactory)
    {
        $this->customerFactory = $customerFactory;
    }

    public function getAllAcounts()
    {
        $user = $this->customerFactory->create();
        
    }
}