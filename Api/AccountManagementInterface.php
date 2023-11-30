<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\AdvancedCheckout\Api;

use Tigren\AdvancedCheckout\Api\Data\AccountInterface;

interface AccountManagementInterface
{

    /**
     * @return AccountInterface[]
     */
    public function getAllAccounts();
}
