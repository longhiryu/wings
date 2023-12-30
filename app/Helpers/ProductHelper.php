<?php

use App\Models\Product;
use Illuminate\Support\Facades\File;

/**
 * Method getImageById
 *
 * @param int $id product
 *
 * @return void
 */
function getImageById(int $id)
{
    $product = Product::find($id);
    if ($product) {
        return $product->getImage();
    }
    return '/images/no_image.png';
}
