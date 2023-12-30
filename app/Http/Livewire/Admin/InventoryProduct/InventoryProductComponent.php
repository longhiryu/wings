<?php

namespace App\Http\Livewire\Admin\InventoryProduct;

use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Setting;
use App\Models\InventoryProduct;
use App\Http\Livewire\Admin\BaseComponent;
use App\Models\Inventory;
use App\Models\Supplier;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InventoryProductComponent extends BaseComponent
{
    use AuthorizesRequests;

    public $inventory_id;
    public $supplier_id;
    public $low_quantity;

    public function rules()
    {
        return [
            // 'object.id' => 'nullable',
            // 'object.is_active' => 'nullable',
            // 'object.name' => 'required|string|max:255',
            // 'object.address' => 'required',
            // 'object.phone' => 'required',
            // 'object.email' => 'nullable',
            // 'object.note' => 'nullable',
            // 'object.manager_id' => 'nullable',
        ];
    }

    public function render()
    {
        $this->authorize('index', new InventoryProduct());

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = new InventoryProduct();
        $this->type = 'inventory-product';
        $this->view = $this->sysView->livewireAdminIndexView($this->type);
        $this->masterView = $this->sysView::_LIVEWIRE_ADMIN_MASTER_VIEW;
        $this->sectionView = $this->sysView::_LIVEWIRE_ADMIN_SECTION;
        $this->limit = $this->limit ?? getSetting('admin_items_per_page', $this->settings);
        $this->files = $this->getFiles();
        $pars = [
            'searchField' => 'product_name',
            'keyword' => $this->keyword,
            'sortBy' => $this->sortBy,
            'sortType' => $this->sortType,
            'limit' => $this->limit,
        ];

        // filter
        if ($this->inventory_id != null) {
            $pars['inventory_id'] = $this->inventory_id;
        }
        if ($this->supplier_id != null) {
            $pars['supplier_id'] = $this->supplier_id;
        }
        if ($this->low_quantity == 1) {
            $pars['low_quantity'] = 1;
        }

        $data = $this->sysData->getData($this->model, $pars);
        $suppliers = $this->sysData->getData(new Supplier(), ['is_active' => 1]);
        $inventories = $this->sysData->getData(new Inventory(), ['is_active' => 1]);

        $dataToView = [
            'data' => $data,
            'links' => $data->links() ?? null,
            'suppliers' => $suppliers,
            'inventories' => $inventories,
        ];

        return view($this->view, $dataToView)
        ->extends($this->masterView)
        ->section($this->sectionView);
    }
}
