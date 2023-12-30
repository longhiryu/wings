<?php

namespace App\Providers;

use App\View\Composers\RoleComposer;
use Illuminate\Support\Facades\View;
use App\View\Composers\ChannelComposer;
use App\View\Composers\ProductComposer;
use Illuminate\Support\ServiceProvider;
use App\View\Composers\CategoryComposer;
use App\View\Composers\CategoryMenuComposer;
use App\View\Composers\CompanyComposer;
use App\View\Composers\CustomerComposer;
use App\View\Composers\PermissionComposer;
use App\View\Composers\InformationComposer;
use App\View\Composers\OrderComposer;
use App\View\Composers\PartnerComposer;
use App\View\Composers\QuotationComposer;
use App\View\Composers\SettingComposer;
use App\View\Composers\TagComposer;
use App\View\Composers\UserComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer('backend.layouts.order._form', ProductComposer::class);
        View::composer([
            'frontend.*'
        ], CategoryComposer::class);
        View::composer([
            'frontend.*'
        ], CategoryMenuComposer::class);
        View::composer('backend.*', ChannelComposer::class);
        View::composer('backend.layouts.*', RoleComposer::class);
        View::composer('backend.layouts.role.*', PermissionComposer::class);
        // View::composer([
        //     'backend.layouts.quotation.*',
        //     'backend.layouts.order.*',
        //     'backend.layouts.invoice.*'
        // ], CustomerComposer::class);
        // View::composer('backend.layouts.order.*', QuotationComposer::class);
        // View::composer('backend.layouts.customer.*', TagComposer::class);
        // View::composer('livewire.admin.customer._form', TagComposer::class);
        // View::composer([
        //     'backend.layouts.invoice.*',
        //     'backend.layouts.payment.*'
        // ], OrderComposer::class);
        View::composer(['backend.layouts.role.*'], UserComposer::class);
        // View::composer(['backend.layouts.order.*'], PartnerComposer::class);
        // View::composer(['backend.layouts.quotation.*'], CompanyComposer::class);
        View::composer([
            'livewire.admin.import.print',
            'livewire.admin.supplier_order.email_template'
        ], SettingComposer::class);
    }
}
