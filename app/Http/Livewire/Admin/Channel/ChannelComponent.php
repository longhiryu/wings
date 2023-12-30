<?php

namespace App\Http\Livewire\Admin\Channel;

use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Channel;
use App\Models\Setting;
use App\Http\Livewire\Admin\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChannelComponent extends BaseComponent
{
    public $parent = null;

    use AuthorizesRequests;

    protected $rules = [
        'object.id' => 'nullable',
        'object.is_active' => 'nullable',
        'object.is_default' => 'nullable',
        'object.name' => 'required',
        'object.slug' => 'nullable',
    ];

    public function render()
    {
        $this->authorize('index', new Channel());

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = new Channel();
        $this->type = 'channel';
        $this->view = $this->sysView->livewireAdminIndexView($this->type);
        $this->masterView = $this->sysView::_LIVEWIRE_ADMIN_MASTER_VIEW;
        $this->sectionView = $this->sysView::_LIVEWIRE_ADMIN_SECTION;
        $this->limit = $this->limit ?? getSetting('admin_items_per_page', $this->settings);
        // $this->files = $this->getFiles();
        $pars = [
            'searchField' => collect($this->searchFields)->first(),
            'keyword' => $this->keyword,
            'sortBy' => ['id'],
            'sortType' => 'DESC',
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
