<?php

use App\Models\Supplier;

/**
 * Method getSupplierNameById
 * @param int $id
 * @return string
 */
function getSupplierNameById(int $id = null): string|null
{
    $supplier = $id ? Supplier::find($id) : null;

    return $supplier ? $supplier->name : null;
}
