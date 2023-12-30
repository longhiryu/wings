<?php

use App\Models\Customer;

/**
 * Method getCustomerNameById
 * @param int $id [explicite description]
 * @return string:null
 */
function getCustomerNameById(int $id): string|null{
    $customer = Customer::find($id);
    if ($customer) {
        $customer->name;
    }

    return null;
}