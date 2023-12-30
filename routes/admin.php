<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\FileComponent;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Livewire\Admin\User\UserComponent;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Livewire\Admin\Order\OrderComponent;
use App\Http\Livewire\Admin\Import\ImportComponent;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Livewire\Admin\Article\ArticleComponent;
use App\Http\Livewire\Admin\Channel\ChannelComponent;
use App\Http\Livewire\Admin\Product\ProductComponent;
use App\Http\Livewire\Admin\Project\ProjectComponent;
use App\Http\Livewire\Admin\Category\CategoryComponent;
use App\Http\Livewire\Admin\Customer\CustomerComponent;
use App\Http\Livewire\Admin\Supplier\SupplierComponent;
use App\Http\Livewire\Admin\Inventory\InventoryComponent;
use App\Http\Livewire\Admin\UserGroup\UserGroupComponent;
use App\Http\Controllers\Livewire\Channel\ChannelController;
use App\Http\Livewire\Admin\InventoryProduct\InventoryProductComponent;
use App\Http\Livewire\Admin\Supplier\SupplierOrderComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Main route admin
Route::middleware(['check.auth', 'locale', 'channel'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', function () {
            return redirect()->route('products');
        })->name('default');
        Route::resource('/user', UserController::class);
        Route::resource('/role', RoleController::class);
        Route::resource('/permission', PermissionController::class);

        Route::get('change-language/{lang}', [BaseController::class, 'changeLanguage'])->name('admin.changeLanguage');
        Route::get('set-channel/{channelSlug}', [BaseController::class, 'channel'])->name('admin.channel');
        Route::get('posts/api', [PostController::class, 'getPosts']);

        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::put('/setting', [SettingController::class, 'update'])->name('setting.update');

        // livewire
        Route::get('/categories', CategoryComponent::class)->name('categories');

        // File
        Route::get('/images', FileComponent::class)->name('images');

        // Article
        Route::get('/articles', ArticleComponent::class)->name('articles');

        // Product
        Route::get('/products', ProductComponent::class)->name('products');

        // Project
        Route::get('/projects', ProjectComponent::class)->name('projects');

        // Supplier
        Route::get('/suppliers', SupplierComponent::class)->name('suppliers');
        Route::get('/supplier-orders', SupplierOrderComponent::class)->name('supplier_orders');

        // Import
        Route::get('/imports', ImportComponent::class)->name('imports');

        // Inventory
        Route::get('/inventories', InventoryComponent::class)->name('inventories');

        // Inventory
        Route::get('/inventory/stocks', InventoryProductComponent::class)->name('inventory_products');

        // Order
        Route::get('/orders', OrderComponent::class)->name('orders');

        // Channel
        Route::get('/channels', ChannelComponent::class)->name('channels');
        Route::get('/channel/{id}', [ChannelController::class, 'setChannel'])->name('set-channel');

        // User
        Route::get('/users', UserComponent::class)->name('users');

        // Usergroup
        Route::get('/usergroups', UserGroupComponent::class)->name('usergroups');

        // Customer
        Route::get('/customers', CustomerComponent::class)->name('customers');
    });
});
