<?php

namespace App\Http\Livewire\Admin\Inventory;

use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Setting;
use App\Models\Inventory;
use App\Http\Livewire\Admin\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InventoryComponent extends BaseComponent
{
    use AuthorizesRequests;

    public function rules()
    {
        return [
            'object.id' => 'nullable',
            'object.is_active' => 'nullable',
            'object.name' => 'required|string|max:255',
            'object.address' => 'required',
            'object.phone' => 'required',
            'object.email' => 'nullable',
            'object.note' => 'nullable',
            'object.manager_id' => 'nullable',
        ];
    }

    public function render()
    {
        $this->authorize('index', new Inventory());

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = new Inventory();
        $this->type = 'inventory';
        $this->view = $this->sysView->livewireAdminIndexView($this->type);
        $this->masterView = $this->sysView::_LIVEWIRE_ADMIN_MASTER_VIEW;
        $this->sectionView = $this->sysView::_LIVEWIRE_ADMIN_SECTION;
        $this->limit = $this->limit ?? getSetting('admin_items_per_page', $this->settings);
        $this->files = $this->getFiles();
        $pars = [
            'searchField' => collect($this->searchFields)->first(),
            'keyword' => $this->keyword,
            'sortBy' => $this->sortBy,
            'sortType' => $this->sortType,
            'limit' => $this->limit,
        ];

        $data = $this->sysData->getData($this->model, $pars);

        $dataToView = [
            'data' => $data,
            'links' => $data->links() ?? null,
        ];

        $this->checkPermission();

        return view($this->view, $dataToView)
        ->extends($this->masterView)
        ->section($this->sectionView);
    }
}
