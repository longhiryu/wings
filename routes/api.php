<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Front\ArticleController;
use App\Http\Controllers\Api\Front\ProductController as FrontProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** ************************** Api Frontend *****************************/
Route::middleware(['front.api.locale'])->group(function () {
    /** Api Front Product */
    Route::resource('/products', FrontProductController::class)->names([
        'index'   => 'front.products.index',
        'show'    => 'front.products.show',
    ])->only(['index', 'show']);
    Route::get('products/slug/{slug}', [FrontProductController::class, 'getDetailBySlug'])->name('front.products.getDetailBySlug');

    Route::resource('/articles', ArticleController::class)->names([
        'index'   => 'front.articles.index',
        'show'    => 'front.articles.show',
    ])->only(['index', 'show']);
});


Route::post('/login', [AuthController::class, 'login']);
